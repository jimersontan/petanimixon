<!-- ===== PRODUCTS ADMIN PAGE ===== -->
<!-- Extends the main admin layout -->
@extends('layouts.admin')

@section('title','Products')

@section('content')

<!-- ===== PAGE HEADER SECTION ===== -->
<!-- Title, subtitle, date filter, and add product button -->
<div class="content-header">
    <!-- Page Title and Subtitle -->
    <div>
        <h1 class="page-title">Products</h1>
        <p class="page-subtitle">Manage your product inventory</p>
    </div>
    <!-- End: Page Title -->

    <!-- Date Range Filter and Add New Product Button -->
    <div class="date-filter">
        <!-- Date Range Filter Form: Filters products by time period -->
        <form method="get" action="{{ route('products.readonly') }}" class="date-filter-form" id="productsDateForm">
            <!-- Brand Filter -->
            <select name="brand" class="filter-select" aria-label="Brand" onchange="this.form.submit()">
                <option value="">All Brands</option>
                <option value="unbranded" {{ ($selectedBrand ?? '') == 'unbranded' ? 'selected' : '' }}>Unbranded/No Brand</option>
                @foreach($brands as $b)
                    <option value="{{ $b->name }}" {{ ($selectedBrand ?? '') == $b->name ? 'selected' : '' }}>
                        {{ $b->name }}
                    </option>
                @endforeach
            </select>
            <!-- Date Range Filter -->
            <select name="days" id="productsDateRange" class="filter-select" aria-label="Date range" onchange="this.form.submit()">
                <option value="7" {{ ($days ?? 30) == 7 ? 'selected' : '' }}>Last 7 days</option>
                <option value="30" {{ ($days ?? 30) == 30 ? 'selected' : '' }}>Last 30 days</option>
                <option value="90" {{ ($days ?? 30) == 90 ? 'selected' : '' }}>Last 90 days</option>
            </select>
        </form>
        <!-- End: Date Range Filter -->

        <!-- Action Button Removed for Read-Only View -->
    </div>
    <!-- End: Date Filter and Action Button -->
</div>
<!-- ===== END PAGE HEADER SECTION ===== -->

<!-- ===== METRICS CARDS SECTION ===== -->
<!-- Four summary cards: Total Products, Active, Low Stock, Out of Stock -->
<div class="metrics-grid">

    <!-- Metric Card: Total Products -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-orders-orange">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3 3v8h8V3H3zm10 0v8h8V3h-8zM3 13v8h8v-8H3zm10 0v8h8v-8h-8z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value" id="productsTotal">{{ number_format($stats['total_products'] ?? 0) }}</div>
            <div class="metric-label">Total Products</div>
        </div>
    </div>
    <!-- End: Total Products Card -->

    <!-- Metric Card: Active Products -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-completed">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value" id="productsActive">{{ number_format($stats['active_products'] ?? 0) }}</div>
            <div class="metric-label">Active</div>
        </div>
    </div>
    <!-- End: Active Products Card -->

    <!-- Metric Card: Low Stock Items -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-pending">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value" id="productsLowStock">{{ number_format($stats['low_stock'] ?? 0) }}</div>
            <div class="metric-label">Low Stock Items</div>
        </div>
    </div>
    <!-- End: Low Stock Card -->

    <!-- Metric Card: Out of Stock -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-cancelled">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value" id="productsOutOfStock">{{ number_format($stats['out_of_stock'] ?? 0) }}</div>
            <div class="metric-label">Out of Stock</div>
        </div>
    </div>
    <!-- End: Out of Stock Card -->

</div>
<!-- ===== END METRICS CARDS SECTION ===== -->

<!-- ===== PRODUCTS TABLE SECTION ===== -->
<!-- Main table listing all products with filtering and actions -->
<div class="card orders-table-card">

    <!-- Table Header: Title and Filter Button -->
    <div class="orders-section-header">
        <h2 class="card-title">All Products</h2>
        <div class="orders-actions">
            <button type="button" class="btn-secondary btn-filter">
                <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/></svg>
                Filter
            </button>
        </div>
    </div>
    <!-- End: Table Header -->

    <!-- Status Filter Tabs: All, Active, Draft, Out of Stock -->
    <div class="order-status-tabs" role="tablist">
        @php $currentStatus = $status ?? 'all'; @endphp
        <a href="{{ route('products.readonly', array_merge(request()->all(), ['status' => 'all'])) }}"
           class="order-tab {{ $currentStatus === 'all' ? 'active' : '' }}"
           role="tab"
           aria-selected="{{ $currentStatus === 'all' ? 'true' : 'false' }}">All</a>
        <a href="{{ route('products.readonly', array_merge(request()->all(), ['status' => 'active'])) }}"
           class="order-tab {{ $currentStatus === 'active' ? 'active' : '' }}"
           role="tab"
           aria-selected="{{ $currentStatus === 'active' ? 'true' : 'false' }}">Active</a>
        <a href="{{ route('products.readonly', array_merge(request()->all(), ['status' => 'draft'])) }}"
           class="order-tab {{ $currentStatus === 'draft' ? 'active' : '' }}"
           role="tab"
           aria-selected="{{ $currentStatus === 'draft' ? 'true' : 'false' }}">Draft</a>
        <a href="{{ route('products.readonly', array_merge(request()->all(), ['status' => 'out_of_stock'])) }}"
           class="order-tab {{ $currentStatus === 'out_of_stock' ? 'active' : '' }}"
           role="tab"
           aria-selected="{{ $currentStatus === 'out_of_stock' ? 'true' : 'false' }}">Out of Stock</a>
    </div>
    <!-- End: Status Filter Tabs -->

    <!-- Products Data Table -->
    <div class="table-wrap">
        <table class="orders-table" id="productsTable">
            <!-- Table Header Columns -->
            <thead>
                <tr>
                    <th class="col-checkbox">
                        <input type="checkbox" class="select-all" id="selectAllProducts" aria-label="Select all products">
                    </th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                </tr>
            </thead>
            <!-- End: Table Header -->

            <!-- Table Body: Product Rows -->
            <tbody>
                <!-- Status badge CSS class mapping -->
                @php
                    $statusBadge = [
                        'active' => 'badge-paid',
                        'draft' => 'badge-pending',
                        'out_of_stock' => 'badge-failed',
                    ];
                @endphp

                <!-- Loop: Render each product row -->
                @forelse(($products ?? []) as $product)
                <tr data-status="{{ $product->product_status ?? 'active' }}">
                    <!-- Checkbox Column -->
                    <td class="col-checkbox">
                        <input type="checkbox" class="order-checkbox" value="{{ $product->id }}">
                    </td>
                    <!-- Product Name and SKU -->
                    <td>
                        <div class="product-cell">
                            <img src="{{ $product->image_url }}" alt="Product Thumb" class="product-thumb-sm" style="object-fit: cover;">
                            <span class="product-meta">
                                <span class="product-name">{{ $product->product_name ?? '' }}</span>
                                <span class="product-sku">SKU: {{ $product->sku ?? '' }}</span>
                            </span>
                        </div>
                    </td>
                    <!-- Category Name -->
                    <td>{{ optional($product->category)->category_name ?? '' }}</td>
                    <!-- Price -->
                    <td>{{ isset($product->price) ? '' . number_format((float)$product->price, 2) : '' }}</td>
                    <!-- Stock Count -->
                    <td>{{ $product->stock ?? 0 }}</td>
                    <!-- Status Badge -->
                    <td>
                        @php $status = $product->product_status ?? 'active'; @endphp
                        <span class="badge {{ $statusBadge[$status] ?? 'badge-pending' }}">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                    </td>
                    <!-- Action Buttons: Removed for Read-Only View -->
                </tr>
                @empty
                <!-- Empty State: Shown when no products exist -->
                <tr>
                    <td colspan="7" class="text-center empty-orders">No products found yet.</td>
                </tr>
                @endforelse
                <!-- End: Product Rows Loop -->
            </tbody>
            <!-- End: Table Body -->
        </table>
    </div>
    <!-- End: Products Data Table -->

    <!-- Pagination: Only shown if products span multiple pages -->
    @if(isset($products) && $products instanceof \Illuminate\Contracts\Pagination\Paginator && $products->hasPages())
    <div class="orders-pagination">
        {{ $products->links() }}
    </div>
    @endif
    <!-- End: Pagination -->

</div>
<!-- ===== END PRODUCTS TABLE SECTION ===== -->

@endsection

<!-- Modals Removed for Read-Only View -->

<!-- Page-Specific Scripts -->
@push('scripts')
<!-- Orders JS: Additional table interaction scripts for this page -->
<script src="{{ asset('js/orders.js') }}"></script>
@endpush
