<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // First, create roles (since users need them)
        Role::firstOrCreate(['name' => 'superadmin']);
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'driver']);
        Role::firstOrCreate(['name' => 'customer']);

        $this->call([
            AdminSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            DriverSeeder::class,
            DeliveryZoneSeeder::class,
            CustomerSeeder::class,
        ]);
    }
}
