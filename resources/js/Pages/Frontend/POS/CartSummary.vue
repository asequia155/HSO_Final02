<template>
	<div>
		<h2 class="mb-2 text-xl font-semibold">Shopping Cart</h2>

		<p v-if="!cartItems.length" class="text-center text-gray-500">
			Your cart is empty.
		</p>

		<ul v-else class="space-y-4">
			<li v-for="item in cartItems" :key="item.id" class="flex items-center justify-between py-3 border-b border-gray-200">
				<span class="flex-grow text-sm font-medium text-gray-800">{{ item.name }}</span>
				<div class="flex items-center space-x-4">
					<span class="font-semibold text-gray-900">₱{{ Number(item.price).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') }}</span>
					<div class="flex items-center space-x-2">
						<button
						 class="text-gray-500 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed"
						@click="updateQuantity(item.id, item.userQuantity - 1)"
						:disabled="item.quantity <= 1">
							<i class="fas fa-minus-circle"></i>
						</button>
						<input
  type="number"
  v-model.number="item.userQuantity"
  class="w-12 h-8 font-medium text-center text-gray-800 border border-gray-300 rounded-md"
  @input="handleInput(item)"
  @blur="updateQuantity(item.id, item.userQuantity)"
/>

<!-- Handle temporary input -->
<!-- Validate when focus is lost -->
						<button  @click="updateQuantity(item.id, item.userQuantity + 1)"
						:disabled="item.userQuantity >= item.quantity"
						class="text-gray-500 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed"
					>
						<i class="fas fa-plus-circle"></i>
						</button>
					</div>
					<button @click="removeItem(item.id)" class="text-red-500 hover:text-red-700">
						<i class="fas fa-trash"></i>
					</button>
				</div>
			</li>
		</ul>

		<div class="mt-4">
			<div class="flex justify-between">
				<span class="text-sm text-gray-700">Subtotal:</span>
				<span class="text-sm text-gray-700">₱{{ cartTotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') }}</span>
			</div>
			<div class="flex justify-between">
				<span class="text-sm text-gray-700">Tax (Vat12%):</span>
				<span class="text-sm text-gray-700">₱{{ vatAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') }}</span>
			</div>
			<div class="flex justify-between border-b border-gray-200">
				<span class="text-sm text-gray-700">Discount:</span>
				<span class="text-sm text-gray-700">₱{{ discountAmountFormatted }}</span>
			</div>
			<div class="flex items-center justify-between">
				<span class="text-lg font-semibold text-gray-900">Total:</span>
				<span class="text-xl font-bold text-gray-800">₱{{ total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') }}</span>
			</div>
		</div>

		<div class="mt-2">
			<label class="block font-medium text-gray-700">Customer Type</label>
			<div class="flex items-center space-x-4">
				<label class="flex items-center">
					<input type="radio" v-model="isPatient" :value="true" class="mr-2">
					Patient
				</label>
				<label class="flex items-center">
					<input type="radio" v-model="isPatient" :value="false" class="mr-2">
					Non-Patient
				</label>
			</div>
		</div>

		<div v-if="isPatient" class="mt-2">
			<label for="patientSearch" class="block font-medium text-gray-700">Search Patient</label>
			<input
				v-model="patientSearch"
				id="patientSearch"
				type="text"
				class="w-full p-2 border border-gray-300 rounded-md"
				placeholder="Search patient by name"
				@input="searchPatient"
                autocomplete="off"
			/>
			<p v-if="searchMessage" class="mt-2 text-sm text-red-700">{{ searchMessage }}</p>
			<ul v-if="searchResults.length" class="mt-2 border border-gray-300 rounded-md">
				<li v-for="patient in searchResults" :key="patient.id" class="p-2 cursor-pointer hover:bg-gray-100" @click="selectPatient(patient)">
					{{ patient.name }}
				</li>
			</ul>
		</div>

		<div v-else class="mt-2">
			<label for="name" class="block font-medium text-gray-700">Customer Name</label>
			<input
				v-model="name"
				id="name"
				type="text"
				class="w-full p-2 border border-gray-300 rounded-md"
				required
				placeholder="Customer name"
			/>
			<p v-if="message" class="mt-2 text-sm text-red-700">{{ message }}</p>
		</div>

		<div class="mt-2">
			<label class="block font-medium text-gray-700">Discount Amount</label>
			<input
				type="number"
				v-model.number="discountAmount"
				placeholder="Discount"
				class="w-full p-2 border border-gray-300 rounded-md"
				@input="handleDiscountInput"
			/>
		</div>

		<div class="mt-2">
			<label for="customerBill" class="block font-medium text-gray-700">Cash</label>
			<input
				type="number"
				id="customerBill"
				v-model.number="customerBill"
				class="w-full p-2 border border-gray-300 rounded-md"
				placeholder="Cash amount"
			/>
			<p v-if="cashMessage" class="mt-2 text-sm text-red-700">{{ cashMessage }}</p>
		</div>

		<div class="mt-2">
			<div class="flex items-center justify-between">
				<span class="text-lg font-semibold text-gray-900">Change:</span>
				<span class="text-xl font-bold text-gray-800">₱{{ Math.max(0, (customerBill - total)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') }}</span>
			</div>
		</div>

		<button @click="processPayment" class="w-full py-3 mt-6 text-sm font-semibold text-white transition duration-300 bg-red-600 rounded-lg hover:bg-gray-600" :disabled="!cartItems.length">
			Process Payment
		</button>
	</div>
</template>

<script setup>
import { ref, computed, defineProps, defineEmits } from 'vue';
import axios from 'axios'; // Ensure axios is installed and imported

// State variables
const name = ref('');
const isPatient = ref(false);
const patientSearch = ref('');
const searchResults = ref([]);
const selectedPatient = ref(null);
const searchMessage = ref('');
const cashMessage = ref('');
const discountAmount = ref(0);
const message = ref('');
const vatRate = 0.12;
const customerBill = ref(0);

// Props from the parent component
const props = defineProps({
	cartItems: Array,
});

const vatAmount = computed(() => {
  return cartTotal.value * vatRate;
});

// Emit events to the parent component
const emit = defineEmits(['addToCart', 'remove', 'updateQuantity', 'processPayment']);

// Method to remove items from the cart
const removeItem = (itemId) => {
	emit('remove', itemId);
};
console.log(props.cartItems);
// Method to update the quantity of items in the cart
const updateQuantity = (itemId, userQuantity) => {
  // Find the item in props.cartItems
  const item = props.cartItems.find((i) => i.id === itemId);
  if (item) {
    if (userQuantity >= 1 && userQuantity <= item.quantity) {
      // Emit the updated quantity to the parent
      emit('updateQuantity', itemId, userQuantity);
    } else if (userQuantity > item.quantity) {
      // Include the product name in the alert message
      alert(`Cannot exceed available stock for ${item.name} (${item.quantity}).`);
      // Reset to stock limit by emitting the change
      emit('updateQuantity', itemId, item.quantity);
	} else if (item.userQuantity < 1) {
		alert('Quantity cannot be less than 1.');
		item.userQuantity = 1; // Reset to minimum value
	}else {
      // Reset to minimum value by emitting the change
      emit('updateQuantity', itemId, 1);
    }
  }
};

const handleInput = (item) => {
  // Allow user to type any number temporarily
  item.userQuantity = Math.max(0, item.userQuantity); // Prevent negative numbers
};


// Handle discount input
const handleDiscountInput = (event) => {
	discountAmount.value = event.target.value === '' ? 0 : parseFloat(event.target.value);
};

// total after tax and discount
const total = computed(() => {
	const subtotal = props.cartItems.reduce((total, item) => total + (item.price * item.userQuantity || 0), 0);
	return Math.max((subtotal + vatAmount.value) - discountAmount.value, 0);
});

// Computed total after discount
const cartTotal = computed(() => {
	const subtotal = props.cartItems.reduce((total, item) => total + (item.price * item.userQuantity || 0), 0);
	return Math.max(subtotal, 0);
});

// Computed formatted discount amount
const discountAmountFormatted = computed(() => discountAmount.value.toFixed(2));

// Method to search for patients
const searchPatient = async () => {
    if (!patientSearch.value.trim()) {
        searchMessage.value = 'Patient search cannot be empty.';
        return;
    }

    try {
        searchMessage.value = ''; // Clear any previous error message
        const response = await axios.get('/api/patients', {
            params: { name: patientSearch.value },
        });
        searchResults.value = response.data;
    } catch (error) {
        console.error('Error fetching patients:', error);
        searchMessage.value = 'An error occurred while searching for patients.';
    }
};

// Select a patient from search results
const selectPatient = (patient) => {
    selectedPatient.value = patient; // Set the selected patient
    name.value = patient.name; // Update the name field
    patientSearch.value = patient.name; // Update the search input
    searchResults.value = []; // Clear search results dropdown
};



// Process payment
const processPayment = () => {
    // Validate that a patient is selected if the customer type is patient
    if (isPatient.value && (!patientSearch.value.trim() || !selectedPatient.value)) {
        searchMessage.value = 'Please search and select a patient.';
        return;
    }

    // Validate customer name
    if (!name.value.trim()) {
        message.value = 'Customer name is required.';
        return;
    }

    // Validate sufficient cash
    if (customerBill.value < total.value) {
        cashMessage.value = `Insufficient cash. Total amount is ₱${total.value.toFixed(2)}.`;
        return;
    }

    // Prepare the transaction payload
    const transactionPayload = {
        customer_name: name.value,
        total_amount: cartTotal.value,
        discount_amount: discountAmount.value,
        tax_amount: vatAmount.value,
        transaction_items: props.cartItems.map((item) => ({
            product_id: item.id,
            quantity: item.quantity,
            price: item.price,
            subtotal: item.userQuantity * item.price,
			userQuantity: item.userQuantity,
        })),
        patient_id: selectedPatient.value ? selectedPatient.value.id : null, // Include patient ID if available
    };

    // Clear error messages
    searchMessage.value = '';
    message.value = '';
    cashMessage.value = '';

    // Emit the transaction payload to the parent
    emit('processPayment', transactionPayload);
};

</script>
<style scoped>
/* Remove arrows for Chrome, Edge, Safari */
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Remove arrows for Firefox */
input[type="number"] {
  -moz-appearance: textfield;
}
</style>
