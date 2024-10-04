<script setup>
import {defineOptions, onMounted, onUpdated} from "vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import Card from "@/Components/AdminComponents/Cards/Card.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import {usePermissions} from "@/composables/permissions.js";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";

const { hasPermission,showFlash } = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
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

defineOptions({ layout: SpatieAdminLayout });
</script>

<template>
    <PageHeader text="Mass Assign Permission to Role"
                title="Roles/MassAssignPermissionToRole">
        <AdminButton
            button-text="Go Back"
            button-type="backward"
            route-name="roles.index"
            v-if="hasPermission('roles.index')"
        />
    </PageHeader>

    <Card v-for="role in roles" v-if="hasPermission(['roles.sync.mass-permission','roles.sync.permission'])" class="mt-4"
          type="cyan">
        <div class="">Roles: {{ role.name }}</div>
        <div class="mx-auto">
            <Card type="green">
                <!--                <Form-->
                <!--                    :key="role.id"-->
                <!--                    :permissions="permissions"-->
                <!--                    :role="role"-->
                <!--                    route-name="roles.syncPermission"-->
                <!--                >-->
                <!--                </Form>-->
            </Card>
        </div>
    </Card>
</template>

<style scoped>

</style>
