<?php

namespace App\Http\Controllers;

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

    public function show($id)
    {
        // Find the infrastructure by ID
        $infrastructure = Infrastructure::findOrFail($id);
        $message = 'Get Infrastructure by Id: ' . $id;
        // Return the infrastructure as a JSON response
        $infrastructure->details = json_decode($infrastructure->details);

        // return $this->sendResponse($infrastructure, $message);
        return $this->sendResponse($infrastructure, "Detail dari infrastructure " . $infrastructure->name);
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
            'details' => json_encode($request->input('details')),
            'image' => $request->input('image'),
        ]);

        $infrastructure->details = json_decode($infrastructure->details);
        //create infrastructure request record
        var_dump($infrastructure->status_approval);
        InfrastructureRequest::query()->create([
            'infrastructure_id' => $infrastructure->id,
            'user_id' => $user->id,
        ]);
        // Return the created infrastructure as a JSON response
        return $this->sendResponse($infrastructure, "Infrastructure Created");;
    }

    public function getDetail($id)
    {
        $infrastructure = Infrastructure::find($id);

        if (!$infrastructure) {
            return response()->json(['error' => 'Infrastructure not found'], 404);
        }

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