@php
    $category = $category ?? new \App\Models\Category();
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
    <label for="category_name">Name</label>
    <input type="text" name="category_name" id="category_name" class="form-control" value="{{ old('category_name', $category->category_name) }}" required>
</div>
<div class="form-group">
    <label for="parent_category_id">Parent Category</label>
    <select name="parent_category_id" id="parent_category_id" class="form-control">
        <option value="">-- none --</option>
        @foreach($parents as $p)
            <option value="{{ $p->id }}" {{ (old('parent_category_id', $category->parent_category_id) == $p->id) ? 'selected' : '' }}>{{ $p->category_name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="is_active">Status</label>
    <select name="is_active" id="is_active" class="form-control">
        <option value="1" {{ old('is_active', $category->is_active) ? 'selected' : '' }}>Active</option>
        <option value="0" {{ !old('is_active', $category->is_active) ? 'selected' : '' }}>Inactive</option>
    </select>
</div>