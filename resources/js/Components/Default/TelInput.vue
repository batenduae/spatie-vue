<script setup>
import {onMounted, ref} from 'vue';

const model = defineModel({
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({focus: () => input.value.focus()});
</script>

<template>
    <input
        ref="input"

        v-model="model"
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm
                mt-1 block w-full bg-purple-200 dark:bg-boxdark-2 text-black dark:text-white"
        pattern="[0-9]{5}-[0-9]{6}"
        type="tel"
    />
</template>
