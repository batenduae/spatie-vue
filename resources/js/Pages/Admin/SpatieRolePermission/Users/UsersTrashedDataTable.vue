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
const restoreUsers = () => {
    user.value = {};
    submitted.value = false;
    userDialog.value = true;
};

//for batch mode operation
//to delete user
const selectedUsers = ref();
const deleteUserDialog = ref(false);
const restoreUsersDialog = ref(false);
const deleteUsersDialog = ref(false);
const confirmRestoreSelected = () => {
    restoreUsersDialog.value = true;
};
const confirmDeleteSelected = () => {
    deleteUsersDialog.value = true;
};

const restoreSelectedUsers = () => {
    restoreUsersDialog.value = false;
    let ids = selectedUsers.value.map(({id}) => id);
    let filteredIds = [...new Set([...hasPermissionOthers('users.others.restore', ids)])].filter((value) => value > 1);
    console.log(filteredIds)
    const form = useForm({
        ids: filteredIds,
    });
    form.post(route('users.restoreMany', filteredIds))
    selectedUsers.value = null;
    // toast.add({severity: 'success', summary: 'Successful', detail: 'Users Restored', life: 3000});
    this.$parent.fetchData();
    this.$forceUpdate();
};
const deleteSelectedUsers = () => {
    deleteUsersDialog.value = false;
    let ids = selectedUsers.value.map(({id}) => id);
    let filteredIds = [...new Set([...hasPermissionOthers('users.others.delete', ids)])].filter((value) => value > 1);
    console.log(filteredIds)
    const form = useForm({
        ids: filteredIds,
    });
    form.delete(route('users.destroyPermanentlyMany', filteredIds))
    selectedUsers.value = null;
    // toast.add({severity: 'success', summary: 'Successful', detail: 'Users Deleted', life: 3000});
    this.$parent.fetchData();
    this.$forceUpdate();
};

const exportCSV = () => {
    dt.value.exportCSV();
};

const multiSortMeta = ref(
    [
        {field: 'id', order: -1},
    ]
);

</script>

<template>
    <div v-if="hasPermission(['users.index'])" class="mx-auto">
        <div v-if="users.length" class="mx-auto">
            <div class="card mb-4">
                <!--            For operation-->
                <Toolbar class="mb-6">
                    <template #start>
                        <!--                    create new user-->
                        <Button :disabled="!selectedUsers || !selectedUsers.length" class="mr-2" icon="pi pi-replay"
                                label="Restore"
                                outlined severity="success"
                                @click="confirmRestoreSelected"

                        />
                        <Button :disabled="!selectedUsers || !selectedUsers.length" icon="pi pi-exclamation-triangle"
                                label="Delete Completely"
                                outlined severity="danger"
                                @click="confirmDeleteSelected"
                        />
                    </template>

                    <template #end>
                        <FileUpload :chooseButtonProps="{ severity: 'secondary' }" :maxFileSize="1000000"
                                    accept="image/*" auto chooseLabel="Import"
                                    class="mr-2" customUpload label="Import" mode="basic"/>
                        <Button icon="pi pi-upload" label="Export" severity="secondary" @click="exportCSV($event)"/>
                    </template>
                </Toolbar>

                <!--            show chart-->
                <DataTable
                    ref="dt"
                    v-model:selection="selectedUsers"
                    :filters="filters"
                    :multiSortMeta="multiSortMeta"
                    :paginator="true"
                    :rows="25"
                    :rowsPerPageOptions="[5, 10, 25, 50, 100]"
                    :value="props.users"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} users from Page {currentPage} of {totalPages}"
                    dataKey="id"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown JumpToPageInput"
                    removableSort
                    scrollHeight="500px"
                    scrollable
                    showGridlines
                    size="small"
                    sortMode="multiple"
                    stripedRows

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
                    <Column header="Deleted At" style="min-width: 3rem">
                        <template #body="slotProps">
                            <div class="">{{ new Date(slotProps.data.deleted_at).toLocaleString() }}</div>
                        </template>
                    </Column>
                    <Column :exportable="false" header="Action" style="min-width: 3rem">
                        <template #body="slotProps">
                            <div class="flex justify-start space-x-2">
                                <AdminButton
                                    v-if="slotProps.data.id!==1 && (hasPermissionSelf('users.self.edit',slotProps.data.id) || hasPermissionOthers('users.others.edit',slotProps.data.id))"
                                    :obj="slotProps.data"
                                    route-method="post"
                                    route-name="users.restore"
                                    text="User"
                                >
                                    <Button icon="pi pi-replay" raised rounded text/>
                                </AdminButton>
                                <AdminButton
                                    v-if="slotProps.data.id!==1 && (hasPermissionSelf('users.self.delete',slotProps.data.id) || hasPermissionOthers('users.others.delete',slotProps.data.id))"
                                    :obj="slotProps.data.id"
                                    button-type="deleteOnConfirm1"
                                    route-method="delete"
                                    route-name="users.destroyPermanently"
                                    text="User"
                                >
                                    <Button icon="pi pi-trash" raised rounded severity="danger" text/>
                                </AdminButton>
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </div>

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

            <Dialog v-model:visible="restoreUsersDialog" :modal="true" :style="{ width: '450px' }" header="Confirm">
                <div class="flex items-center gap-4">
                    <i class="pi pi-exclamation-triangle !text-3xl"/>
                    <span v-if="user">Are you sure you want to restore the selected users?</span>
                </div>
                <template #footer>
                    <Button icon="pi pi-times" label="No" text @click="restoreUsersDialog = false"/>
                    <Button icon="pi pi-check" label="Yes" text @click="restoreSelectedUsers"/>
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
        <div v-else class="">
            <div
                class="text-xl bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
                There are no data in user's Trash Datatable.
            </div>
        </div>
    </div>
    <div v-else class="">
        <div
            class="text-xl bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
            You are not allowed to see user's Trash Datatable.
        </div>
    </div>
</template>


