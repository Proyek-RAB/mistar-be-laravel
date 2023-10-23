<?php

namespace App\Http\Controllers;

use App\Models\InfrastructureSubType;
use Illuminate\Http\Request;

class InfrastructureSubTypeController extends Controller
{
    public function index()
    {
        $subTypes = InfrastructureSubType::all();
        return $this->sendResponse($subTypes, "List of all Infrastructure Sub Types");
    }

    public function show($id)
    {
        $subType = InfrastructureSubType::find($id);
        if ($subType) {
            return response()->json(['data' => $subType]);
        } else {
            return response()->json(['message' => 'SubType not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:infrastructure_types,id',
            'name' => 'required|string|unique:infrastructure_sub_types',
        ]);

        $subType = InfrastructureSubType::create([
            'type_id' => $request->type_id,
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'SubType created successfully', 'data' => $subType], 201);
    }

    public function update(Request $request, $id)
    {
        $subType = InfrastructureSubType::find($id);
        if (!$subType) {
            return response()->json(['message' => 'SubType not found'], 404);
        }

        $request->validate([
            'type_id' => 'required|exists:infrastructure_types,id',
            'name' => 'required|string|unique:infrastructure_sub_types,name,' . $subType->id,
        ]);

        $subType->update([
            'type_id' => $request->type_id,
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'SubType updated successfully', 'data' => $subType]);
    }

    public function destroy($id)
    {
        $subType = InfrastructureSubType::find($id);
        if (!$subType) {
            return response()->json(['message' => 'SubType not found'], 404);
        }

        $subType->delete();
        return response()->json(['message' => 'SubType deleted successfully']);
    }
}
