<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',

})
defineOptions({ layout: AdminLayout });
</script>

<template>
    <Head title="Users/Create" />
    <div class="max-w-7xl mx-auto py-4">
        <div class="flex justify-between items-baseline">
            <h1 class="text-white">Create User</h1>
            <Link
                :href="route('users.index')"
                class="px-4 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded-lg"
            >
                Go Back
            </Link>
        </div>
    </div>
    <div class="mx-auto w-96 p-6 rounded-lg bg-gradient-to-bl from-purple-600 to-amber-200">
        <form @submit.prevent="form.post(route('users.store'))">
            <div>
                <InputLabel for="name" value="Name" />

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

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
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
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Create
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
