<script setup>
import SpatieAdminLayout from "@/Layouts/SpatieAdminLayout.vue";
import {useForm} from "@inertiajs/vue3";
import AdminButton from "@/Components/AdminComponents/Buttons/AdminButton.vue";
import Card from "@/Components/AdminComponents/Cards/Card.vue";
import PageHeader from "@/Components/AdminComponents/Heading/PageHeader.vue";
import TextInput from "@/Components/Default/TextInput.vue";
import InputLabel from "@/Components/Default/InputLabel.vue";
import PrimaryButton from "@/Components/Default/PrimaryButton.vue";
import InputError from "@/Components/Default/InputError.vue";
import {usePermissions} from "@/composables/permissions.js";
import {onMounted, onUpdated} from "vue";

const {hasPermission, showFlash} = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    imagePath: "",
    formalPhoto: "",
    birthDay: "",
    bloodGroup: "",
    primaryPhone: "",
    secondaryPhone: "",
});
defineOptions({layout: SpatieAdminLayout});
</script>

<template>

    <PageHeader text="Create User's Profile" title="User's Profile/Create">
        <AdminButton
            v-if="hasPermission('user.view')"
            button-text="Go Back"
            button-type="backward"
            route-name="usersProfile.index"
        />
    </PageHeader>
    <Card class="mx-auto max-w-150">
        <div class="py-4 font-semibold">User Information</div>
        <form @submit.prevent="form.post(route('users.store',user.id))">
            <div>
                <InputLabel for="user_id" value="Image"/>

                <TextInput
                    id="imagePath"
                    v-model="form.imagePath"
                    type="file"
                    @input="form.imagePath = $event.target.files[0]"
                    required
                />

                <InputError :message="form.errors.imagePath" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="formalPhoto" value="Formal Photo"/>

                <TextInput
                    id="formalPhoto"
                    v-model="form.formalPhoto"
                    type="file"
                    @input="form.formalPhoto = $event.target.files[0]"
                    required
                />

                <InputError :message="form.errors.formalPhoto" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="birthDay" value="Birth Day"/>

                <TextInput
                    id="birthDay"
                    v-model="form.birthDay"
                    autocomplete="birthDay"
                    required
                    type="date"
                />

                <InputError :message="form.errors.birthDay" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="bloodGroup" value="Blood Group"/>

                <Vueform>
                    <SelectElement
                        id="bloodGroup"
                        v-model="form.bloodGroup"
                        :items="[
                           'A (+ve)',
                           'B (+ve)',
                           'AB (+ve)',
                           'O (+ve)',
                           'A (-ve)',
                           'B (-ve)',
                           'AB (-ve)',
                           'O (-ve)',
                          ]"
                        :native="false"
                        autocomplete="bloodGroup"
                        name="bloodGroup"
                        required
                    />
                </Vueform>
                <InputError :message="form.errors.bloodGroup" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="primaryPhone" value="Primary Phone"/>

                <TextInput
                    id="primaryPhone"
                    v-model="form.primaryPhone"
                    autocomplete="primaryPhone"
                    required
                    type="tel"
                />

                <InputError :message="form.errors.primaryPhone" class="mt-2"
                />
            </div>

            <div class="mt-4">
                <InputLabel for="secondaryPhone" value="Secondary Phone"/>

                <TextInput
                    id="secondaryPhone"
                    v-model="form.secondaryPhone"
                    autocomplete="secondaryPhone"
                    required
                    type="tel"
                />

                <InputError :message="form.errors.secondaryPhone" class="mt-2"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    v-if="hasPermission('user.create')"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    class="ms-4"
                >
                    Create
                </PrimaryButton>
            </div>
        </form>
    </Card>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style scoped></style>
