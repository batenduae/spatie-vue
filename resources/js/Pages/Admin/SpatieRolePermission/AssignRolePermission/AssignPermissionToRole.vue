<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { defineOptions, ref } from "vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import Card from "@/Components/AdminComponents/Cards/Card.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
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
    <PageHeader text="Assign Permission to Role:"
                :content="role.name"
                title="Roles/AssignPermissionToRole">
        <AdminButton
            button-text="Go Back"
            button-type="backward"
            route-name="roles.index"
        />
    </PageHeader>

    <Card type="cyan">
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
    </Card>
</template>

<style scoped></style>
