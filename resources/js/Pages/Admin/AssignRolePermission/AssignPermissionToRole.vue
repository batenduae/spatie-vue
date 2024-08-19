<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { defineOptions, ref } from "vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
const props = defineProps({
    role: {
        type: Object,
        required: true,
    },
    permissions: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    permissions: ref(props.role.assignedPermissions),
});
defineOptions({ layout: AdminLayout });
</script>

<template>
    <Head title="Users/AssignPermissionToRole" />
    <div class="mx-auto py-4">
        <div class="flex justify-between items-baseline">
            <h1 class="text-white">
                Assign Permission to Role:
                <span class="font-bold text-red-600">{{ role.name }}</span>
            </h1>
            <Link
                :href="route('roles.index')"
                preserve-scroll
                class="px-4 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded-lg"
            >
                Back to Index
            </Link>
        </div>
    </div>

    <div class="mt-4 bg-slate-200 p-4 rounded-lg">
        <div class="mt-4">Permissions:</div>
        <div
            class="mx-auto p-6 rounded-lg bg-gradient-to-bl from-purple-600 to-amber-200"
        >
            <form
                @submit.prevent="
                    form.put(route('roles.assignPermissionsToRole', role.id))
                "
            >
                <div class="flex flex-wrap items-center">
                    <span v-for="permission in permissions">
                        <input
                            type="checkbox"
                            v-model="form.permissions"
                            :key="permission.id"
                            :id="role.name + ' ' + permission.name"
                            :value="permission"
                            :name="permission.name"
                            class="mr-2 peer/checkbox checked:text-green-900"
                        />
                        <label
                            :for="role.name + ' ' + permission.name"
                            class="mr-2 peer-checked/checkbox:text-green-900"
                            >{{ permission.name }}</label
                        >
                    </span>
                </div>
                <InputError class="mt-2" :message="form.errors.permissions" />
                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton
                        class="ms-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Update
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped></style>
