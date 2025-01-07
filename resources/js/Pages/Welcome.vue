<script setup>
import {Head, Link} from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Login from "@/Components/AdminComponents/DataTable/Primevue/Login.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById("screenshot-container")?.classList.add("!hidden");
    document.getElementById("docs-card")?.classList.add("!row-span-1");
    document.getElementById("docs-card-content")?.classList.add("!flex-row");
    document.getElementById("background")?.classList.add("!hidden");
}
defineOptions({ layout: GuestLayout });
</script>

<template>
    <Head title="Welcome" />
    <div
        class="w-full mx-auto bg-gray-50 text-black/50 dark:bg-black dark:text-white/50"
    >
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg"
        />
        <div
            class="absolute top-0 flex selection:bg-[#FF2D20] selection:text-white"
        >
            <Login></Login>
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                Dashboard
            </Link>
        </div>
    </div>
</template>
