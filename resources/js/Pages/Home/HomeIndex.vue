<script setup>

import HomeMenuBar from "@/Pages/Home/HomeMenuBar.vue";
import HomeMegaMenu from "@/Pages/Home/HomeMegaMenu.vue";
import BlogIndex from "../../../../Modules/Blog/resources/js/Pages/BlogIndex.vue";
</script>

<template>
    <div class="h-screen">
        <!--        <HomeMenuBar></HomeMenuBar>-->
        <HomeMegaMenu></HomeMegaMenu>
        <div class="bg-indigo-50">
            <div class="text-3xl text-center p-5">
                This is My Super Website
                <div class="">Here I provide various Feature</div>
                <div class="">It is a Mother Website</div>
            </div>
        </div>


        <!--        <div class="">-->
        <!--            <BlogIndex></BlogIndex>-->
        <!--        </div>-->
    </div>
    <slot></slot>
</template>

<style scoped>

</style>
