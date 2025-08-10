<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jewelry;
use App\Models\Category;
use App\Helpers\ImageHelper;

class JewelryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Jewelry::with(['category', 'jewelryFiles.file']);

        if ($search) {
            $query->where('name', 'like', "%$search%");
        }

        $jewelries = $query->orderBy('created_at', 'desc')->paginate(5);
        $categories = Category::where('is_deleted', 0)->get();

        // Thêm ảnh chính cho từng jewelry
        foreach ($jewelries as $jewelry) {
            $jewelry->main_image = ImageHelper::getMainImage($jewelry);
        }

        // Lấy danh sách đá chính duy nhất
        $mainStones = Jewelry::select('main_stone')
            ->whereNotNull('main_stone')
            ->distinct()
            ->pluck('main_stone')
            ->map(function ($stone) {
                return ucfirst(strtolower($stone));
            })
            ->unique()
            ->sort()
            ->values();
        return view('admin.jewelries.index', compact('jewelries', 'search', 'categories', 'mainStones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'main_stone' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'after_sales_policy' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sub_stone' => 'nullable|string',
            'gender' => 'nullable|string',
            'brand' => 'nullable|string',
        ]);

        // Tạo jewelry trước
        $jewelry = Jewelry::create($validated);

        // Xử lý ảnh nếu có
        if ($request->hasFile('image')) {
            $fileModel = ImageHelper::uploadFile($request->file('image'));

            if ($fileModel) {
                // Kiểm tra xem đã có ảnh chính chưa
                $hasMainImage = \App\Models\JewelryFile::where('jewelry_id', $jewelry->id)
                    ->where('is_main', 1)
                    ->exists();

                $jewelryFile = new \App\Models\JewelryFile();
                $jewelryFile->jewelry_id = $jewelry->id;
                $jewelryFile->file_id = $fileModel->id;
                $jewelryFile->is_main = !$hasMainImage ? 1 : 0; // Ảnh đầu tiên sẽ là ảnh chính
                $jewelryFile->save();
            }
        }

        $page = $request->input('page');
        $redirect = redirect()->route('admin.jewelries.index');
        if ($page) {
            $redirect = redirect()->route('admin.jewelries.index', ['page' => $page]);
        }
        return $redirect->with('success', 'Đã thêm trang sức thành công!');
    }

    public function edit($id)
    {
        $jewelry = Jewelry::with(['category', 'jewelryFiles.file'])->findOrFail($id);
        $categories = Category::where('is_deleted', 0)->get();

        // Lấy ảnh chính của jewelry
        $jewelry->current_image = ImageHelper::getMainImage($jewelry);

        return view('admin.jewelries.edit', compact('jewelry', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'main_stone' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'after_sales_policy' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sub_stone' => 'nullable|string',
            'gender' => 'nullable|string',
            'brand' => 'nullable|string',
        ]);

        $jewelry = Jewelry::findOrFail($id);

        // Xử lý ảnh nếu có upload mới
        if ($request->hasFile('image')) {
            $fileModel = ImageHelper::uploadFile($request->file('image'));

            if ($fileModel) {
                // Lưu vào bảng jewelry_files
                $hasMainImage = \App\Models\JewelryFile::where('jewelry_id', $jewelry->id)
                    ->where('is_main', 1)
                    ->exists();

                $jewelryFile = new \App\Models\JewelryFile();
                $jewelryFile->jewelry_id = $jewelry->id;
                $jewelryFile->file_id = $fileModel->id;
                $jewelryFile->is_main = !$hasMainImage ? 1 : 0;
                $jewelryFile->save();
            }
        }

        $jewelry->update($validated);

        $page = $request->input('page');
        $redirect = redirect()->route('admin.jewelries.index');
        if ($page) {
            $redirect = redirect()->route('admin.jewelries.index', ['page' => $page]);
        }
        return $redirect->with('success', 'Cập nhật trang sức thành công!');
    }

    public function destroy(Request $request, $id)
    {
        $jewelry = Jewelry::findOrFail($id);
        $jewelry->softDelete();

        $page = $request->input('page');
        $redirect = redirect()->route('admin.jewelries.index');
        if ($page) {
            $redirect = redirect()->route('admin.jewelries.index', ['page' => $page]);
        }
        return $redirect->with('success', 'Xóa trang sức thành công!');
    }
}
