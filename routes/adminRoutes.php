<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserEducationalBackgroundController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserSocialController;
use Illuminate\Support\Facades\Route;


Route::resource('/posts', PostController::class);
Route::resource('/userAddress', UserAddressController::class);
Route::resource('/userEducation', UserEducationalBackgroundController::class);
Route::resource('/userProfile', UserProfileController::class);
Route::resource('/userSocial', UserSocialController::class);

