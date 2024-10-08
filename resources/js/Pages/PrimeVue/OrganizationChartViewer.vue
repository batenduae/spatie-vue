<script setup>
import {ref} from "vue";

const data = ref({
    key: '#',
    org: 'Bangladesh Police',
    styleClass: '!bg-gradient-to-b from-sky-500 via-blue-400 via-blue-400 to-sky-600 text-3xl',
    data: {
        image: 'https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png',
        name: 'Amy Elsner',
        title: 'CEO'
    },
    children: [
        {
            key: '0',
            org: 'Police Headquarters',
            post: 'Inspector General of Police (IGP)',
            grade: 1,
            styleClass: '!bg-purple-100 text-white rounded-xl',
            data: {
                image: 'https://primefaces.org/cdn/primevue/images/avatar/annafali.png',
                name: 'Anna Fali',
                title: 'CMO'
            },
            children: [
                {
                    key: '0_1',
                    org: 'SB',
                    post: 'Addl.IG',
                    grade: 1,
                    styleClass: '!bg-purple-100 text-white rounded-xl'
                },
                {
                    key: '0_2',
                    org: 'CID',
                    post: 'Addl.IG',
                    grade: '2',
                    styleClass: '!bg-purple-100 text-white rounded-xl'
                },
                {
                    key: '0_3',
                    org: 'Range-8',
                    post: 'DIG',
                    styleClass: '!bg-purple-100 text-white rounded-xl'
                },
                {
                    key: '0_4',
                    org: 'Metropolitan Police-8',
                    post: '(Addl.IG-1,DIG-7)',
                    styleClass: '!bg-purple-100 text-white rounded-xl'
                },
                {
                    key: '0_5',
                    org: 'Railway Police',
                    post: 'Addl.IG',
                    grade: 2,
                    styleClass: '!bg-purple-100 text-white rounded-xl'
                },
                {
                    key: '0_6',
                    org: 'Highway Police',
                    post: 'Addl.IG',
                    grade: 2,
                    styleClass: '!bg-purple-100 text-white rounded-xl'
                },
                {
                    key: '0_7',
                    org: 'Police Staff College',
                    post: 'Addl.IG',
                    grade: 2,
                    styleClass: '!bg-purple-100 text-white rounded-xl'
                },
                {
                    key: '0_8',
                    org: 'Police Academy',
                    post: 'Addl.IG',
                    grade: 2,
                    styleClass: '!bg-purple-100 text-white rounded-xl'
                },
                {
                    key: '0_9',
                    org: 'Police Training Center-4',
                    post: 'DIG',
                    grade: 2,
                    styleClass: '!bg-purple-100 text-white rounded-xl',
                    children: [
                        {
                            key: '0_9_1',

                            org: 'Police Academydfgdfg',
                            post: 'Addl.IG',
                            grade: 2,
                            styleClass: '!bg-purple-100 text-white rounded-xl p-organizationchart-connector-left'
                        }
                    ]
                },
            ]
        },
    ]
});
const selection = ref({});

</script>

<template>
    <div class="card overflow-x-auto">
        <OrganizationChart
            v-model:selectionKeys="selection" :value="data"
            collapsible
            selectionMode="multiple"
        >
            <template #person="slotProps">
                <div class="flex flex-col">
                    <div class="flex flex-col items-center">
                        <!--                        <img :alt="slotProps.node.data.name" :src="slotProps.node.data.image" class="mb-4 w-12 h-12" />-->
                        <span class="font-bold mb-2">{{ slotProps.node.org }}</span>
                    </div>
                </div>
            </template>
            <template #default="slotProps">
                <div class="flex flex-col">
                    <div v-if="slotProps.node.org" class="flex flex-col items-center">
                        <div class="font-bold mb-2">{{ slotProps.node.org }}</div>
                    </div>
                    <div v-if="slotProps.node.post" class="">
                        <span>{{ slotProps.node.post }}</span>
                    </div>
                    <div v-if="slotProps.node.grade" class="">
                        <span>G-{{ slotProps.node.grade }}</span>
                    </div>
                    <div v-if="slotProps.node.label" class="">
                        <span>{{ slotProps.node.label }}</span>
                    </div>
                </div>
            </template>
        </OrganizationChart>
    </div>
</template>

<style scoped>

</style>
