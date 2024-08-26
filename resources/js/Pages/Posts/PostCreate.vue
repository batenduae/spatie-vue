<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";


const form = useForm({
    title: "",
    content: "",
});

defineOptions({ layout: AdminLayout });
</script>

<template>
    <PageHeader text="Create Post" title="Posts/Create">
        <AdminButton
            button-text="Go Back"
            button-type="backward"
            route-name="posts.index"
        />
    </PageHeader>
    <div class="flex">
        <div
            class="mx-auto w-96 p-6 rounded-lg bg-gradient-to-bl from-purple-600 to-amber-200 shadow-lg shadow-blue-500/50"
        >
            <form @submit.prevent="form.post(route('posts.store'))">
                <div>
                    <InputLabel for="title" value="Title" />

                    <TextInput
                        id="title"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.title"
                        required
                        autofocus
                        autocomplete="title"
                    />

                    <InputError class="mt-2" :message="form.errors.title" />
                </div>

                <div>
                    <InputLabel for="content" value="Content" />

                    <TextInput
                        id="content"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.content"
                        required
                        autofocus
                        autocomplete="content"
                    />

                    <InputError class="mt-2" :message="form.errors.content" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton
                        class="ms-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Create
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style scoped></style>
