

<?php $__env->startSection('title', 'Brands - Pet Markt-PH'); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* ══════════════════════════════════════════════════════════
   PREMIUM BRANDS PAGE — Pet Markt-PH (Repolished)
   ══════════════════════════════════════════════════════════ */
@import  url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

.brands-page {
    width: 100% !important;
    max-width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
    font-family: 'Inter', -apple-system, sans-serif;
}

/* ── HERO BANNER ── */
.brands-hero {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    padding: 64px 32px 72px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.brands-hero::before {
    content: '';
    position: absolute;
    top: -80px;
    right: -60px;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(255,138,0,0.15) 0%, transparent 70%);
    border-radius: 50%;
}
.brands-hero::after {
    content: '';
    position: absolute;
    bottom: -100px;
    left: -40px;
    width: 250px;
    height: 250px;
    background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, transparent 70%);
    border-radius: 50%;
}
.brands-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,138,0,0.15);
    border: 1px solid rgba(255,138,0,0.3);
    color: #ffb347;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 16px;
}
.brands-hero-title {
    font-size: 36px;
    color: #ffffff;
    margin: 0 0 10px;
    font-weight: 900;
    letter-spacing: -0.5px;
}
.brands-hero-title span {
    background: linear-gradient(135deg, #ff8a00, #e76f51);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.brands-hero-desc {
    font-size: 15px;
    color: rgba(255,255,255,0.6);
    margin: 0 0 28px;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
}

/* ── HERO SEARCH ── */
.brands-search-wrap {
    max-width: 420px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
}
.brands-search-input {
    width: 100%;
    padding: 14px 18px 14px 44px;
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 14px;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
    color: #fff;
    font-size: 14px;
    font-weight: 500;
    outline: none;
    transition: all 0.3s;
}
.brands-search-input::placeholder { color: rgba(255,255,255,0.4); }
.brands-search-input:focus {
    border-color: rgba(255,138,0,0.5);
    background: rgba(255,255,255,0.12);
    box-shadow: 0 0 20px rgba(255,138,0,0.1);
}
.brands-search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255,255,255,0.4);
    pointer-events: none;
}
.brands-hero-wave {
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 50px;
    background: #fafafa;
    clip-path: ellipse(55% 100% at 50% 100%);
}

/* ── STATS BAR ── */
.brands-stats {
    display: flex;
    justify-content: center;
    gap: 48px;
    padding: 28px 16px;
    max-width: 700px;
    margin: 0 auto 8px;
}
.stat-item {
    text-align: center;
}
.stat-value {
    font-size: 28px;
    font-weight: 900;
    color: #1a1a2e;
}
.stat-label {
    font-size: 12px;
    color: #999;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 2px;
}

/* ── CONTENT AREA ── */
.brands-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px 60px;
}

/* ── TABS ── */
.brand-tabs-container {
    margin-bottom: 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}
.brand-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}
.brand-tab {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 8px 20px;
    color: #888;
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.25s;
    border: 1.5px solid #e8e8e8;
    border-radius: 30px;
    background: #fff;
    white-space: nowrap;
}
.brand-tab.active {
    background: linear-gradient(135deg, #ff8a00, #e76f51);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 4px 14px rgba(255,138,0,0.25);
}
.brand-tab:hover:not(.active) {
    border-color: #ff8a00;
    color: #ff8a00;
    transform: translateY(-1px);
}
.brand-count-label {
    font-size: 13px;
    color: #aaa;
    font-weight: 600;
}
.brand-count-label span {
    color: #333;
    font-weight: 800;
}

/* ── GRID ── */
.brands-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
    margin-bottom: 56px;
}

/* ── CARD ── */
.brand-card {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 18px;
    padding: 32px 24px 26px;
    text-align: center;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    overflow: hidden;
    cursor: pointer;
    text-decoration: none;
}
.brand-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #ff8a00, #e76f51);
    opacity: 0;
    transition: opacity 0.35s;
}
.brand-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.08);
    border-color: transparent;
}
.brand-card:hover::before { opacity: 1; }

.brand-logo-wrap {
    height: 90px;
    width: 90px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 18px;
    flex-shrink: 0;
    position: relative;
}

.brand-logo-img {
    width: 82px;
    height: 82px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #f5f5f5;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    transition: transform 0.35s, box-shadow 0.35s;
}
.brand-card:hover .brand-logo-img {
    transform: scale(1.08);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}

.brand-logo-placeholder {
    width: 82px;
    height: 82px;
    border-radius: 50%;
    background: linear-gradient(135deg, #ff8a00 0%, #e76f51 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    font-weight: 900;
    letter-spacing: 1px;
    box-shadow: 0 4px 16px rgba(255,138,0,0.2);
    transition: transform 0.35s;
}
.brand-card:hover .brand-logo-placeholder {
    transform: scale(1.08);
}

.brand-name {
    font-size: 17px;
    font-weight: 800;
    color: #1a1a2e;
    margin: 0 0 6px;
    letter-spacing: -0.3px;
}

.brand-tagline {
    font-size: 13px;
    color: #999;
    margin: 0 0 12px;
    line-height: 1.5;
}

.brand-product-count {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    color: #bbb;
    margin: 0 0 18px;
    font-weight: 600;
    flex-grow: 1;
}

.btn-view-brand {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px 22px;
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    color: #fff;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 13px;
    transition: all 0.25s;
    width: 100%;
    text-align: center;
}
.btn-view-brand:hover {
    background: linear-gradient(135deg, #ff8a00, #e76f51);
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(255,138,0,0.3);
}

/* ── WHY THESE BRANDS ── */
.brands-why-section {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    border-radius: 20px;
    padding: 56px 40px;
    margin-bottom: 56px;
    position: relative;
    overflow: hidden;
}
.brands-why-section::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -40px;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255,138,0,0.1) 0%, transparent 70%);
    border-radius: 50%;
}
.brands-why-title {
    font-size: 26px;
    color: #fff;
    text-align: center;
    margin: 0 0 12px;
    font-weight: 900;
    letter-spacing: -0.5px;
}
.brands-why-subtitle {
    font-size: 14px;
    color: rgba(255,255,255,0.5);
    text-align: center;
    margin: 0 0 40px;
}
.brands-why-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
}
.brands-why-item {
    text-align: center;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    padding: 28px 20px;
    transition: all 0.3s;
}
.brands-why-item:hover {
    background: rgba(255,255,255,0.1);
    transform: translateY(-4px);
}
.brands-why-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    background: rgba(255,138,0,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    font-size: 24px;
}
.brands-why-item h3 {
    font-size: 15px;
    color: #fff;
    margin: 0 0 8px;
    font-weight: 700;
}
.brands-why-item p {
    font-size: 13px;
    color: rgba(255,255,255,0.5);
    margin: 0;
    line-height: 1.6;
}

/* ── FEATURED BRAND ── */
.featured-brand-section {
    background: #fff;
    border-radius: 20px;
    padding: 0;
    box-shadow: 0 4px 24px rgba(0,0,0,0.05);
    margin-bottom: 40px;
    border: 1px solid #f0f0f0;
    overflow: hidden;
}
.featured-brand-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: stretch;
}
.featured-brand-img-wrap {
    background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    min-height: 360px;
    position: relative;
}
.featured-brand-img-wrap::after {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 180px;
    height: 180px;
    background: radial-gradient(circle, rgba(255,138,0,0.2) 0%, transparent 70%);
    border-radius: 50%;
}
.featured-brand-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: relative;
    z-index: 1;
}
.featured-brand-img-wrap .fb-placeholder {
    font-size: 56px;
    font-weight: 900;
    color: rgba(255,255,255,0.15);
    letter-spacing: 4px;
    position: relative;
    z-index: 1;
}
.featured-brand-info {
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 48px 44px;
}
.fb-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: linear-gradient(135deg, #ff8a00, #e76f51);
    color: #fff;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 18px;
    width: fit-content;
}
.fb-name {
    font-size: 30px;
    color: #1a1a2e;
    margin: 0 0 14px;
    font-weight: 900;
    letter-spacing: -0.5px;
}
.fb-desc {
    font-size: 14px;
    color: #777;
    line-height: 1.8;
    margin: 0 0 24px;
}
.fb-features {
    list-style: none;
    padding: 0;
    margin: 0 0 28px;
}
.fb-features li {
    padding: 7px 0;
    font-size: 14px;
    color: #444;
    display: flex;
    align-items: center;
    gap: 10px;
}
.fb-features li::before {
    content: '✓';
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    border-radius: 6px;
    background: rgba(255,138,0,0.1);
    color: #ff8a00;
    font-weight: 800;
    font-size: 12px;
    flex-shrink: 0;
}
.btn-shop-brand {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px 36px;
    background: linear-gradient(135deg, #ff8a00, #e76f51);
    color: #fff;
    text-decoration: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 14px;
    transition: all 0.25s;
    width: fit-content;
    box-shadow: 0 6px 20px rgba(255,138,0,0.25);
}
.btn-shop-brand:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(255,138,0,0.35);
}

.no-brands-msg {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 40px;
    color: #aaa;
    font-size: 15px;
    background: #fafafa;
    border-radius: 16px;
    border: 2px dashed #e8e8e8;
}

/* ── MOBILE ── */
@media (max-width: 768px) {
    .brands-hero { padding: 36px 16px 48px; }
    .brands-hero-title { font-size: 24px; }
    .brands-hero-desc { font-size: 13px; margin-bottom: 20px; }
    .brands-hero-wave { height: 30px; }

    .brands-stats { gap: 24px; padding: 20px 12px; }
    .stat-value { font-size: 22px; }

    .brands-content { padding: 0 14px 40px; }

    .brand-tabs-container { flex-direction: column; align-items: stretch; }
    .brand-tabs { gap: 6px; overflow-x: auto; flex-wrap: nowrap; scrollbar-width: none; padding-bottom: 4px; }
    .brand-tabs::-webkit-scrollbar { display: none; }
    .brand-tab { font-size: 12px; padding: 6px 14px; }
    .brand-count-label { text-align: center; }

    .brands-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 32px; }
    .brand-card { padding: 20px 14px 18px; border-radius: 14px; }
    .brand-logo-wrap { height: 60px; width: 60px; margin-bottom: 12px; }
    .brand-logo-img, .brand-logo-placeholder { width: 56px; height: 56px; font-size: 20px; }
    .brand-name { font-size: 14px; }
    .brand-tagline { display: none; }
    .brand-product-count { font-size: 11px; margin-bottom: 12px; }
    .btn-view-brand { padding: 8px 12px; font-size: 12px; }

    .brands-why-section { padding: 32px 16px; border-radius: 14px; margin-bottom: 32px; }
    .brands-why-title { font-size: 20px; }
    .brands-why-grid { grid-template-columns: 1fr; gap: 14px; }
    .brands-why-item { padding: 20px 16px; }

    .featured-brand-section { margin-bottom: 28px; border-radius: 14px; }
    .featured-brand-grid { grid-template-columns: 1fr; }
    .featured-brand-img-wrap { min-height: 200px; border-radius: 14px 14px 0 0; }
    .featured-brand-info { padding: 28px 20px; text-align: center; }
    .fb-badge { margin-left: auto; margin-right: auto; }
    .fb-name { font-size: 22px; }
    .fb-desc { font-size: 13px; }
    .fb-features { text-align: left; display: inline-block; }
    .btn-shop-brand { width: 100%; text-align: center; justify-content: center; }
}

@media (max-width: 480px) {
    .brands-grid { gap: 8px; }
    .brand-card { padding: 16px 10px 14px; }
    .brand-logo-wrap { height: 50px; width: 50px; }
    .brand-logo-img, .brand-logo-placeholder { width: 46px; height: 46px; font-size: 17px; }
    .brand-name { font-size: 13px; }
    .btn-view-brand { font-size: 11px; padding: 7px 8px; }
    .featured-brand-img-wrap { min-height: 160px; }
    .brands-stats { gap: 16px; }
    .stat-value { font-size: 18px; }
    .stat-label { font-size: 10px; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="brands-page">

    
    <div class="brands-hero">
        <div class="brands-hero-wave"></div>
        <div class="brands-hero-badge">⭐ Curated Selection</div>
        <h1 class="brands-hero-title">Brands We <span>Trust</span> & Carry</h1>
        <p class="brands-hero-desc">Partnering with industry-leading brands committed to quality, safety, and your pet's happiness.</p>
        <div class="brands-search-wrap">
            <svg class="brands-search-icon" viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C8.01 14 6 11.99 6 9.5S8.01 5 10.5 5 15 7.01 15 9.5 12.99 14 10.5 14z"/></svg>
            <input type="text" class="brands-search-input" id="brandSearchInput" placeholder="Search brands..." autocomplete="off">
        </div>
    </div>

    
    <div class="brands-stats">
        <div class="stat-item">
            <div class="stat-value"><?php echo e($brands->count()); ?></div>
            <div class="stat-label">Total Brands</div>
        </div>
        <div class="stat-item">
            <div class="stat-value"><?php echo e($brands->sum('products_count')); ?></div>
            <div class="stat-label">Products</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">100%</div>
            <div class="stat-label">Verified</div>
        </div>
    </div>

    <div class="brands-content">

        
        <div class="brand-tabs-container">
            <div class="brand-tabs">
                <a href="#all" class="brand-tab active" onclick="filterBrands('all', this)">All Brands</a>
                <a href="#top" class="brand-tab" onclick="filterBrands('top', this)">Top Sellers</a>
                <a href="#new" class="brand-tab" onclick="filterBrands('new', this)">New Arrivals</a>
            </div>
            <div class="brand-count-label">Showing <span id="brandVisibleCount"><?php echo e($brands->count()); ?></span> brands</div>
        </div>

        
        <div class="brands-grid" id="brandsGrid">
            <?php $__empty_1 = true; $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="brand-card" data-brand-name="<?php echo e(strtolower($brand->name)); ?>" data-products="<?php echo e($brand->products_count); ?>">
                <div class="brand-logo-wrap">
                    <?php if($brand->logo_path): ?>
                        <img src="<?php echo e($brand->logo_full_url); ?>" alt="<?php echo e($brand->name); ?>" class="brand-logo-img" onerror="this.onerror=null; this.src='<?php echo e(asset('images/placeholder.png')); ?>'">
                    <?php else: ?>
                        <div class="brand-logo-placeholder"><?php echo e(strtoupper(substr($brand->name, 0, 2))); ?></div>
                    <?php endif; ?>
                </div>
                <h3 class="brand-name"><?php echo e($brand->name); ?></h3>
                <p class="brand-tagline">Quality products from <?php echo e($brand->name); ?></p>
                <p class="brand-product-count">📦 <?php echo e($brand->products_count); ?> <?php echo e(Str::plural('product', $brand->products_count)); ?></p>
                <a href="<?php echo e(route('shop.all', ['brand' => $brand->name])); ?>" class="btn-view-brand">
                    View Products →
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="no-brands-msg">No brands available at the moment. Check back soon!</div>
            <?php endif; ?>
        </div>

        
        <div class="brands-why-section">
            <h2 class="brands-why-title">Why These Brands?</h2>
            <p class="brands-why-subtitle">Every brand on Pet Markt-PH passes our rigorous quality standards.</p>
            <div class="brands-why-grid">
                <div class="brands-why-item">
                    <div class="brands-why-icon">🔬</div>
                    <h3>Quality Standards</h3>
                    <p>Every brand is vetted for ingredients, manufacturing practices, and safety certifications.</p>
                </div>
                <div class="brands-why-item">
                    <div class="brands-why-icon">⭐</div>
                    <h3>Proven Track Record</h3>
                    <p>We only partner with brands that have years of positive customer feedback and trust.</p>
                </div>
                <div class="brands-why-item">
                    <div class="brands-why-icon">🌱</div>
                    <h3>Ethical Practices</h3>
                    <p>Committed to animal welfare, sustainable sourcing, and eco-friendly packaging.</p>
                </div>
            </div>
        </div>

        
        <?php if($featuredBrand): ?>
        <div class="featured-brand-section">
            <div class="featured-brand-grid">
                <div>
                    <div class="featured-brand-img-wrap">
                        <?php if($featuredBrand->logo_path): ?>
                            <img src="<?php echo e($featuredBrand->logo_full_url); ?>" alt="<?php echo e($featuredBrand->name); ?>" onerror="this.onerror=null; this.src='<?php echo e(asset('images/placeholder.png')); ?>'">
                        <?php else: ?>
                            <div class="fb-placeholder"><?php echo e(strtoupper(substr($featuredBrand->name, 0, 2))); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="featured-brand-info">
                    <span class="fb-badge">⭐ Featured Brand</span>
                    <h2 class="fb-name"><?php echo e($featuredBrand->name); ?></h2>
                    <p class="fb-desc"><?php echo e($featuredBrand->name); ?> is one of our most trusted partners, providing high-quality, vet-recommended products for your beloved pets. Explore their full range today.</p>
                    <ul class="fb-features">
                        <li>Quality assured & vet-approved</li>
                        <li>Trusted by thousands of pet owners</li>
                        <li>100% pet-friendly materials</li>
                        <li>Sustainable & ethical practices</li>
                    </ul>
                    <a href="<?php echo e(route('shop.all', ['brand' => $featuredBrand->name])); ?>" class="btn-shop-brand">Shop <?php echo e($featuredBrand->name); ?> →</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
(function() {
    var searchInput = document.getElementById('brandSearchInput');
    var grid = document.getElementById('brandsGrid');
    var countLabel = document.getElementById('brandVisibleCount');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            var term = this.value.toLowerCase().trim();
            var cards = grid.querySelectorAll('.brand-card');
            var visible = 0;
            for (var i = 0; i < cards.length; i++) {
                var name = cards[i].getAttribute('data-brand-name') || '';
                if (!term || name.indexOf(term) !== -1) {
                    cards[i].style.display = '';
                    visible++;
                } else {
                    cards[i].style.display = 'none';
                }
            }
            if (countLabel) countLabel.textContent = visible;
        });
    }
})();

function filterBrands(filter, el) {
    // Activate tab
    var tabs = document.querySelectorAll('.brand-tab');
    for (var i = 0; i < tabs.length; i++) tabs[i].classList.remove('active');
    el.classList.add('active');

    var cards = document.querySelectorAll('#brandsGrid .brand-card');
    var visible = 0;

    for (var i = 0; i < cards.length; i++) {
        var products = parseInt(cards[i].getAttribute('data-products')) || 0;
        var show = true;

        if (filter === 'top') {
            show = products >= 3;
        } else if (filter === 'new') {
            show = products < 3;
        }

        cards[i].style.display = show ? '' : 'none';
        if (show) visible++;
    }

    var countLabel = document.getElementById('brandVisibleCount');
    if (countLabel) countLabel.textContent = visible;

    return false;
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Pet Markt-PH\resources\views/frontend/brands.blade.php ENDPATH**/ ?>