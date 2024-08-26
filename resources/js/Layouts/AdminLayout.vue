<script setup>
import { Link } from "@inertiajs/vue3";
import SideBarLink from "@/Layouts/Partials/SideBarLink.vue";
import {Notification, Notivue} from "notivue";
</script>

<template>
    <Notivue v-slot="item">
        <Notification :item="item" />
    </Notivue>
    <body class="bg-gray-100 dark:bg-gray-900">
        <aside
            class="fixed top-0 z-10 ml-[-100%] flex h-screen w-full flex-col justify-between border-r bg-white px-6 pb-3 transition duration-300 md:w-4/12 lg:ml-0 lg:w-[25%] xl:w-[20%] 2xl:w-[15%] dark:bg-gray-800 dark:border-gray-700"
        >
            <div>
                <div class="-mx-6 px-6 py-4">Brand Logo</div>
                <ul class="mt-6 space-y-2 tracking-wide">
                    <li>
                        <SideBarLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
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
                                    d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"
                                />
                            </svg>

                            <span class="-mr-1 font-medium">Dashboard</span>
                        </SideBarLink>
                    </li>
                    <li>
                        <SideBarLink
                            :href="route('users.index')"
                            :active="route().current('users.*')"
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
                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"
                                />
                            </svg>
                            <span class="-mr-1 font-medium">Users</span>
                        </SideBarLink>
                    </li>
                    <li>
                        <SideBarLink
                            :href="route('roles.index')"
                            :active="route().current('roles.*')"
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
                                    d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"
                                />
                            </svg>

                            <span class="-mr-1 font-medium">Roles</span>
                        </SideBarLink>
                    </li>
                    <li>
                        <SideBarLink
                            :href="route('permissions.index')"
                            :active="route().current('permissions.*')"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0 1 19.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 0 0 4.5 10.5a7.464 7.464 0 0 1-1.15 3.993m1.989 3.559A11.209 11.209 0 0 0 8.25 10.5a3.75 3.75 0 1 1 7.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 0 1-3.6 9.75m6.633-4.596a18.666 18.666 0 0 1-2.485 5.33"/>
                            </svg>
                            <span class="-mr-1 font-medium">Permissions</span>
                        </SideBarLink>

                    </li>
                    <li>
                        <SideBarLink
                            :href="route('posts.index')"
                            :active="route().current('posts.*')"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                            <span class="-mr-1 font-medium">Posts</span>
                        </SideBarLink>

                    </li>
                </ul>
            </div>

            <div
                class="-mx-6 flex items-center justify-between border-t px-6 pt-4 dark:border-gray-700"
            >
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
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
                        class="group-hover:text-red-700 dark:group-hover:text-red-500"
                        >Logout</span
                    >
                </Link>
            </div>
        </aside>
        <!--    TopBar-->
        <div
            class="ml-auto lg:w-[75%] xl:w-[80%] 2xl:w-[85%] h-screen flex flex-col"
        >
            <div
                class="sticky top-0 z-20 h-16 border-b bg-white dark:bg-gray-800 dark:border-gray-700 lg:py-2.5"
            >
                <div
                    class="flex items-center justify-between space-x-4 px-6 2xl:container"
                >
                    <h5
                        hidden
                        class="text-2xl font-medium text-gray-600 lg:block dark:text-white"
                    >
                        User: {{ $page.props.auth.user.name }}, Email:
                        {{ $page.props.auth.user.email }}
                    </h5>
                    <button
                        class="-mr-2 h-16 w-12 border-r lg:hidden dark:border-gray-700 dark:text-gray-300"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="my-auto h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                    </button>
                    <div class="flex space-x-4">
                        <!--search bar -->
                        <div hidden class="md:block">
                            <div
                                class="relative flex items-center text-gray-400 focus-within:text-cyan-400"
                            >
                                <span
                                    class="absolute left-4 flex h-6 items-center border-r border-gray-300 pr-3 dark:border-gray-700"
                                >
                                    <svg
                                        xmlns="http://ww50w3.org/2000/svg"
                                        class="w-4 fill-current"
                                        viewBox="0 0 35.997 36.004"
                                    >
                                        <path
                                            id="Icon_awesome-search"
                                            data-name="search"
                                            d="M35.508,31.127l-7.01-7.01a1.686,1.686,0,0,0-1.2-.492H26.156a14.618,14.618,0,1,0-2.531,2.531V27.3a1.686,1.686,0,0,0,.492,1.2l7.01,7.01a1.681,1.681,0,0,0,2.384,0l1.99-1.99a1.7,1.7,0,0,0,.007-2.391Zm-20.883-7.5a9,9,0,1,1,9-9A8.995,8.995,0,0,1,14.625,23.625Z"
                                        ></path>
                                    </svg>
                                </span>
                                <input
                                    type="search"
                                    name="leadingIcon"
                                    id="leadingIcon"
                                    placeholder="Search here"
                                    class="outline-none w-full rounded-xl border border-gray-300 py-2.5 pl-14 pr-4 text-sm text-gray-600 transition focus:border-cyan-300 dark:bg-gray-900 dark:border-gray-700"
                                />
                            </div>
                        </div>
                        <!--/search bar -->
                        <button
                            aria-label="search"
                            class="h-10 w-10 rounded-xl border bg-gray-100 active:bg-gray-200 md:hidden dark:bg-gray-700 dark:border-gray-600 dark:active:bg-gray-800"
                        >
                            <svg
                                xmlns="http://ww50w3.org/2000/svg"
                                class="mx-auto w-4 fill-current text-gray-600 dark:text-gray-300"
                                viewBox="0 0 35.997 36.004"
                            >
                                <path
                                    id="Icon_awesome-search"
                                    data-name="search"
                                    d="M35.508,31.127l-7.01-7.01a1.686,1.686,0,0,0-1.2-.492H26.156a14.618,14.618,0,1,0-2.531,2.531V27.3a1.686,1.686,0,0,0,.492,1.2l7.01,7.01a1.681,1.681,0,0,0,2.384,0l1.99-1.99a1.7,1.7,0,0,0,.007-2.391Zm-20.883-7.5a9,9,0,1,1,9-9A8.995,8.995,0,0,1,14.625,23.625Z"
                                ></path>
                            </svg>
                        </button>
                        <button
                            aria-label="chat"
                            class="h-10 w-10 rounded-xl border bg-gray-100 active:bg-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:active:bg-gray-800"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="m-auto h-5 w-5 text-gray-600 dark:text-gray-300"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"
                                />
                            </svg>
                        </button>
                        <button
                            aria-label="notification"
                            class="h-10 w-10 rounded-xl border bg-gray-100 active:bg-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:active:bg-gray-800"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="m-auto h-5 w-5 text-gray-600 dark:text-gray-300"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex-1 px-4 pt-6 bg-violet-950 overflow-x-auto">
                <slot />
            </div>
        </div>
    </body>
</template>

<style scoped></style>
