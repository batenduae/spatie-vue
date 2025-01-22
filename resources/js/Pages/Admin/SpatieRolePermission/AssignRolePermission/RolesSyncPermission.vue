<script setup>
import {useForm} from "@inertiajs/vue3";
import {defineOptions, onMounted, onUpdated, ref} from "vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import Card from "@/Components/AdminComponents/Cards/Card.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import {usePermissions} from "@/composables/permissions.js";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
import PermissionForm from "@/Components/AdminComponents/Forms/PermissionForm.vue";

const {hasPermission, showFlash} = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
const props = defineProps({
    role: {
        type: Object,
        required: true,
    },
    permissions: {
        type: Object,
        required: true,
    },
    permissionsGrouped: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    permissions: ref(props.role.assignedPermissions),
});
defineOptions({ layout: SpatieAdminLayout });
</script>

<template>
    <!--    <div class="bg-green-900">-->
    <!--        {{ props.role.assignedPermissions }}-->
    <!--    </div>-->

    <div v-if="hasPermission('roles.sync.permission')" class="">
        <PageHeader text="Assign Permission to Role:"
                    :content="role.name"
                    title="Roles/AssignPermissionToRole">
            <AdminButton
                button-text="Go Back"
                button-type="backward"
                route-name="roles.index"
                v-if="hasPermission('roles.view')"
            />
        </PageHeader>

        <Card v-if="hasPermission('roles.sync.permission')" type="cyan">
            <div class="text-xl py-2 text-fuchsia-900 font-bold">
                Permissions:
            </div>

            <div class="mx-auto p-6 rounded-lg bg-gradient-to-bl from-purple-600 to-amber-200">
                <PermissionForm
                    :key="role.id"
                    :permissions="permissions"
                    :permissionsGrouped="permissionsGrouped"
                    :role="role"
                    route-name="roles.syncPermission"
                >
                </PermissionForm>

            </div>
        </Card>
    </div>

</template>

<style scoped></style>
