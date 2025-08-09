<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Helpers\ImageHelper;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Category::with('file')->where('is_deleted', 0);
        if ($search) {
            $query->where('name', 'like', "%$search%");
        }
        $categories = $query->paginate(5);

        // Thêm thuộc tính image cho từng category
        foreach ($categories as $cat) {
            $cat->image = $cat->file ? ImageHelper::getImageUrl($cat->file->path) : null;
        }

        return view('admin.categories.index', compact('categories', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,NULL,id,is_deleted,0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fileId = null;

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('image')) {
            $fileModel = ImageHelper::uploadFile($request->file('image'));
            if ($fileModel) {
                $fileId = $fileModel->id;
            }
        }

        Category::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'file_id' => $fileId,
        ]);

        $page = $request->input('page');
        $redirect = redirect()->route('admin.categories.index');
        if ($page) {
            $redirect = redirect()->route('admin.categories.index', ['page' => $page]);
        }
        return $redirect->with('success', 'Category created successfully.');
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = Category::findOrFail($id);

        // Xử lý upload ảnh mới nếu có
        if ($request->hasFile('image')) {
            $fileModel = ImageHelper::uploadFile($request->file('image'));
            if ($fileModel) {
                $category->file_id = $fileModel->id;
            }
        }

        $category->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        $page = $request->input('page');
        $redirect = redirect()->route('admin.categories.index');
        if ($page) {
            $redirect = redirect()->route('admin.categories.index', ['page' => $page]);
        }
        return $redirect->with('success', 'Category updated successfully.');
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->softDelete();

        $page = $request->input('page');
        $redirect = redirect()->route('admin.categories.index');
        if ($page) {
            $redirect = redirect()->route('admin.categories.index', ['page' => $page]);
        }
        return $redirect->with('success', 'Category deleted successfully.');
    }
}
