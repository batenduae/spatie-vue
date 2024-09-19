<script setup></script>

<template>
    <table
        class="mx-auto overflow-x-auto min-w-80 mb-4 text-sm text-left text-gray-500 dark:text-gray-400 rounded-lg shadow-lg drop-shadow shadow-blue-500/50"
    >
        <thead
            class="text-xs text-white uppercase bg-neutral-800 dark:bg-gray-700 rounded-t-lg"
        >
            <slot name="tableHeader"></slot>
        </thead>
        <tbody class="bg-transparent dark:bg-black">
            <slot />
        </tbody>
    </table>
</template>

<style scoped></style>
