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

//        Super Power
        Permission::create(['name' => '*', 'group' => 'wild']);

//        For Maintaining Users
        Permission::create(['name' => 'users.*', 'group' => 'wild']);
        Permission::create(['name' => 'users.index', 'group' => 'wild']);

        Permission::create(['name' => 'users.self.*', 'group' => 'users.self']);
        Permission::create(['name' => 'users.self.create', 'group' => 'users.self']);
        Permission::create(['name' => 'users.self.view', 'group' => 'users.self']);
        Permission::create(['name' => 'users.self.edit', 'group' => 'users.self']);
        Permission::create(['name' => 'users.self.remove', 'group' => 'users.self']);
        Permission::create(['name' => 'users.self.delete', 'group' => 'users.self']);
        Permission::create(['name' => 'users.self.export', 'group' => 'users.self']);

        Permission::create(['name' => 'users.others.*', 'group' => 'users.others']);
        Permission::create(['name' => 'users.others.create', 'group' => 'users.others']);
        Permission::create(['name' => 'users.others.view', 'group' => 'users.others']);
        Permission::create(['name' => 'users.others.edit', 'group' => 'users.others']);
        Permission::create(['name' => 'users.others.remove', 'group' => 'users.others']);
        Permission::create(['name' => 'users.others.delete', 'group' => 'users.others']);
        Permission::create(['name' => 'users.others.export', 'group' => 'users.others']);
        Permission::create(['name' => 'users.others.login', 'group' => 'users.others']);

        Permission::create(['name' => 'users.sync.*', 'group' => 'users.assign']);
        Permission::create(['name' => 'users.sync.role', 'group' => 'users.assign']);
        Permission::create(['name' => 'users.sync.permission', 'group' => 'users.assign']);
        Permission::create(['name' => 'users.sync.status', 'group' => 'users.assign']);

        Permission::create(['name' => 'users.assign.*', 'group' => 'users.assign']);
        Permission::create(['name' => 'users.assign.role', 'group' => 'users.assign']);
        Permission::create(['name' => 'users.assign.permission', 'group' => 'users.assign']);

        Permission::create(['name' => 'users.revoke.*', 'group' => 'users.assign']);
        Permission::create(['name' => 'users.revoke.role', 'group' => 'users.assign']);
        Permission::create(['name' => 'users.revoke.permission', 'group' => 'users.assign']);


//        For Maintaining Roles by SuperAdmin & Admin
        Permission::create(['name' => 'roles.*', 'group' => 'wild']);
        Permission::create(['name' => 'roles.index', 'group' => 'roles']);
        Permission::create(['name' => 'roles.create', 'group' => 'roles']);
        Permission::create(['name' => 'roles.view', 'group' => 'roles']);
        Permission::create(['name' => 'roles.edit', 'group' => 'roles']);
        Permission::create(['name' => 'roles.remove', 'group' => 'roles']);
        Permission::create(['name' => 'roles.delete', 'group' => 'roles']);

        Permission::create(['name' => 'roles.sync.*', 'group' => 'roles.assign']);
        Permission::create(['name' => 'roles.sync.permission', 'group' => 'roles.assign']);
        Permission::create(['name' => 'roles.sync.mass-permission', 'group' => 'roles.assign']);

        Permission::create(['name' => 'roles.assign.*', 'group' => 'roles.assign']);
        Permission::create(['name' => 'roles.assign.permission', 'group' => 'roles.assign']);
        Permission::create(['name' => 'roles.assign.mass-permission', 'group' => 'roles.assign']);

        Permission::create(['name' => 'roles.revoke.*', 'group' => 'roles.assign']);
        Permission::create(['name' => 'roles.revoke.permission', 'group' => 'roles.assign']);
        Permission::create(['name' => 'roles.revoke.mass-permission', 'group' => 'roles.assign']);


//        For Maintaining Permissions by SuperAdmin
        Permission::create(['name' => 'permissions.*', 'group' => 'wild']);
        Permission::create(['name' => 'permissions.index', 'group' => 'permissions']);
        Permission::create(['name' => 'permissions.create', 'group' => 'permissions']);
        Permission::create(['name' => 'permissions.view', 'group' => 'permissions']);
        Permission::create(['name' => 'permissions.edit', 'group' => 'permissions']);
        Permission::create(['name' => 'permissions.remove', 'group' => 'permissions']);
        Permission::create(['name' => 'permissions.delete', 'group' => 'permissions']);

//        For Maintaining Posts
        Permission::create(['name' => 'posts.*', 'group' => 'wild']);
        Permission::create(['name' => 'posts.index', 'group' => 'wild']);

        Permission::create(['name' => 'posts.self.*', 'group' => 'posts.self']);
        Permission::create(['name' => 'posts.self.create', 'group' => 'posts.self']);
        Permission::create(['name' => 'posts.self.view', 'group' => 'posts.self']);
        Permission::create(['name' => 'posts.self.edit', 'group' => 'posts.self']);
        Permission::create(['name' => 'posts.self.remove', 'group' => 'posts.self']);
        Permission::create(['name' => 'posts.self.delete', 'group' => 'posts.self']);

        Permission::create(['name' => 'posts.others.*', 'group' => 'posts.others']);
        Permission::create(['name' => 'posts.others.create', 'group' => 'posts.others']);
        Permission::create(['name' => 'posts.others.view', 'group' => 'posts.others']);
        Permission::create(['name' => 'posts.others.edit', 'group' => 'posts.others']);
        Permission::create(['name' => 'posts.others.remove', 'group' => 'posts.others']);
        Permission::create(['name' => 'posts.others.delete', 'group' => 'posts.others']);

//        For Access Maintaining
        Permission::create(['name' => 'admin panel', 'group' => 'wild']);
        Permission::create(['name' => 'restricted', 'group' => 'wild']);
        Permission::create(['name' => 'banned', 'group' => 'wild']);


//        Permission::create(['name' => 'assign-role.to-user']);
//        Permission::create(['name' => 'revoke-role.from-user']);
//        Permission::create(['name' => 'assign-permission.to-user']);
//        Permission::create(['name' => 'revoke-permission.from-user']);
//        Permission::create(['name' => 'assign-permission.to-role']);
//        Permission::create(['name' => 'revoke-permission.from-role']);
//        Permission::create(['name' => 'mass-assign-permission.to-role']);
//        Permission::create(['name' => 'delete-permission.from-user']);

    }
}
