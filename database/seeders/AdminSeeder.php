<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $superadmin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@tsavowater.com',
            'phone' => '+254700000000',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $superadmin->assignRole('superadmin');

        $staff = User::create([
            'name' => 'Staff User',
            'email' => 'staff@tsavowater.com',
            'phone' => '+254700000001',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $staff->assignRole('admin');
    }
}
