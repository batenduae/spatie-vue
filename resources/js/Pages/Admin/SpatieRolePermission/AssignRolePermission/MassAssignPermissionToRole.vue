<script setup>
import {Head} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {defineOptions} from "vue";
import Form from "@/Components/AdminComponents/Forms/Form.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import Card from "@/Components/AdminComponents/Cards/Card.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import {usePermissions} from "@/composables/permissions.js";
const { hasPermission } = usePermissions();
const props = defineProps({
    roles: {
        type: Object,
        required: true
    },
    permissions: {
        type: Object,
        required: true
    },
})

defineOptions({ layout: AdminLayout });
</script>

<template>
    <PageHeader text="Mass Assign Permission to Role"
                title="Roles/MassAssignPermissionToRole">
        <AdminButton
            button-text="Go Back"
            button-type="backward"
            route-name="roles.index"
            v-if="hasPermission('role.view')"
        />
    </PageHeader>

    <Card type="cyan" class="mt-4" v-for="role in roles" v-if="hasPermission('assign-permission.to-role')">
        <div class="">Roles: {{ role.name }}</div>
        <div class="mx-auto">
            <Card type="green">
                <Form
                    :key="role.id"
                    :permissions="permissions"
                    :role="role"
                    route-name="roles.assignPermissionsToRole"
                >
                </Form>
            </Card>
        </div>
    </Card>
</template>

<style scoped>

</style>
