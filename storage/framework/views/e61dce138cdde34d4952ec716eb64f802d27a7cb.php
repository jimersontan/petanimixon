<!-- ===== ADMIN SETTINGS PAGE ===== -->
<!-- Extends the main admin layout -->


<?php $__env->startSection('title', 'Settings'); ?>

<!-- ===== CSS STYLES (pushed to layout head) ===== -->
<?php $__env->startPush('styles'); ?>
<style>
    /* ===== PAGE BACKGROUND ===== */
    /* Override body background to light gray */
    body.dashboard-body {
        background-color: #f5f5f5 !important;
    }
    
    .settings-header-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
    }
    
    .settings-header-top h1 {
        margin: 0 0 6px 0;
        font-size: 24px;
        color: #111827;
        font-weight: 700;
    }
    
    .settings-header-top p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }
    
    .btn-global-save {
        background-color: var(--ud-orange-dark);
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-global-save:hover {
        background-color: #c2410c;
    }
    
    /* ===== SETTINGS WRAPPER: Sidebar + Main Content side by side ===== */
    .settings-wrapper {
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }
    
    /* ===== SETTINGS SIDEBAR: Left navigation card ===== */
    .settings-sidebar {
        width: 260px;
        background: #ffffff;
        flex-shrink: 0;
        padding: 24px 0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    
    .settings-group {
        margin-bottom: 24px;
    }
    
    .settings-group:last-child {
        margin-bottom: 0;
    }
    
    .settings-group-label {
        font-size: 11px;
        text-transform: uppercase;
        color: #9ca3af;
        font-weight: 700;
        letter-spacing: 0.05em;
        padding: 0 24px;
        margin-bottom: 10px;
    }
    
    .settings-nav {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .settings-nav-item {
        display: flex;
        align-items: center;
        width: 100%;
        text-align: left;
        padding: 10px 24px;
        color: #4b5563;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
        background: none;
        border-top: none;
        border-right: none;
        border-bottom: none;
    }
    
    .settings-nav-item svg {
        margin-right: 12px;
        color: #9ca3af;
        width: 16px;
        height: 16px;
    }
    
    /* For items without an icon, indent text to match */
    .settings-nav-item.no-icon {
        padding-left: 52px; 
    }
    
    .settings-nav-item:hover {
        background-color: #f9fafb;
    }
    
    .settings-nav-item.active {
        background-color: #fff7ed;
        color: var(--ud-orange-dark);
        border-left: 3px solid var(--ud-orange-dark);
        font-weight: 600;
    }
    
    .settings-nav-item.active svg {
        color: var(--ud-orange-dark);
    }
    
    /* ===== MAIN CONTENT PANEL: Right side form panels ===== */
    .settings-main {
        flex: 1;
        max-width: 800px;
    }

    .settings-panel {
        background: #ffffff;
        padding: 32px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        display: none;
    }

    .settings-panel.active {
        display: block;
    }
    
    .panel-header-block {
        display: flex;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .panel-header-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #fff7ed;
        color: var(--ud-orange-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
    }
    
    .panel-header-icon svg {
        width: 20px;
        height: 20px;
    }
    
    .panel-header-text h2 {
        margin: 0 0 4px 0;
        font-size: 15px;
        color: #111827;
        font-weight: 700;
    }
    
    .panel-header-text p {
        margin: 0;
        font-size: 12px;
        color: #9ca3af;
    }
    
    /* ===== FORM INPUT STYLES ===== */
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #374151;
        margin-bottom: 8px;
    }
    
    .settings-input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        color: #1f2937;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        background: #fff;
        box-sizing: border-box;
    }
    
    .settings-input:focus {
        outline: none;
        border-color: var(--ud-orange-dark);
        box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1);
    }
    
    textarea.settings-input {
        resize: vertical;
        min-height: 80px;
        font-family: inherit;
    }
    
    .help-text {
        font-size: 12px;
        color: #6b7280;
        margin-top: 6px;
    }
    
    /* ===== DRAG AND DROP: Logo upload area ===== */
    .drag-drop-box {
        border: 1px dashed #d1d5db;
        border-radius: 6px;
        padding: 24px;
        text-align: center;
        background: #f9fafb;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .drag-drop-box:hover {
        background: #f3f4f6;
        border-color: #9ca3af;
    }
    
    .drag-drop-box svg {
        color: #9ca3af;
        margin-bottom: 8px;
    }
    
    .drag-drop-title {
        font-size: 13px;
        color: #4b5563;
        font-weight: 500;
        margin-bottom: 2px;
    }
    
    .drag-drop-subtitle {
        font-size: 11px;
        color: #9ca3af;
    }
    
    .image-preview-wrapper {
        margin-top: 12px;
        display: none;
        align-items: center;
        gap: 12px;
    }
    
    .image-preview-wrapper img {
        max-height: 60px;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
    }
    
    .remove-image-btn {
        font-size: 12px;
        color: #ef4444;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
    }
    
    .remove-image-btn:hover {
        text-decoration: underline;
    }

    .store-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }
    .grid-column {
        display: flex;
        flex-direction: column;
    }
    .panel-footer {
        display: flex;
        justify-content: flex-end;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #f3f4f6;
    }
    .form-group {
        margin-bottom: 16px; /* slightly smaller to fit screen */
    }
    .btn-save-changes {
        background-color: var(--ud-orange-dark);
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-save-changes:hover {
        background-color: #c2410c;
    }
</style>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<!-- ===== FLASH MESSAGES ===== -->
<!-- Success message after saving settings -->
<?php if(session('success')): ?>
    <div class="alert alert-success" style="margin-bottom: 20px;"><?php echo e(session('success')); ?></div>
<?php endif; ?>
<!-- Error message if save failed -->
<?php if(session('error')): ?>
    <div class="alert alert-danger" style="margin-bottom: 20px;"><?php echo e(session('error')); ?></div>
<?php endif; ?>
<!-- ===== END FLASH MESSAGES ===== -->

<!-- ===== SETTINGS WRAPPER: Two-column layout ===== -->
<div class="settings-wrapper">

    <!-- ===== SETTINGS SIDEBAR ===== -->
    <!-- Left-side navigation card with grouped setting categories -->
    <aside class="settings-sidebar">
        <!-- Sidebar Group: General Settings -->
        <div class="settings-group">
            <div class="settings-group-label">General</div>
            <ul class="settings-nav">
                <li><button type="button" class="settings-nav-item active" data-section="store-information">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    Store Information
                </button></li>
                <li><button type="button" class="settings-nav-item" data-section="currency">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                    Currency
                </button></li>
                <li><button type="button" class="settings-nav-item" data-section="tax-settings">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.92-5.27l-3.26-1.55"></path></svg>
                    Tax Settings
                </button></li>
                <li><button type="button" class="settings-nav-item no-icon" data-section="invoice">
                    Invoices
                </button></li>
            </ul>
        </div>
        
        <!-- Sidebar Group: Payments -->
        <div class="settings-group">
            <div class="settings-group-label">Payments</div>
            <ul class="settings-nav">
                <li><button type="button" class="settings-nav-item" data-section="payment-gateways">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                    Payment Gateways
                </button></li>
            </ul>
        </div>
        
        <!-- Sidebar Group: Shipping -->
        <div class="settings-group">
            <div class="settings-group-label">Shipping</div>
            <ul class="settings-nav">
                <li><button type="button" class="settings-nav-item" data-section="shipping-zones">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    Shipping Zones
                </button></li>
                <li><button type="button" class="settings-nav-item" data-section="rates-fees">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    Rates & Fees
                </button></li>
            </ul>
        </div>
        
        <!-- Sidebar Group: Users and Roles -->
        <div class="settings-group">
            <div class="settings-group-label">Users & Roles</div>
            <ul class="settings-nav">
                <li><a href="<?php echo e(route('admin.users')); ?>" class="settings-nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    Admin Accounts
                </a></li>
            </ul>
        </div>
        
        <!-- Sidebar Group: Notifications -->
        <div class="settings-group">
            <div class="settings-group-label">Notification</div>
            <ul class="settings-nav">
                <li><button type="button" class="settings-nav-item" data-section="email-templates">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    Email Templates
                </button></li>
            </ul>
        </div>
        

        
        <!-- Sidebar Group: Security -->
        <div class="settings-group">
            <div class="settings-group-label">Security</div>
            <ul class="settings-nav">
                <li><button type="button" class="settings-nav-item" data-section="password-policy">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    Password Policy
                </button></li>
                <li><button type="button" class="settings-nav-item" data-section="login-logs">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                    Login Logs
                </button></li>
            </ul>
        </div>
    </aside>
    <!-- ===== END SETTINGS SIDEBAR ===== -->

    <!-- ===== SETTINGS MAIN CONTENT ===== -->
    <!-- Right-side panels that show/hide based on sidebar selection -->
    <main class="settings-main">
        <?php
            $s = $settings ?? new \App\Models\StoreSetting();
            $extra = $s->extra ?? [];
        ?>

        <!-- ===== PANEL: Store Information (default active) ===== -->
        <!-- Form: Store name, email, phone, URL, description, logo upload -->
        <section class="settings-panel active" id="panel-store-information">
            <div class="panel-header-block">
                <div class="panel-header-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </div>
                <div class="panel-header-text">
                    <h2>General Store Settings</h2>
                    <p>Basic store information</p>
                </div>
            </div>
            
            <form method="post" action="<?php echo e(route('settings.admin.update')); ?>" enctype="multipart/form-data" id="form-store-information">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_section" value="store">
                
                <div class="store-info-grid">
                    <!-- Left Column -->
                    <div class="grid-column">
                        <div class="form-group">
                            <label for="store_name">Store Name</label>
                            <input type="text" id="store_name" name="store_name" class="settings-input" value="<?php echo e(old('store_name', $s->store_name ?? '')); ?>" placeholder="e.g. Pet Markt-PH">
                        </div>
                        
                        <div class="form-group">
                            <label for="store_email">Store Email</label>
                            <input type="email" id="store_email" name="store_email" class="settings-input" value="<?php echo e(old('store_email', $s->store_email ?? '')); ?>" placeholder="support@petmarkt-ph.com">
                        </div>
                        
                        <div class="form-group">
                            <label for="store_phone">Store Phone</label>
                            <input type="text" id="store_phone" name="store_phone" class="settings-input" value="<?php echo e(old('store_phone', $s->store_phone ?? '')); ?>" placeholder="+63 (0000000000) PET-CARE">
                        </div>
                        
                        <div class="form-group">
                            <label for="store_url">Store URL</label>
                            <input type="text" id="store_url" name="store_url" class="settings-input" value="<?php echo e(old('store_url', $s->store_url ?? '')); ?>" placeholder="www.petmarkt-ph.com">
                        </div>
                        
                        <div class="form-group" style="flex: 1; display:flex; flex-direction:column;">
                            <label for="store_description">Store Description</label>
                            <textarea id="store_description" name="store_description" class="settings-input" placeholder="Your trusted pet products marketplace" style="flex: 1; min-height: 80px; resize: none;"><?php echo e(old('store_description', $s->store_description ?? '')); ?></textarea>
                        </div>
                        
                        <div class="form-group" style="flex: 1; display:flex; flex-direction:column;">
                            <label for="store_address">Store Address</label>
                            <textarea id="store_address" name="store_address" class="settings-input" placeholder="e.g. 123 Pet Street, Dog City" style="flex: 1; min-height: 80px; resize: none;"><?php echo e(old('store_address', $extra['store_address'] ?? '')); ?></textarea>
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="grid-column">
                        <div class="form-group" style="flex: 1; display:flex; flex-direction:column;">
                            <label>Store Logo</label>
                            <div class="drag-drop-box" id="drag-drop-trigger" style="flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                <div class="drag-drop-title">Click to upload or drag & drop</div>
                                <div class="drag-drop-subtitle">PNG, JPG up to 2MB</div>
                            </div>
                            <input type="file" id="store_logo" name="store_logo" accept="image/png, image/jpeg, image/jpg" style="display:none;">
                            
                            <div class="image-preview-wrapper" id="logo-preview-wrapper" style="<?php echo e(!empty($s->store_logo_path) ? 'display:flex;' : 'margin-top:0;'); ?>">
                                <img id="logo-preview-img" src="<?php echo e(!empty($s->store_logo_path) ? $s->logo_full_url : ''); ?>" alt="Logo Preview">
                                <span class="remove-image-btn" id="remove-logo-btn">Remove</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="timezone">Timezone</label>
                            <select id="timezone" name="timezone" class="settings-input">
                                <?php $__currentLoopData = ['Asia/Manila'=>'GMT+8','Asia/Tokyo'=>'GMT+9','America/New_York'=>'GMT-5','Europe/London'=>'GMT+0','UTC'=>'UTC']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tz => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tz); ?>" <?php echo e(old('timezone', $s->timezone ?? 'Asia/Manila') == $tz ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="default_currency">Default Currency</label>
                            <select id="default_currency" name="default_currency" class="settings-input">
                                <?php $__currentLoopData = ['PHP'=>'₱ PHP - Philippine Peso (₱)','USD'=>'$ USD - US Dollar ($)','EUR'=>'€ EUR - Euro (€)','GBP'=>'£ GBP - British Pound (£)']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($code); ?>" <?php echo e(old('default_currency', $s->default_currency ?? 'PHP') == $code ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="panel-footer">
                    <button type="submit" class="btn-save-changes">
                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </section>

        <!-- ===== PANEL: Currency Configuration ===== -->
        <!-- Form: Primary currency, decimal places, symbol position -->
        <section class="settings-panel" id="panel-currency">
            <div class="panel-header-block">
                <div class="panel-header-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                </div>
                <div class="panel-header-text">
                    <h2>Currency Configuration</h2>
                    <p>Format rules and secondary currencies</p>
                </div>
            </div>
            <form method="post" action="<?php echo e(route('settings.admin.update')); ?>" id="form-currency">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_section" value="currency">
                <div class="form-group">
                    <label for="primary_currency">Primary Currency Code</label>
                    <select name="primary_currency" class="settings-input">
                        <?php $__currentLoopData = ['PHP','USD','EUR','GBP']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c); ?>" <?php echo e(($extra['primary_currency'] ?? 'PHP') == $c ? 'selected' : ''); ?>><?php echo e($c); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="decimal_places">Decimal Places</label>
                    <input type="number" name="decimal_places" class="settings-input" min="0" max="4" value="<?php echo e($extra['decimal_places'] ?? 2); ?>">
                </div>
                <div class="form-group">
                    <label for="currency_symbol_position">Symbol Position</label>
                    <select name="currency_symbol_position" class="settings-input">
                        <option value="before" <?php echo e(($extra['currency_symbol_position'] ?? 'before') == 'before' ? 'selected' : ''); ?>>Before amount</option>
                        <option value="after" <?php echo e(($extra['currency_symbol_position'] ?? '') == 'after' ? 'selected' : ''); ?>>After amount</option>
                    </select>
                </div>

                <div class="panel-footer">
                    <button type="submit" class="btn-save-changes">
                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </section>

        <!-- Other forms can be structured similarly inside their sections with an ID corresponding to "form-<section>" -->
        <!-- ===== PANEL: Tax Settings ===== -->
        <!-- Form: Enable tax, rate percentage, tax label -->
        <section class="settings-panel" id="panel-tax-settings">
            <div class="panel-header-block">
                <div class="panel-header-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.92-5.27l-3.26-1.55"></path></svg>
                </div>
                <div class="panel-header-text">
                    <h2>Tax Settings</h2>
                    <p>Sales tax computation rules</p>
                </div>
            </div>
            <form method="post" action="<?php echo e(route('settings.admin.update')); ?>" id="form-tax-settings">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_section" value="tax">
                <div class="form-group">
                    <label for="tax_enabled">Enable Tax</label>
                    <select name="tax_enabled" class="settings-input">
                        <option value="1" <?php echo e(($extra['tax_enabled'] ?? '1') == '1' ? 'selected' : ''); ?>>Yes</option>
                        <option value="0" <?php echo e(($extra['tax_enabled'] ?? '') == '0' ? 'selected' : ''); ?>>No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tax_rate">Tax Rate (%)</label>
                    <input type="number" name="tax_rate" class="settings-input" step="0.01" min="0" max="100" value="<?php echo e($extra['tax_rate'] ?? 12); ?>">
                </div>
                <div class="form-group">
                    <label for="tax_name">Tax Label Name</label>
                    <input type="text" name="tax_name" class="settings-input" value="<?php echo e($extra['tax_name'] ?? 'VAT'); ?>">
                </div>

                <div class="panel-footer">
                    <button type="submit" class="btn-save-changes">
                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </section>
        
        <!-- ===== PANEL: Invoice Settings ===== -->
        <!-- Form: Invoice prefix, starting number, payment terms -->
        <section class="settings-panel" id="panel-invoice">
            <div class="panel-header-block">
                <div class="panel-header-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <div class="panel-header-text">
                    <h2>Invoice Settings</h2>
                    <p>Configure invoice numbering and terms</p>
                </div>
            </div>
            <form method="post" action="<?php echo e(route('settings.admin.update')); ?>" id="form-invoice">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_section" value="invoice">
                <div class="form-group">
                    <label for="invoice_prefix">Invoice Prefix</label>
                    <input type="text" name="invoice_prefix" class="settings-input" value="<?php echo e($extra['invoice_prefix'] ?? 'INV-'); ?>" placeholder="INV-">
                </div>
                <div class="form-group">
                    <label for="invoice_start">Starting Invoice Number</label>
                    <input type="number" name="invoice_start" class="settings-input" min="1" value="<?php echo e($extra['invoice_start'] ?? 1); ?>">
                </div>
                <div class="form-group">
                    <label for="invoice_terms">Default Payment Terms</label>
                    <textarea name="invoice_terms" class="settings-input" placeholder="e.g. Net 30"><?php echo e($extra['invoice_terms'] ?? 'Net 30'); ?></textarea>
                </div>

                <div class="panel-footer">
                    <button type="submit" class="btn-save-changes">
                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </section>
        <!-- ===== PANEL: Payment Gateways ===== -->
        <!-- Form: Checkboxes for COD, Bank Transfer, Online Payment -->
        <section class="settings-panel" id="panel-payment-gateways">
            <div class="panel-header-block">
                <div class="panel-header-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                </div>
                <div class="panel-header-text">
                    <h2>Payment Gateways</h2>
                    <p>Manage accepted payment methods</p>
                </div>
            </div>
            <form method="post" action="<?php echo e(route('settings.admin.update')); ?>" id="form-payment-gateways">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_section" value="payment">
                <div class="form-group">
                    <label><input type="checkbox" name="gateway_cod" value="1" <?php echo e(($extra['gateway_cod'] ?? '1') == '1' ? 'checked' : ''); ?>> Cash on Delivery (COD)</label>
                </div>
                <div class="form-group">
                    <label for="gateway_instructions">Payment Instructions</label>
                    <textarea name="gateway_instructions" class="settings-input" rows="3" placeholder="Instructions for customers"><?php echo e($extra['gateway_instructions'] ?? ''); ?></textarea>
                </div>

                <div class="panel-footer">
                    <button type="submit" class="btn-save-changes">
                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </section>

        <!-- ===== PANEL: Shipping Zones ===== -->
        <!-- Form: Local, national, international shipping rates -->
        <section class="settings-panel" id="panel-shipping-zones">
            <div class="panel-header-block">
                <div class="panel-header-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                </div>
                <div class="panel-header-text">
                    <h2>Shipping Zones</h2>
                    <p>Configure regional shipping rates</p>
                </div>
            </div>
            <form method="post" action="<?php echo e(route('settings.admin.update')); ?>" id="form-shipping-zones">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_section" value="shipping_zones">
                <div class="form-group">
                    <label for="zone_local">Local (Same City) - Rate</label>
                    <input type="number" name="zone_local" class="settings-input" step="0.01" min="0" value="<?php echo e($extra['zone_local'] ?? 50); ?>">
                </div>
                <div class="form-group">
                    <label for="zone_national">National (Philippines) - Rate</label>
                    <input type="number" name="zone_national" class="settings-input" step="0.01" min="0" value="<?php echo e($extra['zone_national'] ?? 150); ?>">
                </div>
                <div class="form-group">
                    <label for="zone_international">International - Rate</label>
                    <input type="number" name="zone_international" class="settings-input" step="0.01" min="0" value="<?php echo e($extra['zone_international'] ?? 500); ?>">
                </div>

                <div class="panel-footer">
                    <button type="submit" class="btn-save-changes">
                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </section>

        <!-- ===== PANEL: Rates and Fees ===== -->
        <!-- Form: Free shipping minimum, handling fee -->
        <section class="settings-panel" id="panel-rates-fees">
            <div class="panel-header-block">
                <div class="panel-header-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                </div>
                <div class="panel-header-text">
                    <h2>Rates & Fees</h2>
                    <p>Manage shipping rules and handling fees</p>
                </div>
            </div>
            <form method="post" action="<?php echo e(route('settings.admin.update')); ?>" id="form-rates-fees">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_section" value="rates_fees">
                <div class="form-group">
                    <label for="free_shipping_min">Free Shipping Minimum Order</label>
                    <input type="number" name="free_shipping_min" class="settings-input" step="0.01" min="0" value="<?php echo e($extra['free_shipping_min'] ?? 0); ?>">
                    <p class="help-text">Order total for free shipping (0 = disabled)</p>
                </div>
                <div class="form-group">
                    <label for="handling_fee">Handling Fee</label>
                    <input type="number" name="handling_fee" class="settings-input" step="0.01" min="0" value="<?php echo e($extra['handling_fee'] ?? 0); ?>">
                </div>

                <div class="panel-footer">
                    <button type="submit" class="btn-save-changes">
                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </section>

        <!-- ===== PANEL: Email Templates ===== -->
        <!-- Form: Order confirmation subject, from name -->
        <section class="settings-panel" id="panel-email-templates">
            <div class="panel-header-block">
                <div class="panel-header-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                </div>
                <div class="panel-header-text">
                    <h2>Email Templates</h2>
                    <p>Customize automated email notifications</p>
                </div>
            </div>
            <form method="post" action="<?php echo e(route('settings.admin.update')); ?>" id="form-email-templates">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_section" value="email_templates">
                <div class="form-group">
                    <label for="email_order_confirmation">Order Confirmation Subject</label>
                    <input type="text" name="email_order_confirmation" class="settings-input" value="<?php echo e($extra['email_order_confirmation'] ?? 'Order Confirmed - #ORDER_ID#'); ?>">
                    <p class="help-text">Use #ORDER_ID# as a placeholder for the order number.</p>
                </div>
                <div class="form-group">
                    <label for="email_from_name">From Name</label>
                    <input type="text" name="email_from_name" class="settings-input" value="<?php echo e($extra['email_from_name'] ?? ($s->store_name ?? 'Pet Markt-PH')); ?>">
                </div>

                <div class="panel-footer">
                    <button type="submit" class="btn-save-changes">
                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </section>

        <!-- ===== PANEL: Password Policy ===== -->
        <!-- Form: Minimum length, uppercase requirement, expiry days -->
        <section class="settings-panel" id="panel-password-policy">
            <div class="panel-header-block">
                <div class="panel-header-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                </div>
                <div class="panel-header-text">
                    <h2>Password Policy</h2>
                    <p>Security rules for user passwords</p>
                </div>
            </div>
            <form method="post" action="<?php echo e(route('settings.admin.update')); ?>" id="form-password-policy">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_section" value="password_policy">
                <div class="form-group">
                    <label for="password_min_length">Minimum Length</label>
                    <input type="number" name="password_min_length" class="settings-input" min="6" max="32" value="<?php echo e($extra['password_min_length'] ?? 8); ?>">
                </div>
                <div class="form-group">
                    <label><input type="checkbox" name="password_require_upper" value="1" <?php echo e(($extra['password_require_upper'] ?? '1') == '1' ? 'checked' : ''); ?>> Require uppercase letter</label>
                </div>
                <div class="form-group">
                    <label><input type="checkbox" name="password_require_number" value="1" <?php echo e(($extra['password_require_number'] ?? '1') == '1' ? 'checked' : ''); ?>> Require number</label>
                </div>
                <div class="form-group">
                    <label for="password_expiry_days">Password expiry (days)</label>
                    <input type="number" name="password_expiry_days" class="settings-input" min="0" value="<?php echo e($extra['password_expiry_days'] ?? 0); ?>">
                    <p class="help-text">0 = never expire</p>
                </div>

                <div class="panel-footer">
                    <button type="submit" class="btn-save-changes">
                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </section>

        <!-- ===== PANEL: Login Logs ===== -->
        <!-- Form: Enable/disable login audit trail -->
        <section class="settings-panel" id="panel-login-logs">
            <div class="panel-header-block">
                <div class="panel-header-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                </div>
                <div class="panel-header-text">
                    <h2>Login Logs</h2>
                    <p>Audit trail for admin access</p>
                </div>
            </div>
            <form method="post" action="<?php echo e(route('settings.admin.update')); ?>" id="form-login-logs">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_section" value="login_logs">
                <div class="form-group">
                    <label for="login_logs_enabled">Enable Login Logging</label>
                    <select name="login_logs_enabled" class="settings-input">
                        <option value="0" <?php echo e(($extra['login_logs_enabled'] ?? '0') == '0' ? 'selected' : ''); ?>>No</option>
                        <option value="1" <?php echo e(($extra['login_logs_enabled'] ?? '') == '1' ? 'selected' : ''); ?>>Yes</option>
                    </select>
                    <p class="help-text">Log IP, time, and user for each admin login</p>
                </div>

                <div class="panel-footer">
                    <button type="submit" class="btn-save-changes">
                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </section>
    </main>
    <!-- ===== END SETTINGS MAIN CONTENT ===== -->

</div>
<!-- ===== END SETTINGS WRAPPER ===== -->

<!-- ===== JAVASCRIPT (pushed to layout scripts) ===== -->
<?php $__env->startPush('scripts'); ?>
<script>
/**
 * ===== SETTINGS PAGE JAVASCRIPT =====
 * Handles: Sidebar tab switching, URL sync, and logo drag-and-drop upload
 */
document.addEventListener('DOMContentLoaded', function() {
    // ===== SIDEBAR NAV SWITCHING =====
    // Click a sidebar item to show its corresponding panel
    const navItems = document.querySelectorAll('.settings-nav-item[data-section]');
        const panels = document.querySelectorAll('.settings-panel');

        navItems.forEach(item => {
            item.addEventListener('click', function() {
                const section = this.getAttribute('data-section');
                
                navItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                
                panels.forEach(p => p.classList.remove('active'));
                const targetPanel = document.getElementById('panel-' + section);
                if (targetPanel) {
                    targetPanel.classList.add('active');
                }
                
                if (window.history && window.history.replaceState) {
                    window.history.replaceState(null, '', '?section=' + section);
                }
            });
        });

    const urlParams = new URLSearchParams(window.location.search);
    const activeSection = urlParams.get('section');
        if (activeSection) {
            const targetItem = document.querySelector(`.settings-nav-item[data-section="${activeSection}"]`);
            if (targetItem) {
                targetItem.click();
            }
        }
    // ===== DRAG AND DROP LOGO UPLOAD =====
    // Click or drag-and-drop to upload a store logo image
    const dragDropBox = document.getElementById('drag-drop-trigger');
    const fileInput = document.getElementById('store_logo');
    const previewWrapper = document.getElementById('logo-preview-wrapper');
    const previewImg = document.getElementById('logo-preview-img');
    const removeBtn = document.getElementById('remove-logo-btn');
        
        if (dragDropBox && fileInput) {
            dragDropBox.addEventListener('click', () => {
                fileInput.click();
            });
            
            dragDropBox.addEventListener('dragover', (e) => {
                e.preventDefault();
                dragDropBox.style.borderColor = 'var(--ud-orange-dark)';
                dragDropBox.style.backgroundColor = '#fff7ed';
            });
            
            dragDropBox.addEventListener('dragleave', (e) => {
                e.preventDefault();
                dragDropBox.style.borderColor = '#d1d5db';
                dragDropBox.style.backgroundColor = '#f9fafb';
            });
            
            dragDropBox.addEventListener('drop', (e) => {
                e.preventDefault();
                dragDropBox.style.borderColor = '#d1d5db';
                dragDropBox.style.backgroundColor = '#f9fafb';
                
                if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                    fileInput.files = e.dataTransfer.files;
                    updateImagePreview(e.dataTransfer.files[0]);
                }
            });
            
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    updateImagePreview(this.files[0]);
                }
            });

            function updateImagePreview(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewWrapper.style.display = 'flex';
                };
                reader.readAsDataURL(file);
            }
            
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    fileInput.value = '';
                    previewWrapper.style.display = 'none';
                });
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Pet Markt-PH\resources\views/admin_settings.blade.php ENDPATH**/ ?>