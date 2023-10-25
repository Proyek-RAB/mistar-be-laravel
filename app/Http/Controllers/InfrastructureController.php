<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInfrastructureRequest;
use App\Http\Requests\UpdateInfrastructureRequest;
use App\Http\Resources\InfrastructureCollection;
use App\Http\Resources\InfrastructureResource;
use App\Models\Infrastructure;
use Illuminate\Http\Request;

class InfrastructureController extends Controller
{
    public function index(Request $request)
    {
// Retrieve all infrastructures from the database
        $message = "Get All Infrastructure";
// Return the infrastructures as a JSON response
        $perPage = $request->query('per_page', 5);
        $infrastructures = Infrastructure::paginate($perPage);
// $infrastructures->data->data-> = json_decode($infrastructures->data->details);
        foreach ($infrastructures->items() as $infrastructure) {
            $infrastructure->details = json_decode($infrastructure->details);
        }

        return $this->sendResponse($infrastructures, $message);
    }

    public function get(Request $request)
    {
        $infraId = $request->route('id');
        $infrastructure = Infrastructure::query()
            ->where('id', $infraId)
            ->first();

        if ($infrastructure == null) {
            return response()->json([
                'success' => false,
                'message' => 'id not found',
                'data' => null
            ]);
        }
        return new InfrastructureResource($infrastructure);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInfrastructureRequest $request)
    {
        // the field has been automatically validated before the method is called
        // just use $request->input() like always to access every field needed
        $validated = $request->validated(); // get only the field in validation rule

        $infrastructure = Infrastructure::query()->create([
            'user_id' => auth()->user()->id,
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'sub_type' => $request->input('sub_type'),
            // TODO: check whether front end also send this as a request body
            'status' => Infrastructure::STATUS_GOOD,
            'approved_status' => false,
            'detail' => json_encode($request->input('detail')),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Infrastructure created',
            'data' => [
                'infrastructure_id' => $infrastructure->id,
            ],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Infrastructure $infrastructure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Infrastructure $infrastructure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInfrastructureRequest $request)
    {
        $infraId = $request->route('id');
        $infrastructure = Infrastructure::query()
            ->where('id', $infraId)
            ->first();

        if ($infrastructure == null) {
            return response()->json([
                'success' => false,
                'message' => 'id not found',
                'data' => null
            ]);
        }

        if ($request->input('name') != null) {
            $infrastructure->name = $request->input('name');
        }

        if ($request->input('detail') != null) {
            $infrastructure->detail = json_encode($request->input('detail'));
        }

        $infrastructure->save();

        return (new InfrastructureResource($infrastructure))->additional([
            'success' => true,
            'message' => 'infrastructure updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $infraId = $request->route('id');
        $infrastructure = Infrastructure::query()
            ->where('id', $infraId)
            ->first();

        if ($infrastructure == null) {
            return response()->json([
                'success' => false,
                'message' => 'id not found',
                'data' => null
            ]);
        }

       Infrastructure::destroy($infraId);

        return response()->json([
            'success' => true,
            'message' => 'successfully deleted',
            'data' => null
        ]);
    }
}
