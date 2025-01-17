<script setup>
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
import UsersDataTable from "@/Pages/Admin/SpatieRolePermission/Users/UsersDataTable.vue";
import UsersTable from "@/Pages/Admin/SpatieRolePermission/Users/UsersTable.vue";
import {onMounted, onUpdated} from "vue";
import {usePermissions} from "@/composables/permissions.js";
import UsersTrashedDataTable from "@/Pages/Admin/SpatieRolePermission/Users/UsersTrashedDataTable.vue";

const {hasPermission, hasRole, showFlash} = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
defineProps([
    'users',
    'usersTrashed',
]);
defineOptions({layout: SpatieAdminLayout});
</script>

<template>
    <div class="">
        <PageHeader text="Users Index Page" title="Users">
            <AdminButton
                v-if="hasPermission('users.others.create')"
                button-text="Create User"
                button-type="create"
                route-name="users.create"
            />
        </PageHeader>
        <UsersDataTable :users="users"/>
        <UsersTrashedDataTable :users="usersTrashed"/>
        <UsersTable :users="users"/>
    </div>
</template>

<style scoped></style>
