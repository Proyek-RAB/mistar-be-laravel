<?php

namespace Database\Seeders;

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
            // [
            //     // replace user_id, with existing user in the db
            //     'id' => Str::uuid(),
            //     'user_id' => '9a5421f6-d829-41df-a286-9408a7997da0',
            //     'sub_type_id' => 2,
            //     'name' => 'air di ciwaruga',
            //     'details' => json_encode([
            //         'ownership' => 'bersama',
            //         'stakeholder' => 'pemerintah',
            //         'toilet_type' => 'pelengsengan',
            //         'processing_type' => 'septic tank',
            //         'service_scope' => [
            //             'capacity' => 3,
            //             'kk_count' => 4,
            //             'people_count' => 20,
            //         ],
            //         'monthly_service_bill' => 10000,
            //         'contact_person' => '087848484848'
            //     ]),
            //     'status' => 'hold',
            // ],
            // [
            //     'id' => Str::uuid(),
            //     'user_id' => '9a5421f6-d829-41df-a286-9408a7997da0',
            //     'sub_type_id' => 2,
            //     'name' => 'air di ciwaruga',
            //     'details' => json_encode([
            //         'ownership' => 'bersama',
            //         'stakeholder' => 'pemerintah',
            //         'toilet_type' => 'pelengsengan',
            //         'processing_type' => 'septic tank',
            //         'service_scope' => [
            //             'capacity' => 3,
            //             'kk_count' => 4,
            //             'people_count' => 20,
            //         ],
            //         'monthly_service_bill' => 10000,
            //         'contact_person' => '087848484848'
            //     ]),
            //     'status' => 'hold',
            // ],
            // [
            //     'id' => Str::uuid(),
            //     'user_id' => '9a5421f6-d829-41df-a286-9408a7997da0',
            //     'sub_type_id' => 2,
            //     'name' => 'air di ciwaruga',
            //     'details' => json_encode([
            //         'ownership' => 'bersama',
            //         'stakeholder' => 'pemerintah',
            //         'toilet_type' => 'pelengsengan',
            //         'processing_type' => 'septic tank',
            //         'service_scope' => [
            //             'capacity' => 3,
            //             'kk_count' => 4,
            //             'people_count' => 20,
            //         ],
            //         'monthly_service_bill' => 10000,
            //         'contact_person' => '087848484848'
            //     ]),
            //     'status' => 'hold',
            // ],
            // [
            //     'id' => Str::uuid(),
            //     'user_id' => '9a5421f6-d829-41df-a286-9408a7997da0',
            //     'sub_type_id' => 2,
            //     'name' => 'air di ciwaruga',
            //     'details' => json_encode([
            //         'ownership' => 'bersama',
            //         'stakeholder' => 'pemerintah',
            //         'toilet_type' => 'pelengsengan',
            //         'processing_type' => 'septic tank',
            //         'service_scope' => [
            //             'capacity' => 3,
            //             'kk_count' => 4,
            //             'people_count' => 20,
            //         ],
            //         'monthly_service_bill' => 10000,
            //         'contact_person' => '087848484848'
            //     ]),
            //     'status' => 'hold',
            // ],
            // [
            //     'id' => Str::uuid(),
            //     'user_id' => '9a5421f6-d829-41df-a286-9408a7997da0',
            //     'sub_type_id' => 2,
            //     'name' => 'air di ciwaruga',
            //     'details' => json_encode([
            //         'ownership' => 'bersama',
            //         'stakeholder' => 'pemerintah',
            //         'toilet_type' => 'pelengsengan',
            //         'processing_type' => 'septic tank',
            //         'service_scope' => [
            //             'capacity' => 3,
            //             'kk_count' => 4,
            //             'people_count' => 20,
            //         ],
            //         'monthly_service_bill' => 10000,
            //         'contact_person' => '087848484848'
            //     ]),
            //     'status' => 'hold',
            // ],
            // [
            //     'id' => Str::uuid(),
            //     'user_id' => '9a5421f6-d829-41df-a286-9408a7997da0',
            //     'sub_type_id' => 2,
            //     'name' => 'air di ciwaruga',
            //     'details' => json_encode([
            //         'ownership' => 'bersama',
            //         'stakeholder' => 'pemerintah',
            //         'toilet_type' => 'pelengsengan',
            //         'processing_type' => 'septic tank',
            //         'service_scope' => [
            //             'capacity' => 3,
            //             'kk_count' => 4,
            //             'people_count' => 20,
            //         ],
            //         'monthly_service_bill' => 10000,
            //         'contact_person' => '087848484848'
            //     ]),
            //     'status' => 'hold',
            // ],
            // ['id' => Str::uuid(),
            //     'user_id' => '9a5421f6-d829-41df-a286-9408a7997da0',
            //     'sub_type_id' => 2,
            //     'name' => 'NEW 2 air di ciwaruga',
            //     'details' => json_encode([
            //             'ownership' => 'bersama',
            //             'stakeholder' => 'pemerintah',
            //             'toilet_type' => 'pelengsengan',
            //             'processing_type' => 'septic tank',
            //             'service_scope' => [
            //                 'capacity' => 3,
            //                 'kk_count' => 4,
            //                 'people_count' => 20,
            //             ],
            //             'monthly_service_bill' => 10000,
            //             'contact_person' => '087848484848'
            //         ]),
            //     'status' => 'hold',
            //     ],
            //     ['id' => Str::uuid(),
            //     'user_id' => '9a5421f6-d829-41df-a286-9408a7997da0',
            //     'sub_type_id' => 2,
            //     'name' => 'NEW 3 air di ciwaruga',
            //     'details' => json_encode([
            //             'ownership' => 'bersama',
            //             'stakeholder' => 'pemerintah',
            //             'toilet_type' => 'pelengsengan',
            //             'processing_type' => 'septic tank',
            //             'service_scope' => [
            //                 'capacity' => 3,
            //                 'kk_count' => 4,
            //                 'people_count' => 20,
            //             ],
            //             'monthly_service_bill' => 10000,
            //             'contact_person' => '087848484848'
            //         ]),
            //     'status' => 'hold',
            //     ],
                [
                    "id"=>Str::uuid(),
                    "user_id"=>"9a6f6c0c-27ab-49ff-b724-946f4498b3ab",
                    "name"=>"",
                    "type"=>"",
                    "type_id" =>1,
                    "sub_type"=>"",
                    "sub_type_id"=>2,
                    "image"=>"form-data",
                    "status_approval"=>'in progress',
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
                    "user_id"=>"9a6f6c0c-27ab-49ff-b724-946f4498b3ab",
                    "name"=>"",
                    "type"=>"line",
                    "type_id" =>2,
                    "sub_type"=>"",
                    "sub_type_id"=>2,
                    "image"=>"form-data",
                    "status_approval"=>'in progress',
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
                    "user_id"=>"9a6f6c0c-27ab-49ff-b724-946f4498b3ab",
                    "name"=>"",
                    "type"=>"field",
                    "type_id" =>3,
                    "sub_type"=>"",
                    "sub_type_id"=>2,
                    "image"=>"form-data",
                    "status_approval"=>'in progress',
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
