<?php

namespace App\Http\Controllers;

use App\Models\Pt;
use Illuminate\Http\Request;

class ptController extends Controller
{
    public function delete($id)
    {
        $pts = Pt::findOrFail($id);
        $pts->delete();

        return response()->json([
            'message' => 'Pt deleted with success!',
            'pts' => $pts
        ], 201);
    }
}
