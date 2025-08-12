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

        foreach ($jewelries as $jewelry) {
            $images = [];
            foreach ($jewelry->jewelryFiles as $file) {
                $images[] = $file->file;
            }
            $jewelry->setAttribute('images', $images);
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
        $jewelry->images = [];
        foreach ($jewelry->jewelryFiles as $file) {
            $jewelry->images[] = $file->file;
        }
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
                // Gỡ đánh dấu ảnh chính cũ
                \App\Models\JewelryFile::where('jewelry_id', $jewelry->id)
                    ->where('is_main', 1)
                    ->update(['is_main' => 0]);

                // Lưu ảnh mới làm ảnh chính
                $jewelryFile = new \App\Models\JewelryFile();
                $jewelryFile->jewelry_id = $jewelry->id;
                $jewelryFile->file_id = $fileModel->id;
                $jewelryFile->is_main = 1;
                $jewelryFile->save();
            }
        }


        $jewelry->update($validated);

        return redirect()->route('admin.jewelries.index')
            ->with('success', 'Cập nhật trang sức thành công!');
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


    // Lấy danh sách ảnh của sản phẩm
    public function getImages($id)
    {
        $jewelry = Jewelry::with(['jewelryFiles.file'])->findOrFail($id);
        $images = $jewelry->jewelryFiles->map(function ($jf) {
            return [
                'jewelry_file_id' => $jf->id,
                'url' => asset('img/uploads/images/' . $jf->file->path),
                'is_main' => $jf->is_main,
                'file_name' => $jf->file->name
            ];
        });
        return response()->json(['images' => $images]);
    }

    // Đặt ảnh chính cho sản phẩm
    public function setMainImage(Request $request, $id)
    {
        $jewelryFileId = $request->input('jewelry_file_id');
        // Gỡ đánh dấu ảnh chính cũ
        \App\Models\JewelryFile::where('jewelry_id', $id)->where('is_main', 1)->update(['is_main' => 0]);
        // Đặt ảnh mới làm ảnh chính
        \App\Models\JewelryFile::where('id', $jewelryFileId)->where('jewelry_id', $id)->update(['is_main' => 1]);
        return response()->json(['success' => true]);
    }

    // Thêm ảnh mới cho sản phẩm
    public function addImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $jewelry = Jewelry::findOrFail($id);

        if ($request->hasFile('image')) {
            // Upload file
            $fileModel = ImageHelper::uploadFile($request->file('image'));

            if ($fileModel) {
                // Tạo jewelry_file record
                $jewelryFile = new \App\Models\JewelryFile();
                $jewelryFile->jewelry_id = $jewelry->id;
                $jewelryFile->file_id = $fileModel->id;
                $jewelryFile->is_main = 0; // Ảnh mới không phải ảnh chính
                $jewelryFile->save();

                // Trả về thông tin ảnh mới
                return response()->json([
                    'success' => true,
                    'message' => 'Đã thêm ảnh thành công!',
                    'image' => [
                        'jewelry_file_id' => $jewelryFile->id,
                        'url' => asset('img/uploads/images/' . $fileModel->path),
                        'is_main' => false
                    ]
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi upload ảnh!'
        ]);
    }

    // Xóa ảnh sản phẩm (trừ ảnh chính)
    public function deleteImage($jewelryFileId)
    {
        $jewelryFile = \App\Models\JewelryFile::findOrFail($jewelryFileId);
        if ($jewelryFile->is_main) {
            return response()->json(['success' => false, 'message' => 'Không thể xóa ảnh chính']);
        }
        $jewelryFile->softDelete();
        return response()->json(['success' => true]);
    }

    // Đổi file ảnh cho 1 ảnh sản phẩm
    public function updateImage(Request $request, $jewelryFileId)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $jewelryFile = \App\Models\JewelryFile::findOrFail($jewelryFileId);
        if ($request->hasFile('image')) {
            $fileModel = ImageHelper::uploadFile($request->file('image'));
            if ($fileModel) {
                $jewelryFile->file_id = $fileModel->id;
                $jewelryFile->save();
                return response()->json(['success' => true, 'url' => asset('img/uploads/images/' . $fileModel->path)]);
            }
        }
        return response()->json(['success' => false]);
    }
}
