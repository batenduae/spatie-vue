<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    role: {
        type: Object,
        required: true
    }
})

const form = useForm({
    name: props.role.name
})
defineOptions({ layout: AdminLayout });
</script>

<template>
    <Head title="Roles/Edit" />
    <div class="max-w-7xl mx-auto py-4">
        <div class="flex justify-between items-baseline">
            <h1 class="text-white">Edit Role</h1>
            <Link
                :href="route('roles.index')"
                class="px-4 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded-lg"
            >
                Go Back
            </Link>
        </div>
    </div>
    <div class="mx-auto w-96 p-6 rounded-lg bg-gradient-to-bl from-purple-600 to-amber-200">
        <form @submit.prevent="form.put(route('roles.update',role))">
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

            <div class="flex items-center justify-end mt-4">

                <PrimaryButton class="ms-4"
                               :class="{ 'opacity-25': form.processing }"
                               :disabled="form.processing">
                    Update
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
