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
        Role::create(['name' => 'super admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'editor']);
        Role::create(['name' => 'moderator']);
        Role::create(['name' => 'staff']);
        Role::create(['name' => 'user']);
    }
}
