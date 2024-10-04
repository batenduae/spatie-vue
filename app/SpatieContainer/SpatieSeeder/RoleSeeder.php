<?php

namespace App\SpatieContainer\SpatieSeeder;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'super admin'])
            ->syncPermissions(['*']);
        Role::create(['name' => 'admin'])
            ->syncPermissions(['admin panel', 'users.others.login', 'users.index', 'users.*', 'roles.*', 'permissions.*']);
        Role::create(['name' => 'editor'])
            ->syncPermissions(['admin panel', 'users.others.login', 'users.index', 'users.self.*', 'users.others.edit', 'roles.*']);
        Role::create(['name' => 'moderator'])
            ->syncPermissions(['admin panel', 'users.others.login', 'users.index', 'users.assign.*', 'permissions.*']);
        Role::create(['name' => 'staff'])
            ->syncPermissions(['admin panel', 'users.others.login', 'users.index', 'users.revoke.*',]);
        Role::create(['name' => 'user'])
            ->syncPermissions(['admin panel', 'users.others.login', 'users.index']);
    }
}
