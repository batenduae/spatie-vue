<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserEducationalBackgroundController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserSocialController;
use Illuminate\Support\Facades\Route;


Route::resource('/posts', PostController::class);
Route::resource('/usersAddress', UserAddressController::class);
Route::resource('/usersEducation', UserEducationalBackgroundController::class);
Route::resource('/usersProfile', UserProfileController::class);
Route::resource('/usersSocial', UserSocialController::class);

