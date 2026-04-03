<!-- ===== CATEGORIES ADMIN PAGE ===== -->
<!-- Extends the main admin layout -->
@extends('layouts.admin')

@section('title','Categories')

@section('content')

<!-- ===== PAGE HEADER SECTION ===== -->
<!-- Title and Add Category button -->
<div class="content-header">
    <h1 class="page-title">Categories</h1>
    <div class="date-filter">
        <!-- Add Category Button: Opens the category creation modal -->
        <button type="button" class="btn-primary" onclick="openCategoryModal('add')">
            <span class="btn-icon">+</span>
            <span>Add Category</span>
        </button>
    </div>
</div>
<!-- ===== END PAGE HEADER SECTION ===== -->

<!-- ===== METRICS CARDS SECTION ===== -->
<!-- Four summary cards: Total, Active, Total Products, Avg Products/Category -->
<div class="metrics-grid">

    <!-- Metric Card: Total Categories -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-orders-orange">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3 3v8h8V3H3zm10 0v8h8V3h-8zM3 13v8h8v-8H3zm10 0v8h8v-8h-8z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ number_format($stats['total_categories'] ?? 0) }}</div>
            <div class="metric-label">Total Categories</div>
        </div>
    </div>
    <!-- End: Total Categories Card -->

    <!-- Metric Card: Active Categories -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-completed">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ number_format($stats['active_categories'] ?? 0) }}</div>
            <div class="metric-label">Active Categories</div>
        </div>
    </div>
    <!-- End: Active Categories Card -->

    <!-- Metric Card: Total Products (across all categories) -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-orders">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M20 2H4c-1 0-2 .9-2 2v3.01c0 .72.43 1.34 1 1.69V20c0 1.1 1.1 2 2 2h14c.9 0 2-.9 2-2V8.7c.57-.35 1-.97 1-1.69V4c0-1.1-1-2-2-2zm-5 12H9v-2h6v2zm5-7H4V4h16v3z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ number_format($stats['total_products'] ?? 0) }}</div>
            <div class="metric-label">Total Products</div>
        </div>
    </div>
    <!-- End: Total Products Card -->

    <!-- Metric Card: Average Products Per Category -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-avg">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ number_format($stats['avg_products_per_category'] ?? 0) }}</div>
            <div class="metric-label">Avg Products/Category</div>
        </div>
    </div>
    <!-- End: Avg Products Card -->

</div>
<!-- ===== END METRICS CARDS SECTION ===== -->

<!-- ===== CATEGORIES TABLE SECTION ===== -->
<!-- Main table showing all categories with parent, product count, status, and actions -->
<div class="card orders-table-card">
    <!-- Table Header: Title and Filter Button -->
    <div class="orders-section-header">
        <h2 class="card-title">Category Structure</h2>
        <div class="orders-actions">
            <!-- Filter Actions Placeholder -->
        </div>
    </div>
    <!-- End: Table Header -->

    <!-- Status Filter Tabs: All, Active, Draft -->
    <div class="order-status-tabs" role="tablist">
        @php $currentStatus = $status ?? 'all'; @endphp
        <a href="{{ route('categories.admin', array_merge(request()->all(), ['status' => 'all'])) }}"
           class="order-tab {{ $currentStatus === 'all' ? 'active' : '' }}"
           role="tab"
           aria-selected="{{ $currentStatus === 'all' ? 'true' : 'false' }}">All</a>
        <a href="{{ route('categories.admin', array_merge(request()->all(), ['status' => 'active'])) }}"
           class="order-tab {{ $currentStatus === 'active' ? 'active' : '' }}"
           role="tab"
           aria-selected="{{ $currentStatus === 'active' ? 'true' : 'false' }}">Active</a>
        <a href="{{ route('categories.admin', array_merge(request()->all(), ['status' => 'draft'])) }}"
           class="order-tab {{ $currentStatus === 'draft' ? 'active' : '' }}"
           role="tab"
           aria-selected="{{ $currentStatus === 'draft' ? 'true' : 'false' }}">Draft</a>
    </div>
    <!-- End: Status Filter Tabs -->

    <!-- Categories Data Table -->
    <div class="table-wrap">
        <table class="orders-table" id="categoriesTable">
            <!-- Table Header Columns -->
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Products</th>
                    <th>Status</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <!-- End: Table Header -->

            <!-- Table Body: Category Rows -->
            <tbody>
                <!-- Loop: Render each category row -->
                @forelse($categories as $category)
                <tr>
                    <!-- Category Name -->
                    <td>{{ $category->category_name ?? '' }}</td>
                    <!-- Number of Products in this Category -->
                    <td>{{ $category->products_count ?? 0 }}</td>
                    <!-- Active/Inactive Status -->
                    <td>{{ ($category->is_active ?? true) ? 'Active' : 'Inactive' }}</td>
                    <!-- Action Buttons: Edit and Deactivate -->
                    <td class="col-actions">
                        <!-- Edit Button -->
                        <button type="button" class="action-btn" title="Edit" aria-label="Edit category"
                            onclick="openCategoryModal('edit', {
                                id: {{ $category->id }},
                                name: '{{ addslashes($category->category_name) }}',
                                description: '{{ addslashes($category->description ?? '') }}',
                                sort_order: {{ $category->sort_order ?? 0 }},
                                is_featured: {{ $category->is_featured ? 'true' : 'false' }},
                                is_active: {{ $category->is_active ? '1' : '0' }},
                                image_url: '{{ $category->image_url ? asset('storage/'.$category->image_url) : '' }}'
                            })">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                        </button>
                        <!-- Draft Button: Only for active categories -->
                        @if($category->is_active ?? true)
                        <!-- Draft Button (Soft Deactivate) -->
                        <form method="POST" action="{{ route('categories.draft', $category->id) }}" style="display:inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="action-btn" title="Deactivate Category (Move to Draft)" onclick="return confirm('Deactivate this category and move to Draft?')">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                            </button>
                        </form>
                        @else
                        <!-- Permanent Delete Button -->
                        <form method="POST" action="{{ route('categories.destroy', $category->id) }}" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn" title="Permanently Delete Category" onclick="return confirm('⚠️ PERMANENT DELETE\n\nAre you sure you want to permanently delete this category? This cannot be undone!')" style="color: #ef4444; transition: opacity 0.2s; opacity: 0.85;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.85'">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-4.5l-1-1zM18 7H6v12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7z"/></svg>
                            </button>
                        </form>
                        @endif
                    </td>
                    <!-- End: Action Buttons -->
                </tr>
                @empty
                <!-- Empty State: Shown when no categories exist -->
                <tr>
                    <td colspan="4" class="text-center empty-orders">No categories defined yet.</td>
                </tr>
                @endforelse
                <!-- End: Category Rows Loop -->
            </tbody>
            <!-- End: Table Body -->
        </table>
    </div>
    <!-- End: Categories Data Table -->

</div>
<!-- ===== END CATEGORIES TABLE SECTION ===== -->

@endsection

<!-- ===== CATEGORY MODAL (ADD/EDIT) ===== -->
<!-- Modal popup for creating or editing a category -->
@push('modals')
<!-- Modal Backdrop: Dark overlay -->
<div class="modal-backdrop {{ $errors->any() ? 'open' : '' }}" data-modal-id="category-modal"></div>

<!-- Modal Container -->
<div id="category-modal" class="modal {{ $errors->any() ? 'open' : '' }}" style="max-width: 800px; width: 95%;" role="dialog" aria-modal="true" aria-labelledby="categoryModalTitle" tabindex="-1">

    <!-- Modal Header: Title and Close Button -->
    <div class="modal-header">
        <h2 id="categoryModalTitle" class="modal-title">Add Category</h2>
        <button type="button" class="modal-close" data-modal-close="category-modal" aria-label="Close modal">&times;</button>
    </div>
    <!-- End: Modal Header -->

    <!-- Modal Body: Form for entering category details -->
    <div class="modal-body">
        <form id="categoryModalForm" action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="categoryMethodContainer"></div>
            <!-- Include the reusable category form partial -->
            @include('categories._form', ['category' => new \App\Models\Category()])

            <!-- Modal Footer: Cancel and Save Buttons -->
            <div class="modal-footer" style="padding-top: 20px; border-top: 1px solid #f3f4f6; margin-top: 20px;">
                <button type="button" class="btn-secondary" data-modal-close="category-modal">Cancel</button>
                <button type="submit" id="categoryModalSubmitBtn" class="btn-primary">Save Category</button>
            </div>
            <!-- End: Modal Footer -->
        </form>
    </div>
    <!-- End: Modal Body -->

</div>
<!-- ===== END CATEGORY MODAL ===== -->
@endpush

<!-- Page-Specific Scripts -->
@push('scripts')
<!-- Orders JS: Table interaction scripts -->
<script src="{{ asset('js/orders.js') }}"></script>
<script>
    function openCategoryModal(mode, data = null) {
        const modal = document.getElementById('category-modal');
        const backdrop = document.querySelector('.modal-backdrop[data-modal-id="category-modal"]');
        const form = document.getElementById('categoryModalForm');
        const title = document.getElementById('categoryModalTitle');
        const submitBtn = document.getElementById('categoryModalSubmitBtn');
        const methodContainer = document.getElementById('categoryMethodContainer');
        
        // Reset form
        form.reset();
        
        // Reset image preview in paste zone
        const preview = form.querySelector('.upload-preview');
        const pasteZone = form.querySelector('.paste-upload-zone');
        if (pasteZone) pasteZone.classList.remove('has-file');
        if (preview) preview.innerHTML = '';
        
        if (mode === 'add') {
            title.textContent = 'Add Category';
            submitBtn.textContent = 'Save Category';
            form.action = "{{ route('categories.store') }}";
            methodContainer.innerHTML = '';
            
            // Set defaults
            document.getElementById('sort_order').value = 0;
            document.getElementById('is_active').value = 1;
            document.querySelector('[name="is_featured"]').checked = false;
        } else if (mode === 'edit' && data) {
            title.textContent = 'Edit Category';
            submitBtn.textContent = 'Save Changes';
            form.action = `/admin/categories/${data.id}`;
            methodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            
            document.getElementById('category_name').value = data.name;
            document.getElementById('description').value = data.description;
            document.getElementById('sort_order').value = data.sort_order;
            document.getElementById('is_active').value = data.is_active;
            document.querySelector('[name="is_featured"]').checked = data.is_featured;
            
            if (data.image_url) {
                if (pasteZone) pasteZone.classList.add('has-file');
                if (preview) {
                    preview.innerHTML = `<img src="${data.image_url}" alt="Preview"><div class="upload-filename">Current Image</div>`;
                }
            }
        }
        
        modal.classList.add('open');
        backdrop.classList.add('open');
    }
</script>
@endpush
