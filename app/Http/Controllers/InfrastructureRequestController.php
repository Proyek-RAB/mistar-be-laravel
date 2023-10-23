<?php

namespace App\Http\Controllers;

use App\Models\InfrastructureRequest;
use Illuminate\Http\Request;

class InfrastructureRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve all infrastructures from the database
        $message = "Get All Infrastructure Request";
        // Return the infrastructures as a JSON response
        $perPage = $request->query('per_page', 5);
        $infrastructuresRequest = InfrastructureRequest::paginate($perPage);
        // // $infrastructures->data->data-> = json_decode($infrastructures->data->details);
        // foreach ($infrastructuresRequest->items() as $infrastructure) {
        //     $infrastructure->details = json_decode($infrastructure->details);
        // }

        return $this->sendResponse($infrastructuresRequest, $message);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $infrastructureRequest = InfrastructureRequest::findOrFail($id);

        $request->validate([
            'status_approval'=>'required'
        ]);

        $infrastructureRequest->update($request->all());

        return $this->sendResponse($infrastructureRequest, "Infrastructure " . $infrastructureRequest->id . " updated");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
