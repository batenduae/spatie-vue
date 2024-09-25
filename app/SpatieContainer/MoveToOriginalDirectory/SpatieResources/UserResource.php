<?php

namespace App\SpatieContainer\MoveToOriginalDirectory\SpatieResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
//            'roles' =>  $this->roles->pluck('name'),
//            'roles' =>  RoleResource::collection($this->roles),
//            'permissions'   =>  PermissionResource::collection($this->getDirectPermissions()),
//            'permissionsAll'   =>  PermissionResource::collection($this->getAllPermissions()),
        ];
    }
}
