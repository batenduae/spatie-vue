<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import {usePermissions} from "@/composables/permissions.js";
import {onMounted, onUpdated} from "vue";

const {hasPermission, hasRole, showFlash} = usePermissions();
onMounted(showFlash)
onUpdated(showFlash)
defineOptions({layout: AuthenticatedLayout});
</script>

<template>
    <Head title="Dashboard"/>
    <div class="text-center  bg-white dark:bg-boxdark-2 text-black dark:text-white">

        <section
            class=" h-[478px] w-full bg-cover bg-center bg-no-repeat sm:h-[500px] md:mt-[-22px] lg:h-[630px] bg-[url('https://res.cloudinary.com/cross-border-education-technologies-pte-ltd/image/upload/v1721890721/Shikho%20Website%20V3/Shikho%20New%20Hero%20Image%20-%20July%202024/mobile_responsive_punqka.png')] lg:bg-[url('https://res.cloudinary.com/cross-border-education-technologies-pte-ltd/image/upload/v1721890721/Shikho%20Website%20V3/Shikho%20New%20Hero%20Image%20-%20July%202024/desktop_version_sn7dpn.png')]">
            <div class="mx-auto w-full max-w-[1280px] px-4 sm:px-6 lg:h-full lg:px-8">
                <div class="grid w-full grid-cols-12 lg:h-full ">
                    <div class=" col-span-12 pt-[60px] md:col-span-7 md:pt-[90px] lg:pt-[120px]">
                        <h1 class="hero_Home_h1 ">একাডেমিক থেকে এডমিশন</h1>
                        <p class="hero_Home_p pt-2 font-baloo-da">প্রস্তুতি নাও দেশ সেরা শিক্ষক ও প্রযুক্তির সাথে</p>
                        <div class="grid items-center gap-[20px] pt-[32px] md:flex">
                            <button
                                class="group flex item-center  justify-center  cursor-pointer  bg-[#CF278D] text-white pink_hover_1 px-8 py-[14px] font-medium md:text-base  text-[14px] leading-[160%] rounded-[12px]   flex w-full items-center gap-x-3 md:w-auto font-bangla ">
                                <!-- -->একাডেমিক প্রোগ্রাম দেখো
                            </button>
                            <button
                                class="group flex item-center  justify-center  cursor-pointer  text-[#CF278D] border border-1 !border-[#CF278D] bg-white !hover:bg-[#C0187E] pink_hover_1 !hover:text-white  px-8 py-[14px] font-medium md:text-base  text-[14px] leading-[160%] rounded-[12px]  flex w-full items-center gap-x-3 md:w-auto font-bangla ">
                                <span class=" pr-2 my-auto"><svg
                                    class="fill-[#CF278D] stroke-[#CF278D] group-hover:fill-white group-hover:stroke-white group-hover:text-white"
                                    fill="none" height="20" viewBox="0 0 20 20" width="20"
                                    xmlns="http://www.w3.org/2000/svg"><path
                                    d="M2.375 16.8901V3.10928L9.44012 10L2.375 16.8901Z"></path><path
                                    d="M11.1403 8.36792L5.4534 2.93013L12.6699 6.90597L11.1403 8.36792Z"></path><path
                                    d="M12.67 13.0939L5.45358 17.07L11.1403 11.6313L12.67 13.0939Z"></path><path
                                    d="M12.8469 9.99982L14.8356 8.09702L17.3122 9.46097C17.3123 9.46102 17.3124 9.46108 17.3125 9.46113C17.7292 9.6917 17.7292 10.3082 17.3124 10.5387C17.3123 10.5387 17.3123 10.5388 17.3122 10.5388L14.8356 11.9017L12.8469 9.99982Z"></path></svg></span>শিখতে
                                শুরু করো
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>
</template>
