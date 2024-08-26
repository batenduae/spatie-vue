<script setup>
import {Link} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import Swal from 'sweetalert2'


const props = defineProps({
    obj: {
        type: [String, Object],
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
        default: 'Buttons'
    },
    text: {
        type: String,
        default: 'Permit'
    },
})
let className = ref('')
function defineClass(){
    switch(props.buttonType) {
        case 'create':
            className = "px-4 py-2 text-white bg-indigo-500 hover:bg-indigo-700 hover:shadow-lg hover:drop-shadow hover:shadow-blue-500/50";
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
            className = "text-xs from-red-500 to-amber-500";
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
            default:
                btnText = "Buttons";
        }
    }
    return btnText
}
let deleteBtn = ref(false)
computed(
   className = defineClass(),
    btnText = definebtnText(),
    deleteBtn = props.buttonType=='deleteOnConfirm'
)

const form = useForm({})
function alertNow(props){
    Swal.fire({
        title: "Are you sure?",
        text: props.text+": '"+props.obj.name+"' will be deleted permanently ",
        icon: "danger",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route(props.routeName, props.obj))
            Swal.fire({
                title: "Deleted!",
                text: props.text+": '"+props.obj.name+" has been deleted.",
                icon: "success"
            });
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
            class="px-2 rounded-lg text-black font-bold bg-gradient-to-br"
            :class="className"
            preserve-scroll
        >
            {{ btnText }}
        </Link>
    </template>
    <template v-else>
        <button
            @click.prevent="alertNow(props)"
            class="px-2 rounded-lg text-black font-bold bg-gradient-to-br"
            :class="className"
            preserve-scroll
        >
            {{ btnText }}
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
