<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserEducationalBackgroundController;
use App\Http\Controllers\UserFamilyController;
use App\Http\Controllers\UserHonorGiftController;
use App\Http\Controllers\UserPostingController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserSocialController;
use App\Http\Controllers\UserSuccessController;
use App\Http\Controllers\UserWebPostController;
use Illuminate\Support\Facades\Route;


Route::resource('/posts', PostController::class);
Route::resource('/usersAddress', UserAddressController::class);
Route::resource('/usersEducation', UserEducationalBackgroundController::class);
Route::resource('/usersFamily', UserFamilyController::class);
Route::resource('/usersHonorGift', UserHonorGiftController::class);
Route::resource('/usersPosting', UserPostingController::class);
Route::resource('/usersProfile', UserProfileController::class);
Route::resource('/usersSocial', UserSocialController::class);
Route::resource('/usersSuccess', UserSuccessController::class);
Route::resource('/usersWebPost', UserWebPostController::class);

