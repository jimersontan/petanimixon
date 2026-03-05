@php
    $brand = $brand ?? new \App\Models\Brand();
@endphp

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $brand->name) }}" required>
</div>
<div class="form-group">
    <label for="is_active">Status</label>
    <select name="is_active" id="is_active" class="form-control">
        <option value="1" {{ old('is_active', $brand->is_active) ? 'selected' : '' }}>Active</option>
        <option value="0" {{ !old('is_active', $brand->is_active) ? 'selected' : '' }}>Inactive</option>
    </select>
</div>
<div class="form-group">
    <label for="is_featured">Featured</label>
    <select name="is_featured" id="is_featured" class="form-control">
        <option value="0" {{ !old('is_featured', $brand->is_featured) ? 'selected' : '' }}>No</option>
        <option value="1" {{ old('is_featured', $brand->is_featured) ? 'selected' : '' }}>Yes</option>
    </select>
</div>
