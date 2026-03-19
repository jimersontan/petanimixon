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
                    <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}"
                         onerror="this.src='{{ asset('images/placeholder.png') }}'">
                    <h4>{{ $product->product_name }}</h4>
                    <p class="ud-price">₱{{ number_format($product->price, 2) }}</p>
                    @auth
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="ud-add-cart" {{ $product->stock > 0 ? '' : 'disabled' }}>
                            {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="ud-add-cart" style="text-decoration:none; text-align:center; display:block;">Add to Cart</a>
                    @endauth
                </div>
            @empty
                <p>No products found in this category yet.</p>
            @endforelse
        </div>
    </section>
@endsection
