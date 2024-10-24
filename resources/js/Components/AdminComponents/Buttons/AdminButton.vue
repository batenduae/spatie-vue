<script setup>
import {Link, useForm} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import Swal from 'sweetalert2'
import {push} from "notivue";


const props = defineProps({
    obj: {
        type: [String, Object, Number],
    },
    routeName: {
        type: String,
    },
    routeMethod:{
        type: String,
    },
    buttonType:{
        type: String,
        default: 'Submit'
    },
    buttonText:{
        type: String,
        default: ''
    },
    text: {
        type: [String, Object],
        default: 'Permit'
    },
    property: {
        type: String,
        default: 'name'
    },
})
let className = ref('')
function defineClass(){
    switch(props.buttonType) {
        case 'create':
            className = "px-4 py-2 bg-indigo-500 hover:bg-indigo-700 hover:shadow-lg hover:drop-shadow hover:shadow-blue-500/50";
            break;
        case 'edit':
            className = "text-xs  from-purple-500 to-teal-500 ";
            break;
        case 'update':
            className = "from-purple-500 to-teal-500";
            break;
        case 'delete':
            className = "text-xs from-red-400 to-red-600";
            break;
        case 'deleteOnConfirm':
            className = "text-xs from-red-500 to-amber-700";
            break;
        case 'deleteOnConfirm1':
            className = "";
            break;
        case 'submit':
            className = "text-xs from-red-500 to-amber-500";
            break;
        case 'forward':
            className = "text-xs from-purple-500 to-teal-500";
            break;
        case 'backward':
            className = "px-4 py-2 bg-fuchsia-500 hover:bg-fuchsia-700 hover:shadow-lg hover:drop-shadow hover:shadow-blue-500/50";
            break;
        case 'cancel':
            className = "from-purple-500 to-teal-500";
            break;
        case 'assign':
            className = "text-xs from-green-500 to-blue-500";
            break;
        case 'login':
            className = "text-xs from-fuchsia-500 to-indigo-500";
            break;
        default:
            className = "text-xs";
    }
    return className
}

let btnText = ref('')
function definebtnText(){
    if(props.buttonText){
        btnText = props.buttonText;
    }else{
        switch(props.buttonType) {
            case 'create':
                btnText = "Create";
                break;
            case 'edit':
                btnText = "Edit";
                break;
            case 'update':
                btnText = "Update";
                break;
            case 'delete':
                btnText = "Delete";
                break;
            case 'deleteOnConfirm':
                btnText = "Delete After Confirm";
                break;
            case 'deleteOnConfirm1':
                btnText = "Delete After Confirm";
                break;
            case 'submit':
                btnText = "Submit";
                break;
            case 'forward':
                btnText = "Go Forward";
                break;
            case 'backward':
                btnText = "Go Back";
                break;
            case 'cancel':
                btnText = "Cancel";
                break;
            case 'assign':
                btnText = "Assign";
                break;
            case 'button':
                btnText = "Button";
                break;
            default:
                btnText = "";
        }
    }
    return btnText
}
let deleteBtn = ref(false)
computed(
   className = defineClass(),
    btnText = definebtnText(),
    deleteBtn = props.buttonType === 'deleteOnConfirm' || props.buttonType === 'deleteOnConfirm1'
)

const form = useForm({})
function alertNow(props){
    let text0 = "";
    let text1 = "";
    let swalText = "";
    let swalTextConfirmed = "";
    let errorText = "";
    let warningText = "";
    // console.log()
    if(props.obj.length>1) {
        text0 = props.text[0];
        text1 = props.text[1];
        // console.log('Obj length',props.obj.length,props.obj)
        swalText = text1 + ": '" + props.obj[1][props.property] + "' will be deleted permanently for " + text0 + " '" + props.obj[0][props.property] + "'";
        swalTextConfirmed = text1 + ": '" + props.obj[1][props.property] + "' has been deleted for " + text0 + " '" + props.obj[0][props.property] + "'";
        errorText = text1 + ": '" + props.obj[1][props.property] + "' deleting confirmed for " + text0 + " '" + props.obj[0][props.property] + "'";
        warningText = text1 + ": '" + props.obj[1][props.property] + "' deleting cancelled for " + text0 + " '" + props.obj[0][props.property] + "'";
        // console.log(swalText)
        // console.log(swalTextConfirmed)
        // console.log(errorText)
        // console.log(warningText)
    }else {
        text1 = props.text;
        swalText = text1 + ": '" + props.obj[props.property] + "' will be deleted permanently.";
        swalTextConfirmed = text1 + ": '" + props.obj[props.property] + "' has been deleted.";
        errorText = text1 + ": '" + props.obj[props.property] + "' deleting confirmed.";
        warningText = text1 + ": '" + props.obj[props.property] + "' deleting cancelled.";
        // console.log(swalText)
        // console.log(swalTextConfirmed)
        // console.log(errorText)
        // console.log(warningText)
    }

    Swal.fire({
        title: "Are you sure?",
        text: swalText,
        icon: "error",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route(props.routeName, props.obj))
            Swal.fire({
                title: "Deleted!",
                text: swalTextConfirmed,
                icon: "success"
            });
            push.error(errorText)
        }else{
            push.warning(warningText)
        }
    });
}

</script>
<template>
    <template v-if="!deleteBtn">
        <Link
            :href="route(routeName, obj)"
            :method="routeMethod"
            as="button"
            class="rounded-lg text-black dark:text-white font-bold bg-gradient-to-br px-2"
            :class="className"
            preserve-scroll
        >
            <template v-if="props.buttonText">
                {{ btnText }}
            </template>
            <slot></slot>
        </Link>
    </template>
    <template v-else>
        <button
            @click.prevent="alertNow(props)"
            class="rounded-lg text-black dark:text-white font-bold bg-gradient-to-br px-2"
            :class="className"
        >
            <template v-if="props.buttonText">
                {{ btnText }}
            </template>
            <slot></slot>
        </button>
    </template>
</template>


<style scoped>

</style>

<!--<AdminButton-->
<!--    button-text="Delete"-->
<!--    button-type="deleteOnConfirm"-->
<!--    route-method="delete"-->
<!--    route-name="users.destroy"-->
<!--    :obj="user"-->
<!--    text="User"-->
<!--/>-->
