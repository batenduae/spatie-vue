<script setup>
import {onMounted, ref} from 'vue';
import {CustomerService} from './services/CustomerService';
import {FilterMatchMode, FilterOperator} from '@primevue/core/api';
import {useToast} from 'primevue/usetoast';
import {usePermissions} from "@/composables/permissions.js";

const {hasPermission, hasPermissionSelf, hasPermissionOthers, hasRole, showFlash} = usePermissions();
const props = defineProps([
    'users'
])
const toast = useToast();
const dt = ref();
const customers = ref();
const selectedCustomers = ref();
const filters = ref();
const statuses = ref(['unqualified', 'qualified', 'new', 'negotiation', 'renewal', 'proposal']);

onMounted(() => {
    CustomerService.getCustomersLarge().then((data) => {
        customers.value = getCustomers(data);
    });
});


const initFilters = () => {
    filters.value = {
        global: {value: null, matchMode: FilterMatchMode.CONTAINS},
        name: {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
        'country.name': {
            operator: FilterOperator.AND,
            constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]
        },
        representative: {value: null, matchMode: FilterMatchMode.IN},
        date: {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.DATE_IS}]},
        balance: {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.EQUALS}]},
        status: {operator: FilterOperator.OR, constraints: [{value: null, matchMode: FilterMatchMode.EQUALS}]},
        activity: {value: [0, 100], matchMode: FilterMatchMode.BETWEEN},
        verified: {value: null, matchMode: FilterMatchMode.EQUALS}
    };
};

initFilters();

const formatDate = (value) => {
    return value.toLocaleDateString('en-In', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
};
const formatCurrency = (value) => {
    return value.toLocaleString('en-In', {style: 'currency', currency: 'BDT'});
};
const clearFilter = () => {
    initFilters();
};
const getCustomers = (data) => {
    return [...(data || [])].map((d) => {
        d.date = new Date(d.date);

        return d;
    });
};
const getSeverity = (status) => {
    switch (status) {
        case 'unqualified':
            return 'danger';


        case 'qualified':
            return 'success';

        case 'new':
            return 'info';

        case 'negotiation':
            return 'warn';

        case 'renewal':
            return null;
    }
};


const customerDialog = ref(false);
const deleteCustomerDialog = ref(false);
const deleteCustomersDialog = ref(false);
const customer = ref({});
const submitted = ref(false);

const openNew = () => {
    customer.value = {};
    submitted.value = false;
    customerDialog.value = true;
};
const hideDialog = () => {
    customerDialog.value = false;
    submitted.value = false;
};
const saveCustomer = () => {
    submitted.value = true;

    if (customer?.value.name?.trim()) {
        if (customer.value.id) {
            customer.value.inventoryStatus = customer.value.inventoryStatus.value ? customer.value.inventoryStatus.value : customer.value.inventoryStatus;
            customers.value[findIndexById(customer.value.id)] = customer.value;
            toast.add({severity: 'success', summary: 'Successful', detail: 'Customer Updated', life: 3000});
        } else {
            customer.value.id = createId();
            customer.value.code = createId();
            customer.value.image = 'customer-placeholder.svg';
            customer.value.inventoryStatus = customer.value.inventoryStatus ? customer.value.inventoryStatus.value : 'INSTOCK';
            customers.value.push(customer.value);
            toast.add({severity: 'success', summary: 'Successful', detail: 'Customer Created', life: 3000});
        }

        customerDialog.value = false;
        customer.value = {};
    }
};
const editCustomer = (prod) => {
    customer.value = {...prod};
    customerDialog.value = true;
};
const confirmDeleteCustomer = (prod) => {
    customer.value = prod;
    deleteCustomerDialog.value = true;
};
const deleteCustomer = () => {
    customers.value = customers.value.filter(val => val.id !== customer.value.id);
    deleteCustomerDialog.value = false;
    customer.value = {};
    toast.add({severity: 'success', summary: 'Successful', detail: 'Customer Deleted', life: 3000});
};
const findIndexById = (id) => {
    let index = -1;
    for (let i = 0; i < customers.value.length; i++) {
        if (customers.value[i].id === id) {
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
    deleteCustomersDialog.value = true;
};
const deleteSelectedCustomers = () => {
    customers.value = customers.value.filter(val => !selectedCustomers.value.includes(val));
    deleteCustomersDialog.value = false;
    selectedCustomers.value = null;
    toast.add({severity: 'success', summary: 'Successful', detail: 'Customers Deleted', life: 3000});
};

</script>

<template>
    <div class="card">
        <Toolbar class="mb-6">
            <template #start>
                <Button class="mr-2" icon="pi pi-plus" label="New" @click="openNew"/>
                <Button :disabled="!selectedCustomers || !selectedCustomers.length" icon="pi pi-trash" label="Delete" outlined severity="danger"
                        @click="confirmDeleteSelected"/>
            </template>

            <template #end>
                <FileUpload :chooseButtonProps="{ severity: 'secondary' }" :maxFileSize="1000000" accept="image/*" auto chooseLabel="Import"
                            class="mr-2" customUpload label="Import" mode="basic"/>
                <Button icon="pi pi-upload" label="Export" severity="secondary" @click="exportCSV($event)"/>
            </template>
        </Toolbar>

        <DataTable v-model:filters="filters"
                   v-model:selection="selectedCustomers"
                   :globalFilterFields="['name', 'country.name', 'representative.name', 'balance', 'status']"
                   :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" :value="customers"
                   currentPageReportTemplate="Showing {first} to {last} of {totalRecords} products"
                   dataKey="id"
                   filterDisplay="menu"
                   paginator
                   paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                   removableSort
                   sortMode="multiple"

        >
            <template #header>
                <div class="flex justify-between">
                    <Button icon="pi pi-filter-slash" label="Clear" outlined type="button" @click="clearFilter()"/>
                    <IconField>
                        <InputIcon>
                            <i class="pi pi-search"/>
                        </InputIcon>
                        <InputText v-model="filters['global'].value" placeholder="Keyword Search"/>
                    </IconField>
                </div>
            </template>
            <template #empty> No customers found.</template>
            <Column frozen headerStyle="width: 3rem" selectionMode="multiple"></Column>
            <Column field="name" frozen header="Name" sortable style="min-width: 14rem">
                <template #body="{ data }">
                    {{ data.name }}
                </template>
                <template #filter="{ filterModel }">
                    <InputText v-model="filterModel.value" placeholder="Search by name" type="text"/>
                </template>
            </Column>
            <Column filterField="country.name" header="Country" sortField="country.name" sortable
                    style="min-width: 14rem">
                <template #body="{ data }">
                    <div class="flex items-center gap-2">
                        <img :class="`flag flag-${data.country.code}`" alt="flag"
                             src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png" style="width: 24px"/>
                        <span>{{ data.country.name }}</span>
                    </div>
                </template>
                <template #filter="{ filterModel }">
                    <InputText v-model="filterModel.value" placeholder="Search by country" type="text"/>
                </template>
            </Column>
            <Column :filterMenuStyle="{ width: '14rem' }" :showFilterMatchModes="false" filterField="representative" header="Agent"
                    sortField="representative.name" sortable style="min-width: 14rem">
                <template #body="{ data }">
                    <div class="flex items-center gap-2">
                        <img :alt="data.representative.name"
                             :src="`https://primefaces.org/cdn/primevue/images/avatar/${data.representative.image}`"
                             style="width: 32px"/>
                        <span>{{ data.representative.name }}</span>
                    </div>
                </template>
                <template #filter="{ filterModel }">
                    <MultiSelect v-model="filterModel.value" :options="representatives" optionLabel="name"
                                 placeholder="Any">
                        <template #option="slotProps">
                            <div class="flex items-center gap-2">
                                <img :alt="slotProps.option.name"
                                     :src="`https://primefaces.org/cdn/primevue/images/avatar/${slotProps.option.image}`"
                                     style="width: 32px"/>
                                <span>{{ slotProps.option.name }}</span>
                            </div>
                        </template>
                    </MultiSelect>
                </template>
            </Column>
            <Column dataType="date" field="date" filterField="date" header="Date" sortable style="min-width: 10rem">
                <template #body="{ data }">
                    {{ formatDate(data.date) }}
                </template>
                <template #filter="{ filterModel }">
                    <DatePicker v-model="filterModel.value" dateFormat="dd/mm/yy" placeholder="dd/mm/yy"/>
                </template>
            </Column>
            <Column dataType="numeric" field="balance" filterField="balance" header="Balance" sortable
                    style="min-width: 10rem">
                <template #body="{ data }">
                    {{ formatCurrency(data.balance) }}
                </template>
                <template #filter="{ filterModel }">
                    <InputNumber v-model="filterModel.value" currency="BDT" locale="en-In" mode="currency"/>
                </template>
            </Column>
            <Column :filterMenuStyle="{ width: '14rem' }" field="status" header="Status" sortable
                    style="min-width: 12rem">
                <template #body="{ data }">
                    <Tag :severity="getSeverity(data.status)" :value="data.status"/>
                </template>
                <template #filter="{ filterModel }">
                    <Select v-model="filterModel.value" :options="statuses" placeholder="Select One" showClear>
                        <template #option="slotProps">
                            <Tag :severity="getSeverity(slotProps.option)" :value="slotProps.option"/>
                        </template>
                    </Select>
                </template>
            </Column>
            <Column :showFilterMatchModes="false" field="activity" header="Activity" sortable style="min-width: 12rem">
                <template #body="{ data }">
                    <ProgressBar :showValue="false" :value="data.activity" style="height: 6px"></ProgressBar>
                </template>
                <template #filter="{ filterModel }">
                    <Slider v-model="filterModel.value" class="m-4" range></Slider>
                    <div class="flex items-center justify-between px-2">
                        <span>{{ filterModel.value ? filterModel.value[0] : 0 }}</span>
                        <span>{{ filterModel.value ? filterModel.value[1] : 100 }}</span>
                    </div>
                </template>
            </Column>
            <Column bodyStyle="text-align: center; overflow: visible" headerStyle="width: 5rem; text-align: center">
                <template #body>
                    <Button icon="pi pi-cog" rounded type="button"/>
                </template>
            </Column>
        </DataTable>
    </div>
</template>

