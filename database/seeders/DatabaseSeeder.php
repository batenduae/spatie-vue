<?php

namespace Database\Seeders;

use App\SpatieContainer\SpatieSeeder\PermissionSeeder;
use App\SpatieContainer\SpatieSeeder\RoleSeeder;
use App\SpatieContainer\SpatieSeeder\UserSeeder;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);


        // User::factory(10)->create();
    }
}
