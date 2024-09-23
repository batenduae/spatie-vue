<script setup lang="ts">
import {Notification, NotificationProgress, Notivue, outlinedIcons, pastelTheme} from "notivue";
import SidebarArea from "@/Components/AdminComponents/SideBar/SidebarArea.vue";
import HeaderArea from "@/Components/AdminComponents/Header/HeaderArea.vue";
import {usePermissions} from "@/composables/permissions.js";
import {onMounted} from "vue";
const { hasPermission, showFlash} = usePermissions();
onMounted(showFlash)
</script>

<template>
    <div class="">
        <Notivue v-slot="item">
            <Notification
                          :item="item"
                          :icons="outlinedIcons"
                          :theme="pastelTheme"
            >
                <NotificationProgress :item="item" />
            </Notification>
        </Notivue>
    </div>
    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden text-black dark:text-white">
                <!-- ===== Sidebar Start ===== -->
        <SidebarArea/>
        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div class="relative w-full flex flex-col overflow-y-auto no-scrollbar overflow-x-hidden">
            <!-- ===== Header Start ===== -->
            <HeaderArea />
            <!-- ===== Header End ===== -->

            <!-- ===== Main Content Start ===== -->
            <main class="w-full flex-1 bg-violet-900 bgImage dark:bg-boxdark-2 ">
                <div class="items-center p-4 md:p-6 2xl:p-10">
                    <slot></slot>
                </div>
            </main>
            <!-- ===== Main Content End ===== -->
        </div>
    </div>
    <!-- ===== Page Wrapper End ===== -->
</template>
<style>
:root {
    /* Your variables */
    --nv-gap: 1rem;
    --nv-z: 9999999;
}

/* Rules for mobile devices */
@media (max-width: 768px) {
    :root {
        --nv-root-x-align: center;
        --nv-gap: 0.5rem;
    }
}


.bgImage {
    background: #ffffff url(https://ibas.finance.gov.bd/acs/assets/img/bg_main.gif);
}

</style>
