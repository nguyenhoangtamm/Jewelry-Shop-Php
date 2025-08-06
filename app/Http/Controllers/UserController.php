<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = User::where('is_deleted', 0);
        if ($search) {
            $query->where('username', 'like', "%$search%");
        }
        $users = $query->paginate(5);
        return view('admin.users.index', compact('users', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'date_of_birth' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['is_deleted'] = 0;

        User::create($validated);
        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);
        $user = User::findOrFail($id);
        $user->update($validated);
        return redirect()->route('admin.users.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->softDelete();
        return redirect()->route('admin.users.index')->with('success', 'Customer deleted successfully.');
    }
}
