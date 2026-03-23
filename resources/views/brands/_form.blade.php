<!-- ===== BRAND FORM PARTIAL ===== -->
<!-- Used for both Create and Edit modals/pages -->

@php
    $brand = $brand ?? new \App\Models\Brand();
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

<!-- Brand Name Field -->
<div class="form-group">
    <label for="name">Brand Name <span class="text-danger">*</span></label>
    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $brand->name) }}" required placeholder="e.g. Purina, Royal Canin">
</div>

<!-- Description Field -->
<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Brief description of this brand">{{ old('description', $brand->description) }}</textarea>
</div>

<!-- Website URL Field -->
<div class="form-group">
    <label for="website_url">Website URL</label>
    <div style="position: relative;">
        <span style="position: absolute; left: 12px; top: 10px; color: #9ca3af;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
        </span>
        <input type="url" name="website_url" id="website_url" class="form-control" value="{{ old('website_url', $brand->website_url) }}" placeholder="https://www.example.com" style="padding-left: 36px;">
    </div>
</div>

<!-- Logo Upload Field -->
<div class="form-group">
    <label for="logo">Brand Logo</label>
    <div class="paste-upload-zone" tabindex="0">
        <button type="button" class="remove-file-btn" title="Remove">✕</button>
        <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 16V4m0 0l-4 4m4-4l4 4M4 18h16" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <div class="upload-title">Click to upload or paste image</div>
        <div class="upload-hint">Drag & drop, browse, or press <kbd>Ctrl</kbd>+<kbd>V</kbd> to paste</div>
        <input type="file" name="logo" id="logo" accept="image/*" style="display:none;">
        <div class="upload-preview">
            @if(!empty($brand->logo_path))
                <img src="{{ asset('storage/'.$brand->logo_path) }}" alt="{{ $brand->name }} logo">
            @endif
        </div>
    </div>
</div>

<!-- Status and Featured Row -->
<div class="form-row" style="display: flex; gap: 15px;">
    <!-- Active Status Field -->
    <div class="form-group" style="flex: 1;">
        <label for="is_active">Status</label>
        <select name="is_active" id="is_active" class="form-control">
            <option value="1" {{ old('is_active', $brand->is_active ?? 1) == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('is_active', $brand->is_active ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
    <!-- Featured Brand Field -->
    <div class="form-group" style="flex: 1;">
        <label for="is_featured">Featured</label>
        <select name="is_featured" id="is_featured" class="form-control">
            <option value="0" {{ old('is_featured', $brand->is_featured ?? 0) == 0 ? 'selected' : '' }}>No</option>
            <option value="1" {{ old('is_featured', $brand->is_featured ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
        </select>
    </div>
</div>
