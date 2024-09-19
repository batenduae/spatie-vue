<?php

namespace App\SpatieContainer\SpatieControllers;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Middleware\PermissionMiddleware;

class AdminController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using(['admin panel']), only: ['index']),
        ];
    }
    public function index(): Response
    {
        return Inertia::render('Admin/AdminIndex');
    }
}
