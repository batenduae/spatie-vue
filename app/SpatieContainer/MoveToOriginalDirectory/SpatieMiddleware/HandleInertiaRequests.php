<?php

namespace App\SpatieContainer\MoveToOriginalDirectory\SpatieMiddleware;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;
use Spatie\Permission\Models\Permission;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $permissions = [];
        foreach (Permission::all() as $permission) {
            if(Auth::user()){
                if (Auth::user()->can($permission->name)) {
                    $permissions[] = $permission->name;
                }
            }
        }
        return [
            ...parent::share($request),
            'auth.user' => fn () => $request->user()
                ? new UserResource($request->user())
                : null,
            'auth.user.permit' => $permissions,

            'flash' => function () use ($request) {
                return [
                    'message'   => session('message'),
                    'info'      => session('info'),
                    'success'   => session('success'),
                    'warning'   => session('warning'),
                    'error'     => session('error'),
                    'danger'    => session('danger'),
                ];
            }
        ];
    }
}
