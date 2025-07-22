@extends('admin.layouts.app')
@section('title', 'Category Management')
@section('content')
<div class="table-wrapper">
    <div class="table-header">
        <h3 class="main-title">Categories Information</h3>
        <div class="add-book add-category js-add-category"><i class="fa-solid fa-plus icon-add"></i>Add Category</div>
    </div>
    <div class="table-container" name="category-table">
        <table id="category-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td class="category-id">{{ $category->id }}</td>
                    <td class="category-name">{{ $category->name }}</td>
                    <td class="category-description">{{ $category->description }}</td>
                    <td>
                        <button type="button" class="fa-solid fa-pen icon-change js-changeCategory" data-category-id="{{ $category->id }}" data-category-name="{{ $category->name }}" data-category-description="{{ $category->description }}"></button>
                        <button type="button" class="fas fa-trash icon-delete js-delete-category" data-category-id="{{ $category->id }}"></button>
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
            <a href="{{ $categories->url(max($currentPage-1,1)) }}" class="prev">Prev</a>
            @for ($i = 1; $i <= $lastPage; $i++)
                <a href="{{ $categories->url($i) }}" class="{{ $currentPage == $i ? 'page-current' : '' }}">{{ $i }}</a>
                @endfor
                <a href="{{ $categories->url(min($currentPage+1,$lastPage)) }}" class="next">Next</a>
        </div>
    </div>
</div>
<!-- Modal Add Category -->
<div class="modal js-modal-addCategory" style="display:none;">
    <form class="modal-container modal-container-category js-modal-addCategory-container" method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        <div class="modal-close js-modal-addCategory-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <header class="modal-header modal-header-books">
            <i class="modal-heading-icon fa-solid fa-tags"></i>
            Add Category
        </header>
        <div class="modal-content modal-content-category">
            <div class="modal-col">
                <label for="category-name" class="modal-label">
                    Name
                    <input id="category-name" name="name" type="text" class="js-addCategory-name modal-input" placeholder="Name..." required>
                    <span class="name-addCategory-error check-error"></span>
                </label>
            </div>
            <div class="modal-col">
                <label for="category-description" class="modal-label">
                    Description
                    <textarea id="category-description" name="description" class="js-addCategory-description modal-input" placeholder="Description..." rows="3"></textarea>
                    <span class="description-addCategory-error check-error"></span>
                </label>
            </div>
            <div class="action-form">
                <div class="cancel-book js-cancel-category">Cancel</div>
                <button type="submit" class="submit-book">Add</button>
            </div>
        </div>
    </form>
</div>
<!-- Modal Edit Category -->
<div class="modal js-modal-editCategory" style="display: none;">
    <form class="modal-container modal-container-category js-modal-editCategory-container" method="POST" action="">
        @csrf
        @method('PUT')
        <div class="modal-close js-modal-editCategory-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <header class="modal-header modal-header-books">
            <i class="modal-heading-icon fa-solid fa-tags"></i>
            Edit Category
        </header>
        <div class="modal-content modal-content-category">
            <div class="modal-col">
                <label for="edit-category-name" class="modal-label">
                    Name
                    <input id="edit-category-name" name="name" type="text" class="js-editCategory-name modal-input" placeholder="Name..." required>
                    <span class="name-editCategory-error check-error"></span>
                </label>
            </div>
            <div class="modal-col">
                <label for="edit-category-description" class="modal-label">
                    Description
                    <textarea id="edit-category-description" name="description" class="js-editCategory-description modal-input" placeholder="Description..." rows="3"></textarea>
                    <span class="description-editCategory-error check-error"></span>
                </label>
            </div>
            <div class="action-form">
                <button type="button" class="cancel-book js-cancel-edit-category">Cancel</button>
                <button type="submit" class="submit-book js-save-category">Save</button>
            </div>
        </div>
    </form>
</div>
<!-- Modal Delete Confirmation -->
<div class="modal-delete js-modal-deleteCategory" style="display: none;">
    <form class="modal-delete-container js-modal-deleteCategory-container" method="POST" action="">
        @csrf
        @method('DELETE')
        <div class="modal-delete-close js-modal-deleteCategory-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <div class="modal-delete-body">
            <p>Do you want to delete this category?</p>
            <div class="btn-delete-choose">
                <button type="submit" class="btn-yes js-confirm-delete-category">Yes</button>
                <button type="button" class="btn-no js-cancel-delete-category">No</button>
            </div>
        </div>
    </form>
</div>
<script>
    let currentEditCategoryId = null;
    document.addEventListener('DOMContentLoaded', function() {
        // Add Category Modal
        document.querySelector('.js-add-category').onclick = function() {
            document.querySelector('.js-modal-addCategory').style.display = 'flex';
        };
        document.querySelector('.js-modal-addCategory-close').onclick = function() {
            document.querySelector('.js-modal-addCategory').style.display = 'none';
        };
        document.querySelector('.js-cancel-category').onclick = function() {
            document.querySelector('.js-modal-addCategory').style.display = 'none';
        };
        // Edit Category Modal
        document.querySelectorAll('.js-changeCategory').forEach(function(btn) {
            btn.onclick = function() {
                currentEditCategoryId = btn.getAttribute('data-category-id');
                document.getElementById('edit-category-name').value = btn.getAttribute('data-category-name');
                document.getElementById('edit-category-description').value = btn.getAttribute('data-category-description');
                document.querySelector('.js-modal-editCategory').style.display = 'flex';
                document.querySelector('.js-modal-editCategory-container').action = '/admin/categories/' + currentEditCategoryId;
            };
        });
        document.querySelector('.js-modal-editCategory-close').onclick = function() {
            document.querySelector('.js-modal-editCategory').style.display = 'none';
        };
        document.querySelector('.js-cancel-edit-category').onclick = function() {
            document.querySelector('.js-modal-editCategory').style.display = 'none';
        };
        // Delete Category Modal
        document.querySelectorAll('.js-delete-category').forEach(function(btn) {
            btn.onclick = function() {
                currentEditCategoryId = btn.getAttribute('data-category-id');
                document.querySelector('.js-modal-deleteCategory').style.display = 'flex';
                document.querySelector('.js-modal-deleteCategory-container').action = '/admin/categories/' + currentEditCategoryId;
            };
        });
        document.querySelector('.js-modal-deleteCategory-close').onclick = function() {
            document.querySelector('.js-modal-deleteCategory').style.display = 'none';
        };
        document.querySelector('.js-cancel-delete-category').onclick = function() {
            document.querySelector('.js-modal-deleteCategory').style.display = 'none';
        };
        // Close modal when clicking outside
        document.querySelectorAll('.modal, .modal-delete').forEach(function(modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection