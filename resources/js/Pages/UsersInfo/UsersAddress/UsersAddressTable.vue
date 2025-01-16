<script setup>
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import {usePermissions} from "@/composables/permissions.js";

const {hasPermission, hasRole, showFlash} = usePermissions();
defineProps(["usersAddress"]);
</script>

<template>
    <div v-if="hasPermission(['users.address.index'])" class="mx-auto">
        <div v-if="usersAddress.length" class="mx-auto">
            <Table>
                <template #caption>
                    Table: User's Address Index Table
                </template>
                <template #tableHeader>
                    <TableHeaderRow
                        :contents="['Id','User_id','Address Type','District','type','Upazilla/City','Police Station','Union/Municipality','Ward/Council','Village/Mohokuma','Road No', 'House No', 'Other Details','Action']"/>
                </template>
                <TableRow
                    v-for="addr in usersAddress"
                    :key="addr.id"
                    :contents="[ addr.id,addr.user_id, addr.addressType, addr.district, addr.typeVillageMunicipalityCity, addr.upazillaCity,
                    addr.policeStation, addr.unionMunicipality, addr.wardCouncil, addr.villageMohokuma, addr.roadNo, addr.houseNo, addr.otherDetails]"
                >
                    <TableDataCell>
                        <div class="flex items-center align-middle space-x-2">
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
                        </div>
                    </TableDataCell>
                </TableRow>
            </Table>
        </div>
        <div v-else class="">
            <div class="text-xl bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
                No User's Address Found
            </div>
        </div>
    </div>
    <div v-else class="">
        <div
            class="text-xl text-white bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
            You are not allowed to access User's Address Table
        </div>
    </div>

</template>

<style scoped>

</style>
