import { usePage } from "@inertiajs/vue3";
import {push} from "notivue";
import {watch} from "vue";

export function usePermissions() {
    function hasRole(roleArray) {
        let roles = usePage().props.auth.user.roles;
        if (roles.find((role) => roleArray.includes(role.name))) {
            return true;
        } else {
            return false;
        }
    }

    function hasPermission(permissionArray,option) {
        let permits = usePage().props.auth.user.permit;
        option = option || "any";
        // console.log("option",option);

        if(Array.isArray(permissionArray)){
            // console.log("Array Found")
            switch (option) {
                case 'all':
                    // console.log("Option: All Mandatory ")
                    // console.log(permissionArray, permissionArray.every((permission) => permits.includes(permission)))
                    return permissionArray.every((permission) => permits.includes(permission))
                    break;
                default:
                    // console.log("Option: Any")
                    // console.log(permissionArray, permissionArray.find((permission) => permits.includes(permission)))
                    return permissionArray.find((permission) => permits.includes(permission))
            }
        }else{
            // console.log('String Found')
            // console.log(permissionArray, permits.includes(permissionArray))
            return permits.includes(permissionArray)
        }
    }

    function showFlash(){
        let flash = usePage().props.flash
        // console.log(usePage().props.flash)
        if(flash.message){
            push.info({
                title: 'Message',
                message: flash.message
            })
        }
        if(flash.info){
            push.info({
                title: 'Info',
                message: flash.info
            })
        }
        if(flash.success){
            push.success({
                title: 'Success',
                message: flash.success
            })
        }
        if(flash.warning){
            push.warning({
                title: 'Warning',
                message: flash.warning
            })
        }
        if(flash.error){
            push.error({
                title: 'Error',
                message: flash.error
            })
        }
        if(flash.danger){
            push.error({
                title: 'Danger',
                message: flash.danger
            })
        }

    }

    return { hasRole, hasPermission, showFlash };
}



