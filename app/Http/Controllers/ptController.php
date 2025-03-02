<?php

namespace App\Http\Controllers;

use App\Models\Pt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ptController extends Controller
{
    public function index()
    {
        $pts = Pt::all();

        return response()->json([
            'pts' => $pts
        ], 201);
    }
    public function delete($id)
    {
        $pts = Pt::findOrFail($id);
        $pts->delete();

        return response()->json([
            'message' => 'Pt deleted with success!',
            'pts' => $pts
        ], 201);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:pts',
            'city' => 'required|string',
            'neighborhood' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pts = Pt::create([
            'name' => $request->name,
            'city' => $request->city,
            'neighborhood' => $request->neighborhood,
        ]);

        return response()->json([
            'message' => 'Pt added with success!',
            'pts' => $pts
        ], 201);
    }
    public function show($id)
    {
        $pt = Pt::find($id);

        if (!$pt) {
            return response()->json(['message' => 'PT não encontrado'], 404);
        }

        return response()->json($pt);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:pts',
            'city' => 'required|string',
            'neighborhood' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pt = Pt::find($id);
        if (!$pt) {
            return response()->json(['error' => 'Occurrence not found!'], 404);
        }

        $pt->update([
            'name' => $request->name,
            'city' => $request->city,
            'neighborhood' => $request->neighborhood,
        ]);

        return response()->json([
            'message' => 'Pt updated with success!',
            'pt' => $pt
        ], 200);
    }
}
