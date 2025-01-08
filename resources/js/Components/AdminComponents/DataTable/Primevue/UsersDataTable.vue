<script setup>
import {ref} from 'vue';
import {FilterMatchMode} from '@primevue/core/api';
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import {useToast} from 'primevue/usetoast';
import {usePermissions} from "@/composables/permissions.js";
import {useForm} from "@inertiajs/vue3";

const {hasPermission, hasPermissionSelf, hasPermissionOthers, hasRole, showFlash} = usePermissions();
const props = defineProps([
    'users'
])
const toast = useToast();
const dt = ref();
const users = ref();
users.value = props.users;


const filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
});

//For create new user

const user = ref({});
const userDialog = ref(false);
const submitted = ref(false);
const createNewUser = () => {
    user.value = {};
    submitted.value = false;
    userDialog.value = true;
};
const hideDialog = () => {
    userDialog.value = false;
    submitted.value = false;
};
const saveUser = () => {
    submitted.value = true;
    if (user?.value.name?.trim()) {
        const form = useForm({
            name: user.value.name,
            email: user.value.email,
            password: user.value.password,
            password_confirmation: user.value.password,
        });
        form.post(route('users.store'))
        toast.add({severity: 'success', summary: 'Successful', detail: 'User Created', life: 3000});
        userDialog.value = false;
        user.value = {};
    }
};

//for batch mode operation
//to delete user
const selectedUsers = ref();
const deleteUsersDialog = ref(false);
const confirmDeleteSelected = () => {
    deleteUsersDialog.value = true;
};
const deleteSelectedUsers = () => {
    deleteUsersDialog.value = false;
    let ids = selectedUsers.value.map(({id}) => id);
    let filteredIds = [...new Set([...hasPermissionSelf('users.self.delete', ids), ...hasPermissionOthers('users.others.delete', ids)])].filter((value) => value > 1);
    console.log(filteredIds)
    const form = useForm({
        ids: filteredIds,
    });
    form.delete(route('users.destroyMany', filteredIds))
    selectedUsers.value = null;
    toast.add({severity: 'success', summary: 'Successful', detail: 'Users Deleted', life: 3000});
};

const exportCSV = () => {
    dt.value.exportCSV();
};

</script>

<template>
    <div>
        <div class="card mb-4">
            <!--            For operation-->
            <Toolbar class="mb-6">
                <template #start>
                    <!--                    create new user-->
                    <Button v-if="hasPermission('users.others.create')" class="mr-2" icon="pi pi-plus"
                            label="Create User"
                            @click="createNewUser"/>
                    <Button :disabled="!selectedUsers || !selectedUsers.length" icon="pi pi-trash" label="Delete"
                            outlined severity="danger"
                            @click="confirmDeleteSelected"
                    />

                </template>

                <template #end>
                    <FileUpload :chooseButtonProps="{ severity: 'secondary' }" :maxFileSize="1000000" accept="image/*" auto chooseLabel="Import"
                                class="mr-2" customUpload label="Import" mode="basic"/>
                    <Button icon="pi pi-upload" label="Export" severity="secondary" @click="exportCSV($event)"/>
                </template>
            </Toolbar>

            <!--            show chart-->
            <DataTable
                ref="dt"
                v-model:selection="selectedUsers"
                :filters="filters"
                :paginator="true"
                :rows="25"
                :rowsPerPageOptions="[5, 10, 25, 50, 100, 1000]"
                :value="props.users"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} users from Page {currentPage} of {totalPages}"
                dataKey="id"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown JumpToPageInput"
                removableSort
                showGridlines
                size="small"
                sortMode="multiple"
                stripedRows
                scrollHeight="400px" scrollable
            >
                <template #header>
                    <div class="flex flex-wrap gap-2 items-center justify-between">
                        <h4 class="m-0">Manage Users</h4>
                        <IconField>
                            <InputIcon>
                                <i class="pi pi-search"/>
                            </InputIcon>
                            <InputText v-model="filters['global'].value" placeholder="Search..."/>
                        </IconField>
                    </div>
                </template>

                <Column :exportable="false" selectionMode="multiple" style="width: 2rem"></Column>
                <Column field="id" header="Id" sortable style="min-width: 2rem"></Column>
                <Column field="name" frozen header="Name" sortable style="min-width: 2rem"></Column>
                <Column header="Image">
                    <template #body="slotProps">
                        <img :alt="slotProps.data.image"
                             :src="`https://primefaces.org/cdn/primevue/images/user/${slotProps.data.image}`"
                             class="rounded" style="width: 64px"/>
                    </template>
                </Column>
                <Column field="email" header="Email" sortable style="min-width: 3rem"/>
                <Column field="status" header="Status" sortable style="min-width: 3rem">
                    <template #body="slotProps">
                        <ul v-if="slotProps.data.status" class="flex justify-center justify-items-center space-x-2">
                            <li
                                v-for="item in slotProps.data.status"
                                :class="[
                                    'text-center px-2 rounded-lg text-xs font-bold bg-gradient-to-br',
                                    (item === 'restricted' || item === 'banned') ? 'from-red-500 to-fuchsia-500' : item === 'panel'  ? 'from-green-500 to-indigo-500' : 'from-teal-500 to-fuchsia-500',
                                    ]"
                            >
                                {{ item }}
                            </li>
                        </ul>
                        <ul v-else>--</ul>
                    </template>
                </Column>
                <Column field="assignedRoles" header="Roles" style="min-width: 3rem">
                    <template #body="slotProps">
                        <ul v-if="slotProps.data.assignedRoles"
                            class="flex justify-center justify-items-center space-x-2">
                            <li
                                v-for="role in slotProps.data.assignedRoles"
                                class="text-center px-2 rounded-lg text-xs  font-bold bg-gradient-to-br from-teal-500 to-fuchsia-500"
                            >
                                {{ role.name }}

                            </li>
                        </ul>
                        <ul v-else>--</ul>
                    </template>
                </Column>
                <Column field="permissionsViaRole.length" header="Permissions Via Role" style="min-width: 3rem"/>
                <Column field="permissionsDirect.length" header="Direct Permissions" style="min-width: 3rem"/>
                <Column field="assignedPermissions.length" header="All Permissions" style="min-width: 3rem"/>
                <Column :exportable="false" header="Action" style="min-width: 3rem">
                    <template #body="slotProps">
                        <div class="flex justify-start space-x-2">
                            <AdminButton
                                v-if="slotProps.data.id!==1 && hasPermission(['users.assign.*','users.revoke.*'])"
                                :obj="slotProps.data.id"
                                route-name="users.assignRolePermissionView"
                            >
                                <Button raised rounded severity="help" text>
                                    <svg class="size-6" fill="none" stroke="currentColor"
                                         stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                    </svg>
                                </Button>

                            </AdminButton>
                            <AdminButton
                                v-if="slotProps.data.id!==1 && (hasPermissionSelf('users.self.edit',slotProps.data.id) || hasPermissionOthers('users.others.edit',slotProps.data.id))"
                                :obj="slotProps.data.id"
                                route-name="users.edit"
                            >
                                <!--                                <svg class="size-6" fill="none" stroke="currentColor"-->
                                <!--                                     stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">-->
                                <!--                                    <path d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" stroke-linecap="round"-->
                                <!--                                          stroke-linejoin="round"/>-->
                                <!--                                </svg>-->

                                <Button icon="pi pi-pencil" raised rounded text/>
                            </AdminButton>
                            <AdminButton
                                v-if="slotProps.data.id!==1 && (hasPermissionSelf('users.self.delete',slotProps.data.id) || hasPermissionOthers('users.others.delete',slotProps.data.id))"
                                :obj="slotProps.data"
                                button-type="deleteOnConfirm1"
                                route-method="delete"
                                route-name="users.destroy"
                                text="User"
                            >
                                <!--                                <svg class="size-6" fill="none" stroke="currentColor"-->
                                <!--                                     stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">-->
                                <!--                                    <path d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" stroke-linecap="round"-->
                                <!--                                          stroke-linejoin="round"/>-->
                                <!--                                </svg>-->
                                <Button icon="pi pi-trash" raised rounded severity="danger" text/>
                            </AdminButton>
                            <AdminButton
                                v-if="hasPermissionOthers('users.others.login',slotProps.data.id)"
                                :obj="slotProps.data.id"
                                route-method="post"
                                route-name="users.OthersLogin"
                            >
                                <Button raised rounded severity="info" text>
                                    <svg fill="#2854C5" height="24px" viewBox="0 -960 960 960"
                                         width="24px" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-84 31.5-156.5T197-763l56 56q-44 44-68.5 102T160-480q0 134 93 227t227 93q134 0 227-93t93-227q0-67-24.5-125T707-707l56-56q54 54 85.5 126.5T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-40-360v-440h80v440h-80Z"/>
                                    </svg>
                                </Button>
                            </AdminButton>
                            <Button v-else raised rounded severity="success" text>
                                Logged in
                                <svg fill="#75FB4C" height="24px" viewBox="0 -960 960 960"
                                     width="24px" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-84 31.5-156.5T197-763l56 56q-44 44-68.5 102T160-480q0 134 93 227t227 93q134 0 227-93t93-227q0-67-24.5-125T707-707l56-56q54 54 85.5 126.5T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-40-360v-440h80v440h-80Z"/>
                                </svg>
                            </Button>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="userDialog" :modal="true" :style="{ width: '450px' }" header="User Details">
            <div class="flex flex-col gap-6">
                <img v-if="user.image" :alt="user.image"
                     :src="`https://primefaces.org/cdn/primevue/images/user/${user.image}`" class="block m-auto pb-4"/>
                <div>
                    <label class="block font-bold mb-3" for="name">Name</label>
                    <InputText
                        id="name" v-model.trim="user.name" :invalid="submitted && !user.name"
                        autofocus fluid
                        required="true"/>
                    <small v-if="submitted && !user.name" class="text-red-500">Name is required.</small>
                </div>

                <div>
                    <label class="block font-bold mb-3" for="email">Email</label>
                    <InputText
                        id="email" v-model.trim="user.email" :invalid="submitted && !user.email"
                        fluid
                        required="true"/>
                    <small v-if="submitted && !user.email" class="text-red-500">Email is required.</small>
                </div>

                <div>
                    <label class="block font-bold mb-3" for="password">Password</label>
                    <Password
                        id="password"
                        v-model.trim="user.password" :invalid="submitted && !user.password"
                        fluid
                        required
                        toggleMask/>
                    <small v-if="submitted && !user.password" class="text-red-500">Password is required.</small>
                </div>

            </div>

            <template #footer>
                <Button icon="pi pi-times" label="Cancel" text @click="hideDialog"/>
                <Button icon="pi pi-check" label="Save" @click="saveUser"/>
            </template>
        </Dialog>

        <Dialog v-model:visible="deleteUserDialog" :modal="true" :style="{ width: '450px' }" header="Confirm">
            <div class="flex items-center gap-4">
                <i class="pi pi-exclamation-triangle !text-3xl"/>
                <span v-if="user"
                >Are you sure you want to delete <b>{{ user.name }}</b
                >?</span
                >
            </div>
            <template #footer>
                <Button icon="pi pi-times" label="No" text @click="deleteUserDialog = false"/>
                <Button icon="pi pi-check" label="Yes" @click="deleteUser"/>
            </template>
        </Dialog>

        <Dialog v-model:visible="deleteUsersDialog" :modal="true" :style="{ width: '450px' }" header="Confirm">
            <div class="flex items-center gap-4">
                <i class="pi pi-exclamation-triangle !text-3xl"/>
                <span v-if="user">Are you sure you want to delete the selected users?</span>
            </div>
            <template #footer>
                <Button icon="pi pi-times" label="No" text @click="deleteUsersDialog = false"/>
                <Button icon="pi pi-check" label="Yes" text @click="deleteSelectedUsers"/>
            </template>
        </Dialog>
    </div>
</template>


