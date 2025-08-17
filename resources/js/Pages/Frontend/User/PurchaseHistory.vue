<template>
    <DashboardLayout>
        <div class="relative mt-4 overflow-visible bg-white rounded-lg shadow-lg" >

    <!-- Date Filters -->
<div class="flex items-center justify-between px-4 py-2 border-b border-gray-200">
  <!-- Left Section: Date Filters -->
  <div class="flex items-center space-x-4">
    <div class="flex items-center space-x-2">
      <label for="startDate" class="text-sm font-medium text-gray-700">Start:</label>
      <input
        type="date"
        id="startDate"
        v-model="filters.startDate"
        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
      />
    </div>
    <div class="flex items-center space-x-2">
      <label for="endDate" class="text-sm font-medium text-gray-700">End:</label>
      <input
        type="date"
        id="endDate"
        v-model="filters.endDate"
        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
      />
    </div>
  </div>


</div>




    <div class="overflow-x-auto">
      <!-- Display message when no purchased items are available -->
      <div v-if="filteredPurchasedItems.length === 0" class="p-4 text-center">
        <p class="text-gray-500">No purchased items available.</p>
      </div>

      <!-- Purchased Items Table -->
      <table v-else class="min-w-full text-sm font-light text-left text-gray-700">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
          <tr>
            <th scope="col" class="px-6 py-4">Date</th>
            <th scope="col" class="px-6 py-4">Item</th>
            <th scope="col" class="px-6 py-4">Quantity</th>
            <th scope="col" class="px-6 py-4">Price</th>
            <th scope="col" class="px-6 py-4">Total</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="transaction in paginatedPurchasedItems" :key="transaction.id">
            <tr class="border-b border-neutral-200 hover:bg-neutral-100">
              <td class="px-6 py-3 whitespace-nowrap" :rowspan="transaction.items.length">
                {{ new Date(transaction.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) }}
              </td>
              <td class="px-6 py-3 whitespace-nowrap">{{ transaction.items[0].product.name }}</td>
              <td class="px-6 py-3 whitespace-nowrap">{{ transaction.items[0].quantity }}</td>
              <td class="px-6 py-3 whitespace-nowrap">₱{{ Number(transaction.items[0].price).toFixed(2) }}</td>
              <td class="px-6 py-3 whitespace-nowrap">₱{{ (Number(transaction.items[0].price) * transaction.items[0].quantity).toFixed(2) }}</td>
            </tr>
            <tr v-for="(item, index) in transaction.items.slice(1)" :key="index" class="border-b border-neutral-200 hover:bg-neutral-100">
              <td class="px-6 py-3 whitespace-nowrap">{{ item.product.name }}</td>
              <td class="px-6 py-3 whitespace-nowrap">{{ item.quantity }}</td>
              <td class="px-6 py-3 whitespace-nowrap">₱{{ Number(item.price).toFixed(2) }}</td>
              <td class="px-6 py-3 whitespace-nowrap">₱{{ (Number(item.price) * item.quantity).toFixed(2) }}</td>
            </tr>
          </template>
        </tbody>
      </table>
        <!-- Pagination Section -->
        <div class="relative z-10 flex flex-col items-center justify-between p-4 border-t md:flex-row border-neutral-200">
        <span class="text-sm font-normal text-gray-500">
            Showing <span class="font-semibold">{{ startPurchasedItem }}</span> - <span class="font-semibold">{{ endPurchasedItem }}</span> of <span class="font-semibold">{{ totalPurchasedItems }}</span>
            </span>
            <ul class="inline-flex items-stretch mt-2 -space-x-px md:mt-0">
                <li>
                <button @click="prevPurchasedItemsPage" :disabled="currentPurchasedItemsPage === 1" class="px-3 py-1.5 border rounded-l-lg">Prev</button>
                </li>
                <li v-for="page in totalPurchasedItemsPages" :key="page">
                <button @click="changePurchasedItemsPage(page)" :class="['px-3 py-1.5 border', currentPurchasedItemsPage === page ? 'bg-gray-300' : 'bg-white']">
                    {{ page }}
                </button>
                </li>
                <li>
                <button @click="nextPurchasedItemsPage" :disabled="currentPurchasedItemsPage === totalPurchasedItemsPages" class="px-3 py-1.5 border rounded-r-lg">Next</button>
                </li>
            </ul>
        </div>
    </div>
  </div>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Link } from "@inertiajs/inertia-vue3";
import { ref, defineProps, computed } from 'vue';
import { onMounted, onBeforeUnmount, watch } from 'vue';

import { Inertia } from '@inertiajs/inertia';
import route from 'ziggy-js';

import { jsPDF } from "jspdf";


    const props = defineProps({
        patient: Object,
        flash: Object,
        notifications: {
            type: Array,
            default: () => [], // Default to an empty array
        },
    });


//For purchased item table
    const patientData = computed(() => props.patient);
    // Pagination variables for purchased items
const currentPurchasedItemsPage = ref(1);
const itemsPerPurchasedItemsPage = ref(5);
// Compute total purchased items
const totalPurchasedItems = computed(() => patientData.value.transactions.length);

// Compute start and end indices for the current page
const startPurchasedItem = computed(() => (currentPurchasedItemsPage.value - 1) * itemsPerPurchasedItemsPage.value + 1);
const endPurchasedItem = computed(() => Math.min(currentPurchasedItemsPage.value * itemsPerPurchasedItemsPage.value, totalPurchasedItems.value));

// Compute paginated purchased items
const paginatedPurchasedItems = computed(() => {
  const start = (currentPurchasedItemsPage.value - 1) * itemsPerPurchasedItemsPage.value;
  const end = start + itemsPerPurchasedItemsPage.value;
  return patientData.value.transactions.slice(start, end);
});

// Calculate total pages for purchased items
const totalPurchasedItemsPages = computed(() => {
  return Math.ceil(patientData.value.transactions.length / itemsPerPurchasedItemsPage.value);
});

// Pagination navigation for purchased items
const prevPurchasedItemsPage = () => {
  if (currentPurchasedItemsPage.value > 1) currentPurchasedItemsPage.value--;
};

const nextPurchasedItemsPage = () => {
  if (currentPurchasedItemsPage.value < totalPurchasedItemsPages.value) currentPurchasedItemsPage.value++;
};
//end of purchased item table

    // State for dropdown visibility and notifications list
    const notifDropdownOpen = ref(false);

    // Toggle the dropdown visibility
    const toggleNotifDropdown = () => {
    notifDropdownOpen.value = !notifDropdownOpen.value;
    };

    const message = ref(props.flash?.message || '');
    const messageType = ref(props.flash?.message_type || 'info');
    console.log(message);
    console.log(messageType);
    const dropdownOpen = ref(null);
    const editModal = ref(false);
    const selectedPatient = ref(null);
    const deleteModal = ref(false);
    const editPatientModal = ref(false);
    const selectedPatients = ref(null);
    const selectedPrescriptionId = ref(null);
    const prescriptions = ref(props.patient?.prescriptions || []); // Safely access `patient.prescriptions`
    const currentPage = ref(1);
    const itemsPerPage = ref(5);

    const totalItems = computed(() => filteredPrescriptions.value.length);
    const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage.value));

    const startItem = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1);
    const endItem = computed(() => Math.min(currentPage.value * itemsPerPage.value, totalItems.value));

    const paginatedPrescriptions = computed(() =>
    prescriptions.value.slice(startItem.value - 1, endItem.value)
    );

    const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
    };

    const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
    };

    const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
    };

    const openDeleteModal = (prescriptionId) => {
    selectedPrescriptionId.value = prescriptionId;
    deleteModal.value = true;
    };

    const closeDeleteModal = () => {
    deleteModal.value = false;
    selectedPrescriptionId.value = null;
    };

    const filters = ref({
        startDate: '',
        endDate: ''
    });

const filteredPrescriptions = computed(() => {
  const start = filters.value.startDate ? new Date(`${filters.value.startDate}T00:00:00`) : null;
  const end = filters.value.endDate ? new Date(`${filters.value.endDate}T23:59:59`) : null;
  return patientData.value.prescriptions.filter((prescription) => {
    const date = new Date(prescription.created_at);
    return (!start || date >= start) && (!end || date <= end);
  });
});

const filteredPurchasedItems = computed(() => {
  const start = filters.value.startDate ? new Date(`${filters.value.startDate}T00:00:00`) : null;
  const end = filters.value.endDate ? new Date(`${filters.value.endDate}T23:59:59`) : null;
  return patientData.value.transactions.filter((transaction) => {
    const date = new Date(transaction.created_at);
    return (!start || date >= start) && (!end || date <= end);
  });
});

    const handleDelete = ({ prescriptionId, patientId }) => {
    Inertia.delete(`/patients/${patientId}/prescriptions/${prescriptionId}`, {
        onSuccess: () => {
        alert('Prescription deleted successfully!');
        deleteModal.value = false; // Close the modal
        },
        onError: (errors) => {
        console.error('Error deleting prescription:', errors);
        alert('Failed to delete the prescription.');
        },
    });
    };


    const handleEdit = (updatedData) => {
    console.log('Edited Patient Data:', updatedData);

    Inertia.put(`/patients/${props.patient.id}/prescriptions/${updatedData.id}`, updatedData, {
        onSuccess: () => {
        alert('Prescription updated successfully!');
        editModal.value = false; // Close the modal
        },
        onError: (errors) => {
        console.error('Error updating prescription:', errors);
        alert('Failed to update the prescription.');
        },
    });
    };


    const closeEditModal = () => {
        editModal.value = false;
    }

    const toggleDropdown = (id) => {
        dropdownOpen.value = dropdownOpen.value === id ? null : id; // Toggle dropdown based on id
    };

    const openModal = (type, item) => {
        closeDropdown(); // Close the dropdown whenever a modal is opened

        if (type === 'edit') {
            selectedPatient.value = item; // Set the selected patient
            editModal.value = true;
        }
    };

    const closeDropdown = () => {
        dropdownOpen.value = null;
    };


    onMounted(() => {
        setTimeout(() => {
            message.value = ''; // Clear the message after 3 seconds
            messageType.value = '';
        }, 3000);
    });

    const addModal = ref(false);
    const openAddModal = () => {
        addModal.value = true;
    };

    const closeAddModal = () => {
        addModal.value = false;
    };
        // Calculate Age Function
    const calculateAge = (dateOfBirth) => {
        if (!dateOfBirth) return null;
            const birthDate = new Date(dateOfBirth);
            const ageDiff = Date.now() - birthDate.getTime();
            const ageDate = new Date(ageDiff);
            return Math.abs(ageDate.getUTCFullYear() - 1970);
    };


    const addRecord = (data) => {
    Inertia.post(`/patients/${props.patient.id}/prescriptions`, data, {
        preserveScroll: true,
        onSuccess: (response) => {
            // Update the prescriptions with the latest data
            prescriptions.value = response.props.patient.prescriptions;

            // Find the newly added prescription
            const newPrescription = prescriptions.value.find(
                (prescription) => prescription.id === response.props.newPrescriptionId
            );

            console.log("New Prescription:", newPrescription); // Debugging

            // Generate and print the PDF
            if (newPrescription) {
                generateAndPrintPDF(newPrescription);
            } else {
                alert("New prescription not found.");
            }

            // Close the Add Modal
            closeAddModal();
        },
        onError: (errors) => {
            console.error("Error adding prescription:", errors);
            alert("Failed to add the prescription. Please try again.");
        },
    });
};



    const opeEditPatientModal = () => {
        editPatientModal.value = true;
        selectedPatients.value = props.patient;
        }

        const closeModal = () => {
            editPatientModal.value = false;
            };

            const updatePatient = (updatedPatient) => {
            console.log('Updated patient data:', updatedPatient); // Check updated patient data
            Inertia.put(route('patients.update', updatedPatient.id), updatedPatient, {
                onSuccess: () => {
                flashMessage.value = 'Patient updated successfully!';
                close();
                },
                onError: (errors) => {
                console.error('Error updating patient:', errors);
                flashMessage.value = 'Error updating patient. Please try again.';
                },
            });
            };

    // Automatically dismiss the alert after 3 seconds
watch([message, messageType], () => {
    if (message.value) {
        setTimeout(() => {
            message.value = '';
            messageType.value = '';
        }, 3000);
    }
});

const generateAndPrintPDF = (prescription) => {

// Initialize jsPDF in A5 Landscape
const doc = new jsPDF({
orientation: "landscape",
unit: "mm",
format: "A5",
});

// Define colors and styles
const headerBgColor = "#FF0000"; // Red
const headerTextColor = "#FFFFFF"; // White
const footerBgColor = "#FF0000"; // Red
const footerTextColor = "#FFFFFF"; // White



//Add logo
const logo = new Image();
logo.src = '/images/logo.png';
doc.addImage(logo, 'PNG', 30, 3, 25, 20);

doc.setFontSize(18);
doc.setFont('Helvetica', 'bold');
doc.setTextColor('#e74c3c');
doc.text("Hollywood Spectacles Optical", 105, 10, { align: "center" });

doc.setFontSize(12);
doc.setFont('Roboto', 'normal');
doc.setTextColor('#000');
doc.text("Aguinaldo Street, Iligan City", 105, 15, { align: "center" });
doc.text("Contact No: 091277747297", 105, 20, { align: "center" });

doc.setDrawColor(231, 76, 60);
doc.line(10, 25, 200, 25);

//Add Patient Name
doc.setFontSize(14);
doc.setTextColor("black");
doc.text(`Name: ${props.patient.first_name} ${props.patient.last_name}`, 20, 40); // Name on the left
doc.text(`Date: ${new Date(prescription.created_at).toLocaleDateString()}`, 150, 37); // Date below the name

// Rx Symbol - Bungig Style
doc.setFontSize(50);
doc.setFont('Roboto', 'normal');
doc.setTextColor("#FF0000"); // Red color for Rx symbol
doc.text("Rx", 15, 65, { align: "left" }); // Place Rx below name, left-aligned


// Table Head
const tableHead = [["OD", "OS", "ADD", "PD", "Remarks"]];

// Table Body
const tableBody = [[
prescription.od || "",
prescription.os || "",
prescription.add || "",
prescription.pd || "",
prescription.remarks || ""
]];

// Generate the table using autoTable
// Generate the table using autoTable
doc.autoTable({
startY: 73, // Starting Y position
head: tableHead, // Header row
body: tableBody, // Data rows
theme: "grid", // Table theme (grid for borders)
styles: {
    fontSize: 12, // General font size
    halign: "center", // Horizontal alignment for all cells
    overflow: 'linebreak', // Wrap text if it exceeds cell width
},
headStyles: {
    fillColor: [255, 0, 0], // Red background for header
    textColor: [255, 255, 255], // White text for header
    fontStyle: "bold", // Bold text for header
},
bodyStyles: {
    cellPadding: 4, // Padding for table cells
},
columnStyles: {
    4: { // Specific column (index 4: Remarks)
        cellWidth: 'wrap', // Enable text wrapping for Remarks
        halign: "left", // Align text to the left for Remarks
    },
},
});



const tableEndY = doc.lastAutoTable.finalY; // Get the Y position where the table ends
doc.setFontSize(12);
doc.text("Prescribed by: Dr. Dializa Remedios", 125, tableEndY + 23); // Add text below the table on the left side
doc.text("Licensed No.:______________________", 125, tableEndY + 28);

// // Add Footer
// const pageHeight = doc.internal.pageSize.height;
//     doc.setFontSize(10);
//     doc.setFont('Helvetica', 'normal');
//     doc.setTextColor('#000');
//     doc.text("Generated by Hollywood Spectacles Optical", 105, pageHeight - 10, { align: "center" });


// 	//Add a border line
// 	doc.setDrawColor(231, 76, 60);
// 	doc.line(15, pageHeight - 15, 195, pageHeight - 15);


    // Output the PDF as a Blob
    const pdfBlob = doc.output("blob");

    dropdownOpen.value = false;

    // Create a hidden iframe
    const iframe = document.createElement("iframe");
    iframe.style.position = "absolute";
    iframe.style.width = "1px";
    iframe.style.height = "1px";
    iframe.style.top = "-9999px"; // Hide the iframe
    document.body.appendChild(iframe);

    // Use the Blob URL as the iframe source
    const pdfURL = URL.createObjectURL(pdfBlob);
    iframe.src = pdfURL;

    // Trigger printing only when the iframe is fully loaded
    iframe.onload = () => {
        try {
            iframe.contentWindow.focus(); // Ensure the iframe content is focused
            iframe.contentWindow.print(); // Trigger the print dialog

            // Keep the iframe in the DOM until the user interacts with the print dialog
            console.log("Print dialog triggered. Waiting for user interaction...");
        } catch (error) {
            console.error("Error triggering print dialog:", error);
        }
    };

    // Add cleanup on unload to ensure it doesn't interfere with the print dialog
    window.addEventListener("afterprint", () => {
        console.log("Print completed. Cleaning up resources.");
        document.body.removeChild(iframe);
        URL.revokeObjectURL(pdfURL);
    });
};


</script>

<style scoped>
    /* Fade transition for the alert */
    .alert-fade-enter-active, .alert-fade-leave-active {
    transition: opacity 0.5s ease;
    }

    .alert-fade-enter, .alert-fade-leave-to /* .alert-fade-leave-active in <2.1.8 */ {
    opacity: 0;
    }
</style>
