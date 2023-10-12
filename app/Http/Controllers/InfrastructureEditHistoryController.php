<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfrastructureEditHistory;
use Illuminate\Support\Str;
use App\Http\Requests\InfraEditHistoryRequest;

class InfrastructureEditHistoryController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve all infrastructures from the database
        $message = "Get All Infrastructure Edit History";
        // Return the infrastructures as a JSON response
        $perPage = $request->query('per_page', 5);
        $infrastructures = InfrastructureEditHistory::paginate($perPage);


        return $this->sendResponse($infrastructures, $message);
    }

    public function addToHistory($request) {
        $request->validate([
            'id' => 'required',
            'infrastructure_id' => 'required',
            'user_id' => 'required',
            'details' => 'required',
        ]);
        $editHistory = InfrastructureEditHistory::create([
            'id'=> Str::uuid(),
            'infrastructure_id' => $request->id,
            'user_id' => auth()->id(), // Assuming you are using authentication
            'details' => $request, // Store the original details as JSON
        ]);

        return $this->sendResponse($editHistory, "History for id". $request->id . "Created");
    }

    // public function show($id)
    // {
    //     // Find the infrastructure by ID
    //     $infrastructure = InfrastructureEditHistory::findOrFail($id);
    //     $message = 'Get Infrastructure by Id: ' . $id;
    //     // Return the infrastructure as a JSON response

    //     return $this->sendResponse($infrastructure, $message);
    // }

    // public function store(Request $request)
    // {
    //     // Validate the incoming request data
    //     $request->validate([
    //         'user_id' => 'required|uuid',
    //         'sub_type_id' => 'required|integer',
    //         'name' => 'required|string',
    //         'details' => 'required|json',
    //         'status' => 'required|string',
    //     ]);

    //     // Create a new infrastructure record
    //     $infrastructure = InfrastructureEditHistory::create($request->all());

    //     // Return the created infrastructure as a JSON response

    //     return response()->json($infrastructure, 201);
    // }

    // public function update(Request $request, $id)
    // {
    //     // Find the infrastructure by ID
    //     $infrastructure = InfrastructureEditHistory::findOrFail($id);
    //     $beforeUpdate = $infrastructure->getAttributes();
    //     // Validate the incoming request data
    //     $request->validate([
    //         'user_id' => 'required',
    //         'sub_type_id' => 'required',
    //         'name' => 'required',
    //         'details' => 'required',
    //         'status' => 'required',
    //     ]);
    //     var_dump($beforeUpdate);
    //     InfrastructureEditHistory::create([
    //         'infrastructure_id' => $infrastructure->id,
    //         'user_id' => auth()->id(), // Assuming you are using authentication
    //         'details' => json_encode($beforeUpdate), // Store the original details as JSON
    //     ]);

    //     // Update the infrastructure record
    //     $infrastructure->update($request->all());

    //     // Return the updated infrastructure as a JSON response
    //     return response()->json($infrastructure);
    // }

    // public function destroy($id)
    // {
    //     // Find the infrastructure by ID
    //     $infrastructure = InfrastructureEditHistory::findOrFail($id);

    //     // Delete the infrastructure record
    //     $infrastructure->delete();

    //     // Return a success message
    //     return response()->json(['message' => 'Infrastructure deleted successfully']);
    // }
}
