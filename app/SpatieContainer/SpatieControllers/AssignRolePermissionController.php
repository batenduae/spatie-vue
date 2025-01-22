<?php

namespace App\SpatieContainer\SpatieControllers;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\SpatieContainer\SpatieResources\PermissionResource;
use App\SpatieContainer\SpatieResources\RoleResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignRolePermissionController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('users.sync.role'), only: ['usersSyncRole']),
            new Middleware(PermissionMiddleware::using('users.assign.role'), only: ['usersAssignRole']),
            new Middleware(PermissionMiddleware::using('users.revoke.role'), only: ['usersRevokeRole']),

            new Middleware(PermissionMiddleware::using('users.sync.permission'), only: ['usersSyncPermission']),
            new Middleware(PermissionMiddleware::using('users.assign.permission'), only: ['usersAssignPermission']),
            new Middleware(PermissionMiddleware::using('users.revoke.permission'), only: ['usersRevokePermission']),

            new Middleware(PermissionMiddleware::using('users.others.login'), only: ['usersOthersLogin']),

            new Middleware(PermissionMiddleware::using('roles.sync.permission'), only: ['rolesSyncPermissionView', 'rolesSyncPermission']),
            new Middleware(PermissionMiddleware::using('roles.assign.permission'), only: ['rolesAssignPermissionView', 'rolesAssignPermission']),
            new Middleware(PermissionMiddleware::using('roles.revoke.permission'), only: ['rolesRevokePermission']),

            new Middleware(PermissionMiddleware::using('roles.sync.mass-permission'), only: ['rolesSyncMassPermission']),
            new Middleware(PermissionMiddleware::using('roles.assign.mass-permission'), only: ['rolesAssignMassPermissionView', 'rolesAssignMassPermission']),
            new Middleware(PermissionMiddleware::using('roles.revoke.mass-permission'), only: ['rolesRevokeMassPermissionView', 'rolesRevokeMassPermission']),
        ];
    }

    public function usersAssignRolePermissionView(string $userId): Response
    {
        $user = User::findOrFail($userId);
        return Inertia::render('Admin/SpatieRolePermission/AssignRolePermission/UsersSyncRolePermission', [
            'user' => new UserResource($user),
            'roles' => RoleResource::collection(Role::all()),
            'permissions' => PermissionResource::collection(Permission::all()),
            'permissionsGrouped' => PermissionResource::collection(Permission::all())->collection->sortBy([['name', 'asc']])->groupBy('group'),
            'assignedRoles' => $user->roles->pluck('name'),
            'assignedPermissions' => $user->permissions->pluck('name'),
            'assignedPermissionsViaRole' => $user->getPermissionsViaRoles()->pluck('name'),
        ]);
    }

    //Role to User
    public function usersSyncRole(Request $request, $userId): RedirectResponse
    {
        $request->validate([
            'roles' => ''
        ]);
        $user = User::findOrFail($userId);
        $user->syncRoles($request->roles);
        return back()
            ->with('success', "Role Synced to user: '" . $user->name . "' successfully");
    }

    public function usersAssignRole(Request $request, $userId): RedirectResponse
    {
        $request->validate([
            'roles' => ''
        ]);
        $user = User::findOrFail($userId);
        $user->assignRole($request->roles);
        return back()
            ->with('success', "Role Assigned to user: '" . $user->name . "' successfully");
    }

    public function usersRevokeRole(User $user, Role $role): RedirectResponse
    {
        $user->removeRole($role);
        return back()
            ->with('warning', "Role : '" . $role->name . "' removed from User : '" . $user->name . "' successfully");
    }

    //Permission to User

    public function usersSyncPermission(Request $request, $userId): RedirectResponse
    {
        $request->validate([
            'permissions' => ''
        ]);
        $user = User::findOrFail($userId);
        $user->syncPermissions($request->permissions);
        return back()
            ->with('success', "Permission Synced to user: '" . $user->name . "' successfully");
    }

    public function usersAssignPermission(Request $request, $userId): RedirectResponse
    {
        $request->validate([
            'permissions' => ''
        ]);
        $user = User::findOrFail($userId);
        $user->givePermissionTo($request->permissions);
        return back()
            ->with('success', "Permission Asigned to user: '" . $user->name . "' successfully");
    }

    public function usersRevokePermission(User $user, Permission $permission): RedirectResponse
    {
        $user->revokePermissionTo($permission);
        return back()
            ->with('warning', "Permission : '" . $permission->name . "' removed from User : '" . $user->name . "' successfully");
    }

    //
    public function usersOthersLogin(string $userId): RedirectResponse
    {
        $user = User::findOrFail($userId);
        Auth::login($user);
        session()->regenerate();
        return redirect()->route('users.index')
            ->with('success', "logged in as '" . $user->name . "' successfully");
    }

    //Permission to Role

    public function rolesSyncPermissionView($roleId): Response
    {
//        dd(PermissionResource::collection(Permission::all())->collection->groupBy('group'));
        return Inertia::render('Admin/SpatieRolePermission/AssignRolePermission/RolesSyncPermission', [
            'role' => new RoleResource(Role::findOrFail($roleId)),
            'permissions' => PermissionResource::collection(Permission::all()),
            'permissionsGrouped' => PermissionResource::collection(Permission::all())->collection->sortBy([['name', 'asc']])->groupBy('group'),
        ]);
    }

    public function rolesSyncPermission(Request $request, $roleId): RedirectResponse
    {
        $request->validate([
            'permissions' => ''
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->input('permissions.*.name'));

        return back()
            ->with('success', "Permissions Synced to role: '" . $role->name . "' successfully");
    }

    //
    public function rolesAssignPermission(Request $request, $roleId): RedirectResponse
    {
        $request->validate([
            'permissions' => ''
        ]);

        $role = Role::findOrFail($roleId);
        $role->givePermissionTo($request->input('permissions.*.name'));

        return back()
            ->with('success', "Permissions Assigned to role: '" . $role->name . "' successfully");
    }

    public function rolesRevokePermission(Role $role, Permission $permission): RedirectResponse
    {
        $role->revokePermissionTo($permission);
        return back()
            ->with('warning', "Permission : '" . $permission->name . "' removed from Role : '" . $role->name . "' successfully");
    }


    public function rolesSyncMassPermission(): Response
    {
        return Inertia::render('Admin/SpatieRolePermission/AssignRolePermission/RolesSyncMassPermission', [
            'roles' => RoleResource::collection(Role::all()),
            'permissions' => PermissionResource::collection(Permission::all()),
            'permissionsGrouped' => PermissionResource::collection(Permission::all())->collection->sortBy([['name', 'asc']])->groupBy('group'),
        ]);
    }


}
