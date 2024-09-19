<script setup>
import { Head } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/AdminComponents/Cards/Card.vue";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
defineOptions({ layout: SpatieAdminLayout });
</script>

<template>
    <Head title="Admin" ></Head>
    <div class="py-6">
        <div class="bg-slate-200 text-black dark:bg-black dark:text-white/70 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 text-center">Admin Page</div>
        </div>
    </div>
    <Card type="green">
        <div class="min-h-96">
            This is Admin Page. Here You are welcome. Explore the cool feature of this admin panel.
            Best of luck.
        </div>
    </Card>
</template>
