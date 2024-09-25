import {usePage} from "@inertiajs/vue3";
import {push} from "notivue";

export function usePermissions() {
    // function hasRole(roleArray) {
    //     let roles = usePage().props.auth.user.roles;
    //     return !!roles.find((role) => roleArray.includes(role.name));
    // }

    function hasRole(rolesArray, option) {
        let assignedRoles = usePage().props.auth.user.roles;
        option = option || "any";
        // console.log("option",option);

        if (Array.isArray(rolesArray)) {
            console.log("Array Found")
            switch (option) {
                case 'all':
                    // console.log("Option: All Mandatory ")
                    // console.log(rolesArray, rolesArray.every((role) => assignedRoles.includes(role)))
                    return rolesArray.every((role) => assignedRoles.includes(role))
                    break;
                default:
                    // console.log("Option: Any")
                    // console.log(rolesArray, rolesArray.find((role) => assignedRoles.includes(role)))
                    return rolesArray.find((role) => assignedRoles.includes(role))
            }
        } else {
            console.log('String Found')
            console.log(rolesArray, assignedRoles.includes(rolesArray))
            console.log(rolesArray, assignedRoles)
            return assignedRoles.includes(rolesArray)
        }
    }

    function hasPermission(permissionArray, option) {
        let permits = usePage().props.auth.user.permit;
        option = option || "any";
        // console.log("option",option);

        if (Array.isArray(permissionArray)) {
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



