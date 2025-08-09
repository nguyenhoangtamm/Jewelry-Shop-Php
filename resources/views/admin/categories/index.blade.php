@extends('admin.layouts.app')
@section('title', 'Quản lý danh mục')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #0f0f23 0%, #1a1a3a 50%, #2d2d5f 100%);
        min-height: 100vh;
        color: #ffffff;
    }

    /* Table Wrapper */
    .table-wrapper {
        margin: 20px;

        background: linear-gradient(135deg, #8cb0f2 0%, #e6e6e7 100%);
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 8px 32px rgba(30, 60, 114, 0.3);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Table Header */
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid rgba(135, 207, 235, 0.571);
    }

    .main-title {
        font-size: 28px;
        font-weight: 600;
        color: #ffffff;
        text-shadow: 0 2px 4px rgba(149, 25, 25, 0.3);
    }

    .add-category {
        background: linear-gradient(135deg, #4a90e2 0%, #6bb6ff 100%);
        color: white;
        padding: 12px 20px;
        border-radius: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .add-category:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 144, 226, 0.6);
        background: linear-gradient(135deg, #5ba0f2 0%, #7cc5ff 100%);
    }

    .icon-add {
        font-size: 14px;
    }

    /* Alert Success */
    .alert-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    /* Table Container */
    .table-container {
        background: rgba(157, 133, 133, 0.05);
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    #category-table {
        width: 100%;
        border-collapse: collapse;
    }

    #category-table thead th {
        background: linear-gradient(135deg, #1f2fdf 0%, #41a0d3 100%);
        color: #ffffff;
        padding: 15px;
        text-align: left;
        font-weight: 600;
        font-size: 16px;
        border-bottom: 2px solid rgba(135, 206, 235, 0.3);
    }

    #category-table tbody tr {
        background: rgba(255, 255, 255, 0.03);
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    #category-table tbody tr:hover {
        background: rgba(103, 184, 216, 0.1);
        transform: translateX(5px);
    }

    #category-table tbody td {
        padding: 15px;
        color: #000000;
    }

    /* Action Buttons */
    .icon-change,
    .icon-delete {
        padding: 8px 12px;
        margin: 0 5px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .icon-change {
        background: linear-gradient(135deg, #ffc107 0%, #ffed4e 100%);
        color: #333;
    }

    .icon-change:hover {
        background: linear-gradient(135deg, #ffed4e 0%, #fff59d 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
    }

    .icon-delete {
        background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%);
        color: white;
    }

    .icon-delete:hover {
        background: linear-gradient(135deg, #ff6b6b 0%, #ff8e8e 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.05);
        margin-top: 20px;
        border-radius: 10px;
    }

    .pagination a {
        padding: 10px 15px;
        background: linear-gradient(135deg, #7ea5ee 0%, #2a5298 100%);
        color: #87ceeb;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .pagination a:hover,
    .pagination a.page-current {
        background: linear-gradient(135deg, #4a90e2 0%, #6bb6ff 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4);
    }

    /* Modal Styles */
    .modal,
    .modal-delete {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        backdrop-filter: blur(5px);
    }

    .modal-container,
    .modal-delete-container {
        background: linear-gradient(135deg, #ffffff 0%, #f9f9f9 100%);
        border-radius: 15px;
        width: 500px;
        max-width: 90vw;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        position: relative;
    }

    .modal-close,
    .modal-delete-close {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: #87ceeb;
        font-size: 20px;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-close:hover,
    .modal-delete-close:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(90deg);
    }

    .modal-header {
        background: linear-gradient(135deg, #2a5298 0%, #3d72b4 100%);
        padding: 20px 25px;
        border-radius: 15px 15px 0 0;
        font-size: 20px;
        font-weight: 600;
        color: #000000;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-heading-icon {
        font-size: 18px;
    }

    .modal-content {
        padding: 25px;
    }

    .modal-col {
        margin-bottom: 20px;
    }

    .modal-label {
        display: block;
        color: #000000;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .modal-input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid rgba(135, 206, 235, 0.3);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.1);
        color: rgb(0, 0, 0);
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .modal-input:focus {
        outline: none;
        border-color: #87ceeb;
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 0 10px rgba(135, 206, 235, 0.3);
    }

    .modal-input::placeholder {
        color: rgba(255, 255, 255, 0);
    }

    /* Action Form */
    .action-form {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 25px;
    }

    .cancel-book,
    .submit-book {
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .cancel-book {
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff00;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .cancel-book:hover {
        background: rgba(7, 81, 133, 0);
        transform: translateY(-2px);
    }

    .submit-book {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: rgb(0, 0, 0);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .submit-book:hover {
        background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
    }

    /* Delete Modal */
    .modal-delete-body {
        padding: 30px;
        text-align: center;
    }

    .modal-delete-body p {
        font-size: 18px;
        margin-bottom: 25px;
        color: #2227c1;
    }

    .btn-delete-choose {
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .btn-yes,
    .btn-no {
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-yes {
        background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%);
        color: white;
    }

    .btn-yes:hover {
        background: linear-gradient(135deg, #ff6b6b 0%, #ff8e8e 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
    }

    .btn-no {
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-no:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .table-wrapper {
            margin: 10px;
            padding: 15px;
        }

        .table-header {
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
        }

        .main-title {
            font-size: 24px;
            text-align: center;
        }

        .modal-container {
            width: 95vw;
            margin: 10px;
        }

        #category-table {
            font-size: 14px;
        }

        #category-table thead th,
        #category-table tbody td {
            padding: 10px 8px;
        }

        .action-form {
            flex-direction: column;
        }

        .cancel-book,
        .submit-book {
            width: 100%;
        }
    }
</style>
<div class="table-wrapper">
    <div class="table-header">
        <h3 class="main-title">Thông tin danh mục</h3>
        <div class="add-book add-category js-add-category"><i class="fa-solid fa-plus icon-add"></i>Thêm danh mục</div>
    </div>

    {{-- Thông báo thành công --}}
    @if (session('success'))
    <div class="alert alert-success" id="success-toast">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('success-toast');
            if (toast) toast.style.display = 'none';
        }, 3000);
    </script>
    @endif

    <div class="table-container" name="category-table">
        <table id="category-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Hình ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td class="category-id">{{ $category->id }}</td>
                    <td class="category-name">{{ $category->name }}</td>
                    <td class="category-description">{{ $category->description }}</td>
                    <td>
                        @if ($category->file && $category->file->path)
                        <img src="{{ $category->image }}" width="100" alt="Ảnh danh mục" style="border-radius: 4px;">
                        @else
                        <span style="color: #6b7280; font-style: italic;">Không có ảnh</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="fa-solid fa-pen icon-change js-changeCategory"
                            data-category-id="{{ $category->id }}"
                            data-category-name="{{ $category->name }}"
                            data-category-description="{{ $category->description }}"
                            data-category-image="{{ $category->image }}"></button>
                        <button type="button" class="fas fa-trash icon-delete js-delete-category"
                            data-category-id="{{ $category->id }}"></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination" style="justify-content:center;">
            @php
            $currentPage = $categories->currentPage();
            $lastPage = $categories->lastPage();
            @endphp
            <a href="{{ $categories->url(max($currentPage-1,1)) }}" class="prev">Trước</a>
            @for ($i = 1; $i <= $lastPage; $i++) <a href="{{ $categories->url($i) }}"
                class="{{ $currentPage == $i ? 'page-current' : '' }}">{{ $i }}</a>
                @endfor
                <a href="{{ $categories->url(min($currentPage+1,$lastPage)) }}" class="next">Tiếp</a>
        </div>
    </div>
</div>

<!-- Modal Thêm danh mục -->
<div class="modal js-modal-addCategory" style="display:none;">
    <form class="modal-container modal-container-category js-modal-addCategory-container" method="POST"
        action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-close js-modal-addCategory-close"><i class="fa-solid fa-xmark"></i></div>
        <header class="modal-header modal-header-books"><i class="modal-heading-icon fa-solid fa-tags"></i>Thêm danh mục
        </header>
        <div class="modal-content modal-content-category">
            <div class="modal-col">
                <label class="modal-label">
                    Tên danh mục
                    <input name="name" type="text" class="js-addCategory-name modal-input" placeholder="Tên..."
                        required>
                </label>
            </div>
            <div class="modal-col">
                <label class="modal-label">
                    Mô tả
                    <textarea name="description" class="js-addCategory-description modal-input" placeholder="Mô tả..."
                        rows="3"></textarea>
                </label>
            </div>
            <div class="modal-col">
                <label class="modal-label">
                    Hình ảnh
                    <input type="file" name="image" id="category-image" class="modal-input" onchange="previewCategoryImage(event)" accept="image/*">
                    <img id="categoryImagePreview" src="#" alt="Ảnh xem trước" style="display:none; max-width: 200px; margin-top: 10px; border-radius: 8px;" />
                </label>
            </div>
            <div class="action-form">
                <div class="cancel-book js-cancel-category">Hủy</div>
                <button type="submit" class="submit-book">Thêm</button>
            </div>
        </div>
    </form>
</div>

<!-- Modal Chỉnh sửa danh mục -->
<div class="modal js-modal-editCategory" style="display: none;">
    <form class="modal-container modal-container-category js-modal-editCategory-container" method="POST" action="" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-close js-modal-editCategory-close"><i class="fa-solid fa-xmark"></i></div>
        <header class="modal-header modal-header-books"><i class="modal-heading-icon fa-solid fa-tags"></i>Chỉnh sửa
            danh mục</header>
        <div class="modal-content modal-content-category">
            <div class="modal-col">
                <label class="modal-label">
                    Tên danh mục
                    <input id="edit-category-name" name="name" type="text" class="js-editCategory-name modal-input"
                        placeholder="Tên..." required>
                </label>
            </div>
            <div class="modal-col">
                <label class="modal-label">
                    Mô tả
                    <textarea id="edit-category-description" name="description"
                        class="js-editCategory-description modal-input" placeholder="Mô tả..." rows="3"></textarea>
                </label>
            </div>
            <div class="modal-col">
                <label class="modal-label">
                    Hình ảnh
                    <input type="file" name="image" id="edit-category-image" class="modal-input" onchange="previewEditCategoryImage(event)" accept="image/*">
                    <div id="editCurrentImageContainer" style="margin-top: 10px;">
                        <div style="margin-bottom: 5px; font-weight: 500; color: #333;">Ảnh hiện tại:</div>
                        <img id="editCurrentImage" src="" alt="Ảnh hiện tại" style="display:none; max-width: 200px; border-radius: 8px; border: 2px solid #e2e8f0;" />
                        <div id="editNoCurrentImage" style="display:none; padding: 20px; background: #f9fafb; border: 2px dashed #d1d5db; border-radius: 8px; text-align: center; color: #6b7280;">
                            Chưa có ảnh
                        </div>
                    </div>
                    <img id="editCategoryImagePreview" src="#" alt="Ảnh xem trước" style="display:none; max-width: 200px; margin-top: 10px; border-radius: 8px; border: 2px solid #3b82f6;" />
                </label>
            </div>
            <div class="action-form">
                <button type="button" class="cancel-book js-cancel-edit-category">Hủy</button>
                <button type="submit" class="submit-book js-save-category">Lưu</button>
            </div>
        </div>
    </form>
</div>

<!-- Modal Xác nhận xóa -->
<div class="modal-delete js-modal-deleteCategory" style="display: none;">
    <form class="modal-delete-container js-modal-deleteCategory-container" method="POST" action="">
        @csrf
        @method('DELETE')
        <div class="modal-delete-close js-modal-deleteCategory-close"><i class="fa-solid fa-xmark"></i></div>
        <div class="modal-delete-body">
            <p>Bạn có chắc chắn muốn xóa danh mục này không?</p>
            <div class="btn-delete-choose">
                <button type="submit" class="btn-yes js-confirm-delete-category">Có</button>
                <button type="button" class="btn-no js-cancel-delete-category">Không</button>
            </div>
        </div>
    </form>
</div>

<!-- JavaScript xử lý modal -->
<script>
    // Hàm preview ảnh cho form thêm category
    function previewCategoryImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('categoryImagePreview');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }

    // Hàm preview ảnh cho form edit category
    function previewEditCategoryImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('editCategoryImagePreview');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }

    let currentEditCategoryId = null;
    document.addEventListener('DOMContentLoaded', function() {
        // Modal Thêm danh mục
        document.querySelector('.js-add-category').onclick = () => document.querySelector('.js-modal-addCategory')
            .style.display = 'flex';
        document.querySelector('.js-modal-addCategory-close').onclick =
            document.querySelector('.js-cancel-category').onclick = () => document.querySelector(
                '.js-modal-addCategory').style.display = 'none';

        // Modal Chỉnh sửa
        document.querySelectorAll('.js-changeCategory').forEach(btn => {
            btn.onclick = () => {
                currentEditCategoryId = btn.getAttribute('data-category-id');
                document.getElementById('edit-category-name').value = btn.getAttribute(
                    'data-category-name');
                document.getElementById('edit-category-description').value = btn.getAttribute(
                    'data-category-description');

                // Xử lý hiển thị ảnh hiện tại
                const currentImageUrl = btn.getAttribute('data-category-image');
                const editCurrentImage = document.getElementById('editCurrentImage');
                const editNoCurrentImage = document.getElementById('editNoCurrentImage');
                const editCategoryImagePreview = document.getElementById('editCategoryImagePreview');

                // Reset preview ảnh mới
                editCategoryImagePreview.style.display = 'none';
                document.getElementById('edit-category-image').value = '';

                if (currentImageUrl && currentImageUrl !== 'null' && currentImageUrl !== '') {
                    editCurrentImage.src = currentImageUrl;
                    editCurrentImage.style.display = 'block';
                    editNoCurrentImage.style.display = 'none';
                } else {
                    editCurrentImage.style.display = 'none';
                    editNoCurrentImage.style.display = 'block';
                }

                document.querySelector('.js-modal-editCategory').style.display = 'flex';
                document.querySelector('.js-modal-editCategory-container').action =
                    '/admin/categories/' + currentEditCategoryId;
            };
        });
        document.querySelector('.js-modal-editCategory-close').onclick =
            document.querySelector('.js-cancel-edit-category').onclick = () => document.querySelector(
                '.js-modal-editCategory').style.display = 'none';

        // Modal Xóa
        document.querySelectorAll('.js-delete-category').forEach(btn => {
            btn.onclick = () => {
                currentEditCategoryId = btn.getAttribute('data-category-id');
                document.querySelector('.js-modal-deleteCategory').style.display = 'flex';
                document.querySelector('.js-modal-deleteCategory-container').action =
                    '/admin/categories/' + currentEditCategoryId;
            };
        });
        document.querySelector('.js-modal-deleteCategory-close').onclick =
            document.querySelector('.js-cancel-delete-category').onclick = () => document.querySelector(
                '.js-modal-deleteCategory').style.display = 'none';

        // Đóng modal khi click ra ngoài
        document.querySelectorAll('.modal, .modal-delete').forEach(modal => {
            modal.onclick = e => {
                if (e.target === modal) modal.style.display = 'none';
            };
        });
    });
</script>
@endsection