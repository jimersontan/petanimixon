@extends('layouts.admin')

@section('title', 'Inventory Management')

@section('content')
<div class="inventory-management-page">
    <!-- Page Header -->
    <div class="inventory-header-section">
        <div class="header-top">
            <h1>Inventory Management</h1>
            <p class="subtitle">Manage product inventory - View Price, Stock, Edit & Remove</p>
        </div>
        <button class="btn btn-add-product" data-toggle="modal" data-target="#addProductModal">
            <i class="fas fa-plus"></i> Add New Product
        </button>
    </div>

    <!-- Inventory Stats -->
    <div class="inventory-stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background: #e3f2fd; color: #1976d2;">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Products</div>
                <div class="stat-number">{{ $stats['total_products'] ?? 0 }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #e8f5e9; color: #388e3c;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Active Products</div>
                <div class="stat-number active">{{ $stats['active_products'] ?? 0 }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fff3e0; color: #f57c00;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Low Stock Items</div>
                <div class="stat-number warning">{{ $stats['low_stock'] ?? 0 }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #ffebee; color: #d32f2f;">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Out of Stock</div>
                <div class="stat-number danger">{{ $stats['out_of_stock'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="inventory-filters">
        <form action="{{ route('inventory.admin') }}" method="GET" class="filter-form">
            <div class="filter-field">
                <label for="brand-filter">Brand:</label>
                <select name="brand" id="brand-filter" class="form-control">
                    <option value="">All Brands</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->brand_name }}" {{ request('brand') === $brand->brand_name ? 'selected' : '' }}>
                            {{ $brand->brand_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-field">
                <label for="stock-filter">Stock Status:</label>
                <select name="stock_status" id="stock-filter" class="form-control">
                    <option value="">All Items</option>
                    <option value="in_stock" {{ request('stock_status') === 'in_stock' ? 'selected' : '' }}>In Stock</option>
                    <option value="low_stock" {{ request('stock_status') === 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                    <option value="out_of_stock" {{ request('stock_status') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
            <button type="submit" class="btn btn-filter">
                <i class="fas fa-filter"></i> Filter
            </button>
        </form>
    </div>

    <!-- Inventory Table -->
    <div class="inventory-table-container">
        @if($products->count() > 0)
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        @php
                            $totalStock = $product->variants->sum('stock') ?? 0;
                            $stockStatus = $totalStock == 0 ? 'out-of-stock' : ($totalStock <= 5 ? 'low-stock' : 'in-stock');
                        @endphp
                        <tr class="inventory-row">
                            <td class="product-name">
                                <strong>{{ $product->product_name }}</strong>
                            </td>
                            <td class="product-sku">
                                <code>{{ $product->sku }}</code>
                            </td>
                            <td class="product-category">
                                {{ $product->category->category_name ?? 'N/A' }}
                            </td>
                            <td class="product-brand">
                                {{ $product->brand_name ?? 'Unbranded' }}
                            </td>
                            <td class="product-price">
                                <span class="price-badge">₱{{ number_format((float)$product->price, 2) }}</span>
                            </td>
                            <td class="product-stock">
                                <div class="stock-info">
                                    <span class="stock-number">{{ $totalStock }}</span>
                                    @if($stockStatus === 'out-of-stock')
                                        <span class="stock-badge danger">Out of Stock</span>
                                    @elseif($stockStatus === 'low-stock')
                                        <span class="stock-badge warning">Low Stock</span>
                                    @else
                                        <span class="stock-badge success">In Stock</span>
                                    @endif
                                </div>
                            </td>
                            <td class="product-status">
                                <span class="status-badge {{ strtolower($product->product_status) }}">
                                    {{ ucfirst($product->product_status) }}
                                </span>
                            </td>
                            <td class="product-actions">
                                <a href="{{ route('products.edit', $product->id) }}" 
                                   class="action-btn edit-btn" 
                                   title="Edit Product">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" 
                                      method="POST" 
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="action-btn delete-btn" 
                                            title="Remove Product"
                                            onclick="return confirm('Are you sure you want to remove this product?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="pagination-wrapper">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>No Products Found</h3>
                <p>Try adjusting your filters or <a href="{{ route('inventory.admin') }}">view all products</a></p>
            </div>
        @endif
    </div>
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
.inventory-management-page {
    padding: 20px;
    background: #f5f5f5;
    min-height: 100vh;
}

.inventory-header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 25px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.header-top h1 {
    margin: 0 0 8px 0;
    font-size: 28px;
    font-weight: 700;
    color: #333;
}

.header-top .subtitle {
    margin: 0;
    color: #999;
    font-size: 14px;
}

.btn-add-product {
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
    transition: all 0.2s;
}

.btn-add-product:hover {
    background: #45a049;
}

.inventory-stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 25px;
}

.stat-card {
    background: white;
    padding: 18px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: all 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 45px;
    height: 45px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.stat-label {
    font-size: 12px;
    color: #999;
    margin-bottom: 4px;
}

.stat-number {
    font-size: 24px;
    font-weight: 700;
    color: #333;
}

.stat-number.active {
    color: #4CAF50;
}

.stat-number.warning {
    color: #ff9800;
}

.stat-number.danger {
    color: #f44336;
}

.inventory-filters {
    background: white;
    padding: 18px;
    border-radius: 8px;
    margin-bottom: 25px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.filter-form {
    display: flex;
    gap: 15px;
    align-items: flex-end;
    flex-wrap: wrap;
}

.filter-field {
    display: flex;
    flex-direction: column;
}

.filter-field label {
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 6px;
    color: #333;
}

.form-control {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 13px;
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
    transition: all 0.2s;
}

.btn-filter:hover {
    background: #0277bd;
}

.inventory-table-container {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.inventory-table {
    width: 100%;
    border-collapse: collapse;
}

.inventory-table thead {
    background: #f5f5f5;
    border-bottom: 2px solid #e0e0e0;
}

.inventory-table th {
    padding: 15px;
    text-align: left;
    font-weight: 600;
    color: #333;
    font-size: 13px;
    text-transform: uppercase;
}

.inventory-table tbody tr {
    border-bottom: 1px solid #e0e0e0;
    transition: background-color 0.2s;
}

.inventory-table tbody tr:hover {
    background-color: #f9f9f9;
}

.inventory-row td {
    padding: 15px;
    font-size: 13px;
    vertical-align: middle;
}

.product-name {
    font-weight: 600;
    color: #333;
    min-width: 200px;
}

.product-sku code {
    background: #f5f5f5;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 11px;
    color: #666;
}

.product-category {
    color: #0288d1;
    font-weight: 500;
}

.product-brand {
    color: #7b1fa2;
}

.product-price {
    text-align: center;
}

.price-badge {
    background: #d4edda;
    color: #155724;
    padding: 4px 10px;
    border-radius: 4px;
    font-weight: 600;
    display: inline-block;
}

.product-stock {
    text-align: center;
}

.stock-info {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
}

.stock-number {
    font-weight: 700;
    font-size: 16px;
    color: #333;
}

.stock-badge {
    padding: 2px 8px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 600;
}

.stock-badge.success {
    background: #d4edda;
    color: #155724;
}

.stock-badge.warning {
    background: #fff3cd;
    color: #856404;
}

.stock-badge.danger {
    background: #f8d7da;
    color: #721c24;
}

.product-status {
    text-align: center;
}

.status-badge {
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
    display: inline-block;
}

.status-badge.active {
    background: #d4edda;
    color: #155724;
}

.status-badge.draft {
    background: #fff3cd;
    color: #856404;
}

.status-badge.out_of_stock {
    background: #f8d7da;
    color: #721c24;
}

.product-actions {
    text-align: center;
}

.action-btn {
    padding: 6px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.2s;
    font-size: 12px;
    width: 32px;
    height: 32px;
}

.edit-btn {
    background: #0288d1;
    margin-right: 4px;
}

.edit-btn:hover {
    background: #0277bd;
}

.delete-btn {
    background: #e74c3c;
    margin: 0;
}

.delete-btn:hover {
    background: #c0392b;
}

.empty-state {
    padding: 60px 20px;
    text-align: center;
    color: #999;
}

.empty-state i {
    font-size: 48px;
    color: #ddd;
    display: block;
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
    padding: 20px;
    text-align: center;
    border-top: 1px solid #e0e0e0;
}

@media (max-width: 768px) {
    .inventory-header-section {
        flex-direction: column;
        gap: 16px;
    }

    .filter-form {
        flex-direction: column;
    }

    .filter-field {
        width: 100%;
    }

    .form-control {
        min-width: 100%;
    }

    .inventory-table {
        font-size: 12px;
    }

    .inventory-row td {
        padding: 10px;
    }

    .action-btn {
        width: 28px;
        height: 28px;
        font-size: 11px;
    }

    .product-name {
        min-width: 150px;
    }
}
</style>
@endsection
