<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import {usePermissions} from "@/composables/permissions.js";
const { hasPermission } = usePermissions();
const props = defineProps({
    permission: {
        type: Object,
        required: true,
    },
});
const form = useForm({
    name: props.permission.name,
});
defineOptions({ layout: AdminLayout });
</script>

<template>
    <PageHeader text="Edit Permission" title="Permissions/Edit">
        <AdminButton
            button-text="Go Back"
            button-type="backward"
            route-name="permissions.index"
            v-if="hasPermission('permission.view')"
        />
    </PageHeader>
    <div
        class="mx-auto w-96 p-6 rounded-lg bg-gradient-to-bl from-purple-600 to-amber-200 shadow-lg shadow-blue-500/50"
    >
        <form
            @submit.prevent="form.put(route('permissions.update', permission))"
        >
            <div>
                <InputLabel for="name" value="Permissions" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    v-if="hasPermission('permission.edit')"
                >
                    Update
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>

<style scoped></style>
