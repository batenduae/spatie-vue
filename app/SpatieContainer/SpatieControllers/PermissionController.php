<?php

namespace App\SpatieContainer\SpatieControllers;

use App\Http\Controllers\Controller;
use App\SpatieContainer\SpatieRequests\CreatePermissionRequest;
use App\SpatieContainer\SpatieResources\PermissionResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('permission.view'), only: ['index']),
            new Middleware(PermissionMiddleware::using('permission.create'), only: ['create','store']),
            new Middleware(PermissionMiddleware::using('permission.edit'), only: ['edit','update']),
            new Middleware(PermissionMiddleware::using('permission.delete'), only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/SpatieRolePermission/Permissions/PermissionsIndex',[
            'permissions'  => PermissionResource::collection(Permission::all()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/SpatieRolePermission/Permissions/PermissionsCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePermissionRequest $request): RedirectResponse
    {
        $permission = Permission::create($request->validated());
        return to_route('permissions.index')
            ->with('success',"Permission : '".$permission->name."' Created Successfully");
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission): Response
    {
        return Inertia::render('Admin/SpatieRolePermission/Permissions/PermissionsEdit',[
            'permission'=> new PermissionResource($permission)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreatePermissionRequest $request, Permission $permission): RedirectResponse
    {
        $permission->update($request->validated());
        return to_route('permissions.index')
            ->with('success','Permission Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->delete();
        return back()->with('error','Permission deleted successfully');
    }
}
