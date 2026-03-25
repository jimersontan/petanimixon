<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Petverse'); ?></title>

    <link rel="stylesheet" href="<?php echo e(asset('css/user_dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/responsive.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="user-dashboard">
    <header class="ud-header">
        <div class="ud-header-inner">
            <a href="<?php echo e(route('shop')); ?>" class="ud-logo" style="display:flex; align-items:center; text-decoration:none;">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Pet Animixon Logo" style="max-height: 38px; margin-right: 8px;">
                <span class="ud-logo-text" style="font-size: 24px; color:#1f2937;">Pet <span style="color: #ff8a00; font-weight: 700;">Animixon</span></span>
            </a>

            <nav class="ud-nav">
                <a href="<?php echo e(route('shop')); ?>" class="ud-nav-link <?php echo e(request()->routeIs('shop') ? 'active' : ''); ?>">Home</a>
                <a href="<?php echo e(route('categories')); ?>" class="ud-nav-link <?php echo e(request()->routeIs('categories*') ? 'active' : ''); ?>">Categories</a>
                <a href="<?php echo e(route('shop.all')); ?>" class="ud-nav-link <?php echo e(request()->routeIs('shop.all') ? 'active' : ''); ?>">Shop</a>
                <a href="<?php echo e(route('brands')); ?>" class="ud-nav-link <?php echo e(request()->routeIs('brands*') ? 'active' : ''); ?>">Brands</a>
            </nav>

            <div class="ud-search-bar">
                <span class="ud-search-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C8.01 14 6 11.99 6 9.5S8.01 5 10.5 5 15 7.01 15 9.5 12.99 14 10.5 14z"/>
                    </svg>
                </span>
                <input type="text" class="ud-search-input" placeholder="Search products..." />
            </div>

            <?php if(auth()->guard()->check()): ?>
                <div class="ud-header-actions">
                    <button type="button" class="ud-icon-btn hide-on-mobile" aria-label="Favorites">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>

                    <a href="<?php echo e(route('cart.index')); ?>" class="ud-icon-btn hide-on-mobile" aria-label="Cart" style="text-decoration:none;">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22">
                            <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                        </svg>
                        <span class="ud-cart-count">0</span>
                    </a>

                    <div class="ud-user-dropdown">
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
                                    Cart <span class="ud-cart-count" style="background:#FF8844; color:white; padding:2px 8px; border-radius:10px; font-size:11px;">0</span>
                                </a>
                                <hr style="border:0; border-top:1px solid #f0f0f0; margin: 4px 0;">
                            </div>
                            <a href="<?php echo e(route('profile.edit')); ?>">My Account</a>
                            <?php if(! (Auth::user()->isAdmin() ?? false)): ?>
                                <a href="<?php echo e(route('orders')); ?>">My Orders</a>
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

    
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-col footer-brand">
                <a href="<?php echo e(route('shop')); ?>" class="footer-logo">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Pet Animixon" style="max-height:36px;">
                    <span>Pet <strong>Animixon</strong></span>
                </a>
                <p class="footer-tagline">Your one-stop shop for premium pet products. Quality care for every furry, feathered & scaly friend.</p>
                <div class="footer-socials">
                    <a href="#" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg></a>
                    <a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6m9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8 1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5 5 5 0 0 1-5 5 5 5 0 0 1-5-5 5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3z"/></svg></a>
                    <a href="#" aria-label="Twitter / X"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/></svg></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="<?php echo e(route('shop')); ?>">Home</a></li>
                    <li><a href="<?php echo e(route('shop.all')); ?>">Shop</a></li>
                    <li><a href="<?php echo e(route('categories')); ?>">Categories</a></li>
                    <li><a href="<?php echo e(route('brands')); ?>">Brands</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Support</h4>
                <ul>
                    <li><a href="<?php echo e(route('faq')); ?>">FAQ</a></li>
                    <li><a href="<?php echo e(route('contact')); ?>">Contact Us</a></li>
                    <li><a href="<?php echo e(route('shipping')); ?>">Shipping Info</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="<?php echo e(route('about')); ?>">About Us</a></li>
                    <li><a href="<?php echo e(route('trial')); ?>">Free Trial</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo e(date('Y')); ?> Pet Animixon. All rights reserved.</p>
        </div>
    </footer>

    
    <nav class="mobile-bottom-nav">
        <a href="<?php echo e(route('shop')); ?>" class="bottom-nav-item <?php echo e(request()->routeIs('shop') ? 'active' : ''); ?>">
            <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
            <span>Home</span>
        </a>
        <a href="<?php echo e(route('categories')); ?>" class="bottom-nav-item <?php echo e(request()->routeIs('categories*') ? 'active' : ''); ?>">
            <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z"/></svg>
            <span>Categories</span>
        </a>
        <a href="<?php echo e(route('shop.all')); ?>" class="bottom-nav-item <?php echo e(request()->routeIs('shop.all') ? 'active' : ''); ?>">
            <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M18.36 9l.6 3H5.04l.6-3h12.72M20 4H4v2h16V4zm0 3H4l-1 5v2h1v6h10v-6h4v6h2v-6h1v-2l-1-5zM6 18v-4h6v4H6z"/></svg>
            <span>Shop</span>
        </a>
        <a href="<?php echo e(route('cart.index')); ?>" class="bottom-nav-item <?php echo e(request()->routeIs('cart.index') ? 'active' : ''); ?>">
            <div class="bottom-nav-icon-wrap">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
                <span class="bottom-nav-badge ud-cart-count-mobile">0</span>
            </div>
            <span>Cart</span>
        </a>
        <?php if(auth()->guard()->check()): ?>
        <a href="<?php echo e(route('profile.edit')); ?>" class="bottom-nav-item <?php echo e(request()->routeIs('profile*') ? 'active' : ''); ?>">
            <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            <span>Account</span>
        </a>
        <?php else: ?>
        <a href="<?php echo e(route('login')); ?>" class="bottom-nav-item">
            <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            <span>Login</span>
        </a>
        <?php endif; ?>
    </nav>

    
    <div id="globalProductModal" class="ud-modal-overlay" style="display:none;" onclick="if(event.target===this) window.closeProductModal()">
        <div class="ud-modal-container">
            <button class="ud-modal-close" onclick="window.closeProductModal()">&times;</button>
            <div id="globalProductModalContent" class="ud-modal-body">
                <!-- AJAX Content Injected Here -->
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('js/user_dashboard.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/frontend/layouts/app.blade.php ENDPATH**/ ?>