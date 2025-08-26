<script setup lang="ts">
import {Notification, NotificationProgress, Notivue, outlinedIcons, pastelTheme} from "notivue";
import Toast from 'primevue/toast';
import SidebarArea from "@/Components/AdminComponents/SideBar/SidebarArea.vue";
import HeaderArea from "@/Components/AdminComponents/Header/HeaderArea.vue";
import {usePermissions} from "@/composables/permissions.js";
import {onMounted} from "vue";

const { hasPermission, showFlash} = usePermissions();
onMounted(showFlash)
</script>

<template>
    <div class="">
        <Toast/>
        <Notivue v-slot="item">
            <Notification
                          :item="item"
                          :icons="outlinedIcons"
                          :theme="pastelTheme"
            >
                <NotificationProgress :item="item" />
            </Notification>
        </Notivue>
        <Toast position="bottom-right"/>
    </div>
    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden bg-white dark:bg-boxdark-2 text-black dark:text-white">
        <!-- ===== Sidebar Start ===== -->
        <SidebarArea/>
        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div class="relative w-full flex flex-col overflow-y-auto no-scrollbar overflow-x-hidden">
            <!-- ===== Header Start ===== -->
            <HeaderArea/>
            <!-- ===== Header End ===== -->

            <!-- ===== Main Content Start ===== -->
            <main class="w-full flex-1 bgImage dark:bg-boxdark-2 ">
                <ScrollPanel style="height: 93vh">
                    <div class="items-center p-4 md:p-6 2xl:p-10 duration-300 ease-linear">
                        <slot></slot>
                    </div>
                    <ScrollTop :buttonProps="{ severity: 'danger', raised: true, rounded: true }" :threshold="100"
                               behavior="smooth"
                               icon="pi pi-arrow-up" target="parent"/>
                </ScrollPanel>
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

.bgImageDark {
    background: #010101 url(https://img.freepik.com/free-vector/floral-ornamental-abstract-background_23-2148355961.jpg?w=740&t=st=1661002853~exp=1661003453~hmac=ee258d6ed697bb65c58b484f0552fea07bb87ea53667d4eecaa051869b3dd185);
}
</style>
