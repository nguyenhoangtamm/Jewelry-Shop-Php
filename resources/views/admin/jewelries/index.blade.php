@extends('admin.layouts.app')
@section('title', 'Quản lý Trang sức')
@section('content')

<style>
    :root {
        --galaxy-primary: #1e3a8a;
        --galaxy-secondary: #1e40af;
        --galaxy-accent: #3b82f6;
        --galaxy-light: #dbeafe;
        --galaxy-dark: #1e293b;
        --galaxy-gradient: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #06b6d4 100%);
        --galaxy-gradient-hover: linear-gradient(135deg, #1e40af 0%, #2563eb 50%, #0891b2 100%);
        --shadow-sm: 0 2px 4px rgba(30, 58, 138, 0.1);
        --shadow-md: 0 4px 12px rgba(30, 58, 138, 0.15);
        --shadow-lg: 0 8px 25px rgba(30, 58, 138, 0.2);
        --shadow-xl: 0 12px 40px rgba(30, 58, 138, 0.25);
    }

    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        color: var(--galaxy-dark);
        line-height: 1.6;
    }

    /* Modern Button Styles */
    .icon-change {
        background: var(--galaxy-gradient);
        border: none;
        color: white;
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 8px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-sm);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .icon-change:hover {
        background: var(--galaxy-gradient-hover);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .icon-delete {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        color: white;
        padding: 8px 12px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-sm);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        margin-left: 8px;
    }

    .icon-delete:hover {
        background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        text-decoration: none;
        color: white;
    }

    /* Table Wrapper */
    .table-wrapper {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        margin: 20px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.1);
    }

    /* Header Section */
    .table-header {
        background: var(--galaxy-gradient);
        padding: 24px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        position: relative;
        overflow: hidden;
    }

    .table-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="stars" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23stars)"/></svg>');
        opacity: 0.3;
        pointer-events: none;
    }

    .main-title {
        color: white;
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .main-title::before {
        content: '💎';
        font-size: 32px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }

    /* Search Form */
    .jewelry-search {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        padding: 4px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .jewelry-text-search {
        background: transparent;
        border: none;
        color: white;
        padding: 12px 16px;
        font-size: 16px;
        outline: none;
        width: 280px;
        border-radius: 8px;
    }

    .jewelry-text-search::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .jewelry-search button {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        padding: 12px 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 16px;
    }

    .jewelry-search button:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.05);
    }

    /* Add Button */
    .add-jewelry {
        background: rgba(255, 255, 255, 0.9);
        color: var(--galaxy-primary);
        padding: 12px 24px;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: var(--shadow-sm);
        border: none;
        position: relative;
        z-index: 1;
    }

    .add-jewelry:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .icon-add {
        background: var(--galaxy-gradient);
        color: white;
        padding: 6px;
        border-radius: 6px;
        font-size: 12px;
    }






    /* Pagination */
    .pagination {
        padding: 24px 32px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .pagination a {
        padding: 10px 16px;
        border-radius: 8px;
        text-decoration: none;
        color: var(--galaxy-primary);
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
        background: white;
    }

    .pagination a:hover {
        background: var(--galaxy-light);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }

    .pagination .page-current {
        background: var(--galaxy-gradient);
        color: white;
        border-color: var(--galaxy-primary);
        box-shadow: var(--shadow-md);
    }

    /* Modal Styles */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(30, 58, 138, 0.6);
        backdrop-filter: blur(8px);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-container {
        background: white;
        border-radius: 20px;
        box-shadow: var(--shadow-xl);
        max-width: 800px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        border: 1px solid rgba(59, 130, 246, 0.1);
    }

    .modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: none;
        padding: 12px;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        font-size: 18px;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-close:hover {
        background: rgba(239, 68, 68, 0.2);
        transform: scale(1.1);
    }

    .modal-header {
        background: var(--galaxy-gradient);
        color: white;
        padding: 24px 32px;
        font-size: 24px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        overflow: hidden;
    }

    .modal-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="stars" x="0" y="0" width="15" height="15" patternUnits="userSpaceOnUse"><circle cx="7.5" cy="7.5" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23stars)"/></svg>');
        opacity: 0.3;
    }

    .modal-heading-icon {
        position: relative;
        z-index: 1;
        font-size: 28px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }

    .modal-content {
        padding: 32px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .modal-twoCol {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .modal-label {
        display: flex;
        flex-direction: column;
        font-size: 16px;
        font-weight: 600;
        color: var(--galaxy-dark);
        gap: 8px;
    }

    .modal-input,
    textarea.modal-input,
    select.modal-input {
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        font-family: inherit;
    }

    .modal-input:focus,
    textarea.modal-input:focus,
    select.modal-input:focus {
        border-color: var(--galaxy-accent);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        outline: none;
        transform: translateY(-1px);
    }

    textarea.modal-input {
        resize: vertical;
        min-height: 100px;
    }

    .check-error {
        font-size: 14px;
        color: #ef4444;
        font-weight: 500;
        margin-top: 4px;
        min-height: 20px;
    }

    /* Action Buttons */
    .action-form {
        display: flex;
        justify-content: flex-end;
        gap: 16px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #e2e8f0;
    }

    .cancel-jewelry,
    .submit-jewelry {
        padding: 14px 28px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .cancel-jewelry {
        background: #f1f5f9;
        color: #64748b;
        border: 2px solid #e2e8f0;
    }

    .cancel-jewelry:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .submit-jewelry {
        background: var(--galaxy-gradient);
        color: white;
        box-shadow: var(--shadow-md);
    }

    .submit-jewelry:hover {
        background: var(--galaxy-gradient-hover);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* Delete Modal */
    .modal-delete {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.5);
        /* Nền trắng mờ */
        backdrop-filter: blur(10px) saturate(150%);
        -webkit-backdrop-filter: blur(10px) saturate(150%);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    /* Container chính của modal */
    .modal-delete-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
        position: relative;
        border: 1px solid rgba(203, 213, 225, 0.6);
        /* Màu viền nhẹ */
        animation: fadeIn 0.3s ease-in-out;
    }

    /* Nút đóng (X) */
    .modal-delete-close {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(255, 255, 255, 0.8);
        color: #ef4444;
        border: none;
        padding: 6px 10px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 18px;
        font-weight: bold;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .modal-delete-close:hover {
        background: #fee2e2;
    }

    /* Nội dung bên trong modal */
    .modal-delete-body {
        padding: 32px 24px 24px;
        text-align: center;
    }

    .modal-delete-body p {
        font-size: 17px;
        font-weight: 600;
        line-height: 1.5;
        color: #1e293b;
        /* Màu chữ đậm */
        margin-bottom: 24px;
    }

    /* Nhóm nút */
    .btn-delete-choose {
        display: flex;
        gap: 16px;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* Nút đồng ý và hủy */
    .btn-yes,
    .btn-no {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        font-size: 15px;
    }

    /* Nút Có */
    .btn-yes {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-yes:hover {
        background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%);
        transform: translateY(-2px);
    }

    /* Nút Không */
    .btn-no {
        background: #f1f5f9;
        color: #64748b;
        border: 2px solid #e2e8f0;
    }

    .btn-no:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    /* Hiệu ứng xuất hiện */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Responsive */
    @media (max-width: 480px) {
        .modal-delete-container {
            max-width: 90%;
            padding: 16px;
        }

        .modal-delete-body p {
            font-size: 16px;
        }

        .btn-yes,
        .btn-no {
            width: 100%;
            padding: 10px;
            font-size: 14px;
        }

        .btn-delete-choose {
            flex-direction: column;
            gap: 12px;
        }
    }


    /* Responsive Design */
    @media (max-width: 768px) {
        .modal-twoCol {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .action-form {
            flex-direction: column;
        }

        .table-header {
            flex-direction: column;
            text-align: center;
        }

        .jewelry-text-search {
            width: 100%;
        }

        .main-title {
            font-size: 24px;
        }

        .modal-content {
            padding: 24px;
        }
    }

    @media (max-width: 480px) {
        .table-wrapper {
            margin: 10px;
            border-radius: 12px;
        }

        .modal {
            padding: 10px;
        }

        .modal-container {
            border-radius: 16px;
        }
    }

    /* Loading and Animation Effects */
    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }

    .loading-shimmer {
        position: relative;
        overflow: hidden;
    }

    .loading-shimmer::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
        animation: shimmer 1.5s infinite;
    }

    /* Scrollbar Styling */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: var(--galaxy-gradient);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--galaxy-gradient-hover);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: "Thành công!",
            text: @json(session('success')),
            confirmButtonColor: '#3b82f6',
            confirmButtonText: 'OK',
            background: '#ffffff',
            customClass: {
                popup: 'border-radius: 16px'
            }
        });
    });
</script>
@endif

<div class="table-wrapper">
    <div class="table-header">
        <h3 class="main-title">Thông tin Trang sức</h3>
        <form method="GET" action="" class="jewelry-search">
            <input type="text" name="search" value="{{ request('search') }}" class="jewelry-text-search"
                placeholder="Tìm kiếm trang sức...">
            <button type="submit" class="fa-solid fa-magnifying-glass"></button>
        </form>
        <div class="add-book add-jewelry js-add-jewelry">
            <i class="fa-solid fa-plus icon-add"></i>
            Thêm Trang sức
        </div>
    </div>

    <div class="table-container" name="jewelry-table">
        <table id="table-jewelry">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Danh mục</th>
                    <th>Đá Chính</th>
                    <th>Tồn kho</th>
                    <th>Hình ảnh</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jewelries as $jewelry)
                <tr>
                    <td class="jewelry-id">{{ $jewelry->id }}</td>
                    <td class="jewelry-name">{{ $jewelry->name }}</td>
                    <td class="jewelry-price">{{ number_format($jewelry->price, 0, ',', '.') }}₫</td>
                    <td class="jewelry-category">{{ $jewelry->category->name ?? 'Không có' }}</td>
                    <td class="jewelry-main-stone">{{ ucfirst(strtolower($jewelry->main_stone ?? 'Không rõ')) }}</td>

                    <td class="jewelry-stock">{{ $jewelry->stock ?? '0' }}</td>
                    <td>
                        @if ($jewelry->main_image)
                        <img src="{{ $jewelry->main_image }}" width="100" alt="Ảnh">
                        @else
                        Không có ảnh
                        @endif
                    </td>


                    <td class="jewelry-description">{{ $jewelry->description ?? '' }}</td>
                    <td>
                        <button type="button" class="fa-solid fa-pen icon-change js-changeJewelry"
                            data-id="{{ $jewelry->id }}"
                            data-name="{{ $jewelry->name }}"
                            data-price="{{ $jewelry->price }}"
                            data-category="{{ $jewelry->category_id }}"
                            data-main_stone="{{ $jewelry->main_stone }}"
                            data-stock="{{ $jewelry->stock }}"
                            data-description="{{ $jewelry->description }}"
                            data-weight="{{ $jewelry->weight }}"
                            data-policy="{{ $jewelry->after_sales_policy }}"
                            data-current-image="{{ $jewelry->main_image }}">
                        </button>

                        <a href="?delete={{ $jewelry->id }}" class="fas fa-trash icon-delete js-delete-jewelry"></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            @php
            $currentPage = $jewelries->currentPage();
            $lastPage = $jewelries->lastPage();
            $search = request('search');
            @endphp
            @for ($i = 1; $i <= $lastPage; $i++)
                <a href="{{ $jewelries->url($i) }}{{ $search ? '&search=' . urlencode($search) : '' }}"
                class="{{ $currentPage == $i ? 'page-current' : '' }}">
                {{ $i }}
                </a>
                @endfor
        </div>
    </div>
</div>

<!-- Modal Thêm -->
<div class="modal js-modal-addJewelry" style="display:none;">
    <form class="modal-container js-modal-addJewelry-container" method="POST"
        action="{{ route('admin.jewelries.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="page" value="{{ request('page', 1) }}">
        <div class="modal-close js-modal-addJewelry-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <header class="modal-header modal-header-jewelry">
            <i class="modal-heading-icon fa-solid fa-gem"></i>
            Thêm Trang sức
        </header>
        <div class="modal-content">
            <div class="modal-twoCol">
                <label for="jewelry-name" class="modal-label">
                    Tên
                    <input id="jewelry-name" name="name" type="text" class="js-addJewelry-name modal-input"
                        placeholder="Nhập tên trang sức..." required>
                    <span class="name-addJewelry-error check-error"></span>
                </label>
                <label for="jewelry-price" class="modal-label">
                    Giá
                    <input id="jewelry-price" name="price" type="number" class="js-addJewelry-price modal-input"
                        placeholder="Giá..." min="1" step="0.01" required>
                    <span class="price-addJewelry-error check-error"></span>
                </label>
            </div>

            <div class="modal-twoCol">
                <label for="jewelry-category" class="modal-label">
                    Danh mục
                    <select id="jewelry-category" name="category_id" class="modal-input" required>
                        <option value="">Chọn danh mục</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <span class="category-addJewelry-error check-error"></span>
                </label>
                <label for="jewelry-main-stone" class="modal-label">
                    Đá chính
                    <select id="jewelry-main-stone" name="main_stone" class="modal-input" required>
                        <option value="">Chọn đá chính</option>
                        @foreach ($mainStones as $stone)
                        <option value="{{ $stone }}">{{ $stone }}</option>
                        @endforeach
                    </select>

                    <span class="main-stone-addJewelry-error check-error"></span>
                </label>
            </div>

            <div class="modal-twoCol">
                <label for="jewelry-stock" class="modal-label">
                    Tồn kho
                    <input id="jewelry-stock" name="stock" type="number" class="modal-input"
                        placeholder="Số lượng tồn..." min="0" required>
                    <span class="stock-addJewelry-error check-error"></span>
                </label>
                <label for="jewelry-image" class="modal-label">
                    Hình ảnh
                    <input type="file" name="image" id="image" class="modal-input" onchange="previewImage(event)">
                    <img id="imagePreview" src="#" alt="Ảnh xem trước" style="display:none; max-width: 200px; margin-top: 10px;" />
                    <span class="image-addJewelry-error check-error"></span>
                </label>
            </div>

            <label for="jewelry-description" class="modal-label">
                Mô tả
                <textarea id="jewelry-description" name="description" rows="3" class="modal-input"
                    placeholder="Mô tả chi tiết..."></textarea>
                <span class="description-addJewelry-error check-error"></span>
            </label>

            <div class="modal-twoCol">
                <label for="jewelry-weight" class="modal-label">
                    Khối lượng (gram)
                    <input id="jewelry-weight" name="weight" type="number" step="0.01" min="0" class="modal-input"
                        placeholder="Nhập khối lượng..." required>
                    <span class="weight-addJewelry-error check-error"></span>
                </label>
                <label for="jewelry-policy" class="modal-label">
                    Chính sách bán hàng
                    <select id="jewelry-policy" name="after_sales_policy" class="modal-input">
                        <option value="">-- Chọn chính sách --</option>
                        <option value="Bảo hành 12 tháng">Bảo hành 12 tháng</option>
                        <option value="Bảo hành 6 tháng">Bảo hành 6 tháng</option>
                        <option value="Bảo hành trọn đời">Bảo hành trọn đời</option>
                        <option value="Miễn phí vệ sinh trọn đời">Miễn phí vệ sinh trọn đời</option>
                        <option value="Sale 20%">Sale 20%</option>
                        <option value="Sale 50%">Sale 50%</option>
                        <option value="Giảm 10% cho đơn hàng tiếp theo">Giảm 10% cho đơn hàng tiếp theo</option>
                        <option value="Đổi trả trong 7 ngày">Đổi trả trong 7 ngày</option>
                        <option value="Đổi trả trong 30 ngày">Đổi trả trong 30 ngày</option>
                        <option value="Miễn phí vận chuyển">Miễn phí vận chuyển</option>
                        <option value="Không áp dụng">Không áp dụng</option>
                        <option value="custom">Khác (nhập tay)</option>
                    </select>
                    <span class="policy-addJewelry-error check-error"></span>
                </label>
            </div>

            <div class="action-form">
                <div class="cancel-jewelry js-cancel-jewelry">
                    <i class="fa-solid fa-xmark"></i>
                    Hủy
                </div>
                <button class="submit-jewelry js-add-jewelry-btn" type="submit">
                    <i class="fa-solid fa-plus"></i>
                    Thêm
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Modal Chỉnh sửa -->
<div class="modal modal-changeJewelry js-modal-changeJewelry" style="display:none;">
    <form class="modal-container js-modal-changeJewelry-container" method="POST" action="" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="page" value="{{ request('page', 1) }}">
        <div class="modal-close js-modal-changeJewelry-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <header class="modal-header modal-header-jewelry">
            <i class="modal-heading-icon fa-solid fa-gem"></i>
            Cập nhật Thông tin Trang sức
        </header>
        <div class="modal-content">
            <div class="modal-twoCol">
                <label for="edit-jewelry-name" class="modal-label">
                    Tên
                    <input id="edit-jewelry-name" type="text" name="name" class="js-changeJewelry-name modal-input" required>
                    <span class="name-changeJewelry-error check-error"></span>
                </label>
                <label for="edit-jewelry-price" class="modal-label">
                    Giá
                    <input id="edit-jewelry-price" type="number" name="price" class="js-changeJewelry-price modal-input"
                        placeholder="Giá..." min="1" step="0.01" required>
                    <span class="price-changeJewelry-error check-error"></span>
                </label>
            </div>

            <div class="modal-twoCol">
                <label for="edit-jewelry-category" class="modal-label">
                    Danh mục
                    <select id="edit-jewelry-category" name="category_id" class="modal-input" required>
                        <option value="">Chọn danh mục</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <span class="category-changeJewelry-error check-error"></span>
                </label>
                <label for="edit-jewelry-main-stone" class="modal-label">
                    Đá chính
                    <select id="edit-jewelry-main-stone" name="main_stone" class="modal-input" required>
                        <option value="">Chọn đá chính</option>
                        <option value="Kim cương">Kim cương</option>
                        <option value="Ngọc trai">Ngọc trai</option>
                        <option value="Ruby">Ruby</option>
                        <option value="Sapphire">Sapphire</option>
                        <option value="Thạch anh">Thạch anh</option>
                        <option value="Không có">Không có</option>
                    </select>
                    <span class="main-stone-changeJewelry-error check-error"></span>
                </label>
            </div>

            <div class="modal-twoCol">
                <label for="edit-jewelry-stock" class="modal-label">
                    Tồn kho
                    <input id="edit-jewelry-stock" name="stock" type="number" class="modal-input"
                        placeholder="Số lượng tồn..." min="0" required>
                    <span class="stock-changeJewelry-error check-error"></span>
                </label>
                <label for="edit-jewelry-image" class="modal-label">
                    Hình ảnh
                    <input type="file" name="image" id="edit-jewelry-image" class="modal-input" onchange="previewEditImage(event)">
                    <div id="currentImageContainer" style="margin-top: 10px;">
                        <div style="margin-bottom: 5px; font-weight: 500; color: #6b7280;">Ảnh hiện tại:</div>
                        <img id="currentImage" src="" alt="Ảnh hiện tại" style="display:none; max-width: 200px; border-radius: 8px; border: 2px solid #e2e8f0;" />
                        <div id="noCurrentImage" style="display:none; padding: 20px; background: #f9fafb; border: 2px dashed #d1d5db; border-radius: 8px; text-align: center; color: #6b7280;">
                            Chưa có ảnh
                        </div>
                    </div>
                    <img id="editImagePreview" src="#" alt="Ảnh xem trước" style="display:none; max-width: 200px; margin-top: 10px; border-radius: 8px; border: 2px solid #3b82f6;" />
                    <span class="image-changeJewelry-error check-error"></span>
                </label>
            </div>

            <label for="edit-jewelry-description" class="modal-label">
                Mô tả
                <textarea id="edit-jewelry-description" name="description" rows="3" class="modal-input"
                    placeholder="Mô tả chi tiết..."></textarea>
                <span class="description-changeJewelry-error check-error"></span>
            </label>

            <div class="modal-twoCol">
                <label for="edit-jewelry-weight" class="modal-label">
                    Khối lượng (gram)
                    <input id="edit-jewelry-weight" name="weight" type="number" step="0.01" min="0" class="modal-input"
                        placeholder="Nhập khối lượng..." required>
                    <span class="weight-changeJewelry-error check-error"></span>
                </label>
                <label for="edit-jewelry-policy" class="modal-label">
                    Chính sách bán hàng
                    <select id="edit-jewelry-policy" name="after_sales_policy" class="modal-input">
                        <option value="">-- Chọn chính sách --</option>
                        <option value="Bảo hành 12 tháng">Bảo hành 12 tháng</option>
                        <option value="Bảo hành 6 tháng">Bảo hành 6 tháng</option>
                        <option value="Bảo hành trọn đời">Bảo hành trọn đời</option>
                        <option value="Miễn phí vệ sinh trọn đời">Miễn phí vệ sinh trọn đời</option>
                        <option value="Sale 20%">Sale 20%</option>
                        <option value="Sale 50%">Sale 50%</option>
                        <option value="Giảm 10% cho đơn hàng tiếp theo">Giảm 10% cho đơn hàng tiếp theo</option>
                        <option value="Đổi trả trong 7 ngày">Đổi trả trong 7 ngày</option>
                        <option value="Đổi trả trong 30 ngày">Đổi trả trong 30 ngày</option>
                        <option value="Miễn phí vận chuyển">Miễn phí vận chuyển</option>
                        <option value="Không áp dụng">Không áp dụng</option>
                        <option value="custom">Khác (nhập tay)</option>
                    </select>
                    <span class="policy-changeJewelry-error check-error"></span>
                </label>
            </div>

            <div class="action-form">
                <div class="cancel-jewelry js-cancel-jewelry">
                    <i class="fa-solid fa-xmark"></i>
                    Hủy
                </div>
                <button class="submit-jewelry js-save-changedJewelry" type="submit">
                    <i class="fa-solid fa-save"></i>
                    Lưu
                </button>
            </div>
        </div>
    </form>
</div>


<!-- Modal Xóa -->
<div class="modal-delete js-modal-deleteJewelry" style="display:none;">
    <form class="modal-delete-container js-modal-deleteJewelry-container" method="POST" action=""
        enctype="multipart/form-data">
        @csrf
        @method('DELETE')
        <input type="hidden" name="page" value="{{ request('page', 1) }}">
        <div class="modal-delete-close js-modal-deleteJewelry-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <div class="modal-delete-body">
            <div style="font-size: 48px; margin-bottom: 16px;">⚠️</div>
            <p>Bạn có chắc chắn muốn xóa trang sức này?</p>
            <div class="btn-delete-choose">
                <button type="submit" class="btn-yes js-jewelry-btn-yes">
                    <i class="fa-solid fa-check"></i>
                    Có
                </button>
                <div class="btn-no js-jewelry-btn-no">
                    <i class="fa-solid fa-xmark"></i>
                    Không
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');
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

    function previewEditImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('editImagePreview');
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

    document.addEventListener('DOMContentLoaded', function() {
        // ===== OPEN ADD MODAL =====
        const openAddBtn = document.querySelector('.js-add-jewelry');
        const addModal = document.querySelector('.js-modal-addJewelry');
        const addCloseBtn = document.querySelector('.js-modal-addJewelry-close');
        const addCancelBtns = document.querySelectorAll('.js-cancel-jewelry');

        if (openAddBtn) {
            openAddBtn.addEventListener('click', () => {
                addModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        }

        if (addCloseBtn) {
            addCloseBtn.addEventListener('click', () => {
                addModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
        }

        addCancelBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const modal = btn.closest('.modal');
                if (modal) {
                    modal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });
        });

        // ===== OPEN EDIT MODAL =====
        const editBtns = document.querySelectorAll('.js-changeJewelry');
        const editModal = document.querySelector('.js-modal-changeJewelry');
        const editForm = document.querySelector('.js-modal-changeJewelry-container');
        const editCloseBtn = document.querySelector('.js-modal-changeJewelry-close');

        editBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                editForm.action = `/admin/jewelries/${id}`;
                document.getElementById('edit-jewelry-name').value = btn.getAttribute('data-name') || '';
                document.getElementById('edit-jewelry-price').value = btn.getAttribute('data-price') || '';
                document.getElementById('edit-jewelry-category').value = btn.getAttribute('data-category') || '';
                document.getElementById('edit-jewelry-main-stone').value = btn.getAttribute('data-main_stone') || '';
                document.getElementById('edit-jewelry-stock').value = btn.getAttribute('data-stock') || '';
                document.getElementById('edit-jewelry-description').value = btn.getAttribute('data-description') || '';
                document.getElementById('edit-jewelry-weight').value = btn.getAttribute('data-weight') || '';
                document.getElementById('edit-jewelry-policy').value = btn.getAttribute('data-policy') || '';

                // Xử lý hiển thị ảnh hiện tại
                const currentImageUrl = btn.getAttribute('data-current-image');
                const currentImage = document.getElementById('currentImage');
                const noCurrentImage = document.getElementById('noCurrentImage');
                const editImagePreview = document.getElementById('editImagePreview');

                // Reset preview ảnh mới
                editImagePreview.style.display = 'none';
                document.getElementById('edit-jewelry-image').value = '';

                if (currentImageUrl && currentImageUrl !== 'null' && currentImageUrl !== '') {
                    currentImage.src = currentImageUrl;
                    currentImage.style.display = 'block';
                    noCurrentImage.style.display = 'none';
                } else {
                    currentImage.style.display = 'none';
                    noCurrentImage.style.display = 'block';
                }

                editModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        });

        if (editCloseBtn) {
            editCloseBtn.addEventListener('click', () => {
                editModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
        }

        // ===== OPEN DELETE MODAL =====
        const deleteBtns = document.querySelectorAll('.js-delete-jewelry');
        const deleteModal = document.querySelector('.js-modal-deleteJewelry');
        const deleteForm = document.querySelector('.js-modal-deleteJewelry-container');
        const deleteCloseBtn = document.querySelector('.js-modal-deleteJewelry-close');
        const deleteCancelBtn = document.querySelector('.js-jewelry-btn-no');

        deleteBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const url = '/admin/jewelries/' + btn.getAttribute('href').split('=')[1];
                deleteForm.action = url;
                deleteModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        });

        if (deleteCloseBtn) {
            deleteCloseBtn.addEventListener('click', () => {
                deleteModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
        }

        if (deleteCancelBtn) {
            deleteCancelBtn.addEventListener('click', () => {
                deleteModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
        }

        // ===== CLICK OUTSIDE TO CLOSE MODAL =====
        [addModal, editModal, deleteModal].forEach(modal => {
            if (modal) {
                modal.addEventListener('click', e => {
                    if (e.target === modal) {
                        modal.style.display = 'none';
                        document.body.style.overflow = 'auto';
                    }
                });
            }
        });

        // ===== FORM VALIDATION =====
        const addForm = document.querySelector('.js-modal-addJewelry-container');
        const submitBtn = document.querySelector('.js-add-jewelry-btn');

        if (addForm && submitBtn) {
            addForm.addEventListener('submit', function(e) {
                let isValid = true;

                document.querySelectorAll('.check-error').forEach(el => el.textContent = '');

                const name = document.querySelector('.js-addJewelry-name');
                const price = document.querySelector('.js-addJewelry-price');
                const category = document.getElementById('jewelry-category');
                const stone = document.getElementById('jewelry-main-stone');
                const stock = document.getElementById('jewelry-stock');
                const image = document.getElementById('image');
                const description = document.getElementById('jewelry-description');
                const weight = document.getElementById('jewelry-weight');
                const policy = document.getElementById('jewelry-policy');

                if (!name.value.trim()) {
                    document.querySelector('.name-addJewelry-error').textContent = 'Tên không được để trống';
                    isValid = false;
                }
                if (!price.value || price.value <= 0) {
                    document.querySelector('.price-addJewelry-error').textContent = 'Giá phải lớn hơn 0';
                    isValid = false;
                }
                if (!category.value) {
                    document.querySelector('.category-addJewelry-error').textContent = 'Vui lòng chọn danh mục';
                    isValid = false;
                }
                if (!stone.value) {
                    document.querySelector('.main-stone-addJewelry-error').textContent = 'Chọn đá chính hoặc "Không có"';
                    isValid = false;
                }
                if (!stock.value || stock.value < 0) {
                    document.querySelector('.stock-addJewelry-error').textContent = 'Tồn kho không hợp lệ';
                    isValid = false;
                }
                if (!image.files.length) {
                    document.querySelector('.image-addJewelry-error').textContent = 'Vui lòng chọn ảnh';
                    isValid = false;
                }
                if (!description.value.trim()) {
                    document.querySelector('.description-addJewelry-error').textContent = 'Mô tả không được để trống';
                    isValid = false;
                }
                if (!weight.value || weight.value <= 0) {
                    document.querySelector('.weight-addJewelry-error').textContent = 'Khối lượng phải lớn hơn 0';
                    isValid = false;
                }
                if (!policy.value) {
                    document.querySelector('.policy-addJewelry-error').textContent = 'Vui lòng chọn chính sách';
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    const firstError = document.querySelector('.check-error:not(:empty)');
                    if (firstError) {
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                } else {
                    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang xử lý...';
                    submitBtn.disabled = true;
                }
            });
        }
    });
</script>



@endsection