<?php

namespace Database\Seeders;

use App\Models\Infrastructure;
use App\Models\InfrastructureSubType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'name' => Infrastructure::SUB_TYPE_CLEAN_WATER,
                'icon_url' => env('BE_DOMAIN') . '/icon_infras/water.svg',
            ],
            [
                'id' => 2,
                'type_id' => 1,
                'name' => Infrastructure::SUB_TYPE_DIRTY_WATER,
                'icon_url' => env('BE_DOMAIN') . '/icon_infras/air_limbah.svg',
            ],
            [
                'id' => 3,
                'type_id' => 1,
                'name' => Infrastructure::SUB_TYPE_WASTE,
                'icon_url' => env('BE_DOMAIN') . '/icon_infras/persampahan.svg',
            ],
            [
                'id' => 4,
                'type_id' => 2,
                'name' => Infrastructure::SUB_TYPE_ROAD_DRAINAGE,
                'icon_url' => env('BE_DOMAIN') . '/icon_infras/jalan_drainase.svg',
            ],
            [
                'id' => 5,
                'type_id' => 3,
                'name' => Infrastructure::SUB_TYPE_PARKING_LOT,
                'icon_url' => env('BE_DOMAIN') . '/icon_infras/parkir.svg',
            ],
        ];

        foreach ($subTypes as $type) {
            InfrastructureSubType::create($type);
        }
    }
}
