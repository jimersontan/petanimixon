<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard_v2.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
            <div class="content-header" style="margin-bottom:0;">
                <h1 class="page-title" style="display:none;">Dashboard</h1>
            </div>

            <!-- Dashboard V2 Redesign -->
            <div class="v2-dashboard-grid">
                <!-- LEFT COLUMN: Approx 65% width -->
                <div class="v2-left-col">
                    
                    <!-- Top Stats Row (3 items) -->
                    <div class="v2-top-stats">
                        <div class="v2-stat-mini">
                            <div class="v2-stat-top">
                                <div class="v2-stat-top-inner">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                    <span>Products</span>
                                </div>
                                <span style="font-size:12px;">›</span>
                            </div>
                            <div class="v2-stat-bottom">
                                <span class="v2-stat-number"><?php echo e($totalProducts); ?></span>
                                <span class="v2-stat-badge v2-badge-green">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
                                    10%
                                </span>
                            </div>
                        </div>

                        <div class="v2-stat-mini">
                            <div class="v2-stat-top">
                                <div class="v2-stat-top-inner">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                    <span>Customers</span>
                                </div>
                                <span style="font-size:12px;">›</span>
                            </div>
                            <div class="v2-stat-bottom">
                                <span class="v2-stat-number"><?php echo e($newCustomers); ?></span>
                                <span class="v2-stat-badge v2-badge-red">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
                                    5%
                                </span>
                            </div>
                        </div>

                        <div class="v2-stat-mini">
                            <div class="v2-stat-top">
                                <div class="v2-stat-top-inner">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                    <span>Orders</span>
                                </div>
                                <span style="font-size:12px;">›</span>
                            </div>
                            <div class="v2-stat-bottom">
                                <span class="v2-stat-number"><?php echo e($totalOrders); ?></span>
                                <span class="v2-stat-badge v2-badge-green">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
                                    8%
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Major Sales Card -->
                    <div class="v2-card v2-sales-card">
                                                <div class="v2-card-header" style="margin-bottom: 24px; border-bottom: 1px solid #f3f4f6; padding-bottom: 16px;">
                            <h2 class="v2-card-title">
                                <span class="v2-sales-icon-wrap" style="color:var(--ud-orange); margin-right:8px; display:inline-flex;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                </span>
                                Sales Overview
                                <span class="v2-info-tip" title="Total accumulated revenue" style="color:#d1d5db; font-size:14px; cursor:help; margin-left:8px;">ⓘ</span>
                            </h2>
                            <div class="v2-card-actions" style="display:flex; gap:8px;">
                                <button style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:6px; padding:4px 8px; cursor:pointer; color:#6b7280; font-size:12px;">[ ]</button>
                                <button style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:6px; padding:4px 8px; cursor:pointer; color:#6b7280; font-size:12px;">✎</button>
                                <button style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:6px; padding:4px 8px; cursor:pointer; color:#6b7280; font-size:12px;">⋯</button>
                            </div>
                        </div>
                        
                        <div class="v2-sales-summary-wrap" style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:32px;">
                            <div>
                                <div style="font-size:14px; color:#6b7280; font-weight:600; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Total Revenue</div>
                                <div class="v2-sales-main-number">₱<?php echo e(number_format($totalRevenue, 0)); ?></div>
                            </div>
                            <div class="v2-sales-vs">
                                <span class="v2-sales-badge" style="background:#ecfdf5; color:#10b981; border:1px solid #a7f3d0; padding:4px 10px; border-radius:12px; font-weight:700; font-size:13px; display:inline-flex; align-items:center; gap:4px; box-shadow:0 0 10px rgba(16, 185, 129, 0.1);">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
                                    12.5%
                                </span>
                                <span style="font-size:13px; color:#9ca3af; margin-left:6px; font-weight:500;">vs last year</span>
                            </div>
                        </div>

                        <div class="v2-sales-categories">
                            <!-- Pending -->
                            <div class="v2-sale-cat-card">
                                <div style="position:absolute; top:0; left:0; right:0; height:4px; background:#f59e0b;"></div>
                                <div style="width:40px; height:40px; margin:0 auto 12px; background:#fffbeb; color:#f59e0b; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                </div>
                                <div style="font-size:13px; color:#6b7280; font-weight:600; margin-bottom:4px;">Pending Orders</div>
                                <div style="font-size:22px; font-weight:800; color:#111827; margin-bottom:2px;">₱<?php echo e(number_format($pendingOrdersRevenue, 0)); ?></div>
                                <div style="font-size:12px; color:#9ca3af; font-weight:500;"><?php echo e($pendingOrdersCount); ?> Orders</div>
                            </div>
                            
                            <!-- Processing -->
                            <div class="v2-sale-cat-card">
                                <div style="position:absolute; top:0; left:0; right:0; height:4px; background:#3b82f6;"></div>
                                <div style="width:40px; height:40px; margin:0 auto 12px; background:#eff6ff; color:#3b82f6; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                                </div>
                                <div style="font-size:13px; color:#6b7280; font-weight:600; margin-bottom:4px;">Processing</div>
                                <div style="font-size:22px; font-weight:800; color:#111827; margin-bottom:2px;">₱<?php echo e(number_format($processingRevenue, 0)); ?></div>
                                <div style="font-size:12px; color:#9ca3af; font-weight:500;"><?php echo e($processingCount); ?> Orders</div>
                            </div>

                            <!-- In Transit -->
                            <div class="v2-sale-cat-card">
                                <div style="position:absolute; top:0; left:0; right:0; height:4px; background:#06b6d4;"></div>
                                <div style="width:40px; height:40px; margin:0 auto 12px; background:#ecfeff; color:#06b6d4; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                                </div>
                                <div style="font-size:13px; color:#6b7280; font-weight:600; margin-bottom:4px;">In Transit</div>
                                <div style="font-size:22px; font-weight:800; color:#111827; margin-bottom:2px;">₱<?php echo e(number_format($transitRevenue, 0)); ?></div>
                                <div style="font-size:12px; color:#9ca3af; font-weight:500;"><?php echo e($transitCount); ?> Orders</div>
                            </div>

                            <!-- Completed -->
                            <div class="v2-sale-cat-card">
                                <div style="position:absolute; top:0; left:0; right:0; height:4px; background:#10b981;"></div>
                                <div style="width:40px; height:40px; margin:0 auto 12px; background:#ecfdf5; color:#10b981; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                </div>
                                <div style="font-size:13px; color:#6b7280; font-weight:600; margin-bottom:4px;">Completed (Paid)</div>
                                <div style="font-size:22px; font-weight:800; color:#111827; margin-bottom:2px;">₱<?php echo e(number_format($completedRevenue, 0)); ?></div>
                                <div style="font-size:12px; color:#9ca3af; font-weight:500;"><?php echo e($completedCount); ?> Orders</div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Selling Product Table -->
                    <div class="v2-card">
                        <div class="v2-card-header">
                            <h2 class="v2-card-title">Top Selling Product <span style="background:#ecfdf5; color:#10b981; font-size:10px; padding:2px 6px; border-radius:10px;"><?php echo e(count($topProducts)); ?> Product(s)</span></h2>
                            <div style="display:flex; gap:8px;">
                                <button style="background:#ffffff; border:1px solid #e5e7eb; border-radius:6px; padding:6px 12px; font-size:12px; font-weight:600; color:#6b7280;">Filters</button>
                                <button style="background:#014d87; border:none; border-radius:6px; padding:6px 12px; font-size:12px; font-weight:600; color:white;">See More</button>
                            </div>
                        </div>

                        <table class="v2-table">
                            <thead>
                                <tr>
                                    <th>Product ▾</th>
                                    <th>Sales ▾</th>
                                    <th>Amount ▾</th>
                                    <th>Price</th>
                                    <th>Status ▾</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $tp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="v2-product-cell">
                                            <div class="v2-product-img" style="background-image: url('<?php echo e($tp->image_url); ?>');"></div>
                                            <div class="v2-product-details">
                                                <span class="v2-product-name"><?php echo e(Str::limit($tp->product_name, 15)); ?></span>
                                                <span class="v2-product-sku">SKU: 30201<?php echo e($idx); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="font-weight:700; color:#111827;"><?php echo e($tp->total_sold); ?></td>
                                    <td class="v2-td-amount">₱<?php echo e(number_format((float)($tp->total_sold * 121), 0)); ?></td>
                                    <td style="font-weight:600; color:#6b7280;">₱<?php echo e(number_format($tp->price, 2)); ?></td>
                                    <td>
                                        <?php if($idx % 2 == 0): ?>
                                            <span class="v2-status-pill v2-pill-low">Low Cost</span>
                                        <?php else: ?>
                                            <span class="v2-status-pill v2-pill-pub">Published</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                </div>

                <!-- RIGHT COLUMN: Tools & Charts -->
                <div class="v2-right-col">
                    
                    <!-- Order Status & Delivery Performance Widget -->
                    <div class="v2-card" style="padding-bottom:12px; margin-bottom: 16px;">
                        <!-- Top Half: Order Status -->
                        <div style="margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid #e5e7eb;">
                            <div class="v2-card-header" style="margin-bottom:8px;">
                                <h2 class="v2-card-title">Order Status</h2>
                                <span style="font-size:12px; color:#6b7280; font-weight:600;">Total: <?php echo e($totalOrders); ?></span>
                            </div>
                            <div style="display:flex; flex-direction:column; gap:8px;">
                                <div style="display:flex; align-items:center; font-size:12px;">
                                    <div style="width:70px; color:#4b5563; font-weight:500;">Pending</div>
                                    <div style="flex:1; height:8px; background:#f3f4f6; border-radius:4px; margin:0 12px; overflow:hidden;">
                                        <div style="height:100%; background:#fcd34d; width: <?php echo e($totalOrders ? ($pendingOrdersCount / $totalOrders) * 100 : 0); ?>%; border-radius:4px;"></div>
                                    </div>
                                    <div style="width:24px; text-align:right; font-weight:700; color:#111827;"><?php echo e($pendingOrdersCount); ?></div>
                                </div>
                                <div style="display:flex; align-items:center; font-size:12px;">
                                    <div style="width:70px; color:#4b5563; font-weight:500;">Processing</div>
                                    <div style="flex:1; height:8px; background:#f3f4f6; border-radius:4px; margin:0 12px; overflow:hidden;">
                                        <div style="height:100%; background:#3b82f6; width: <?php echo e($totalOrders ? ($processingCount / $totalOrders) * 100 : 0); ?>%; border-radius:4px;"></div>
                                    </div>
                                    <div style="width:24px; text-align:right; font-weight:700; color:#111827;"><?php echo e($processingCount); ?></div>
                                </div>
                                <div style="display:flex; align-items:center; font-size:12px;">
                                    <div style="width:70px; color:#4b5563; font-weight:500;">In Transit</div>
                                    <div style="flex:1; height:8px; background:#f3f4f6; border-radius:4px; margin:0 12px; overflow:hidden;">
                                        <div style="height:100%; background:#f97316; width: <?php echo e($totalOrders ? ($transitCount / $totalOrders) * 100 : 0); ?>%; border-radius:4px;"></div>
                                    </div>
                                    <div style="width:24px; text-align:right; font-weight:700; color:#111827;"><?php echo e($transitCount); ?></div>
                                </div>
                                <div style="display:flex; align-items:center; font-size:12px;">
                                    <div style="width:70px; color:#4b5563; font-weight:500;">Delivered</div>
                                    <div style="flex:1; height:8px; background:#f3f4f6; border-radius:4px; margin:0 12px; overflow:hidden;">
                                        <div style="height:100%; background:#10b981; width: <?php echo e($totalOrders ? ($completedCount / $totalOrders) * 100 : 0); ?>%; border-radius:4px;"></div>
                                    </div>
                                    <div style="width:24px; text-align:right; font-weight:700; color:#111827;"><?php echo e($completedCount); ?></div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Half: Delivery Performance -->
                        <div>
                            <div class="v2-card-header" style="margin-bottom:8px;">
                                <h2 class="v2-card-title">Delivery Performance</h2>
                                <span style="font-size:14px; cursor:pointer; color:#d1d5db;">ⓘ</span>
                            </div>
                            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                                <div style="background:#f8fafc; padding:10px; border-radius:8px; border:1px solid #f1f5f9;">
                                    <div style="font-size:10px; color:#64748b; text-transform:uppercase; font-weight:700; display:flex; align-items:center; gap:4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                        Avg Time
                                    </div>
                                    <div style="font-size:17px; font-weight:800; color:#0f172a; margin-top:4px;"><?php echo e($avgDeliveryTime); ?> <span style="font-size:10px; font-weight:600; color:#64748b;">mins</span></div>
                                </div>
                                <div style="background:#f8fafc; padding:10px; border-radius:8px; border:1px solid #f1f5f9;">
                                    <div style="font-size:10px; color:#64748b; text-transform:uppercase; font-weight:700; display:flex; align-items:center; gap:4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                        On-Time Rate
                                    </div>
                                    <div style="font-size:17px; font-weight:800; color:#10b981; margin-top:4px;"><?php echo e($onTimeRate); ?>%</div>
                                </div>
                                <div style="background:#f8fafc; padding:10px; border-radius:8px; border:1px solid #f1f5f9;">
                                    <div style="font-size:10px; color:#64748b; text-transform:uppercase; font-weight:700; display:flex; align-items:center; gap:4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                        Success
                                    </div>
                                    <div style="font-size:17px; font-weight:800; color:#10b981; margin-top:4px;"><?php echo e($successRate); ?>%</div>
                                </div>
                                <div style="background:#f8fafc; padding:10px; border-radius:8px; border:1px solid #f1f5f9;">
                                    <div style="font-size:10px; color:#64748b; text-transform:uppercase; font-weight:700; display:flex; align-items:center; gap:4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                        Dispatch
                                    </div>
                                    <div style="font-size:17px; font-weight:800; color:#3b82f6; margin-top:4px;"><?php echo e($activeRiders); ?> <span style="font-size:10px; font-weight:600; color:#64748b;">riders</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Weekly Revenue Bar Chart -->
                    <div class="v2-card" style="padding-bottom:12px;">
                        <div class="v2-card-header" style="margin-bottom:6px;">
                            <h2 class="v2-card-title">Weekly Revenue</h2>
                            <span style="color:#d1d5db; font-size:18px; cursor:pointer;">⋮</span>
                        </div>
                        <div class="v2-chart-dummy" style="background: transparent; height: 170px; display: flex; align-items: center; justify-content: center;">
                            <canvas id="weeklyRevenueChart" width="100%" height="80"></canvas>
                        </div>
                    </div>

                    <!-- Low Stock Alerts List -->
                    <div class="v2-card" style="padding-bottom:12px;">
                        <div class="v2-card-header" style="margin-bottom:4px;">
                            <h2 class="v2-card-title">Low Stock Alerts</h2>
                            <span style="color:#d1d5db; letter-spacing:2px; font-weight:bold; cursor:pointer;">...</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom: 10px;">
                            <div style="font-size:28px; font-weight:800; color:#111827; line-height:1;"><?php echo e(count($lowStock)); ?></div>
                            <div class="v2-stat-badge v2-badge-red" style="background:transparent; padding:0; font-size:13px; color: #ef4444;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Action needed
                            </div>
                        </div>

                        <div class="v2-leads-list">
                            <?php $__empty_1 = true; $__currentLoopData = $lowStock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ls): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="v2-lead-item">
                                <div class="v2-lead-left">
                                    <div class="v2-lead-name"><?php echo e(Str::limit($ls->product_name, 25)); ?></div>
                                    <div class="v2-lead-sessions">Only <?php echo e($ls->variants_sum_variant_quantity ?? 0); ?> left</div>
                                </div>
                                <div class="v2-lead-right" style="background:#fef2f2; color:#ef4444; padding:4px 10px; border-radius:12px; border:1px solid #fee2e2;">
                                    Restock
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="v2-lead-item">
                                <div class="v2-lead-left">
                                    <div class="v2-lead-name" style="color:var(--success);">All caught up!</div>
                                    <div class="v2-lead-sessions">No items are low on stock.</div>
                                </div>
                                <div class="v2-lead-right" style="background:#ecfdf5; color:#10b981; padding:4px 10px; border-radius:12px; border:1px solid #d1fae5;">
                                    Healthy
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

            </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <!-- Chart.js configuration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var weeklyDataRaw = <?php echo $weeklyRevenueData; ?>;
            
            var ctx = document.getElementById('weeklyRevenueChart').getContext('2d');
            var weeklyChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: weeklyDataRaw.labels,
                    datasets: [{
                        label: 'Revenue',
                        data: weeklyDataRaw.data,
                        backgroundColor: '#bdf17d',
                        borderRadius: 8,
                        barThickness: 24,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#ffffff',
                            titleColor: '#014d87',
                            bodyColor: '#014d87',
                            borderColor: '#e5e7eb',
                            borderWidth: 1,
                            padding: 10,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return '$' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { color: '#9ca3af', font: { size: 10 } }
                        },
                        y: {
                            grid: { display: false, drawBorder: false },
                            ticks: { color: '#9ca3af', font: { size: 10 }, stepSize: 30000, maxTicksLimit: 5,
                                callback: function(value) { return value >= 1000 ? (value/1000) + 'k' : value; }
                            }
                        }
                    }
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\Pet Markt-PH\resources\views/dashboard_admin.blade.php ENDPATH**/ ?>