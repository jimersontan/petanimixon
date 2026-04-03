<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Delivery - Pet Animixon Rider</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/rider.css')); ?>">
</head>
<body class="rider-body">

    <?php if(session('success')): ?>
        <div class="rider-toast"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <header class="rider-header">
        <div class="logo">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo">
            <span>Pet <span style="color: #059669;">Animixon</span></span>
            <span class="rider-badge">🛵 Rider</span>
        </div>
        <div class="header-right">
            <span class="rider-name"><?php echo e(Auth::user()->full_name); ?></span>
            <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="icon-btn" aria-label="Logout" title="Logout">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                </button>
            </form>
        </div>
    </header>

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
                <a href="<?php echo e(route('rider.active')); ?>" class="nav-item active" data-page="active">
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
                    <h1>Active Deliveries</h1>
                    <div class="subtitle">Your current delivery assignments</div>
                </div>
            </div>

            <?php if($activeOrders->count() > 0): ?>
                <?php $__currentLoopData = $activeOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="active-order-detail">
                    <div class="order-header">
                        <h3>🚀 <?php echo e($order->display_id); ?> — <?php echo e($order->rider_picked_up_at ? 'In Transit' : 'Awaiting Pickup'); ?></h3>
                        <span class="rider-badge-status rider-badge-out_for_delivery">Out for Delivery</span>
                    </div>
                    <div class="order-body">
                        <!-- Customer Info -->
                        <div class="customer-info">
                            <div class="info-item">
                                <div class="info-label">Customer Name</div>
                                <div class="info-value"><?php echo e(optional($order->user)->full_name ?? 'N/A'); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Phone</div>
                                <div class="info-value"><?php echo e(optional($order->user)->phone_number ?? 'N/A'); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Delivery Address</div>
                                <div class="info-value">
                                    <?php if($order->shippingAddress): ?>
                                        <?php echo e($order->shippingAddress->street_address ?? ''); ?>,
                                        <?php echo e($order->shippingAddress->barangay ?? ''); ?>

                                        <?php echo e($order->shippingAddress->city_municipality ?? ''); ?>,
                                        <?php echo e($order->shippingAddress->province ?? ''); ?>

                                        <?php echo e($order->shippingAddress->zip_code ?? ''); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Payment Method</div>
                                <div class="info-value"><?php echo e(strtoupper($order->payment_method)); ?></div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="info-label" style="margin-bottom: 8px;">Order Items</div>
                        <ul class="items-list">
                            <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <span><?php echo e(optional($item->product)->product_name ?? 'Product'); ?> × <?php echo e($item->quantity); ?></span>
                                <span>₱<?php echo e(number_format((float)$item->total_amount, 0)); ?></span>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <li style="font-weight: 700;">
                                <span>Total</span>
                                <span><?php echo e($order->formatted_total); ?></span>
                            </li>
                        </ul>

                        <?php if($order->customer_notes): ?>
                        <div style="margin-bottom: 16px; padding: 12px 16px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; font-size: 0.85rem;">
                            <strong>Customer Notes:</strong> <?php echo e($order->customer_notes); ?>

                        </div>
                        <?php endif; ?>

                        <!-- Actions -->
                        <div class="order-actions">
                            <?php if(!$order->rider_picked_up_at): ?>
                                <form action="<?php echo e(route('rider.pickup', $order->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn-rider-warning" onclick="return confirm('Confirm: Order picked up from store?')">📦 Mark as Picked Up</button>
                                </form>
                            <?php else: ?>
                                <form action="<?php echo e(route('rider.deliver', $order->id)); ?>" method="POST" style="display: flex; flex-direction: column; width: 100%;">
                                    <?php echo csrf_field(); ?>
                                    <textarea name="rider_notes" class="delivery-notes-input" placeholder="Delivery notes (optional): e.g., Left with guard, delivered to door..." style="width: 100%; box-sizing: border-box; margin-bottom: 15px;"></textarea>
                                    <button type="submit" class="btn-rider-success" style="width: 100%; text-align: center; justify-content: center; padding: 14px 20px; font-size: 16px;">✅ Mark as Delivered</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="rider-card">
                    <div class="rider-card-body">
                        <div class="rider-empty-state">
                            <div class="empty-icon">🛵</div>
                            <h3>No Active Deliveries</h3>
                            <p>Accept an order from the Available Orders page to start delivering.</p>
                            <a href="<?php echo e(route('rider.available')); ?>" class="btn-rider-primary" style="margin-top: 16px;">View Available Orders →</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/rider/active_delivery.blade.php ENDPATH**/ ?>