<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard() {
        return response()->json(
            [
                'sucess' => true,
                'message' => 'success',
                'data' => [
                    'infrastruktur' => [
                        'status' => [
                            'baik' => 3,
                            'perbaikan' => 1,
                            'rusak' => 2
                        ],
                        'total' => 6,
                        'titik'=> [
                            'label' => ['Air Bersih', 'Air Limbah (Jamban)', 'Air Sumur'],
                            'count' => [1, 2, 0]
                        ],
                        'garis' => [
                            'label' => ['Drainase', 'Jalan'],
                            'count' => [0, 1]
                        ],
                        'bidang' => [
                            'label' => ['Lahan Parkir'],
                            'count' => [2]
                        ],
                        'report' => [
                            'month' => ['Juni', 'Juli', 'Agustus', 'September'],
                            'count' => [
                                'titik' => [0,0,0,3],
                                'garis' => [0,0,0,1],
                                'bidang' => [0,0,0,2]
                            ]
                        ]
                    ]
                ]

            ]
        );
    }

    public function point() {
        return response()->json(
            [
                'success' => true,
                'message' => 'success get point',
                'data' => [
                    'infrastruktur' => [
                        [
                            'id' => 1,
                            'nama' => 'Mata Air Sumur Ayu',
                            'tipe' => 'Air Bersih',
                            'kepemilikan' => 'Publik',
                            'created_by' => 'akram',
                            'created_at' => ' 2023-09-30 16:20:00.00',
                            'updated_at' => ' 2023-09-30 16:20:00.00',
                        ],
                        [
                            'id' => 2,
                            'nama' => 'Pembuangan Akhir WC RT 5',
                            'tipe' => 'Air Kotor (Jamban)',
                            'kepemilikan' => 'Publik',
                            'created_by' => 'akram',
                            'created_at' => ' 2023-09-30 16:20:00.00',
                            'updated_at' => ' 2023-09-30 16:20:00.00',
                        ],
                        [
                            'id' => 3,
                            'nama' => 'Jamban Bersama',
                            'tipe' => 'Air Kotor (Jamban)',
                            'kepemilikan' => 'Publik',
                            'created_by' => 'akram',
                            'created_at' => ' 2023-09-30 16:20:00.00',
                            'updated_at' => ' 2023-09-30 16:20:00.00',
                        ]
                    ],
                    'page' => 1,
                    'total_page' => 1,
                    'total_data' => 3,
                ]
            ]
        );
    }

    public function line() {
        return response()->json(
            [
                'success' => true,
                'message' => 'success get line',
                'data' => [
                    'infrastruktur' => [
                        [
                            'id' => 1,
                            'nama' => 'Jalan Rakyat',
                            'tipe' => 'Jalan',
                            'tingkatan' => 'Umum',
                            'created_by' => 'akram',
                            'created_at' => ' 2023-09-30 16:20:00.00',
                            'updated_at' => ' 2023-09-30 16:20:00.00',
                        ]
                    ],
                    'page' => 1,
                    'total_page' => 1,
                    'total_data' => 1,
                ]
            ]
        );
    }

    public function area() {
        return response()->json(
            [
                'success' => true,
                'message' => 'success get area',
                'data' => [
                    'infrastruktur' => [
                        [
                            'id' => 1,
                            'nama' => 'Tempat Parkir RT 5',
                            'tipe' => 'Lahan Parkir',
                            'kepemilikan' => 'Publik',
                            'created_by' => 'akram',
                            'created_at' => ' 2023-09-30 16:20:00.00',
                            'updated_at' => ' 2023-09-30 16:20:00.00',
                        ],
                        [
                            'id' => 2,
                            'nama' => 'Tempar Parkir Liar',
                            'tipe' => 'Lahan Parkir',
                            'kepemilikan' => 'Publik',
                            'created_by' => 'akram',
                            'created_at' => ' 2023-09-30 16:20:00.00',
                            'updated_at' => ' 2023-09-30 16:20:00.00',
                        ]
                    ],
                    'page' => 1,
                    'total_page' => 1,
                    'total_data' => 2,
                ]
            ]
        );
    }

    public function user() {
        return response()->json(
            [
                'success' => true,
                'message' => 'success get user',
                'data' => [
                    'users' => [
                        [
                            'id' => 1,
                            'nama' => 'akram',
                            'email' => 'akram@mail.com',
                            'role' => 'USER',
                            'created_at' => ' 2023-09-30 16:20:00.00',
                            'updated_at' => ' 2023-09-30 16:20:00.00',
                        ]
                    ],
                    'page' => 1,
                    'total_page' => 1,
                    'total_data' => 1,
                ]
            ]
        );
    }
}
