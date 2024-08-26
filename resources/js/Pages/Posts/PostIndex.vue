<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Table from "@/Components/AdminComponents/Table/Table.vue";
import TableDataCell from "@/Components/AdminComponents/Table/TableDataCell.vue";
import TableRow from "@/Components/AdminComponents/Table/TableRow.vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import TableHeaderRow from "@/Components/AdminComponents/Table/TableHeaderRow.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
defineProps(["posts"]);
defineOptions({ layout: AdminLayout });
</script>

<template>
    <PageHeader text="Post Index Page" title="Posts">
        <AdminButton
            button-text="Create Post"
            button-type="create"
            route-name="posts.create"
        />
    </PageHeader>
    <div class="mx-auto" v-if="posts.length">
        <Table>
            <template #tableHeader>
                <TableHeaderRow :contents="['ID','Title','Action']"/>
            </template>
            <TableRow
                v-for="post in posts"
                :key="post.id"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                :contents="[post.id,post.title]"
            >
                <TableDataCell class="flex space-x-2">
                    <AdminButton
                        button-text="Edit"
                        button-type="edit"
                        route-name="posts.edit"
                        :obj="post"
                    />
                    <AdminButton
                        button-text="Delete"
                        button-type="deleteOnConfirm"
                        route-method="delete"
                        route-name="posts.destroy"
                        :obj="post"
                        text="Post"
                    />
                </TableDataCell>
            </TableRow>
        </Table>
    </div>
    <div class="" v-else>
        <div class="text-xl text-white bg-gradient-to-br from-pink-300 to-rose-600 rounded-lg p-4 max-w-xl text-center mx-auto">
            No Post Found
        </div>
    </div>
</template>

<style scoped></style>
