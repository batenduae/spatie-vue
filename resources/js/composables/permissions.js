import { usePage } from "@inertiajs/vue3";

export function usePermissions() {
    const is = (name) => usePage().props.auth.user.roles.includes(name);
    const hasPermission = (name) =>
        usePage().props.auth.user.permissions.includes(name);
    const can = (name) =>
        usePage().props.auth.user.permissionsAll.includes(name);

    return { is, hasPermission, can };
}
