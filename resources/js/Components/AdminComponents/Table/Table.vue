<script setup>
</script>

<template>

    <div class="relative rounded-lg overflow-x-auto narrow-scrollbar">

        <table
            class="mx-auto mb-4 w-full min-w-80
         bg-neutral-200 dark:bg-neutral-800 rounded-lg
         text-sm text-left text-black dark:text-white
         shadow-lg drop-shadow shadow-blue-500/50
         border-collapse"
        >
            <caption class="caption-top bg-slate-400 dark:bg-slate-700">
                <slot name="caption"/>
            </caption>

            <thead
                class="text-xs uppercase bg-indigo-300 dark:bg-indigo-900 shadow-md shadow-slate-300 dark:shadow-indigo-500"
            >
            <slot name="tableHeader"></slot>
            </thead>
            <tbody class="">
            <slot/>
            </tbody>

        </table>

    </div>

</template>

<style scoped></style>
