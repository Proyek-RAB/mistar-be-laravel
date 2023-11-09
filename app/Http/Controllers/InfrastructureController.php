<?php

namespace App\Http\Controllers;

use App\Http\Resources\InfrastructureResource;
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
        $currentLimit = 20;
        if( $request->has('page') && ctype_digit($request->query('page'))) {
            $currentPage = intval($request->query('page'));
        }
        if( $request->has('limit') && ctype_digit($request->query('limit'))) {
            $currentLimit = intval($request->query('limit'));
        }
        $paginator = Infrastructure::query()
            ->paginate($currentLimit);
        return response()->json(
            [
                'success' => true,
                'message' => 'success get all infrastructures',
                'data' => InfrastructureResource::collection($paginator->items()),
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
                'data' => InfrastructureResource::collection($paginator->items()),
                'page' => $currentPage,
                'total_page' => $paginator->lastPage(),
                'total_data' => $paginator->total()
            ]
        );
    }

    public function show($id)
    {
        // Find the infrastructure by ID
        $infrastructure = Infrastructure::findOrFail($id);
        $message = 'Get Infrastructure by Id: ' . $id;
        // Return the infrastructure as a JSON response
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
            'details' => json_encode($request->input('details')),
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

    public function getDetail($id)
    {
        $infrastructure = Infrastructure::find($id);

        if (!$infrastructure) {
            return response()->json(['error' => 'Infrastructure not found'], 404);
        }

        return $this->sendResponse(json_decode($infrastructure->details), "Detail dari infrastructure " . $infrastructure->name);
    }

    public function approve($id)
    {
        $infrastructure = Infrastructure::query()
        ->where('id', $id)
        ->update([
            'status_approval' => Infrastructure::STATUS_APPROVAL_APPROVED
        ]);

        return $this->sendResponse(json_decode($infrastructure->details), "Detail dari infrastructure " . $infrastructure->name);
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


}
