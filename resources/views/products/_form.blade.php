@php
    // available vars: $product (optional), $categories, $brands
    $product = $product ?? new \App\Models\Product();
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
    <label for="product_name">Product Name</label>
    <input type="text" name="product_name" id="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}" required>
</div>
<div class="form-group">
    <label for="animal_type_id">Animal Type</label>
    <select name="animal_type_id" id="animal_type_id" class="form-control" required>
        <option value="">Select type</option>
        @foreach($animalTypes as $type)
            <option value="{{ $type->id }}" {{ (old('animal_type_id', $product->animal_type_id) == $type->id) ? 'selected' : '' }}>{{ $type->animal_type }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="animal_category_id">Category</label>
    <select name="animal_category_id" id="animal_category_id" class="form-control" required>
        <option value="">Select category</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ (old('animal_category_id', $product->animal_category_id) == $cat->id) ? 'selected' : '' }}>{{ $cat->category_name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="brand_name">Brand</label>
    <select name="brand_name" id="brand_name" class="form-control">
        <option value="">-- none --</option>
        @foreach($brands as $brand)
            <option value="{{ $brand->name }}" {{ (old('brand_name', $product->brand_name) == $brand->name) ? 'selected' : '' }}>{{ $brand->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="price">Price</label>
    <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" required>
</div>
<div class="form-group">
    <label for="sku">SKU</label>
    <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
</div>
<div class="form-group">
    <label for="short_description">Short Description</label>
    <textarea name="short_description" id="short_description" class="form-control">{{ old('short_description', $product->short_description) }}</textarea>
</div>
<div class="form-group">
    <label for="full_description">Full Description</label>
    <textarea name="full_description" id="full_description" class="form-control">{{ old('full_description', $product->full_description) }}</textarea>
</div>
<div class="form-group">
    <label for="animal_image_url">Product Image</label>
    <input type="file" name="animal_image_url" id="animal_image_url" class="form-control" accept="image/*" onchange="previewImage(event)">
    <div id="image_preview_container" style="margin-top: 10px; display: {{ $product->animal_image_url ? 'block' : 'none' }};">
        <img id="image_preview" src="{{ $product->animal_image_url ? asset('storage/' . $product->animal_image_url) : '#' }}" alt="Image Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 1px solid #ccc; object-fit: cover;">
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('image_preview');
        output.src = reader.result;
        document.getElementById('image_preview_container').style.display = 'block';
    };
    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    } else {
        document.getElementById('image_preview_container').style.display = 'none';
        document.getElementById('image_preview').src = '#';
    }
}
</script>
<div class="form-group">
    <label for="product_status">Status</label>
    <select name="product_status" id="product_status" class="form-control">
        <option value="active" {{ (old('product_status', $product->product_status) == 'active') ? 'selected' : '' }}>Active</option>
        <option value="draft" {{ (old('product_status', $product->product_status) == 'draft') ? 'selected' : '' }}>Draft</option>
        <option value="out_of_stock" {{ (old('product_status', $product->product_status) == 'out_of_stock') ? 'selected' : '' }}>Out of stock</option>
    </select>
</div>
