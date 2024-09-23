<script setup>
import {useForm} from "@inertiajs/vue3";
import {defineOptions, onMounted, onUpdated, ref, watch} from "vue";
import InputError from "@/Components/Default/InputError.vue";
import PrimaryButton from "@/Components/Default/PrimaryButton.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import Card from "@/Components/AdminComponents/Cards/Card.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import {usePermissions} from "@/composables/permissions.js";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";

const {hasPermission, showFlash} = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    roles: {
        type: Object,
        required: true,
    },
    permissions: {
        type: Object,
        required: true,
    },
    assignedRoles: {
        type: Object,
        required: true,
    },
    assignedPermissions: {
        type: Object,
        required: true,
    },
    assignedPermissionsViaRole: {
        type: Object,
        required: true,
    },
});

const form1 = useForm({
    roles: ref(props.assignedRoles),
});

const form2 = useForm({
    permissions: ref(props.assignedPermissions),
});

watch(
    () => props.assignedPermissionsViaRole,
    () => form2.permissions
);
defineOptions({ layout: SpatieAdminLayout });
</script>

<template>
    <PageHeader text="Assign Role & Permission to User:"
                :content="user.name"
                title="Users/AssignRolePermissionToUser">
        <AdminButton
            button-text="Go Back"
            button-type="backward"
            route-name="users.index"
            v-if="hasPermission('user.view')"
        />
    </PageHeader>
    <Card type="green">
        <div class="text-xl py-2 text-fuchsia-900 font-bold">
            User Information:
        </div>
        <div class="justify-between font-bold">
            <div class="">UserId: {{ user.id }}</div>
            <div class="">User: {{ user.name }}</div>
            <div class="">Email: {{ user.email }}</div>
        </div>
    </Card>

    <Card type="cyan" v-if="hasPermission(['assign-role.to-user','assign-permission.to-user'])">
        <div class="my-2" v-if="hasPermission('assign-role.to-user')">
            <div class="text-xl py-2 text-blue-600 font-bold">
                Roles:
            </div>
            <div
                class="mx-auto p-6 rounded-lg bg-gradient-to-b from-purple-400 to-indigo-400"
            >
                <form
                    @submit.prevent="
                        form1.put(route('users.assignRoleToUser', user.id))
                    "
                >
                    <div class="grid sm:grid-cols-4">
                        <span v-for="role in roles" class="">
                            <input
                                type="checkbox"
                                v-model="form1.roles"
                                :id="role.name"
                                :value="role.name"
                                :name="role.name"
                                class="mr-2 peer/checkbox checked:text-green-900"
                            />
                            <label
                                :for="role.name"
                                class="mr-2 peer-checked/checkbox:text-green-900"
                                >{{ role.name }}</label
                            >
                        </span>
                    </div>
                    <InputError class="mt-2" :message="form1.errors.roles" />
                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form1.processing }"
                            :disabled="form1.processing"
                            @click="push.success('Role to User: `'+user.name+'` Updated Successfully')"
                        >
                            Update
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
        <div class="my-2" v-if="hasPermission('assign-permission.to-user')">
            <div class="mt-4 text-xl py-2 text-green-600 font-bold">
                Permissions:
            </div>
            <div
                class="mx-auto p-6 rounded-lg bg-gradient-to-bl from-fuchsia-500 to-amber-200"
            >
                <form
                    @submit.prevent="
                        form2.put(
                            route('users.assignPermissionToUser', user.id)
                        )
                    "
                >
                    <div class="grid sm:grid-cols-4">
                        <span v-for="permission in permissions">
                            <input
                                type="checkbox"
                                v-model="form2.permissions"
                                :id="permission.name"
                                :value="permission.name"
                                :name="permission.name"
                                :checked="
                                    assignedPermissionsViaRole.includes(
                                        permission.name
                                    )
                                "
                                :disabled="
                                    assignedPermissionsViaRole.includes(
                                        permission.name
                                    ) &&
                                    !form2.permissions.includes(permission.name)
                                "
                                class="mr-2 peer/checkbox checked:text-blue-700 disabled:text-green-900 disabled:opacity-25 disabled:font-semibold"
                            />
                            <label
                                :for="permission.name"
                                class="mr-2 peer-checked/checkbox:text-blue-700 peer-disabled/checkbox:text-green-900"
                                >{{ permission.name }}</label
                            >
                        </span>
                    </div>
                    <InputError
                        class="mt-2"
                        :message="form2.errors.permissions"
                    />
                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form2.processing }"
                            :disabled="form2.processing"
                            @click="push.success('Permission to User: `'+user.name+'` Updated Successfully')"
                        >
                            Update
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </Card>
</template>

<style scoped></style>
