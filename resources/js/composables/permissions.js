import {usePage} from "@inertiajs/vue3";
import {push} from "notivue";

export function usePermissions() {
    // function hasRole(roleArray) {
    //     let roles = usePage().props.auth.user.roles;
    //     return !!roles.find((role) => roleArray.includes(role.name));
    // }

    function hasRole(rolesArray, option) {
        let assignedRoles = usePage().props.auth.user?.assignedRoles;
        option = option || "any";
        // console.log("option",option);
        // console.log('roles',usePage().props.auth.user.assignedRoles)
        // console.log('Roles',usePage().props.auth.user.assignedRoles.flat())

        if (Array.isArray(rolesArray)) {
            assignedRoles = assignedRoles.flat();
            // console.log("Array Found")
            switch (option) {
                case 'exact':
                    // console.log(rolesArray,assignedRoles,JSON.stringify(rolesArray.sort()) == JSON.stringify(assignedRoles.sort()))
                    return (JSON.stringify(rolesArray.sort()) === JSON.stringify(assignedRoles.sort()))
                    break;
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
            // console.log('String Found')
            // console.log(rolesArray, assignedRoles.includes(rolesArray))
            // console.log(rolesArray, assignedRoles)
            return assignedRoles.includes(rolesArray)
        }
    }

    function hasPermissionSelf(permissionArray, userId, option) {
        if (usePage().props.auth.user.id === userId) {
            return hasPermission(permissionArray, option);
        }
        return false;
    }

    function hasPermissionOthers(permissionArray, userId, option) {
        if (usePage().props.auth.user.id !== userId) {
            return hasPermission(permissionArray, option);
        }
        return false;
    }

    function hasPermission(permissionArray, option) {
        let permits = usePage().props.auth.user?.permit;
        option = option || "any";
        // console.log("option",option);
        // console.log('roles',usePage().props.auth.user.assignedPermissions)
        // console.log('Roles',usePage().props.auth.user.assignedPermissions.flat())

        if (Array.isArray(permissionArray)) {
            permits = permits.flat().sort();
            permissionArray = permissionArray.sort();
            let jsonPermissionArray;
            jsonPermissionArray = JSON.stringify(permissionArray);
            let jsonPermits;
            jsonPermits = JSON.stringify(permits);

            // console.log("Array Found")
            switch (option) {
                case 'exact':
                    // console.log(permissionArray,permits,JSON.stringify(permissionArray.sort()) === JSON.stringify(permits.sort()))
                    return (jsonPermissionArray === jsonPermits)
                    break;
                case 'all':
                    // console.log("Option: All Mandatory ")
                    // console.log(permissionArray, permissionArray.every((permission) => permits.includes(permission)))
                    return permissionArray.every((permission) => permits.includes(permission))
                    break;
                case 'direct':
                    // console.log(permissionArray,permits,JSON.stringify(permissionArray.sort()) === JSON.stringify(permits.sort()))
                    return (JSON.stringify(permissionArray) === JSON.stringify(permits))
                    break;
                case 'exactDirect':
                    // console.log(permissionArray,permits,JSON.stringify(permissionArray.sort()) === JSON.stringify(permits.sort()))
                    return (JSON.stringify(permissionArray.sort()) === JSON.stringify(permits.sort()))
                    break;
                case 'allDirect':
                    // console.log(permissionArray,permits,JSON.stringify(permissionArray.sort()) === JSON.stringify(permits.sort()))
                    return (JSON.stringify(permissionArray.sort()) === JSON.stringify(permits.sort()))
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

    return {hasRole, hasPermission, hasPermissionSelf, hasPermissionOthers, showFlash};
}



