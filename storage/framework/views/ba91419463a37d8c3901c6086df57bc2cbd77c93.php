<!-- ===== CATEGORY FORM PARTIAL ===== -->
<!-- Used for both Create and Edit modals/pages -->

<?php
    $category = $category ?? new \App\Models\Category();
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

<!-- Category Name Field -->
<div class="form-group">
    <label for="category_name">Category Name <span class="text-danger">*</span></label>
    <input type="text" name="category_name" id="category_name" class="form-control" value="<?php echo e(old('category_name', $category->category_name)); ?>" required placeholder="e.g. Dogs, Cats, Toys">
</div>

<!-- Description Field -->
<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Brief description of this category"><?php echo e(old('description', $category->description)); ?></textarea>
</div>

<!-- Image Upload Field -->
<div class="form-group">
    <label for="image">Category Image</label>
    <div class="paste-upload-zone" tabindex="0">
        <button type="button" class="remove-file-btn" title="Remove">✕</button>
        <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 16V4m0 0l-4 4m4-4l4 4M4 18h16" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <div class="upload-title">Click to upload or paste image</div>
        <div class="upload-hint">Drag & drop, browse, or press <kbd>Ctrl</kbd>+<kbd>V</kbd> to paste</div>
        <input type="file" name="image" id="image" accept="image/*" style="display:none;">
        <div class="upload-preview">
            <?php if(!empty($category->image_url)): ?>
                <img src="<?php echo e(asset('storage/'.$category->image_url)); ?>" alt="<?php echo e($category->category_name); ?>">
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Sort Order and Featured Row -->
<div class="form-row" style="display: flex; gap: 15px;">
    <!-- Sort Order Field -->
    <div class="form-group" style="flex: 1;">
        <label for="sort_order">Sort Order</label>
        <input type="number" name="sort_order" id="sort_order" class="form-control" value="<?php echo e(old('sort_order', $category->sort_order ?? 0)); ?>">
    </div>
    
    <!-- Featured Category Toggle -->
    <div class="form-group" style="flex: 1; display: flex; flex-direction: column; justify-content: flex-start;">
        <label>Featured Category?</label>
        <label class="toggle-switch" style="margin-top: 8px;">
            <input type="checkbox" name="is_featured" value="1" <?php echo e(old('is_featured', $category->is_featured) ? 'checked' : ''); ?>>
            <span class="toggle-slider"></span>
            <span class="toggle-label" style="margin-left:8px; font-size:14px; font-weight:500;">Show on Homepage</span>
        </label>
    </div>
</div>

<!-- Status Field -->
<div class="form-group">
    <label for="is_active">Status</label>
    <select name="is_active" id="is_active" class="form-control">
        <option value="1" <?php echo e(old('is_active', $category->is_active ?? 1) == 1 ? 'selected' : ''); ?>>Active</option>
        <option value="0" <?php echo e(old('is_active', $category->is_active ?? 1) == 0 ? 'selected' : ''); ?>>Inactive</option>
    </select>
</div><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/categories/_form.blade.php ENDPATH**/ ?>