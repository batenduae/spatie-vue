<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
defineOptions({ layout: AuthenticatedLayout });
</script>

<template>
    <Head title="Dashboard" />
    <div class="mx-auto container bg-white dark:bg-boxdark-2 rounded-lg">
        <div class=" text-black dark:text-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">You're in Dashboard now</div>
        </div>
    </div>
</template>
