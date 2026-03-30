@extends('layouts.admin')

@section('title','Product Management Module')

@section('content')
<div class="products-admin-container">
    <!-- Header with Title and Add Button -->
    <div class="admin-header">
        <div class="header-content">
            <h1>Product Management Module</h1>
            <p class="subtitle">Manage your product inventory - View Price, Stock, Edit & Remove</p>
        </div>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">
            <i class="fas fa-plus"></i> Add New Product
        </button>
    </div>

    <!-- Metrics Cards -->
    <div class="metrics-row">
        <div class="metric-card">
            <div class="metric-icon" style="background: #e3f2fd;">
                <i class="fas fa-box" style="color: #1976d2;"></i>
            </div>
            <div class="metric-content">
                <div class="metric-label">Total Products</div>
                <div class="metric-value">{{ $stats['total_products'] }}</div>
            </div>
        </div>
        <div class="metric-card">
            <div class="metric-icon" style="background: #e8f5e9;">
                <i class="fas fa-check-circle" style="color: #388e3c;"></i>
            </div>
            <div class="metric-content">
                <div class="metric-label">Active Products</div>
                <div class="metric-value">{{ $stats['active_products'] }}</div>
            </div>
        </div>
        <div class="metric-card">
            <div class="metric-icon" style="background: #fff3e0;">
                <i class="fas fa-exclamation-triangle" style="color: #f57c00;"></i>
            </div>
            <div class="metric-content">
                <div class="metric-label">Low Stock Items</div>
                <div class="metric-value">{{ $stats['low_stock'] }}</div>
            </div>
        </div>
        <div class="metric-card">
            <div class="metric-icon" style="background: #ffebee;">
                <i class="fas fa-times-circle" style="color: #d32f2f;"></i>
            </div>
            <div class="metric-content">
                <div class="metric-label">Out of Stock</div>
                <div class="metric-value">{{ $stats['out_of_stock'] }}</div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <form action="{{ route('products.admin') }}" method="GET" class="filter-form">
            <div class="filter-group">
                <label for="brand-filter">Filter by Brand:</label>
                <select name="brand" id="brand-filter" class="form-control">
                    <option value="">All Brands</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->brand_name }}" {{ request('brand') === $brand->brand_name ? 'selected' : '' }}>
                            {{ $brand->brand_name }}
                        </option>
                    @endforeach
                    <option value="unbranded" {{ request('brand') === 'unbranded' ? 'selected' : '' }}>
                        Unbranded
                    </option>
                </select>
            </div>

            <div class="filter-group">
                <label for="date-filter">Date Range:</label>
                <select name="days" id="date-filter" class="form-control">
                    <option value="">All Time</option>
                    <option value="7" {{ request('days') === '7' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="30" {{ request('days') === '30' ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="90" {{ request('days') === '90' ? 'selected' : '' }}>Last 90 Days</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="status-filter">Status:</label>
                <select name="status" id="status-filter" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="out_of_stock" {{ request('status') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>

            <button type="submit" class="btn btn-filter">
                <i class="fas fa-filter"></i> Apply Filters
            </button>
        </form>
    </div>

    <!-- Status Tabs -->
    <div class="status-tabs">
        <a href="{{ route('products.admin') }}" class="tab-item {{ !request('status') ? 'active' : '' }}">
            All Products
        </a>
        <a href="{{ route('products.admin', ['status' => 'active']) }}" class="tab-item {{ request('status') === 'active' ? 'active' : '' }}">
            Active
        </a>
        <a href="{{ route('products.admin', ['status' => 'draft']) }}" class="tab-item {{ request('status') === 'draft' ? 'active' : '' }}">
            Draft
        </a>
        <a href="{{ route('products.admin', ['status' => 'out_of_stock']) }}" class="tab-item {{ request('status') === 'out_of_stock' ? 'active' : '' }}">
            Out of Stock
        </a>
    </div>

    <!-- Products Grid (Module-based) -->
    <div class="products-grid">
        @forelse($products as $product)
            @include('components.product-module', ['product' => $product])
        @empty
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>No Products Found</h3>
                <p>Try adjusting your filters or <a href="{{ route('products.admin') }}">view all products</a></p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="pagination-wrapper">
            {{ $products->links() }}
        </div>
    @endif
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('products._form')
            </div>
        </div>
    </div>
</div>

<style>
.products-admin-container {
    padding: 20px;
    background: #f5f5f5;
    min-height: 100vh;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.header-content h1 {
    margin: 0 0 8px 0;
    font-size: 28px;
    font-weight: 700;
    color: #333;
}

.header-content .subtitle {
    margin: 0;
    color: #999;
    font-size: 14px;
}

.btn-primary {
    background: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: #45a049;
}

.metrics-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 30px;
}

.metric-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease;
}

.metric-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.metric-icon {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.metric-label {
    font-size: 12px;
    color: #999;
    margin-bottom: 4px;
}

.metric-value {
    font-size: 28px;
    font-weight: 700;
    color: #333;
}

.filters-section {
    background: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.filter-form {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    align-items: flex-end;
}

.filter-group {
    display: flex;
    flex-direction: column;
}

.filter-group label {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 6px;
    color: #333;
}

.form-control {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    min-width: 150px;
}

.form-control:focus {
    outline: none;
    border-color: #4CAF50;
    box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
}

.btn-filter {
    background: #0288d1;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
}

.btn-filter:hover {
    background: #0277bd;
}

.status-tabs {
    display: flex;
    gap: 12px;
    margin-bottom: 30px;
    border-bottom: 2px solid #e0e0e0;
    background: white;
    padding: 16px 20px;
    border-radius: 8px 8px 0 0;
}

.tab-item {
    padding: 10px 16px;
    border: none;
    background: none;
    cursor: pointer;
    font-weight: 600;
    color: #999;
    text-decoration: none;
    border-bottom: 3px solid transparent;
    margin-bottom: -1px;
    transition: all 0.2s ease;
}

.tab-item:hover {
    color: #333;
}

.tab-item.active {
    color: #4CAF50;
    border-bottom-color: #4CAF50;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 8px;
    color: #999;
}

.empty-state i {
    font-size: 48px;
    color: #ddd;
    margin-bottom: 16px;
}

.empty-state h3 {
    color: #666;
    margin-bottom: 8px;
}

.empty-state p {
    margin: 0;
}

.empty-state a {
    color: #4CAF50;
    text-decoration: none;
    font-weight: 600;
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 30px;
}

@media (max-width: 768px) {
    .admin-header {
        flex-direction: column;
        gap: 16px;
        text-align: center;
    }

    .metrics-row {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    }

    .filter-form {
        flex-direction: column;
    }

    .filter-group {
        width: 100%;
    }

    .form-control {
        min-width: 100%;
    }

    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }

    .status-tabs {
        overflow-x: auto;
        flex-wrap: nowrap;
    }
}
</style>
@endsection
