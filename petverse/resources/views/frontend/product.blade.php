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
                <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}" style="width:100%; border-radius: 16px; object-fit: cover;" />
            </div>
            <div>
                <div style="margin-bottom: 1rem;">
                    <span style="font-size: 0.9rem; color: #666;">Category:</span>
                    <strong>{{ $product->category->category_name ?? 'General' }}</strong>
                </div>
                <p style="font-size: 1.4rem; font-weight: 700; margin: 0 0 0.75rem;">₱{{ number_format($product->price, 2) }}</p>
                <p style="margin-bottom: 1.5rem; color: #555;">{{ $product->short_description ?? $product->animal_description }}</p>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="number" name="quantity" value="1" min="1" class="form-control" style="width: 80px; display: inline-block; margin-right: 10px;">
                    <button type="submit" class="ud-btn ud-btn-primary">Add to Cart</button>
                </form>
            </div>
        </div>
    </section>
@endsection
