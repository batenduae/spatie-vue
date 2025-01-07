<script setup>
import {useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/Default/TextInput.vue";
import InputLabel from "@/Components/Default/InputLabel.vue";
import InputError from "@/Components/Default/InputError.vue";
import PrimaryButton from "@/Components/Default/PrimaryButton.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import {usePermissions} from "@/composables/permissions.js";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
import {onMounted, onUpdated} from "vue";

const {hasPermission, showFlash} = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
const props = defineProps({
    permission: {
        type: Object,
        required: true,
    },
});
const form = useForm({
    name: props.permission.name,
    group: props.permission.group,
});
defineOptions({ layout: SpatieAdminLayout });
</script>

<template>
    <PageHeader text="Edit Permission" title="Permissions/Edit">
        <AdminButton
            button-text="Go Back"
            button-type="backward"
            route-name="permissions.index"
            v-if="hasPermission('permissions.index')"
        />
    </PageHeader>
    <div
        class="mx-auto w-96 p-6 rounded-lg bg-gradient-to-bl from-purple-600 to-amber-200 shadow-lg shadow-blue-500/50"
    >
        <form
            @submit.prevent="form.put(route('permissions.update', permission))"
        >
            <div>
                <InputLabel for="name" value="Permission Name"/>

                <TextInput
                    id="name"
                    type="text"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError :message="form.errors.name" class="mt-2"/>
            </div>

            <div class="mt-2">
                <InputLabel for="group" value="Permission Group"/>

                <TextInput
                    id="group"
                    v-model="form.group"
                    autocomplete="group"
                    autofocus
                    required
                    type="text"
                />

                <InputError :message="form.errors.group" class="mt-2"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    v-if="hasPermission('permissions.edit')"
                >
                    Update
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>

<style scoped></style>
