<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jewelry;
use App\Models\Category; // 👉 Thêm dòng này để dùng model Category

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
        $categories = Category::all(); // Danh mục

        // Lấy image là đường dẫn file có is_main=1 cho từng jewelry
        foreach ($jewelries as $jewelry) {
            $mainFile = \App\Models\JewelryFile::where('jewelry_id', $jewelry->id)
                ->where('is_main', 1)
                ->with('file')
                ->first();
            $jewelry->image = $mainFile && $mainFile->file ? $mainFile->file->path : null;
        }

        // ✅ Lấy danh sách đá chính duy nhất, chuẩn hóa hoa/thường
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

        // ✅ Truyền vào view
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

        // Xử lý ảnh nếu có
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Lưu vào public/img/uploads/images
            $destinationPath = public_path('img/uploads/images');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $fileName = time() . '_' . $image->getClientOriginalName();
            $image->move($destinationPath, $fileName);
            $relativePath = $fileName;
            $validated['image'] = $relativePath;

            // Lưu vào bảng files
            $fileModel = new \App\Models\File();
            $fileModel->name = $image->getClientOriginalName();
            $fileModel->path = $relativePath;
            $fileModel->type = $image->getClientMimeType();
            $fileModel->size = filesize($destinationPath . DIRECTORY_SEPARATOR . $fileName);
            $fileModel->extension = $image->getClientOriginalExtension();
            $fileModel->is_deleted = false;
            $fileModel->save();
        }

        $jewelry = Jewelry::create($validated);

        // Nếu có file, lưu vào jewelry_files
        if (isset($fileModel) && isset($jewelry)) {
            $hasImage = \App\Models\JewelryFile::where('jewelry_id', $jewelry->id)->exists();
            $jewelryFile = new \App\Models\JewelryFile();
            $jewelryFile->jewelry_id = $jewelry->id;
            $jewelryFile->file_id = $fileModel->id;
            $jewelryFile->is_main = $hasImage ? 0 : 1;
            $jewelryFile->save();
        }

        return redirect()->route('admin.jewelries.index')
            ->with('success', 'Đã thêm trang sức thành công!');
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
            $image = $request->file('image');
            // Lưu vào public/img/uploads/images
            $destinationPath = public_path('img/uploads/images');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $fileName = time() . '_' . $image->getClientOriginalName();
            $image->move($destinationPath, $fileName);
            $relativePath = $fileName;
            $validated['image'] = $relativePath;

            // Lưu vào bảng files
            $fileModel = new \App\Models\File();
            $fileModel->name = $image->getClientOriginalName();
            $fileModel->path = $relativePath;
            $fileModel->type = $image->getClientMimeType();
            $fileModel->size = filesize($destinationPath . DIRECTORY_SEPARATOR . $fileName);
            $fileModel->extension = $image->getClientOriginalExtension();
            $fileModel->is_deleted = false;
            $fileModel->save();

            // Lưu vào bảng jewelry_files (giả sử jewelry_id, file_id)
            $hasImage = \App\Models\JewelryFile::where('jewelry_id', $jewelry->id)->exists();
            $jewelryFile = new \App\Models\JewelryFile();
            $jewelryFile->jewelry_id = $jewelry->id;
            $jewelryFile->file_id = $fileModel->id;
            $jewelryFile->is_main = $hasImage ? 0 : 1;
            $jewelryFile->save();
        }

        $jewelry->update($validated);

        return redirect()->route('admin.jewelries.index')
            ->with('success', 'Cập nhật trang sức thành công!');
    }

    public function destroy($id)
    {
        $jewelry = Jewelry::findOrFail($id);
        $jewelry->delete();

        return redirect()->route('admin.jewelries.index')->with('success', 'Xóa trang sức thành công!');
    }
}
