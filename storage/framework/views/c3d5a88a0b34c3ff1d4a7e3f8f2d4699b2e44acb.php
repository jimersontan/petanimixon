<?php $__env->startSection('title', 'Me - Pet Markt-PH'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* ─── Mobile-First "Me" Page Styles ─── */
    .me-page-container {
        background: #f5f5f5;
        min-height: 100vh;
        padding-bottom: 80px; /* space for bottom nav */
    }

    /* Header Section */
    .me-header {
        background: linear-gradient(135deg, var(--ud-orange), #ff9800);
        padding: 30px 20px 20px;
        color: white;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .me-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.4);
        object-fit: cover;
        background: #fff;
    }

    .me-user-info {
        flex: 1;
    }

    .me-user-name {
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 4px;
    }

    .me-user-email {
        font-size: 13px;
        opacity: 0.9;
        margin: 0;
    }

    /* Section Component */
    .me-section {
        background: white;
        margin-top: 12px;
    }

    .me-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .me-section-title {
        font-size: 15px;
        font-weight: 700;
        color: #333;
        margin: 0;
    }

    .me-section-link {
        font-size: 13px;
        color: #888;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Purchases Grid */
    .me-purchases-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        padding: 16px 10px;
    }

    .me-purchase-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        color: #555;
        gap: 8px;
        position: relative;
    }

    .me-purchase-icon {
        width: 28px;
        height: 28px;
        color: #555;
    }

    .me-purchase-label {
        font-size: 11px;
        text-align: center;
        font-weight: 500;
    }

    .me-badge {
        position: absolute;
        top: -6px;
        right: 12px;
        background: #ef4444;
        color: white;
        font-size: 10px;
        font-weight: 700;
        min-width: 16px;
        height: 16px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 4px;
        border: 1px solid white;
    }

    /* Options List */
    .me-options-list {
        display: flex;
        flex-direction: column;
    }

    .me-option-item {
        display: flex;
        align-items: center;
        padding: 16px;
        text-decoration: none;
        color: #333;
        border-bottom: 1px solid #f9f9f9;
        transition: background 0.2s;
    }

    .me-option-item:active {
        background: #f5f5f5;
    }

    .me-option-icon {
        width: 20px;
        height: 20px;
        margin-right: 14px;
    }

    .me-option-icon.primary { color: var(--ud-orange); }
    .me-option-icon.danger { color: #ef4444; }
    .me-option-icon.gray { color: #888; }

    .me-option-text {
        font-size: 14px;
        flex: 1;
    }

    .me-option-arrow {
        color: #ccc;
        width: 16px;
        height: 16px;
    }

    /* Desktop Failsafe */
    @media (min-width: 769px) {
        .me-page-container {
            max-width: 600px;
            margin: 40px auto;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            padding-bottom: 0;
            min-height: auto;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="me-page-container">
    
    <div class="me-header">
        <img src="<?php echo e($user->profile_picture_url); ?>" alt="<?php echo e($user->first_name); ?>" class="me-avatar" onerror="this.src='<?php echo e(asset('images/default_avatar.png')); ?>'">
        <div class="me-user-info">
            <h2 class="me-user-name"><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></h2>
            <p class="me-user-email"><?php echo e($user->email); ?></p>
        </div>
        <a href="<?php echo e(route('profile.edit')); ?>" style="color: white; opacity: 0.9;" aria-label="Settings">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/><circle cx="12" cy="12" r="3"/></svg>
        </a>
    </div>

    
    <div class="me-section">
        <div class="me-section-header">
            <h3 class="me-section-title">My Purchases</h3>
            <a href="<?php echo e(route('orders')); ?>" class="me-section-link">
                View Purchase History
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>
        <div class="me-purchases-grid">
            <a href="<?php echo e(route('orders')); ?>?status=pending" class="me-purchase-item">
                <?php if(($orderStats['pending'] ?? 0) > 0): ?>
                    <div class="me-badge"><?php echo e($orderStats['pending'] > 99 ? '99+' : $orderStats['pending']); ?></div>
                <?php endif; ?>
                <svg class="me-purchase-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                <span class="me-purchase-label">To Pay</span>
            </a>
            <a href="<?php echo e(route('orders')); ?>?status=processing" class="me-purchase-item">
                <?php if(($orderStats['processing'] ?? 0) > 0): ?>
                    <div class="me-badge"><?php echo e($orderStats['processing'] > 99 ? '99+' : $orderStats['processing']); ?></div>
                <?php endif; ?>
                <svg class="me-purchase-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                <span class="me-purchase-label">To Ship</span>
            </a>
            <a href="<?php echo e(route('orders')); ?>?status=out_for_delivery" class="me-purchase-item">
                <?php if(($orderStats['out_for_delivery'] ?? 0) > 0): ?>
                    <div class="me-badge"><?php echo e($orderStats['out_for_delivery'] > 99 ? '99+' : $orderStats['out_for_delivery']); ?></div>
                <?php endif; ?>
                <svg class="me-purchase-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <span class="me-purchase-label">To Receive</span>
            </a>
            <a href="<?php echo e(route('orders')); ?>?status=delivered" class="me-purchase-item">
                <?php if(($orderStats['delivered'] ?? 0) > 0): ?>
                    <div class="me-badge"><?php echo e($orderStats['delivered'] > 99 ? '99+' : $orderStats['delivered']); ?></div>
                <?php endif; ?>
                <svg class="me-purchase-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <span class="me-purchase-label">To Rate</span>
            </a>
        </div>
    </div>

    
    <div class="me-section" style="margin-top: 12px;">
        <div class="me-options-list">
            <a href="<?php echo e(route('wishlist.index')); ?>" class="me-option-item">
                <svg class="me-option-icon primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                <span class="me-option-text">My Wishlist</span>
                <svg class="me-option-arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
            <a href="<?php echo e(route('profile.edit')); ?>" class="me-option-item">
                <svg class="me-option-icon gray" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span class="me-option-text">Account Settings</span>
                <svg class="me-option-arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
            <form id="logoutform" action="<?php echo e(route('logout')); ?>" method="POST" style="display:none;">
                <?php echo csrf_field(); ?>
            </form>
            <a href="javascript:void(0)" onclick="document.getElementById('logoutform').submit()" class="me-option-item">
                <svg class="me-option-icon danger" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span class="me-option-text" style="color: #ef4444;">Logout</span>
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\Pet Markt-PH\resources\views/profile/me.blade.php ENDPATH**/ ?>