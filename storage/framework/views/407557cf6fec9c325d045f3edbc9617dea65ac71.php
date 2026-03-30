

<?php $__env->startSection('title','Create Brand'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
    <div>
        <h1 class="page-title">Add New Brand</h1>
        <p class="page-subtitle">Highlight the brands you work with.</p>
    </div>
</div>

<div class="card form-card">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('brands.store')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('brands._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="form-actions">
                <button type="submit" class="btn-primary">Create brand</button>
                <a href="<?php echo e(route('brands.admin')); ?>" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Petverse\petverse\resources\views/brands/create.blade.php ENDPATH**/ ?>