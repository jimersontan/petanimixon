

<?php $__env->startSection('title','Edit Product'); ?>

<?php $__env->startSection('content'); ?>
<h1>Edit Product</h1>
<form action="<?php echo e(route('products.update', $product)); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <?php echo $__env->make('products._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <button type="submit" class="btn btn-primary">Save Changes</button>
    <a href="<?php echo e(route('products.admin')); ?>" class="btn btn-secondary">Cancel</a>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Petverse\petverse\resources\views/products/edit.blade.php ENDPATH**/ ?>