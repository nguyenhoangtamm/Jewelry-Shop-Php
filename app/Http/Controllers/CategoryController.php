<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Category::where('is_deleted', 0);
        if ($search) {
            $query->where('name', 'like', "%$search%");
        }
        $categories = $query->paginate(5);
        return view('admin.categories.index', compact('categories', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,NULL,id,is_deleted,0',
            'description' => 'nullable|string',
        ]);
        Category::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::with('file')->findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id . ',id,is_deleted,0',
            'description' => 'nullable|string',
        ]);
        $category = Category::findOrFail($id);
        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->softDelete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
