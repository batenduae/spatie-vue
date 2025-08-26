<script setup>
import InputError from "@/Components/Default/InputError.vue";
import InputLabel from "@/Components/Default/InputLabel.vue";
import PrimaryButton from "@/Components/Default/PrimaryButton.vue";
import TextInput from "@/Components/Default/TextInput.vue";
import {Head, useForm} from "@inertiajs/vue3";

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("password.store"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Reset Password" />
    <div class="p-2 bg-green-200">
        <form @submit.prevent="submit">
            <div class="p-4">
                <InputLabel for="email" value="Email"/>

                <TextInput
                    id="email"
                    v-model="form.email"
                    autocomplete="username"
                    autofocus
                    class="mt-1 block w-full"
                    required
                    type="email"
                />

                <InputError :message="form.errors.email" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password"/>

                <TextInput
                    id="password"
                    v-model="form.password"
                    autocomplete="new-password"
                    class="mt-1 block w-full"
                    required
                    type="password"
                />

                <InputError :message="form.errors.password" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password"/>

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    autocomplete="new-password"
                    class="mt-1 block w-full"
                    required
                    type="password"
                />

                <InputError
                    :message="form.errors.password_confirmation"
                    class="mt-2"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reset Password
                </PrimaryButton>
            </div>
        </form>
    </div>

</template>
