<!-- ===== ORDERS PAGE ===== -->
<!-- Standalone page (does not extend admin layout, has its own header/sidebar) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - PetMarkt-PH Admin</title>
    <!-- Core Stylesheets -->
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/orders.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/animations.css')); ?>">
</head>
<body class="dashboard-body">

    <!-- ===== HEADER SECTION ===== -->
    <!-- Top navigation bar with logo, search, and user actions -->
    <header class="dashboard-header">

        <!-- Logo and Brand Name -->
        <div class="header-left">
            <div class="logo" style="display:flex; align-items:center; gap:8px;">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" style="max-height: 28px;">
                <span class="logo-text" style="color:#1f2937;">Pet <span style="color: #ea580c;">Markt-PH</span></span>
            </div>
        </div>
        <!-- End: Logo -->

        <!-- Search Bar -->
        <div class="header-center">
            <div class="search-bar">
                <svg class="search-icon" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                <input type="text" class="search-input" placeholder="Search orders, products, customers...">
            </div>
        </div>
        <!-- End: Search Bar -->

        <!-- User Actions: Notifications, Profile, Settings -->
        <div class="header-right">
            <!-- Notifications Bell -->
            <button type="button" class="icon-btn" aria-label="Notifications">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
            </button>
            <!-- Profile Icon -->
            <button type="button" class="icon-btn" aria-label="Profile">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </button>
            <!-- Settings Gear -->
            <button type="button" class="icon-btn" aria-label="Settings">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M11.4 24H0V12.6h2.4v9.4h9v2.4zm12-12H12.6V0H24v2.4h-9.6v9.6H24V12zM2.4 9.6V0h2.4v9.6H2.4zm19.2 0V0H24v9.6h-2.4zM9.6 2.4V0h4.8v2.4H9.6zm4.8 19.2v-2.4h4.8V24h-4.8z"/></svg>
            </button>
        </div>
        <!-- End: User Actions -->

    </header>
    <!-- ===== END HEADER SECTION ===== -->

    <!-- ===== DASHBOARD LAYOUT: Sidebar + Main Content ===== -->
    <div class="dashboard-layout">

        <!-- ===== SIDEBAR NAVIGATION ===== -->
        <!-- Left-side navigation menu -->
        <?php echo $__env->make('partials.admin_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- ===== END SIDEBAR NAVIGATION ===== -->

        <!-- ===== MAIN CONTENT AREA ===== -->
        <main class="main-content">

            <!-- ===== PAGE HEADER: Title and Date Filter ===== -->
            <div class="content-header">
                <h1 class="page-title">Orders</h1>
                <div class="date-filter">
                    <!-- Date Range Filter Form: Filters orders by time period -->
                    <form method="get" action="<?php echo e(route('admin.orders')); ?>" class="date-filter-form" id="ordersDateForm">
                        <select name="days" id="ordersDateRange" class="filter-select" aria-label="Date range">
                            <option value="7" <?php echo e(($days ?? 30) == 7 ? 'selected' : ''); ?>>Last 7 days</option>
                            <option value="30" <?php echo e(($days ?? 30) == 30 ? 'selected' : ''); ?>>Last 30 days</option>
                            <option value="90" <?php echo e(($days ?? 30) == 90 ? 'selected' : ''); ?>>Last 90 days</option>
                        </select>
                    </form>
                    <!-- End: Date Range Filter -->
                </div>
            </div>
            <!-- ===== END PAGE HEADER ===== -->

            <!-- ===== METRICS CARDS SECTION ===== -->
            <!-- Four summary cards: Total Orders, Pending, Completed, Cancelled -->
            <div class="metrics-grid">

                <!-- Metric Card: Total Orders -->
                <div class="metric-card">
                    <div class="metric-icon metric-icon-orders-orange">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value" id="ordersTotal"><?php echo e(number_format($stats['total'] ?? 0)); ?></div>
                        <div class="metric-label">Total Orders</div>
                    </div>
                </div>
                <!-- End: Total Orders Card -->

                <!-- Metric Card: Pending Orders -->
                <div class="metric-card">
                    <div class="metric-icon metric-icon-pending">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value" id="ordersPending"><?php echo e(number_format($stats['pending'] ?? 0)); ?></div>
                        <div class="metric-label">Pending</div>
                    </div>
                </div>
                <!-- End: Pending Orders Card -->

                <!-- Metric Card: Completed Orders -->
                <div class="metric-card">
                    <div class="metric-icon metric-icon-completed">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value" id="ordersCompleted"><?php echo e(number_format($stats['completed'] ?? 0)); ?></div>
                        <div class="metric-label">Completed</div>
                    </div>
                </div>
                <!-- End: Completed Orders Card -->

                <!-- Metric Card: Cancelled Orders -->
                <div class="metric-card">
                    <div class="metric-icon metric-icon-cancelled">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value" id="ordersCancelled"><?php echo e(number_format($stats['cancelled'] ?? 0)); ?></div>
                        <div class="metric-label">Cancelled</div>
                    </div>
                </div>
                <!-- End: Cancelled Orders Card -->

            </div>
            <!-- ===== END METRICS CARDS SECTION ===== -->

            <!-- ===== ORDERS TABLE SECTION ===== -->
            <!-- Main table listing all orders with filtering and actions -->
            <div class="card orders-table-card">

                <!-- Table Header: Title, Export and Filter Buttons -->
                <div class="orders-section-header">
                    <h2 class="card-title">All Orders</h2>
                    <div class="orders-actions">
                        <!-- Export Button -->
                        <button type="button" class="btn-secondary btn-export" id="btnExport">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                            Export
                        </button>
                        <!-- Filter Button -->
                        <button type="button" class="btn-secondary btn-filter" id="btnFilter">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/></svg>
                            Filter
                        </button>
                    </div>
                </div>
                <!-- End: Table Header -->

                <!-- Status Filter Tabs: All, Pending, Processing, Shipped, Delivered, Cancelled -->
                <div class="order-status-tabs" role="tablist">
                    <button type="button" class="order-tab active" data-status="all" role="tab" aria-selected="true">All</button>
                    <button type="button" class="order-tab" data-status="pending" role="tab">Pending</button>
                    <button type="button" class="order-tab" data-status="processing" role="tab">Processing</button>
                    <button type="button" class="order-tab" data-status="shipped" role="tab">Shipped</button>
                    <button type="button" class="order-tab" data-status="delivered" role="tab">Delivered</button>
                    <button type="button" class="order-tab" data-status="cancelled" role="tab">Cancelled</button>
                </div>
                <!-- End: Status Filter Tabs -->

                <!-- Orders Data Table -->
                <div class="table-wrap">
                    <table class="orders-table" id="ordersTable">
                        <!-- Table Header Columns -->
                        <thead>
                            <tr>
                                <th class="col-checkbox">
                                    <input type="checkbox" class="select-all" id="selectAllOrders" aria-label="Select all orders">
                                </th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th class="col-actions">Actions</th>
                            </tr>
                        </thead>
                        <!-- End: Table Header -->

                        <!-- Table Body: Order Rows -->
                        <tbody>
                            <!-- Badge CSS class mappings for payment and order statuses -->
                            <?php
                                $paymentBadge = [
                                    'paid' => 'badge-paid',
                                    'pending' => 'badge-pending',
                                    'failed' => 'badge-failed',
                                ];
                                $statusBadge = [
                                    'pending' => 'badge-pending',
                                    'processing' => 'badge-processing',
                                    'shipped' => 'badge-shipped',
                                    'delivered' => 'badge-delivered',
                                    'cancelled' => 'badge-cancelled',
                                ];
                                $paymentLabel = ['paid' => 'Paid', 'pending' => 'Pending', 'failed' => 'Failed'];
                                $statusLabel = [
                                    'pending' => 'Pending',
                                    'processing' => 'Processing',
                                    'shipped' => 'Shipped',
                                    'delivered' => 'Delivered',
                                    'cancelled' => 'Cancelled',
                                ];
                            ?>

                            <!-- Loop: Render each order row -->
                            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr data-status="<?php echo e($order->order_status); ?>">
                                <!-- Checkbox Column -->
                                <td class="col-checkbox"><input type="checkbox" class="order-checkbox" value="<?php echo e($order->id); ?>"></td>
                                <!-- Order ID -->
                                <td><span class="order-id"><?php echo e($order->display_id); ?></span></td>
                                <!-- Customer Name and Email -->
                                <td>
                                    <div class="customer-cell"><?php echo e(optional($order->user)->full_name ?? '—'); ?></div>
                                    <div class="customer-email"><?php echo e(optional($order->user)->email ?? '—'); ?></div>
                                </td>
                                <!-- First Product in Order -->
                                <td>
                                    <div class="product-cell">
                                        <?php
                                            $firstItem = $order->orderItems && $order->orderItems->isNotEmpty() ? $order->orderItems->first() : null;
                                            $firstProduct = $firstItem ? $firstItem->product : null;
                                            $imageUrl = $firstProduct ? $firstProduct->image_url : null;
                                        ?>
                                        <span class="product-thumb-sm">
                                            <?php if($imageUrl): ?>
                                                <img src="<?php echo e($imageUrl); ?>" alt="" style="width: 100%; height: 100%; object-fit: cover; border-radius: inherit;">
                                            <?php endif; ?>
                                        </span>
                                        <span class="product-meta">
                                            <?php echo e($firstItem ? ($firstItem->summary ?? '—') : '—'); ?>

                                        </span>
                                    </div>
                                </td>
                                <!-- Order Date and Time -->
                                <td>
                                    <div class="date-cell"><?php echo e(optional($order->created_at)->format('M j, Y') ?? '—'); ?></div>
                                    <div class="time-cell"><?php echo e(optional($order->created_at)->format('g:i A') ?? '—'); ?></div>
                                </td>
                                <!-- Order Total -->
                                <td class="total-cell"><?php echo e($order->formatted_total ?? '—'); ?></td>
                                <!-- Payment Status Badge -->
                                <td><span class="badge <?php echo e($paymentBadge[$order->payment_status] ?? 'badge-pending'); ?>"><?php echo e($paymentLabel[$order->payment_status] ?? ucfirst($order->payment_status)); ?></span></td>
                                <!-- Order Status Badge -->
                                <td><span class="badge <?php echo e($statusBadge[$order->order_status] ?? 'badge-pending'); ?>"><?php echo e($statusLabel[$order->order_status] ?? ucfirst($order->order_status)); ?></span></td>
                                <!-- Action Buttons: View and Edit -->
                                <td class="col-actions">
                                    <!-- View Button -->
                                    <a href="#" class="action-btn" title="View" aria-label="View order"><svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg></a>
                                    <!-- Edit Button -->
                                    <a href="#" class="action-btn" title="Edit" aria-label="Edit order"><svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg></a>
                                </td>
                                <!-- End: Action Buttons -->
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <!-- Empty State: Shown when no orders exist for the period -->
                            <tr>
                                <td colspan="9" class="text-center empty-orders">No orders found for the selected period.</td>
                            </tr>
                            <?php endif; ?>
                            <!-- End: Order Rows Loop -->
                        </tbody>
                        <!-- End: Table Body -->
                    </table>
                </div>
                <!-- End: Orders Data Table -->

                <!-- Pagination: Only shown if orders span multiple pages -->
                <?php if(isset($orders) && $orders->hasPages()): ?>
                <div class="orders-pagination">
                    <?php echo e($orders->withQueryString()->links()); ?>

                </div>
                <?php endif; ?>
                <!-- End: Pagination -->

            </div>
            <!-- ===== END ORDERS TABLE SECTION ===== -->

        </main>
        <!-- ===== END MAIN CONTENT AREA ===== -->

    </div>
    <!-- ===== END DASHBOARD LAYOUT ===== -->

    <!-- ===== SCRIPTS SECTION ===== -->
    <!-- Orders JS: Table filtering, export, and interaction scripts -->
    <script src="<?php echo e(asset('js/orders.js')); ?>"></script>
    <script src="<?php echo e(asset('js/animations.js')); ?>"></script>
    <!-- ===== END SCRIPTS SECTION ===== -->

</body>
</html>
<!-- ===== END ORDERS PAGE ===== -->


<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/orders.blade.php ENDPATH**/ ?>