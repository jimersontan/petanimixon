

<?php $__env->startSection('title', $category->category_name . ' - Shop'); ?>

<?php $__env->startSection('content'); ?>
    <section class="ud-section">
        <div class="ud-section-header">
            <h2 class="ud-section-title"><?php echo e($category->category_name); ?></h2>
            <a href="<?php echo e(route('categories')); ?>" class="ud-view-all">Back to categories</a>
        </div>

        <div class="ud-product-grid">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="ud-product-card">
                    <button type="button" class="ud-wishlist-btn" aria-label="Add to wishlist">♡</button>
                    <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->product_name); ?>"
                         onerror="this.onerror=null; this.src='<?php echo e(asset('images/placeholder.png')); ?>'"
                         onclick="window.openProductModal(<?php echo e($product->id); ?>, event)" style="cursor:pointer;">
                    <h4 onclick="window.openProductModal(<?php echo e($product->id); ?>, event)" style="cursor:pointer; transition:color 0.2s;" onmouseover="this.style.color='#3b7c42'" onmouseout="this.style.color='inherit'"><?php echo e($product->product_name); ?></h4>
                    <p class="ud-price">₱<?php echo e(number_format((float)$product->price, 2)); ?></p>
                    <?php if(auth()->guard()->check()): ?>
                    <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="ud-add-cart" <?php echo e($product->stock > 0 ? '' : 'disabled'); ?>>
                            <?php echo e($product->stock > 0 ? 'Add to Cart' : 'Out of Stock'); ?>

                        </button>
                    </form>
                    <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="ud-add-cart" style="text-decoration:none; text-align:center; display:block;">Add to Cart</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p>No products found in this category yet.</p>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/frontend/category.blade.php ENDPATH**/ ?>