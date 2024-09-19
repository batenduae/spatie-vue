<script setup>
import {computed, ref} from "vue";

const props = defineProps({
        type: {
            type: String,
            default: "orange"
        }
    })
let className = ref('')

function defineClass(){
    switch(props.type){
        case 'green':
            className = "from-green-600 to-indigo-500"
            break;
        case 'orange':
            className = "from-purple-600 to-amber-200"
            break;
        case 'cyan':
            className = "from-slate-300 to-cyan-200"
            break;
        default:
            className = ""
    }
    return className
}

computed(
 className = defineClass()
)
</script>

<template>
        <div
            :class="className"
            class="mx-auto mb-4 p-4 min-w-96 rounded-lg shadow-lg drop-shadow
            shadow-blue-500/50 bg-gradient-to-bl text-black dark:text-stone-200"
        >
            <slot/>
        </div>
</template>

<style scoped>

</style>
