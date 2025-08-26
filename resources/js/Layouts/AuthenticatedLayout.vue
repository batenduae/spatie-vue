<script setup>
import {ref} from "vue";
import ApplicationLogo from "@/Components/Default/ApplicationLogo.vue";
import Dropdown from "@/Components/Default/Dropdown.vue";
import DropdownLink from "@/Components/Default/DropdownLink.vue";
import NavLink from "@/Components/Default/NavLink.vue";
import ResponsiveNavLink from "@/Components/Default/ResponsiveNavLink.vue";
import {Link} from "@inertiajs/vue3";
import {usePermissions} from "@/composables/permissions.js";
import {Notification, NotificationProgress, Notivue, outlinedIcons, pastelTheme} from "notivue";
import DarkModeSwitcher from "@/Components/TailAdmin/Header/DarkModeSwitcher.vue";
import LeftSideDrawer from "@/Components/PrimevueComponents/LeftSideDrawer.vue";

const showingNavigationDropdown = ref(false);
const {hasRole, hasPermission} = usePermissions();
</script>

<template>
    <div class="">
        <Toast/>
        <Notivue v-slot="item">
            <Notification
                :icons="outlinedIcons"
                :item="item"
                :theme="pastelTheme"
            >
                <NotificationProgress :item="item"/>
            </Notification>
        </Notivue>
        <div class="min-h-screen bgImage text-black dark:text-white">
            <!-- top-banner-->
            <div class="bg-indigo-800 dark:bg-indigo-800">
                <Message class="h-20 bg-indigo-800 dark:bg-indigo-800 items-center"
                         closable
                >
                    <div class="my-auto flex items-center justify-center gap-x-1 md:gap-x-2" role="button">
                        <img
                            alt="banner icon"
                            class="max-w-20 w-auto  max-h-20 h-auto  md:max-w-20 md:max-h-20 "
                            src="https://res.cloudinary.com/cross-border-education-technologies-pte-ltd/image/upload/v1732684015/Web-Portal/brandmark_1_sujlse.png">
                        <span class="my-auto text-center font-bangla md:mt-2">
                            <span class="text-[14px] font-medium leading-[160%]  underline md:text-[18px]"
                                  style="color:#FFFFFF">নিয়ে এলো Shikho স্টুডেন্টদের জন্যে<!-- --> </span>
                            <span class="text-[14px] font-bold leading-[160%]  underline md:text-[18px]"
                                  style="color:#FFF22E">১০ GB ইন্টারনেট মাত্র ১৯৬ টাকায়!</span>
                        </span>
                    </div>
                </Message>
            </div>
            <nav class="h-20 border-b bg-white dark:bg-boxdark-2 text-black dark:text-white border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">

                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    User Dashboard
                                </NavLink>
                                <NavLink
                                    :href="route('admin.index')"
                                    :active="route().current('admin.index')"
                                >
                                    Admin Dashboard
                                </NavLink>

                            </div>
                        </div>

                        <div class="flex ">
                            <div
                                class="my-auto mr-0"
                            >
                                <!-- Dark Mode Toggler -->
                                <DarkModeSwitcher/>
                                <!-- Dark Mode Toggle r -->
                            </div>
                            <!-- Settings Dropdown -->
                            <div class="hidden sm:flex sm:items-center sm:ms-6 text-black ">
                                <!-- Settings Dropdown -->
                                <div class="ms-3 relative">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium
                                                rounded-md hover:text-gray-700 focus:outline-none transition ease-in-out duration-150
                                                bg-teal-800 dark:bg-green-700"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                        </template>

                                        <template #content>
                                            <DropdownLink
                                                :href="route('profile.edit')"
                                            >
                                                Profile
                                            </DropdownLink>
                                            <DropdownLink
                                                :href="route('logout')"
                                                as="button"
                                                method="post"
                                            >
                                                Log Out
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>

                            <!-- Left Side Drawer -->
                            <div class="-me-2 flex items-center sm:hidden">
                                <LeftSideDrawer/>
                            </div>

                            <!-- Hamburger -->
                            <div class="-me-2 flex items-center sm:hidden">
                                <button
                                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                                    @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                >
                                    <svg
                                        class="h-6 w-6"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                            d="M4 6h16M4 12h16M4 18h16"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                        />
                                        <path
                                            :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                            d="M6 18L18 6M6 6l12 12"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                        />
                                    </svg>
                                </button>
                            </div>

                        </div>

                    </div>
                </div>


                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden bg-indigo-600 h-screen"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('admin.index')"
                            :active="route().current('admin.index')"
                        >
                            Admin
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="">
                <slot />
            </main>
        </div>
    </div>
</template>

<style>
.bgImage {
    background: #ffffff url(https://ibas.finance.gov.bd/acs/assets/img/bg_main.gif);
}
</style>
