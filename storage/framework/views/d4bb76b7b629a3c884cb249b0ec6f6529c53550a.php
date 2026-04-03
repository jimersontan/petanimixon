<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery History - Pet Animixon Rider</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/rider.css')); ?>">
</head>
<body class="rider-body">

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
                <a href="<?php echo e(route('rider.active')); ?>" class="nav-item" data-page="active">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg></span>
                    <span>Active Delivery</span>
                </a>
                <a href="<?php echo e(route('rider.history')); ?>" class="nav-item active" data-page="history">
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
                    <h1>Delivery History</h1>
                    <div class="subtitle">Your past deliveries and performance</div>
                </div>
            </div>

            <!-- Stats -->
            <div class="rider-stats-grid">
                <div class="rider-stat-card">
                    <div class="rider-stat-icon green">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <div>
                        <div class="rider-stat-value"><?php echo e($stats['total']); ?></div>
                        <div class="rider-stat-label">All-Time Deliveries</div>
                    </div>
                </div>
                <div class="rider-stat-card">
                    <div class="rider-stat-icon blue">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/></svg>
                    </div>
                    <div>
                        <div class="rider-stat-value"><?php echo e($stats['this_week']); ?></div>
                        <div class="rider-stat-label">This Week</div>
                    </div>
                </div>
                <div class="rider-stat-card">
                    <div class="rider-stat-icon orange">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/></svg>
                    </div>
                    <div>
                        <div class="rider-stat-value"><?php echo e($stats['this_month']); ?></div>
                        <div class="rider-stat-label">This Month</div>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <div class="rider-filter-bar">
                <form method="get" action="<?php echo e(route('rider.history')); ?>" style="display:flex; gap:10px; align-items:center;">
                    <select name="days" class="rider-filter-select" onchange="this.form.submit()">
                        <option value="7" <?php echo e($days == 7 ? 'selected' : ''); ?>>Last 7 days</option>
                        <option value="30" <?php echo e($days == 30 ? 'selected' : ''); ?>>Last 30 days</option>
                        <option value="90" <?php echo e($days == 90 ? 'selected' : ''); ?>>Last 90 days</option>
                        <option value="365" <?php echo e($days == 365 ? 'selected' : ''); ?>>Last Year</option>
                    </select>
                </form>
            </div>

            <!-- History List -->
            <div class="rider-card">
                <div class="rider-card-header">
                    <h2>📜 Delivery Records</h2>
                </div>

                <?php if($orders->count() > 0): ?>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="delivery-history-item">
                        <div class="delivery-history-icon <?php echo e($order->order_status === 'delivered' ? 'delivered' : 'cancelled'); ?>">
                            <?php echo e($order->order_status === 'delivered' ? '✅' : '❌'); ?>

                        </div>
                        <div class="delivery-history-info">
                            <div class="delivery-history-id"><?php echo e($order->display_id); ?></div>
                            <div class="delivery-history-customer">
                                <?php echo e(optional($order->user)->full_name ?? 'Customer'); ?>

                                · <?php echo e(optional($order->shippingAddress)->city_municipality ?? ''); ?>

                            </div>
                            <?php if($order->rider_notes): ?>
                                <div style="font-size: 0.78rem; color: var(--rider-text-muted); margin-top: 4px; font-style: italic;">
                                    📝 <?php echo e($order->rider_notes); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                        <div style="text-align: right;">
                            <div class="delivery-history-total"><?php echo e($order->formatted_total); ?></div>
                            <div class="delivery-history-date">
                                <?php echo e(optional($order->rider_delivered_at ? \Carbon\Carbon::parse($order->rider_delivered_at) : $order->updated_at)->format('M j, Y g:i A')); ?>

                            </div>
                            <span class="rider-badge-status rider-badge-<?php echo e($order->order_status); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $order->order_status))); ?></span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($orders->hasPages()): ?>
                    <div class="rider-pagination">
                        <?php echo e($orders->links()); ?>

                    </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="rider-card-body">
                        <div class="rider-empty-state">
                            <div class="empty-icon">📜</div>
                            <h3>No Delivery Records</h3>
                            <p>Your completed deliveries will appear here.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/rider/history.blade.php ENDPATH**/ ?>