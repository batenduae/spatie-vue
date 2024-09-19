<?php

namespace App\SpatieContainer\SpatieSeeder;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'user.*']);
        Permission::create(['name' => 'user.create']);
        Permission::create(['name' => 'user.view']);
        Permission::create(['name' => 'user.edit']);
        Permission::create(['name' => 'user.delete']);
        Permission::create(['name' => 'user.export']);

        Permission::create(['name' => 'role.*']);
        Permission::create(['name' => 'role.create']);
        Permission::create(['name' => 'role.view']);
        Permission::create(['name' => 'role.edit']);
        Permission::create(['name' => 'role.delete']);

        Permission::create(['name' => 'permission.*']);
        Permission::create(['name' => 'permission.create']);
        Permission::create(['name' => 'permission.view']);
        Permission::create(['name' => 'permission.edit']);
        Permission::create(['name' => 'permission.delete']);

        Permission::create(['name' => 'post.*']);
        Permission::create(['name' => 'post.create']);
        Permission::create(['name' => 'post.view']);
        Permission::create(['name' => 'post.edit']);
        Permission::create(['name' => 'post.delete']);

        Permission::create(['name' => 'assign-role.to-user']);
        Permission::create(['name' => 'revoke-role.from-user']);
        Permission::create(['name' => 'assign-permission.to-user']);
        Permission::create(['name' => 'revoke-permission.from-user']);
        Permission::create(['name' => 'assign-permission.to-role']);
        Permission::create(['name' => 'revoke-permission.from-role']);
        Permission::create(['name' => 'mass-assign-permission.to-role']);
        Permission::create(['name' => 'delete-permission.from-user']);

        Permission::create(['name' => 'admin panel']);
        Permission::create(['name' => 'restricted']);
        Permission::create(['name' => 'banned']);
    }
}
