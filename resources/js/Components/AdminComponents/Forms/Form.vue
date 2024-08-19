<script setup>
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";

const props = defineProps({
    role:{
        type: Object,
        required: true
    },
    permissions: {
        type: Object,
        required: true
    },
    routeUrl: {
        type: String,
        required: true,
        default: 'roles.assignPermissionsToRole'
    },
    submitText: {
        type: String,
        default: "Update"
    },
})

const form = useForm({
    permissions: ref(props.role.assignedPermissions),
})
</script>

<template>
    <form @submit.prevent="form.put(route(routeUrl,role.id))">
        <div class="flex flex-wrap items-center group">
                    <span v-for="permission in permissions"
                          class=""
                    >
                        <input
                            type="checkbox"
                            v-model="form.permissions"
                            :id="role.name+' '+permission.name"
                            :value="permission.name"
                            :name="permission.name"
                            class="mr-2 peer/checkbox checked:text-green-900"
                        >
                        <label :for="role.name+' '+permission.name" class="mr-2 peer-checked/checkbox:text-green-900">
                            {{ permission.name }}
                        </label>
                    </span>
        </div>
        <InputError class="mt-2" :message="form.errors.permissions" />
        <div class="flex items-center justify-end mt-4">

            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{ props.submitText }}
            </PrimaryButton>
        </div>
    </form>
</template>

<style scoped>

</style>
