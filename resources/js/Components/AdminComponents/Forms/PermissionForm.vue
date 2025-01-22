<script setup>
import InputError from "@/Components/Default/InputError.vue";
import PrimaryButton from "@/Components/Default/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import {usePermissions} from "@/composables/permissions.js";
import Card from "@/Components/AdminComponents/Cards/Card.vue";

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
    permissionsGrouped: {
        type: Object,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
        default: "roles.syncPermission",
    },
    submitText: {
        type: String,
        default: "Sync",
    },
});

const form = useForm({
    permissions: ref(props.role.assignedPermissions),
});
</script>

<template>

    <form @submit.prevent="form.put(route(routeName, role))">
        <div class="flex flex-col">
            <Card type="green">
                <div v-for="(groupItem,groupName) of permissionsGrouped" class="pb-6">
                    <div class="text-blue-900">
                                <span class="text-xl font-semibold">
                                    Group: <span class="text-purple-900 capitalize">{{ groupName || "Null" }}</span>
                                </span> ({{ groupItem.length }})
                    </div>
                    <div class="flex flex-row flex-wrap">
                        <div v-for="permission in groupItem" class="flex flex-row flex-none w-64">
                            <input
                                :id="role.name + ' ' + permission.name"
                                :key="permission.id"
                                v-model="form.permissions"
                                :name="permission.name"
                                :value="permission"
                                class="mr-2 peer/checkbox checked:text-green-900 self-center"
                                type="checkbox"
                            />
                            <label
                                :for="role.name + ' ' + permission.name"
                                class="mr-2 peer-checked/checkbox:text-green-900 capitalize whitespace-nowrap self-center"
                            >{{ permission.name }}</label
                            >
                        </div>
                    </div>
                </div>
            </Card>

            <Card type="yellow">
                <div class="flex flex-row flex-wrap">
                    <div v-for="permission in permissions" class="flex flex-row flex-none w-64">
                        <input
                            :id="role.name + ' ' + permission.name"
                            :key="permission.id"
                            v-model="form.permissions"
                            :name="permission.name"
                            :value="permission"
                            class="mr-2 peer/checkbox checked:text-green-900"
                            type="checkbox"
                        />
                        <label
                            :for="role.name + ' ' + permission.name"
                            class="mr-2 peer-checked/checkbox:text-green-900"
                        >{{ permission.name }}</label
                        >
                    </div>
                </div>
            </Card>
        </div>
        <InputError :message="form.errors.permissions" class="mt-2"/>
        <div class="flex items-center justify-end mt-4">
            <PrimaryButton
                class="ms-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                v-if="hasPermission('roles.sync.permission')"
            >
                Sync
            </PrimaryButton>
        </div>
    </form>
</template>

<style scoped></style>
