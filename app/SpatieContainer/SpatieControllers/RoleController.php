<?php

namespace App\SpatieContainer\SpatieControllers;

use App\Http\Controllers\Controller;
use App\SpatieContainer\SpatieRequests\CreateRoleRequest;
use App\SpatieContainer\SpatieResources\PermissionResource;
use App\SpatieContainer\SpatieResources\RoleResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('roles.view'), only: ['index']),
            new Middleware(PermissionMiddleware::using('roles.create'), only: ['create', 'store']),
            new Middleware(PermissionMiddleware::using('roles.edit'), only: ['edit', 'update']),
            new Middleware(PermissionMiddleware::using('roles.delete'), only: ['destroy', 'destroyMany']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/SpatieRolePermission/Roles/RolesIndex',[
            'roles'=> RoleResource::collection(Role::all()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/SpatieRolePermission/Roles/RolesCreate',[
            'permissions'   =>  PermissionResource::collection(Permission::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRoleRequest $request): RedirectResponse
    {
        $role = Role::create($request->validated());
        if($request->has('permissions')){
//            $role->syncPermissions($request->permissions);
            $role->syncPermissions($request->input('permissions.*.name'));
        }
        return to_route('roles.index')
            ->with('success',"Role: '".$role->name."' Created Successfully");
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
        return Inertia::render('Admin/SpatieRolePermission/Roles/RolesEdit',[
            'role'  =>  new RoleResource($role),
            'permissions' =>   PermissionResource::collection(Permission::all()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateRoleRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->validated());
//            $role->syncPermissions($request->permissions);
        $role->syncPermissions($request->input('permissions.*.name'));
        return back()
            ->with('success',"Role: '".$role->name."' Updated Successfully");
//        return to_route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();
        return back()
            ->with('warning', "Role: '" . $role->name . "' Deleted Successfully");
    }

    /**
     * Remove the specified resources from storage.
     */
    public function destroyMany(Request $request)
    {
        $ids = $request->ids;
        $text = "";
        foreach ($ids as $id) {
            $role = Role::findOrFail($id);
            if ($id > 1) {
                $role->delete();
            }
            $text = $text . $role->name . ", ";
        }
        return back()
            ->with('danger', "Roles : '" . $text . "' Deleted Successfully");
    }
}
