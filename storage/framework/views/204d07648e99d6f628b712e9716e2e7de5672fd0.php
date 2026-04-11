<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - PetMarkt-PH Admin</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/orders.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/animations.css')); ?>">
</head>
<body class="dashboard-body">
    <!-- Header -->
    <header class="dashboard-header">
        <div class="header-left">
            <div class="logo" style="display:flex; align-items:center; gap:8px;">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" style="max-height: 28px;">
                <span class="logo-text" style="color:#1f2937;">Pet <span style="color: #ea580c;">Markt-PH</span></span>
            </div>
        </div>
        <div class="header-center">
            <div class="search-bar">
                <svg class="search-icon" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                <input type="text" class="search-input" placeholder="Search orders, products, customers...">
            </div>
        </div>
        <div class="header-right">
            <button type="button" class="icon-btn" aria-label="Notifications">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
            </button>
            <button type="button" class="icon-btn" aria-label="Profile">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </button>
            <button type="button" class="icon-btn" aria-label="Settings">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M11.4 24H0V12.6h2.4v9.4h9v2.4zm12-12H12.6V0H24v2.4h-9.6v9.6H24V12zM2.4 9.6V0h2.4v9.6H2.4zm19.2 0V0H24v9.6h-2.4zM9.6 2.4V0h4.8v2.4H9.6zm4.8 19.2v-2.4h4.8V24h-4.8z"/></svg>
            </button>
        </div>
    </header>

    <div class="dashboard-layout">
        <!-- Sidebar -->
        <?php echo $__env->make('partials.admin_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <main class="main-content">
            <div class="content-header">
                <h1 class="page-title">Analytics</h1>
                <div class="date-filter">
                    <form method="get" action="<?php echo e(route('analytics.admin')); ?>" class="date-filter-form" id="analyticsDateForm">
                        <select name="days" id="analyticsDateRange" class="filter-select" aria-label="Date range">
                            <option value="7" <?php echo e(($days ?? 30) == 7 ? 'selected' : ''); ?>>Last 7 days</option>
                            <option value="30" <?php echo e(($days ?? 30) == 30 ? 'selected' : ''); ?>>Last 30 days</option>
                            <option value="90" <?php echo e(($days ?? 30) == 90 ? 'selected' : ''); ?>>Last 90 days</option>
                        </select>
                    </form>
                    <button type="button" class="btn-primary">Export Report</button>
                </div>
            </div>

            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-icon metric-icon-revenue">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">₱<?php echo e(number_format($stats['revenue'] ?? 0)); ?></div>
                        <div class="metric-label">Revenue</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-orders">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M20 2H4c-1 0-2 .9-2 2v3.01c0 .72.43 1.34 1 1.69V20c0 1.1 1.1 2 2 2h14c.9 0 2-.9 2-2V8.7c.57-.35 1-.97 1-1.69V4c0-1.1-1-2-2-2zm-5 12H9v-2h6v2zm5-7H4V4h16v3z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value"><?php echo e(number_format($stats['orders'] ?? 0)); ?></div>
                        <div class="metric-label">Orders</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-avg">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value"><?php echo e(number_format($stats['conversion_rate'] ?? 0, 1)); ?>%</div>
                        <div class="metric-label">Conversion Rate</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-avg">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">₱<?php echo e(number_format($stats['avg_order_value'] ?? 0)); ?></div>
                        <div class="metric-label">Avg Order Value</div>
                    </div>
                </div>
            </div>

            <!-- Placeholder analytics sections -->
            <div class="dashboard-grid-two">
                <div class="card revenue-card">
                    <h2 class="card-title">Revenue &amp; Sales</h2>
                    <div class="chart-container">
                        <div class="empty-chart">Connect analytics data to show charts here.</div>
                    </div>
                </div>
                <div class="card top-products-card">
                    <h2 class="card-title">Sales by Category</h2>
                    <div class="empty-chart">No category analytics yet.</div>
                </div>
            </div>

            <div class="dashboard-grid-two">
                <div class="card top-products-card">
                    <h2 class="card-title">Top Selling Products</h2>
                    <div class="empty-chart">No product analytics yet.</div>
                </div>
                <div class="card top-products-card">
                    <h2 class="card-title">Customer Demographics</h2>
                    <div class="empty-chart">No demographic data yet.</div>
                </div>
            </div>
        </main>
    </div>

    <script src="<?php echo e(asset('js/dashboard.js')); ?>"></script>
    <script src="<?php echo e(asset('js/animations.js')); ?>"></script>
</body>
</html>



<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/analytics_admin.blade.php ENDPATH**/ ?>