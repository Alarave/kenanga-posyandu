<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{
    public function show($id)
    {
        // Cek apakah pengguna yang sedang login adalah pemilik data
        $user = Auth::user();

        if ($user->id !== (int)$id) {
            return response()->json(['message' => 'Unauthorized access.'], 403); // Unauthorized if they try to access someone else's data
        }

        $user = User::findOrFail($id); // Ambil data user berdasarkan ID yang diberikan
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        // Cek apakah pengguna yang sedang login adalah pemilik data
        $user = Auth::user();

        if ($user->id !== (int)$id) {
            return response()->json(['message' => 'Unauthorized access.'], 403); // Unauthorized if they try to update someone else's data
        }

        $user = User::findOrFail($id);
        $user->update($request->all()); // Update user data
        return response()->json($user);
    }
}
