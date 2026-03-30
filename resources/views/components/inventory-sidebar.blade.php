<!-- Sidebar Inventory Module Component -->
<div class="inventory-module-sidebar">
    <div class="inventory-header">
        <h3 class="inventory-title">
            <i class="fas fa-boxes"></i> Inventory Manager
        </h3>
        <button class="btn-refresh" onclick="location.reload()" title="Refresh">
            <i class="fas fa-sync"></i>
        </button>
    </div>

    <!-- Inventory Stats -->
    <div class="inventory-stats">
        <div class="stat-item">
            <span class="stat-label">Total</span>
            <span class="stat-value">{{ $totalProducts ?? 0 }}</span>
        </div>
        <div class="stat-item">
            <span class="stat-label">Active</span>
            <span class="stat-value active">{{ $activeProducts ?? 0 }}</span>
        </div>
        <div class="stat-item">
            <span class="stat-label">Low Stock</span>
            <span class="stat-value warning">{{ $lowStockItems ?? 0 }}</span>
        </div>
    </div>

    <!-- Search/Filter -->
    <div class="inventory-search">
        <input type="text" 
               id="inventorySearch" 
               class="search-input" 
               placeholder="Search products..."
               onkeyup="filterInventoryProducts()">
    </div>

    <!-- Inventory List -->
    <div class="inventory-list">
        @forelse($products as $product)
            <div class="inventory-item" data-product-name="{{ strtolower($product->product_name) }}">
                <div class="item-header">
                    <div class="item-name">
                        <small>{{ Str::limit($product->product_name, 18) }}</small>
                    </div>
                    <div class="item-status">
                        @php
                            $totalStock = $product->variants->sum('stock') ?? 0;
                        @endphp
                        @if($totalStock > 0)
                            <span class="badge-small status-active">In</span>
                        @else
                            <span class="badge-small status-danger">Out</span>
                        @endif
                    </div>
                </div>

                <div class="item-details">
                    <div class="detail-row">
                        <span class="detail-label">Price:</span>
                        <span class="detail-value price">₱{{ number_format((float)$product->price, 2) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Stock:</span>
                        <span class="detail-value stock">{{ $totalStock }}</span>
                    </div>
                </div>

                <div class="item-actions">
                    <a href="{{ route('products.edit', $product->id) }}" 
                       class="action-btn edit-btn" 
                       title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('products.destroy', $product->id) }}" 
                          method="POST" 
                          class="action-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="action-btn delete-btn" 
                                title="Remove"
                                onclick="return confirm('Remove this product?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-inventory">
                <i class="fas fa-inbox"></i>
                <p>No products</p>
            </div>
        @endforelse
    </div>

    <!-- View All Link -->
    <div class="inventory-footer">
        <a href="{{ route('products.admin') }}" class="btn-view-all">
            View All Products <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>

<style>
.inventory-module-sidebar {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    max-height: 600px;
}

.inventory-header {
    padding: 12px 14px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.inventory-title {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-refresh {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    padding: 6px 8px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 12px;
}

.btn-refresh:hover {
    background: rgba(255, 255, 255, 0.3);
}

.inventory-stats {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 8px;
    padding: 10px;
    background: #f8f9fa;
    border-bottom: 1px solid #e0e0e0;
}

.stat-item {
    text-align: center;
    padding: 6px;
}

.stat-label {
    display: block;
    font-size: 11px;
    color: #999;
    margin-bottom: 2px;
}

.stat-value {
    display: block;
    font-size: 16px;
    font-weight: 700;
    color: #333;
}

.stat-value.active {
    color: #4CAF50;
}

.stat-value.warning {
    color: #ff9800;
}

.inventory-search {
    padding: 10px;
    border-bottom: 1px solid #e0e0e0;
}

.search-input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 12px;
    box-sizing: border-box;
}

.search-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.inventory-list {
    flex: 1;
    overflow-y: auto;
    padding: 0;
}

.inventory-item {
    padding: 10px;
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.2s ease;
}

.inventory-item:hover {
    background: #f8f9fa;
}

.item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
}

.item-name {
    flex: 1;
}

.item-name small {
    font-weight: 600;
    color: #333;
    font-size: 12px;
}

.badge-small {
    display: inline-block;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 10px;
    font-weight: 600;
}

.status-active {
    background: #d4edda;
    color: #155724;
}

.status-danger {
    background: #f8d7da;
    color: #721c24;
}

.item-details {
    margin-bottom: 6px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 11px;
    margin-bottom: 3px;
}

.detail-label {
    color: #999;
    font-weight: 500;
}

.detail-value {
    color: #333;
    font-weight: 600;
}

.detail-value.price {
    color: #4CAF50;
    font-size: 12px;
}

.detail-value.stock {
    color: #666;
}

.item-actions {
    display: flex;
    gap: 6px;
}

.action-btn {
    flex: 1;
    padding: 5px;
    border: none;
    border-radius: 3px;
    font-size: 11px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
}

.edit-btn {
    background: #0288d1;
}

.edit-btn:hover {
    background: #0277bd;
}

.action-form {
    flex: 1;
    margin: 0;
    padding: 0;
}

.delete-btn {
    background: #e74c3c;
    width: 100%;
}

.delete-btn:hover {
    background: #c0392b;
}

.empty-inventory {
    padding: 20px;
    text-align: center;
    color: #999;
}

.empty-inventory i {
    font-size: 32px;
    color: #ddd;
    display: block;
    margin-bottom: 8px;
}

.empty-inventory p {
    margin: 0;
    font-size: 12px;
}

.inventory-footer {
    padding: 10px;
    border-top: 1px solid #e0e0e0;
    background: #f8f9fa;
}

.btn-view-all {
    display: block;
    width: 100%;
    padding: 8px;
    background: #667eea;
    color: white;
    text-align: center;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}

.btn-view-all:hover {
    background: #5568d3;
    text-decoration: none;
}

.btn-view-all i {
    margin-left: 4px;
}

/* Search filter - hide non-matching items */
.inventory-item.hidden {
    display: none;
}

/* Scrollbar styling */
.inventory-list::-webkit-scrollbar {
    width: 6px;
}

.inventory-list::-webkit-scrollbar-track {
    background: #f0f0f0;
}

.inventory-list::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 3px;
}

.inventory-list::-webkit-scrollbar-thumb:hover {
    background: #999;
}

@media (max-width: 768px) {
    .inventory-module-sidebar {
        max-height: 400px;
    }

    .item-actions {
        gap: 4px;
    }

    .action-btn {
        padding: 4px;
        font-size: 10px;
    }
}
</style>

<script>
function filterInventoryProducts() {
    const searchInput = document.getElementById('inventorySearch').value.toLowerCase();
    const items = document.querySelectorAll('.inventory-item');
    
    items.forEach(item => {
        const productName = item.getAttribute('data-product-name');
        if (productName.includes(searchInput)) {
            item.classList.remove('hidden');
        } else {
            item.classList.add('hidden');
        }
    });
}
</script>
