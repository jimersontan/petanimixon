<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Pet Markt-PH'); ?></title>

    <link rel="stylesheet" href="<?php echo e(asset('css/user_dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/themes.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/responsive.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/mobile.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/animations.css')); ?>">
    <meta name="search-suggest-url" content="<?php echo e(route('search.suggestions')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="user-dashboard theme-<?php echo e(Auth::check() ? (Auth::user()->color_theme ?? 'citrus_tail') : 'citrus_tail'); ?>">
    <header class="ud-header <?php echo e(View::hasSection('hide-global-header-mobile') ? 'hide-on-mobile' : ''); ?>">
        <div class="ud-header-inner">
            <div class="ud-header-left" style="display: flex; align-items: center; gap: 32px;">
                <a href="<?php echo e(route('shop')); ?>" class="ud-logo" style="display:flex; align-items:center; gap:0; text-decoration:none;">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Pet Markt-PH Logo" style="max-height: 38px; margin-right: -8px;">
                    <span class="ud-logo-text" style="font-size: 24px; color:#1f2937; margin:0;">Pet <span style="color: #ff8a00; font-weight: 700;">Markt-PH</span></span>
                </a>

                <button type="button" class="show-on-mobile-flex" aria-label="Search" onclick="window.openMobSearch()" style="border:none; background:transparent; padding:0; cursor:pointer; color:#555; display:none; align-items:center;">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C8.01 14 6 11.99 6 9.5S8.01 5 10.5 5 15 7.01 15 9.5 12.99 14 10.5 14z"/>
                    </svg>
                </button>


                <nav class="ud-nav hide-on-mobile" style="margin: 0; padding: 0;">
                    <a href="<?php echo e(route('shop')); ?>" class="ud-nav-link <?php echo e(request()->routeIs('shop') ? 'active' : ''); ?>">Home</a>
                    <a href="<?php echo e(route('categories')); ?>" class="ud-nav-link <?php echo e(request()->routeIs('categories*') ? 'active' : ''); ?>">Categories</a>
                    <a href="<?php echo e(route('shop.all')); ?>" class="ud-nav-link <?php echo e(request()->routeIs('shop.all') ? 'active' : ''); ?>">Shop</a>
                    <a href="<?php echo e(route('brands')); ?>" class="ud-nav-link <?php echo e(request()->routeIs('brands*') ? 'active' : ''); ?>">Brands</a>
                </nav>
            </div>

            <div class="ud-header-center" style="display: flex; justify-content: center; flex: 1; margin: 0 24px;">
                <div class="ud-search-bar hide-on-mobile" style="width: 100%; max-width: 420px; position: relative;" id="searchBarWrap">
                    <form action="<?php echo e(route('shop.all')); ?>" method="GET" style="position: relative;" id="searchForm">
                        <button type="submit" class="ud-search-icon" aria-label="Search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #999; background: transparent; border: none; padding: 0; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index:2;">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                                <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C8.01 14 6 11.99 6 9.5S8.01 5 10.5 5 15 7.01 15 9.5 12.99 14 10.5 14z"/>
                            </svg>
                        </button>
                        <input type="text" name="q" class="ud-search-input" id="globalSearchInput" value="<?php echo e(request('q')); ?>" placeholder="Search products, brands..." autocomplete="off" style="width: 100%; padding: 10px 14px 10px 38px; border-radius: 24px; border: 1.5px solid #e8e8e8; background: #f7f7f7; font-size: 13px; transition: all 0.3s;" />
                    </form>
                    
                    <div id="searchSuggestions" style="display:none; position:absolute; top:calc(100% + 10px); left:-40px; right:-40px; background:#fff; border-radius:18px; box-shadow:0 20px 60px rgba(0,0,0,0.18), 0 0 0 1px rgba(0,0,0,0.04); z-index:999; overflow:hidden; max-height:480px;">
                        <div style="padding:16px 20px 10px; border-bottom:1px solid #f0f0f0;">
                            <div style="font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:1.2px; color:#bbb;">🔍 Search Results</div>
                        </div>
                        <div id="searchSuggestionsList" style="overflow-y:auto; max-height:360px; padding:6px 0;"></div>
                        <a href="#" id="searchViewAll" style="display:none; padding:14px 20px; text-align:center; font-size:13px; font-weight:700; color:#ff8a00; text-decoration:none; border-top:1px solid #f0f0f0; background:linear-gradient(180deg, #fefefe, #fafafa);">
                            View all results →
                        </a>
                    </div>
                </div>
            </div>

            <div class="ud-header-right">

                <?php if(auth()->guard()->check()): ?>
                    <div class="ud-header-actions" style="margin: 0; gap: 8px;">
                        <?php echo $__env->make('components.user_notifications', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <a href="<?php echo e(route('wishlist.index')); ?>" class="ud-icon-btn" aria-label="Wishlist" style="text-decoration:none;">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </a>

                        <a href="<?php echo e(route('cart.index')); ?>" class="ud-icon-btn" aria-label="Cart" style="text-decoration:none;">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22">
                                <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                            </svg>
                            <span class="ud-cart-count">0</span>
                        </a>

                        <div class="ud-user-dropdown hide-on-mobile">
                            <button id="udUserBtn" type="button" class="ud-user-btn" style="border: none; background: transparent; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                                <span class="ud-user-name hide-on-mobile" style="font-size: 14px; color: #333;"><?php echo e(Auth::user()->first_name ?? Auth::user()->email); ?></span>
                            </button>
                            <div id="udUserDropdown" class="ud-dropdown-menu">
                                <div class="show-on-mobile" style="display: none;">
                                    <a href="#" style="display: flex; justify-content: space-between; align-items: center;">
                                        Favorites <span class="ud-wishlist-count-badge" style="background:#e91e63; color:white; padding:2px 8px; border-radius:10px; font-size:11px;">0</span>
                                    </a>
                                    <a href="<?php echo e(route('cart.index')); ?>" style="display: flex; justify-content: space-between; align-items: center;">
                                        Cart <span class="ud-cart-count" style="background:#3b7c42; color:white; padding:2px 8px; border-radius:10px; font-size:11px;">0</span>
                                    </a>
                                    <hr style="border:0; border-top:1px solid #f0f0f0; margin: 4px 0;">
                                </div>
                                <a href="<?php echo e(route('profile.edit')); ?>">My Account</a>
                                <a href="<?php echo e(route('orders')); ?>">My Orders</a>
                                <a href="<?php echo e(route('user.notifications')); ?>">Notifications</a>
                                <a href="<?php echo e(route('wishlist.index')); ?>">My Wishlist</a>
                                <?php if(! (Auth::user()->isAdmin() ?? false)): ?>
                                    <a href="<?php echo e(route('returns.index')); ?>">My Returns</a>
                                <?php endif; ?>
                                <a href="<?php echo e(route('faq')); ?>">FAQ</a>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" style="width:100%; text-align:left;">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="ud-auth-btns" style="display: flex; gap: 12px; align-items: center;">
                        <a href="<?php echo e(route('login')); ?>" class="ud-btn ud-btn-outline">Login</a>
                        <a href="<?php echo e(route('register')); ?>" class="ud-btn ud-btn-primary">Sign up</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="ud-main">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <style>
    /* Premium Footer Styles */
    .site-footer-premium {
        background: linear-gradient(145deg, #0b0f19 0%, #161f30 100%);
        color: #e2e8f0;
        padding-top: 60px;
        padding-bottom: 24px;
        position: relative;
        font-family: 'Inter', -apple-system, sans-serif;
        margin-top: 40px;
    }
    .site-footer-premium::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,138,0,0.5), transparent);
    }
    .sfp-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
    }
    /* Main Grid */
    .sfp-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 48px;
        margin-bottom: 60px;
    }
    /* Brand Col */
    .sfp-brand-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        margin-bottom: 24px;
    }
    .sfp-brand-logo img { max-height: 44px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3)); }
    .sfp-brand-logo span {
        font-size: 26px;
        color: #fff;
        font-weight: 400;
        letter-spacing: -0.5px;
    }
    .sfp-brand-logo span strong {
        font-weight: 900;
        color: #ff8a00;
    }
    .sfp-tagline {
        color: #64748b;
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 32px;
        max-width: 340px;
    }
    .sfp-socials {
        display: flex;
        gap: 14px;
    }
    .sfp-social-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #cbd5e1;
        text-decoration: none;
        transition: all 0.3s;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .sfp-social-icon:hover {
        background: #ff8a00;
        color: #fff;
        transform: translateY(-4px);
        border-color: #ff8a00;
        box-shadow: 0 8px 20px rgba(255,138,0,0.3);
    }
    /* Links Cols */
    .sfp-col h4 {
        color: #fff;
        font-size: 17px;
        font-weight: 800;
        margin: 0 0 28px;
        letter-spacing: 0.5px;
    }
    .sfp-col ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .sfp-col ul li { margin-bottom: 16px; }
    .sfp-col ul li a {
        color: #94a3b8;
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
    }
    .sfp-col ul li a::before {
        content: '→';
        margin-right: 8px;
        font-size: 14px;
        color: #ff8a00;
        opacity: 0;
        transform: translateX(-10px);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .sfp-col ul li a:hover {
        color: #fff;
        transform: translateX(6px);
    }
    .sfp-col ul li a:hover::before {
        opacity: 1;
        transform: translateX(0);
    }

    /* Bottom Bar */
    .sfp-bottom {
        border-top: 1px solid rgba(255,255,255,0.08);
        padding-top: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }
    .sfp-copyright {
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
    }
    .sfp-payments {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .sfp-pay-badge {
        height: 28px;
        background: #fff;
        padding: 4px 8px;
        border-radius: 6px;
        opacity: 0.8;
        transition: all 0.2s;
    }
    .sfp-pay-badge:hover { opacity: 1; transform: scale(1.05); }

    @media (max-width: 992px) {
        .sfp-grid { grid-template-columns: 1fr 1fr; gap: 48px; }
    }
    @media (max-width: 576px) {
        .sfp-grid { grid-template-columns: 1fr; gap: 40px; }
        .sfp-bottom { flex-direction: column; text-align: center; justify-content: center; }
    }
    </style>

    <footer class="site-footer-premium">
        <div class="sfp-container">
            
            
            <div class="sfp-grid">
                <div class="sfp-col">
                    <a href="<?php echo e(route('shop')); ?>" class="sfp-brand-logo">
                        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Pet Markt-PH">
                        <span>Pet <strong>Markt-PH</strong></span>
                    </a>
                    <p class="sfp-tagline">
                        Your ultimate destination for premium pet essentials. We provide top-tier care products for your furry, feathered, and scaly companions.
                    </p>
                    <div class="sfp-socials">
                        <a href="#" class="sfp-social-icon" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>
                        </a>
                        <a href="#" class="sfp-social-icon" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6m9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8 1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5 5 5 0 0 1-5 5 5 5 0 0 1-5-5 5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3z"/></svg>
                        </a>
                        <a href="#" class="sfp-social-icon" aria-label="Twitter">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/></svg>
                        </a>
                    </div>
                </div>
                
                <div class="sfp-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="<?php echo e(route('shop')); ?>">Home</a></li>
                        <li><a href="<?php echo e(route('shop.all')); ?>">Shop All</a></li>
                        <li><a href="<?php echo e(route('categories')); ?>">Categories</a></li>
                        <li><a href="<?php echo e(route('brands')); ?>">Our Brands</a></li>
                        <li><a href="<?php echo e(route('vouchers')); ?>">Vouchers & Promos</a></li>
                    </ul>
                </div>

                <div class="sfp-col">
                    <h4>Support</h4>
                    <ul>
                        <li><a href="<?php echo e(route('faq')); ?>">FAQ & Help Center</a></li>
                        <li><a href="<?php echo e(route('contact')); ?>">Contact Us</a></li>
                        <li><a href="<?php echo e(route('shipping')); ?>">Shipping Policy</a></li>
                        <li><a href="<?php echo e(route('returns.index')); ?>">Returns & Refunds</a></li>
                    </ul>
                </div>

                <div class="sfp-col">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="<?php echo e(route('about')); ?>">About Us</a></li>
                        <li><a href="<?php echo e(route('trial')); ?>">Free Trial</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            
            <div class="sfp-bottom">
                <div class="sfp-copyright">
                    &copy; <?php echo e(date('Y')); ?> Pet Markt-PH. All rights reserved.
                </div>
                <div class="sfp-payments">
                    
                    <svg class="sfp-pay-badge" viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" width="38" height="24">
                        <rect width="38" height="24" rx="4" fill="#0057A0" />
                        <text x="19" y="16" fill="#fff" font-family="Arial" font-size="10" font-weight="bold" text-anchor="middle">VISA</text>
                    </svg>
                    <svg class="sfp-pay-badge" viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" width="38" height="24">
                        <rect width="38" height="24" rx="4" fill="#EB001B" />
                        <circle cx="15" cy="12" r="7" fill="#FF5F00" />
                        <circle cx="23" cy="12" r="7" fill="#F79E1B" fill-opacity="0.8" />
                    </svg>
                    <svg class="sfp-pay-badge" viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" width="38" height="24">
                        <rect width="38" height="24" rx="4" fill="#0079C1" />
                        <text x="19" y="15" fill="#fff" font-family="Arial" font-size="9" font-weight="bold" font-style="italic" text-anchor="middle">PayPal</text>
                    </svg>
                </div>
            </div>
        </div>
    </footer>

    
    <?php echo $__env->make('frontend.partials.mobile-bottom-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <?php echo $__env->make('components.support_chat', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <div id="globalProductModal" class="ud-modal-overlay" style="display:none;" onclick="if(event.target===this) window.closeProductModal()">
        <div class="ud-modal-container">
            <button class="ud-modal-close" onclick="window.closeProductModal()">&times;</button>
            <div id="globalProductModalContent" class="ud-modal-body">
                <!-- AJAX Content Injected Here -->
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('js/user_dashboard.js')); ?>"></script>
    <script src="<?php echo e(asset('js/animations.js')); ?>"></script>
    <script src="<?php echo e(asset('js/mobile.js')); ?>"></script>

    
    <script>
    (function() {
        var input = document.getElementById('globalSearchInput');
        var wrap = document.getElementById('searchSuggestions');
        var list = document.getElementById('searchSuggestionsList');
        var viewAll = document.getElementById('searchViewAll');
        var form = document.getElementById('searchForm');
        var timer = null;

        if (!input || !wrap) return;

        input.addEventListener('input', function() {
            clearTimeout(timer);
            var q = this.value.trim();
            if (q.length < 2) {
                wrap.style.display = 'none';
                return;
            }
            timer = setTimeout(function() {
                fetch('<?php echo e(route("search.suggestions")); ?>?q=' + encodeURIComponent(q))
                    .then(function(r) { return r.json(); })
                    .then(function(data) {
                        if (!data || data.length === 0) {
                            list.innerHTML = '<div style="padding:32px 20px; text-align:center; color:#bbb; font-size:14px;"><div style="font-size:28px; margin-bottom:8px;">🔍</div>No products found</div>';
                            viewAll.style.display = 'none';
                            wrap.style.display = 'block';
                            return;
                        }
                        var html = '';
                        for (var i = 0; i < data.length; i++) {
                            var p = data[i];
                            html += '<a href="' + p.url + '" style="display:flex; align-items:center; gap:14px; padding:12px 20px; text-decoration:none; transition:all 0.2s; margin:0;" onmouseover="this.style.background=\'#f8f8f8\'" onmouseout="this.style.background=\'transparent\'">';
                            html += '<img src="' + (p.image || '') + '" style="width:52px; height:52px; border-radius:10px; object-fit:cover; background:#f5f5f5; flex-shrink:0; border:1px solid #eee;" onerror="this.style.display=\'none\'">';
                            html += '<div style="min-width:0; flex:1;">';
                            html += '<div style="font-size:14px; font-weight:700; color:#222; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">' + p.name + '</div>';
                            html += '<div style="font-size:12px; color:#999; margin-top:2px;">' + (p.brand || 'Pet Markt-PH') + '</div>';
                            html += '</div>';
                            html += '<div style="text-align:right; flex-shrink:0; padding-left:8px;">';
                            html += '<div style="font-size:15px; font-weight:800; color:#ff8a00;">₱' + p.price + '</div>';
                            if (p.original_price) {
                                html += '<div style="font-size:11px; color:#ccc; text-decoration:line-through; margin-top:2px;">₱' + p.original_price + '</div>';
                            }
                            html += '</div>';
                            html += '</a>';
                        }
                        list.innerHTML = html;
                        viewAll.href = '<?php echo e(route("shop.all")); ?>?q=' + encodeURIComponent(q);
                        viewAll.style.display = 'block';
                        wrap.style.display = 'block';
                    })
                    .catch(function() {
                        wrap.style.display = 'none';
                    });
            }, 300);
        });

        input.addEventListener('focus', function() {
            if (this.value.trim().length >= 2 && list.innerHTML.trim()) {
                wrap.style.display = 'block';
            }
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('#searchBarWrap')) {
                wrap.style.display = 'none';
            }
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') wrap.style.display = 'none';
        });
    })();
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>

<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\Pet Markt-PH\resources\views/frontend/layouts/app.blade.php ENDPATH**/ ?>