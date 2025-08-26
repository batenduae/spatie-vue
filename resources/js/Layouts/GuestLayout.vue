<script setup>
</script>

<template>
    <Toast/>
    <div class="min-h-screen flex flex-col sm:justify-center items-center sm:pt-0 bg-gray-100 mx-auto">
        <div
            class="w-full mx-auto mt-6 px-6 py-4 bg-white overflow-hidden sm:rounded-lg"
        >
            <slot/>
        </div>
    </div>
</template>
