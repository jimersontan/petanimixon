

<?php $__env->startSection('title', 'Pet Markt-PH - Premium Pet Essentials'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Most Sold Carousel */
    .hm-most-sold-section {
        background: #fff;
        padding: 24px 0;
        margin-top: 20px;
    }
    .ms-carousel-container {
        position: relative;
        overflow: hidden;
        padding: 10px 4px;
    }
    .ms-carousel-track {
        display: flex;
        transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        gap: 16px;
    }
    .ms-carousel-slide {
        flex: 0 0 calc(100% / 3 - 11px);
        min-width: calc(100% / 3 - 11px);
    }
    .hm-carousel-btn-mini {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #4b5563;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 14px;
    }
    .hm-carousel-btn-mini:hover {
        background: var(--ud-orange);
        color: #fff;
        border-color: var(--ud-orange);
        box-shadow: 0 4px 10px rgba(255, 136, 68, 0.3);
    }

    /* Life Stage Section */
    .hm-life-stage-section {
        background: linear-gradient(135deg, #fefce8 0%, #fef3c7 100%);
        border-radius: 16px;
        padding: 32px 24px;
        margin: 32px 12px;
        text-align: center;
        border: 1px solid #fde68a;
    }
    .ls-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-top: 24px;
    }
    .ls-card {
        background: #fff;
        border-radius: 14px;
        padding: 20px 16px;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        border: 1px solid rgba(0,0,0,0.03);
        box-shadow: 0 4px 12px rgba(251, 191, 36, 0.1);
    }
    .ls-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(251, 191, 36, 0.2);
        border-color: #fbbf24;
    }
    .ls-icon {
        font-size: 32px;
        margin-bottom: 12px;
        display: block;
    }
    .ls-name {
        font-size: 15px;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 4px;
        display: block;
    }
    .ls-desc {
        font-size: 11px;
        color: #78716c;
        line-height: 1.4;
    }

    .hm-pc-add-btn {
        margin-top: 10px;
        padding: 8px 12px;
        background: var(--ud-orange);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .hm-pc-add-btn:hover {
        background: var(--ud-orange-dark);
        transform: scale(1.02);
    }

    @media (max-width: 768px) {
        .ms-carousel-slide {
            flex: 0 0 calc(100% / 2 - 8px);
            min-width: calc(100% / 2 - 8px);
        }
        .ls-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .ls-card { padding: 16px 12px; }
    }
    @media (max-width: 480px) {
        .ms-carousel-slide {
            flex: 0 0 100%;
            min-width: 100%;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('message')): ?>
        <div class="ud-msg"><?php echo e(session('message')); ?></div>
    <?php endif; ?>

    <div class="hm-container">
        
        
        <section class="hm-hero-section">
            <div class="hm-hero-main">
                <div class="hm-carousel" id="hm-main-carousel">
                    <?php 
                        $slides = ($heroProducts ?? collect())->take(5);
                        if ($slides->isEmpty()) {
                            $slides = collect([(object)['id'=>1, 'product_name'=>'Premium Pet Food', 'image_url'=>asset('images/default.png'), 'price'=>0, 'original_price'=>0, 'average_rating'=>5]]);
                        }
                        $slideBadges = ['🔥 HOT DEALS', '⭐ TOP RATED', '💎 BEST SELLER', '🎯 TRENDING', '✨ NEW ARRIVAL'];
                        $slideSubtitles = [
                            'Limited time offer — Don\'t miss out!',
                            'Loved by thousands of pet parents',
                            'Most popular choice this month',
                            'Rising star in pet nutrition',
                            'Fresh from our latest collection'
                        ];
                    ?>
                    <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $hp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="hm-slide <?php echo e($index === 0 ? 'active' : ''); ?>">
                            
                            <div class="hm-slide-decor">
                                <div class="hm-slide-circle hm-slide-circle-1"></div>
                                <div class="hm-slide-circle hm-slide-circle-2"></div>
                            </div>
                            <div class="hm-slide-content">
                                <span class="hm-slide-badge"><?php echo e($slideBadges[$index % count($slideBadges)]); ?></span>
                                <h1 class="hm-slide-title"><?php echo e(Str::limit($hp->product_name, 45)); ?></h1>
                                <p class="hm-slide-subtitle"><?php echo e($slideSubtitles[$index % count($slideSubtitles)]); ?></p>
                                <div class="hm-slide-pricing">
                                    <span class="hm-slide-price">₱<?php echo e(number_format($hp->price, 0)); ?></span>
                                    <?php if(isset($hp->original_price) && $hp->original_price > $hp->price): ?>
                                        <span class="hm-slide-original">₱<?php echo e(number_format($hp->original_price, 0)); ?></span>
                                        <span class="hm-slide-discount">-<?php echo e(round((1 - $hp->price / $hp->original_price) * 100)); ?>%</span>
                                    <?php endif; ?>
                                </div>
                                <div class="hm-slide-rating" <?php echo (!isset($hp->average_rating) || $hp->average_rating == 0) ? 'style="opacity: 0.6;"' : ''; ?>>
                                    <?php $rating = $hp->average_rating ?? 0; ?>
                                    <?php for($s = 1; $s <= 5; $s++): ?>
                                        <span class="hm-star <?php echo e($s <= round($rating) && $rating > 0 ? 'filled' : ''); ?>">★</span>
                                    <?php endfor; ?>
                                    <span class="hm-rating-text"><?php echo e(number_format($rating, 1)); ?></span>
                                </div>
                                <a href="<?php echo e(route('product.show', $hp->id)); ?>" class="hm-btn hm-btn-primary" onclick="window.openProductModal(<?php echo e($hp->id); ?>, event)">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                    Shop Now
                                </a>
                            </div>
                            <div class="hm-slide-image">
                                <div class="hm-slide-image-glow"></div>
                                <img src="<?php echo e($hp->image_url); ?>" alt="<?php echo e($hp->product_name); ?>"
                                    onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 150 150%22%3E%3Crect width=%22150%22 height=%22150%22 fill=%22%23f5f5f5%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2214%22 fill=%22%23bbb%22%3ENo Image%3C/text%3E%3C/svg%3E';">
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <button class="hm-carousel-btn prev" onclick="moveSlide(-1)">❮</button>
                    <button class="hm-carousel-btn next" onclick="moveSlide(1)">❯</button>
                    <div class="hm-carousel-dots">
                        <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $hp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="hm-dot <?php echo e($index === 0 ? 'active' : ''); ?>" onclick="goToSlide(<?php echo e($index); ?>)"></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="hm-hero-side">
                <?php 
                    $sideBanners = isset($promoCoupons) && $promoCoupons->count() >= 2 
                        ? $promoCoupons->take(2)->map(fn($p) => $p->featuredProduct) 
                        : ($featuredSaleProducts ?? collect())->take(2);
                    $sideTags = ['🎟️ VOUCHER', '🔥 MEGA SALE'];
                    $sideSubtitles = ['Save big on every order', 'Flash deal — limited stock!'];
                ?>
                
                <?php $__currentLoopData = $sideBanners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $sb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($sb): ?>
                <a href="<?php echo e(route('product.show', $sb->id)); ?>" class="hm-side-banner hm-side-banner-<?php echo e($idx + 1); ?>" onclick="window.openProductModal(<?php echo e($sb->id); ?>, event)">
                    <div class="hm-sb-decor"></div>
                    <div class="hm-sb-content">
                        <span class="hm-sb-tag"><?php echo e($sideTags[$idx] ?? 'DEAL'); ?></span>
                        <h3 class="hm-sb-title"><?php echo e(Str::limit($sb->product_name, 30)); ?></h3>
                        <p class="hm-sb-subtitle"><?php echo e($sideSubtitles[$idx] ?? ''); ?></p>
                        <div class="hm-sb-pricing">
                            <span class="hm-sb-price">₱<?php echo e(number_format($sb->price, 0)); ?></span>
                            <?php if(isset($sb->original_price) && $sb->original_price > $sb->price): ?>
                                <span class="hm-sb-discount">-<?php echo e(round((1 - $sb->price / $sb->original_price) * 100)); ?>%</span>
                            <?php endif; ?>
                        </div>
                        <span class="hm-sb-link">Grab it &rarr;</span>
                    </div>
                    <div class="hm-sb-image">
                        <img src="<?php echo e($sb->image_url); ?>" alt="<?php echo e($sb->product_name); ?>"
                             onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 150 150%22%3E%3Crect width=%22150%22 height=%22150%22 fill=%22transparent%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2214%22 fill=%22%23bbb%22%3ENo Image%3C/text%3E%3C/svg%3E';">
                    </div>
                </a>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>

        
        <section class="hm-trust-strip">
            <div class="hm-trust-item">
                <div class="hm-trust-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 8v4l3 3"></path></svg>
                </div>
                <div class="hm-trust-text">
                    <strong>24/7 Support</strong>
                    <span>Dedicated assistance</span>
                </div>
            </div>
            <div class="hm-trust-item">
                <div class="hm-trust-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                </div>
                <div class="hm-trust-text">
                    <strong>Fast Shipping</strong>
                    <span>Nationwide delivery</span>
                </div>
            </div>
            <div class="hm-trust-item">
                <div class="hm-trust-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </div>
                <div class="hm-trust-text">
                    <strong>100% Authentic</strong>
                    <span>Guaranteed quality</span>
                </div>
            </div>
            <div class="hm-trust-item">
                <div class="hm-trust-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                </div>
                <div class="hm-trust-text">
                    <strong>Secure Payment</strong>
                    <span>100% encrypted</span>
                </div>
            </div>
        </section>

        
        <section class="hm-section hm-categories-section">
            <div class="hm-section-header">
                <h2 class="hm-section-title">Shop by Category</h2>
                <a href="<?php echo e(route('shop.all')); ?>" class="hm-section-link">View All &rarr;</a>
            </div>
            <div class="hm-category-grid">
                <?php $__empty_1 = true; $__currentLoopData = $animalTypes ?? collect(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $at): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('shop.all', ['pet_type' => [$at->animal_type]])); ?>" class="hm-category-item">
                    <div class="hm-cat-icon">
                        <?php if($at->image_url): ?>
                            <img src="<?php echo e($at->image_full_url); ?>" alt="<?php echo e($at->animal_type); ?>" onerror="this.onerror=null; this.src='<?php echo e(asset('images/placeholder.png')); ?>'; this.style.objectFit='contain';">
                        <?php else: ?>
                            <span>🐾</span>
                        <?php endif; ?>
                    </div>
                    <span class="hm-cat-name"><?php echo e($at->animal_type); ?></span>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p>No categories configured.</p>
                <?php endif; ?>
            </div>
        </section>

        
        <section class="hm-section hm-life-stage-section">
            <h2 class="hm-section-title" style="font-size: 1.6rem; color: #92400e;">Tailored by Life Stage</h2>
            <p style="color: #b45309; font-size: 14px; margin-top: 4px;">Premium nutrition for every milestone in your pet's life</p>
            
            <div class="ls-grid">
                <?php $__currentLoopData = $lifeStages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ls): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('shop.all', ['life_stage[]' => $ls['slug']])); ?>" class="ls-card">
                    <span class="ls-icon"><?php echo e($ls['icon']); ?></span>
                    <span class="ls-name"><?php echo e($ls['name']); ?></span>
                    <span class="ls-desc"><?php echo e($ls['desc']); ?></span>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>

        
        <?php if(isset($saleProducts) && $saleProducts->count() > 0): ?>
        <section class="hm-section hm-flash-sale-section">
            <div class="hm-section-header hm-flash-header">
                <div class="hm-flash-title">
                    <h2 class="hm-section-title">⚡ Flash Deals</h2>
                    <div class="hm-flash-timer">
                        <span class="hm-time-box">12</span> : <span class="hm-time-box">45</span> : <span class="hm-time-box">00</span>
                    </div>
                </div>
                <a href="<?php echo e(route('shop.all', ['discount' => 'on_sale'])); ?>" class="hm-section-link">See All Deals &rarr;</a>
            </div>
            
            <div class="hm-product-scroller">
                <?php $__currentLoopData = $saleProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saleProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="hm-product-card hm-flash-card">
                    <div class="hm-pc-image" onclick="window.openProductModal(<?php echo e($saleProduct->id); ?>, event)">
                        <img src="<?php echo e($saleProduct->image_url); ?>" alt="<?php echo e($saleProduct->product_name); ?>"
                             onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 150 150%22%3E%3Crect width=%22150%22 height=%22150%22 fill=%22%23f5f5f5%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-family=%22Arial%22 font-size=%2214%22 fill=%22%23bbb%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22%3ENo Image%3C/text%3E%3C/svg%3E';">
                        <?php
                            $discountLabel = 'SALE';
                            if ($saleProduct->discount_type === 'percent' && $saleProduct->discount_amount > 0) {
                                $discountLabel = '-' . (int)$saleProduct->discount_amount . '%';
                            }
                        ?>
                        <span class="hm-badge hm-badge-sale"><?php echo e($discountLabel); ?></span>
                    </div>
                    <div class="hm-pc-info">
                        <h3 class="hm-pc-title" onclick="window.openProductModal(<?php echo e($saleProduct->id); ?>, event)"><?php echo e($saleProduct->product_name); ?></h3>
                        <div class="hm-pc-price-row">
                            <?php
                                $salePrice = $saleProduct->price;
                                if ($saleProduct->discount_type === 'percent' && $saleProduct->discount_amount > 0) {
                                    $salePrice = $saleProduct->price * (1 - ($saleProduct->discount_amount / 100));
                                } elseif ($saleProduct->discount_type === 'fixed' && $saleProduct->discount_amount > 0) {
                                    $salePrice = max(0, $saleProduct->price - $saleProduct->discount_amount);
                                }
                            ?>
                            <span class="hm-price-current">₱<?php echo e(number_format((float)$salePrice, 2)); ?></span>
                            <span class="hm-price-old">₱<?php echo e(number_format((float)$saleProduct->price, 2)); ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>
        <?php endif; ?>

        
        <section class="hm-section hm-most-sold-section" style="padding: 0 12px;">
            <div class="hm-section-header">
                <h2 class="hm-section-title">🔥 Most Sold Products</h2>
                <div style="display: flex; gap: 8px;">
                    <button class="hm-carousel-btn-mini" onclick="moveMS(-1)" aria-label="Previous">←</button>
                    <button class="hm-carousel-btn-mini" onclick="moveMS(1)" aria-label="Next">→</button>
                </div>
            </div>

            <div class="ms-carousel-container">
                <div class="ms-carousel-track" id="msTrack">
                    <?php $__currentLoopData = $bestSellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="ms-carousel-slide">
                        <div class="hm-product-card">
                            <div class="hm-pc-image" onclick="window.openProductModal(<?php echo e($product->id); ?>, event)">
                                <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->product_name); ?>"
                                     onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 150 150%22%3E%3Crect width=%22150%22 height=%22150%22 fill=%22%23f5f5f5%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-family=%22Arial%22 font-size=%2214%22 fill=%22%23bbb%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22%3ENo Image%3C/text%3E%3C/svg%3E';">
                                <span class="hm-badge" style="background: #ef4444; color: #fff; right: 8px; top: 8px;">TOP SELLER</span>
                            </div>
                            <div class="hm-pc-info">
                                <h3 class="hm-pc-title" onclick="window.openProductModal(<?php echo e($product->id); ?>, event)"><?php echo e($product->product_name); ?></h3>
                                <div class="hm-pc-price-row">
                                    <span class="hm-price-current">₱<?php echo e(number_format((float)$product->price, 2)); ?></span>
                                </div>
                                <?php if(auth()->guard()->check()): ?>
                                <button class="hm-pc-add-btn" onclick="event.stopPropagation(); window.quickAddToCart(<?php echo e($product->id); ?>)">Add to Cart</button>
                                <?php else: ?>
                                <a href="<?php echo e(route('login')); ?>" class="hm-pc-add-btn" style="text-decoration:none; text-align:center;">Add to Cart</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
        
        <section class="hm-section hm-latest-section">
            <div class="hm-section-header" style="justify-content: center;">
                <h2 class="hm-section-title" style="font-size: 1.8rem; color: var(--ud-orange);">Just For You</h2>
            </div>
            <div class="hm-product-grid">
                <?php $__empty_1 = true; $__currentLoopData = $latestProducts ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php /** @var \App\Models\Product $product */ ?>
                    <div class="hm-product-card">
                        <div class="hm-pc-image" onclick="window.openProductModal(<?php echo e($product->id); ?>, event)">
                            <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->product_name); ?>"
                                 onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 150 150%22%3E%3Crect width=%22150%22 height=%22150%22 fill=%22%23f5f5f5%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-family=%22Arial%22 font-size=%2214%22 fill=%22%23bbb%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22%3ENo Image%3C/text%3E%3C/svg%3E';">
                            <?php if($product->is_featured): ?>
                                <span class="hm-badge hm-badge-featured">HOT</span>
                            <?php endif; ?>
                            <?php if($product->is_sale_active): ?>
                                <span class="hm-badge hm-badge-sale">
                                    <?php echo e($product->discount_type === 'percent' ? '-' . (int)$product->discount_amount . '%' : 'SALE'); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="hm-pc-info">
                            <h3 class="hm-pc-title" onclick="window.openProductModal(<?php echo e($product->id); ?>, event)"><?php echo e($product->product_name); ?></h3>
                            
                            <?php
                                $pReviewCount = $product->reviews()->count();
                                $pReviewAvg = $product->avg_rating > 0 ? $product->avg_rating : 0;
                                $roundedAvg = round($pReviewAvg);
                                $pFmt = $pReviewCount >= 1000 ? round($pReviewCount / 1000, 1) . 'k' : $pReviewCount;
                            ?>
                            <div class="hm-pc-rating">
                                <div class="hm-stars-wrap" style="--rating: <?php echo e($pReviewAvg); ?>;" title="<?php echo e(number_format($pReviewAvg, 1)); ?> out of 5"></div>
                                <span class="hm-count">(<?php echo e($pFmt); ?>)</span>
                            </div>

                            <div class="hm-pc-price-row" style="margin-bottom: 8px;">
                                <?php if($product->is_sale_active): ?>
                                    <span class="hm-price-current">₱<?php echo e(number_format((float)$product->sale_price, 2)); ?></span>
                                    <span class="hm-price-old">₱<?php echo e(number_format((float)$product->price, 2)); ?></span>
                                <?php else: ?>
                                    <span class="hm-price-current">₱<?php echo e(number_format((float)$product->price, 2)); ?></span>
                                <?php endif; ?>
                                <span class="hm-sold-count"><?php echo e($product->total_sold ?? 0); ?> Sold</span>
                            </div>

                            <?php if(auth()->guard()->check()): ?>
                                <?php if($product->variants && $product->variants->where('uom', '!=', null)->count() > 0): ?>
                                    <button type="button" class="hm-btn hm-btn-outline hm-btn-block" style="margin-top:auto;" onclick="window.openProductModal(<?php echo e($product->id); ?>, event)">
                                        Select Options
                                    </button>
                                <?php else: ?>
                                    <form action="<?php echo e(route('cart.add')); ?>" method="POST" style="margin-top:auto;">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="hm-btn hm-btn-outline hm-btn-block" <?php echo e($product->stock > 0 ? '' : 'disabled'); ?>>
                                            <?php echo e($product->stock > 0 ? 'Add to Cart' : 'Out of Stock'); ?>

                                        </button>
                                    </form>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="<?php echo e(route('login')); ?>" class="hm-btn hm-btn-outline hm-btn-block" style="text-align:center;">Add to Cart</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #888;">
                        <p>No products available at the moment.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div style="text-align: center; margin-top: 32px;">
                <a href="<?php echo e(route('shop.all')); ?>" class="hm-btn hm-btn-secondary" style="padding: 12px 32px; font-size: 16px;">View All Products</a>
            </div>
        </section>

    </div>

    
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hm-slide');
        const dots = document.querySelectorAll('.hm-dot');
        const carousel = document.getElementById('hm-main-carousel');
        let slideInterval;

        function showSlide(index) {
            if (!slides || slides.length === 0) return;
            dots[currentSlide].classList.remove('active');
            
            currentSlide = (index + slides.length) % slides.length;
            
            dots[currentSlide].classList.add('active');
            carousel.style.transform = 'translateX(-' + (currentSlide * 100) + '%)';
        }

        function moveSlide(dir) {
            showSlide(currentSlide + dir);
            resetInterval();
        }

        function goToSlide(index) {
            showSlide(index);
            resetInterval();
        }

        function resetInterval() {
            clearInterval(slideInterval);
            slideInterval = setInterval(() => moveSlide(1), 5000);
        }

        if (slides.length > 0) {
            slideInterval = setInterval(() => moveSlide(1), 5000);
        }
    </script>
    <?php $__env->startPush('scripts'); ?>
    <script>
        // Most Sold Carousel Logic
        let msIndex = 0;
        const msTrack = document.getElementById('msTrack');
        
        window.moveMS = function(direction) {
            const container = document.querySelector('.ms-carousel-container');
            const slide = document.querySelector('.ms-carousel-slide');
            if (!msTrack || !slide) return;
            
            const slideWidth = slide.offsetWidth + 16; // width + gap
            const visibleSlides = Math.floor(container.offsetWidth / slideWidth) || 1;
            const totalSlides = msTrack.children.length;
            const maxIndex = totalSlides - visibleSlides;
            
            msIndex += direction;
            if (msIndex < 0) msIndex = maxIndex;
            if (msIndex > maxIndex) msIndex = 0;
            
            msTrack.style.transform = `translateX(-${msIndex * slideWidth}px)`;
        };

        window.quickAddToCart = function(productId) {
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', 1);
            formData.append('_token', '<?php echo e(csrf_token()); ?>');

            fetch('<?php echo e(route("cart.add")); ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok) {
                    if (window.showToast) window.showToast("Added to cart! ✓");
                    else alert("Added to cart!");
                } else if (response.status === 401) {
                    window.location.href = "<?php echo e(route('login')); ?>";
                }
            })
            .catch(error => console.error('Error:', error));
        };
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Pet Markt-PH\resources\views/user_dashboard.blade.php ENDPATH**/ ?>