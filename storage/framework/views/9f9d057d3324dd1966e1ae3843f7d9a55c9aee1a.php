<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PetMarkt-PH Admin</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/animations.css')); ?>">
</head>
<body class="dashboard-body">
    <?php echo $__env->make('partials.admin_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="dashboard-layout">
        <!-- Sidebar -->
        <?php echo $__env->make('partials.admin_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Main content -->
        <main class="main-content">
            <div class="content-header">
                <h1 class="page-title">Dashboard</h1>
                <div class="date-filter">
                    <select id="dateRange" class="filter-select" aria-label="Date range">
                        <option value="30">Last 30 days</option>
                        <option value="7">Last 7 days</option>
                        <option value="90">Last 90 days</option>
                    </select>
                </div>
            </div>

            <!-- Metric cards -->
            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-icon metric-icon-revenue">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value" id="totalRevenue">₱<?php echo e(number_format($totalRevenue, 0)); ?></div>
                        <div class="metric-label">Total Revenue</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-orders">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M20 2H4c-1 0-2 .9-2 2v3.01c0 .72.43 1.34 1 1.69V20c0 1.1 1.1 2 2 2h14c.9 0 2-.9 2-2V8.7c.57-.35 1-.97 1-1.69V4c0-1.1-1-2-2-2zm-5 12H9v-2h6v2zm5-7H4V4h16v3z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value" id="totalOrders"><?php echo e($totalOrders); ?></div>
                        <div class="metric-label">Total Orders</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-customers">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value" id="newCustomers"><?php echo e($newCustomers); ?></div>
                        <div class="metric-label">New Customers</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-avg">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value" id="avgOrderValue">₱<?php echo e(number_format($avgOrderValue, 0)); ?></div>
                        <div class="metric-label">Avg Order Value</div>
                    </div>
                </div>
            </div>

            <!-- Two-column: Revenue chart + Top products -->
            <div class="dashboard-grid-two">
                <div class="card revenue-card">
                    <h2 class="card-title">Revenue Overview</h2>
                    <div class="chart-tabs" role="tablist">
                        <button type="button" class="chart-tab active" data-tab="monthly" role="tab" aria-selected="true">Monthly</button>
                        <button type="button" class="chart-tab" data-tab="weekly" role="tab" aria-selected="false">Weekly</button>
                        <button type="button" class="chart-tab" data-tab="daily" role="tab" aria-selected="false">Daily</button>
                    </div>
                    <div class="chart-container">
                        <canvas id="revenueChart" width="400" height="200" aria-label="Revenue line chart"></canvas>
                    </div>
                </div>
                <div class="card top-products-card">
                    <div class="card-title-row">
                        <h2 class="card-title">Top Products</h2>
                        <a href="#" class="card-link">View All</a>
                    </div>
                    <ul class="top-products-list" id="topProductsList">
                        <?php $__empty_1 = true; $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li class="top-product-item">
                            <div class="product-info">
                                <span class="product-name"><?php echo e($tp->product_name); ?></span>
                            </div>
                            <span class="product-sold"><?php echo e($tp->total_sold); ?> sold</span>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="top-product-item empty-state">
                            <div class="product-info">
                                <span class="product-name">No products yet</span>
                                <span class="product-category">Add products to see them here</span>
                            </div>
                            <span class="product-sold">0 sold</span>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <!-- Two-column: Recent orders + Low stock -->
            <div class="dashboard-grid-two">
                <div class="card orders-card">
                    <div class="card-title-row">
                        <h2 class="card-title">Recent Orders</h2>
                        <a href="#" class="btn-primary disabled" aria-disabled="true">View All Orders</a>
                    </div>
                    <div class="table-wrap">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="recentOrdersBody">
                                <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($order->display_id); ?></td>
                                    <td><?php echo e($order->user->first_name ?? 'Guest'); ?> <?php echo e($order->user->last_name ?? ''); ?></td>
                                    <td>₱<?php echo e(number_format($order->total_amount, 0)); ?></td>
                                    <td><span class="status-badge status-<?php echo e($order->order_status); ?>"><?php echo e(ucfirst($order->order_status)); ?></span></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" style="text-align:center;">No orders yet</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card low-stock-card">
                    <h2 class="card-title"><span class="warning-icon" aria-hidden="true">⚠</span> Low Stock Alerts</h2>
                    <ul class="low-stock-list" id="lowStockList">
                        <?php $__empty_1 = true; $__currentLoopData = $lowStock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ls): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li class="low-stock-item">
                            <div class="stock-info">
                                <span class="stock-name"><?php echo e($ls->product_name); ?></span>
                                <span class="stock-qty">Only <?php echo e($ls->stock); ?> left in stock</span>
                            </div>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="low-stock-item">
                            <div class="stock-info">
                                <span class="stock-name">No low stock items</span>
                                <span class="stock-qty">All stock levels are healthy</span>
                            </div>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <!-- Recent customer activity (full width) -->
            <div class="card activity-card">
                <h2 class="card-title">Recent Customer Activity</h2>
                <ul class="activity-list" id="activityList">
                    <li class="activity-item">
                        <div class="activity-content">
                            <span class="activity-text">No activity yet</span>
                            <span class="activity-time">Start receiving orders to see activity here</span>
                        </div>
                    </li>
                </ul>
            </div>
        </main>
    </div>

    <script src="<?php echo e(asset('js/dashboard.js')); ?>"></script>
    <script src="<?php echo e(asset('js/animations.js')); ?>"></script>
</body>
</html>



<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/dashboard_admin.blade.php ENDPATH**/ ?>