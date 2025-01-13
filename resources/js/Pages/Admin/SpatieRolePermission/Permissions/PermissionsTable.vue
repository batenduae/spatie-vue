<script setup>
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import {usePermissions} from "@/composables/permissions.js";

const props = defineProps({
    permissions: {
        type: [Object, String],
        required: true
    }
});
const {hasPermission, showFlash} = usePermissions();
</script>

<template>
    <div v-if="hasPermission('permissions.index')" class="">
        <div v-if="permissions.length" class="mx-auto">
            <Table>
                <template #caption>
                    Table: Permissions Index
                </template>
                <template #tableHeader>
                    <TableHeaderRow :contents="['ID','Name','Group','Action']"/>
                </template>
                <TableRow
                    v-for="permission in props.permissions"
                    :key="permission.id"
                    :contents="[ permission.id,permission.name, permission.group]"
                    narrow="narrower"
                >
                    <TableDataCell>
                        <AdminButton
                            v-if="hasPermission('permissions.edit')"
                            :obj="permission"
                            button-text="Edit"
                            button-type="edit"
                            route-name="permissions.edit"
                        />
                        <AdminButton
                            v-if="hasPermission('permissions.delete')"
                            :obj="permission"
                            button-text="Delete"
                            button-type="deleteOnConfirm"
                            route-method="delete"
                            route-name="permissions.destroy"
                            text="Permission"
                        />
                    </TableDataCell>
                </TableRow>
            </Table>
        </div>
        <div v-else class="">
            <div
                class="text-xl text-white bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
                No Permission Found
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
