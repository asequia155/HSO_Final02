<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

function goHome() {
    Inertia.get('/');
}

</script>

<template>
    <div
    style="
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        min-height: 100vh;
        padding: 15px;
        background: linear-gradient(-135deg, #ffffff, #d44949);
        width: 100%;
    "
>
<div
  :class="{
    'mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg h-[520px]': $page.component === 'Auth/Login',
    'mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg h-[560]': $page.component !== 'Auth/Login'
  }"
>

            <div @click="goHome" class="cursor-pointer">
                <div class="flex items-center justify-center " style="margin-bottom: -6px;">
                    <img src="../Components/logored.svg" alt="Logo" class="w-18 h-automatic" />
                </div>
            </div>
            <slot />
        </div>
    </div>
</template>
