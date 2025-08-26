<script setup>

import Login from "@/Pages/Auth/Login.vue";
import HomeMenuBar from "@/Pages/Home/HomeMenuBar.vue";
import HomeMegaMenu from "@/Pages/Home/HomeMegaMenu.vue";
</script>

<template>
    <div class="">
        <HomeMenuBar></HomeMenuBar>
        <HomeMegaMenu></HomeMegaMenu>
        <div class="bg-indigo-50">
            <div class="text-3xl text-center p-5">
                This is My Super Website
                <div class="">Here I provide various Feature</div>
                <div class="">It is a Mother Website</div>
            </div>
        </div>
        <div class="">

        </div>
    </div>
    <slot></slot>
</template>

<style scoped>

</style>
