<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json([
            'users' => $users
        ], 201);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName(); // Garante nome único
            $path = $file->storeAs('uploads/files', $filename, 'public'); // Salva no storage

            if (!$path) {
                return response()->json(['error' => 'Failed to upload file'], 500);
            }

            $user->update(['file' => $path]);
        }

        return response()->json([
            'message' => 'User added successfully!',
            'user' => $user
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName(); // Garante nome único
            $path = $file->storeAs('uploads/files', $filename, 'public'); // Salva no storage

            if (!$path) {
                return response()->json(['error' => 'Failed to upload file'], 500);
            }

            $user->update(['file' => $path]);
        }

        return response()->json([
            'message' => 'User updated successfully!',
            'user' => $user
        ], 201);
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'message' => 'User deleted with success!',
            'user' => $user
        ], 201);
    }
}
