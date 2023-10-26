<?php

namespace Database\Seeders;

use App\Models\Infrastructure;
use App\Models\InfrastructureType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InfrastructureTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $infrastructureTypes = [
            [
                'id' => 1,
                'name' => Infrastructure::TYPE_POINT,
                'icon_url' => env('BE_DOMAIN') . '/type/titik.svg',
            ],
            [
                'id' => 2,
                'name' => Infrastructure::TYPE_LINE,
                'icon_url' => env('BE_DOMAIN') . '/type/Garis.svg',
            ],
            [
                'id' => 3,
                'name' => Infrastructure::TYPE_AREA,
                'icon_url' => env('BE_DOMAIN') . '/type/bidang.svg',
            ],
        ];

        foreach ($infrastructureTypes as $type) {
            InfrastructureType::create($type);
        }
    }
}
