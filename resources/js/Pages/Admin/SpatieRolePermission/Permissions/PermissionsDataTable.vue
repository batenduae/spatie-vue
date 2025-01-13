<script setup>
import {ref} from 'vue';
import {FilterMatchMode} from '@primevue/core/api';
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";

import {useToast} from 'primevue/usetoast';
import {usePermissions} from "@/composables/permissions.js";
import {useForm} from "@inertiajs/vue3";

const {hasPermission, hasPermissionSelf, hasPermissionOthers, hasRole, showFlash} = usePermissions();
const props = defineProps([
    'permissions',
])
const toast = useToast();
const dt = ref();
const permissions = ref();
permissions.value = props.permissions;


const filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
});

//For create new permission

let permission = ref({});
const permissionDialog = ref(false);
const submitted = ref(false);

const createNewPermission = () => {
    permission = {};
    submitted.value = false;
    permissionDialog.value = true;
};

function updatePermission(permissionId) {
    permission = props.permissions.filter((item) => {
        return (item.id === permissionId)
    })[0];
    submitted.value = false;
    permissionDialog.value = true;
}

const hideDialog = () => {
    permissionDialog.value = false;
    submitted.value = false;
};
const savePermission = () => {
    submitted.value = true;
    let form = useForm({
        name: ref(permission.name),
        group: ref(permission.group),
    });
    if (!permission?.id && permission?.name.trim()) {
        form.post(route('permissions.store'))
        toast.add({severity: 'success', summary: 'Successful', detail: 'Permission Created', life: 3000});
        permissionDialog.value = false;
        permission = {};
    } else {
        form.put(route('permissions.update', permission.id))
        toast.add({severity: 'success', summary: 'Successful', detail: 'Permission Updated', life: 3000});
        permissionDialog.value = false;
        permission.value = {};
    }
};

//for batch mode operation
//to delete permission
const selectedPermissions = ref();
const deletePermissionDialog = ref(false);
const deletePermissionsDialog = ref(false);
const confirmDeleteSelected = () => {
    deletePermissionsDialog.value = true;
};
const deleteSelectedPermissions = () => {
    deletePermissionsDialog.value = false;
    let ids = selectedPermissions.value.map(({id}) => id);
    let filteredIds = [...new Set([...hasPermissionSelf('permissions.delete', ids), ...hasPermissionOthers('permissions.delete', ids)])].filter((value) => value > 0);
    const form = useForm({
        ids: filteredIds,
    });
    form.delete(route('permissions.destroyMany', filteredIds))
    selectedPermissions.value = null;
    toast.add({severity: 'success', summary: 'Successful', detail: 'Permissions Deleted', life: 3000});
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
                    <!--                    create new permission-->
                    <Button v-if="hasPermission('permissions.create')" class="mr-2" icon="pi pi-plus"
                            label="Create Permission"
                            @click="createNewPermission"/>
                    <Button :disabled="!selectedPermissions || !selectedPermissions.length" icon="pi pi-trash"
                            label="Delete"
                            outlined severity="danger"
                            @click="confirmDeleteSelected"
                    />

                </template>

                <template #end>
                    <FileUpload :chooseButtonProps="{ severity: 'secondary' }" :maxFileSize="1000000" accept="image/*"
                                auto chooseLabel="Import"
                                class="mr-2" customUpload label="Import" mode="basic"/>
                    <Button icon="pi pi-upload" label="Export" severity="secondary" @click="exportCSV($event)"/>
                </template>
            </Toolbar>

            <!--            show chart-->
            <DataTable
                ref="dt"
                v-model:selection="selectedPermissions"
                :filters="filters"
                :paginator="true"
                :rows="5"
                :rowsPerPageOptions="[5, 10, 25, 50, 100]"
                :value="props.permissions"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} permissions from Page {currentPage} of {totalPages}"
                dataKey="id"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown JumpToPageInput"
                sortMode="multiple"
                removableSort
                scrollHeight="400px"
                scrollable
                showGridlines
                size="small"
                stripedRows

            >
                <template #header>
                    <div class="flex flex-wrap gap-2 items-center justify-between">
                        <h4 class="m-0">Manage Permissions</h4>
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
                <Column field="name" header="Permission Name" sortable style="min-width: 2rem"></Column>
                <Column field="group" header="Permission Group" sortable style="min-width: 2rem"></Column>
                <Column :exportable="false" header="Action" style="min-width: 3rem">
                    <template #body="slotProps">
                        <div class="flex justify-start space-x-2">
                            <Button v-if="hasPermission('permissions.edit')" class="mr-2" icon="pi pi-pencil"
                                    label=""
                                    @click="updatePermission(slotProps.data.id)"/>
                            <AdminButton
                                v-if="hasPermission('permissions.edit')"
                                :obj="slotProps.data.id"
                                button-type="edit1"
                                route-name="permissions.edit"
                            >
                                <Button icon="pi pi-pencil" raised rounded text/>
                            </AdminButton>
                            <AdminButton
                                v-if="hasPermission('permissions.delete')"
                                :obj="slotProps.data.id"
                                button-type="deleteOnConfirm1"
                                route-method="delete"
                                route-name="permissions.destroy"
                                text="Permission"
                            >
                                <Button icon="pi pi-trash" raised rounded severity="danger" text/>
                            </AdminButton>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="permissionDialog" :modal="true" :style="{ width: '450px' }"
                header="Permission Details">
            <div class="flex flex-col gap-6">
                <div>
                    <label class="block font-bold mb-3" for="name">Name</label>
                    <InputText
                        id="name" v-model.trim="permission.name" :invalid="submitted && !permission.name"
                        autofocus fluid
                        required="true"/>
                    <small v-if="submitted && !permission.name" class="text-red-500">Name is required.</small>
                </div>

                <div>
                    <label class="block font-bold mb-3" for="group">Group</label>
                    <InputText
                        id="email" v-model.trim="permission.group" :invalid="submitted && !permission.group"
                        fluid
                        required="false"/>
                    <!--                    <small v-if="submitted && !permission.group" class="text-red-500">group is required.</small>-->
                </div>
            </div>

            <template #footer>
                <Button icon="pi pi-times" label="Cancel" text @click="hideDialog"/>
                <Button icon="pi pi-check" label="Save" @click="savePermission"/>
            </template>
        </Dialog>

        <Dialog v-model:visible="deletePermissionDialog" :modal="true" :style="{ width: '450px' }" header="Confirm">
            <div class="flex items-center gap-4">
                <i class="pi pi-exclamation-triangle !text-3xl"/>
                <span v-if="permission">Are you sure you want to delete <b>{{ permission.name }}</b>?</span>
            </div>
            <template #footer>
                <Button icon="pi pi-times" label="No" text @click="deletePermissionDialog = false"/>
                <Button icon="pi pi-check" label="Yes" @click="deletePermission"/>
            </template>
        </Dialog>

        <Dialog v-model:visible="deletePermissionDialog" :modal="true" :style="{ width: '450px' }" header="Confirm">
            <div class="flex items-center gap-4">
                <i class="pi pi-exclamation-triangle !text-3xl"/>
                <span v-if="permission">Are you sure you want to delete <b>{{ permission.name }}</b>?</span>
            </div>
            <template #footer>
                <Button icon="pi pi-times" label="No" text @click="deletePermissionDialog = false"/>
                <Button icon="pi pi-check" label="Yes" @click="deletePermission"/>
            </template>
        </Dialog>

        <Dialog v-model:visible="deletePermissionsDialog" :modal="true" :style="{ width: '450px' }" header="Confirm">
            <div class="flex items-center gap-4">
                <i class="pi pi-exclamation-triangle !text-3xl"/>
                <span v-if="permission">Are you sure you want to delete the selected permissions?</span>
            </div>
            <template #footer>
                <Button icon="pi pi-times" label="No" text @click="deletePermissionsDialog = false"/>
                <Button icon="pi pi-check" label="Yes" text @click="deleteSelectedPermissions"/>
            </template>
        </Dialog>
    </div>
</template>


