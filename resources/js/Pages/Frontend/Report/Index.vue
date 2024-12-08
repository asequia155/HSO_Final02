<template>
	<DashboardLayout>
		<head title="Products" />

		<!-- Alert Modal -->
		<div v-if="flashMessage" class="z-[100] bg-teal-100 border-t-4 border-teal-500 text-teal-900 px-6 py-4 shadow-lg rounded-lg fixed top-20 left-95 w-96" role="alert">
			<div class="flex">
				<div class="py-1">
					<svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
						<path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
					</svg>
				</div>
				<div>
					<p class="font-bold">{{ flashMessage }}</p>
					<p class="text-sm">Make sure to check your spelling before adding something.</p>
				</div>
			</div>
		</div>

		<div class="mt-4 mx-4">
			<div class="flex justify-between mb-4">
				<h5>Product Lists</h5>
			</div>

			<div class="bg-white rounded-lg shadow-lg overflow-visible relative">
				<div class="flex items-center p-4 border-b border-neutral-200 justify-between w-full">
					<div class="flex items-center">
						<form class="flex items-center w-full">
							<label for="search" class="sr-only">Search</label>
							<div class="relative w-80">
								<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
									<svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
									</svg>
								</div>
								<input
									type="text"
									id="search"
									v-model="searchQuery"
									placeholder="Search Products..."
									class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
								/>
							</div>
						</form>
					</div>

					<!-- This is me trying to enhance design might delete later -->
					<div class="relative inline-block text-left z-100 ml-4">
						<!-- Toggle Button -->
						<button
							@click="toggleCategoryDropdown"
							id="filterDropdownButton"
							class="ml-auto w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-500 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-blue-400 dark:hover:bg-gray-700"
							type="button"
						>
							<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4 mr-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
								<path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
							</svg>
							Filter
							<svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
								<path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
							</svg>
						</button>

						<!-- Dropdown Menu -->
						<div v-show="isCategoryDropdownOpen1" id="filterDropdown" @click.stop class="absolute z-[100] w-48 mt-2 bg-white rounded-lg shadow-lg dark:bg-gray-700 p-3">
							<h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Choose Category</h6>
							<ul class="space-y-2 text-sm">
								<li v-for="category in props.categories" :key="category.id" @click.stop class="flex items-center">
									<input
										@click.stop
										type="checkbox"
										:id="'category-' + category.id"
										:value="category.id"
										v-model="selectedCategories"
										class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
									/>
									<label @click.stop :for="'category-' + category.id" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
										{{ category.name }} ({{ category.count }})
									</label>
								</li>
							</ul>
						</div>
					</div>
					<div class="ml-auto flex space-x-2">
						<button @click="openAddModal" class="bg-blue-500 text-white rounded px-3 py-1.5 flex items-center">
							<svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
							</svg>
							Add Product
						</button>
					</div>
				</div>

				<div class="overflow-x-auto">
					<div v-if="products.length === 0" class="text-gray-500 text-center py-8">
						No products yet
					</div>
					<table class="min-w-full text-left text-sm font-light text-gray-700">
						<thead class="text-xs text-gray-700 uppercase bg-gray-200 text-left">
							<tr>
								<th scope="col" class="px-6 py-4">Name</th>
								<th scope="col" class="px-6 py-4">Category</th> 
								<th scope="col" class="px-6 py-4">Price</th>
								<th scope="col" class="px-6 py-4">Description</th>
								<th scope="col" class="px-6 py-4">Quantity</th>
								<th scope="col" class="px-6 py-4">Action</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="item in paginatedProducts" :key="item.id" class="border-b border-neutral-200 transition hover:bg-neutral-100">
								<td class="whitespace-nowrap px-6 py-4"></td>
								<td class="whitespace-nowrap px-6 py-4"></td>
								<td class="whitespace-nowrap px-6 py-4"></td>
								<td class="whitespace-nowrap px-6 py-4"></td>
								<td class="whitespace-nowrap px-6 py-4"></td>
								<td class="whitespace-nowrap px-6 py-4"></td>
								<td class="whitespace-nowrap px-6 py-4">
									Print
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- pagination -->
				<div class="flex flex-col md:flex-row justify-between items-center p-4 border-t border-neutral-200 relative z-10">
					<span class="text-sm font-normal text-gray-500">
						Showing <span class="font-semibold">{{ startItem }}</span> - <span class="font-semibold">{{ endItem }}</span> of <span class="font-semibold">{{ totalItems }}</span>
					</span>
					<ul class="inline-flex items-stretch -space-x-px mt-2 md:mt-0">
						<li>
							<button @click="prevPage" :disabled="currentPage === 1" class="px-3 py-1.5 border rounded-l-lg">Prev</button>
						</li>
						<li v-for="page in totalPages" :key="page">
							<button @click="changePage(page)" :class="['px-3 py-1.5 border', currentPage === page ? 'bg-gray-300' : 'bg-white']">{{ page }}</button>
						</li>
						<li>
							<button @click="nextPage" :disabled="currentPage === totalPages" class="px-3 py-1.5 border rounded-r-lg">Next</button>
						</li>
					</ul>
				</div>
			</div>
		</div>

</DashboardLayout>
</template>

<script setup>
	import { ref, watch, computed, defineProps } from 'vue';
	import { Inertia } from '@inertiajs/inertia';
	import DashboardLayout from '@/Layouts/DashboardLayout.vue';
	import { onMounted, onBeforeUnmount } from 'vue';

</script>
