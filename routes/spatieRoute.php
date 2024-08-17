<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.index');
});


Route::resource('/users', UserController::class);
Route::resource('/roles', RoleController::class);
Route::resource('/permissions', PermissionController::class);
