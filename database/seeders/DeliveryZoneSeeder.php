<?php

namespace Database\Seeders;

use App\Models\DeliveryZone;
use Illuminate\Database\Seeder;

class DeliveryZoneSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            ['name' => 'Nairobi CBD', 'base_fee' => 100, 'per_km_rate' => 20],
            ['name' => 'Westlands', 'base_fee' => 150, 'per_km_rate' => 25],
            ['name' => 'Eastlands', 'base_fee' => 120, 'per_km_rate' => 20],
            ['name' => 'Kilimani/Lavington', 'base_fee' => 150, 'per_km_rate' => 25],
            ['name' => 'South B/C', 'base_fee' => 130, 'per_km_rate' => 22],
        ];

        foreach ($zones as $z) {
            DeliveryZone::create([
                'name' => $z['name'],
                'base_fee' => $z['base_fee'],
                'per_km_rate' => $z['per_km_rate'],
                'is_active' => true,
            ]);
        }
    }
}
