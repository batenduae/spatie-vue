<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import {usePermissions} from "@/composables/permissions.js";
import {onMounted, onUpdated} from "vue";

const {hasPermission, hasRole, showFlash} = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
defineOptions({layout: AuthenticatedLayout});
</script>

<template>
    <Head title="Dashboard"/>
    <div class="mx-auto text-center container bg-white dark:bg-boxdark-2 text-black dark:text-white rounded-lg">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">You're in Dashboard now</div>
        </div>
    </div>
</template>
