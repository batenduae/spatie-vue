<script setup>
import {computed} from "vue";

const props = defineProps({
    narrow: {
        type: [String, Boolean]
    },
})
let className = '';

function defineClass() {
    switch (props.narrow) {
        case 'narrower':
            className = "w-12";
            break;
        case 'narrow':
            className = "w-24";
            break;
        case 'shallows':
            className = "w-36";
            break;
        case 'standard':
            className = "w-48";
            break;
        default:
            className = "w-16";
    }
    return className;
}

computed(
    className = defineClass(),
)
</script>

<template>
    <td
        :class="[
            'px-2 py-3 items-center text-center align-middle space-x-2 border border-slate-300 dark:border-slate-600 transition ease-in-out duration-300',
             (props.narrow ? className : ''),

        ]">
        <slot/>
    </td>
</template>

<style scoped>

</style>
