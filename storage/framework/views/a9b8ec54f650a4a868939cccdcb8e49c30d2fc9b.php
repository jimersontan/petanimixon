<!-- ===== PRODUCT FORM PARTIAL ===== -->
<!-- Reusable form included in both Add and Edit product modals -->
<!-- Available variables: $product, $categories, $brands, $animal_types -->
<?php
    // Set default empty product if not provided (for new product forms)
    $product = $product ?? new \App\Models\Product();
?>

<!-- ===== VALIDATION ERRORS SECTION ===== -->
<!-- Displays a list of all form validation errors from the backend -->
<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <!-- Loop: Show each validation error message -->
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <!-- End: Error Messages Loop -->
        </ul>
    </div>
<?php endif; ?>
<!-- ===== END VALIDATION ERRORS SECTION ===== -->

<!-- ===== TWO-PANEL FORM LAYOUT ===== -->
<!-- Split layout: Left panel for core product details, Right panel for media and descriptions -->
<div class="form-two-panel">

    <!-- ===== LEFT PANEL: Main Product Details ===== -->
    <div class="form-panel-left">

        <!-- Field: Product Name (required) -->
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" id="product_name" class="form-control" value="<?php echo e(old('product_name', $product->product_name)); ?>" required>
        </div>
        <!-- End: Product Name -->

        <!-- Field: Animal Type (searchable dropdown with Manage button) -->
        <div class="form-group">
            <label for="animal_type_id">Animal Type</label>
            <!-- Flex container: Select2 dropdown + Manage button side by side -->
            <div style="display: flex; gap: 8px; align-items: center;">
                <!-- Select2 Searchable Dropdown: Loads animal types from database -->
                <div style="flex: 1;">
                    <select name="animal_type_id" id="animal_type_id" class="form-control select2-animal" required>
                        <option value="">Search Animal Type...</option>
                        <!-- Loop: Render each active animal type as a dropdown option -->
                        <?php $__currentLoopData = $animal_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $at): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($at->id); ?>" <?php echo e((old('animal_type_id') == $at->id || (!old('animal_type_id') && ($product->animal_type ?? '') === $at->animal_type)) ? 'selected' : ''); ?>><?php echo e($at->animal_type); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <!-- End: Animal Types Loop -->
                    </select>
                </div>
                <!-- End: Select2 Dropdown -->

                <!-- + Manage Button: Opens the Manage Animal Types mini modal -->
                <button type="button" class="btn-manage-animals" id="btnManageAnimals" title="Manage Animal Types" style="
                    background: #ea580c; color: #fff; border: none; padding: 8px 12px; border-radius: 6px;
                    font-size: 12px; font-weight: 600; cursor: pointer; white-space: nowrap;
                    display: inline-flex; align-items: center; gap: 4px; transition: background 0.2s;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Manage
                </button>
                <!-- End: Manage Button -->
            </div>
        </div>
        <!-- End: Animal Type -->

        <!-- Field: Life Stage (conditional, depends on animal type) -->
        <div class="form-group" id="lifeStageGroup" style="display: none;">
            <label for="life_stage">Life Stage</label>
            <select name="life_stage" id="life_stage" class="form-control">
                <option value="">Select life stage</option>
            </select>
        </div>
        <!-- End: Life Stage -->

        <!-- Field: Category (required dropdown from categories table) -->
        <div class="form-group">
            <label for="animal_category_id">Category</label>
            <select name="animal_category_id" id="animal_category_id" class="form-control" required>
                <option value="">Select category</option>
                <!-- Loop: Render each active category -->
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cat->id); ?>" <?php echo e((old('animal_category_id', $product->animal_category_id) == $cat->id) ? 'selected' : ''); ?>><?php echo e($cat->category_name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <!-- End: Categories Loop -->
            </select>
        </div>
        <!-- End: Category -->

        <!-- Field: Wet or Dry (conditional field for Food & Nutrition category) -->
        <div class="form-group" id="wetOrDryGroup" style="display: none;">
            <label for="wet_or_dry">Wet or Dry</label>
            <select name="wet_or_dry" id="wet_or_dry" class="form-control">
                <option value="">Select type</option>
                <option value="wet" <?php echo e((old('wet_or_dry', $product->wet_or_dry) == 'wet') ? 'selected' : ''); ?>>Wet</option>
                <option value="dry" <?php echo e((old('wet_or_dry', $product->wet_or_dry) == 'dry') ? 'selected' : ''); ?>>Dry</option>
            </select>
        </div>
        <!-- End: Wet or Dry -->

        <!-- Field: Brand (optional dropdown from brands table) -->
        <div class="form-group">
            <label for="brand_name">Brand</label>
            <select name="brand_name" id="brand_name" class="form-control">
                <option value="">No Brand / Unbranded</option>
                <!-- Loop: Render each active brand -->
                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($brand->name); ?>" <?php echo e((old('brand_name', $product->brand_name) == $brand->name) ? 'selected' : ''); ?>><?php echo e($brand->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <!-- End: Brands Loop -->
            </select>
        </div>
        <!-- End: Brand -->

        <!-- Price and Stock Fields: Side-by-side row -->
        <div class="form-row" style="display: flex; gap: 15px;">
            <!-- Field: Price (required, currency format) -->
            <div class="form-group" style="flex: 1; min-width: 0;">
                <label for="price">Price (₱)</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" style="width: 100%;" value="<?php echo e(old('price', $product->price)); ?>" required>
            </div>
            <!-- End: Price -->
            <!-- Field: Stock (optional, whole number) -->
            <div class="form-group" style="flex: 1; min-width: 0;">
                <label for="stock">Stock</label>
                <input type="number" min="0" name="stock" id="stock" class="form-control" style="width: 100%;" value="<?php echo e(old('stock', $product->stock ?? '')); ?>">
            </div>
            <!-- End: Stock -->
        </div>
        <!-- End: Price and Stock Row -->

    </div>
    <!-- ===== END LEFT PANEL ===== -->

    <!-- Visual Divider between panels -->
    <div class="form-divider"></div>

    <!-- ===== RIGHT PANEL: Media and Extra Details ===== -->
    <div class="form-panel-right">

        <!-- Field: Product Image (file upload with paste + drag support) -->
        <div class="form-group">
            <label for="image">Product Image</label>
            <div class="paste-upload-zone" tabindex="0">
                <button type="button" class="remove-file-btn" title="Remove">✕</button>
                <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 16V4m0 0l-4 4m4-4l4 4M4 18h16" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <div class="upload-title">Click to upload or paste image</div>
                <div class="upload-hint">Drag & drop, browse, or press <kbd>Ctrl</kbd>+<kbd>V</kbd> to paste</div>
                <input type="file" name="image" id="image" accept="image/*" style="display:none;">
                <div class="upload-preview">
                    <?php if(!empty($product->animal_image_url)): ?>
                        <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->product_name); ?> image">
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- End: Product Image -->

        <!-- Field: SKU (required, unique product identifier) -->
        <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" name="sku" id="sku" class="form-control" value="<?php echo e(old('sku', $product->sku)); ?>" required>
        </div>
        <!-- End: SKU -->

        <!-- Field: Product Status (Active, Draft, Out of Stock) -->
        <div class="form-group">
            <label for="product_status">Status</label>
            <select name="product_status" id="product_status" class="form-control">
                <option value="active" <?php echo e((old('product_status', $product->product_status) == 'active') ? 'selected' : ''); ?>>Active</option>
                <option value="draft" <?php echo e((old('product_status', $product->product_status) == 'draft') ? 'selected' : ''); ?>>Draft</option>
                <option value="out_of_stock" <?php echo e((old('product_status', $product->product_status) == 'out_of_stock') ? 'selected' : ''); ?>>Out of stock</option>
            </select>
        </div>
        <!-- End: Product Status -->

        <!-- Field: Short Description (optional, brief summary) -->
        <div class="form-group">
            <label for="short_description">Short Description</label>
            <textarea name="short_description" id="short_description" class="form-control" rows="2"><?php echo e(old('short_description', $product->short_description)); ?></textarea>
        </div>
        <!-- End: Short Description -->

        <!-- Field: Full Description (optional, detailed product info) -->
        <div class="form-group">
            <label for="full_description">Full Description</label>
            <textarea name="full_description" id="full_description" class="form-control" rows="4"><?php echo e(old('full_description', $product->full_description)); ?></textarea>
        </div>
        <!-- End: Full Description -->

    </div>
    <!-- ===== END RIGHT PANEL ===== -->

</div>
<!-- ===== END TWO-PANEL FORM LAYOUT ===== -->


<!-- ===== MANAGE ANIMAL TYPES MINI MODAL ===== -->
<!-- Overlay: Dark backdrop for the manage modal (appears on top of the product modal) -->
<div id="manageAnimalOverlay" style="
    display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.4); z-index: 10001; justify-content: center; align-items: center;">

    <!-- Modal Container: 420px centered white card -->
    <div id="manageAnimalModal" style="
        background: #fff; border-radius: 12px; width: 420px; max-height: 80vh;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2); display: flex; flex-direction: column; overflow: hidden;">

        <!-- Modal Header: Title and Close Button -->
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px 24px 16px; border-bottom: 1px solid #f3f4f6;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #111827;">Manage Animal Types</h3>
            <!-- Close (X) Button -->
            <button type="button" id="closeManageModal" style="
                background: none; border: none; cursor: pointer; color: #9ca3af; font-size: 20px;
                width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
                border-radius: 6px; transition: all 0.2s;"
                onmouseover="this.style.background='#f3f4f6';this.style.color='#111827'"
                onmouseout="this.style.background='none';this.style.color='#9ca3af'">✕</button>
        </div>
        <!-- End: Modal Header -->

        <!-- Animal Types List: Dynamically loaded via AJAX -->
        <!-- Each row shows animal name + edit/delete buttons (or restore for drafted items) -->
        <div id="animalTypesList" style="flex: 1; overflow-y: auto; padding: 12px 24px; max-height: 400px;">
            <div style="text-align: center; padding: 24px; color: #9ca3af;">Loading...</div>
        </div>
        <!-- End: Animal Types List -->

        <!-- Add New Animal Footer -->
        <div style="border-top: 1px solid #f3f4f6; padding: 16px 24px;">

            <!-- Add Button: Shows the inline input form when clicked -->
            <div id="addNewAnimalArea">
                <button type="button" id="btnShowAddAnimal" style="
                    background: none; border: 1px dashed #d1d5db; color: #ea580c; padding: 8px 16px;
                    border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer;
                    width: 100%; transition: all 0.2s;"
                    onmouseover="this.style.borderColor='#ea580c';this.style.background='#fff7ed'"
                    onmouseout="this.style.borderColor='#d1d5db';this.style.background='none'">
                    + Add New Animal
                </button>
            </div>
            <!-- End: Add Button -->

            <!-- Inline Add Form: Text input with Save and Cancel buttons -->
            <div id="addNewAnimalForm" style="display: none;">
                <div style="display: flex; gap: 8px; align-items: center;">
                    <!-- New Animal Name Input -->
                    <input type="text" id="newAnimalName" placeholder="Enter animal name" style="
                        flex: 1; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px;
                        font-size: 13px; transition: border-color 0.2s;">
                    <!-- Save Button: Sends POST request to create animal -->
                    <button type="button" id="btnSaveNewAnimal" style="
                        background: #ea580c; color: #fff; border: none; padding: 8px 14px;
                        border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer;">Save</button>
                    <!-- Cancel Button: Hides the input form -->
                    <button type="button" id="btnCancelNewAnimal" style="
                        background: #f3f4f6; color: #4b5563; border: none; padding: 8px 14px;
                        border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer;">Cancel</button>
                </div>
                <!-- Error Message: Shows duplicate or validation errors in red -->
                <div id="addAnimalError" style="color: #ef4444; font-size: 12px; margin-top: 6px; display: none;"></div>
            </div>
            <!-- End: Inline Add Form -->

        </div>
        <!-- End: Add New Animal Footer -->

    </div>
    <!-- End: Modal Container -->

</div>
<!-- ===== END MANAGE ANIMAL TYPES MINI MODAL ===== -->


<!-- ===== CSS STYLES (pushed to layout head) ===== -->
<?php $__env->startPush('styles'); ?>
<style>
    /* ===== SELECT2 THEME OVERRIDE: Orange Color Scheme ===== */

    /* Select2 Base: Match form-control height, border, and rounded corners */
    .select2-container--default .select2-selection--single {
        height: 38px !important;
        border: 1px solid #d1d5db !important;
        border-radius: 6px !important;
        padding: 4px 8px;
        font-size: 13px;
    }
    /* Select2 Text: Vertically center the selected value */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px !important;
        color: #374151;
    }
    /* Select2 Arrow: Align the dropdown arrow vertically */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
    /* Select2 Focus/Open: Orange border and glow on focus */
    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #ea580c !important;
        box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1) !important;
    }
    /* Select2 Highlighted Option: Orange background when hovering options */
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #ea580c !important;
        color: #fff !important;
    }
    /* Select2 Selected Option: Light orange background for the currently selected item */
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #fff7ed !important;
        color: #ea580c !important;
    }
    /* Select2 Search Input: Orange border on focus */
    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        outline: none;
        border-color: #ea580c;
    }
    /* Select2 Dropdown Container: Rounded corners and shadow */
    .select2-dropdown {
        border-color: #d1d5db !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08) !important;
        z-index: 100020 !important;
    }

    /* ===== MANAGE MODAL LIST ITEM STYLES ===== */

    /* Animal Type Row: Flex layout with name on left, actions on right */
    .at-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 0; border-bottom: 1px solid #f9fafb;
    }
    .at-row:last-child { border-bottom: none; }
    /* Drafted Row: Reduced opacity for inactive items */
    .at-row.drafted { opacity: 0.5; }
    /* Animal Name Text */
    .at-row .at-name {
        font-size: 13px; color: #374151; font-weight: 500; flex: 1;
    }
    /* Drafted Name: Strikethrough and gray text */
    .at-row.drafted .at-name {
        text-decoration: line-through; color: #9ca3af;
    }
    /* Action Buttons Container */
    .at-row .at-actions { display: flex; gap: 6px; align-items: center; }
    /* Action Buttons: Edit and Delete icons */
    .at-row .at-actions button {
        background: none; border: none; cursor: pointer; padding: 4px 6px;
        border-radius: 4px; transition: all 0.15s; color: #6b7280; font-size: 12px;
    }
    .at-row .at-actions button:hover { background: #f3f4f6; color: #111827; }
    /* Restore Button: Green accent for reactivating drafted items */
    .at-row .at-actions .btn-restore {
        background: #f0fdf4; color: #16a34a; font-size: 11px; font-weight: 600;
        padding: 4px 10px; border-radius: 4px;
    }
    .at-row .at-actions .btn-restore:hover { background: #dcfce7; }
    /* Manage Button Hover: Darker orange on hover */
    .btn-manage-animals:hover { background: #c2410c !important; }
</style>
<?php $__env->stopPush(); ?>
<!-- ===== END CSS STYLES ===== -->


<!-- ===== JAVASCRIPT (pushed to layout scripts) ===== -->
<?php $__env->startPush('scripts'); ?>
<script>
/**
 * ===== PRODUCT FORM JAVASCRIPT =====
 * Handles: Select2 initialization, Manage Animal Types modal,
 * and all CRUD operations (Add, Edit, Delete, Draft, Restore)
 */
document.addEventListener('DOMContentLoaded', function() {

    // ===== CONFIGURATION =====
    // CSRF token for AJAX security (from meta tag in layout)
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    // API base URL for animal types CRUD endpoints
    const API_BASE = '/admin/api/animal-types';

    // ===== SELECT2 INITIALIZATION =====
    // Initialize the searchable dropdown on the Animal Type field
    function initSelect2() {
        if ($.fn.select2) {
            $('#animal_type_id').select2({
                placeholder: 'Search Animal Type...',
                allowClear: true,
                width: '100%',
                dropdownParent: $('#animal_type_id').closest('.modal-body, .form-panel-left, body')
            });
        }
    }
    initSelect2();

    // Re-initialize Select2 when a Bootstrap modal opens (for dynamic modals)
    $(document).on('shown.bs.modal', function() { initSelect2(); });
    // ===== END SELECT2 INITIALIZATION =====

    // ===== LIFE STAGE CONDITIONAL LOGIC =====
    // Map animal type names (lowercase) to their life stage options
    const lifeStageMap = {
        'dog':   ['Puppy', 'Adult', 'Senior'],
        'dogs':  ['Puppy', 'Adult', 'Senior'],
        'cat':   ['Kitten', 'Adult', 'Senior'],
        'cats':  ['Kitten', 'Adult', 'Senior'],
        'bird':  ['Chick', 'Adult'],
        'birds': ['Chick', 'Adult'],
        'fish':  ['Fry', 'Adult'],
        'reptile':  ['Juvenile', 'Adult'],
        'reptiles': ['Juvenile', 'Adult'],
        'small-mammals': ['Young', 'Adult'],
        'small mammals': ['Young', 'Adult'],
    };

    function toggleLifeStageField() {
        const lifeStageGroup = document.getElementById('lifeStageGroup');
        const lifeStageSelect = document.getElementById('life_stage');
        if (!lifeStageGroup || !lifeStageSelect) return;

        // Get the selected animal type text from Select2
        const $sel = $('#animal_type_id');
        const selectedText = $sel.find('option:selected').text().trim().toLowerCase();

        const stages = lifeStageMap[selectedText] || null;

        if (stages) {
            // Save current value before rebuilding
            const currentVal = lifeStageSelect.value;
            lifeStageSelect.innerHTML = '<option value="">Select life stage</option>';
            stages.forEach(stage => {
                const opt = document.createElement('option');
                opt.value = stage.toLowerCase();
                opt.textContent = stage;
                if (stage.toLowerCase() === currentVal) opt.selected = true;
                lifeStageSelect.appendChild(opt);
            });
            lifeStageGroup.style.display = 'block';
        } else {
            lifeStageGroup.style.display = 'none';
            lifeStageSelect.value = '';
        }
    }

    // Listen for Select2 change events on animal type
    $('#animal_type_id').on('change', function() {
        toggleLifeStageField();
    });

    // Make it accessible globally for the modal open function
    window.toggleLifeStageField = toggleLifeStageField;
    // ===== END LIFE STAGE CONDITIONAL LOGIC =====


    // ===== MANAGE MODAL: Element References =====
    const overlay = document.getElementById('manageAnimalOverlay');
    const listContainer = document.getElementById('animalTypesList');
    const btnManage = document.getElementById('btnManageAnimals');
    const btnClose = document.getElementById('closeManageModal');
    const btnShowAdd = document.getElementById('btnShowAddAnimal');
    const addArea = document.getElementById('addNewAnimalArea');
    const addForm = document.getElementById('addNewAnimalForm');
    const addInput = document.getElementById('newAnimalName');
    const addError = document.getElementById('addAnimalError');
    const btnSaveNew = document.getElementById('btnSaveNewAnimal');
    const btnCancelNew = document.getElementById('btnCancelNewAnimal');

    // ===== MANAGE MODAL: Open and Close =====
    // Open: Show overlay and load the animal types list from API
    function openManageModal() {
        overlay.style.display = 'flex';
        loadAnimalTypes();
    }
    // Close: Hide overlay and reset the add form
    function closeManageModal() {
        overlay.style.display = 'none';
        hideAddForm();
    }

    // Event Listeners: Open/Close manage modal
    if (btnManage) btnManage.addEventListener('click', openManageModal);
    if (btnClose) btnClose.addEventListener('click', closeManageModal);
    // Close when clicking the dark overlay background
    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) closeManageModal();
    });
    // ===== END MANAGE MODAL: Open and Close =====


    // ===== LOAD ANIMAL TYPES LIST =====
    // Fetch all animal types from the API and render them in the modal
    function loadAnimalTypes() {
        listContainer.innerHTML = '<div style="text-align:center;padding:24px;color:#9ca3af;">Loading...</div>';
        fetch(API_BASE, { headers: { 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(data => renderList(data))
            .catch(() => {
                listContainer.innerHTML = '<div style="text-align:center;padding:24px;color:#ef4444;">Failed to load.</div>';
            });
    }

    // Render the animal types list HTML from API data
    function renderList(items) {
        if (!items.length) {
            listContainer.innerHTML = '<div style="text-align:center;padding:24px;color:#9ca3af;">No animal types yet.</div>';
            return;
        }
        let html = '';
        // Loop: Build HTML for each animal type row
        items.forEach(item => {
            const isDrafted = item.status === 'Inactive';
            html += `<div class="at-row ${isDrafted ? 'drafted' : ''}" data-id="${item.id}">
                <span class="at-name" data-name="${escHtml(item.name)}">${escHtml(item.name)}</span>
                <div class="at-actions">`;

            // Conditional: Show Restore button for drafted items, Edit/Delete for active
            if (isDrafted) {
                html += `<button class="btn-restore" onclick="restoreAnimal(${item.id})" title="Restore">Restore</button>`;
            } else {
                html += `<button onclick="editAnimal(${item.id}, '${escAttr(item.name)}')" title="Edit">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                </button>
                <button onclick="deleteAnimal(${item.id}, ${item.product_count || 0})" title="Delete">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                </button>`;
            }
            html += `</div></div>`;
        });
        listContainer.innerHTML = html;
    }
    // ===== END LOAD ANIMAL TYPES LIST =====


    // ===== UTILITY FUNCTIONS =====
    // Escape HTML to prevent XSS in rendered content
    function escHtml(str) { const d = document.createElement('div'); d.textContent = str; return d.innerHTML; }
    // Escape attribute values for safe insertion into HTML attributes
    function escAttr(str) { return str.replace(/'/g, "\\'").replace(/"/g, '&quot;'); }


    // ===== ADD NEW ANIMAL TYPE =====
    // Show the inline add form when "+ Add New Animal" button is clicked
    btnShowAdd.addEventListener('click', function() {
        addArea.style.display = 'none';
        addForm.style.display = 'block';
        addInput.value = '';
        addError.style.display = 'none';
        addInput.focus();
    });
    // Cancel: Hide the add form and show the button again
    btnCancelNew.addEventListener('click', hideAddForm);
    function hideAddForm() {
        addForm.style.display = 'none';
        addArea.style.display = 'block';
        addError.style.display = 'none';
    }

    // Save new animal: POST to API with duplicate check
    btnSaveNew.addEventListener('click', function() {
        const name = addInput.value.trim();
        if (!name) { showAddError('Please enter an animal name.'); return; }
        btnSaveNew.disabled = true;
        fetch(API_BASE, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ name: name })
        })
        .then(r => r.json().then(d => ({ ok: r.ok, data: d })))
        .then(({ ok, data }) => {
            btnSaveNew.disabled = false;
            if (!ok) { showAddError(data.error || 'Error saving.'); return; }
            hideAddForm();
            loadAnimalTypes();    // Refresh manage modal list
            refreshSelect2Dropdown(); // Refresh main dropdown
        })
        .catch(() => { btnSaveNew.disabled = false; showAddError('Network error.'); });
    });

    // Allow Enter key to submit the add form
    addInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') { e.preventDefault(); btnSaveNew.click(); }
    });

    // Display error message below the add input
    function showAddError(msg) { addError.textContent = msg; addError.style.display = 'block'; }
    // ===== END ADD NEW ANIMAL TYPE =====


    // ===== EDIT ANIMAL TYPE =====
    // Convert the animal name to an inline editable input with Save/Cancel
    window.editAnimal = function(id, currentName) {
        const row = listContainer.querySelector(`.at-row[data-id="${id}"]`);
        if (!row) return;
        const nameSpan = row.querySelector('.at-name');
        const actionsDiv = row.querySelector('.at-actions');
        const origName = nameSpan.dataset.name;

        // Replace name text with editable input
        nameSpan.innerHTML = `<input type="text" value="${escHtml(origName)}" style="
            padding:6px 10px;border:1px solid #d1d5db;border-radius:6px;font-size:13px;width:100%;">`;
        // Replace action buttons with Save/Cancel
        actionsDiv.innerHTML = `
            <button onclick="saveEdit(${id})" style="background:#ea580c;color:#fff;border:none;padding:5px 10px;border-radius:5px;font-size:11px;font-weight:600;cursor:pointer;">Save</button>
            <button onclick="loadAnimalTypes()" style="background:#f3f4f6;color:#4b5563;border:none;padding:5px 10px;border-radius:5px;font-size:11px;font-weight:600;cursor:pointer;">Cancel</button>`;
        const input = nameSpan.querySelector('input');
        if (input) { input.focus(); input.select(); }

        // Create error message div for edit validation
        let errDiv = row.querySelector('.edit-error');
        if (!errDiv) {
            errDiv = document.createElement('div');
            errDiv.className = 'edit-error';
            errDiv.style.cssText = 'color:#ef4444;font-size:12px;margin-top:4px;display:none;width:100%;';
            row.appendChild(errDiv);
        }
    };

    // Save the edited animal name: PUT to API with duplicate check
    window.saveEdit = function(id) {
        const row = listContainer.querySelector(`.at-row[data-id="${id}"]`);
        if (!row) return;
        const input = row.querySelector('input[type="text"]');
        const errDiv = row.querySelector('.edit-error');
        const name = input ? input.value.trim() : '';
        if (!name) { if (errDiv) { errDiv.textContent = 'Name cannot be empty.'; errDiv.style.display = 'block'; } return; }

        fetch(`${API_BASE}/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ name: name })
        })
        .then(r => r.json().then(d => ({ ok: r.ok, data: d })))
        .then(({ ok, data }) => {
            if (!ok) { if (errDiv) { errDiv.textContent = data.error || 'Error saving.'; errDiv.style.display = 'block'; } return; }
            loadAnimalTypes();        // Refresh manage modal list
            refreshSelect2Dropdown(); // Refresh main dropdown
        })
        .catch(() => { if (errDiv) { errDiv.textContent = 'Network error.'; errDiv.style.display = 'block'; } });
    };
    // ===== END EDIT ANIMAL TYPE =====


    // ===== DELETE / DRAFT ANIMAL TYPE =====
    // Show inline Draft/Delete/Cancel buttons when delete icon is clicked
    window.deleteAnimal = function(id, productCount) {
        const row = listContainer.querySelector(`.at-row[data-id="${id}"]`);
        if (!row) return;
        const actionsDiv = row.querySelector('.at-actions');

        // Warning: If this animal type is used by products
        let warningHtml = '';
        if (productCount > 0) {
            warningHtml = `<div style="color:#ef4444;font-size:11px;margin-top:4px;width:100%;">⚠ Used by ${productCount} product(s). You can Draft it instead.</div>`;
        }

        // Replace actions with Draft/Delete/Cancel buttons
        actionsDiv.innerHTML = `
            <button onclick="draftAnimal(${id})" style="background:#fef3c7;color:#92400e;border:none;padding:5px 10px;border-radius:5px;font-size:11px;font-weight:600;cursor:pointer;">Draft</button>
            ${productCount === 0 ? `<button onclick="confirmDelete(${id})" style="background:#fee2e2;color:#dc2626;border:none;padding:5px 10px;border-radius:5px;font-size:11px;font-weight:600;cursor:pointer;">Delete</button>` : ''}
            <button onclick="loadAnimalTypes()" style="background:#f3f4f6;color:#4b5563;border:none;padding:5px 10px;border-radius:5px;font-size:11px;font-weight:600;cursor:pointer;">Cancel</button>`;

        // Append usage warning if applicable
        if (warningHtml) {
            let wd = row.querySelector('.delete-warning');
            if (!wd) { wd = document.createElement('div'); wd.className = 'delete-warning'; row.appendChild(wd); }
            wd.innerHTML = warningHtml;
        }
    };

    // Draft an animal type: PATCH status to Inactive (hides from dropdown, keeps in database)
    window.draftAnimal = function(id) {
        fetch(`${API_BASE}/${id}/status`, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(() => { loadAnimalTypes(); refreshSelect2Dropdown(); });
    };

    // Restore a drafted animal type: PATCH status back to Active
    window.restoreAnimal = function(id) {
        fetch(`${API_BASE}/${id}/status`, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(() => { loadAnimalTypes(); refreshSelect2Dropdown(); });
    };

    // Permanently delete an animal type: DELETE request (only if not used by products)
    window.confirmDelete = function(id) {
        fetch(`${API_BASE}/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        })
        .then(r => r.json().then(d => ({ ok: r.ok, data: d })))
        .then(({ ok, data }) => {
            if (!ok) { alert(data.error || 'Cannot delete.'); return; }
            loadAnimalTypes();
            refreshSelect2Dropdown();
        });
    };
    // ===== END DELETE / DRAFT ANIMAL TYPE =====


    // Make loadAnimalTypes globally accessible (used by Cancel buttons in rendered HTML)
    window.loadAnimalTypes = loadAnimalTypes;


    // ===== SYNC SELECT2 DROPDOWN =====
    // Re-fetch animal types from API and rebuild the main dropdown options
    // Called after every CRUD action to keep the dropdown in sync with the database
    function refreshSelect2Dropdown() {
        const currentVal = $('#animal_type_id').val();
        fetch(API_BASE, { headers: { 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(data => {
                const $sel = $('#animal_type_id');
                $sel.empty();
                $sel.append('<option value="">Search Animal Type...</option>');
                // Only show Active animal types in the dropdown
                data.filter(t => t.status === 'Active').forEach(t => {
                    const selected = (String(t.id) === String(currentVal)) ? ' selected' : '';
                    $sel.append(`<option value="${t.id}"${selected}>${escHtml(t.name)}</option>`);
                });
                $sel.trigger('change'); // Notify Select2 of the updated options
            });
    }
    // ===== END SYNC SELECT2 DROPDOWN =====

});
</script>
<?php $__env->stopPush(); ?>
<!-- ===== END JAVASCRIPT ===== -->


<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/products/_form.blade.php ENDPATH**/ ?>