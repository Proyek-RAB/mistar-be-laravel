<?php

namespace Database\Seeders;

use App\Models\InfrastructureSubType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InfrastructureSubTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subTypes = [
            [
                'id' => 1,
                'type_id' => 1,
                'name' => 'Air Bersih',
                'icon_url' => env('BE_DOMAIN') . '/icon_infras/water.svg',
            ],
            [
                'id' => 2,
                'type_id' => 1,
                'name' => 'Air Limbah',
                'icon_url' => env('BE_DOMAIN') . '/icon_infras/air_limbah.svg',
            ],
            [
                'id' => 3,
                'type_id' => 2,
                'name' => 'Jalan',
                'icon_url' => env('BE_DOMAIN') . '/icon_infras/road.svg',
            ],
            [
                'id' => 4,
                'type_id' => 2,
                'name' => 'Drainase',
                'icon_url' => env('BE_DOMAIN') . '/icon_infras/drainase.svg',
            ],
            [
                'id' => 5,
                'type_id' => 3,
                'name' => 'Lahan Parkir',
                'icon_url' => env('BE_DOMAIN') . '/icon_infras/parkir.svg',
            ],
        ];

        foreach ($subTypes as $type) {
            InfrastructureSubType::create($type);
        }
    }
}
