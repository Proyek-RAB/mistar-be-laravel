<?php

namespace App\Http\Controllers;

use App\Http\Resources\InfrastructureResource;
use App\Http\Resources\UserResource;
use App\Models\Infrastructure;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class DashboardController extends Controller
{
    const NUM_OF_MONTHS = 4;

    public function dashboard() {
        $infrastructurePointList = Infrastructure::query()
            ->where('type', Infrastructure::TYPE_POINT)
            ->get();

        return response()->json(
            [
                'success' => true,
                'message' => 'success',
                'data' => [
                    'infrastruktur' => [
                        'status' => [
                            'baik' => $this->countInfraByStatus( Infrastructure::STATUS_GOOD),
                            'perbaikan' => $this->countInfraByStatus(Infrastructure::STATUS_REPAIR),
                            'rusak' => $this->countInfraByStatus(Infrastructure::STATUS_BROKEN),
                        ],
                        'total' => Infrastructure::query()->count(),
                        'titik' => [
                            'label' => [Infrastructure::SUB_TYPE_CLEAN_WATER, Infrastructure::SUB_TYPE_DIRTY_WATER, Infrastructure::SUB_TYPE_WASTE],
                            'count' => [$this->countInfraBySubType(Infrastructure::SUB_TYPE_CLEAN_WATER),
                                $this->countInfraBySubType(Infrastructure::SUB_TYPE_DIRTY_WATER),
                                $this->countInfraBySubType(Infrastructure::SUB_TYPE_WASTE)]
                        ],
                        'garis' => [
                            'label' => [Infrastructure::SUB_TYPE_ROAD_DRAINAGE],
                            'count' => [$this->countInfraBySubType(Infrastructure::SUB_TYPE_ROAD_DRAINAGE)]
                        ],
                        'bidang' => [
                            'label' => [Infrastructure::SUB_TYPE_PARKING_LOT],
                            'count' => [$this->countInfraBySubType(Infrastructure::SUB_TYPE_PARKING_LOT)]
                        ],
                        'report' => [
                            'month' => $this->getReportMonthList(self::NUM_OF_MONTHS),
                            'titik' => $this->getInfraCountByTypeAndNumberOfMonthList(Infrastructure::TYPE_POINT, self::NUM_OF_MONTHS),
                            'garis' => $this->getInfraCountByTypeAndNumberOfMonthList(Infrastructure::TYPE_LINE, self::NUM_OF_MONTHS),
                            'bidang' => $this->getInfraCountByTypeAndNumberOfMonthList(Infrastructure::TYPE_AREA, self::NUM_OF_MONTHS),
                        ]
                    ]
                ]
            ]
        );
    }

    public function point(Request $request) {
        $currentPage = 1;
        $currentLimit = 20;
        if( $request->has('page') && ctype_digit($request->query('page'))) {
            $currentPage = intval($request->query('page'));
        }
        if( $request->has('limit') && ctype_digit($request->query('limit'))) {
            $currentLimit = intval($request->query('limit'));
        }
        $paginator = Infrastructure::query()
            ->where('type', Infrastructure::TYPE_POINT);

        if ($request->has('keyword')) {
            $paginator = $paginator->where('name', $request->query('keyword'));
        }

        $paginator = $paginator->paginate($currentLimit);
        return response()->json(
            [
                'success' => true,
                'message' => 'success get points',
                'data' =>
                    [
                        'infrastruktur' => InfrastructureResource::collection($paginator->items()),
                    ],
                'page' => $currentPage,
                'total_page' => $paginator->lastPage(),
                'total_data' => $paginator->total()
            ]
        );
    }

    public function line(Request $request) {
        $currentPage = 1;
        $currentLimit = 20;
        if( $request->has('page') && ctype_digit($request->query('page'))) {
            $currentPage = intval($request->query('page'));
        }
        if( $request->has('limit') && ctype_digit($request->query('limit'))) {
            $currentLimit = intval($request->query('limit'));
        }
        $paginator = Infrastructure::query()
            ->where('type', Infrastructure::TYPE_LINE)
            ->paginate($currentLimit);
        return response()->json(
            [
                'success' => true,
                'message' => 'success get lines',
                'data' =>
                    [
                        'infrastruktur' => InfrastructureResource::collection($paginator->items()),
                    ],
                'page' => $currentPage,
                'total_page' => $paginator->lastPage(),
                'total_data' => $paginator->total()
            ]
        );
    }

    public function area(Request $request) {
        $currentPage = 1;
        $currentLimit = 20;
        if( $request->has('page') && ctype_digit($request->query('page'))) {
            $currentPage = intval($request->query('page'));
        }
        if( $request->has('limit') && ctype_digit($request->query('limit'))) {
            $currentLimit = intval($request->query('limit'));
        }
        $paginator = Infrastructure::query()
            ->where('type', Infrastructure::TYPE_AREA)
            ->paginate($currentLimit);
        return response()->json(
            [
                'success' => true,
                'message' => 'success get areas',
                'data' =>
                    [
                        'infrastruktur' => InfrastructureResource::collection($paginator->items()),
                    ],
                'page' => $currentPage,
                'total_page' => $paginator->lastPage(),
                'total_data' => $paginator->total()
            ]
        );
    }

    public function user(Request $request) {
        $currentPage = 1;
        $currentLimit = 20;
        if( $request->has('page') && ctype_digit($request->query('page'))) {
            $currentPage = intval($request->query('page'));
        }
        if( $request->has('limit') && ctype_digit($request->query('limit'))) {
            $currentLimit = intval($request->query('limit'));
        }
        $paginator = User::query()
            ->where('role', User::ROLE_MEMBER)
            ->paginate($currentLimit);
        return response()->json(
            [
                'success' => true,
                'message' => 'success get users',
                'data' =>
                    [
                        'users' => UserResource::collection($paginator->items()),
                    ],
                'page' => $currentPage,
                'total_page' => $paginator->lastPage(),
                'total_data' => $paginator->total()
            ]
        );
    }

    private function countInfraByType($type) {
        return Infrastructure::query()
            ->where('type', $type)
            ->count();
    }

    private function countInfraBySubType($subType) {
        return Infrastructure::query()
            ->where('sub_type', $subType)
            ->count();
    }

    private function countInfraByStatus($status) {
        return Infrastructure::query()
            ->where('status', $status)
            ->count();
    }

    private function countInfraByTypeAndStatus($type, $status) {
        return Infrastructure::query()
            ->where('type', $type)
            ->where('status', $status)
            ->count();
    }

    private function getReportMonthList($numberOfMonths) {
        $currentMonthNum  = idate("m");
        $reportMonthList = [];
        for($count = 0; $count < $numberOfMonths; $count++) {
            $dateObj   = DateTime::createFromFormat('!m', $currentMonthNum);
            $monthName = $dateObj->format('F');
            $reportMonthList[] = $monthName;

            $currentMonthNum--;
            if ($currentMonthNum == 0) {
                $currentMonthNum = 12;
            }
        }

        return array_reverse($reportMonthList);
    }

    private function getReportMonthInNumStringList($numberOfMonths) {
        $currentMonthNum  = idate("m");
        $reportMonthInNumStringList = [];
        for($count = 0; $count < $numberOfMonths; $count++) {
            if ($currentMonthNum == 0) {
                $currentMonthNum = 12;
            }
            if ($currentMonthNum < 10) {
                $reportMonthInNumStringList[] = '0' . $currentMonthNum;
            } else {
                $reportMonthInNumStringList[] = strval($currentMonthNum);
            }

            $currentMonthNum--;
        }

        return array_reverse($reportMonthInNumStringList);
    }

    private function countInfraByTypeAndMonth($type, $month) {
        return Infrastructure::query()
            ->where('type', $type)
            ->whereMonth('created_at', $month)
            ->count();
    }

    private function getInfraCountByTypeAndNumberOfMonthList($type, $numberOfMonths) {
        $infraCountByTypeAndNumberOfMonthList = [];
        $reportMonthStringList = $this->getReportMonthInNumStringList($numberOfMonths);

        foreach($reportMonthStringList as $reportMonthString) {
            $infraCountByTypeAndNumberOfMonthList[] = $this->countInfraByTypeAndMonth($type, $reportMonthString);
        }

        return $infraCountByTypeAndNumberOfMonthList;
    }
}
