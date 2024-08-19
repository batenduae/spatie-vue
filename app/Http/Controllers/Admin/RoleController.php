<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Roles/RolesIndex',[
            'roles'=> RoleResource::collection(Role::all()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Roles/RolesCreate',[
            'permissions'   =>  PermissionResource::collection(Permission::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRoleRequest $request): RedirectResponse
    {
        $role = Role::create(['name' => $request->name]);
        if($request->has('permissions')){
//            $role->syncPermissions($request->permissions);
            $role->syncPermissions($request->input('permissions.*.name'));
        }
        return to_route('roles.index');
//        return to_route('roles.edit',$role->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): Response
    {
        return Inertia::render('Admin/Roles/RolesEdit',[
            'role'  =>  new RoleResource($role),
            'permissions' =>   PermissionResource::collection(Permission::all()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateRoleRequest $request, Role $role): RedirectResponse
    {
        $role->update(['name' => $request->name]);
//            $role->syncPermissions($request->permissions);
        $role->syncPermissions($request->input('permissions.*.name'));
        return back();
//        return to_route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();
        return to_route('roles.index');
    }
}
