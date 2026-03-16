@extends('frontend.layouts.app')

@section('title', $product->product_name . ' - Petverse')

@section('content')
    <section class="ud-section">
        <div class="ud-section-header">
            <h2 class="ud-section-title">{{ $product->product_name }}</h2>
            <a href="{{ url()->previous() }}" class="ud-view-all">Back</a>
        </div>
        <div class="ud-product-grid" style="grid-template-columns: 1.2fr 0.8fr; gap: 2rem;">
            <div class="ud-productcard">
                <img src="{{ $product->animal_image_url ?: 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=600&h=400&fit=crop' }}" alt="{{ $product->product_name }}" style="width:100%; border-radius: 16px; object-fit: cover;" />
            </div>
            <div>
                <div style="margin-bottom: 1rem;">
                    <span style="font-size: 0.9rem; color: #666;">Category:</span>
                    <strong>{{ $product->category->category_name ?? 'General' }}</strong>
                </div>
                <p style="font-size: 1.4rem; font-weight: 700; margin: 0 0 0.75rem;">₱{{ number_format($product->price, 2) }}</p>
                <p style="margin-bottom: 1.5rem; color: #555;">{{ $product->short_description ?? $product->animal_description }}</p>
                <button type="button" class="ud-btn ud-btn-primary">Add to Cart</button>
            </div>
        </div>
    </section>
@endsection
