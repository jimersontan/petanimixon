

<?php $__env->startSection('title','Petverse - Everything Your Pet Needs'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('message')): ?>
        <div class="ud-msg"><?php echo e(session('message')); ?></div>
    <?php endif; ?>

    <!-- Hero Section -->
    <section class="ud-hero">
        <div class="ud-hero-inner">
            <div class="ud-hero-left">
                <h1 class="ud-hero-title">Everything your pet needs is here, just wait!</h1>
                <div class="ud-hero-btns">
                    <a href="<?php echo e(route('shop.all')); ?>" class="ud-btn ud-btn-primary">Shop Now</a>
                    <a href="<?php echo e(route('categories')); ?>" class="ud-btn ud-btn-outline">View Categories</a>
                </div>
            </div>
            
            <div class="ud-hero-right ud-hide-mobile">
                <div class="ud-hero-image">
                    <img src="https://images.unsplash.com/photo-1544568100-847a948585b9?w=600&h=400&fit=crop" alt="Happy pets - dog, cat, and rabbit">
                </div>
            </div>

            
            <div class="ud-hero-products ud-show-mobile">
                <h3 class="hero-prod-heading">🔥 Popular Products</h3>
                <div class="hero-prod-grid">
                    <?php $__currentLoopData = ($heroProducts ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('product.show', $hp->id)); ?>" class="hero-prod-card">
                        <div class="hero-prod-img-wrap">
                            <img src="<?php echo e($hp->image_url); ?>" alt="<?php echo e($hp->product_name); ?>" onerror="this.src='https://via.placeholder.com/150x150?text=No+Image'">
                            <?php if($loop->index < 2): ?>
                            <span class="hero-prod-badge">Best Seller</span>
                            <?php endif; ?>
                        </div>
                        <div class="hero-prod-info">
                            <div class="hero-prod-name"><?php echo e(Str::limit($hp->product_name, 28)); ?></div>
                            <div class="hero-prod-price">₱<?php echo e(number_format($hp->price, 2)); ?></div>
                        </div>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <div class="ud-purple-banner">
            <div class="ud-banner-header">
                <div class="ud-banner-icon">
                    <svg viewBox="0 0 24 24" fill="#6B46C1" width="28" height="28">
                        <path d="M19 6h-4a3 3 0 0 0-6 0H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2zm-7-2a1 1 0 0 1 1 1h-2a1 1 0 0 1 1-1z"/>
                    </svg>
                </div>
                <h2 class="ud-banner-title">We Sell Products Only, No Live Animals</h2>
            </div>
            <p class="ud-banner-desc">Pet Animixon is your trusted source for premium pet supplies, food, toys, and accessories. We're dedicated to providing quality products that keep your pets happy and healthy.</p>
            <a href="#" class="ud-banner-link">Learn More About Us &rarr;</a>
        </div>
    </section>

    <!-- Key Features (Trust Strip) -->
    <section class="ud-features">
        <div class="ud-feature-card">
            <div class="ud-feature-icon-wrapper icon-blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="2" y1="12" x2="22" y2="12"></line>
                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                </svg>
            </div>
            <h3>All Pets Welcome</h3>
            <p>Support for every species, from dogs to birds</p>
        </div>
        <div class="ud-feature-card">
            <div class="ud-feature-icon-wrapper icon-green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <h3>Family-Safe Products</h3>
            <p>Vetted for safety and quality standards</p>
        </div>
        <div class="ud-feature-card">
            <div class="ud-feature-icon-wrapper icon-orange">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
            </div>
            <h3>Fast Shipping</h3>
            <p>Quick, reliable delivery to your door</p>
        </div>
        <div class="ud-feature-card">
            <div class="ud-feature-icon-wrapper icon-purple">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                </svg>
            </div>
            <h3>Expert Guides</h3>
            <p>Free care resources and pet tips</p>
        </div>
    </section>

    <!-- Browse by Category -->
    <section class="ud-section ud-categories">
        <h2 class="ud-section-title">
            <span class="ud-paw">🐾</span>
            Browse by Inclusive Category
            <span class="ud-paw">🐾</span>
        </h2>
        <div class="ud-category-grid" id="udCategoryGrid">
            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('categories.show', $category->id)); ?>" class="ud-category-card">
                    <div class="ud-category-card-title"><?php echo e($category->category_name); ?></div>
                    <div class="ud-category-card-meta"><?php echo e($category->products()->count()); ?> products</div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="ud-category-card">No categories available yet.</div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Promotional Banners -->
    <section class="ud-promo-banners">
        <div class="ud-promo-card ud-promo-orange">
            <div class="ud-promo-content">
                <h3>Wholesome Nutrition for Pets</h3>
                <a href="#" class="ud-btn ud-btn-promo">Read More</a>
            </div>
            <div class="ud-promo-image">
                <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=300&h=200&fit=crop" alt="Happy dog with food">
            </div>
        </div>
        <div class="ud-promo-card ud-promo-blue">
            <div class="ud-promo-content">
                <h3>Premium Food for Your Happy Pets</h3>
                <a href="#" class="ud-btn ud-btn-promo">Shop Now</a>
            </div>
            <div class="ud-promo-image">
                <img src="https://images.unsplash.com/photo-1589924691995-400dc9ecc119?w=300&h=200&fit=crop" alt="Pet food products">
            </div>
        </div>
    </section>

    <!-- Why Choose Our Pet Products -->
    <section class="ud-why-choose">
        <div class="ud-why-inner">
            <div class="ud-why-image">
                <img src="https://images.unsplash.com/photo-1576087001033-5e1e2d7a5b51?w=500&h=400&fit=crop" alt="Happy pets">
            </div>
            <div class="ud-why-content">
                <h2>Why Choose Our Pet Products</h2>
                <ul class="ud-why-list">
                    <li>High-Quality Pet Items</li>
                    <li>24/7 Customer Support</li>
                    <li>Fast & Reliable Delivery</li>
                    <li>Safety & Hygiene Standards</li>
                    <li>Satisfaction Guaranteed</li>
                </ul>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Petverse\petverse\resources\views/user_dashboard.blade.php ENDPATH**/ ?>