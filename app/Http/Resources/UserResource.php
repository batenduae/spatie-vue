<?php

namespace App\Http\Resources;

use App\SpatieContainer\SpatieResources\PermissionResource;
use App\SpatieContainer\SpatieResources\RoleResource;
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
        $status = [];
        if ($this->asp) {
            array_push($status, 'asp');
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $status,
            'roles' => RoleResource::collection($this->roles),
            'permissions' => PermissionResource::collection($this->getDirectPermissions()),
            'permissionsAll' => PermissionResource::collection($this->getAllPermissions()),
        ];
    }
}
