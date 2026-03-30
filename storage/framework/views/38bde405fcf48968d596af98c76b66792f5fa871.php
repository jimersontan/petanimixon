

<?php $__env->startSection('title','Pet Animixon - Home'); ?>

<?php $__env->startSection('content'); ?>
    <section class="ud-hero">
        <div class="ud-hero-inner">
            <div class="ud-hero-left">
                <h1 class="ud-hero-title">Everything your pet needs, from everyday to extraordinary</h1>
                <p class="ud-hero-desc">Find premium food, toys, and wellness products for cats, dogs, birds, fish, reptiles, and more.</p>
                <div class="ud-hero-btns">
                    <a href="<?php echo e(route('shop')); ?>" class="ud-btn ud-btn-primary">Shop Products</a>
                    <a href="<?php echo e(route('categories')); ?>" class="ud-btn ud-btn-outline">Browse Categories</a>
                </div>
            </div>
            <div class="ud-hero-right">
                <div class="ud-hero-image">
                    <img src="https://via.placeholder.com/600x400?text=Pet+Supplies" alt="Happy pets" />
                </div>
            </div>
        </div>
        <div class="ud-hero-sub">
            <p class="ud-hero-tagline">We sell products only — no live animals</p>
            <p class="ud-hero-desc">Browse collections curated for your beloved pets.</p>
        </div>
    </section>

    <section class="ud-features">
        <div class="ud-feature-card" style="--bg: #E3F2FD;">
            <div class="ud-feature-icon">🐾</div>
            <h3>All Pets Welcome</h3>
            <p>Products for dogs, cats, birds, fish, reptiles and more.</p>
        </div>
        <div class="ud-feature-card" style="--bg: #E8F5E9;">
            <div class="ud-feature-icon">✅</div>
            <h3>Family-Safe Products</h3>
            <p>We only source vetted brands with safe, tested ingredients.</p>
        </div>
        <div class="ud-feature-card" style="--bg: #FFF3E0;">
            <div class="ud-feature-icon">🚚</div>
            <h3>Fast Shipping</h3>
            <p>Reliable delivery right to your door.</p>
        </div>
        <div class="ud-feature-card" style="--bg: #F3E5F5;">
            <div class="ud-feature-icon">📚</div>
            <h3>Expert Guides</h3>
            <p>Care guides to help you keep your pet happy and healthy.</p>
        </div>
    </section>

    <section class="ud-section">
        <div class="ud-section-header">
            <h2 class="ud-section-title">Browse by Inclusive Category</h2>
            <p class="section-subtitle">Shop by what your pet needs—find the right category fast.</p>
        </div>
        <div class="ud-category-grid">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('shop', ['category' => $category->id])); ?>" class="ud-category-card">
                    <div class="ud-category-card-icon">💼</div>
                    <h3 class="ud-category-card-title"><?php echo e($category->category_name); ?></h3>
                    <p class="ud-category-card-meta"><?php echo e($category->products_count ?? 0); ?> items available</p>
                    <span class="ud-category-card-cta">Shop Now →</span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <section class="ud-section">
        <div class="ud-section-header">
            <h2 class="ud-section-title">Flash Sale Products</h2>
            <a href="<?php echo e(route('shop')); ?>" class="ud-view-all">View All →</a>
        </div>
        <div class="ud-flash-sale-grid">
            <div class="ud-flash-featured">
                <div class="ud-flash-featured-inner">
                    <img src="https://via.placeholder.com/600x500?text=Flash+Sale" alt="Flash sale" />
                    <span class="ud-flash-badge">FLASH SALE</span>
                </div>
            </div>
            <div class="ud-flash-products">
                <?php $__currentLoopData = $flashSale; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="ud-product-card">
                        <img src="<?php echo e($product->animal_image_url ? asset('storage/'.$product->animal_image_url) : 'https://via.placeholder.com/200x200?text=Product'); ?>" alt="<?php echo e($product->product_name); ?>">
                        <h4><?php echo e($product->product_name); ?></h4>
                        <p class="ud-price">₱<?php echo e(number_format($product->price, 2)); ?></p>
                        <button type="button" class="ud-add-cart">Add to Cart</button>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <section class="ud-section">
        <div class="ud-section-header">
            <h2 class="ud-section-title">Recently Added Items</h2>
            <a href="<?php echo e(route('shop')); ?>" class="ud-view-all">View All →</a>
        </div>
        <div class="ud-flash-products">
            <?php $__currentLoopData = $recent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="ud-product-card">
                    <img src="<?php echo e($product->animal_image_url ? asset('storage/'.$product->animal_image_url) : 'https://via.placeholder.com/200x200?text=Product'); ?>" alt="<?php echo e($product->product_name); ?>">
                    <h4><?php echo e($product->product_name); ?></h4>
                    <p class="ud-price">₱<?php echo e(number_format($product->price, 2)); ?></p>
                    <button type="button" class="ud-add-cart">Add to Cart</button>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Petverse\petverse\resources\views/frontend/home.blade.php ENDPATH**/ ?>