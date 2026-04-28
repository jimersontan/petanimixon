<!-- ===== CATEGORIES ADMIN PAGE ===== -->
<!-- Extends the main admin layout -->


<?php $__env->startSection('title','Categories'); ?>

<?php $__env->startSection('content'); ?>

<!-- ===== PAGE HEADER SECTION ===== -->
<!-- Title and Add Category button -->
<div class="content-header">
    <h1 class="page-title">Categories</h1>
    <div class="date-filter">
        <!-- Add Category Button: Opens the category creation modal -->
        <button type="button" class="btn-primary" onclick="openCategoryModal('add')">
            <span class="btn-icon">+</span>
            <span>Add Category</span>
        </button>
    </div>
</div>
<!-- ===== END PAGE HEADER SECTION ===== -->

<!-- ===== METRICS CARDS SECTION ===== -->
<!-- Four summary cards: Total, Active, Total Products, Avg Products/Category -->
<div class="metrics-grid">

    <!-- Metric Card: Total Categories -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-orders-orange">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3 3v8h8V3H3zm10 0v8h8V3h-8zM3 13v8h8v-8H3zm10 0v8h8v-8h-8z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value"><?php echo e(number_format($stats['total_categories'] ?? 0)); ?></div>
            <div class="metric-label">Total Categories</div>
        </div>
    </div>
    <!-- End: Total Categories Card -->

    <!-- Metric Card: Active Categories -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-completed">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value"><?php echo e(number_format($stats['active_categories'] ?? 0)); ?></div>
            <div class="metric-label">Active Categories</div>
        </div>
    </div>
    <!-- End: Active Categories Card -->

    <!-- Metric Card: Total Products (across all categories) -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-orders">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M20 2H4c-1 0-2 .9-2 2v3.01c0 .72.43 1.34 1 1.69V20c0 1.1 1.1 2 2 2h14c.9 0 2-.9 2-2V8.7c.57-.35 1-.97 1-1.69V4c0-1.1-1-2-2-2zm-5 12H9v-2h6v2zm5-7H4V4h16v3z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value"><?php echo e(number_format($stats['total_products'] ?? 0)); ?></div>
            <div class="metric-label">Total Products</div>
        </div>
    </div>
    <!-- End: Total Products Card -->

    <!-- Metric Card: Average Products Per Category -->
    <div class="metric-card">
        <div class="metric-icon metric-icon-avg">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value"><?php echo e(number_format($stats['avg_products_per_category'] ?? 0)); ?></div>
            <div class="metric-label">Avg Products/Category</div>
        </div>
    </div>
    <!-- End: Avg Products Card -->

</div>
<!-- ===== END METRICS CARDS SECTION ===== -->

<!-- ===== CATEGORIES TABLE SECTION ===== -->
<!-- Main table showing all categories with parent, product count, status, and actions -->
<div class="card orders-table-card">
    <!-- Table Header: Title and Filter Button -->
    <div class="orders-section-header">
        <h2 class="card-title">Category Structure</h2>
        <div class="orders-actions">
            <!-- Filter Actions Placeholder -->
        </div>
    </div>
    <!-- End: Table Header -->

    <!-- Status Filter Tabs: All, Active, Draft -->
    <div class="order-status-tabs" role="tablist">
        <?php $currentStatus = $status ?? 'all'; ?>
        <a href="<?php echo e(route('categories.admin', array_merge(request()->all(), ['status' => 'all']))); ?>"
           class="order-tab <?php echo e($currentStatus === 'all' ? 'active' : ''); ?>"
           role="tab"
           aria-selected="<?php echo e($currentStatus === 'all' ? 'true' : 'false'); ?>">All</a>
        <a href="<?php echo e(route('categories.admin', array_merge(request()->all(), ['status' => 'active']))); ?>"
           class="order-tab <?php echo e($currentStatus === 'active' ? 'active' : ''); ?>"
           role="tab"
           aria-selected="<?php echo e($currentStatus === 'active' ? 'true' : 'false'); ?>">Active</a>
        <a href="<?php echo e(route('categories.admin', array_merge(request()->all(), ['status' => 'draft']))); ?>"
           class="order-tab <?php echo e($currentStatus === 'draft' ? 'active' : ''); ?>"
           role="tab"
           aria-selected="<?php echo e($currentStatus === 'draft' ? 'true' : 'false'); ?>">Draft</a>
    </div>
    <!-- End: Status Filter Tabs -->

    <!-- Categories Data Table -->
    <div class="table-wrap">
        <table class="orders-table" id="categoriesTable">
            <!-- Table Header Columns -->
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Products</th>
                    <th>Status</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <!-- End: Table Header -->

            <!-- Table Body: Category Rows -->
            <tbody>
                <!-- Loop: Render each category row -->
                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <!-- Category Name -->
                    <td><?php echo e($category->category_name ?? ''); ?></td>
                    <!-- Number of Products in this Category -->
                    <td><?php echo e($category->products_count ?? 0); ?></td>
                    <!-- Active/Inactive Status -->
                    <td><?php echo e(($category->is_active ?? true) ? 'Active' : 'Inactive'); ?></td>
                    <!-- Action Buttons: Edit and Deactivate -->
                    <td class="col-actions">
                        <button type="button" class="action-btn" title="Edit" aria-label="Edit category"
                            onclick="openCategoryModal('edit', <?php echo e(json_encode([
                                'id' => $category->id,
                                'name' => $category->category_name,
                                'description' => $category->description ?? '',
                                'sort_order' => $category->sort_order ?? 0,
                                'is_featured' => (bool)$category->is_featured,
                                'is_active' => (bool)$category->is_active,
                                'image_url' => $category->image_url ? $category->image_full_url : ''
                            ])); ?>)">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                        </button>
                        <!-- Draft Button: Only for active categories -->
                        <?php if($category->is_active ?? true): ?>
                        <!-- Draft Button (Soft Deactivate) -->
                        <form method="POST" action="<?php echo e(route('categories.draft', $category->id)); ?>" style="display:inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="action-btn" title="Deactivate Category (Move to Draft)" onclick="return confirm('Deactivate this category and move to Draft?')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                            </button>
                        </form>
                        <?php else: ?>
                        <!-- Restore Button -->
                        <form method="POST" action="<?php echo e(route('categories.restore', $category->id)); ?>" style="display:inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="action-btn" title="Restore Category" style="color: #22c55e;" onclick="return confirm('Restore this category and make it active again?')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" /><path d="M3 3v5h5" /></svg>
                            </button>
                        </form>
                        <!-- Permanent Delete Button -->
                        <form method="POST" action="<?php echo e(route('categories.destroy', $category->id)); ?>" style="display:inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="action-btn" title="Permanently Delete Category" onclick="return confirm('⚠️ PERMANENT DELETE\n\nAre you sure you want to permanently delete this category? This cannot be undone!')" style="color: #ef4444; transition: opacity 0.2s; opacity: 0.85;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.85'">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-4.5l-1-1zM18 7H6v12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7z"/></svg>
                            </button>
                        </form>
                        <?php endif; ?>
                    </td>
                    <!-- End: Action Buttons -->
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <!-- Empty State: Shown when no categories exist -->
                <tr>
                    <td colspan="4" class="text-center empty-orders">No categories defined yet.</td>
                </tr>
                <?php endif; ?>
                <!-- End: Category Rows Loop -->
            </tbody>
            <!-- End: Table Body -->
        </table>
    </div>
    <!-- End: Categories Data Table -->

</div>
<!-- ===== END CATEGORIES TABLE SECTION ===== -->

<!-- ===== ANIMAL TYPES TABLE SECTION ===== -->
<div class="card orders-table-card" style="margin-top: 24px;">
    <div class="orders-section-header">
        <h2 class="card-title">Animal Types</h2>
        <div class="orders-actions">
            <button type="button" class="btn-primary" onclick="openAnimalTypeModal('add')">
                <span class="btn-icon">+</span>
                <span>Add Animal Type</span>
            </button>
        </div>
    </div>

    <div class="table-wrap">
        <table class="orders-table" id="animalTypesTable">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Products</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $animalTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $at): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <?php if($at->image_url): ?>
                            <div style="width: 44px; height: 44px; border-radius: 50%; background: #f9f9f9; display: flex; align-items: center; justify-content: center; border: 1px solid #f0f0f0;">
                                <img src="<?php echo e($at->image_full_url); ?>" alt="<?php echo e($at->animal_type); ?>" onerror="this.onerror=null; this.parentElement.innerHTML='🐾'; this.parentElement.style.fontSize='18px';" style="width: 75%; height: 75%; object-fit: contain;">
                            </div>
                        <?php else: ?>
                            <div style="width: 44px; height: 44px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 18px; border: 1px solid #eee;">🐾</div>
                        <?php endif; ?>
                    </td>
                    <td style="font-weight: 600;"><?php echo e($at->animal_type); ?></td>
                    <td style="color: #888; font-size: 13px;"><?php echo e($at->description ?? '—'); ?></td>
                    <td><?php echo e($at->product_count); ?></td>
                    <td><?php echo e($at->sort_order ?? 0); ?></td>
                    <td>
                        <span style="padding: 2px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; <?php echo e(($at->status ?? 'Active') === 'Active' ? 'background: #e9f2ea; color: #2E6C34;' : 'background: #fef3cd; color: #856404;'); ?>">
                            <?php echo e($at->status ?? 'Active'); ?>

                        </span>
                    </td>
                    <td class="col-actions">
                        <button type="button" class="action-btn" title="Edit" onclick="openAnimalTypeModal('edit', <?php echo e(json_encode([
                            'id' => $at->id,
                            'name' => $at->animal_type,
                            'description' => $at->description ?? '',
                            'sort_order' => $at->sort_order ?? 0,
                            'status' => $at->status ?? 'Active',
                            'image_full_url' => $at->image_full_url,
                            'life_stages' => is_string($at->life_stages) ? json_decode($at->life_stages) : ($at->life_stages ?: [])
                        ])); ?>)">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                        </button>
                        <?php if(($at->status ?? 'Active') === 'Active'): ?>
                        <button type="button" class="action-btn" title="Draft" onclick="toggleAnimalStatus(<?php echo e($at->id); ?>)">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                        </button>
                        <?php else: ?>
                        <button type="button" class="action-btn" title="Restore" onclick="toggleAnimalStatus(<?php echo e($at->id); ?>)" style="color: #22c55e;">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        </button>
                        <button type="button" class="action-btn" title="Delete" onclick="deleteAnimalType(<?php echo e($at->id); ?>)" style="color: #ef4444;">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-4.5l-1-1zM18 7H6v12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7z"/></svg>
                        </button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center empty-orders">No animal types defined yet.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- ===== END ANIMAL TYPES TABLE SECTION ===== -->

<?php $__env->stopSection(); ?>

<!-- ===== CATEGORY MODAL (ADD/EDIT) ===== -->
<!-- Modal popup for creating or editing a category -->
<?php $__env->startPush('modals'); ?>
<!-- Modal Backdrop: Dark overlay -->
<div class="modal-backdrop <?php echo e($errors->any() ? 'open' : ''); ?>" data-modal-id="category-modal"></div>

<!-- Modal Container -->
<div id="category-modal" class="modal <?php echo e($errors->any() ? 'open' : ''); ?>" style="max-width: 800px; width: 95%;" role="dialog" aria-modal="true" aria-labelledby="categoryModalTitle" tabindex="-1">

    <!-- Modal Header: Title and Close Button -->
    <div class="modal-header">
        <h2 id="categoryModalTitle" class="modal-title">Add Category</h2>
        <button type="button" class="modal-close" data-modal-close="category-modal" aria-label="Close modal">&times;</button>
    </div>
    <!-- End: Modal Header -->

    <!-- Modal Body: Form for entering category details -->
    <div class="modal-body">
        <form id="categoryModalForm" action="<?php echo e(route('categories.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div id="categoryMethodContainer"></div>
            <!-- Include the reusable category form partial -->
            <?php echo $__env->make('categories._form', ['category' => new \App\Models\Category()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- Modal Footer: Cancel and Save Buttons -->
            <div class="modal-footer" style="padding-top: 20px; border-top: 1px solid #f3f4f6; margin-top: 20px;">
                <button type="button" class="btn-secondary" data-modal-close="category-modal">Cancel</button>
                <button type="submit" id="categoryModalSubmitBtn" class="btn-primary">Save Category</button>
            </div>
            <!-- End: Modal Footer -->
        </form>
    </div>
    <!-- End: Modal Body -->

</div>
<!-- ===== END CATEGORY MODAL ===== -->

<!-- ===== ANIMAL TYPE MODAL (ADD/EDIT) ===== -->
<div class="modal-backdrop" data-modal-id="animal-type-modal"></div>
<div id="animal-type-modal" class="modal" style="max-width: 560px; width: 95%;" role="dialog" aria-modal="true" aria-labelledby="animalTypeModalTitle" tabindex="-1">
    <div class="modal-header">
        <h2 id="animalTypeModalTitle" class="modal-title">Add Animal Type</h2>
        <button type="button" class="modal-close" onclick="closeAnimalTypeModal()" aria-label="Close modal">&times;</button>
    </div>
    <div class="modal-body">
        <form id="animalTypeModalForm" enctype="multipart/form-data">
            <div id="animalTypeErrors" style="display: none; background: #fee; border: 1px solid #fcc; border-radius: 8px; padding: 10px; margin-bottom: 16px; color: #c33; font-size: 13px;"></div>

            <div class="form-group">
                <label for="at_name">Animal Type Name <span class="text-danger">*</span></label>
                <input type="text" id="at_name" class="form-control" placeholder="e.g. Cat, Dog, Bird" required>
            </div>

            <div class="form-group">
                <label for="at_description">Description</label>
                <input type="text" id="at_description" class="form-control" placeholder="e.g. Products for cats">
            </div>

            <div class="form-group">
                <label>Animal Type Image</label>
                <div class="paste-upload-zone" id="atPasteZone" tabindex="0">
                    <button type="button" class="remove-file-btn" title="Remove" onclick="removeAtImage()">✕</button>
                    <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 16V4m0 0l-4 4m4-4l4 4M4 18h16" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <div class="upload-title">Click to upload or paste image</div>
                    <div class="upload-hint">Drag & drop, browse, or press <kbd>Ctrl</kbd>+<kbd>V</kbd> to paste</div>
                    <input type="file" id="at_image" accept="image/*" style="display:none;">
                    <div class="upload-preview" id="atPreview"></div>
                </div>
            </div>

            <div class="form-group">
                <label>Life Stages <span style="font-weight:normal; color:#6b7280; font-size:12px;">(optional)</span></label>
                <div style="font-size: 11px; color: #6b7280; margin-bottom: 6px;">Type a stage name and press <kbd>Enter</kbd> to add.</div>
                
                <div class="tag-input-container" style="border: 1px solid #d1d5db; border-radius: 6px; padding: 6px 8px; background: #fff; display: flex; flex-wrap: wrap; gap: 6px; align-items: center; min-height: 42px; cursor: text;" onclick="document.getElementById('at_life_stage_input').focus()">
                    <div id="atLifeStagesTags" style="display: flex; flex-wrap: wrap; gap: 6px; align-items: center;"></div>
                    <input type="text" id="at_life_stage_input" style="border: none; outline: none; background: transparent; flex: 1; min-width: 100px; font-size: 13px;" placeholder="Add life stage...">
                </div>
            </div>

            <div class="form-row" style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label for="at_sort_order">Sort Order</label>
                    <input type="number" id="at_sort_order" class="form-control" value="0">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label for="at_status">Status</label>
                    <select id="at_status" class="form-control">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer" style="padding-top: 20px; border-top: 1px solid #f3f4f6; margin-top: 20px;">
                <button type="button" class="btn-secondary" onclick="closeAnimalTypeModal()">Cancel</button>
                <button type="submit" id="animalTypeSubmitBtn" class="btn-primary">Save Animal Type</button>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopPush(); ?>

<!-- Page-Specific Scripts -->
<?php $__env->startPush('scripts'); ?>
<!-- Orders JS: Table interaction scripts -->
<script src="<?php echo e(asset('js/orders.js')); ?>"></script>
<script>
    function openCategoryModal(mode, data = null) {
        const modal = document.getElementById('category-modal');
        const backdrop = document.querySelector('.modal-backdrop[data-modal-id="category-modal"]');
        const form = document.getElementById('categoryModalForm');
        const title = document.getElementById('categoryModalTitle');
        const submitBtn = document.getElementById('categoryModalSubmitBtn');
        const methodContainer = document.getElementById('categoryMethodContainer');
        
        // Reset form
        form.reset();
        
        // Reset image preview in paste zone
        const preview = form.querySelector('.upload-preview');
        const pasteZone = form.querySelector('.paste-upload-zone');
        if (pasteZone) pasteZone.classList.remove('has-file');
        if (preview) preview.innerHTML = '';
        
        if (mode === 'add') {
            title.textContent = 'Add Category';
            submitBtn.textContent = 'Save Category';
            form.action = "<?php echo e(route('categories.store')); ?>";
            methodContainer.innerHTML = '';
            
            // Set defaults
            document.getElementById('sort_order').value = 0;
            document.getElementById('is_active').value = 1;
            document.querySelector('[name="is_featured"]').checked = false;
        } else if (mode === 'edit' && data) {
            title.textContent = 'Edit Category';
            submitBtn.textContent = 'Save Changes';
            form.action = `/admin/categories/${data.id}`;
            methodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            
            document.getElementById('category_name').value = data.name;
            document.getElementById('description').value = data.description;
            document.getElementById('sort_order').value = data.sort_order;
            document.getElementById('is_active').value = data.is_active;
            document.querySelector('[name="is_featured"]').checked = data.is_featured;
            
            if (data.image_url) {
                if (pasteZone) pasteZone.classList.add('has-file');
                if (preview) {
                    preview.innerHTML = `<img src="${data.image_url}" alt="Preview"><div class="upload-filename">Current Image</div>`;
                }
            }
        }
        
        modal.classList.add('open');
        backdrop.classList.add('open');
    }
    // ========== ANIMAL TYPE MODAL ==========
    var currentAnimalTypeId = null;

    function openAnimalTypeModal(mode, data = null) {
        const modal = document.getElementById('animal-type-modal');
        const backdrop = document.querySelector('.modal-backdrop[data-modal-id="animal-type-modal"]');
        const title = document.getElementById('animalTypeModalTitle');
        const submitBtn = document.getElementById('animalTypeSubmitBtn');
        const errorDiv = document.getElementById('animalTypeErrors');
        
        // Reset
        document.getElementById('at_name').value = '';
        document.getElementById('at_description').value = '';
        document.getElementById('at_sort_order').value = 0;
        document.getElementById('at_status').value = 'Active';
        document.getElementById('at_image').value = '';
        document.getElementById('atPreview').innerHTML = '';
        var pz = document.getElementById('atPasteZone');
        if (pz) pz.classList.remove('has-file');
        errorDiv.style.display = 'none';
        currentAnimalTypeId = null;

        // Reset Life Stages
        window.atLifeStages = [];
        if (typeof renderAtLifeStages === 'function') renderAtLifeStages();
        var lsi = document.getElementById('at_life_stage_input');
        if (lsi) lsi.value = '';

        if (mode === 'add') {
            title.textContent = 'Add Animal Type';
            submitBtn.textContent = 'Save Animal Type';
        } else if (mode === 'edit' && data) {
            title.textContent = 'Edit Animal Type';
            submitBtn.textContent = 'Save Changes';
            currentAnimalTypeId = data.id;
            document.getElementById('at_name').value = data.name;
            document.getElementById('at_description').value = data.description || '';
            document.getElementById('at_sort_order').value = data.sort_order || 0;
            document.getElementById('at_status').value = data.status || 'Active';
            if (data.life_stages && Array.isArray(data.life_stages)) {
                window.atLifeStages = [...data.life_stages];
                if (typeof renderAtLifeStages === 'function') renderAtLifeStages();
            }
            if (data.image_full_url) {
                if (pz) pz.classList.add('has-file');
                document.getElementById('atPreview').innerHTML = `<img src="${data.image_full_url}" alt="Preview"><div class="upload-filename">Current Image</div>`;
            }
        }
        
        modal.classList.add('open');
        backdrop.classList.add('open');
    }

    function closeAnimalTypeModal() {
        document.getElementById('animal-type-modal').classList.remove('open');
        document.querySelector('.modal-backdrop[data-modal-id="animal-type-modal"]').classList.remove('open');
    }

    function removeAtImage() {
        document.getElementById('at_image').value = '';
        document.getElementById('atPreview').innerHTML = '';
        document.getElementById('atPasteZone').classList.remove('has-file');
    }

    // Handle animal type form submission via AJAX
    document.getElementById('animalTypeModalForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var errorDiv = document.getElementById('animalTypeErrors');
        errorDiv.style.display = 'none';

        var formData = new FormData();
        formData.append('name', document.getElementById('at_name').value);
        formData.append('description', document.getElementById('at_description').value);
        formData.append('sort_order', document.getElementById('at_sort_order').value);

        if (window.atLifeStages && window.atLifeStages.length > 0) {
            window.atLifeStages.forEach((stage) => {
                formData.append('life_stages[]', stage);
            });
        }

        var imageInput = document.getElementById('at_image');
        if (imageInput.files.length > 0) {
            formData.append('image', imageInput.files[0]);
        }

        var url, method;
        if (currentAnimalTypeId) {
            url = '/admin/api/animal-types/' + currentAnimalTypeId;
            formData.append('_method', 'PUT');
            method = 'POST';
        } else {
            url = '/admin/api/animal-types';
            method = 'POST';
        }

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: formData,
        })
        .then(r => r.json().then(data => ({ ok: r.ok, data })))
        .then(({ ok, data }) => {
            if (!ok) {
                errorDiv.textContent = data.error || 'An error occurred.';
                errorDiv.style.display = 'block';
                return;
            }
            closeAnimalTypeModal();
            location.reload();
        })
        .catch(err => {
            errorDiv.textContent = 'Network error. Please try again.';
            errorDiv.style.display = 'block';
        });
    });

    function toggleAnimalStatus(id) {
        if (!confirm('Are you sure you want to change the status of this animal type?')) return;
        fetch('/admin/api/animal-types/' + id + '/status', {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        })
        .then(r => r.json())
        .then(() => location.reload());
    }

    function deleteAnimalType(id) {
        if (!confirm('⚠️ PERMANENT DELETE\n\nAre you sure you want to permanently delete this animal type?')) return;
        fetch('/admin/api/animal-types/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        })
        .then(r => r.json().then(data => ({ ok: r.ok, data })))
        .then(({ ok, data }) => {
            if (!ok) {
                alert(data.error || 'Cannot delete.');
                return;
            }
            location.reload();
        });
    }

    // ========== PASTE UPLOAD for Animal Type Modal ==========
    document.addEventListener('DOMContentLoaded', function() {
        var zone = document.getElementById('atPasteZone');
        var input = document.getElementById('at_image');
        var preview = document.getElementById('atPreview');
        if (!zone) return;

        zone.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-file-btn')) return;
            input.click();
        });

        input.addEventListener('change', function() {
            if (input.files.length > 0) {
                showAtPreview(input.files[0]);
            }
        });

        zone.addEventListener('dragover', function(e) { e.preventDefault(); zone.style.borderColor = '#3b7c42'; });
        zone.addEventListener('dragleave', function() { zone.style.borderColor = ''; });
        zone.addEventListener('drop', function(e) {
            e.preventDefault();
            zone.style.borderColor = '';
            if (e.dataTransfer.files.length > 0) {
                input.files = e.dataTransfer.files;
                showAtPreview(e.dataTransfer.files[0]);
            }
        });

        zone.addEventListener('paste', function(e) {
            var items = e.clipboardData && e.clipboardData.items;
            if (!items) return;
            for (var i = 0; i < items.length; i++) {
                if (items[i].type.indexOf('image') !== -1) {
                    var file = items[i].getAsFile();
                    var dt = new DataTransfer();
                    dt.items.add(file);
                    input.files = dt.files;
                    showAtPreview(file);
                    break;
                }
            }
        });

        function showAtPreview(file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview"><div class="upload-filename">' + file.name + '</div>';
                zone.classList.add('has-file');
            };
            reader.readAsDataURL(file);
        }
    });

    // ========== LIFE STAGES TAG BUILDER ==========
    window.atLifeStages = [];
    const atLifeStageInput = document.getElementById('at_life_stage_input');
    const atLifeStagesContainer = document.getElementById('atLifeStagesTags');

    function renderAtLifeStages() {
        if (!atLifeStagesContainer) return;
        atLifeStagesContainer.innerHTML = '';
        window.atLifeStages.forEach((stage, index) => {
            const tag = document.createElement('span');
            tag.style.cssText = 'background: #f3f4f6; color: #374151; font-size: 12px; font-weight: 500; padding: 4px 8px; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);';
            tag.innerHTML = `
                ${escapeHtml(stage)}
                <button type="button" onclick="removeAtLifeStage(${index})" style="background: none; border: none; cursor: pointer; color: #9ca3af; padding: 0 0 0 4px; font-size: 14px; line-height: 1; display:flex; align-items:center;">&times;</button>
            `;
            atLifeStagesContainer.appendChild(tag);
        });
    }

    if (atLifeStageInput) {
        atLifeStageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const val = this.value.trim();
                if (!window.atLifeStages) window.atLifeStages = [];
                if (val && !window.atLifeStages.includes(val)) {
                    window.atLifeStages.push(val);
                    renderAtLifeStages();
                }
                this.value = '';
            }
        });
    }

    window.removeAtLifeStage = function(index) {
        window.atLifeStages.splice(index, 1);
        renderAtLifeStages();
    };

    function escapeHtml(str) {
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Pet Markt-PH\resources\views/categories_admin.blade.php ENDPATH**/ ?>