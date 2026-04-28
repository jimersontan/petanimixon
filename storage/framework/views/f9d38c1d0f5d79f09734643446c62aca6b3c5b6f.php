<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Products - Pet Markt-PH Rider</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/rider.css')); ?>">
</head>
<body class="rider-body">

    <?php echo $__env->make('partials.rider_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="rider-layout">
        <aside class="rider-sidebar">
            <div class="nav-section-title">Navigation</div>
            <nav>
                <a href="<?php echo e(route('rider.dashboard')); ?>" class="nav-item" data-page="dashboard">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg></span>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo e(route('rider.available')); ?>" class="nav-item" data-page="available">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-3 10h-3v3h-2v-3H8v-2h3V8h2v3h3v2z"/></svg></span>
                    <span>Available Orders</span>
                </a>
                <a href="<?php echo e(route('rider.active')); ?>" class="nav-item" data-page="active">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg></span>
                    <span>Active Delivery</span>
                </a>
                <a href="<?php echo e(route('rider.history')); ?>" class="nav-item" data-page="history">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/></svg></span>
                    <span>History</span>
                </a>
                <a href="<?php echo e(route('rider.products')); ?>" class="nav-item active" data-page="products">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M5 8h2V6h10v2h2V6c0-1.1-.9-2-2-2H7V2H5v4c-1.1 0-2 .9-2 2v2zm-2 4v8c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-8H3z"/></svg></span>
                    <span>Products</span>
                </a>
            </nav>
            <div class="logout-link">
                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="nav-item" style="width:100%; border:none; background:none; cursor:pointer; text-align:left;">
                        <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg></span>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="rider-main">
            <div class="rider-page-header">
                <div>
                    <h1>Product Catalog</h1>
                    <div class="subtitle">Verify products you're delivering (read-only)</div>
                </div>
            </div>

            <!-- Search -->
            <div class="rider-filter-bar">
                <form method="get" action="<?php echo e(route('rider.products')); ?>" style="display:flex; gap:10px; align-items:center;">
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search products..." class="rider-search-input">
                    <button type="submit" class="btn-rider-primary btn-rider-sm">Search</button>
                </form>
            </div>

            <!-- Products Grid -->
            <div class="rider-products-grid">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="rider-product-card">
                    <?php if($product->image_url): ?>
                        <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->product_name); ?>" onerror="this.onerror=null; this.src='<?php echo e(asset('images/placeholder.png')); ?>'" style="width:100%; height:140px; object-fit:cover; border-radius:10px; margin-bottom:12px; background:#f1f5f9;">
                    <?php else: ?>
                        <div style="width:100%; height:140px; border-radius:10px; margin-bottom:12px; background: linear-gradient(135deg, #ecfdf5, #d1fae5); display:flex; align-items:center; justify-content:center; font-size:2.5rem;">
                            🐾
                        </div>
                    <?php endif; ?>
                    <div class="rider-product-name"><?php echo e($product->product_name); ?></div>
                    <div class="rider-product-category"><?php echo e(optional($product->category)->category_name ?? 'Uncategorized'); ?></div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="rider-product-price">₱<?php echo e(number_format((float)($product->price ?? 0), 0)); ?></div>
                        <div class="rider-product-stock">Stock: <?php echo e($product->stock ?? 0); ?></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div style="grid-column: 1/-1;">
                    <div class="rider-empty-state">
                        <div class="empty-icon">📦</div>
                        <h3>No Products Found</h3>
                        <p>Try a different search term.</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <?php if($products->hasPages()): ?>
            <div class="rider-pagination" style="margin-top: 20px;">
                <?php echo e($products->links()); ?>

            </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>


<?php /**PATH C:\xampp\htdocs\Pet Markt-PH\resources\views/rider/products.blade.php ENDPATH**/ ?>