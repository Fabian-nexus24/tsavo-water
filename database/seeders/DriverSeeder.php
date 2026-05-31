<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\DriverProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        $drivers = [
            [
                'name' => 'James Mwangi', 'email' => 'james.driver@tsavowater.com', 'phone' => '+254711000001',
                'national_id' => '12345678', 'vehicle_type' => 'Motorcycle', 'vehicle_plate' => 'KMCA 001A'
            ],
            [
                'name' => 'Peter Ochieng', 'email' => 'peter.driver@tsavowater.com', 'phone' => '+254711000002',
                'national_id' => '23456789', 'vehicle_type' => 'Van', 'vehicle_plate' => 'KCB 002B'
            ],
            [
                'name' => 'Mary Wanjiku', 'email' => 'mary.driver@tsavowater.com', 'phone' => '+254711000003',
                'national_id' => '34567890', 'vehicle_type' => 'Motorcycle', 'vehicle_plate' => 'KDA 003C'
            ]
        ];

        foreach ($drivers as $d) {
            $user = User::create([
                'name' => $d['name'],
                'email' => $d['email'],
                'phone' => $d['phone'],
                'password' => Hash::make('password'),
                'role' => 'driver',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
            $user->assignRole('driver');

            DriverProfile::create([
                'user_id' => $user->id,
                'national_id' => $d['national_id'],
                'vehicle_type' => $d['vehicle_type'],
                'vehicle_plate' => $d['vehicle_plate'],
                'availability' => 'offline',
                'rating' => 5.00,
            ]);
        }
    }
}
