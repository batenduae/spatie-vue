<script setup>
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";


import {usePermissions} from "@/composables/permissions.js";
import {onMounted, onUpdated} from "vue";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import Card from "@/Components/AdminComponents/Cards/Card.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";

const {hasPermission, showFlash} = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    userAddress: {
        type: Object,
        required: true,
    },
});
defineOptions({layout: SpatieAdminLayout});
</script>

<template>
    <PageHeader text="Edit User's Address" title="User's Address/Edit">
        <AdminButton
            v-if="hasPermission('users.*')"
            button-text="Go Back"
            button-type="backward"
            route-name="usersAddress.index"
        />
    </PageHeader>

    <Card class="mx-auto max-w-150">
        <div class="py-4 font-semibold">User's Address View</div>


        <div class="p-2 bg-rose-400 rounded-lg my-2">
            <div class="text-xl">User Info:</div>
            <div class="flex text-blue-700">
                <div class="flex-none w-32">User Id</div>
                <div class="flex-none w-12">:</div>
                <div class="flex-grow font-semibold">{{ user.id }}</div>
            </div>
            <div class="flex text-blue-700">
                <div class="flex-none w-32">User Name</div>
                <div class="flex-none w-12">:</div>
                <div class="flex-grow font-semibold">{{ user.name }}</div>
            </div>
            <div class="flex text-blue-700">
                <div class="flex-none w-32">User Email</div>
                <div class="flex-none w-12">:</div>
                <div class="flex-grow font-semibold">{{ user.email }}</div>
            </div>
        </div>
        <div class="p-2 bg-gradient-to-tl from-sky-500 to-green-600 rounded-lg">
            <div class="flex">
                <div class="flex-none w-32">Address Type</div>
                <div class="flex-none w-12">:</div>
                <div class="flex-grow font-semibold">{{ userAddress.addressType }}</div>
            </div>
            <div class="flex">
                <div class="flex-none w-32">District</div>
                <div class="flex-none w-12">:</div>
                <div class="flex-grow font-semibold">{{ userAddress.district }}</div>
            </div>
            <div class="flex">
                <div class="flex-none w-32">
                    {{ (userAddress.typeVillageMunicipalityCity === "City") ? "City Corporation" : "Upazilla" }}
                </div>
                <div class="flex-none w-12">:</div>
                <div class="flex-grow font-semibold">{{ userAddress.upazillaCity }}</div>
            </div>
            <div class="flex">
                <div class="flex-none w-32">Police Station</div>
                <div class="flex-none w-12">:</div>
                <div class="flex-grow font-semibold">{{ userAddress.policeStation }}</div>
            </div>
            <div class="flex">
                <div class="flex-none w-32">
                    {{ (userAddress.typeVillageMunicipalityCity === "Municipality") ? "Municipality" : "Union" }}
                </div>
                <div class="flex-none w-12">:</div>
                <div class="flex-grow font-semibold">{{ userAddress.unionMunicipality }}</div>
            </div>
            <div class="flex">
                <div class="flex-none w-32">
                    {{ (userAddress.typeVillageMunicipalityCity === "Village") ? "Ward No" : "Council" }}
                </div>
                <div class="flex-none w-12">:</div>
                <div class="flex-grow font-semibold">{{ userAddress.unionMunicipality }}</div>
            </div>
            <div class="flex">
                <div class="flex-none w-32">
                    {{ (userAddress.typeVillageMunicipalityCity === "Village") ? "Village" : "Mohokuma" }}
                </div>
                <div class="flex-none w-12">:</div>
                <div class="flex-grow font-semibold">{{ userAddress.villageMohokuma }}</div>
            </div>
            <div class="flex">
                <div class="flex-none w-32">Road No</div>
                <div class="flex-none w-12">:</div>
                <div class="flex-grow font-semibold">{{ userAddress.roadNo }}</div>
            </div>
            <div class="flex">
                <div class="flex-none w-32">House No</div>
                <div class="flex-none w-12">:</div>
                <div class="flex-grow font-semibold">{{ userAddress.houseNo }}</div>
            </div>
            <div class="">
                <div class="">Other Details:</div>
                <div class="bg-slate-700 p-2 rounded-md ">
                    <div v-html="userAddress.otherDetails"></div>
                </div>
            </div>
        </div>
    </Card>
</template>

<style scoped>

</style>
