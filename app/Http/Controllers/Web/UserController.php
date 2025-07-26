<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.user-management.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user-management.create');
    }

    public function store(UserRequest $request)
    {
        User::create($request->validated());
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('admin.user-management.details', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.user-management.update', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
