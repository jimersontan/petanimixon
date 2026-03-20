

<?php $__env->startSection('title','Shop by Category'); ?>

<?php $__env->startSection('content'); ?>
    <section class="ud-section">
        <div class="ud-section-header">
            <h2 class="ud-section-title">Shop by Category</h2>
        </div>
        <div class="ud-category-grid">
            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('categories.show', $category->id)); ?>" class="ud-category-card">
                    <div class="ud-category-card-title"><?php echo e($category->category_name); ?></div>
                    <div class="ud-category-card-meta"><?php echo e($category->products()->count()); ?> products</div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="ud-category-card">No categories found.</div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\petverse\resources\views/frontend/categories.blade.php ENDPATH**/ ?>