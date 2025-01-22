<script setup>
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import {usePermissions} from "@/composables/permissions.js";
import {onMounted, onUpdated} from "vue";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
import RolesDataTable from "@/Pages/Admin/SpatieRolePermission/Roles/RolesDataTable.vue";

defineProps(["roles"]);
const { hasPermission,showFlash } = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
defineOptions({ layout: SpatieAdminLayout });

</script>

<template>
    <div v-if="hasPermission('roles.index')" class="">
        <PageHeader text="Roles Index Page" title="Roles">
            <AdminButton
                v-if="hasPermission(['roles.sync.mass-permission'])"
                button-type="create"
                button-text="Sync Mass Permission To Role"
                route-name="roles.syncMassPermission"
            />
            <AdminButton
                button-text="Create Role"
                button-type="create"
                route-name="roles.create"
                v-if="hasPermission('roles.create')"
            />
        </PageHeader>
        <RolesDataTable :roles="roles"/>
<!--        <RolesTable :roles="roles"/>-->
    </div>
</template>

<style scoped></style>
