

<?php $__env->startSection('title','Create Category'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
    <div>
        <h1 class="page-title">Create Category</h1>
        <p class="page-subtitle">Organize your products into clear sections.</p>
    </div>
</div>

<div class="card form-card">
    <form action="<?php echo e(route('categories.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo $__env->make('categories._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="form-actions">
            <button type="submit" class="btn-primary">Save category</button>
            <a href="<?php echo e(route('categories.admin')); ?>" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Petverse\petverse\resources\views/categories/create.blade.php ENDPATH**/ ?>