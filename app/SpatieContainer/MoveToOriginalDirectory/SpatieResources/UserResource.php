<?php

namespace App\SpatieContainer\MoveToOriginalDirectory\SpatieResources;

use App\SpatieContainer\SpatieResources\PermissionResource;
use App\SpatieContainer\SpatieResources\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class UserResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'  =>  $this->id,
            'name' =>   $this->name,
            'email' =>  $this->email,
            'roles' =>  RoleResource::collection($this->roles),
            'permissions'   =>  PermissionResource::collection($this->getDirectPermissions()),
            'permissionsAll'   =>  PermissionResource::collection($this->getAllPermissions()),
        ];
    }
}
