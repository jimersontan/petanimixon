<?php $__env->startSection('title', 'Order Placed - Pet Animixon'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.success-page { max-width: 600px; margin: 0 auto; padding: 50px 20px 60px; text-align: center; }
.success-icon { font-size: 64px; margin-bottom: 16px; display: block; }
.success-page h1 { font-size: 28px; font-weight: 800; color: #222; margin: 0 0 8px; }
.success-page .sub { font-size: 15px; color: #888; margin: 0 0 24px; }
.success-card { background: #fff; border-radius: 14px; padding: 28px; box-shadow: 0 2px 12px rgba(0,0,0,.06); text-align: left; margin-bottom: 24px; }
.success-row { display: flex; justify-content: space-between; padding: 8px 0; font-size: 14px; border-bottom: 1px solid #f5f5f5; }
.success-row:last-child { border-bottom: none; }
.success-label { color: #888; }
.success-value { color: #333; font-weight: 600; }
.success-total { font-size: 18px; font-weight: 800; color: #FF8C42; border-top: 2px solid #eee; padding-top: 12px; margin-top: 6px; }
.success-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
.success-btn { padding: 14px 28px; border-radius: 8px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all .2s; display: inline-flex; align-items: center; gap: 6px; }
.success-btn-track { background: #FF8C42; color: #fff; }
.success-btn-track:hover { opacity: .88; }
.success-btn-orders { background: #f0f0f0; color: #555; }
.success-btn-orders:hover { background: #e0e0e0; }
.success-btn-shop { background: #fff; color: #FF8C42; border: 2px solid #FF8C42; }
.success-btn-shop:hover { background: #fffaf5; }

@media (max-width: 768px) {
    .success-page { padding: 30px 12px 100px; }
    .success-page h1 { font-size: 22px; }
    .success-actions { flex-direction: column; }
    .success-btn { justify-content: center; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="success-page">
    <span class="success-icon">🎉</span>
    <h1>Order Placed Successfully!</h1>
    <p class="sub">Thank you for shopping at Pet Animixon. We'll start processing your order right away.</p>

    <div class="success-card">
        <div class="success-row">
            <span class="success-label">Order ID</span>
            <span class="success-value"><?php echo e($order->order_id); ?></span>
        </div>
        <div class="success-row">
            <span class="success-label">Date</span>
            <span class="success-value"><?php echo e($order->created_at->format('M j, Y g:i A')); ?></span>
        </div>
        <div class="success-row">
            <span class="success-label">Payment</span>
            <span class="success-value"><?php echo e($order->payment_method === 'cod' ? 'Cash on Delivery' : 'GCash'); ?></span>
        </div>
        <div class="success-row">
            <span class="success-label">Shipping</span>
            <span class="success-value"><?php echo e(ucfirst($order->shipping_method ?? 'Standard')); ?> Delivery</span>
        </div>
        <div class="success-row">
            <span class="success-label">Items</span>
            <span class="success-value"><?php echo e($order->orderItems->count()); ?> item(s)</span>
        </div>
        <div class="success-row success-total">
            <span>Total</span>
            <span>₱<?php echo e(number_format($order->total_amount, 2)); ?></span>
        </div>
    </div>

    <div class="success-actions">
        <a href="<?php echo e(route('order.track', $order->order_id)); ?>" class="success-btn success-btn-track">📦 Track My Order</a>
        <a href="<?php echo e(route('orders')); ?>" class="success-btn success-btn-orders">📋 My Orders</a>
        <a href="<?php echo e(route('shop.all')); ?>" class="success-btn success-btn-shop">🛒 Continue Shopping</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\petverse\resources\views/frontend/checkout_success.blade.php ENDPATH**/ ?>