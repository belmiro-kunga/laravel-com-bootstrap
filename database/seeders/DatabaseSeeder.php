<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            PublicPermissionsSeeder::class,
            AdminUserSeeder::class,
            CategoriaSeeder::class,
            StatusSeeder::class,
        ]);
    }
}
