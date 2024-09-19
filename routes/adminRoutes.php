<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::resource('/posts', PostController::class);
Route::middleware([])->group(function () {

});
