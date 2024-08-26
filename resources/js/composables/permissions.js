import { usePage } from "@inertiajs/vue3";

export function usePermissions() {
    const hasPermissions = (name) =>
        usePage().props.auth.user.permissions.includes(name);
    const can = (name) =>
        usePage().props.auth.user.permissionsAll.includes(name);

    function hasRole(roleArray) {
        let roles = usePage().props.auth.user.roles;
        if (roles.find((role) => roleArray.includes(role.name))) {
            return true;
        } else {
            return false;
        }
    }

    function hasPermission(permissionArray) {
        let permissions = usePage().props.auth.user.roles;
        if (permissions.find((role) => permissionArray.includes(role.name))) {
            return true;
        } else {
            return false;
        }
    }

    return { hasRole, hasPermission, can };
}



