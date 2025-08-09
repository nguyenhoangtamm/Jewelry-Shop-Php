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

        $page = $request->input('page');
        $redirect = redirect()->route('admin.users.index');
        if ($page) {
            $redirect = redirect()->route('admin.users.index', ['page' => $page]);
        }
        return $redirect->with('success', 'Customer updated successfully.');
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->is_deleted = 1;
        $user->save();

        $page = $request->input('page');
        $redirect = redirect()->route('admin.users.index');
        if ($page) {
            $redirect = redirect()->route('admin.users.index', ['page' => $page]);
        }
        return $redirect->with('success', 'Customer deleted successfully.');
    }

    public function lock(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->is_locked = $request->input('lock') ? 1 : 0;
        $user->save();

        return response()->json([
            'message' => $request->input('lock') ? 'Tài khoản đã bị khóa' : 'Tài khoản đã được mở khóa'
        ]);
    }

    public function toggleLock(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->is_locked = !$user->is_locked;
        $user->save();

        $page = $request->input('page');
        $redirect = redirect()->route('admin.users.index');
        if ($page) {
            $redirect = redirect()->route('admin.users.index', ['page' => $page]);
        }
        return $redirect->with('success', $user->is_locked ? 'Tài khoản đã bị khóa' : 'Tài khoản đã được mở khóa');
    }
}
