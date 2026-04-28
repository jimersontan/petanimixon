<!-- ===== BRAND FORM PARTIAL ===== -->
<!-- Used for both Create and Edit modals/pages -->

<?php
    $brand = $brand ?? new \App\Models\Brand();
?>

<!-- Form Validation Errors -->
<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<!-- ===== TWO-PANEL FORM LAYOUT ===== -->
<div class="form-two-panel">

    <!-- ===== LEFT PANEL: Main Brand Details ===== -->
    <div class="form-panel-left">

        <!-- Brand Name Field -->
        <div class="form-group">
            <label for="name">Brand Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo e(old('name', $brand->name)); ?>" required placeholder="e.g. Purina, Royal Canin">
        </div>

        <!-- Website URL Field -->
        <div class="form-group">
            <label for="website_url">Website URL</label>
            <div style="position: relative;">
                <span style="position: absolute; left: 12px; top: 10px; color: #9ca3af;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                </span>
                <input type="url" name="website_url" id="website_url" class="form-control" value="<?php echo e(old('website_url', $brand->website_url)); ?>" placeholder="https://www.example.com" style="padding-left: 36px;">
            </div>
        </div>

        <!-- Description Field -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="5" placeholder="Brief description of this brand"><?php echo e(old('description', $brand->description)); ?></textarea>
        </div>

    </div>
    <!-- ===== END LEFT PANEL ===== -->

    <!-- Visual Divider between panels -->
    <div class="form-divider"></div>

    <!-- ===== RIGHT PANEL: Logo and Status ===== -->
    <div class="form-panel-right">

        <!-- Logo Upload Field -->
        <div class="form-group">
            <label for="logo">Brand Logo</label>
            <div class="paste-upload-zone brand-logo-upload" tabindex="0">
                <button type="button" class="remove-file-btn" title="Remove">✕</button>
                <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 16V4m0 0l-4 4m4-4l4 4M4 18h16" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <div class="upload-title">Click to upload or paste image</div>
                <div class="upload-hint">Drag & drop, browse, or press <kbd>Ctrl</kbd>+<kbd>V</kbd> to paste</div>
                <input type="file" name="logo" id="logo" accept="image/*" style="display:none;">
                <div class="upload-preview">
                    <?php if(!empty($brand->logo_path)): ?>
                        <img src="<?php echo e($brand->logo_full_url); ?>" alt="<?php echo e($brand->name); ?> logo">
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Status and Featured Row -->
        <div class="form-row" style="display: flex; gap: 15px;">
            <!-- Active Status Field -->
            <div class="form-group" style="flex: 1;">
                <label for="is_active">Status</label>
                <select name="is_active" id="is_active" class="form-control">
                    <option value="1" <?php echo e(old('is_active', $brand->is_active ?? 1) == 1 ? 'selected' : ''); ?>>Active</option>
                    <option value="0" <?php echo e(old('is_active', $brand->is_active ?? 1) == 0 ? 'selected' : ''); ?>>Inactive</option>
                </select>
            </div>
            <!-- Featured Brand Field -->
            <div class="form-group" style="flex: 1;">
                <label for="is_featured">Featured</label>
                <select name="is_featured" id="is_featured" class="form-control">
                    <option value="0" <?php echo e(old('is_featured', $brand->is_featured ?? 0) == 0 ? 'selected' : ''); ?>>No</option>
                    <option value="1" <?php echo e(old('is_featured', $brand->is_featured ?? 0) == 1 ? 'selected' : ''); ?>>Yes</option>
                </select>
            </div>
        </div>

    </div>
    <!-- ===== END RIGHT PANEL ===== -->

</div>
<!-- ===== END TWO-PANEL FORM LAYOUT ===== -->

<?php $__env->startPush('styles'); ?>
<style>
    /* Force the brand modal upload preview to be a perfect circle */
    .brand-logo-upload .upload-preview img {
        width: 120px;
        height: 120px;
        max-width: none;
        max-height: none;
        border-radius: 50% !important;
        object-fit: cover;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin: 0 auto;
        display: block;
    }
</style>
<?php $__env->stopPush(); ?>


<?php /**PATH C:\xampp\htdocs\Pet Markt-PH\resources\views/brands/_form.blade.php ENDPATH**/ ?>