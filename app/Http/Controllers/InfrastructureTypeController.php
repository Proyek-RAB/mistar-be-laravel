<?php

namespace App\Http\Controllers;

use App\Models\InfrastructureType;
use Illuminate\Http\Request;

class InfrastructureTypeController extends Controller
{
    public function index()
    {
        $types = InfrastructureType::all();
        return $this->sendResponse($types, "List of All Infrastructure Type");
    }

    public function show($id)
    {
        $type = InfrastructureType::find($id);
        if ($type) {
            return $this->sendResponse($type, "List of All Infrastructure Type");
        } else {
            return $this->sendError($type, "Error");
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:infrastructure_types',
        ]);

        $type = InfrastructureType::create([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Type created successfully', 'data' => $type], 201);
    }

    public function update(Request $request, $id)
    {
        $type = InfrastructureType::find($id);
        if (!$type) {
            return response()->json(['message' => 'Type not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|unique:infrastructure_types,name,' . $type->id,
        ]);

        $type->update([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Type updated successfully', 'data' => $type]);
    }

    public function destroy($id)
    {
        $type = InfrastructureType::find($id);
        if (!$type) {
            return response()->json(['message' => 'Type not found'], 404);
        }

        $type->delete();
        return response()->json(['message' => 'Type deleted successfully']);
    }
}
