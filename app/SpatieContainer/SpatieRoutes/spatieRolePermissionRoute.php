<?php

use App\SpatieContainer\SpatieControllers\AdminController;
use App\SpatieContainer\SpatieControllers\AssignRolePermissionController;
use App\SpatieContainer\SpatieControllers\PermissionController;
use App\SpatieContainer\SpatieControllers\RoleController;
use App\SpatieContainer\SpatieControllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/dashboard1', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['isAdmin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.index');

    Route::resource('users', UserController::class);
    Route::delete('usersDestroyMany', [UserController::class, 'destroyMany'])->name("users.destroyMany");
    Route::delete('usersDestroyPermanently/{id}', [UserController::class, 'destroyPermanently'])->name("users.destroyPermanently");
    Route::post('usersRestore/{id}', [UserController::class, 'restore'])->name("users.restore");
    Route::post('usersRestoreMany', [UserController::class, 'restoreMany'])->name("users.restoreMany");
    Route::delete('usersDestroyPermanentlyMany', [UserController::class, 'destroyPermanentlyMany'])->name("users.destroyPermanentlyMany");

    Route::resource('roles', RoleController::class);
    Route::delete('rolesDestroy', [RoleController::class, 'destroyMany'])->name("roles.destroyMany");
    Route::resource('permissions', PermissionController::class);
    Route::delete('permissionsDestroy', [PermissionController::class, 'destroyMany'])->name("permissions.destroyMany");

    Route::get('users/{user}/assignRolePermissionView', [AssignRolePermissionController::class, 'usersAssignRolePermissionView'])
        ->name('users.assignRolePermissionView');

    Route::put('users/{user}/syncRole', [AssignRolePermissionController::class, 'usersSyncRole'])
        ->name('users.syncRole');
    Route::put('users/{user}/assignRole', [AssignRolePermissionController::class, 'usersAssignRole'])
        ->name('users.assignRole');
    Route::delete('users/{user}/revokeRole/{role}', [AssignRolePermissionController::class, 'usersRevokeRole'])
        ->name('users.revokeRole');

    Route::put('users/{user}/syncPermission', [AssignRolePermissionController::class, 'usersSyncPermission'])
        ->name('users.syncPermission');
    Route::put('users/{user}/assignPermission', [AssignRolePermissionController::class, 'usersAssignPermission'])
        ->name('users.assignPermission');
    Route::delete('users/{user}/revokePermission/{permission}', [AssignRolePermissionController::class, 'usersRevokePermission'])
        ->name('users.revokePermission');

    Route::post('users/{user}/OthersLogin', [AssignRolePermissionController::class, 'usersOthersLogin'])
        ->name('users.OthersLogin');

    Route::get('roles/{role}/syncPermissionView', [AssignRolePermissionController::class, 'rolesSyncPermissionView'])
        ->name('roles.syncPermissionView');
    Route::put('roles/{role}/syncPermission', [AssignRolePermissionController::class, 'rolesSyncPermission'])
        ->name('roles.syncPermission');
    Route::put('roles/{role}/assignPermission', [AssignRolePermissionController::class, 'rolesAssignPermission'])
        ->name('roles.assignPermission');
    Route::delete('roles/{role}/revokePermission/{permission}', [AssignRolePermissionController::class, 'rolesRevokePermission'])
        ->name('roles.revokePermission');

    Route::get('rolesSyncMassPermission', [AssignRolePermissionController::class, 'rolesSyncMassPermission'])
        ->name('roles.syncMassPermission');

    Route::get('roles/assignMassPermissionView', [AssignRolePermissionController::class, 'rolesAssignMassPermissionView'])
        ->name('roles.assignMassPermissionView');
    Route::get('roles/assignMassPermission', [AssignRolePermissionController::class, 'rolesAssignMassPermission'])
        ->name('roles.assignMassPermission');
    Route::get('roles/revokeMassPermission', [AssignRolePermissionController::class, 'rolesRevokeMassPermission'])
        ->name('roles.revokeMassPermission');

});

