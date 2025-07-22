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
        $user->is_deleted = 1;
        $user->save();
        return redirect()->route('admin.users.index')->with('success', 'Customer deleted successfully.');
    }
}
