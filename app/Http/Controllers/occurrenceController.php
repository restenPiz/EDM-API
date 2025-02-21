<?php

namespace App\Http\Controllers;

use App\Models\Occurrence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class occurrenceController extends Controller
{
    public function index()
    {
        $occurrences = Occurrence::with(['user', 'board'])->latest()->get();

        return response()->json($occurrences);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'board_id' => 'required|exists:boards,id',
            'status' => 'required|string|in:pending,in_progress,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $occurrence = Occurrence::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'user_id' => $request->user_id,
            'board_id' => $request->board_id,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Occurrence added with success!',
            'occurrence' => $occurrence
        ], 201);
    }
    public function delete($id)
    {
        $occurrence = Occurrence::findOrFail($id);

        $occurrence->delete();

        return response()->json([
            'message' => 'Occurrence deleted with success!',
            'occurrence' => $occurrence
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'board_id' => 'required|exists:boards,id',
            'status' => 'required|string|in:pending,in_progress,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $occurrence = Occurrence::find($id);
        if (!$occurrence) {
            return response()->json(['error' => 'Occurrence not found!'], 404);
        }

        $occurrence->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'user_id' => $request->user_id,
            'board_id' => $request->board_id,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Occurrence updated with success!',
            'occurrence' => $occurrence
        ], 200);
    }

}
