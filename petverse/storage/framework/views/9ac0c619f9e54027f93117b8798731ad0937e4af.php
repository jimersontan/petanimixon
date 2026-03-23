

<?php $__env->startSection('title','Edit Category'); ?>

<?php $__env->startSection('content'); ?>
<h1>Edit Category</h1>
<form action="<?php echo e(route('categories.update', $category)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <?php echo $__env->make('categories._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <button type="submit" class="btn btn-primary">Save Changes</button>
    <a href="<?php echo e(route('categories.admin')); ?>" class="btn btn-secondary">Cancel</a>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\petverse\resources\views/categories/edit.blade.php ENDPATH**/ ?>