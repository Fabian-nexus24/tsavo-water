<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            ['name' => 'John Doe', 'email' => 'john@example.com', 'phone' => '+254722000001', 'address' => '123 Tom Mboya St', 'city' => 'Nairobi'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'phone' => '+254722000002', 'address' => '456 Waiyaki Way', 'city' => 'Nairobi'],
            ['name' => 'David Kimani', 'email' => 'david@example.com', 'phone' => '+254722000003', 'address' => '789 Ngong Rd', 'city' => 'Nairobi'],
            ['name' => 'Alice Otieno', 'email' => 'alice@example.com', 'phone' => '+254722000004', 'address' => '321 Jogoo Rd', 'city' => 'Nairobi'],
            ['name' => 'Samuel Njoroge', 'email' => 'samuel@example.com', 'phone' => '+254722000005', 'address' => '654 Mombasa Rd', 'city' => 'Nairobi'],
        ];

        foreach ($customers as $c) {
            $user = User::create([
                'name' => $c['name'],
                'email' => $c['email'],
                'phone' => $c['phone'],
                'address' => $c['address'],
                'city' => $c['city'],
                'password' => Hash::make('password'),
                'role' => 'customer',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
            $user->assignRole('customer');
        }
    }
}
