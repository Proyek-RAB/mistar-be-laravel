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
            ['id' => Str::uuid(),
                'user_id' => '9a5421f6-d829-41df-a286-9408a7997da0',
                'sub_type_id' => 2,
                'name' => 'NEW 2 air di ciwaruga',
                'details' => json_encode([
                        'ownership' => 'bersama',
                        'stakeholder' => 'pemerintah',
                        'toilet_type' => 'pelengsengan',
                        'processing_type' => 'septic tank',
                        'service_scope' => [
                            'capacity' => 3,
                            'kk_count' => 4,
                            'people_count' => 20,
                        ],
                        'monthly_service_bill' => 10000,
                        'contact_person' => '087848484848'
                    ]),
                'status' => 'hold',
                ],
                ['id' => Str::uuid(),
                'user_id' => '9a5421f6-d829-41df-a286-9408a7997da0',
                'sub_type_id' => 2,
                'name' => 'NEW 3 air di ciwaruga',
                'details' => json_encode([
                        'ownership' => 'bersama',
                        'stakeholder' => 'pemerintah',
                        'toilet_type' => 'pelengsengan',
                        'processing_type' => 'septic tank',
                        'service_scope' => [
                            'capacity' => 3,
                            'kk_count' => 4,
                            'people_count' => 20,
                        ],
                        'monthly_service_bill' => 10000,
                        'contact_person' => '087848484848'
                    ]),
                'status' => 'hold',
            ]
            // Add other infrastructure entries similarly
        ];
        foreach ($infrastructures as $type) {
            Infrastructure::create($type);
        }
    }
}
