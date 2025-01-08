<script setup>
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
import {usePermissions} from "@/composables/permissions.js";
import {onMounted, onUpdated} from "vue";


const {hasPermission, showFlash} = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
defineProps(["usersAddress"]);
defineOptions({layout: SpatieAdminLayout});
</script>

<template>
    <PageHeader text="User's Address Index Page" title="User's Profile">
        <AdminButton
            v-if="hasPermission('users.others.create')"
            button-text="Create User's Address"
            button-type="create"
            route-name="usersAddress.create"
        />
    </PageHeader>
    <div v-if="usersAddress.length" class="mx-auto">
        <div class="">
            <Table>
                <template #tableHeader>
                    <TableHeaderRow
                        :contents="['Id','User_id','Address Type','District','type','Upazilla/City','Police Station','Union/Municipality','Ward/Council','Village/Mohokuma','Road No', 'House No', 'Other Details','Action']"/>
                </template>
                <TableRow
                    v-for="addr in usersAddress"
                    :key="addr.id"
                    :contents="[ addr.id,addr.user_id, addr.addressType, addr.district, addr.typeVillageMunicipalityCity, addr.upazillaCity, addr.policeStation, addr.unionMunicipality, addr.wardCouncil, addr.villageMohokuma, addr.roadNo, addr.houseNo, addr.otherDetails]"
                >
                    <TableDataCell class="flex items-center align-middle space-x-2">
                        <AdminButton
                            v-if="hasPermission('users.*')"
                            :obj="addr.id"
                            button-text="Edit"
                            button-type="edit"
                            route-name="usersAddress.edit"
                        />
                        <AdminButton
                            v-if="hasPermission('users.*')"
                            :obj="addr.id"
                            button-text="Delete"
                            button-type="deleteOnConfirm"
                            route-method="delete"
                            route-name="usersAddress.destroy"
                            text="User Address"
                        />
                        <AdminButton
                            v-if="hasPermission('users.*')"
                            :obj="addr.id"
                            button-text="View"
                            button-type="login"
                            route-method="get"
                            route-name="usersAddress.show"
                        />
                    </TableDataCell>
                </TableRow>
            </Table>
        </div>
    </div>
    <div v-else class="">
        <div class="text-xl bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
            No User's Address Found
        </div>
    </div>
</template>
<style scoped></style>
