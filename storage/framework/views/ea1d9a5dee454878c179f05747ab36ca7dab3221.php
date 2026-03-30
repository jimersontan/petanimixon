

<?php $__env->startSection('title','Petverse - Everything Your Pet Needs'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('message')): ?>
        <div class="ud-msg"><?php echo e(session('message')); ?></div>
    <?php endif; ?>

    <!-- Hero Section -->
    <section class="ud-hero">
        <div class="ud-hero-inner">
            
            <div class="ud-hero-products">
                <h3 class="hero-prod-heading" style="text-align: left; font-size: 20px; margin-bottom: 15px;">🔥 Popular Products</h3>
                <div class="hero-prod-grid">
                    <?php $__currentLoopData = ($heroProducts ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('product.show', $hp->id)); ?>" onclick="window.openProductModal(<?php echo e($hp->id); ?>, event)" class="hero-prod-card">
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
            <div class="ud-hero-right ud-hero-products-right">
                <h3 class="hero-prod-heading" style="text-align: left; font-size: 20px; margin-bottom: 15px;">✨ Featured Products</h3>
                <div class="hero-prod-grid-3">
                    <?php $__currentLoopData = $featuredProducts->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="ud-product-card" style="padding: 12px; display: flex; flex-direction: column; background: #fff; border: 1px solid rgba(255,136,68,.2); box-shadow: 0 2px 6px rgba(0,0,0,.03);">
                        <a href="<?php echo e(route('product.show', $product->id)); ?>" style="text-decoration: none; color: inherit; flex-grow: 1;">
                            <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->product_name); ?>" onerror="this.src='https://via.placeholder.com/150x150?text=No+Image'" style="height: 120px; width: 100%; object-fit: cover; border-radius: 8px; margin-bottom: 8px;">
                            <h4 style="margin: 0 0 6px; font-size: 12px; font-weight: 600; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.3;"><?php echo e($product->product_name); ?></h4>
                            <div class="ud-price" style="margin: 0 0 8px; font-size: 14px; font-weight: 700; color: var(--ud-orange);">₱<?php echo e(number_format($product->price, 2)); ?></div>
                        </a>
                        <form action="<?php echo e(route('cart.add')); ?>" method="POST" style="margin-top: auto;">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="ud-add-cart" style="padding: 6px; width: 100%; font-size: 11px; font-weight: 700; background: var(--ud-orange); color: #fff; border: none; border-radius: 6px; cursor: pointer;">Add to Cart</button>
                        </form>
                    </div>
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
                    <div class="ud-category-card-meta"><?php echo e(collect($category->getAttributes())->has('products_count') ? $category->products_count : $category->products()->count()); ?> products</div>
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

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views\user_dashboard.blade.php ENDPATH**/ ?>