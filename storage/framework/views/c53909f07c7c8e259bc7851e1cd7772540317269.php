<!-- ===== BRANDS ADMIN PAGE ===== -->
<!-- Extends the main admin layout -->


<?php $__env->startSection('title','Brands'); ?>

<?php $__env->startSection('content'); ?>

<!-- ===== PAGE HEADER SECTION ===== -->
<!-- Title and Add Brand button -->
<div class="content-header">
    <h1 class="page-title">Brands</h1>
    <div class="date-filter">
        <!-- Add Brand Button: Opens the brand creation modal -->
        <button type="button" class="btn-primary" onclick="openBrandModal('add')">
            <span class="btn-icon">+</span>
            <span>Add Brand</span>
        </button>
    </div>
</div>
<!-- ===== END PAGE HEADER SECTION ===== -->

<!-- ===== METRICS CARDS SECTION ===== -->
<!-- Four summary cards: Total Brands, Active, Featured, Avg Products/Brand -->
<div class="metrics-grid">

    <!-- Metric Card: Total Brands -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-orders-orange">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3 3h18v4H3z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value"><?php echo e(number_format($stats['total_brands'] ?? 0)); ?></div>
            <div class="metric-label">Total Brands</div>
        </div>
    </div>
    <!-- End: Total Brands Card -->

    <!-- Metric Card: Active Brands -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-completed">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value"><?php echo e(number_format($stats['active_brands'] ?? 0)); ?></div>
            <div class="metric-label">Active</div>
        </div>
    </div>
    <!-- End: Active Brands Card -->

    <!-- Metric Card: Featured Brands -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-avg">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value"><?php echo e(number_format($stats['featured_brands'] ?? 0)); ?></div>
            <div class="metric-label">Featured</div>
        </div>
    </div>
    <!-- End: Featured Brands Card -->

    <!-- Metric Card: Average Products Per Brand -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-avg">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3 17h18v4H3z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value"><?php echo e(number_format($stats['avg_products_per_brand'] ?? 0, 1)); ?></div>
            <div class="metric-label">Avg Products/Brand</div>
        </div>
    </div>
    <!-- End: Avg Products Card -->

</div>
<!-- ===== END METRICS CARDS SECTION ===== -->

<!-- ===== BRANDS TABLE SECTION ===== -->
<!-- Main table listing all brands with logo, product count, status, and actions -->
<div class="card orders-table-card">
    <h2 class="card-title">All Brands</h2>

    <!-- Brands Data Table -->
    <div class="table-wrap">
        <table class="orders-table" id="brandsTable">
            <!-- Table Header Columns -->
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Logo</th>
                    <th>Products</th>
                    <th>Status</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <!-- End: Table Header -->

            <!-- Table Body: Brand Rows -->
            <tbody>
                <!-- Loop: Render each brand row -->
                <?php $__empty_1 = true; $__currentLoopData = ($brands ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <!-- Brand Name -->
                    <td><?php echo e($brand->name ?? '—'); ?></td>
                    <!-- Brand Logo: Shows image if uploaded, dash if not -->
                    <td>
                        <?php if(!empty($brand->logo_path)): ?>
                            <img src="<?php echo e(asset('storage/'.$brand->logo_path)); ?>" alt="<?php echo e($brand->name); ?> logo" style="max-height:40px;">
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                    <!-- Product Count -->
                    <td><?php echo e($brand->products_count ?? 0); ?></td>
                    <!-- Active/Inactive Status -->
                    <td><?php echo e(($brand->is_active ?? true) ? 'Active' : 'Inactive'); ?></td>
                    <!-- Action Buttons: Edit and Deactivate -->
                    <td class="col-actions">
                        <!-- Edit Button -->
                        <button type="button" class="action-btn" title="Edit" aria-label="Edit brand"
                            onclick="openBrandModal('edit', {
                                id: <?php echo e($brand->id); ?>,
                                name: '<?php echo e(addslashes($brand->name)); ?>',
                                description: '<?php echo e(addslashes($brand->description ?? '')); ?>',
                                is_featured: <?php echo e($brand->is_featured ? 'true' : 'false'); ?>,
                                is_active: <?php echo e($brand->is_active ? '1' : '0'); ?>,
                                logo_path: '<?php echo e($brand->logo_path ? asset('storage/'.$brand->logo_path) : ''); ?>'
                            })">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                        </button>
                        <!-- Deactivate Button: Submits DELETE form to soft-deactivate -->
                        <form method="POST" action="<?php echo e(route('brands.destroy', $brand)); ?>" style="display:inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="action-btn" title="Deactivate" onclick="return confirm('Deactivate this brand?')">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-4.5l-1-1z"/></svg>
                            </button>
                        </form>
                    </td>
                    <!-- End: Action Buttons -->
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <!-- Empty State: Shown when no brands exist -->
                <tr>
                    <td colspan="4" class="text-center empty-orders">No brands defined yet.</td>
                </tr>
                <?php endif; ?>
                <!-- End: Brand Rows Loop -->
            </tbody>
            <!-- End: Table Body -->
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            <?php echo e($brands->links() ?? ''); ?>

        </div>
        <!-- End: Pagination -->
    </div>
    <!-- End: Brands Data Table -->

</div>
<!-- ===== END BRANDS TABLE SECTION ===== -->

<?php $__env->stopSection(); ?>

<!-- ===== BRAND MODAL (ADD/EDIT) ===== -->
<!-- Modal popup for creating or editing a brand -->
<?php $__env->startPush('modals'); ?>
<!-- Modal Backdrop: Dark overlay -->
<div class="modal-backdrop <?php echo e($errors->any() ? 'open' : ''); ?>" data-modal-id="brand-modal"></div>

<!-- Modal Container -->
<div id="brand-modal" class="modal <?php echo e($errors->any() ? 'open' : ''); ?>" role="dialog" aria-modal="true" aria-labelledby="brandModalTitle" tabindex="-1">

    <!-- Modal Header: Title and Close Button -->
    <div class="modal-header">
        <h2 id="brandModalTitle" class="modal-title">Add Brand</h2>
        <button type="button" class="modal-close" data-modal-close="brand-modal" aria-label="Close modal">&times;</button>
    </div>
    <!-- End: Modal Header -->

    <!-- Modal Body: Form for entering brand details -->
    <div class="modal-body">
        <form id="brandModalForm" method="POST" action="<?php echo e(route('brands.store')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div id="brandMethodContainer"></div>
            <!-- Include the reusable brand form partial -->
            <?php echo $__env->make('brands._form', ['brand' => new \App\Models\Brand()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- Modal Footer: Cancel and Save Buttons -->
            <div class="modal-footer">
                <button type="button" class="btn-secondary" data-modal-close="brand-modal">Cancel</button>
                <button type="submit" id="brandModalSubmitBtn" class="btn-primary">Save Brand</button>
            </div>
            <!-- End: Modal Footer -->
        </form>
    </div>
    <!-- End: Modal Body -->

</div>
<!-- ===== END BRAND MODAL ===== -->
<?php $__env->stopPush(); ?>

<!-- Page-Specific Scripts -->
<?php $__env->startPush('scripts'); ?>
<!-- Orders JS: Table interaction scripts -->
<script src="<?php echo e(asset('js/orders.js')); ?>"></script>
<script>
    function openBrandModal(mode, data = null) {
        const modal = document.getElementById('brand-modal');
        const backdrop = document.querySelector('.modal-backdrop[data-modal-id="brand-modal"]');
        const form = document.getElementById('brandModalForm');
        const title = document.getElementById('brandModalTitle');
        const submitBtn = document.getElementById('brandModalSubmitBtn');
        const methodContainer = document.getElementById('brandMethodContainer');
        
        // Reset form
        form.reset();
        
        // Reset image preview in paste zone
        const preview = form.querySelector('.upload-preview');
        const pasteZone = form.querySelector('.paste-upload-zone');
        if (pasteZone) pasteZone.classList.remove('has-file');
        if (preview) preview.innerHTML = '';
        
        if (mode === 'add') {
            title.textContent = 'Add Brand';
            submitBtn.textContent = 'Save Brand';
            form.action = "<?php echo e(route('brands.store')); ?>";
            methodContainer.innerHTML = '';
            
            // Set defaults
            document.getElementById('is_active').value = 1;
            document.querySelector('[name="is_featured"]').checked = false;
        } else if (mode === 'edit' && data) {
            title.textContent = 'Edit Brand';
            submitBtn.textContent = 'Save Changes';
            form.action = `/admin/brands/${data.id}`;
            methodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            
            document.getElementById('name').value = data.name;
            document.getElementById('description').value = data.description;
            document.getElementById('is_active').value = data.is_active;
            document.querySelector('[name="is_featured"]').checked = data.is_featured;
            
            if (data.logo_path) {
                if (pasteZone) pasteZone.classList.add('has-file');
                if (preview) {
                    preview.innerHTML = `<img src="${data.logo_path}" alt="Preview"><div class="upload-filename">Current Logo</div>`;
                }
            }
        }
        
        modal.classList.add('open');
        backdrop.classList.add('open');
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/brands_admin.blade.php ENDPATH**/ ?>