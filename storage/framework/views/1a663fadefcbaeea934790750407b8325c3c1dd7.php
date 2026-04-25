

<?php $__env->startSection('title', 'My Orders - Pet Markt-PH'); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* ── Orders Page ── */
.mo-page { width: 100%; padding: 32px 2rem 60px; }

/* Header */
.mo-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; flex-wrap: wrap; gap: 12px; }
.mo-heading { font-size: 28px; font-weight: 800; color: #1a1a2e; }
.mo-heading span { color: var(--ud-orange); }
.mo-subtitle { font-size: 14px; color: #888; margin-top: 4px; }

/* Stats Cards */
.mo-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 14px; margin-bottom: 28px; }
.mo-stat-card {
    background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 18px 16px;
    display: flex; align-items: center; gap: 12px; transition: all 0.2s;
}
.mo-stat-card:hover { border-color: var(--ud-orange); transform: translateY(-2px); box-shadow: 0 6px 16px rgba(232,93,4,0.08); }
.mo-stat-icon {
    width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.mo-stat-icon.total { background: #e9f2ea; color: var(--ud-orange); }
.mo-stat-icon.pending { background: #fff8e1; color: #ff9800; }
.mo-stat-icon.out_for_delivery { background: #e3f2fd; color: #1e88e5; }
.mo-stat-icon.shipped { background: #f3e5f5; color: #9c27b0; }
.mo-stat-icon.delivered { background: #e8f5e9; color: #4caf50; }
.mo-stat-num { font-size: 22px; font-weight: 800; color: #1a1a2e; }
.mo-stat-label { font-size: 12px; color: #999; }

/* Status Tabs */
.mo-tabs { display: flex; gap: 8px; margin-bottom: 24px; flex-wrap: wrap; }
.mo-tab {
    display: inline-flex; align-items: center; justify-content: center; gap: 6px;
    padding: 8px 18px; border-radius: 20px; background: #f5f5f5; color: #666;
    font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s;
    border: 1px solid transparent;
}
.mo-tab:hover { background: #fdf3ed; color: var(--ud-orange); border-color: #fce0cc; }
.mo-tab.active { background: var(--ud-orange); color: #fff; border-color: var(--ud-orange); }
.mo-tab .mo-tab-count {
    background: rgba(255,255,255,0.3); padding: 2px 8px; border-radius: 10px;
    font-size: 11px; margin-left: 0; line-height: 1; display: inline-flex; align-items: center; justify-content: center;
}
.mo-tab.active .mo-tab-count { background: rgba(255,255,255,0.3); }
.mo-tab:not(.active) .mo-tab-count { background: #e0e0e0; color: #666; }

/* Order Cards */
.mo-order-list { display: flex; flex-direction: column; gap: 16px; }
.mo-order-card {
    background: #fff; border: 1px solid #eee; border-radius: 14px; padding: 20px 24px;
    transition: all 0.2s; position: relative; overflow: hidden;
}
.mo-order-card:hover { border-color: var(--ud-orange); box-shadow: 0 6px 20px rgba(232,93,4,0.07); }
.mo-order-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 8px; }
.mo-order-id { font-weight: 700; font-size: 15px; color: var(--ud-orange); text-decoration: none; }
.mo-order-id:hover { text-decoration: underline; }
.mo-order-date { font-size: 13px; color: #999; }
.mo-badge {
    padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;
    text-transform: capitalize; display: inline-flex; align-items: center; justify-content: center;
}
.mo-badge.pending { background: #e9f2ea; color: #e65100; }
.mo-badge.out_for_delivery, .mo-badge.out_for_delivery { background: #e1f5fe; color: #0277bd; }
.mo-badge.shipped { background: #f3e5f5; color: #7b1fa2; }
.mo-badge.delivered { background: #e8f5e9; color: #2e7d32; }
.mo-badge.cancelled { background: #fbe9e7; color: #c62828; }

/* Products row */
.mo-products { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; margin-bottom: 16px; }
.mo-product-item { display: flex; align-items: center; gap: 10px; background: #fafafa; border-radius: 10px; padding: 8px 12px 8px 8px; }
.mo-product-img { width: 48px; height: 48px; border-radius: 8px; object-fit: cover; background: #eee; flex-shrink: 0; border: 1px solid #eee; }
.mo-product-name { font-size: 13px; font-weight: 600; color: #333; max-width: 160px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.mo-product-qty { font-size: 12px; color: #999; }
.mo-product-more {
    width: 48px; height: 48px; border-radius: 8px; background: #f0f0f0;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700; color: #666;
}

/* Bottom row */
.mo-order-bottom { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; padding-top: 14px; border-top: 1px solid #f0f0f0; }
.mo-total-label { font-size: 13px; color: #999; }
.mo-total-value { font-size: 20px; font-weight: 800; color: #1a1a2e; }
.mo-actions { display: flex; gap: 8px; }
.mo-btn {
    padding: 9px 20px; border-radius: 8px; font-size: 13px; font-weight: 600;
    text-decoration: none; transition: all 0.2s; border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px;
}
.mo-btn-outline { background: #fff; color: #333; border: 1px solid #ddd; }
.mo-btn-outline:hover { border-color: var(--ud-orange); color: var(--ud-orange); }
.mo-btn-primary { background: var(--ud-orange); color: #fff; }
.mo-btn-primary:hover { background: #d14f00; }

/* Empty state */
.mo-empty {
    text-align: center; padding: 60px 20px; background: #fff; border: 1px dashed #ddd;
    border-radius: 14px;
}
.mo-empty-icon { font-size: 56px; margin-bottom: 16px; }
.mo-empty-title { font-size: 20px; font-weight: 700; color: #333; margin-bottom: 8px; }
.mo-empty-text { font-size: 14px; color: #999; margin-bottom: 20px; }

/* Pagination */
.mo-pagination { margin-top: 28px; display: flex; justify-content: center; }

/* Recommended Section */
.mo-rec-section { margin-top: 56px; }
.mo-rec-title { font-size: 22px; font-weight: 800; color: #1a1a2e; margin-bottom: 20px; }
.mo-rec-title span { color: var(--ud-orange); }
.mo-rec-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 18px; }
.mo-rec-card {
    background: #fff; border: 1px solid #eee; border-radius: 14px; overflow: hidden;
    text-decoration: none; color: inherit; transition: all 0.25s; display: block;
}
.mo-rec-card:hover { border-color: var(--ud-orange); transform: translateY(-4px); box-shadow: 0 10px 24px rgba(232,93,4,0.1); }
.mo-rec-img-wrap { width: 100%; aspect-ratio: 1; overflow: hidden; background: #f9f9f9; position: relative; }
.mo-rec-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
.mo-rec-card:hover .mo-rec-img { transform: scale(1.06); }
.mo-rec-body { padding: 14px 16px 18px; }
.mo-rec-brand { font-size: 11px; color: var(--ud-orange); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
.mo-rec-name {
    font-size: 14px; font-weight: 600; color: #222; margin-bottom: 8px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    min-height: 40px;
}
.mo-rec-rating { display: flex; align-items: center; gap: 4px; margin-bottom: 8px; font-size: 13px; }
.mo-rec-stars { color: #facc15; }
.mo-rec-count { color: #999; }
.mo-rec-price { font-size: 18px; font-weight: 800; color: var(--ud-orange); }

@media (max-width: 768px) {
    .mo-page { padding: 20px 14px 40px; }
    .mo-heading { font-size: 22px; }
    .mo-stats { grid-template-columns: repeat(2, 1fr); }
    .mo-order-card { padding: 16px; }
    .mo-product-name { max-width: 100px; }
    .mo-rec-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="mo-page">

    
    <div class="mo-header">
        <div>
            <h1 class="mo-heading">My <span>Orders</span></h1>
            <p class="mo-subtitle">Track and manage all your purchases</p>
        </div>
        <a href="<?php echo e(route('shop')); ?>" class="mo-btn mo-btn-primary">🛒 Continue Shopping</a>
    </div>

    
    <div class="mo-stats">
        <div class="mo-stat-card">
            <div class="mo-stat-icon total">📦</div>
            <div>
                <div class="mo-stat-num"><?php echo e($stats['total'] ?? 0); ?></div>
                <div class="mo-stat-label">Total Orders</div>
            </div>
        </div>
        <div class="mo-stat-card">
            <div class="mo-stat-icon pending">⏳</div>
            <div>
                <div class="mo-stat-num"><?php echo e($stats['pending'] ?? 0); ?></div>
                <div class="mo-stat-label">Pending</div>
            </div>
        </div>
        <div class="mo-stat-card">
            <div class="mo-stat-icon out_for_delivery">🛵</div>
            <div>
                <div class="mo-stat-num"><?php echo e($stats['out_for_delivery'] ?? 0); ?></div>
                <div class="mo-stat-label">Out For Delivery</div>
            </div>
        </div>
        <div class="mo-stat-card">
            <div class="mo-stat-icon delivered">✅</div>
            <div>
                <div class="mo-stat-num"><?php echo e($stats['delivered'] ?? 0); ?></div>
                <div class="mo-stat-label">Delivered</div>
            </div>
        </div>
    </div>

    
    <?php $sf = $statusFilter ?? 'all'; ?>
    <div class="mo-tabs">
        <a href="<?php echo e(route('orders', ['status' => 'all'])); ?>" class="mo-tab <?php echo e($sf === 'all' ? 'active' : ''); ?>">
            All <span class="mo-tab-count"><?php echo e($stats['total'] ?? 0); ?></span>
        </a>
        <a href="<?php echo e(route('orders', ['status' => 'pending'])); ?>" class="mo-tab <?php echo e($sf === 'pending' ? 'active' : ''); ?>">
            Pending <span class="mo-tab-count"><?php echo e($stats['pending'] ?? 0); ?></span>
        </a>
        <a href="<?php echo e(route('orders', ['status' => 'processing'])); ?>" class="mo-tab <?php echo e($sf === 'processing' ? 'active' : ''); ?>">
            Processing <span class="mo-tab-count"><?php echo e($stats['processing'] ?? 0); ?></span>
        </a>
        <a href="<?php echo e(route('orders', ['status' => 'out_for_delivery'])); ?>" class="mo-tab <?php echo e($sf === 'out_for_delivery' ? 'active' : ''); ?>">
            Out For Delivery <span class="mo-tab-count"><?php echo e($stats['out_for_delivery'] ?? 0); ?></span>
        </a>
        <a href="<?php echo e(route('orders', ['status' => 'delivered'])); ?>" class="mo-tab <?php echo e($sf === 'delivered' ? 'active' : ''); ?>">
            Delivered <span class="mo-tab-count"><?php echo e($stats['delivered'] ?? 0); ?></span>
        </a>
        <a href="<?php echo e(route('orders', ['status' => 'cancelled'])); ?>" class="mo-tab <?php echo e($sf === 'cancelled' ? 'active' : ''); ?>">
            Cancelled <span class="mo-tab-count"><?php echo e($stats['cancelled'] ?? 0); ?></span>
        </a>
    </div>

    
    <?php if($orders->isEmpty()): ?>
        <div class="mo-empty">
            <div class="mo-empty-icon">📭</div>
            <div class="mo-empty-title">No orders found</div>
            <div class="mo-empty-text">
                <?php if($sf !== 'all'): ?>
                    You don't have any <?php echo e($sf); ?> orders yet.
                <?php else: ?>
                    You haven't placed any orders yet. Let's change that!
                <?php endif; ?>
            </div>
            <a href="<?php echo e(route('shop')); ?>" class="mo-btn mo-btn-primary">Browse Products</a>
        </div>
    <?php else: ?>
        <div class="mo-order-list">
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mo-order-card">
                    
                    <div class="mo-order-top">
                        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                            <a href="<?php echo e(route('order.track', $order->order_id)); ?>" class="mo-order-id">
                                <?php echo e($order->display_id); ?>

                            </a>
                            <span class="mo-order-date"><?php echo e($order->created_at->format('M j, Y · g:i A')); ?></span>
                        </div>
                        <div style="display:flex; gap:8px; align-items:center;">
                            <?php if($order->isLocal()): ?>
                                <span class="mo-badge" style="background:#fef3c7; color:#d97706;">🛵 Local</span>
                            <?php else: ?>
                                <span class="mo-badge" style="background:#fce7f3; color:#be185d;">📦 Courier</span>
                            <?php endif; ?>
                            <span class="mo-badge <?php echo e($order->order_status); ?>">
                                <?php echo e($order->status_label); ?>

                            </span>
                        </div>
                    </div>

                    
                    <div class="mo-products">
                        <?php $__currentLoopData = $order->orderItems->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mo-product-item">
                                <img src="<?php echo e(optional($item->product)->image_url ?? asset('images/placeholder.png')); ?>" alt="" class="mo-product-img">
                                <div>
                                    <div class="mo-product-name"><?php echo e(optional($item->product)->product_name ?? 'Product'); ?></div>
                                    <div class="mo-product-qty">x<?php echo e($item->quantity); ?> · ₱<?php echo e(number_format((float)($item->price ?? 0), 2)); ?></div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($order->orderItems->count() > 3): ?>
                            <div class="mo-product-more">+<?php echo e($order->orderItems->count() - 3); ?></div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="mo-order-bottom">
                        <div>
                            <div class="mo-total-label"><?php echo e($order->orderItems->count()); ?> <?php echo e(Str::plural('item', $order->orderItems->count())); ?> · Order Total</div>
                            <div class="mo-total-value">₱<?php echo e(number_format((float)$order->total_amount, 2)); ?></div>
                        </div>
                        <div class="mo-actions">
                            <a href="<?php echo e(route('order.track', $order->order_id)); ?>" class="mo-btn mo-btn-outline">📋 View Details</a>
                            <?php if($order->order_status === 'out_for_delivery'): ?>
                                <a href="<?php echo e(route('order.track', $order->order_id)); ?>" class="mo-btn mo-btn-primary">📍 Track Package</a>
                            <?php elseif($order->order_status === 'delivered'): ?>
                                <a href="<?php echo e(route('order.track', $order->order_id)); ?>" class="mo-btn mo-btn-primary">⭐ Write Review</a>
                                <?php if($order->orderItems->first()): ?>
                                    <a href="<?php echo e(route('returns.create', $order->orderItems->first()->id)); ?>" class="mo-btn mo-btn-outline" style="border-color: #ef4444; color: #ef4444;">↩ Return</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <?php if($orders->hasPages()): ?>
            <div class="mo-pagination">
                <?php echo e($orders->links()); ?>

            </div>
        <?php endif; ?>
    <?php endif; ?>

    
    <?php if(isset($recommendedProducts) && $recommendedProducts->isNotEmpty()): ?>
        <div class="mo-rec-section">
            <h3 class="mo-rec-title">You May Also <span>Like</span></h3>
            <div class="mo-rec-grid">
                <?php $__currentLoopData = $recommendedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('product.show', $product->id)); ?>" class="mo-rec-card js-open-product-modal" data-product-id="<?php echo e($product->id); ?>">
                        <div class="mo-rec-img-wrap">
                            <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->product_name); ?>" class="mo-rec-img">
                        </div>
                        <div class="mo-rec-body">
                            <div class="mo-rec-brand"><?php echo e($product->brand_name ?: 'Pet Markt-PH'); ?></div>
                            <h4 class="mo-rec-name"><?php echo e($product->product_name); ?></h4>
                            <div class="mo-rec-rating">
                                <span class="mo-rec-stars">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php echo e($i <= round($product->avg_rating) ? '★' : '☆'); ?>

                                    <?php endfor; ?>
                                </span>
                                <span class="mo-rec-count">(<?php echo e($product->reviews_count); ?>)</span>
                            </div>
                            <div class="mo-rec-price">₱<?php echo e(number_format((float)$product->price, 2)); ?></div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\Pet Markt-PH\resources\views/frontend/orders.blade.php ENDPATH**/ ?>