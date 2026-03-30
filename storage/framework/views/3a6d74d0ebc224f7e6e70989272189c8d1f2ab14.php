

<?php $__env->startSection('title','Create Product'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
    <div>
        <h1 class="page-title">Create Product</h1>
        <p class="page-subtitle">Add a new item to your catalog.</p>
    </div>
</div>

<div class="card form-card">
    <form action="<?php echo e(route('products.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo $__env->make('products._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="form-actions">
            <button type="submit" class="btn-primary">Save product</button>
            <a href="<?php echo e(route('products.admin')); ?>" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Petverse\petverse\resources\views/products/create.blade.php ENDPATH**/ ?>