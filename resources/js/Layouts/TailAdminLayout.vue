<script setup lang="ts">
import HeaderArea from "@/Components/TailAdmin/Header/HeaderArea.vue"
import SidebarArea from "@/Components/TailAdmin/Sidebar/SidebarArea.vue"
</script>

<template>
    <Toast/>
    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
        <!-- ===== Sidebar Start ===== -->
        <SidebarArea />
        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div class="relative w-full flex flex-col overflow-y-auto overflow-x-hidden">
            <!-- ===== Header Start ===== -->
            <HeaderArea />
            <!-- ===== Header End ===== -->

            <!-- ===== Main Content Start ===== -->
            <main class="flex flex-1">
                <div class="mx-auto p-4 md:p-6 2xl:p-10">
                    <slot></slot>
                </div>
            </main>
            <!-- ===== Main Content End ===== -->
        </div>
    </div>
    <!-- ===== Page Wrapper End ===== -->
</template>
