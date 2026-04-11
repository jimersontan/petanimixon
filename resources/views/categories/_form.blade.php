<!-- ===== CATEGORY FORM PARTIAL ===== -->
<!-- Used for both Create and Edit modals/pages -->

@php
    $category = $category ?? new \App\Models\Category();
@endphp

<!-- Form Validation Errors -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- ===== TWO-PANEL FORM LAYOUT ===== -->
<div class="form-two-panel">

    <!-- ===== LEFT PANEL: Main Category Details ===== -->
    <div class="form-panel-left">

        <!-- Category Name Field -->
        <div class="form-group">
            <label for="category_name">Category Name <span class="text-danger">*</span></label>
            <input type="text" name="category_name" id="category_name" class="form-control" value="{{ old('category_name', $category->category_name) }}" required placeholder="e.g. Dogs, Cats, Toys">
        </div>

        <!-- Description Field -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="5" placeholder="Brief description of this category">{{ old('description', $category->description) }}</textarea>
        </div>

        <!-- Sort Order Field -->
        <div class="form-group">
            <label for="sort_order">Sort Order</label>
            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order ?? 0) }}">
        </div>

    </div>
    <!-- ===== END LEFT PANEL ===== -->

    <!-- Visual Divider between panels -->
    <div class="form-divider"></div>

    <!-- ===== RIGHT PANEL: Image and Status Details ===== -->
    <div class="form-panel-right">

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
                    @if(!empty($category->image_url))
                        <img src="{{ asset('storage/'.$category->image_url) }}" alt="{{ $category->category_name }}">
                    @endif
                </div>
            </div>
        </div>

        <!-- Status and Featured Row -->
        <div class="form-row" style="display: flex; gap: 15px;">
            <!-- Status Field -->
            <div class="form-group" style="flex: 1;">
                <label for="is_active">Status</label>
                <select name="is_active" id="is_active" class="form-control">
                    <option value="1" {{ old('is_active', $category->is_active ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active', $category->is_active ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Featured Category Toggle -->
            <div class="form-group" style="flex: 1; display: flex; flex-direction: column; justify-content: flex-start;">
                <label>Featured Category?</label>
                <label class="toggle-switch" style="margin-top: 8px;">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $category->is_featured) ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                    <span class="toggle-label" style="margin-left:8px; font-size:14px; font-weight:500;">Homepage</span>
                </label>
            </div>
        </div>

    </div>
    <!-- ===== END RIGHT PANEL ===== -->

</div>
<!-- ===== END TWO-PANEL FORM LAYOUT ===== -->

