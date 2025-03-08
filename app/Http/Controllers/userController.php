<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        dd($request->all());
        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName(); // Garante um nome único
            $path = $file->storeAs('uploads/files', $filename, 'public'); // Salva com o nome correto
            $user->file = $path;
        }

        $user->save();

        return response()->json([
            'message' => 'User added with success!',
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
