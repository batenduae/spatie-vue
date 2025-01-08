<script setup>
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
import {useForm} from "@inertiajs/vue3";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import Card from "@/Components/AdminComponents/Cards/Card.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import districts from "@/bangladeshGeocode/districts/districts.json";
import upazilas from "@/bangladeshGeocode/upazilas/upazilas.json";
import unions from "@/bangladeshGeocode/unions/unions.json";
import {usePermissions} from "@/composables/permissions.js";
import {onMounted, onUpdated, ref} from "vue";

const {hasPermission, showFlash} = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
const props = defineProps({
    userAddress: {
        type: Object,
        required: true,
    },
    user: {
        type: Object,
        required: true,
    },
    users: {
        type: Object,
        required: true,
    },
});
const form = useForm({
    id: ref(props.userAddress.id),
    user_id: ref(props.userAddress?.user_id),
    addressType: ref(props.userAddress?.addressType),
    district: ref(props.userAddress?.district),
    typeVillageMunicipalityCity: ref(props.userAddress?.typeVillageMunicipalityCity),
    upazillaCity: ref(props.userAddress?.upazillaCity),
    policeStation: ref(props.userAddress?.policeStation),
    unionMunicipality: ref(props.userAddress?.unionMunicipality),
    wardCouncil: ref(props.userAddress?.wardCouncil),
    villageMohokuma: ref(props.userAddress?.villageMohokuma),
    roadNo: ref(props.userAddress?.roadNo),
    houseNo: ref(props.userAddress?.houseNo),
    otherDetails: ref(props.userAddress?.otherDetails),
});

var usersList = props.users.map(function (a) {
    return {
        id: a.id,
        value: a.id,
        label: a.name + "  ( id: " + a.id + ", email: " + a.email + ")",
        name: a.name,
        email: a.email,
    }
});

function updateUserAddress() {
    form.put(route('usersAddress.update', form.id));
    console.log(form)
    console.log("data updated");
}

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
        <div class="py-4 font-semibold">User's Address</div>
        <!-- src/App.vue -->
        <Vueform v-model="form" :display-errors="false"
                 :endpoint="false"
                 :multilingual="false"
                 size="md" sync
                 @submit='updateUserAddress'
        >
            <SelectElement
                :items="usersList"
                :native="false"
                :rules="['required']"
                :search="true"
                :track-by="['id', 'name', 'email', 'label']"
                autocomplete="disabled"
                input-type="search"
                label="Select User"
                name="user_id"
            />
            <StaticElement
                content="Address Details"
                name="register_title"
                tag="h1"
            />
            <StaticElement
                name="divider"
                tag="hr"
            />
            <GroupElement
                name="container"
            >
                <RadiogroupElement
                    :columns="{
                                  container: 6,
                                  label: 12,
                                  wrapper: 12,
                                }"
                    :items="['Permanent', 'Present']"
                    :rules="['required','max:255']"
                    label="Address Type"
                    name="addressType"
                />
                <RadiogroupElement
                    :columns="{
                                  container: 6,
                                  label: 12,
                                  wrapper: 12,
                                }"
                    :items="['Village', 'Municipality', 'City Corporation']"
                    :rules="['required','max:255']"
                    label="Chose Category"
                    name="typeVillageMunicipalityCity"
                />

                <SelectElement
                    :columns="{
                                  container: 6,
                                  label: 12,
                                  wrapper: 12,
                                }"
                    :items="districts"
                    :native="false"
                    :rules="['required','max:255']"
                    :search="true"
                    :track-by="['name']"
                    autocomplete="disabled"
                    input-type="search"
                    label="District"
                    label-prop="name"
                    name="district"
                    value-prop="name"
                />
                <SelectElement
                    :columns="{
                                  container: 6,
                                  label: 12,
                                  wrapper: 12,
                                }"
                    :items="upazilas"
                    :native="false"
                    :rules="['required','max:255']"
                    :search="true"
                    :track-by="['name']"
                    autocomplete="disabled"
                    input-type="search"
                    label="Upazila / City Corporation"
                    label-prop="name"
                    name="upazillaCity"
                    value-prop="name"
                />
                <SelectElement
                    :columns="{
                                  container: 6,
                                  label: 12,
                                  wrapper: 12,
                                }"
                    :items="unions"
                    :native="false"
                    :rules="['required','max:255']"
                    :search="true"
                    :track-by="['name']"
                    autocomplete="disabled"
                    input-type="search"
                    label="Union / Municipality"
                    label-prop="name"
                    name="unionMunicipality"
                    value-prop="name"
                />
                <TextElement
                    :columns="{
                                  container: 6,
                                  label: 12,
                                  wrapper: 12,
                                }"
                    :rules="['required','max:255']"
                    input-type="text"
                    label="Police Station"
                    name="policeStation"
                />

                <TextElement
                    :columns="{
                                  container: 6,
                                  label: 12,
                                  wrapper: 12,
                                }"
                    :rules="['required','max:255']"
                    input-type="text"
                    label="Ward / Council"
                    name="wardCouncil"
                />
                <TextElement
                    :columns="{
                                  container: 6,
                                  label: 12,
                                  wrapper: 12,
                                }"
                    :rules="['required','max:255']"
                    input-type="text"
                    label="Village / Mohokuma"
                    name="villageMohokuma"
                />
                <TextElement
                    :columns="{
                                  container: 6,
                                  label: 12,
                                  wrapper: 12,
                                }"
                    :rules="['max:255']"
                    input-type="text"
                    label="Road No / Name"
                    name="roadNo"
                />
                <TextElement
                    :columns="{
                                  container: 6,
                                  label: 12,
                                  wrapper: 12,
                                }"
                    :rules="['max:255']"
                    input-type="text"
                    label="House No / Name"
                    name="houseNo"
                />
                <EditorElement editorStyle="height: 320px" name="otherDetails"/>
            </GroupElement>
            <ButtonElement
                :full="true"
                :submits="true"
                button-label="Update Address Data"
                name="submit"
                size="lg"
            />
        </Vueform>
    </Card>
</template>
<style scoped></style>
