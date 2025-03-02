<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function save(Request $request)
    {
        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');

        if ($request->hasFile('file')) {
            $user['file'] = $request->file('file')->store('uploads/files', 'public');
        }

        $user->save();

        return response()->json([
            'message' => 'User added with success!',
            'user' => $user
        ], 201);
    }
}
