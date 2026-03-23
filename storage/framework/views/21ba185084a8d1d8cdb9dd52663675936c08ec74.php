

<?php $__env->startSection('title','Shop by Category'); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* ── Category Page ── */
.cat-page { max-width: 1100px; margin: 0 auto; padding: 32px 20px 60px; }

/* Header */
.cat-header { text-align: center; margin-bottom: 36px; }
.cat-title {
    font-size: 30px; font-weight: 800; color: #1a1a2e; margin: 0 0 8px;
}
.cat-subtitle { font-size: 14px; color: #888; margin: 0 0 14px; }
.cat-line { width: 48px; height: 3px; background: #E85D04; border-radius: 3px; margin: 0 auto; }

/* Grid */
.cat-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;
}

/* Card */
.cat-card {
    background: #fff; border: 1px solid #eee; border-radius: 14px;
    padding: 28px 20px 22px; text-align: center; text-decoration: none; color: inherit;
    transition: all 0.25s; display: flex; flex-direction: column; align-items: center;
}
.cat-card:hover {
    border-color: #E85D04; transform: translateY(-4px);
    box-shadow: 0 10px 28px rgba(232,93,4,0.1);
}

/* Icon circle */
.cat-icon {
    width: 64px; height: 64px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 16px; font-size: 26px;
}
.cat-icon.orange { background: #fff3e0; color: #E85D04; }
.cat-icon.blue   { background: #e3f0ff; color: #2563eb; }
.cat-icon.red    { background: #fce4ec; color: #e53935; }
.cat-icon.teal   { background: #e0f2f1; color: #00897b; }

/* Text */
.cat-name { font-size: 15px; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
.cat-desc { font-size: 12.5px; color: #888; line-height: 1.45; margin-bottom: 10px; min-height: 36px; }
.cat-count { font-size: 12px; color: #aaa; margin-bottom: 12px; }
.cat-link {
    font-size: 13px; font-weight: 700; color: #E85D04; text-decoration: none;
    display: inline-flex; align-items: center; gap: 4px; transition: gap 0.2s;
}
.cat-card:hover .cat-link { gap: 8px; }

@media (max-width: 900px) {
    .cat-grid { grid-template-columns: repeat(3, 1fr); gap: 16px; }
}
@media (max-width: 600px) {
    .cat-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .cat-card { padding: 20px 14px 16px; }
    .cat-icon { width: 52px; height: 52px; font-size: 22px; }
    .cat-name { font-size: 13px; }
}
</style>
<?php $__env->stopPush(); ?>

<?php
// Map category names to icon + color
$iconMap = [
    'Food and Nutritions'   => ['icon' => '🍖', 'color' => 'orange'],
    'Habitats & Housing'    => ['icon' => '🏠', 'color' => 'blue'],
    'Health & Care'         => ['icon' => '➕', 'color' => 'red'],
    'Medicine HealthCare'   => ['icon' => '➕', 'color' => 'red'],
    'Toys & Enrichment'     => ['icon' => '🎾', 'color' => 'teal'],
    'Toys'                  => ['icon' => '🎾', 'color' => 'teal'],
    'Grooming & Hygiene'    => ['icon' => '✂️', 'color' => 'orange'],
    'Travel & Safety'       => ['icon' => '✈️', 'color' => 'blue'],
    'Aquatic Supplies'      => ['icon' => '🐠', 'color' => 'teal'],
    'Reptile & Exotic Care' => ['icon' => '🦎', 'color' => 'teal'],
    'Invertebrate Care'     => ['icon' => '🦀', 'color' => 'red'],
    'Training & Behavior'   => ['icon' => '📋', 'color' => 'blue'],
];
?>

<?php $__env->startSection('content'); ?>
<div class="cat-page">

    
    <div class="cat-header">
        <h1 class="cat-title">Shop by Category</h1>
        <p class="cat-subtitle">Browse products by what you need</p>
        <div class="cat-line"></div>
    </div>

    
    <div class="cat-grid">
        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $map = $iconMap[$category->category_name] ?? ['icon' => '📦', 'color' => 'orange'];
                $productCount = $category->products()->count();
            ?>
            <a href="<?php echo e(route('categories.show', $category->id)); ?>" class="cat-card">
                <div class="cat-icon <?php echo e($map['color']); ?>"><?php echo e($map['icon']); ?></div>
                <div class="cat-name"><?php echo e($category->category_name); ?></div>
                <div class="cat-desc"><?php echo e($category->description ?: 'Explore our selection'); ?></div>
                <div class="cat-count"><?php echo e($productCount); ?> <?php echo e(Str::plural('product', $productCount)); ?></div>
                <span class="cat-link">Shop Now →</span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="cat-card" style="grid-column: 1/-1; padding: 60px;">
                <div style="font-size: 48px; margin-bottom: 16px;">📭</div>
                <div class="cat-name">No categories found</div>
            </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\petverse\resources\views/frontend/categories.blade.php ENDPATH**/ ?>