

<?php $__env->startSection('title', $product->product_name . ' - Pet Animixon'); ?>

<?php $__env->startSection('content'); ?>
<div class="pd-page">
    
    <div class="pd-breadcrumb">
        <a href="<?php echo e(route('shop')); ?>">Home</a> /
        <a href="<?php echo e(route('shop.all')); ?>">Shop</a> /
        <?php if($product->category): ?>
        <a href="<?php echo e(route('categories.show', $product->category->id)); ?>"><?php echo e($product->category->category_name); ?></a> /
        <?php endif; ?>
        <?php echo e($product->product_name); ?>

    </div>

    <?php echo $__env->make('frontend.partials.product_modal_content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</div>


<div class="rv-lightbox" id="lightbox" onclick="window.closeLightbox()">
    <button class="rv-lightbox-close">&times;</button>
    <img id="lightboxImg" src="" alt="Review photo">
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views\frontend\product.blade.php ENDPATH**/ ?>