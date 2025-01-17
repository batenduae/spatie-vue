<script setup>
import {ref} from 'vue';
import {FilterMatchMode} from '@primevue/core/api';
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import {useToast} from 'primevue/usetoast';
import {usePermissions} from "@/composables/permissions.js";
import {useForm} from "@inertiajs/vue3";

const {hasPermission, hasPermissionSelf, hasPermissionOthers, hasRole, showFlash} = usePermissions();
const props = defineProps([
    'usersAddress'
])
const toast = useToast();
const dt = ref();
const usersAddress = ref();
usersAddress.value = props.usersAddress;


const filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
});

//For create new userAddress

const userAddress = ref({});
const userDialog = ref(false);
const submitted = ref(false);
const createNewUser = () => {
    userAddress.value = {};
    submitted.value = false;
    userDialog.value = true;
};
const hideDialog = () => {
    userDialog.value = false;
    submitted.value = false;
};
const saveUser = () => {
    submitted.value = true;
    if (userAddress?.value.name?.trim()) {
        const form = useForm({
            name: userAddress.value.name,
            email: userAddress.value.email,
            password: userAddress.value.password,
            password_confirmation: userAddress.value.password,
        });
        form.post(route('usersAddress.store'))
        toast.add({severity: 'success', summary: 'Successful', detail: 'UserAddress Created', life: 3000});
        userDialog.value = false;
        userAddress.value = {};
    }
};

//for batch mode operation
//to delete userAddress
const selectedUsersAddress = ref();
const deleteUserDialog = ref(false);
const deleteUsersAddressDialog = ref(false);
const confirmDeleteSelected = () => {
    deleteUsersAddressDialog.value = true;
};
const deleteSelectedUsersAddress = () => {
    deleteUsersAddressDialog.value = false;
    let ids = selectedUsersAddress.value.map(({id}) => id);
    let filteredIds = [...new Set([...hasPermissionSelf('usersAddress.self.delete', ids), ...hasPermissionOthers('usersAddress.others.delete', ids)])].filter((value) => value > 1);
    console.log(filteredIds)
    const form = useForm({
        ids: filteredIds,
    });
    form.delete(route('usersAddress.destroyMany', filteredIds))
    selectedUsersAddress.value = null;
    toast.add({severity: 'success', summary: 'Successful', detail: 'UsersAddress Deleted', life: 3000});
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
    <div v-if="hasPermission(['users.address.index'])" class="">
        <div v-if="usersAddress.length" class="mx-auto">
            <div>
                <div class="card mb-4">
                    <!--            For operation-->
                    <Toolbar class="mb-6">
                        <template #start>
                            <!--                    create new userAddress-->
                            <Button v-if="hasPermission('users.address.others.create')" class="mr-2" icon="pi pi-plus"
                                    label="Create UserAddress"
                                    @click="createNewUser"/>
                            <Button :disabled="!selectedUsersAddress || !selectedUsersAddress.length" icon="pi pi-trash"
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
                        v-model:selection="selectedUsersAddress"
                        :filters="filters"
                        :paginator="true"
                        :rows="25"
                        :rowsPerPageOptions="[5, 10, 25, 50, 100]"
                        :value="props.usersAddress"
                        currentPageReportTemplate="Showing {first} to {last} of {totalRecords} usersAddress from Page {currentPage} of {totalPages}"
                        dataKey="id"
                        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown JumpToPageInput"
                        removableSort
                        :multiSortMeta="multiSortMeta"
                        showGridlines
                        scrollHeight="400px"
                        scrollable
                        size="small"
                        sortMode="multiple"
                        stripedRows

                    >
                        <template #header>
                            <div class="flex flex-wrap gap-2 items-center justify-between">
                                <h4 class="m-0">Manage UsersAddress</h4>
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
                        <Column field="user_id" header="User ID" sortable style="min-width: 2rem"></Column>
                        <Column field="user_name" header="User Name" sortable style="min-width: 2rem"></Column>
                        <Column field="user_email" header="User Email" sortable style="min-width: 2rem"></Column>
                        <Column field="addressType" header="Address Type" sortable style="min-width: 3rem"/>
                        <Column field="district" header="District" sortable style="min-width: 3rem"/>
                        <Column field="typeVillageMunicipalityCity" header="Type" sortable style="min-width: 3rem"/>
                        <Column field="upazillaCity" header="Upazilla / City" sortable style="min-width: 3rem"/>
                        <Column field="policeStation" header="Police Station" sortable style="min-width: 3rem"/>
                        <Column field="unionMunicipality" header="Union / Municipality" sortable
                                style="min-width: 3rem"/>
                        <Column field="wardCouncil" header="Ward / Council" sortable style="min-width: 3rem"/>
                        <Column field="villageMohokuma" header="Village / Mohokuma" sortable style="min-width: 3rem"/>
                        <Column field="roadNo" header="Road No" sortable style="min-width: 3rem"/>
                        <Column field="houseNo" header="House No" sortable style="min-width: 3rem"/>
                        <Column field="otherDetails" header="Other Details" style="min-width: 3rem">
                            <template #body="slotProps">
                                <div v-html="slotProps.data.otherDetails">
                                </div>
                            </template>
                        </Column>


                        <Column :exportable="false" header="Action" style="min-width: 3rem">
                            <template #body="slotProps">
                                <div class="flex items-center align-middle space-x-2">
                                    <AdminButton
                                        v-if="hasPermission('users.*')"
                                        :obj="slotProps.data.id"
                                        button-text="Edit"
                                        button-type="edit"
                                        route-name="usersAddress.edit"
                                    />
                                    <AdminButton
                                        v-if="hasPermission('users.*')"
                                        :obj="slotProps.data"
                                        button-text="Delete"
                                        button-type="deleteOnConfirm"
                                        route-method="delete"
                                        route-name="usersAddress.destroy"
                                        text="User Address"
                                    />
                                    <AdminButton
                                        v-if="hasPermission('users.*')"
                                        :obj="slotProps.data.id"
                                        button-text="View"
                                        button-type="login"
                                        route-method="get"
                                        route-name="usersAddress.show"
                                    />
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                </div>

                <Dialog v-model:visible="userDialog" :modal="true" :style="{ width: '450px' }" header="UserAddress Details">
                    <div class="flex flex-col gap-6">
                        <img v-if="userAddress.image" :alt="userAddress.image"
                             :src="`https://primefaces.org/cdn/primevue/images/userAddress/${userAddress.image}`"
                             class="block m-auto pb-4"/>
                        <div>
                            <label class="block font-bold mb-3" for="name">Name</label>
                            <InputText
                                id="name" v-model.trim="userAddress.name" :invalid="submitted && !userAddress.name"
                                autofocus fluid
                                required="true"/>
                            <small v-if="submitted && !userAddress.name" class="text-red-500">Name is required.</small>
                        </div>

                        <div>
                            <label class="block font-bold mb-3" for="email">Email</label>
                            <InputText
                                id="email" v-model.trim="userAddress.email" :invalid="submitted && !userAddress.email"
                                fluid
                                required="true"/>
                            <small v-if="submitted && !userAddress.email" class="text-red-500">Email is required.</small>
                        </div>

                        <div>
                            <label class="block font-bold mb-3" for="password">Password</label>
                            <Password
                                id="password"
                                v-model.trim="userAddress.password" :invalid="submitted && !userAddress.password"
                                fluid
                                required
                                toggleMask/>
                            <small v-if="submitted && !userAddress.password" class="text-red-500">Password is required.</small>
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
                        <span v-if="userAddress"
                        >Are you sure you want to delete <b>{{ userAddress.name }}</b
                        >?</span
                        >
                    </div>
                    <template #footer>
                        <Button icon="pi pi-times" label="No" text @click="deleteUserDialog = false"/>
                        <Button icon="pi pi-check" label="Yes" @click="deleteUser"/>
                    </template>
                </Dialog>

                <Dialog v-model:visible="deleteUsersAddressDialog" :modal="true" :style="{ width: '450px' }" header="Confirm">
                    <div class="flex items-center gap-4">
                        <i class="pi pi-exclamation-triangle !text-3xl"/>
                        <span v-if="userAddress">Are you sure you want to delete the selected usersAddress?</span>
                    </div>
                    <template #footer>
                        <Button icon="pi pi-times" label="No" text @click="deleteUsersAddressDialog = false"/>
                        <Button icon="pi pi-check" label="Yes" text @click="deleteSelectedUsersAddress"/>
                    </template>
                </Dialog>
            </div>
        </div>
        <div v-else class="">
            <div
                class="text-xl text-white bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
                No User's Address Found
            </div>
        </div>
    </div>
    <div v-else class="">
        <div
            class="text-xl text-white bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
            You are not allowed to access User's Address Datatable
        </div>
    </div>


</template>


