<?php $__env->startSection('title','Shop by Category'); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* ── Premium Category Page ── */
.cat-page {
    width: 100% !important;
    max-width: 100% !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
}

/* Hero Banner */
.cat-hero {
    background: linear-gradient(135deg, #FFF7ED 0%, #FFEDD5 100%);
    padding: 40px 32px;
    border-radius: 0;
    text-align: center;
    margin: 0;
}

.cat-title {
    font-size: 28px;
    font-weight: 800;
    color: #1a1a1a;
    margin: 0 0 8px;
}

.cat-subtitle {
    font-size: 14px;
    color: #888;
    margin: 0 0 14px;
}

.cat-line {
    width: 48px;
    height: 3px;
    background: var(--ud-orange);
    border-radius: 3px;
    margin: 0 auto;
}

/* Grid */
.cat-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 16px;
    margin-top: 48px;
}

/* Card */
.cat-card {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 14px;
    padding: 28px 20px 22px;
    text-align: center;
    width: 280px;
    max-width: 100%;
    text-decoration: none;
    color: inherit;
    transition: all 0.25s;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.cat-card:hover {
    border-color: var(--ud-orange);
    transform: translateY(-4px);
    box-shadow: 0 10px 28px rgba(255,140,66,0.12);
}

/* Icon circle */
.cat-icon-wrap {
    width: 72px;
    height: 72px;
    margin-bottom: 16px;
    border-radius: 50%;
    background-color: #f9f9f9;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px;
    box-sizing: border-box;
    transition: all 0.3s;
}

.cat-card:hover .cat-icon-wrap {
    background-color: #FFF7ED;
    box-shadow: 0 4px 16px rgba(255,140,66,0.15);
}

.cat-icon-wrap img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.cat-emoji {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
    font-size: 32px;
    background: #FFF7ED;
}

/* Text */
.cat-name {
    font-size: 15px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 6px;
}

.cat-desc {
    font-size: 12.5px;
    color: #888;
    line-height: 1.45;
    margin-bottom: 10px;
    min-height: 36px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.cat-count {
    font-size: 12px;
    color: #aaa;
    margin-bottom: 12px;
}

.cat-link {
    font-size: 13px;
    font-weight: 700;
    color: var(--ud-orange);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: gap 0.2s;
}

.cat-card:hover .cat-link { gap: 8px; }

/* ── Responsive ── */
@media (max-width: 768px) {
    .cat-page { padding: 0 14px 40px; }
    .cat-hero { padding: 28px 20px; border-radius: 12px; margin-bottom: 20px; margin-top: 12px; }
    .cat-title { font-size: 22px; }
    .cat-subtitle { font-size: 13px; }
    .cat-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .cat-card { padding: 18px 14px 16px; border-radius: 10px; }
    .cat-icon-wrap { width: 56px; height: 56px; margin-bottom: 10px; }
    .cat-name { font-size: 13px; }
    .cat-desc { font-size: 11px; min-height: auto; -webkit-line-clamp: 2; }
    .cat-count { font-size: 11px; margin-bottom: 8px; }
    .cat-link { font-size: 12px; }
}

@media (max-width: 480px) {
    .cat-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
    .cat-card { padding: 14px 10px 12px; }
    .cat-icon-wrap { width: 48px; height: 48px; padding: 8px; }
    .cat-name { font-size: 12px; }
    .cat-desc { display: none; }
    .cat-count { font-size: 10px; }
}
</style>
<?php $__env->stopPush(); ?>

<?php
$iconMap = [
    'Food and Nutritions'   => ['icon' => '🍖'],
    'Habitats & Housing'    => ['icon' => '🏠'],
    'Health & Care'         => ['icon' => '➕'],
    'Medicine HealthCare'   => ['icon' => '💊'],
    'Toys & Enrichment'     => ['icon' => '🎾'],
    'Toys'                  => ['icon' => '🎾'],
    'Grooming & Hygiene'    => ['icon' => '✂️'],
    'Travel & Safety'       => ['icon' => '✈️'],
    'Aquatic Supplies'      => ['icon' => '🐠'],
    'Reptile & Exotic Care' => ['icon' => '🦎'],
    'Invertebrate Care'     => ['icon' => '🦀'],
    'Training & Behavior'   => ['icon' => '📋'],
];
?>

<?php $__env->startSection('content'); ?>
<div class="cat-page">

    
    <div class="cat-hero">
        <h1 class="cat-title">Shop by Category</h1>
        <p class="cat-subtitle">Browse products by what you need</p>
        <div class="cat-line"></div>
    </div>

    
    <div class="cat-grid">
        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $map = $iconMap[$category->category_name] ?? ['icon' => '📦'];
                $productCount = $category->products()->count();
            ?>
            <a href="<?php echo e(route('shop.all', ['category[]' => $category->id])); ?>" class="cat-card">
                <?php if($category->image_url): ?>
                    <div class="cat-icon-wrap">
                    <img src="<?php echo e($category->image_full_url); ?>" alt="<?php echo e($category->category_name); ?>">
                    </div>
                <?php else: ?>
                    <div class="cat-emoji"><?php echo e($map['icon']); ?></div>
                <?php endif; ?>
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

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\Pet Markt-PH\resources\views/frontend/categories.blade.php ENDPATH**/ ?>