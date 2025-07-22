@extends('admin.layouts.app')
@section('title', 'Jewelry Management')
@section('content')
<style>
    .icon-change {
        background: none;
        border: none;
        color: #007bff;
        cursor: pointer;
        padding: 5px;
        margin-right: 10px;
    }

    .icon-change:hover {
        color: #0056b3;
    }
</style>
<div class="table-wrapper">
    <div class="table-header">
        <h3 class="main-title">Jewelry Information</h3>
        <form method="GET" action="" class="jewelry-search" style="display:inline-block;">
            <input type="text" name="search" value="{{ request('search') }}" class="jewelry-text-search" placeholder="Search jewelry...">
            <button type="submit" class="fa-solid fa-magnifying-glass" style="border:none;background:none;"></button>
        </form>
        <div class="add-book add-jewelry js-add-jewelry"><i class="fa-solid fa-plus icon-add"></i>Add Jewelry</div>
    </div>
    <div class="table-container" name="jewelry-table">
        <table id="table-jewelry">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Material</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jewelries as $jewelry)
                <tr>
                    <td class="jewelry-id">{{ $jewelry->id }}</td>
                    <td class="jewelry-name">{{ $jewelry->name }}</td>
                    <td class="jewelry-price">${{ $jewelry->price }}</td>
                    <td class="jewelry-category">{{ $jewelry->category->name ?? 'N/A' }}</td>
                    <td class="jewelry-material">{{ $jewelry->material ?? 'N/A' }}</td>
                    <td class="jewelry-stock">{{ $jewelry->stock ?? 'N/A' }}</td>
                    <td>
                        @if ($jewelry->image)
                        <img src="{{ asset('images_jewelry/' . $jewelry->image) }}" alt="jewelry" class="jewelry-img">
                        @else
                        <span>No image</span>
                        @endif
                    </td>
                    <td class="jewelry-description">{{ $jewelry->description ?? '' }}</td>
                    <td>
                        <button type="button" class="fa-solid fa-pen icon-change js-changeJewelry" data-id="{{ $jewelry->id }}" data-name="{{ $jewelry->name }}" data-price="{{ $jewelry->price }}"></button>
                        <a href="?delete={{ $jewelry->id }}" class="fas fa-trash icon-delete js-delete-jewelry"></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination" style="justify-content:center;">
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
<!-- Modal Add Jewelry -->
<div class="modal js-modal-addJewelry" style="display:none;">
    <form class="modal-container js-modal-addJewelry-container" method="POST" action="{{ route('admin.jewelries.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-close js-modal-addJewelry-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <header class="modal-header modal-header-jewelry">
            <i class="modal-heading-icon fa-solid fa-gem"></i>
            Add Jewelry
        </header>
        <div class="modal-content">
            <div class="modal-twoCol">
                <label for="jewelry-name" class="modal-label">
                    Name
                    <input id="jewelry-name" name="name" type="text" class="js-addJewelry-name modal-input" placeholder="Jewelry name..." required>
                    <span class="name-addJewelry-error check-error"></span>
                </label>
                <label for="jewelry-price" class="modal-label">
                    Price
                    <input id="jewelry-price" name="price" type="number" class="js-addJewelry-price modal-input" placeholder="Price..." min="1" step="0.01" required>
                    <span class="price-addJewelry-error check-error"></span>
                </label>
            </div>
            <div class="action-form">
                <div class="cancel-jewelry js-cancel-jewelry">Cancel</div>
                <button class="submit-jewelry js-add-jewelry-btn" type="submit">Add Jewelry</button>
            </div>
        </div>
    </form>
</div>
<!-- Modal Edit Jewelry -->
<div class="modal modal-changeJewelry js-modal-changeJewelry" style="display:none;">
    <form class="modal-container js-modal-changeJewelry-container" method="POST" action="" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-close js-modal-changeJewelry-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <header class="modal-header modal-header-jewelry">
            <i class="modal-heading-icon fa-solid fa-gem"></i>
            Change Jewelry Information
        </header>
        <div class="modal-content">
            <div class="modal-twoCol">
                <label for="edit-jewelry-name" class="modal-label">
                    Name
                    <input id="edit-jewelry-name" type="text" class="js-changeJewelry-name modal-input" placeholder="Name..." name="name" required>
                    <span class="name-changeJewelry-error check-error"></span>
                </label>
                <label for="edit-jewelry-price" class="modal-label">
                    Price
                    <input id="edit-jewelry-price" type="number" class="js-changeJewelry-price modal-input" placeholder="Price..." min="1" step="0.01" name="price" required>
                    <span class="price-changeJewelry-error check-error"></span>
                </label>
            </div>
            <div class="action-form">
                <div class="cancel-jewelry js-cancel-jewelry">Cancel</div>
                <button class="submit-jewelry js-save-changedJewelry" type="submit">Save</button>
            </div>
        </div>
    </form>
</div>
<!-- Modal Delete Jewelry -->
<div class="modal-delete js-modal-deleteJewelry" style="display:none;">
    <form class="modal-delete-container js-modal-deleteJewelry-container" method="POST" action="" enctype="multipart/form-data">
        @csrf
        @method('DELETE')
        <div class="modal-delete-close js-modal-deleteJewelry-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <div class="modal-delete-body">
            <p>Do you want to delete this jewelry?</p>
            <div class="btn-delete-choose">
                <button type="submit" class="btn-yes js-jewelry-btn-yes">Yes</button>
                <div class="btn-no js-jewelry-btn-no">No</div>
            </div>
        </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add Jewelry Modal
        const addJewelryBtn = document.querySelector('.js-add-jewelry');
        const addJewelryModal = document.querySelector('.js-modal-addJewelry');
        const addJewelryCloseBtn = document.querySelector('.js-modal-addJewelry-close');
        const addJewelryCancelBtns = document.querySelectorAll('.js-cancel-jewelry');
        if (addJewelryBtn) {
            addJewelryBtn.addEventListener('click', function() {
                addJewelryModal.style.display = 'flex';
            });
        }
        if (addJewelryCloseBtn) {
            addJewelryCloseBtn.addEventListener('click', function() {
                addJewelryModal.style.display = 'none';
            });
        }
        addJewelryCancelBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const modal = btn.closest('.modal');
                if (modal) {
                    modal.style.display = 'none';
                }
            });
        });

        // Edit Jewelry Modal
        const editJewelryBtns = document.querySelectorAll('.js-changeJewelry');
        const editJewelryModal = document.querySelector('.js-modal-changeJewelry');
        const editJewelryForm = document.querySelector('.js-modal-changeJewelry-container');
        const editJewelryCloseBtn = document.querySelector('.js-modal-changeJewelry-close');
        editJewelryBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const jewelryId = btn.getAttribute('data-id');
                const jewelryName = btn.getAttribute('data-name');
                const jewelryPrice = btn.getAttribute('data-price');
                editJewelryForm.action = '/admin/jewelries/' + jewelryId;
                document.getElementById('edit-jewelry-name').value = jewelryName;
                document.getElementById('edit-jewelry-price').value = jewelryPrice;
                editJewelryModal.style.display = 'flex';
            });
        });
        if (editJewelryCloseBtn) {
            editJewelryCloseBtn.addEventListener('click', function() {
                editJewelryModal.style.display = 'none';
            });
        }

        // Delete Jewelry Modal
        const deleteJewelryBtns = document.querySelectorAll('.js-delete-jewelry');
        const deleteJewelryModal = document.querySelector('.js-modal-deleteJewelry');
        const deleteJewelryForm = document.querySelector('.js-modal-deleteJewelry-container');
        const deleteJewelryCloseBtn = document.querySelector('.js-modal-deleteJewelry-close');
        const deleteJewelryNoBtn = document.querySelector('.js-jewelry-btn-no');
        deleteJewelryBtns.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const url = '/admin/jewelries/' + btn.getAttribute('href').split('=')[1];
                deleteJewelryForm.action = url;
                deleteJewelryModal.style.display = 'flex';
            });
        });
        if (deleteJewelryCloseBtn) {
            deleteJewelryCloseBtn.addEventListener('click', function() {
                deleteJewelryModal.style.display = 'none';
            });
        }
        if (deleteJewelryNoBtn) {
            deleteJewelryNoBtn.addEventListener('click', function() {
                deleteJewelryModal.style.display = 'none';
            });
        }
    });
</script>
@endsection