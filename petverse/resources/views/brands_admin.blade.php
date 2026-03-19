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
        <button type="button" class="btn-primary" data-modal-open="add-brand-modal">
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
    <h2 class="card-title">All Brands</h2>

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
                @forelse(($brands ?? []) as $brand)
                <tr>
                    <!-- Brand Name -->
                    <td>{{ $brand->name ?? '—' }}</td>
                    <!-- Brand Logo: Shows image if uploaded, dash if not -->
                    <td>
                        @if(!empty($brand->logo_path))
                            <img src="{{ asset('storage/'.$brand->logo_path) }}" alt="{{ $brand->name }} logo" style="max-height:40px;">
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
                        <a href="{{ route('brands.edit', $brand) }}" class="action-btn" title="Edit" aria-label="Edit brand">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                        </a>
                        <!-- Deactivate Button: Submits DELETE form to soft-deactivate -->
                        <form method="POST" action="{{ route('brands.destroy', $brand) }}" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn" title="Deactivate" onclick="return confirm('Deactivate this brand?')">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-4.5l-1-1z"/></svg>
                            </button>
                        </form>
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

<!-- ===== ADD BRAND MODAL ===== -->
<!-- Modal popup for creating a new brand -->
@push('modals')
<!-- Modal Backdrop: Dark overlay -->
<div class="modal-backdrop {{ $errors->any() ? 'open' : '' }}" data-modal-id="add-brand-modal"></div>

<!-- Modal Container -->
<div id="add-brand-modal" class="modal {{ $errors->any() ? 'open' : '' }}" role="dialog" aria-modal="true" aria-labelledby="addBrandTitle" tabindex="-1">

    <!-- Modal Header: Title and Close Button -->
    <div class="modal-header">
        <h2 id="addBrandTitle" class="modal-title">Add Brand</h2>
        <button type="button" class="modal-close" data-modal-close="add-brand-modal" aria-label="Close modal">&times;</button>
    </div>
    <!-- End: Modal Header -->

    <!-- Modal Body: Form for entering brand details -->
    <div class="modal-body">
        <form method="POST" action="{{ route('brands.store') }}" enctype="multipart/form-data">
            @csrf
            <!-- Include the reusable brand form partial -->
            @include('brands._form')

            <!-- Modal Footer: Cancel and Create Buttons -->
            <div class="modal-footer">
                <button type="button" class="btn-secondary" data-modal-close="add-brand-modal">Cancel</button>
                <button type="submit" class="btn-primary">Create Brand</button>
            </div>
            <!-- End: Modal Footer -->
        </form>
    </div>
    <!-- End: Modal Body -->

</div>
<!-- ===== END ADD BRAND MODAL ===== -->
@endpush

<!-- Page-Specific Scripts -->
@push('scripts')
<!-- Orders JS: Table interaction scripts -->
<script src="{{ asset('js/orders.js') }}"></script>
@endpush
