<script setup>
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
import PermissionsDataTable from "@/Pages/Admin/SpatieRolePermission/Permissions/PermissionsDataTable.vue";
import {usePermissions} from "@/composables/permissions.js";
import {onMounted, onUpdated} from "vue";

const props = defineProps({
    permissions: {
        type: [Object, String],
        required: true
    }
});
const {hasPermission, showFlash} = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
defineOptions({ layout: SpatieAdminLayout });
</script>

<template>
    <div v-if="hasPermission('permissions.index')" class="">
        <PageHeader text="Permissions Index Page" title="Permissions">
            <AdminButton
                button-text="Create Permission"
                button-type="create"
                route-name="permissions.create"
                v-if="hasPermission('permissions.create')"
            />
        </PageHeader>
        <PermissionsDataTable :permissions="permissions"/>
<!--        <PermissionsTable :permissions="permissions"/>-->
    </div>
</template>

<style scoped></style>
