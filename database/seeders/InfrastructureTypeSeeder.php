<?php

namespace Database\Seeders;

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
                'name' => 'Titik',
                'icon_url' => env('BE_DOMAIN') . '/static/icons/jenis data new/titik.svg',
            ],
            [
                'id' => 2,
                'name' => 'Garis',
                'icon_url' => env('BE_DOMAIN') . '/static/icons/jenis data new/Garis.svg',
            ],
            [
                'id' => 3,
                'name' => 'Bidang',
                'icon_url' => env('BE_DOMAIN') . '/static/icons/jenis data new/bidang.svg',
            ],
        ];

        foreach ($infrastructureTypes as $type) {
            InfrastructureType::create($type);
        }
    }
}