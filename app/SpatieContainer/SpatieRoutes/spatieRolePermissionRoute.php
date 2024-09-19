<?php

use App\SpatieContainer\SpatieControllers\AdminController;
use App\SpatieContainer\SpatieControllers\AssignRolePermissionController;
use App\SpatieContainer\SpatieControllers\PermissionController;
use App\SpatieContainer\SpatieControllers\RoleController;
use App\SpatieContainer\SpatieControllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['isAdmin'])->group(function () {
    Route::get('/check',function (){
        return "hi";
    });
});


Route::middleware(['isAdmin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.index');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::get('users/{user}/assignRolePermissionToUserView',[AssignRolePermissionController::class,'assignRolePermissionToUserView'])
        ->name('users.assignRolePermissionToUser');
    Route::put('users/{user}/assignRoleToUser',[AssignRolePermissionController::class,'assignRoleToUser'])
        ->name('users.assignRoleToUser');
    Route::put('users/{user}/assignPermissionToUser',[AssignRolePermissionController::class,'assignPermissionToUser'])
        ->name('users.assignPermissionToUser');
    Route::post('users/{user}/loginDynamically',[AssignRolePermissionController::class,'loginDynamically'])
        ->name('users.loginDynamically');
    Route::delete('users/{user}/revokeRole/{role}',[AssignRolePermissionController::class,'revokeRoleFromUser'])
        ->name('users.revokeRole');
    Route::delete('users/{user}/revokePermission/{permission}',[AssignRolePermissionController::class,'revokePermissionFromUser'])
        ->name('users.revokePermission');

    Route::get('roles/{role}/assignPermissionToRoleView',[AssignRolePermissionController::class,'assignPermissionToRoleView'])
        ->name('roles.assignPermissionToRoleView');
    Route::put('roles/{role}/assignPermissionsToRole',[AssignRolePermissionController::class,'assignPermissionToRole'])
        ->name('roles.assignPermissionsToRole');
    Route::get('massAssignPermissionToRole',[AssignRolePermissionController::class,'massAssignPermissionToRole'])
        ->name('roles.massAssignPermissionToRole');;
    Route::delete('roles/{role}/revokePermission/{permission}',[AssignRolePermissionController::class,'revokePermissionFromRole'])
        ->name('roles.revokePermission');
});

