@extends('frontend.layouts.app')

@section('title', $category->category_name . ' - Shop')

@section('content')
    <section class="ud-section">
        <div class="ud-section-header">
            <h2 class="ud-section-title">{{ $category->category_name }}</h2>
            <a href="{{ route('categories') }}" class="ud-view-all">Back to categories</a>
        </div>

        <div class="ud-product-grid">
            @forelse($products as $product)
                <div class="ud-product-card">
                    <button type="button" class="ud-wishlist-btn" aria-label="Add to wishlist">♡</button>
                    <img src="{{ $product->animal_image_url ?: 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=200&h=200&fit=crop' }}" alt="{{ $product->product_name }}">
                    <h4>{{ $product->product_name }}</h4>
                    <p class="ud-price">₱{{ number_format($product->price, 2) }}</p>
                    <button type="button" class="ud-add-cart">Add to Cart</button>
                </div>
            @empty
                <p>No products found in this category yet.</p>
            @endforelse
        </div>
    </section>
@endsection
