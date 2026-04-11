<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - PetMarkt-PH Admin</title>
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
                <input type="text" class="search-input" placeholder="Search reviews, products, customers...">
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

        <!-- Main content -->
        <main class="main-content">
            <div class="content-header">
                <h1 class="page-title">Reviews</h1>
                <div class="date-filter">
                    <form method="get" action="<?php echo e(route('reviews.admin')); ?>" class="date-filter-form" id="reviewsDateForm">
                        <select name="days" id="reviewsDateRange" class="filter-select" aria-label="Date range">
                            <option value="7" <?php echo e(($days ?? 30) == 7 ? 'selected' : ''); ?>>Last 7 days</option>
                            <option value="30" <?php echo e(($days ?? 30) == 30 ? 'selected' : ''); ?>>Last 30 days</option>
                            <option value="90" <?php echo e(($days ?? 30) == 90 ? 'selected' : ''); ?>>Last 90 days</option>
                        </select>
                    </form>
                    <button type="button" class="btn-primary">Export Reviews</button>
                </div>
            </div>

            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-icon metric-icon-avg">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value"><?php echo e(number_format($stats['avg_rating'] ?? 0, 1)); ?></div>
                        <div class="metric-label">Average Rating</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-orders-orange">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3 3v18l7-3 7 3V3z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value"><?php echo e(number_format($stats['total_reviews'] ?? 0)); ?></div>
                        <div class="metric-label">Total Reviews</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-pending">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value"><?php echo e(number_format($stats['pending_reviews'] ?? 0)); ?></div>
                        <div class="metric-label">Pending Reviews</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-avg">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value"><?php echo e(number_format($stats['response_rate'] ?? 0, 1)); ?>%</div>
                        <div class="metric-label">Response Rate</div>
                    </div>
                </div>
            </div>

            <div class="card orders-table-card">
                <div class="orders-section-header">
                    <h2 class="card-title">All Reviews</h2>
                </div>

                <div class="order-status-tabs" role="tablist">
                    <button type="button" class="order-tab active" data-status="all" role="tab" aria-selected="true">All</button>
                    <button type="button" class="order-tab" data-status="published" role="tab">Published</button>
                    <button type="button" class="order-tab" data-status="pending" role="tab">Pending</button>
                    <button type="button" class="order-tab" data-status="flagged" role="tab">Flagged</button>
                </div>

                <div class="table-wrap">
                    <table class="orders-table" id="reviewsTable">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Status</th>
                                <th class="col-actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = ($reviews ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr data-status="<?php echo e($review->status ?? 'published'); ?>">
                                <td><?php echo e(optional($review->product)->product_name ?? ''); ?></td>
                                <td><?php echo e(optional($review->user)->first_name ?? ''); ?> <?php echo e(optional($review->user)->last_name ?? ''); ?></td>
                                <td><?php echo e($review->rating ?? ''); ?>/5</td>
                                <td><?php echo e($review->review_title ?? ''); ?></td>
                                <td><?php echo e(ucfirst($review->status ?? 'published')); ?></td>
                                <td class="col-actions">
                                    <a href="#" class="action-btn" title="Approve" aria-label="Approve review">
                                        ✓
                                    </a>
                                    <a href="#" class="action-btn" title="Reply" aria-label="Reply to review">
                                        ↩
                                    </a>
                                    <a href="#" class="action-btn" title="Delete" aria-label="Delete review">
                                        🗑
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center empty-orders">No reviews yet.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="<?php echo e(asset('js/orders.js')); ?>"></script>
    <script src="<?php echo e(asset('js/animations.js')); ?>"></script>
</body>
</html>



<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/reviews_admin.blade.php ENDPATH**/ ?>