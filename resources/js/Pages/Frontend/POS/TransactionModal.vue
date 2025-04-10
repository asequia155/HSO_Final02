<template>
    <div v-if="isOpen && transaction" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
      <div class="relative w-full max-w-3xl p-6 bg-white rounded-lg shadow-lg modal-content">
        <button class="absolute text-xl text-gray-600 top-2 right-2" @click="closeModal">
          <i class="fa fa-times"></i>
        </button>

        <!-- Printable Content -->
        <div id="printable-content">
          <!-- Invoice Header -->
          <div class="flex justify-between pb-4 mb-6 border-b border-red-500">
            <div>
              <h2 class="text-3xl font-bold text-red-600">Invoice {{ invoiceNumber }}</h2>
              <p class="text-sm text-gray-500">Issued: {{ currentDate }}</p>
              <p class="text-sm text-gray-500">Proccessed by: {{ $page.props.auth.user.name }}</p>
            </div>
            <div class="text-right">
              <h3 class="text-lg font-semibold text-red-600">{{ companyName }}</h3>
              <p class="text-sm text-gray-500">Address: {{ companyAddress }}</p>
              <p class="text-sm text-gray-500">Phone: {{ companyPhone }}</p>
              <p class="text-sm text-gray-500">Email: {{ companyEmail }}</p>
            </div>
          </div>

          <!-- Customer Info -->
          <div class="py-4 border-b border-red-500">
            <h4 class="text-lg font-semibold text-red-600">Bill To:</h4>
            <p class="text-sm text-gray-600">{{ transaction.customer_name }}</p>
          </div>

          <!-- Invoice Table -->
          <table v-if="transaction.transaction_items && transaction.transaction_items.length > 0" class="w-full mt-4 text-sm text-left text-gray-600">
            <thead>
              <tr class="text-black bg-red-600">
                <th class="px-4 py-2 border border-red-600">Item</th>
                <th class="px-4 py-2 border border-red-600">Quantity</th>
                <th class="px-4 py-2 border border-red-600">Price</th>
                <th class="px-4 py-2 border border-red-600">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in transaction.transaction_items" :key="index" class="odd:bg-gray-100 even:bg-white">
                <td class="px-4 py-2 border border-red-600">{{ getProductName(item.product_id) }}</td>
                <td class="px-4 py-2 text-center border border-red-600">{{ item.userQuantity }}</td>
                <td class="px-4 py-2 text-right border border-red-600">₱ {{ (Number(item.price)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') }}</td>
                <td class="px-4 py-2 text-right border border-red-600">₱ {{ (Number(item.subtotal)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') }}</td>
              </tr>
            </tbody>
          </table>

          <!-- Invoice Total -->
          <div class="flex justify-end mt-4 font-semibold text-gray-700">
            <div class="w-1/2 text-right">
              <p class="text-lg">Subtotal: ₱ {{ formatPrice(transaction.total_amount) }}</p>
              <p class="text-lg">VAT (12%): + ₱ {{ formatPrice(vatAmount) }}</p>
              <p class="text-lg">Discount: - ₱ {{ formatPrice(transaction.discount_amount) }}</p>
              <hr class="my-2 border-gray-300">
              <p class="text-xl text-red-600">Total: ₱ {{ formatPrice(totalWithVAT) }}</p>
            </div>
          </div>
        </div>

        <!-- Button Row -->
        <div class="flex justify-between mt-6">
          <button @click="closeModal" class="px-6 py-2 text-gray-700 bg-gray-300 rounded-md hover:bg-gray-400">
            Cancel
          </button>
          <button @click="generateAndPrintPDF" class="px-6 py-2 text-white bg-red-600 rounded-md hover:bg-gray-600">
            Confirm & Print
          </button>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { defineProps, defineEmits, computed } from 'vue';

  const props = defineProps({
    isOpen: Boolean, // Controls modal visibility
    transaction: {
      type: Object,
      required: true,
    },
    products: {
      type: Array,
      required: true,
    },
  });

  const emit = defineEmits();
  console.log(props.transaction);


  const invoiceNumber = ''; // Invoice identifier
  const currentDate = new Date().toLocaleDateString('en-US', {
    month: 'long',
    day: 'numeric',
    year: 'numeric',
  });
  const companyName = 'Hollywood Spectacles';
  const companyAddress = 'Gen. Aguinaldo St., Iligan City';
  const companyPhone = '0912 774 7297';
  const companyEmail = 'hollywoodspectaclesiligan@domain.com';

  const vatRate = 0.12;

  const vatAmount = computed(() => props.transaction.total_amount * vatRate);

  const totalWithVAT = computed(() => {
    return props.transaction.total_amount + vatAmount.value - props.transaction.discount_amount;
  });

  function closeModal() {
    emit('close'); // Explicitly close the modal
  }

  function generateAndPrintPDF() {
    let isPrintCompleted = false; // Track if printing is successfully completed

    // Function to handle the `afterprint` event
    const handleAfterPrint = () => {
      // Clean up the listener after firing
      window.removeEventListener('afterprint', handleAfterPrint);

      if (isPrintCompleted) {
        // If printing is completed, process the payment
        emit('confirm', {
          customer_name: props.transaction.customer_name,
          total_amount: totalWithVAT.value,
          discount_amount: props.transaction.discount_amount,
          patient_id: props.transaction.patient_id,
          tax_amount: vatAmount.value,
          transaction_items: props.transaction.transaction_items.map((item) => ({
            product_id: item.product_id,
            quantity: item.userQuantity,
            price: item.price,
            subtotal: item.subtotal,
          })),
        });

        // Close the modal and return to the POS
        closeModal();
        console.log('Payment was processed and printing completed.');
      } else {
        // If printing was canceled, reset the modal
        console.log('Printing was canceled. Returning to the invoice modal.');
      }
    };

    // Attach the `afterprint` event listener
    window.addEventListener('afterprint', handleAfterPrint);

    // Open the print dialog
    isPrintCompleted = true; // Assume printing will complete successfully
    window.print();

    // Delay detection to check if printing was canceled
    setTimeout(() => {
      if (document.hasFocus()) {
        // If the window regains focus quickly, printing was canceled
        isPrintCompleted = false; // Reset the flag to indicate cancellation
      }
    }, 500);
  }





  function getProductName(productId) {
    const product = props.products.find((p) => p.id === productId);
    return product ? product.name : 'Unknown Product';
  }

  function formatPrice(value) {
    return value.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  }
  </script>


  <style>
  @media print {
    @page {
      size: A5;
      margin: 0;
    }

    body, html {
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
    }

    body * {
      visibility: hidden;
    }

    #printable-content,
    #printable-content * {
      visibility: visible;
    }

    #printable-content {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: auto; /* Set height to auto */
      background: white;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Ensure proper spacing inside table */
    table {
      width: 100%;
      border-collapse: collapse;
    }

    table th,
    table td {
      border: 1px solid #e3342f;
      padding: 8px;
    }

    table th {
      background-color: #e3342f;
      color: white;
    }

    table td {
      text-align: left;
    }
  }


  </style>


