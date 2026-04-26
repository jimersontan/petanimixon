<?php $__env->startSection('title', 'My Wishlist - Pet Markt-PH'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.wl-page { width: 100%; padding: 32px 2rem 60px; }
.wl-header { margin-bottom: 28px; }
.wl-heading { font-size: 28px; font-weight: 800; color: #1a1a2e; }
.wl-heading span { color: var(--ud-orange); }
.wl-subtitle { font-size: 14px; color: #888; margin-top: 4px; }
.wl-count { background: var(--ud-orange); color: #fff; padding: 2px 10px; border-radius: 10px; font-size: 13px; font-weight: 700; margin-left: 8px; }
.wl-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
.wl-card {
    background: #fff; border: 1px solid #eee; border-radius: 14px; overflow: hidden;
    transition: all 0.25s; position: relative;
}
.wl-card:hover { border-color: var(--ud-orange); transform: translateY(-4px); box-shadow: 0 10px 24px rgba(232,93,4,0.1); }
.wl-img-wrap { width: 100%; aspect-ratio: 1; overflow: hidden; background: #f9f9f9; }
.wl-img { width: 100%; height: 100%; object-fit: contain; mix-blend-mode: multiply; transition: transform 0.3s; }
.wl-card:hover .wl-img { transform: scale(1.06); }
.wl-body { padding: 14px 16px 18px; }
.wl-brand { font-size: 11px; color: var(--ud-orange); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
.wl-name { font-size: 14px; font-weight: 600; color: #222; margin-bottom: 8px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 40px; }
.wl-price { font-size: 20px; font-weight: 800; color: var(--ud-orange); margin-bottom: 12px; }
.wl-actions { display: flex; gap: 8px; }
.wl-btn { flex: 1; padding: 10px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; text-align: center; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 4px; border: none; }
.wl-btn-cart { background: var(--ud-orange); color: #fff; }
.wl-btn-cart:hover { background: #d14f00; }
.wl-btn-remove { background: #fff; color: #666; border: 1px solid #ddd; }
.wl-btn-remove:hover { border-color: #ef4444; color: #ef4444; }
.wl-empty { text-align: center; padding: 60px 20px; background: #fff; border: 1px dashed #ddd; border-radius: 14px; }
.wl-empty-icon { font-size: 56px; margin-bottom: 16px; }
.wl-empty-title { font-size: 20px; font-weight: 700; color: #333; margin-bottom: 8px; }
.wl-empty-text { font-size: 14px; color: #999; margin-bottom: 20px; }
@media (max-width: 768px) {
    .wl-page { padding: 20px 14px 40px; }
    .wl-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="wl-page">
    <div class="wl-header">
        <h1 class="wl-heading">My <span>Wishlist</span> <span class="wl-count"><?php echo e($items->count()); ?></span></h1>
        <p class="wl-subtitle">Products you've saved for later</p>
    </div>

    <?php if($items->isEmpty()): ?>
        <div class="wl-empty">
            <div class="wl-empty-icon">💖</div>
            <div class="wl-empty-title">Your wishlist is empty</div>
            <div class="wl-empty-text">Start adding products you love by clicking the heart icon!</div>
            <a href="<?php echo e(route('shop.all')); ?>" class="wl-btn wl-btn-cart" style="display: inline-flex; padding: 12px 24px;">Browse Products</a>
        </div>
    <?php else: ?>
        <div class="wl-grid">
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($item->product): ?>
                <div class="wl-card">
                    <a href="<?php echo e(route('product.show', $item->product->id)); ?>" class="js-open-product-modal" data-product-id="<?php echo e($item->product->id); ?>" style="text-decoration: none; color: inherit;">
                        <div class="wl-img-wrap">
                            <img src="<?php echo e($item->product->image_url); ?>" alt="<?php echo e($item->product->product_name); ?>" class="wl-img">
                        </div>
                    </a>
                    <div class="wl-body">
                        <div class="wl-brand"><?php echo e($item->product->brand_name ?: 'Pet Markt-PH'); ?></div>
                        <h4 class="wl-name js-open-product-modal" data-product-id="<?php echo e($item->product->id); ?>" style="cursor: pointer;"><?php echo e($item->product->product_name); ?></h4>
                        <div class="wl-price">₱<?php echo e(number_format($item->product->price, 0)); ?></div>
                        <div class="wl-actions">
                            <form action="<?php echo e(route('cart.add')); ?>" method="POST" style="flex: 1;">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="product_id" value="<?php echo e($item->product->id); ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="wl-btn wl-btn-cart" style="width: 100%;">🛒 Add to Cart</button>
                            </form>
                            <a href="<?php echo e(route('wishlist.remove', $item->id)); ?>" class="wl-btn wl-btn-remove" onclick="return confirm('Remove from wishlist?')">✕</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\Pet Markt-PH\resources\views/frontend/wishlist.blade.php ENDPATH**/ ?>