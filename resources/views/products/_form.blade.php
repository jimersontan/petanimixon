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
    <label for="animal_type">Animal Type</label>
    <input
        type="text"
        name="animal_type"
        id="animal_type"
        class="form-control"
        value="{{ old('animal_type', $product->animal_type) }}"
        required
    >
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
    <label for="stock">Stock</label>
    <input type="number" min="0" name="stock" id="stock" class="form-control" value="{{ old('stock') }}">
    <small class="form-text text-muted">Initial quantity available for this product.</small>
</div>
<div class="form-group">
    <label for="image">Product Image</label>
    <input type="file" name="image" id="image" class="form-control">
    @if(!empty($product->animal_image_url))
        <div class="mt-2">
            <img src="{{ asset('storage/'.$product->animal_image_url) }}" alt="{{ $product->product_name }} image" style="max-height:80px;">
        </div>
    @endif
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
    <label for="product_status">Status</label>
    <select name="product_status" id="product_status" class="form-control">
        <option value="active" {{ (old('product_status', $product->product_status) == 'active') ? 'selected' : '' }}>Active</option>
        <option value="draft" {{ (old('product_status', $product->product_status) == 'draft') ? 'selected' : '' }}>Draft</option>
        <option value="out_of_stock" {{ (old('product_status', $product->product_status) == 'out_of_stock') ? 'selected' : '' }}>Out of stock</option>
    </select>
</div>
