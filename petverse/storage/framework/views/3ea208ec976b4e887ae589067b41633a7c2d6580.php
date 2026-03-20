<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Petverse'); ?></title>

    <link rel="stylesheet" href="<?php echo e(asset('css/user_dashboard.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="user-dashboard">
    <header class="ud-header">
        <div class="ud-header-inner">
            <a href="<?php echo e(route('shop')); ?>" class="ud-logo" style="display:flex; align-items:center; text-decoration:none;">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" style="max-height: 38px; margin-right: 8px;">
                <span class="ud-logo-text" style="color:#1f2937;">Pet <span style="color: #ff8a00; font-weight: 700;">Animixon</span></span>
            </a>

            <nav class="ud-nav">
                <a href="<?php echo e(route('shop')); ?>" class="ud-nav-link <?php echo e(request()->routeIs('shop') ? 'active' : ''); ?>">Home</a>
                <a href="<?php echo e(route('categories')); ?>" class="ud-nav-link <?php echo e(request()->routeIs('categories*') ? 'active' : ''); ?>">Categories</a>
                <a href="<?php echo e(route('shop.all')); ?>" class="ud-nav-link <?php echo e(request()->routeIs('shop.all') ? 'active' : ''); ?>">Shop</a>
                <a href="#" class="ud-nav-link">Contact</a>
                <a href="<?php echo e(route('brands')); ?>" class="ud-nav-link <?php echo e(request()->routeIs('brands*') ? 'active' : ''); ?>">Brands</a>
                <a href="#" class="ud-nav-link">FAQ</a>
                <a href="#" class="ud-nav-link">About</a>
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

    <script src="<?php echo e(asset('js/user_dashboard.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\petverse\resources\views/frontend/layouts/app.blade.php ENDPATH**/ ?>