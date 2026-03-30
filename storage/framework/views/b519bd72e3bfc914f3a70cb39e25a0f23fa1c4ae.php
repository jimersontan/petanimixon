<header class="front-header">
    <div class="container">
        <div class="brand">
            <a href="<?php echo e(route('home')); ?>" class="brand-logo">
                <span class="brand-emoji">🐾</span>
                <span class="brand-text">Pet Animixon</span>
            </a>
        </div>
        <nav class="nav">
            <a href="<?php echo e(route('home')); ?>" class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Home</a>
            <a href="<?php echo e(route('categories')); ?>" class="nav-link <?php echo e(request()->routeIs('categories') ? 'active' : ''); ?>">Categories</a>
            <a href="<?php echo e(route('shop')); ?>" class="nav-link <?php echo e(request()->routeIs('shop') ? 'active' : ''); ?>">Shop</a>
            <a href="<?php echo e(route('brands')); ?>" class="nav-link <?php echo e(request()->routeIs('brands') ? 'active' : ''); ?>">Brands</a>
            <a href="<?php echo e(route('faq')); ?>" class="nav-link <?php echo e(request()->routeIs('faq') ? 'active' : ''); ?>">FAQ</a>
            <a href="<?php echo e(route('contact')); ?>" class="nav-link <?php echo e(request()->routeIs('contact') ? 'active' : ''); ?>">Contact</a>
        </nav>

        <div class="nav-actions">
            <?php if(auth()->guard()->check()): ?>
                <div class="user-menu">
                    <button type="button" class="btn btn-outline" id="frontendUserBtn">
                        <?php echo e(Auth::user()->first_name ?? Auth::user()->name ?? Auth::user()->email); ?>

                        <span class="ml-2">▼</span>
                    </button>
                    <div class="user-menu-dropdown" id="frontendUserDropdown">
                        <a href="<?php echo e(route('orders')); ?>">My Orders</a>
                        <a href="<?php echo e(route('home')); ?>">Home</a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-secondary" style="width:100%;">Logout</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-secondary">Sign In</a>
                <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">Register</a>
            <?php endif; ?>
        </div>

        <button class="mobile-menu-toggle" aria-label="Toggle menu" aria-expanded="false">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
    </div>

    <div class="mobile-menu" aria-hidden="true">
        <a href="<?php echo e(route('home')); ?>" class="mobile-link">Home</a>
        <a href="<?php echo e(route('categories')); ?>" class="mobile-link">Categories</a>
        <a href="<?php echo e(route('shop')); ?>" class="mobile-link">Shop</a>
        <a href="<?php echo e(route('brands')); ?>" class="mobile-link">Brands</a>
        <a href="<?php echo e(route('faq')); ?>" class="mobile-link">FAQ</a>
        <a href="<?php echo e(route('contact')); ?>" class="mobile-link">Contact</a>
        <div class="mobile-actions">
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('orders')); ?>" class="btn btn-secondary">My Orders</a>
                <form method="POST" action="<?php echo e(route('logout')); ?>" style="width:100%;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-secondary" style="width:100%;">Logout</button>
                </form>
            <?php endif; ?>
            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-secondary">Sign In</a>
                <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">Register</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<?php /**PATH C:\xampp\htdocs\Petverse\petverse\resources\views/frontend/partials/header.blade.php ENDPATH**/ ?>