<script setup>
import {ref} from 'vue';
import {FilterMatchMode} from '@primevue/core/api';
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import {useToast} from 'primevue/usetoast';
import {usePermissions} from "@/composables/permissions.js";

const {hasPermission, hasPermissionSelf, hasPermissionOthers, hasRole, showFlash} = usePermissions();
const props = defineProps({
    permissions: {
        type: [Object, String],
        required: true
    }
});
const toast = useToast();
const dt = ref();
const permissions = ref();
permissions.value = props.permissions;
const permissionDialog = ref(false);
const deletePermissionDialog = ref(false);

const deletePermissionsDialog = ref(false);//for batch mode
const permission = ref({});
const selectedPermissions = ref();
const filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
});
const submitted = ref(false);
const openNew = () => {
    permission.value = {};
    submitted.value = false;
    permissionDialog.value = true;
};
const hideDialog = () => {
    permissionDialog.value = false;
    submitted.value = false;
};
const savePermission = () => {
    submitted.value = true;

    if (permission?.value.name?.trim()) {
        if (permission.value.id) {
            permission.value.inventoryStatus = permission.value.inventoryStatus.value ? permission.value.inventoryStatus.value : permission.value.inventoryStatus;
            permissions.value[findIndexById(permission.value.id)] = permission.value;
            toast.add({severity: 'success', summary: 'Successful', detail: 'Permission Updated', life: 3000});
        } else {
            permission.value.id = createId();
            permission.value.code = createId();
            permission.value.image = 'permission-placeholder.svg';
            permission.value.inventoryStatus = permission.value.inventoryStatus ? permission.value.inventoryStatus.value : 'INSTOCK';
            permissions.value.push(permission.value);
            toast.add({severity: 'success', summary: 'Successful', detail: 'Permission Created', life: 3000});
        }

        permissionDialog.value = false;
        permission.value = {};
    }
};
const editPermission = (prod) => {
    permission.value = {...prod};
    permissionDialog.value = true;
};
const confirmDeletePermission = (prod) => {
    permission.value = prod;
    deletePermissionDialog.value = true;
};
const deletePermission = () => {
    permissions.value = permissions.value.filter(val => val.id !== permission.value.id);
    deletePermissionDialog.value = false;
    permission.value = {};
    toast.add({severity: 'success', summary: 'Successful', detail: 'Permission Deleted', life: 3000});
};
const findIndexById = (id) => {
    let index = -1;
    for (let i = 0; i < permissions.value.length; i++) {
        if (permissions.value[i].id === id) {
            index = i;
            break;
        }
    }

    return index;
};
const createId = () => {
    let id = '';
    var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    for (var i = 0; i < 5; i++) {
        id += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return id;
}
const exportCSV = () => {
    dt.value.exportCSV();
};
const confirmDeleteSelected = () => {
    deletePermissionsDialog.value = true;
};
const deleteSelectedPermissions = () => {
    permissions.value = permissions.value.filter(val => !selectedPermissions.value.includes(val));
    deletePermissionsDialog.value = false;
    console.log(selectedPermissions.value);
    selectedPermissions.value = null;
    toast.add({severity: 'success', summary: 'Successful', detail: 'Permissions Deleted', life: 3000});
};

const getStatusLabel = (status) => {
    switch (status) {
        case 'asp':
            return 'success';

        case 'restricted' :
            return 'warn';

        case 'banned':
            return 'danger';

        default:
            return null;
    }
};

</script>

<template>
    <div>
        <div class="card mb-4">
            <Toolbar class="mb-6">
                <template #start>
                    <Button v-if="hasPermission('permissions.others.create')" class="mr-2" icon="pi pi-plus" label="New"
                            @click="openNew"/>
                    <Button :disabled="!selectedPermissions || !selectedPermissions.length" icon="pi pi-trash"
                            label="Delete" outlined severity="danger"
                            @click="confirmDeleteSelected"/>
                </template>

                <template #end>
                    <FileUpload :chooseButtonProps="{ severity: 'secondary' }" :maxFileSize="1000000" accept="image/*"
                                auto chooseLabel="Import"
                                class="mr-2" customUpload label="Import" mode="basic"/>
                    <Button icon="pi pi-upload" label="Export" severity="secondary" @click="exportCSV($event)"/>
                </template>
            </Toolbar>

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
                removableSort
                scrollHeight="400px"
                scrollable
                showGridlines
                size="small"
                sortMode="multiple" stripedRows
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
                <Column field="name" frozen header="Permission Name" sortable style="min-width: 2rem"></Column>
                <Column field="group" header="Permission Group" sortable style="min-width: 2rem"></Column>
                <Column :exportable="false" header="Action" style="min-width: 3rem">
                    <template #body="slotProps">
                        <div class="flex justify-start space-x-2">
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
                <img v-if="permission.image" :alt="permission.image"
                     :src="`https://primefaces.org/cdn/primevue/images/permission/${permission.image}`"
                     class="block m-auto pb-4"/>
                <div>
                    <label class="block font-bold mb-3" for="name">Name</label>
                    <InputText id="name" v-model.trim="permission.name" :invalid="submitted && !permission.name"
                               autofocus
                               fluid required="true"/>
                    <small v-if="submitted && !permission.name" class="text-red-500">Name is required.</small>
                </div>
                <div>
                    <label class="block font-bold mb-3" for="description">Description</label>
                    <Textarea id="description" v-model="permission.description" cols="20" fluid required="true"
                              rows="3"/>
                </div>
                <div>
                    <label class="block font-bold mb-3" for="inventoryStatus">Inventory Status</label>
                    <Select id="inventoryStatus" v-model="permission.inventoryStatus" :options="statuses" fluid
                            optionLabel="label" placeholder="Select a Status"></Select>
                </div>

                <div>
                    <span class="block font-bold mb-4">Category</span>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="flex items-center gap-2 col-span-6">
                            <RadioButton id="category1" v-model="permission.category" name="category"
                                         value="Accessories"/>
                            <label for="category1">Accessories</label>
                        </div>
                        <div class="flex items-center gap-2 col-span-6">
                            <RadioButton id="category2" v-model="permission.category" name="category" value="Clothing"/>
                            <label for="category2">Clothing</label>
                        </div>
                        <div class="flex items-center gap-2 col-span-6">
                            <RadioButton id="category3" v-model="permission.category" name="category"
                                         value="Electronics"/>
                            <label for="category3">Electronics</label>
                        </div>
                        <div class="flex items-center gap-2 col-span-6">
                            <RadioButton id="category4" v-model="permission.category" name="category" value="Fitness"/>
                            <label for="category4">Fitness</label>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-6">
                        <label class="block font-bold mb-3" for="price">Price</label>
                        <InputNumber id="price" v-model="permission.price" currency="USD" fluid locale="en-US"
                                     mode="currency"/>
                    </div>
                    <div class="col-span-6">
                        <label class="block font-bold mb-3" for="quantity">Quantity</label>
                        <InputNumber id="quantity" v-model="permission.quantity" fluid integeronly/>
                    </div>
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
                <span v-if="permission"
                >Are you sure you want to delete <b>{{ permission.name }}</b
                >?</span
                >
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


