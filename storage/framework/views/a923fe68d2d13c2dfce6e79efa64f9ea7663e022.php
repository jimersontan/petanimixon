<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Available Orders - Pet Markt-PH Rider</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/rider.css')); ?>">
</head>
<body class="rider-body">

    <?php if(session('success')): ?>
        <div class="rider-toast"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="rider-toast" style="background:#dc2626;"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <?php echo $__env->make('partials.rider_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="rider-layout">
        <aside class="rider-sidebar">
            <div class="nav-section-title">Navigation</div>
            <nav>
                <a href="<?php echo e(route('rider.dashboard')); ?>" class="nav-item" data-page="dashboard">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg></span>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo e(route('rider.available')); ?>" class="nav-item active" data-page="available">
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
                <a href="<?php echo e(route('rider.products')); ?>" class="nav-item" data-page="products">
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
                    <h1>Available Orders</h1>
                    <div class="subtitle">Orders ready for delivery pickup</div>
                </div>
            </div>

            <?php if($hasCurrentAssignment): ?>
            <div class="rider-card" style="border-color:#fde68a; background:#fffbeb;">
                <div class="rider-card-body" style="padding:16px 22px; color:#92400e;">
                    <strong>Current assignment in progress.</strong> Finish your pickup or delivery first before accepting another order.
                    <a href="<?php echo e(route('rider.active')); ?>" style="margin-left:8px; font-weight:700; color:#166534; text-decoration:none;">Go to Current Assignment →</a>
                </div>
            </div>
            <?php endif; ?>

            <div class="rider-card">
                <div class="rider-card-header">
                    <h2>📦 Ready for Pickup (<?php echo e($orders->total()); ?>)</h2>
                </div>
                <div class="rider-card-body" style="padding: 12px 22px;">
                    <?php if($orders->count() > 0): ?>
                        <div class="order-queue">
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="order-queue-item">
                                <div class="order-queue-info">
                                    <div class="order-queue-id"><?php echo e($order->display_id); ?></div>
                                    <div class="order-queue-customer"><?php echo e(optional($order->user)->full_name ?? 'Customer'); ?></div>
                                    <div class="order-queue-meta">
                                        <span>📦 <?php echo e($order->orderItems->count()); ?> items</span>
                                        <span>📍 <?php echo e(optional($order->shippingAddress)->city_municipality ?? 'N/A'); ?></span>
                                        <span>🕐 <?php echo e($order->created_at->diffForHumans()); ?></span>
                                        <span>💳 <?php echo e(ucfirst($order->payment_method)); ?></span>
                                    </div>
                                </div>
                                <div class="order-queue-actions">
                                    <div class="order-queue-total"><?php echo e($order->formatted_total); ?></div>
                                    <?php if(!$hasCurrentAssignment): ?>
                                        <form action="<?php echo e(route('rider.accept', $order->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn-rider-primary btn-rider-sm" onclick="return confirm('Accept this order for delivery?')">🛵 Accept Order</button>
                                        </form>
                                    <?php else: ?>
                                        <button type="button" class="btn-rider-secondary btn-rider-sm" disabled title="Finish your current assignment first">Finish Current Assignment</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="rider-empty-state">
                            <div class="empty-icon">📭</div>
                            <h3>No Orders Available</h3>
                            <p>All current orders are either pending or already claimed. Check back soon!</p>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if($orders->hasPages()): ?>
                <div class="rider-pagination">
                    <?php echo e($orders->links()); ?>

                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>


<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\Pet Markt-PH\resources\views/rider/available_orders.blade.php ENDPATH**/ ?>