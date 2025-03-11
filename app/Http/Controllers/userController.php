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
            'email' => 'required|email|unique:users,email', // Garante e-mails únicos
            'password' => 'required|min:6', // Garante um mínimo de 6 caracteres
            'file' => 'required|file|mimes:jpg,png,pdf|max:2048' // Restrição de formato e tamanho
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
        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->id = $request->input('id');
        $user->email = $request->input('email');
        $user->password = $request->input('password');

        if ($request->hasFile('file')) {
            $user['file'] = $request->file('file')->store('uploads/files', 'public');
        }

        $user->save();

        return response()->json([
            'message' => 'User updated with success!',
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
