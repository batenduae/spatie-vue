<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import Card from "@/Components/AdminComponents/Cards/Card.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import {usePermissions} from "@/composables/permissions.js";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
const { hasPermission } = usePermissions();
const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});
defineOptions({ layout: SpatieAdminLayout });
</script>

<template>
    <PageHeader text="Create User" title="Users/Create">
        <AdminButton
            button-text="Go Back"
            button-type="backward"
            route-name="users.index"
            v-if="hasPermission('user.view')"
        />
    </PageHeader>
    <Card class="mx-auto w-96">
        <form @submit.prevent="form.post(route('users.store'))">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full bg-purple-200 dark:bg-boxdark-2 text-black dark:text-white/70"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full bg-purple-200 dark:bg-boxdark-2 text-black dark:text-white/70"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full bg-purple-200 dark:bg-boxdark-2 text-black dark:text-white/70"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full bg-purple-200 dark:bg-boxdark-2 text-black dark:text-white/70"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    v-if="hasPermission('user.create')"
                >
                    Create
                </PrimaryButton>
            </div>
        </form>
    </Card>
</template>

<style scoped></style>
