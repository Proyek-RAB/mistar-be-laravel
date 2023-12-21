<?php

namespace App\Http\Controllers;

use App\Http\Resources\InfrastructureHistoryResource;
use App\Http\Resources\InfrastructureResource;
use App\Http\Resources\InfrastructureSearchResource;
use App\Http\Resources\InfrastructureWebResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Infrastructure;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\StoreInfrastructureRequest;
use App\Models\InfrastructureEditHistory;
use App\Models\InfrastructureRequest;
use App\Models\InfrastructureSubType;
use Illuminate\Support\Str;
use App\Models\InfrastructureType;


class InfrastructureController extends Controller
{
    public function index(Request $request)
    {
        $currentPage = 1;
        $currentLimit = 20000;
        if( $request->has('page') && ctype_digit($request->query('page'))) {
            $currentPage = intval($request->query('page'));
        }
        if( $request->has('limit') && ctype_digit($request->query('limit'))) {
            $currentLimit = intval($request->query('limit'));
        }

        $paginator = null;
        if ($request->has('zip_code')) {
            $zipCode = $request->input('zip_code');
            $paginator = Infrastructure::query()->where('zip_code', $zipCode)->paginate($currentLimit);
        } else if ($request->has('status_approval')) {
            $status_approval = $request->input('status_asspproval');
            $paginator = Infrastructure::query()->where('status_approval', $status_approval)->paginate($currentLimit);
        }
        else if ($request->has('sub_type')) {
            $paginator = Infrastructure::query();
            foreach($request->input('sub_type') as $subType) {
                $subTypeExist = InfrastructureSubType::query()->where('name', $subType)->first();
                if ($subTypeExist != null) {
                    $paginator = $paginator->orWhere('sub_type', $subType);
                }
            }
            $paginator = $paginator->paginate($currentLimit);
        } else {
            $paginator = Infrastructure::query()
                ->paginate($currentLimit);
        }
        $user = auth()->user();

        $channelId = $request->header('CHANNELID', 'MOBILE');

        if ($channelId == 'WEB') {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'success get all infrastructures',
                    'data' => InfrastructureWebResource::collection($paginator->items()),
                    'page' => $currentPage,
                    'total_page' => $paginator->lastPage(),
                    'total_data' => $paginator->total()
                ]
            );
        }

        // dd($paginator);

        //filtering si pemilik user, dan seluruh user.
        // foreach(InfrastructureResource::collection($paginator->items()) as $item){
        //     if ($item->created_by != $user->full_name && $item->approval_status == Infrastructure::STATUS_APPROVAL_REQUESTED)  {
        //         $data->push($item);
        //     }
        // }

        $requestedData = InfrastructureResource::collection($paginator->items())
            ->where('status_approval', Infrastructure::STATUS_APPROVAL_REQUESTED);

        $userData = InfrastructureResource::collection($paginator->items())
            ->where('user_id', $user->id)
            ->where('status_approval', '<>',Infrastructure::STATUS_APPROVAL_REQUESTED);

        $combinedData = $requestedData->concat($userData);

        // If you want to get the final result as an array, you can use the all() method
        $resultArray = $combinedData->all();

        return response()->json(
            [
                'success' => true,
                'message' => 'success get all infrastructures',
                'data' => $combinedData,
                'page' => $currentPage,
                'total_page' => $paginator->lastPage(),
                'total_data' => $paginator->total()
            ]
        );
    }

    public function getInfrastructureHistory(Request $request)
    {
        $currentPage = 1;
        $currentLimit = 20;
        if( $request->has('page') && ctype_digit($request->query('page'))) {
            $currentPage = intval($request->query('page'));
        }
        if( $request->has('limit') && ctype_digit($request->query('limit'))) {
            $currentLimit = intval($request->query('limit'));
        }
        $paginator = Infrastructure::query()
            ->where('user_id', auth()->user()->id)
                ->where('status_approval', $request->query('status_approval'))
            ->paginate($currentLimit);
        return response()->json(
            [
                'success' => true,
                'message' => 'success get all infrastructures',
                'data' => InfrastructureHistoryResource::collection($paginator->items()),
                'page' => $currentPage,
                'total_page' => $paginator->lastPage(),
                'total_data' => $paginator->total()
            ]
        );
    }

    public function getSelfInfrastructureDashboardCount(Request $request)
    {
        $requestedCount = Infrastructure::query()
            ->where('user_id', auth()->user()->id)
            ->where('status_approval', Infrastructure::STATUS_APPROVAL_REQUESTED)
            ->count();
        $acceptedCount = Infrastructure::query()
            ->where('user_id', auth()->user()->id)
            ->where('status_approval', Infrastructure::STATUS_APPROVAL_APPROVED)
            ->count();
        $totalCount = $requestedCount + $acceptedCount;
        return response()->json(
            [
                'success' => true,
                'message' => 'success get history infrastructure count',
                'data' => [
                    'total_count' => $totalCount,
                    'requested_count' => $requestedCount,
                    'accepted_count' => $acceptedCount,
                ],
            ]
        );
    }

    public function getSelfInfrastructureDashboardCountBySubTypeId(Request $request)
    {
        $subTypeIdList = $request->input('sub_type_id_list');
        $infrastructureSubTypeList = [];
        if ($subTypeIdList[0] == 0) {
            $infrastructureSubTypeList = InfrastructureSubType::query()
                ->orderBy('id', 'asc')
                ->get();
        } else {
            $idExist = [];
            sort($subTypeIdList);
            foreach($subTypeIdList as $subTypeId) {
                if ($subTypeId == 0) {
                    $infrastructureSubTypeList = InfrastructureSubType::query()
                        ->orderBy('id', 'asc')
                        ->get();
                    break;
                } else if (!array_key_exists($subTypeId, $idExist)) {
                    $infrastructureSubTypeList[] = InfrastructureSubType::query()
                        ->where('id', $subTypeId)
                        ->first();
                    $idExist[$subTypeId] = true;
                }
            }
        }

        $responseList = [];
        foreach($infrastructureSubTypeList as $infrastructureSubType) {
            $responseList[] = [
                'icon_url' => $infrastructureSubType->icon_url,
                'name' => 'Infrastruktur ' . $infrastructureSubType->name,
                'count' => Infrastructure::query()
                    ->where('sub_type_id', $infrastructureSubType->id)
                    ->count()
            ];
        }

        return response()->json(
            [
                'success' => true,
                'message' => 'success get history infrastructure by subtype count',
                'data' => $responseList,
            ]
        );
    }

    public function show($id, Request $request)
    {
        // Find the infrastructure by ID
        $infrastructure = Infrastructure::findOrFail($id);
        $message = 'Get Infrastructure by Id: ' . $id;
        // Return the infrastructure as a JSON response
        $channelId = $request->header('CHANNELID', 'MOBILE');

        if ($channelId == 'WEB') {
            return response()->json([
                'success' => true,
                'message' => 'success get infrastructure by id',
                'data' => new InfrastructureWebResource($infrastructure)
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'success get infrastructure by id',
            'data' => new InfrastructureResource($infrastructure)
        ]);
    }


    public function store(StoreInfrastructureRequest $request)
    {
        // Validate the incoming request data
        // $validated = $request->validated();
        // $request->validate([
        //     'user_id' => 'required',
        //     'sub_type_id' => 'required',
        //     'name' => 'required',
        //     'details' => 'required',
        //     'status' => 'required',
        // ]);

        $validated = $request->validated();
        $type = InfrastructureType::find($validated['type_id'])->name;
        $sub_type = InfrastructureSubType::find($validated['sub_type_id'])->name;
        $user = auth()->user();


        // Create a new infrastructure record
        $infrastructure = Infrastructure::query()->create([
            'name' => $request->input('name'),
            'user_id' => $user->id,
            'sub_type_id' => $request->input('sub_type_id'),
            'sub_type' => $sub_type,
            'type_id'=> $request->input('type_id'),
            'type' => $type,
            'status' => $request->input('status'),
            'zip_code' => $request->input('zip_code'),
            'details' => json_encode($request->input('details')),
            'zip_code'=> $request->input('zip_code'),
            'image' => $request->input('image'),
        ]);

        if ($request->hasFile('images')) {
            if ($infrastructure == null) {
                return response()->json([
                    'message' => 'not found'
                ]);
            }

            foreach ($request->file('images') as $file) {
                $infrastructure->addMedia($file)->toMediaCollection(Infrastructure::THUMBNAIL_IMAGES);
            }
        }

        $infrastructure->details = json_decode($infrastructure->details);
        //create infrastructure request record
        InfrastructureRequest::query()->create([
            'infrastructure_id' => $infrastructure->id,
            'user_id' => $user->id,
        ]);
        // Return the created infrastructure as a JSON response
        return $this->sendResponse($infrastructure, "Infrastructure Created");
    }

    public function getDetail($id, Request $request)
    {
        // Find the infrastructure by ID
        $infrastructure = Infrastructure::findOrFail($id);
        $message = 'Get Infrastructure by Id: ' . $id;
        // Return the infrastructure as a JSON response
        $channelId = $request->header('CHANNELID', 'MOBILE');

        if ($channelId == 'WEB') {
            return response()->json([
                'success' => true,
                'message' => 'success get infrastructure by id',
                'data' => new InfrastructureWebResource($infrastructure)
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'success get infrastructure by id',
            'data' => new InfrastructureResource($infrastructure)
        ]);
    }

    public function approve($id)
    {
        $infrastructure = Infrastructure::query()
        ->where('id', $id)
        ->update([
            'status_approval' => Infrastructure::STATUS_APPROVAL_APPROVED
        ]);

        return response()->json(
            [
                'success' => true,
                'message' => 'infrastructure has been succesfully approved',
                'data' => null
            ]
        );
    }

    public function deny($id)
    {
        $infrastructure = Infrastructure::query()
            ->where('id', $id)
            ->update([
                'status_approval' => Infrastructure::STATUS_APPROVAL_REJECTED
            ]);

        return response()->json(
            [
                'success' => true,
                'message' => 'infrastructure has been succesfully rejected',
                'data' => null
            ]
        );
    }

    public function changeStatus($id, Request $request)
    {
        $infrastructure = Infrastructure::query()
            ->where('id', $id)
            ->update([
                'status' => $request->query('status')
            ]);

        return response()->json(
            [
                'success' => true,
                'message' => 'infrastructure status has been succesfully changed',
                'data' => null
            ]
        );
    }


    public function update(Request $request, $id)
    {
        // Find the infrastructure by ID
        $infrastructure = Infrastructure::findOrFail($id);
        // $beforeUpdate = $infrastructure;
        // $beforeUpdate->details = json_decode($beforeUpdate->details);
        // InfrastructureEditHistory::query()->create([
        //     'id'=> Str::uuid(),
        //     'infrastructure_id' => $infrastructure->id,
        //     'user_id' => auth()->id(), // Assuming you are using authentication
        //     'details' => $beforeUpdate->toJson(), // Store the original details as JSON
        // ]);

        // Validate the incoming request data
        $request->validate([
            'user_id' => 'required',
            'sub_type_id' => 'required',
            'name' => 'required',
            'details' => 'required',
        ]);

        $infrastructure->update($request->all());

        // Return the updated infrastructure as a JSON response
        return response()->json($infrastructure);
    }

    public function destroy($id)
    {
        // Find the infrastructure by ID
        $infrastructure = Infrastructure::findOrFail($id);
        // Delete related records first
        // InfrastructureEditHistory::where('infrastructure_id', $id)->delete();
        // InfrastructureRequest::where('infrastructure_id', $infrastructureId)->delete();

        // Delete the infrastructure record
        $infrastructure->delete();

        // Return a success message
        return $this->sendResponse($infrastructure, "Infrastructure with id" . $id . " succesfully deleted");
    }

    public function searchInfrastructure(Request $request) {
        $infrastructures = null;
        if ($request->has('sub_type')) {
            $infrastructures = Infrastructure::query();
            foreach($request->input('sub_type') as $subType) {
                $subTypeExist = InfrastructureSubType::query()->where('name', $subType)->first();
                if ($subTypeExist != null) {
                    $infrastructures = $infrastructures->orWhere('sub_type', $subType);
                }
            }
            $infrastructures = $infrastructures
                ->where('name', 'like', '%' . $request->query('keyword') . '%')
                ->limit(5)
                ->get();
        } else {
            $infrastructures = Infrastructure::query()
                ->where('name', 'like', '%' . $request->query('keyword') . '%')
                ->limit(5)
                ->get();
        }

            
        return response()->json([
            'success' => true,
            'message' => 'search infrastructure success',
            'data' => InfrastructureSearchResource::collection($infrastructures)
        ]);
    }
}
