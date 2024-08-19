<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {defineOptions, mergeProps, ref} from "vue";
import Form from "@/Components/AdminComponents/Forms/Form.vue";
const props = defineProps({
    roles: {
        type: Object,
        required: true
    },
    permissions: {
        type: Object,
        required: true
    },
})

defineOptions({ layout: AdminLayout });
</script>

<template>
    <Head title="Users/MassAssignPermissionToRole" />
    <div class="max-w-7xl mx-auto py-4">
        <div class="flex justify-between items-baseline">
            <h1 class="text-white">Mass Assign Permission to Role</h1>
            <Link
                :href="route('roles.index')"
                preserve-scroll
                class="px-4 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded-lg"
            >
                Back to Index
            </Link>
        </div>
    </div>

    <div class="mt-4 bg-slate-200 p-4 rounded-lg" v-for="role in roles">
        <div class="">Roles: {{ role.name }}</div>
        <div class="mx-auto p-6 rounded-lg bg-gradient-to-bl from-purple-600 to-amber-200">
            <Form
                :key="role.id"
                :permissions="permissions"
                :role="role"
                preserveScroll: true
            >
            </Form>
        </div>
    </div>
</template>

<style scoped>

</style>
