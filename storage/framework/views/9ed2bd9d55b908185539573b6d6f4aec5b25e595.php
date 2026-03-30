

<?php $__env->startSection('title','Edit Brand'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
    <h1 class="page-title">Edit Brand</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('brands.update', $brand)); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <?php echo $__env->make('brands._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <button type="submit" class="btn-primary">Save Changes</button>
            <a href="<?php echo e(route('brands.admin')); ?>" class="btn-secondary">Cancel</a>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Petverse\petverse\resources\views/brands/edit.blade.php ENDPATH**/ ?>