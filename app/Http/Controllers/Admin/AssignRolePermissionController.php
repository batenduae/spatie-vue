<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignRolePermissionController extends Controller
{
    public function assignRolePermissionToUserView(string $userId): Response
    {
        $user = User::findOrFail($userId);
        return Inertia::render('Admin/AssignRolePermission/AssignRolePermissionToUser',[
            'user'   =>  new UserResource($user),
            'roles'  => RoleResource::collection(Role::all()),
            'permissions'   =>   PermissionResource::collection(Permission::all()),
            'assignedRoles' =>  $user->roles->pluck('name'),
            'assignedPermissions'   =>   $user->permissions->pluck('name'),
            'assignedPermissionsViaRole'  =>    $user->getPermissionsViaRoles()->pluck('name'),
        ]);
    }

    public function assignRoleToUser(Request $request, $userId): RedirectResponse
    {
        $request->validate([
            'roles'    =>  ''
        ]);
        $user = User::findOrFail($userId);
        $user->syncRoles($request->roles);
        return back();
    }

    public function assignPermissionToUser(Request $request, $userId): RedirectResponse
    {
        $request->validate([
            'permissions'    =>  ''
        ]);
        $user = User::findOrFail($userId);
        $user->syncPermissions($request->permissions);
        return back();
    }

    public function loginDynamically(string $userId): RedirectResponse
    {
        $user = User::findOrFail($userId);
        Auth::login($user);
        session()->regenerate();
        return back();
    }


    public function assignPermissionToRoleView($roleId): Response
    {
        return Inertia::render('Admin/AssignRolePermission/AssignPermissionToRole',[
            'role'  => new RoleResource(Role::findOrFail($roleId)),
            'permissions'   => PermissionResource::collection(Permission::all()),
        ]);
    }

    public function assignPermissionToRole(Request $request, $roleId): RedirectResponse
    {
        $request->validate([
            'permissions'    =>  ''
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->input('permissions.*.name'));

        return redirect()->back()->with('status','Permissions updated to role: '.$role->name);
    }

    public function massAssignPermissionToRole(): Response
    {
        return Inertia::render('Admin/AssignRolePermission/MassAssignPermissionToRole',[
            'roles'  => RoleResource::collection(Role::all()),
            'permissions'   =>  PermissionResource::collection(Permission::all()),
        ]);
    }
    //
    public function revokeRoleFromUser(User $user,Role $role): RedirectResponse
    {
        $user->removeRole($role);
        return back();
    }

    public function revokePermissionFromUser(User $user,Permission $permission): RedirectResponse
    {
        $user->revokePermissionTo($permission);
        return back();
    }


    public function revokePermissionFromRole(Role $role,Permission $permission): RedirectResponse
    {
        $role->revokePermissionTo($permission);
        return back();
    }




}
