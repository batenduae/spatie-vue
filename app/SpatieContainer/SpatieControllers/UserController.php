<?php

namespace App\SpatieContainer\SpatieControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\SpatieContainer\SpatieRequests\CreateUserRequest;
use App\SpatieContainer\SpatieResources\PermissionResource;
use App\SpatieContainer\SpatieResources\RoleResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('user.view'), only:['index']),
            new Middleware(PermissionMiddleware::using('user.create'), only:['create','store']),
            new Middleware(PermissionMiddleware::using('user.edit'), only:['edit','update']),
            new Middleware(PermissionMiddleware::using('user.delete'), only:['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/SpatieRolePermission/Users/UsersIndex',[
            'users' =>  UserResource::collection(User::all()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/SpatieRolePermission/Users/UsersCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return to_route('users.index')
            ->with('success',"User : '".$user->name."' Created Successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Admin/SpatieRolePermission/Users/UsersEdit',[
            'user'  => new UserResource($user),
            'roles'=> RoleResource::collection(Role::all()),
            'permissions'   =>  PermissionResource::collection(Permission::all())
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|' . Rule::unique('users', 'email')->ignore($user),
            'status' => 'sometimes|array',
            'roles' => 'sometimes|array',
            'permissions' => 'sometimes|array'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        if (in_array("asp", $request->status)) {
            $user->update([
                'asp' => true,
            ]);
        } else {
            $user->update([
                'asp' => false,
            ]);
        }
        $user->syncRoles($request->input('roles.*.name'));
//        $user->syncRoles($request->roles);
        $user->syncPermissions($request->input('permissions.*.name'));
//        $user->syncPermissions($request->permissions);
        return back()
            ->with('info', "User : '" . $user->name . "' Updated Successfully");
//        return to_route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return back()
            ->with('danger',"User : '".$user->name."' Deleted Successfully");
    }
}
