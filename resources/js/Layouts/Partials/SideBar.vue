<script setup>
import { Link } from "@inertiajs/vue3";
import SideBarNav from "@/Layouts/Partials/SideBarNav.vue";
</script>

<template>
    <aside
        class="fixed top-0 z-10 ml-[-100%] flex h-screen w-full flex-col justify-between border-r bg-white px-6 pb-3 transition duration-300 md:w-4/12 lg:ml-0 lg:w-[25%] xl:w-[20%] 2xl:w-[15%] dark:bg-gray-800 dark:border-gray-700"
    >
        <div>
            <div class="-mx-6 px-6 py-4">Brand Logo</div>
            <SideBarNav></SideBarNav>
        </div>

        <div
            class="-mx-6 flex items-center justify-between border-t px-6 pt-4 dark:border-gray-700"
        >
            <Link
                :href="route('logout')"
                method="post"
                class="group flex items-center space-x-4 rounded-md px-4 py-3 text-gray-600 dark:text-gray-300"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"
                    />
                </svg>

                <span
                    class="group-hover:text-gray-700 dark:group-hover:text-white"
                    >Logout</span
                >
            </Link>
        </div>
    </aside>
</template>

<style scoped></style>
