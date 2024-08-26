<script setup></script>

<template>
    <div class="relative mb-4 overflow-x-auto rounded-lg min-w-80 shadow-lg drop-shadow shadow-blue-500/50">
        <table
            class="w-full mx-auto text-sm text-left text-gray-500 dark:text-gray-400"
        >
            <thead
                class="text-xs text-white uppercase bg-gray-50 dark:bg-gray-700"
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
