<script setup>
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import {usePermissions} from "@/composables/permissions.js";

const {hasPermission, hasPermissionSelf, hasPermissionOthers, hasRole, showFlash} = usePermissions();
defineProps(["users"]);
</script>

<template>
    <div v-if="users.length && hasPermission(['users.index'])" class="mx-auto">
        <div class="">
            <Table>
                <template #caption>
                    Table: User's Index Table
                </template>
                <template #tableHeader>
                    <TableHeaderRow
                        :contents="['ID','Name','Email','Status','Roles','Permissions Via Role','Direct Permissions','All Permissions','Action']"
                    />
                </template>
                <TableRow
                    v-for="user in users"
                    :key="user.id"
                    :contents="[ user.id,user.name,user.email]"
                    narrow="narrower"

                >
                    <TableDataCell narrow="narrower">
                        <ul v-if="user.status.length" class="flex justify-center justify-items-center space-x-2">
                            <li
                                v-for="item in user.status"
                                :class="[
                                    'text-center px-2 rounded-lg text-xs font-bold bg-gradient-to-br',
                                    (item === 'restricted' || item === 'banned') ? 'from-red-500 to-fuchsia-500' : item === 'panel'  ? 'from-green-500 to-indigo-500' : 'from-teal-500 to-fuchsia-500',
                                    ]"
                            >
                                {{ item }}
                            </li>
                        </ul>
                        <ul v-else>--</ul>
                    </TableDataCell>
                    <TableDataCell>
                        <ul v-if="user.assignedRoles.length"
                            class="flex justify-center justify-items-center space-x-2">
                            <li
                                v-for="role in user.assignedRoles"
                                class="text-center px-2 rounded-lg text-xs  font-bold bg-gradient-to-br from-teal-500 to-fuchsia-500"
                            >
                                {{ role.name }}

                            </li>
                        </ul>
                        <ul v-else>--</ul>
                    </TableDataCell>
                    <TableDataCell narrow="narrower">
                        {{ user.permissionsViaRole.length }}
                    </TableDataCell>
                    <TableDataCell narrow="narrower">
                        {{ user.permissionsDirect.length }}
                    </TableDataCell>
                    <TableDataCell narrow="narrower">
                        {{ user.assignedPermissions.length }}
                    </TableDataCell>
                    <TableDataCell>
                        <div class="flex justify-start space-x-2">
                            <AdminButton
                                v-if="user.id!==1 && hasPermission(['users.assign.*','users.revoke.*'])"
                                :obj="user"
                                button-type="assign"
                                class="px-2"
                                route-name="users.assignRolePermissionView"
                            >
                                <svg class="size-6" fill="none" stroke="currentColor"
                                     stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                    <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                </svg>

                            </AdminButton>
                            <AdminButton
                                v-if="user.id!==1 && (hasPermissionSelf('users.self.edit',user.id) || hasPermissionOthers('users.others.edit',user.id))"
                                :obj="user"
                                button-type="edit"
                                class="px-2"
                                route-name="users.edit"
                            >
                                <svg class="size-6" fill="none" stroke="currentColor"
                                     stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>

                            </AdminButton>
                            <AdminButton
                                v-if="user.id!==1 && (hasPermissionSelf('users.self.delete',user.id) || hasPermissionOthers('users.others.delete',user.id))"
                                :obj="user"
                                button-type="deleteOnConfirm"
                                class="px-2"
                                route-method="delete"
                                route-name="users.destroy"
                                text="User"
                            >
                                <svg class="size-6" fill="none" stroke="currentColor"
                                     stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>

                            </AdminButton>
                            <AdminButton
                                v-if="hasPermissionOthers('users.others.login',user.id)"
                                :obj="user"
                                button-text="Log in"
                                button-type="login"
                                class="px-2"
                                route-method="post"
                                route-name="users.OthersLogin"
                            />
                            <button v-else class="text-green-400 flex space-x-2" raised rounded text>
                                <span>Logged in</span>
                                <svg fill="#75FB4C" height="24px" viewBox="0 -960 960 960"
                                     width="24px" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-84 31.5-156.5T197-763l56 56q-44 44-68.5 102T160-480q0 134 93 227t227 93q134 0 227-93t93-227q0-67-24.5-125T707-707l56-56q54 54 85.5 126.5T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-40-360v-440h80v440h-80Z"/>
                                </svg>
                            </button>
                        </div>
                    </TableDataCell>
                </TableRow>
            </Table>
        </div>
    </div>
    <div v-else class="">
        <div
            class="text-xl bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
            No User Found
        </div>
    </div>
</template>

<style scoped>

</style>
