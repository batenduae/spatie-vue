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
    permissionsGrouped: {
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
    <PageHeader text="Sync Role & Permission to User:"
                :content="user.name"
                title="Users/AssignRolePermissionToUser">
        <AdminButton
            button-text="Go Back"
            button-type="backward"
            route-name="users.index"
            v-if="hasPermission('users.index')"
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

    <Card v-if="hasPermission(['users.sync.role','users.sync.permission'])" type="cyan">
        <div v-if="hasPermission('users.sync.role')" class="my-2">
            <div class="text-xl py-2 text-blue-600 font-bold">
                Roles:
            </div>
            <div class="mx-auto p-6 rounded-lg bg-gradient-to-b from-purple-400 to-indigo-400">
                <form @submit.prevent="form1.put(route('users.syncRole', user.id))">
                    <Card type="">
                        <div class="flex flex-row flex-wrap">
                            <div v-for="role in roles" class="flex flex-row flex-none w-64">
                                <input
                                    :id="role.name"
                                    v-model="form1.roles"
                                    :name="role.name"
                                    :value="role.name"
                                    class="mr-2 peer/checkbox checked:text-green-900"
                                    type="checkbox"
                                />
                                <label
                                    :for="role.name"
                                    class="mr-2 peer-checked/checkbox:text-green-900"
                                >{{ role.name }}</label>
                            </div>
                        </div>
                    </Card>
                    <InputError :message="form1.errors.roles" class="mt-2"/>
                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form1.processing }"
                            :disabled="form1.processing"
                        >
                            Sync
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>

        <div v-if="hasPermission('users.sync.permission')" class="my-2">
            <div class="mt-4 text-xl py-2 text-green-600 font-bold">
                Permissions:
            </div>
            <div class="mx-auto p-6 rounded-lg bg-gradient-to-bl from-fuchsia-500 to-amber-200">
                <form @submit.prevent="form2.put(route('users.syncPermission', user.id))">

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
                                            :id="permission.name"
                                            v-model="form2.permissions"
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
                                            :name="permission.name"
                                            :value="permission.name"
                                            class="mr-2 peer/checkbox checked:text-blue-700 disabled:text-green-900 disabled:opacity-25 disabled:font-semibold"
                                            type="checkbox"
                                        />
                                        <label
                                            :for="permission.name"
                                            class="mr-2 peer-checked/checkbox:text-blue-700 peer-disabled/checkbox:text-green-900"
                                        >{{ permission.name }}</label>
                                    </div>
                                </div>
                            </div>
                        </Card>

                        <Card type="yellow">
                            <div class="flex flex-row flex-wrap">
                                <div v-for="permission in permissions" class="flex flex-row flex-none w-64">
                                    <input
                                        :id="permission.name"
                                        v-model="form2.permissions"
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
                                        :name="permission.name"
                                        :value="permission.name"
                                        class="mr-2 peer/checkbox checked:text-blue-700 disabled:text-green-900 disabled:opacity-25 disabled:font-semibold"
                                        type="checkbox"
                                    />
                                    <label
                                        :for="permission.name"
                                        class="mr-2 peer-checked/checkbox:text-blue-700 peer-disabled/checkbox:text-green-900"
                                    >{{ permission.name }}</label>
                                </div>
                            </div>
                        </Card>
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
                        >
                            Sync
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </Card>
</template>

<style scoped></style>
