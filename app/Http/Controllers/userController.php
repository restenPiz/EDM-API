<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    public function index()
    {
        $users = User::all(); // Pega todos os usuários

        // Modifica a URL da imagem antes de retornar
        $users->transform(function ($user) {
            if (!empty($user->file) && !str_starts_with($user->file, 'http')) {
                $user->file = url('storage/' . $user->file);
            }
            return $user;
        });

        return response()->json(['users' => $users]);
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
        // \Log::info('Dados recebidos na API:', $request->all()); // Verifica os dados recebidos
        // \Log::info('Arquivo recebido:', [$request->file('file')]); // Verifica se o arquivo está chegando

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // Permite o mesmo email do usuário
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found!'], 404);
        }

        // Atualiza os dados do usuário
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Atualiza a senha apenas se for fornecida
        if (!empty($request->password)) {
            $updateData['password'] = bcrypt($request->password);
        }

        $user->update($updateData);

        // Verifica se um novo arquivo foi enviado
        if ($request->hasFile('file')) {
            \Log::info('Arquivo recebido:', [$request->file('file')]); // Debug do arquivo

            $filePath = $request->file('file')->store('uploads/files', 'public');
            $user->update(['file' => $filePath]); // Atualiza a imagem no banco de dados
        }

        return response()->json([
            'message' => 'User updated successfully!',
            'user' => $user
        ], 200);
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
