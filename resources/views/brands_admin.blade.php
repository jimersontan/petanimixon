<!-- ===== BRANDS ADMIN PAGE ===== -->
<!-- Extends the main admin layout -->
@extends('layouts.admin')

@section('title','Brands')

@section('content')

<!-- ===== PAGE HEADER SECTION ===== -->
<!-- Title and Add Brand button -->
<div class="content-header">
    <h1 class="page-title">Brands</h1>
    <div class="date-filter">
        <!-- Add Brand Button: Opens the brand creation modal -->
        <button type="button" class="btn-primary" onclick="openBrandModal('add')">
            <span class="btn-icon">+</span>
            <span>Add Brand</span>
        </button>
    </div>
</div>
<!-- ===== END PAGE HEADER SECTION ===== -->

<!-- ===== METRICS CARDS SECTION ===== -->
<!-- Four summary cards: Total Brands, Active, Featured, Avg Products/Brand -->
<div class="metrics-grid">

    <!-- Metric Card: Total Brands -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-orders-orange">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3 3h18v4H3z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ number_format($stats['total_brands'] ?? 0) }}</div>
            <div class="metric-label">Total Brands</div>
        </div>
    </div>
    <!-- End: Total Brands Card -->

    <!-- Metric Card: Active Brands -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-completed">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ number_format($stats['active_brands'] ?? 0) }}</div>
            <div class="metric-label">Active</div>
        </div>
    </div>
    <!-- End: Active Brands Card -->

    <!-- Metric Card: Featured Brands -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-avg">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ number_format($stats['featured_brands'] ?? 0) }}</div>
            <div class="metric-label">Featured</div>
        </div>
    </div>
    <!-- End: Featured Brands Card -->

    <!-- Metric Card: Average Products Per Brand -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-avg">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3 17h18v4H3z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ number_format($stats['avg_products_per_brand'] ?? 0, 1) }}</div>
            <div class="metric-label">Avg Products/Brand</div>
        </div>
    </div>
    <!-- End: Avg Products Card -->

</div>
<!-- ===== END METRICS CARDS SECTION ===== -->

<!-- ===== BRANDS TABLE SECTION ===== -->
<!-- Main table listing all brands with logo, product count, status, and actions -->
<div class="card orders-table-card">
    <!-- Table Header: Title and Filter Button -->
    <div class="orders-section-header">
        <h2 class="card-title">All Brands</h2>
        <div class="orders-actions">
            <!-- Filter Actions Placeholder -->
        </div>
    </div>
    <!-- End: Table Header -->

    <!-- Status Filter Tabs: All, Active, Draft -->
    <div class="order-status-tabs" role="tablist">
        @php $currentStatus = $status ?? 'all'; @endphp
        <a href="{{ route('brands.admin', array_merge(request()->all(), ['status' => 'all'])) }}"
           class="order-tab {{ $currentStatus === 'all' ? 'active' : '' }}"
           role="tab"
           aria-selected="{{ $currentStatus === 'all' ? 'true' : 'false' }}">All</a>
        <a href="{{ route('brands.admin', array_merge(request()->all(), ['status' => 'active'])) }}"
           class="order-tab {{ $currentStatus === 'active' ? 'active' : '' }}"
           role="tab"
           aria-selected="{{ $currentStatus === 'active' ? 'true' : 'false' }}">Active</a>
        <a href="{{ route('brands.admin', array_merge(request()->all(), ['status' => 'draft'])) }}"
           class="order-tab {{ $currentStatus === 'draft' ? 'active' : '' }}"
           role="tab"
           aria-selected="{{ $currentStatus === 'draft' ? 'true' : 'false' }}">Draft</a>
    </div>
    <!-- End: Status Filter Tabs -->

    <!-- Brands Data Table -->
    <div class="table-wrap">
        <table class="orders-table" id="brandsTable">
            <!-- Table Header Columns -->
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Logo</th>
                    <th>Products</th>
                    <th>Status</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <!-- End: Table Header -->

            <!-- Table Body: Brand Rows -->
            <tbody>
                <!-- Loop: Render each brand row -->
                @forelse($brands as $brand)
                <tr>
                    <!-- Brand Name -->
                    <td>{{ $brand->name ?? '—' }}</td>
                    <!-- Brand Logo: Shows image if uploaded, dash if not -->
                    <td>
                        @if(!empty($brand->logo_path))
                            <img src="{{ $brand->logo_full_url }}" alt="{{ $brand->name }} logo" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        @else
                            —
                        @endif
                    </td>
                    <!-- Product Count -->
                    <td>{{ $brand->products_count ?? 0 }}</td>
                    <!-- Active/Inactive Status -->
                    <td>{{ ($brand->is_active ?? true) ? 'Active' : 'Inactive' }}</td>
                    <!-- Action Buttons: Edit and Deactivate -->
                    <td class="col-actions">
                        <!-- Edit Button -->
                        <button type="button" class="action-btn" title="Edit" aria-label="Edit brand"
                            onclick="openBrandModal('edit', {
                                id: {{ $brand->id }},
                                name: '{{ addslashes($brand->name) }}',
                                description: '{{ addslashes($brand->description ?? '') }}',
                                is_featured: {{ $brand->is_featured ? 'true' : 'false' }},
                                is_active: {{ $brand->is_active ? '1' : '0' }},
                                logo_path: '{{ $brand->logo_path ? $brand->logo_full_url : '' }}'
                            })">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                        </button>
                        <!-- Draft Button: Only for active brands -->
                        @if($brand->is_active ?? true)
                        <!-- Draft Button (Soft Deactivate) -->
                        <form method="POST" action="{{ route('brands.draft', $brand->id) }}" style="display:inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="action-btn" title="Deactivate Brand (Move to Draft)" onclick="return confirm('Deactivate this brand and move to Draft?')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                            </button>
                        </form>
                        @else
                        <!-- Restore Button -->
                        <form method="POST" action="{{ route('brands.restore', $brand->id) }}" style="display:inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="action-btn" title="Restore Brand" style="color: #22c55e;" onclick="return confirm('Restore this brand and make it active again?')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" /><path d="M3 3v5h5" /></svg>
                            </button>
                        </form>
                        <!-- Permanent Delete Button -->
                        <form method="POST" action="{{ route('brands.destroy', $brand->id) }}" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn" title="Permanently Delete Brand" onclick="return confirm('⚠️ PERMANENT DELETE\n\nAre you sure you want to permanently delete this brand? This cannot be undone!')" style="color: #ef4444; transition: opacity 0.2s; opacity: 0.85;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.85'">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-4.5l-1-1zM18 7H6v12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7z"/></svg>
                            </button>
                        </form>
                        @endif
                    </td>
                    <!-- End: Action Buttons -->
                </tr>
                @empty
                <!-- Empty State: Shown when no brands exist -->
                <tr>
                    <td colspan="4" class="text-center empty-orders">No brands defined yet.</td>
                </tr>
                @endforelse
                <!-- End: Brand Rows Loop -->
            </tbody>
            <!-- End: Table Body -->
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $brands->links() ?? '' }}
        </div>
        <!-- End: Pagination -->
    </div>
    <!-- End: Brands Data Table -->

</div>
<!-- ===== END BRANDS TABLE SECTION ===== -->

@endsection

<!-- ===== BRAND MODAL (ADD/EDIT) ===== -->
<!-- Modal popup for creating or editing a brand -->
@push('modals')
<!-- Modal Backdrop: Dark overlay -->
<div class="modal-backdrop {{ $errors->any() ? 'open' : '' }}" data-modal-id="brand-modal"></div>

<!-- Modal Container -->
<div id="brand-modal" class="modal {{ $errors->any() ? 'open' : '' }}" style="max-width: 800px; width: 95%;" role="dialog" aria-modal="true" aria-labelledby="brandModalTitle" tabindex="-1">

    <!-- Modal Header: Title and Close Button -->
    <div class="modal-header">
        <h2 id="brandModalTitle" class="modal-title">Add Brand</h2>
        <button type="button" class="modal-close" data-modal-close="brand-modal" aria-label="Close modal">&times;</button>
    </div>
    <!-- End: Modal Header -->

    <!-- Modal Body: Form for entering brand details -->
    <div class="modal-body">
        <form id="brandModalForm" method="POST" action="{{ route('brands.store') }}" enctype="multipart/form-data">
            @csrf
            <div id="brandMethodContainer"></div>
            <!-- Include the reusable brand form partial -->
            @include('brands._form', ['brand' => new \App\Models\Brand()])

            <!-- Modal Footer: Cancel and Save Buttons -->
            <div class="modal-footer" style="padding-top: 20px; border-top: 1px solid #f3f4f6; margin-top: 20px;">
                <button type="button" class="btn-secondary" data-modal-close="brand-modal">Cancel</button>
                <button type="submit" id="brandModalSubmitBtn" class="btn-primary">Save Brand</button>
            </div>
            <!-- End: Modal Footer -->
        </form>
    </div>
    <!-- End: Modal Body -->

</div>
<!-- ===== END BRAND MODAL ===== -->
@endpush

<!-- Page-Specific Scripts -->
@push('scripts')
<!-- Orders JS: Table interaction scripts -->
<script src="{{ asset('js/orders.js') }}"></script>
<!-- Image Upload Logic -->
<script src="{{ asset('js/paste-upload.js') }}"></script>
<script>
    function openBrandModal(mode, data = null) {
        const modal = document.getElementById('brand-modal');
        const backdrop = document.querySelector('.modal-backdrop[data-modal-id="brand-modal"]');
        const form = document.getElementById('brandModalForm');
        const title = document.getElementById('brandModalTitle');
        const submitBtn = document.getElementById('brandModalSubmitBtn');
        const methodContainer = document.getElementById('brandMethodContainer');
        
        // Reset form
        form.reset();
        
        // Reset image preview in paste zone
        const preview = form.querySelector('.upload-preview');
        const pasteZone = form.querySelector('.paste-upload-zone');
        if (pasteZone) pasteZone.classList.remove('has-file');
        if (preview) preview.innerHTML = '';
        
        if (mode === 'add') {
            title.textContent = 'Add Brand';
            submitBtn.textContent = 'Save Brand';
            form.action = "{{ route('brands.store') }}";
            methodContainer.innerHTML = '';
            
            // Set defaults
            document.getElementById('is_active').value = 1;
            document.querySelector('[name="is_featured"]').checked = false;
        } else if (mode === 'edit' && data) {
            title.textContent = 'Edit Brand';
            submitBtn.textContent = 'Save Changes';
            form.action = `/admin/brands/${data.id}`;
            methodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            
            document.getElementById('name').value = data.name;
            document.getElementById('description').value = data.description;
            document.getElementById('is_active').value = data.is_active;
            document.querySelector('[name="is_featured"]').checked = data.is_featured;
            
            if (data.logo_path) {
                if (pasteZone) pasteZone.classList.add('has-file');
                if (preview) {
                    preview.innerHTML = `<img src="${data.logo_path}" alt="Preview"><div class="upload-filename">Current Logo</div>`;
                }
            }
        }
        
        modal.classList.add('open');
        backdrop.classList.add('open');
    }
</script>
@endpush


