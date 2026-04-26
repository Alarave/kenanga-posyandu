<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{
    public function show(User $user)
    {
        // Cek apakah pengguna yang sedang login adalah pemilik data
        if (auth()->id() !== $user->id && !auth()->user()->isSuperAdmin()) {
            return response()->json(['message' => 'Unauthorized access.'], 403);
        }

        return response()->json($user);
    }

    public function update(\App\Http\Requests\UserRequest $request, User $user, \App\Services\UserService $userService)
    {
        // Cek apakah pengguna yang sedang login adalah pemilik data
        if (auth()->id() !== $user->id && !auth()->user()->isSuperAdmin()) {
            return response()->json(['message' => 'Unauthorized access.'], 403);
        }

        $userService->updateUser($user, $request->validated(), $request->input('is_active', $user->is_active));
        return response()->json($user);
    }

    public function index()
    {
        if (!auth()->user()->isSuperAdmin()) {
            return response()->json(['message' => 'Unauthorized access.'], 403);
        }
        return response()->json(User::all());
    }
}
