<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jewelry;

class JewelryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Jewelry::query();
        if ($search) {
            $query->where('name', 'like', "%$search%");
        }
        $jewelries = $query->paginate(5);
        return view('admin.jewelries.index', compact('jewelries', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        Jewelry::create($validated);

        return redirect()->route('admin.jewelries.index')->with('success', 'Jewelry created successfully.');
    }

    public function edit($id)
    {
        $jewelry = Jewelry::findOrFail($id);
        return view('admin.jewelries.edit', compact('jewelry'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $jewelry = Jewelry::findOrFail($id);
        $jewelry->update($validated);

        return redirect()->route('admin.jewelries.index')->with('success', 'Jewelry updated successfully.');
    }

    public function destroy($id)
    {
        $jewelry = Jewelry::findOrFail($id);
        $jewelry->delete();

        return redirect()->route('jewelries.index')->with('success', 'Jewelry deleted successfully.');
    }
}
