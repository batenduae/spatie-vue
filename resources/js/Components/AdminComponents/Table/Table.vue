<script setup>
</script>

<template>
    <div class="relative rounded-lg overflow-x-auto narrow-scrollbar">
        <table
            class="mx-auto w-full min-w-80 mb-4 text-sm text-left
         bg-neutral-200 dark:bg-neutral-800 text-black dark:text-slate-300
         shadow-lg drop-shadow shadow-blue-500/50 rounded-lg"
        >
            <thead
                class="text-xs uppercase bg-indigo-200 dark:bg-indigo-900 shadow-md shadow-slate-300 dark:shadow-indigo-500"
            >
            <slot name="tableHeader"></slot>
            </thead>
            <tbody>
            <slot />
            </tbody>
        </table>
    </div>
</template>

<style scoped></style>
