<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Infrastructure;
use Illuminate\Support\Str;


class InfrastructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $infrastructures = [
                [
                    "id"=>Str::uuid(),
                    "user_id"=>User::query()->first()->id,
                    "name"=>"",
                    "type"=>"",
                    "type_id" =>1,
                    "sub_type"=>"",
                    "sub_type_id"=>2,
                    "image"=>"form-data",
                    "status_approval"=>'requested',
                    "details" => json_encode([
                        "lat_lng"=>[
                            "lat"=>0,
                            "lng"=>0
                        ],
                        'address' => '',
                        'description' => [
                            'ownership' => '',
                            'stakeholder' => [
                                'government' => '',
                                'rt_rw' => '',
                                'ngo' => ''
                            ],
                            'source' => ['a', 'b'],
                            'toilet_type' => '',
                            'water_processing_type' => '',
                            'waste_type' => '',
                            'waste_processing_type' => '',
                            'serviceScope' => [
                                'capacity' => 1000.5,
                                'kk_count' => 5,
                                'people_count' => 15
                            ],
                            'contactPerson' => '+6281234567890',
                            'monthlyServiceBill' => 10000.0
                        ]
                    ]),
                ],
                [
                    "id"=>Str::uuid(),
                    "user_id"=>User::query()->first()->id,
                    "name"=>"",
                    "type"=>"line",
                    "type_id" =>2,
                    "sub_type"=>"",
                    "sub_type_id"=>2,
                    "image"=>"form-data",
                    "status_approval"=>'requested',
                    "details" => json_encode([
                        'lat_lng' => [
                            ['lat' => 0, 'lng' => 0],
                            ['lat' => 0, 'lng' => 0],
                        ],
                        'address' => '',
                        'description' => [
                            'distance' => '',
                            'level' => '',
                            'vehicles' => ['a', 'b'],
                            'road_width' => '',
                            'has_drainage' => false,
                            'contactPerson' => '+6281234567890',
                        ],
                    ]),
                ],
                [
                    "id"=>Str::uuid(),
                    "user_id"=>User::query()->first()->id,
                    "name"=>"",
                    "type"=>"field",
                    "type_id" =>3,
                    "sub_type"=>"",
                    "sub_type_id"=>2,
                    "image"=>"form-data",
                    "status_approval"=>'requested',
                    "details" => json_encode([
                        'lat_lng' => [
                            ['lat' => 0, 'lng' => 0],
                            ['lat' => 0, 'lng' => 0],
                        ],
                        'address' => '',
                        'description' => [
                            'ownership' => '',
                            'stakeholder' => [
                                'government' => '',
                                'rt_rw' => '',
                                'ngo' => '',
                            ],
                            'surface_area' => '',
                            'building_area' => '',
                            'contactPerson' => '+6281234567890',
                        ],
                    ]),
                ]
            // Add other infrastructure entries similarly
        ];
        foreach ($infrastructures as $type) {
            Infrastructure::create($type);
        }
    }
}
