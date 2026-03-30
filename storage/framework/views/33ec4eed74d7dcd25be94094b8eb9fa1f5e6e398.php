<!-- Product Module Component - Admin Product Management Card -->
<div class="product-module-card">
    <div class="product-module-header">
        <div class="product-image-container">
            <?php if($product->animal_image_url): ?>
                <img src="<?php echo e(asset($product->animal_image_url)); ?>" alt="<?php echo e($product->product_name); ?>" class="product-image">
            <?php else: ?>
                <div class="product-image-placeholder">
                    <i class="fas fa-image"></i>
                </div>
            <?php endif; ?>
            <div class="product-status-badge">
                <?php if($product->product_status === 'active'): ?>
                    <span class="badge badge-active">Active</span>
                <?php elseif($product->product_status === 'draft'): ?>
                    <span class="badge badge-draft">Draft</span>
                <?php else: ?>
                    <span class="badge badge-out-of-stock">Out of Stock</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="product-module-content">
        <!-- Product Name & SKU -->
        <div class="product-header-info">
            <h3 class="product-title"><?php echo e($product->product_name); ?></h3>
            <p class="product-sku">SKU: <span><?php echo e($product->sku); ?></span></p>
        </div>

        <!-- Category & Brand Info -->
        <div class="product-meta-info">
            <?php if($product->category): ?>
                <span class="product-category"><?php echo e($product->category->category_name ?? 'N/A'); ?></span>
            <?php endif; ?>
            <?php if($product->brand_name): ?>
                <span class="product-brand"><?php echo e($product->brand_name); ?></span>
            <?php endif; ?>
        </div>

        <!-- Price Section -->
        <div class="product-price-section">
            <div class="price-label">Price</div>
            <div class="price-value">₱<?php echo e(number_format($product->price, 2)); ?></div>
        </div>

        <!-- Stock Section -->
        <div class="product-stock-section">
            <div class="stock-label">Stock</div>
            <div class="stock-value">
                <?php
                    $totalStock = $product->variants->sum('stock') ?? 0;
                ?>
                <span class="stock-number"><?php echo e($totalStock); ?></span>
                <?php if($totalStock == 0): ?>
                    <span class="stock-status low">Out of Stock</span>
                <?php elseif($totalStock <= 5): ?>
                    <span class="stock-status warning">Low Stock</span>
                <?php else: ?>
                    <span class="stock-status available">In Stock</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Animal Type -->
        <?php if($product->animal_type): ?>
            <div class="product-animal-type">
                <small>Type: <strong><?php echo e($product->animal_type); ?></strong></small>
            </div>
        <?php endif; ?>
    </div>

    <!-- Action Buttons -->
    <div class="product-module-actions">
        <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="btn-action btn-edit" title="Edit Product">
            <i class="fas fa-edit"></i>
            <span>Edit</span>
        </a>
        <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" class="delete-form" style="display: inline;">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn-action btn-remove" title="Remove Product" onclick="return confirm('Are you sure you want to remove this product?')">
                <i class="fas fa-trash"></i>
                <span>Remove</span>
            </button>
        </form>
    </div>
</div>

<style>
.product-module-card {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.product-module-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.product-module-header {
    position: relative;
    background: #f8f9fa;
}

.product-image-container {
    position: relative;
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: #f0f0f0;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    color: #ccc;
}

.product-status-badge {
    position: absolute;
    top: 8px;
    right: 8px;
}

.badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.badge-active {
    background: #d4edda;
    color: #155724;
}

.badge-draft {
    background: #fff3cd;
    color: #856404;
}

.badge-out-of-stock {
    background: #f8d7da;
    color: #721c24;
}

.product-module-content {
    padding: 16px;
}

.product-header-info {
    margin-bottom: 12px;
}

.product-title {
    margin: 0 0 4px 0;
    font-size: 16px;
    font-weight: 600;
    color: #333;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.product-sku {
    margin: 0;
    font-size: 12px;
    color: #999;
}

.product-sku span {
    font-weight: 600;
    color: #666;
}

.product-meta-info {
    display: flex;
    gap: 8px;
    margin-bottom: 12px;
    flex-wrap: wrap;
}

.product-category,
.product-brand {
    font-size: 12px;
    padding: 4px 8px;
    background: #e8f4f8;
    border-radius: 4px;
    color: #0288d1;
}

.product-brand {
    background: #f3e5f5;
    color: #7b1fa2;
}

.product-price-section {
    margin-bottom: 12px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f0f0f0;
}

.price-label {
    font-size: 12px;
    color: #999;
    margin-bottom: 4px;
}

.price-value {
    font-size: 20px;
    font-weight: 700;
    color: #2ecc71;
}

.product-stock-section {
    margin-bottom: 12px;
}

.stock-label {
    font-size: 12px;
    color: #999;
    margin-bottom: 4px;
}

.stock-value {
    display: flex;
    align-items: center;
    gap: 8px;
}

.stock-number {
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.stock-status {
    font-size: 11px;
    padding: 2px 8px;
    border-radius: 4px;
    font-weight: 600;
}

.stock-status.available {
    background: #d4edda;
    color: #155724;
}

.stock-status.low {
    background: #fff3cd;
    color: #856404;
}

.stock-status.warning {
    background: #fff3cd;
    color: #856404;
}

.product-animal-type {
    font-size: 12px;
    color: #666;
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px solid #f0f0f0;
}

.product-module-actions {
    display: flex;
    gap: 8px;
    padding: 12px;
    background: #f8f9fa;
    border-top: 1px solid #e0e0e0;
}

.btn-action {
    flex: 1;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: all 0.2s ease;
    text-decoration: none;
    color: white;
}

.btn-edit {
    background: #0288d1;
}

.btn-edit:hover {
    background: #0277bd;
}

.btn-remove {
    background: #e74c3c;
}

.btn-remove:hover {
    background: #c0392b;
}

.btn-action i {
    font-size: 14px;
}

@media (max-width: 768px) {
    .product-title {
        font-size: 14px;
    }

    .price-value {
        font-size: 18px;
    }

    .stock-number {
        font-size: 16px;
    }

    .btn-action span {
        display: none;
    }

    .btn-action {
        padding: 8px;
        justify-content: center;
    }
}
</style>
<?php /**PATH C:\xampp\htdocs\Petverse\petverse\resources\views/components/product-module.blade.php ENDPATH**/ ?>