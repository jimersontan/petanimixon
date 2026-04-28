<!-- ===== PRODUCT FORM PARTIAL ===== -->
<!-- Reusable form included in both Add and Edit product modals -->
<!-- Available variables: $product, $categories, $brands, $animal_types -->
@php
    // Set default empty product if not provided (for new product forms)
    $product = $product ?? new \App\Models\Product();
@endphp

<!-- ===== VALIDATION ERRORS SECTION ===== -->
<!-- Displays a list of all form validation errors from the backend -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            <!-- Loop: Show each validation error message -->
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            <!-- End: Error Messages Loop -->
        </ul>
    </div>
@endif
<!-- ===== END VALIDATION ERRORS SECTION ===== -->

<!-- ===== TWO-PANEL FORM LAYOUT ===== -->
<!-- Split layout: Left panel for core product details, Right panel for media and descriptions -->
<div class="form-two-panel">

    <!-- ===== LEFT PANEL: Main Product Details ===== -->
    <div class="form-panel-left">

        <!-- Field: Product Name (required) -->
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" id="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}" required>
        </div>
        <!-- End: Product Name -->

        <!-- Field: Animal Type (Multiple Selection with Chips) -->
        <div class="form-group">
            <label>Animal Types (Select Multiple)</label>
            <!-- Chips Container: Shows selected animals as pills -->
            <div id="animalChipsContainer" style="
                display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;
                min-height: 32px; padding: 8px; background: #f9fafb; border-radius: 6px;
                border: 1px solid #e5e7eb;">
            </div>
            <!-- Hidden multi-select for form submission -->
            <select name="animal_type_ids[]" id="animal_type_ids" multiple style="display: none;">
                @foreach($animal_types as $at)
                    <option value="{{ $at->id }}">{{ $at->animal_type }}</option>
                @endforeach
            </select>
            
            <!-- Available Animals Buttons Row -->
            <div id="availableAnimalsRow" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 12px;">
            </div>

            <!-- Dynamic Life Stage Selectors (One per Selected Animal) -->
            <div id="lifeStageContainers" style="display: none;"></div>

        </div>
        <!-- End: Animal Type -->

        <!-- Field: Category -->
        <div class="form-group">
            <label for="animal_category_id">Category *</label>
            <select name="animal_category_id" id="animal_category_id" class="form-control" required>
                <option value="">Select a category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ (old('animal_category_id', $product->animal_category_id) == $cat->id) ? 'selected' : '' }}>
                        {{ $cat->category_name }}
                    </option>
                @endforeach
            </select>
            @if($errors->has('animal_category_id'))
                <span class="text-danger" style="font-size: 12px; color: #dc2626;">Please select a category.</span>
            @endif
        </div>
        <!-- End: Category -->

        <!-- Field: Wet or Dry (conditional field for Food & Nutrition category) -->
        <div class="form-group" id="wetOrDryGroup" style="display: none;">
            <label for="wet_or_dry">Wet or Dry</label>
            <select name="wet_or_dry" id="wet_or_dry" class="form-control">
                <option value="">Select type</option>
                <option value="wet" {{ (old('wet_or_dry', $product->wet_or_dry) == 'wet') ? 'selected' : '' }}>Wet</option>
                <option value="dry" {{ (old('wet_or_dry', $product->wet_or_dry) == 'dry') ? 'selected' : '' }}>Dry</option>
            </select>
        </div>
        <!-- End: Wet or Dry -->

        <!-- Field: SKU (required, unique product identifier) -->
        <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
        </div>
        <!-- End: SKU -->


        <!-- Field: Brand (optional dropdown from brands table) -->
        <div class="form-group">
            <label for="brand_name">Brand</label>
            <select name="brand_name" id="brand_name" class="form-control">
                <option value="">No Brand / Unbranded</option>
                <!-- Loop: Render each active brand -->
                @foreach($brands as $brand)
                    <option value="{{ $brand->name }}" {{ (old('brand_name', $product->brand_name) == $brand->name) ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
                <!-- End: Brands Loop -->
            </select>
        </div>
        <!-- End: Brand -->

        <!-- Price and Stock Fields: ALWAYS HIDDEN, using variants for everything now -->
        <div class="form-row" id="basePriceStockRow" style="display: none !important; gap: 15px;">
            <!-- Field: Price -->
            <div class="form-group" style="flex: 1; min-width: 0;">
                <label for="price">Base Price (₱)</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" style="width: 100%;" value="{{ old('price', $product->price ?? 0) }}">
            </div>
            <!-- End: Price -->
            <!-- Field: Stock -->
            <div class="form-group" style="flex: 1; min-width: 0;">
                <label for="stock">Stock</label>
                <input type="number" min="0" name="stock" id="stock" class="form-control" style="width: 100%;" value="{{ old('stock', $product->stock ?? 0) }}">
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
            <div class="paste-upload-zone" data-input="image" tabindex="0">
                <button type="button" class="remove-file-btn" title="Remove">✕</button>
                <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 16V4m0 0l-4 4m4-4l4 4M4 18h16" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <div class="upload-title">Click to upload or paste image</div>
                <div class="upload-hint">Drag & drop, browse, or press <kbd>Ctrl</kbd>+<kbd>V</kbd> to paste</div>
                <input type="file" name="image" id="image" accept="image/*" style="display:none;">
                <div class="upload-preview">
                    @if(!empty($product->animal_image_url))
                        <img src="{{ $product->image_url }}" alt="{{ $product->product_name }} image">
                    @endif
                </div>
            </div>
        </div>
        <!-- End: Product Image -->

        <!-- Field: Product Variants (Table with per-variant Price & Stock) -->
        <div class="form-group" id="variantGroup">
            <label>Product Variants <span style="font-weight:normal; color:#6b7280; font-size:12px;">(Optional — each variant gets its own price & stock)</span></label>

            <!-- Input row: value + unit selector + add button -->
            <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 12px;">
                <input type="text" id="variantInputValue" class="form-control"
                       placeholder="Value (e.g. 1.5, Large, Red)" style="flex: 1; min-width: 0;">
                <select id="variantInputType" class="form-control" style="width: auto; min-width: 100px;">
                    <option value="KG">Weight (KG)</option>
                    <option value="G">Weight (Grams)</option>
                    <option value="Lbs">Weight (Lbs)</option>
                    <option value="Oz">Weight (Oz)</option>
                    <option value="Size">Size</option>
                    <option value="Color">Color</option>
                    <option value="Flavor">Flavor</option>
                    <option value="Material">Material</option>
                    <option value="Type">Type</option>
                </select>
                <button type="button" id="addVariantBtn" style="
                    padding: 8px 16px; background: var(--ud-orange-dark); color: #fff; border: none;
                    border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer;
                    white-space: nowrap; transition: background 0.2s;">+ Add</button>
            </div>

            <!-- Variant Table: Rendered by JS -->
            <div id="variantTableContainer"></div>

            <!-- Hidden inputs container: generated by JS for form submission -->
            <div id="variantHiddenInputs"></div>
        </div>
        <!-- End: Product Variants -->


        <!-- Status is now handled automatically based on stock levels -->

        <!-- Field: Full Description (optional, detailed product info) -->
        <div class="form-group">
            <label for="full_description">Description</label>
            <textarea name="full_description" id="full_description" class="form-control" rows="4">{{ old('full_description', $product->full_description) }}</textarea>
        </div>
        <!-- End: Full Description -->

    </div>
    <!-- ===== END RIGHT PANEL ===== -->

</div>
<!-- ===== END TWO-PANEL FORM LAYOUT ===== -->





<!-- ===== CSS STYLES (pushed to layout head) ===== -->
@push('styles')
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
        border-color: var(--ud-orange-dark) !important;
        box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1) !important;
    }
    /* Select2 Highlighted Option: Orange background when hovering options */
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: var(--ud-orange-dark) !important;
        color: #fff !important;
    }
    /* Select2 Selected Option: Light orange background for the currently selected item */
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #fff7ed !important;
        color: var(--ud-orange-dark) !important;
    }
    /* Select2 Search Input: Orange border on focus */
    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        outline: none;
        border-color: var(--ud-orange-dark);
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
@endpush
<!-- ===== END CSS STYLES ===== -->


<!-- ===== JAVASCRIPT (pushed to layout scripts) ===== -->
@push('scripts')
<script>
/**
 * ===== PRODUCT FORM JAVASCRIPT =====
 * Handles: Select2 initialization, Manage Animal Types modal,
 * and all CRUD operations (Add, Edit, Delete, Draft, Restore)
 */
(function() {

    // ===== CONFIGURATION =====
    // CSRF token for AJAX security (from meta tag in layout)
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    // API base URL for animal types CRUD endpoints
    const API_BASE = '/admin/api/animal-types';

    // ===== SELECT2 INITIALIZATION =====
    // Initialize the searchable dropdown on the Animal Type field
    function initSelect2() {
        if (typeof jQuery !== 'undefined' && $.fn.select2) {
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
    if (typeof jQuery !== 'undefined') {
        $(document).on('shown.bs.modal', function() { initSelect2(); });
    }
    // ===== END SELECT2 INITIALIZATION =====

    // ===== MULTIPLE ANIMAL TYPE SELECTION WITH PER-ANIMAL LIFE STAGES =====
    const animalChipsContainer = document.getElementById('animalChipsContainer');
    const availableAnimalsRow = document.getElementById('availableAnimalsRow');
    const animalTypeSelect = document.getElementById('animal_type_ids');
    const lifeStageContainers = document.getElementById('lifeStageContainers');
    
    // Life stages per animal type
    const lifeStagesByAnimal = {
        'cat': ['Kitten', 'Adult', 'Senior'],
        'dog': ['Puppy', 'Adult', 'Senior'],
        'bird': ['Chick', 'Juvenile', 'Adult'],
        'rabbit': ['Baby', 'Adult', 'Senior'],
        'guinea pig': ['Baby', 'Adult', 'Senior'],
        'hamster': ['Baby', 'Adult', 'Senior'],
        'ferret': ['Kit', 'Adult', 'Senior'],
        'chinchilla': ['Baby', 'Adult', 'Senior'],
        'reptile': ['Hatchling', 'Juvenile', 'Adult'],
        'fish': ['Fry', 'Juvenile', 'Adult']
    };

    // Initialize available animals buttons
    function renderAvailableAnimals() {
        const selectedIds = Array.from(animalTypeSelect.selectedOptions).map(o => o.value);
        availableAnimalsRow.innerHTML = '';
        
        Array.from(animalTypeSelect.options).forEach(opt => {
            if (opt.value && !selectedIds.includes(opt.value)) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = opt.text;
                btn.style.cssText = `
                    padding: 8px 14px; background: #f3f4f6; border: 1px solid #d1d5db;
                    border-radius: 20px; font-size: 13px; cursor: pointer; transition: all 0.2s;
                    color: #374151; font-weight: 500;`;
                btn.onmouseover = () => { btn.style.background = 'var(--ud-orange-dark)'; btn.style.color = '#fff'; btn.style.borderColor = 'var(--ud-orange-dark)'; };
                btn.onmouseout = () => { btn.style.background = '#f3f4f6'; btn.style.color = '#374151'; btn.style.borderColor = '#d1d5db'; };
                btn.onclick = (e) => {
                    e.preventDefault();
                    selectAnimal(opt.value, opt.text);
                };
                availableAnimalsRow.appendChild(btn);
            }
        });
    }

    // Select an animal type as a chip
    function selectAnimal(value, text) {
        const selectedIds = Array.from(animalTypeSelect.selectedOptions).map(o => o.value);
        if (!selectedIds.includes(value)) {
            animalTypeSelect.querySelector(`option[value="${value}"]`).selected = true;
            updateChips();
        }
    }

    // Remove an animal type
    window.removeAnimal = function(value) {
        animalTypeSelect.querySelector(`option[value="${value}"]`).selected = false;
        updateChips({});
    };

    // Update chips display and life stage selectors
    window.updateChips = function(existingStages = {}) {
        const selectedIds = Array.from(animalTypeSelect.selectedOptions).map(o => o.value);
        const selectedOptions = selectedIds.map(id => animalTypeSelect.querySelector(`option[value="${id}"]`));
        
        // Update chips
        animalChipsContainer.innerHTML = '';
        selectedOptions.forEach(opt => {
            const chip = document.createElement('div');
            chip.style.cssText = `
                display: inline-flex; align-items: center; gap: 6px;
                background: var(--ud-orange-dark); color: #fff; padding: 6px 12px;
                border-radius: 20px; font-size: 13px; font-weight: 500;`;
            chip.innerHTML = `
                ${opt.text}
                <button type="button" onclick="window.removeAnimal('${opt.value}')" 
                    style="background: none; border: none; color: #fff; cursor: pointer; font-size: 16px; padding: 0;">×</button>
            `;
            animalChipsContainer.appendChild(chip);
        });

        // Update life stage selectors
        updateLifeStageSelectors(selectedOptions, existingStages);
        
        // Rebuild available animals buttons
        renderAvailableAnimals();
    };

    // Global window functions for the popover UI
    window.togglePopover = function(popoverId, badgeElt) {
        // Close others
        document.querySelectorAll('.lifestage-popover').forEach(p => {
            if(p.id !== popoverId) {
                p.style.display = 'none';
                p.previousElementSibling.style.borderColor = '#d1d5db';
                p.previousElementSibling.style.background = '#f9fafb';
            }
        });
        
        const popover = document.getElementById(popoverId);
        if(!popover) return;
        
        if (popover.style.display === 'none' || !popover.style.display) {
            popover.style.display = 'flex';
            badgeElt.style.borderColor = 'var(--ud-orange-dark)';
            badgeElt.style.background = '#fff7ed';
        } else {
            popover.style.display = 'none';
            badgeElt.style.borderColor = '#d1d5db';
            badgeElt.style.background = '#f9fafb';
        }
    };

    window.closeAllPopoversOnClickOutside = function(e) {
        if (!e.target.closest('.lifestage-badge-wrapper')) {
            document.querySelectorAll('.lifestage-popover').forEach(p => p.style.display = 'none');
            document.querySelectorAll('.lifestage-badge').forEach(b => {
                b.style.borderColor = '#d1d5db';
                b.style.background = '#f9fafb';
            });
        }
    };

    window.updateLifestageChip = function(checkbox, animalValue) {
        // Update visual look of the clicked chip
        if(checkbox.checked) {
            checkbox.parentElement.style.background = 'var(--ud-orange-dark)';
            checkbox.parentElement.style.borderColor = 'var(--ud-orange-dark)';
            checkbox.parentElement.style.color = 'white';
        } else {
            checkbox.parentElement.style.background = 'white';
            checkbox.parentElement.style.borderColor = '#d1d5db';
            checkbox.parentElement.style.color = '#4b5563';
        }

        // Update the notification count dot on the badge
        const badgeId = 'badge_' + animalValue;
        const badge = document.getElementById(badgeId);
        if (badge) {
            const countSpan = badge.querySelector('.lifestage-count');
            const checkedCount = document.querySelectorAll(`input[name="life_stages[${animalValue}][]"]:checked`).length;
            if(countSpan) {
                countSpan.textContent = checkedCount;
                if(checkedCount > 0) {
                    countSpan.style.opacity = '1';
                    countSpan.style.width = 'auto';
                    countSpan.style.minWidth = '16px';
                    countSpan.style.marginLeft = '4px';
                    countSpan.style.padding = '0 5px';
                } else {
                    countSpan.style.opacity = '0';
                    countSpan.style.width = '0px';
                    countSpan.style.minWidth = '0px';
                    countSpan.style.marginLeft = '-6px';
                    countSpan.style.padding = '0';
                }
            }
        }
    };

    // Update per-animal life stage selectors using the space-saving popover badge design
    function updateLifeStageSelectors(selectedOptions, existingStages) {
        lifeStageContainers.innerHTML = '';
        
        if (selectedOptions.length === 0) {
            lifeStageContainers.style.display = 'none';
            return;
        }

        // Show container but make it a clean flex row without the bulky grey box
        lifeStageContainers.style.display = 'block';
        lifeStageContainers.style.background = 'transparent';
        lifeStageContainers.style.border = 'none';
        lifeStageContainers.style.padding = '0';
        lifeStageContainers.style.marginTop = '0';

        const rowLabel = document.createElement('label');
        rowLabel.textContent = 'Selected Life Stages (Click to Select)';
        rowLabel.style.cssText = 'font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px; display: block;';
        lifeStageContainers.appendChild(rowLabel);

        const badgeRow = document.createElement('div');
        badgeRow.style.cssText = 'display: flex; flex-wrap: wrap; gap: 12px; position: relative; width: 100%; margin-bottom: 15px; z-index: 10;';

        selectedOptions.forEach((opt, idx) => {
            const animalName = opt.text.toLowerCase();
            const stages = lifeStagesByAnimal[animalName] || ['Adult'];
            
            const preselectedStages = (existingStages[opt.value] || existingStages[opt.text]) ? 
                (existingStages[opt.value] || existingStages[opt.text]).split(', ').map(s => s.toLowerCase().trim()) 
                : [];
            
            const count = preselectedStages.filter(s => stages.map(st=>st.toLowerCase()).includes(s)).length;
            const badgeId = `badge_${opt.value}`;
            const popoverId = `popover_${opt.value}`;

            const badgeWrapper = document.createElement('div');
            badgeWrapper.className = 'lifestage-badge-wrapper';
            badgeWrapper.style.cssText = 'position: relative; display: inline-block;';

            let html = `
                <!-- The Clickable Badge -->
                <button type="button" id="${badgeId}" class="lifestage-badge" style="
                    display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px;
                    border-radius: 20px; font-size: 13px; font-weight: 600; cursor: pointer;
                    background: #f9fafb; border: 1px solid #d1d5db; color: #4b5563; transition: all 0.2s;
                    user-select: none; white-space: nowrap; outline: none;
                " onclick="window.togglePopover('${popoverId}', this)">
                    <span>${opt.text}</span>
                    <span class="lifestage-count" style="
                        background: var(--ud-orange-dark); color: white; border-radius: 50%; font-size: 11px;
                        height: 18px; display: inline-flex; align-items: center; justify-content: center;
                        font-weight: 700; transition: all 0.2s;
                        ${count === 0 ? 'opacity: 0; width: 0; min-width: 0; margin-left: -6px; padding: 0; overflow: hidden;' : 'opacity: 1; width: auto; min-width: 16px; margin-left: 4px; padding: 0 5px;'}
                    ">${count}</span>
                </button>

                <!-- The Popover content -->
                <div id="${popoverId}" class="lifestage-popover" style="
                    display: none; position: absolute; top: calc(100% + 8px); left: 0;
                    background: #ffffff !important; border: 1px solid #e5e7eb; border-radius: 12px;
                    box-shadow: 0 10px 25px -4px rgba(0,0,0,0.1), 0 4px 10px -4px rgba(0,0,0,0.06); 
                    padding: 12px; z-index: 2000; min-width: 200px; flex-wrap: wrap; gap: 8px;
                    transform-origin: top left;
                ">
            `;

            // Render checkboxes as chips inside the popover
            stages.forEach(stage => {
                const stageLower = stage.toLowerCase();
                const isSelected = preselectedStages.includes(stageLower);
                const checkboxId = `ls_${opt.value}_${stageLower}`;
                
                html += `
                    <label for="${checkboxId}" style="
                        display: inline-flex; align-items: center; justify-content: center;
                        padding: 6px 14px; border-radius: 20px; font-size: 12px; 
                        border: 1px solid ${isSelected ? 'var(--ud-orange-dark)' : '#d1d5db'};
                        background: ${isSelected ? 'var(--ud-orange-dark)' : 'white'};
                        color: ${isSelected ? 'white' : '#4b5563'};
                        cursor: pointer; transition: all 0.2s ease; font-weight: 500;
                        margin: 0;
                    ">
                        <input type="checkbox" id="${checkboxId}" name="life_stages[${opt.value}][]" value="${stageLower}" 
                               ${isSelected ? 'checked' : ''} style="display:none;"
                               onchange="window.updateLifestageChip(this, '${opt.value}')">
                        ${stage}
                    </label>
                `;
            });

            html += `</div>`;
            badgeWrapper.innerHTML = html;
            badgeRow.appendChild(badgeWrapper);
        });

        lifeStageContainers.appendChild(badgeRow);

        // Bind global click away
        document.removeEventListener('click', window.closeAllPopoversOnClickOutside);
        document.addEventListener('click', window.closeAllPopoversOnClickOutside);
    }

    // Initialize on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            renderAvailableAnimals();
            window.updateChips({});
        });
    } else {
        renderAvailableAnimals();
        window.updateChips({});
    }
    // ===== END MULTIPLE ANIMAL TYPE SELECTION =====

    // ===== PRODUCT VARIANTS TABLE SYSTEM =====
    const variantTableContainer = document.getElementById('variantTableContainer');
    const variantHiddenInputs = document.getElementById('variantHiddenInputs');
    const variantInputValue = document.getElementById('variantInputValue');
    const variantInputType = document.getElementById('variantInputType');
    const addVariantBtn = document.getElementById('addVariantBtn');
    const globalStockInput = document.getElementById('stock');
    const globalPriceInput = document.getElementById('price');
    const priceHint = document.getElementById('priceHint');
    const stockAutoLabel = document.getElementById('stockAutoLabel');

    window._productVariants = [];

    function getDefaultPrice() {
        return parseFloat(globalPriceInput?.value) || 0;
    }

    function syncGlobalStock() {
        const row = document.getElementById('basePriceStockRow');
        if (!globalStockInput || !row) return;

        if (window._productVariants.length > 0) {
            var total = 0;
            window._productVariants.forEach(function(v) { total += (parseInt(v.stock, 10) || 0); });
            globalStockInput.value = total;
            globalStockInput.readOnly = true;
            globalStockInput.style.background = '#f3f4f6';
            globalStockInput.style.color = '#6b7280';
            
            // In many setups, when variants exist, the base price is hidden or used as "Starting at"
            // For now, we'll keep it visible but maybe hint that it's the base.
            // Or if the user prefers, we can hide the whole row. 
            // The request was "editing for products without variants", implying they might be hidden now.
            // Let's keep it visible but disable stock editing.
            if (stockAutoLabel) stockAutoLabel.style.display = 'inline';
            if (priceHint) priceHint.style.display = 'inline';
        }
        
        // Always hidden as requested
        row.style.display = 'none';
    }

    window.renderVariantTable = function() {
        if (!variantTableContainer || !variantHiddenInputs) return;

        if (window._productVariants.length === 0) {
            variantTableContainer.innerHTML = '';
            variantHiddenInputs.innerHTML = '';
            syncGlobalStock();
            return;
        }

        var html = '<table style="width:100%; border-collapse: separate; border-spacing: 0; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; font-size: 13px;">';
        html += '<thead><tr style="background: #f9fafb;">';
        html += '<th style="padding: 10px 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Variant</th>';
        html += '<th style="padding: 10px 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb; width: 140px;">Price (₱)</th>';
        html += '<th style="padding: 10px 12px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb; width: 110px;">Stock</th>';
        html += '<th style="padding: 10px 12px; text-align: center; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb; width: 40px;"></th>';
        html += '</tr></thead><tbody>';

        window._productVariants.forEach(function(entry, idx) {
            var displayLabel = '';
            if (['KG','G','Lbs','Oz'].includes(entry.type)) {
                displayLabel = entry.value + ' ' + entry.type;
            } else {
                displayLabel = entry.type + ': ' + entry.value;
            }

            var isLast = (idx === window._productVariants.length - 1);
            var borderStyle = isLast ? 'none' : '1px solid #f3f4f6';

            html += '<tr style="border-bottom: ' + borderStyle + ';">';
            html += '<td style="padding: 8px 12px; color: #374151; font-weight: 500;">';
            html += '<span style="display:inline-flex;align-items:center;gap:6px;background:#fff7ed;color:var(--ud-orange-dark);padding:4px 10px;border-radius:16px;font-size:12px;font-weight:600;border:1px solid #fed7aa;">' + displayLabel + '</span>';
            html += '</td>';
            html += '<td style="padding: 8px 12px;">';
            html += '<input type="number" step="0.01" min="0" value="' + (entry.price || 0) + '" ';
            html += 'onchange="window.updateVariantField(' + idx + ',\'price\',this.value)" ';
            html += 'style="width:100%;padding:6px 10px;border:1px solid #d1d5db;border-radius:6px;font-size:13px;background:#fff;outline:none;" ';
            html += 'onfocus="this.style.borderColor=\'var(--ud-orange-dark)\';this.style.boxShadow=\'0 0 0 2px rgba(234,88,12,0.1)\'" ';
            html += 'onblur="this.style.borderColor=\'#d1d5db\';this.style.boxShadow=\'none\'">';
            html += '</td>';
            html += '<td style="padding: 8px 12px;">';
            html += '<input type="number" min="0" value="' + (entry.stock || 0) + '" ';
            html += 'onchange="window.updateVariantField(' + idx + ',\'stock\',this.value);window.syncGlobalStockFromTable()" ';
            html += 'style="width:100%;padding:6px 10px;border:1px solid #d1d5db;border-radius:6px;font-size:13px;background:#fff;outline:none;" ';
            html += 'onfocus="this.style.borderColor=\'var(--ud-orange-dark)\';this.style.boxShadow=\'0 0 0 2px rgba(234,88,12,0.1)\'" ';
            html += 'onblur="this.style.borderColor=\'#d1d5db\';this.style.boxShadow=\'none\'">';
            html += '</td>';
            html += '<td style="padding: 8px 12px; text-align: center;">';
            html += '<button type="button" onclick="window.removeVariantRow(' + idx + ')" ';
            html += 'style="background:none;border:none;color:#ef4444;cursor:pointer;font-size:18px;padding:2px 6px;border-radius:4px;transition:all 0.15s;" ';
            html += 'onmouseover="this.style.background=\'#fef2f2\'" onmouseout="this.style.background=\'none\'" ';
            html += 'title="Remove variant">×</button>';
            html += '</td>';
            html += '</tr>';
        });

        // Footer row: total stock
        var totalStock = 0;
        window._productVariants.forEach(function(v) { totalStock += (parseInt(v.stock, 10) || 0); });
        html += '</tbody><tfoot><tr style="background:#f9fafb;">';
        html += '<td style="padding: 8px 12px; font-weight: 600; color: #374151;" colspan="2">Total Stock</td>';
        html += '<td style="padding: 8px 12px; font-weight: 700; color: var(--ud-orange-dark);">' + totalStock + '</td>';
        html += '<td></td>';
        html += '</tr></tfoot>';
        html += '</table>';

        variantTableContainer.innerHTML = html;

        // Generate hidden inputs for form submission
        variantHiddenInputs.innerHTML = '';
        window._productVariants.forEach(function(entry, idx) {
            var fields = {value: entry.value, type: entry.type, price: entry.price, stock: entry.stock};
            Object.keys(fields).forEach(function(key) {
                var inp = document.createElement('input');
                inp.type = 'hidden';
                inp.name = 'product_variants[' + idx + '][' + key + ']';
                inp.value = fields[key] ?? '';
                variantHiddenInputs.appendChild(inp);
            });
        });

        syncGlobalStock();
    };

    window.updateVariantField = function(idx, field, value) {
        if (window._productVariants[idx]) {
            window._productVariants[idx][field] = value;
        }
    };

    window.syncGlobalStockFromTable = function() {
        syncGlobalStock();
        // Also re-render the footer total
        window.renderVariantTable();
    };

    window.addVariantRow = function() {
        if (!variantInputValue) return;
        var val = variantInputValue.value.trim();
        if (!val) {
            variantInputValue.style.borderColor = '#ef4444';
            setTimeout(function() { variantInputValue.style.borderColor = ''; }, 1500);
            return;
        }
        var type = variantInputType ? variantInputType.value : 'Type';

        var isDuplicate = window._productVariants.some(function(e) {
            return e.value.toLowerCase() === val.toLowerCase() && e.type === type;
        });
        if (isDuplicate) {
            variantInputValue.style.borderColor = '#f59e0b';
            setTimeout(function() { variantInputValue.style.borderColor = ''; }, 1500);
            return;
        }

        window._productVariants.push({ value: val, type: type, price: getDefaultPrice(), stock: 0 });
        variantInputValue.value = '';
        window.renderVariantTable();
    };

    window.removeVariantRow = function(idx) {
        window._productVariants.splice(idx, 1);
        window.renderVariantTable();
    };

    window.clearVariantChips = function() {
        window._productVariants = [];
        window.renderVariantTable();
    };

    window.setVariantChips = function(entries) {
        window._productVariants = entries.map(function(e) {
            return {
                value: e.value,
                type: e.type || e.unit || e.uom || 'Type',
                price: e.price || getDefaultPrice(),
                stock: e.stock ?? e.variant_quantity ?? 0
            };
        });
        window.renderVariantTable();
    };

    // Alias for backwards compat
    window.setWeightChips = window.setVariantChips;
    window.clearWeightChips = window.clearVariantChips;
    window.renderVariantChips = window.renderVariantTable;

    if (addVariantBtn) {
        addVariantBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.addVariantRow();
        });
    }

    if (variantInputValue) {
        variantInputValue.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                window.addVariantRow();
            }
        });
    }

    window.renderVariantTable();
    // ===== END PRODUCT VARIANTS TABLE SYSTEM =====

})();
</script>
@endpush
<!-- ===== END JAVASCRIPT ===== -->

