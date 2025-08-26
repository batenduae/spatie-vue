<script setup>
</script>

<template>
    <Toast/>
    <div
        class="min-h-screen w-full sm:justify-center items-center "
    >
        <div
            class="shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
