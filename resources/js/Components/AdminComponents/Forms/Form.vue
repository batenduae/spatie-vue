<script setup>
import InputError from "@/Components/Default/InputError.vue";
import PrimaryButton from "@/Components/Default/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import {usePermissions} from "@/composables/permissions.js";

const {hasPermission} = usePermissions();
const props = defineProps({
    role: {
        type: Object,
        required: true,
    },
    permissions: {
        type: Object,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
        default: "roles.assignPermissionsToRole",
    },
    submitText: {
        type: String,
        default: "Update",
    },
});

const form = useForm({
    permissions: ref(props.role.assignedPermissions),
});
</script>

<template>

    <form @submit.prevent="form.put(route(routeName, role))">
        <div class="grid sm:grid-cols-4">
            <span v-for="permission in permissions" class="">
                <input
                    type="checkbox"
                    v-model="form.permissions"
                    :id="role.name + ' ' + permission.name"
                    :value="permission"
                    :name="permission.name"
                    class="mr-2 peer/checkbox checked:text-green-900"
                />
                <label
                    :for="role.name + ' ' + permission.name"
                    class="mr-2 peer-checked/checkbox:text-green-900"
                >
                    {{ permission.name }}
                </label>
            </span>
        </div>
        <InputError class="mt-2" :message="form.errors.permissions" />
        <div class="flex items-center justify-end mt-4">
            <PrimaryButton
                class="ms-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="push.success('Permission to Role: `'+role.name+'` Updated Successfully')"
                v-if="hasPermission('assign-permission.to-role')"
            >
                {{ props.submitText }}
            </PrimaryButton>
        </div>
    </form>
</template>

<style scoped></style>
