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
        if ($this->hasAnyPermission('admin panel')) {
            array_push($status, 'panel');
        }
        if ($this->hasDirectPermission('restricted')) {
            array_push($status, 'restricted');
        }
        if ($this->hasDirectPermission('banned')) {
            array_push($status, 'banned');
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $status,
            'assignedRoles' => RoleResource::collection($this->roles),
            'permissionsDirect' => PermissionResource::collection($this->getDirectPermissions()), // Direct permissions
            'permissionsViaRole' => PermissionResource::collection($this->getPermissionsViaRoles()), // Permissions Via Role
            'assignedPermissions' => PermissionResource::collection($this->getAllPermissions()), //All Permissions
        ];
    }
}
