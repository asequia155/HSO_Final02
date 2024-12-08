<template>
	<div>
		<h2 class="text-xl font-semibold mb-4">Shopping Cart</h2>

		<p v-if="!cartItems.length" class="text-gray-500 text-center">
			Your cart is empty.
		</p>

		<ul v-else class="space-y-4">
			<li v-for="item in cartItems" :key="item.id" class="flex justify-between items-center border-b border-gray-200 py-3">
				<span class="flex-grow text-sm font-medium text-gray-800">{{ item.name }}</span>
				<div class="flex items-center space-x-4">
					<span class="font-semibold text-gray-900">₱{{ Number(item.price).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') }}</span>
					<div class="flex items-center space-x-2">
						<button @click="updateQuantity(item.id, item.quantity - 1)" :disabled="item.quantity <= 1">
							<i class="fas fa-minus-circle"></i>
						</button>
						<span class="text-gray-800 font-medium">{{ item.quantity }}</span>
						<button @click="updateQuantity(item.id, item.quantity + 1)">
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
			<div class="flex justify-between items-center">
				<span class="text-lg font-semibold text-gray-900">Total:</span>
				<span class="text-xl font-bold text-gray-800">₱{{ cartTotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') }}</span>
			</div>
			<div class="mt-4">
				<span class="text-sm text-gray-700">Discount Applied: ₱{{ discountAmountFormatted }}</span>
			</div>
		</div>

		<div class="mt-4">
			<label for="name" class="block text-gray-700 font-medium mb-2">Customer Name</label>
			<input v-model="name" id="name" type="text" class="w-full p-3 border border-gray-300 rounded-lg" required placeholder="Enter customer name" />
			<p v-if="message" class="mt-4 text-red-700">{{ message }}</p>
		</div>

		<div class="mt-4">
			<label class="block text-gray-700 font-medium mb-2">Discount Amount</label>
			<input type="number" v-model.number="discountAmount" placeholder="Enter discount amount" class="w-full p-3 border border-gray-300 rounded-lg" @input="handleDiscountInput" />
		</div>

		<button @click="processPayment" class="bg-red-600 text-sm hover:bg-gray-600 transition duration-300 mt-6 w-full py-3  text-white rounded-lg font-semibold" :disabled="!cartItems.length">
			Process Payment
		</button>
	</div>
</template>

<script setup>
import { ref, computed, defineProps, defineEmits } from 'vue';

// State variables
const name = ref('');
const discountAmount = ref(0);
const message = ref(''); // Added `message` for error handling

// Props from the parent component
const props = defineProps({
	cartItems: Array,
});

// Emit events to the parent component
const emit = defineEmits(['addToCart', 'remove', 'updateQuantity', 'processPayment']);

// Method to remove items from the cart
const removeItem = (itemId) => {
	emit('remove', itemId);
};

// Method to update the quantity of items in the cart
const updateQuantity = (itemId, quantity) => {
	if (quantity >= 0) {
		emit('updateQuantity', itemId, quantity);
	}
};

// Handle discount input
const handleDiscountInput = (event) => {
	discountAmount.value = event.target.value === '' ? 0 : parseFloat(event.target.value);
};

// Computed total after discount
const cartTotal = computed(() => {
	const subtotal = props.cartItems.reduce((total, item) => total + (item.price * item.quantity || 0), 0);
	return Math.max(subtotal - discountAmount.value, 0);
});

// Computed formatted discount amount
const discountAmountFormatted = computed(() => discountAmount.value.toFixed(2));

// Process payment
const processPayment = () => {
	if (!name.value.trim()) {
		message.value = 'Customer name is required.';
		return;
	}

	// Emit payload to the parent
	const payload = {
		customer_name: name.value,
		total: cartTotal.value,
		discount_amount: discountAmount.value,
		cart_items: props.cartItems.map((item) => ({
			product_name: item.name,
			price: item.price,
			quantity: item.quantity,
		})),
	};

	message.value = ''; // Clear any previous error messages
	emit('processPayment', payload);
};
</script>
