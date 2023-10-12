<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Infrastructure;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\StoreInfrastructureRequest;
use App\Models\InfrastructureEditHistory;
use Illuminate\Support\Str;


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

        return $this->sendResponse($infrastructure, $message);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        // $validated = $request->validated();
        $request->validate([
            'user_id' => 'required',
            'sub_type_id' => 'required',
            'name' => 'required',
            'details' => 'required',
            'status' => 'required',
        ]);

        // Create a new infrastructure record
        $infrastructure = Infrastructure::query()->create([
            'user_id' => auth()->id(),
            'sub_type_id' => $request->input('sub_type_id'),
            'name' => $request->input('name'),
            'details' => json_encode($request->input('details')),
            'status' => 'hold',
        ]);

        $infrastructure->details = json_decode($infrastructure->details);

        // Return the created infrastructure as a JSON response
        return $this->sendResponse($infrastructure, "Infrastructure Created");;
    }

    public function update(Request $request, $id)
    {
        // Find the infrastructure by ID
        $infrastructure = Infrastructure::findOrFail($id);
        $beforeUpdate = $infrastructure;
        $beforeUpdate->details = json_decode($beforeUpdate->details);
        InfrastructureEditHistory::query()->create([
            'id'=> Str::uuid(),
            'infrastructure_id' => $infrastructure->id,
            'user_id' => auth()->id(), // Assuming you are using authentication
            'details' => $beforeUpdate->toJson(), // Store the original details as JSON
        ]);

        // Validate the incoming request data
        $request->validate([
            'user_id' => 'required',
            'sub_type_id' => 'required',
            'name' => 'required',
            'details' => 'required',
            'status' => 'required',
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
        InfrastructureEditHistory::where('infrastructure_id', $id)->delete();
        // InfrastructureRequest::where('infrastructure_id', $infrastructureId)->delete();

        // Delete the infrastructure record
        $infrastructure->delete();

        // Return a success message
        return $this->sendResponse($infrastructure, "Infrastructure with id" . $id . " succesfully deleted");
        }

}
