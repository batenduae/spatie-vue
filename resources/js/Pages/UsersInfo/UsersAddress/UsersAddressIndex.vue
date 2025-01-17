<script setup>
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
import {usePermissions} from "@/composables/permissions.js";
import {onMounted, onUpdated} from "vue";
import UsersAddressTable from "@/Pages/UsersInfo/UsersAddress/UsersAddressTable.vue";
import UsersAddressDataTable from "@/Pages/UsersInfo/UsersAddress/UsersAddressDataTable.vue";

const {hasPermission, showFlash} = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
defineProps([
    'usersAddress',
]);
defineOptions({layout: SpatieAdminLayout});
</script>

<template>
    <PageHeader text="User's Address Index Page" title="User's Profile">
        <AdminButton
            v-if="hasPermission(['users.address.create'])"
            button-text="Create User's Address"
            button-type="create"
            route-name="usersAddress.create"
        />
    </PageHeader>

    <UsersAddressDataTable :usersAddress="usersAddress"/>
    <UsersAddressTable :usersAddress="usersAddress"/>
</template>
<style scoped></style>
