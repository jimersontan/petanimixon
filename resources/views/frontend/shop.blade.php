@extends('frontend.layouts.app')

@section('title', 'Shop - Pet Animixon')

@section('content')
<div style="background-color: #fef5f0; padding: 40px 20px; text-align: center; margin-bottom: 30px;">
    <h1 style="font-size: 36px; color: #333; margin: 0 0 10px 0;">All Products</h1>
    <p style="font-size: 16px; color: #666; margin: 0;">Discover quality products for every pet</p>
</div>

<div style="max-width: 1400px; margin: 0 auto; padding: 0 20px; display: flex; gap: 30px; min-height: 60vh;">
    <!-- Sidebar Filters -->
    <aside style="width: 200px; flex-shrink: 0;">
        <form method="GET" action="{{ route('shop') }}" id="filterForm">
            <!-- Pet Type Filter -->
            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 16px; font-weight: 600; margin: 0 0 15px 0; color: #333;">Pet Type</h3>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach(['Dogs' => 'dogs', 'Cats' => 'cats', 'Birds' => 'birds', 'Fish' => 'fish', 'Small Mammals' => 'small-mammals', 'Reptiles' => 'reptiles'] as $label => $value)
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="pet_type[]" value="{{ $value }}" {{ in_array($value, request()->input('pet_type', [])) ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;">
                            <span style="font-size: 14px; color: #333;">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Category Filter -->
            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 16px; font-weight: 600; margin: 0 0 15px 0; color: #333;">Category</h3>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach($categories as $category)
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="category[]" value="{{ $category->id }}" {{ in_array($category->id, request()->input('category', [])) ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;">
                            <span style="font-size: 14px; color: #333;">{{ $category->category_name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Price Range Filter -->
            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 16px; font-weight: 600; margin: 0 0 15px 0; color: #333;">Price Range</h3>
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <input type="range" name="price_min" min="0" max="10000" value="{{ request()->input('price_min', 0) }}" style="width: 100%; cursor: pointer;">
                    <div style="display: flex; gap: 10px; font-size: 12px; color: #666;">
                        <span>₱<span id="priceMin">{{ request()->input('price_min', 0) }}</span></span>
                        <span>-</span>
                        <span>₱<span id="priceMax">10000</span></span>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('filterForm').submit()" style="width: 100%; padding: 10px; background-color: var(--ud-orange, #FF8C42); color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; margin-top: 15px;">Apply</button>
            </div>

            <!-- Ratings Filter -->
            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 16px; font-weight: 600; margin: 0 0 15px 0; color: #333;">Ratings</h3>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach([5 => '5 stars & up', 4 => '4 stars & up', 3 => '3 stars & up'] as $rating => $label)
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="radio" name="rating" value="{{ $rating }}" {{ request()->input('rating') == $rating ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;">
                            <span style="font-size: 14px; color: #333;">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Availability Filter -->
            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 16px; font-weight: 600; margin: 0 0 15px 0; color: #333;">Availability</h3>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="in_stock" value="1" {{ request()->input('in_stock') ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;">
                        <span style="font-size: 14px; color: #333;">In Stock Only</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="on_sale" value="1" {{ request()->input('on_sale') ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;">
                        <span style="font-size: 14px; color: #333;">On Sale</span>
                    </label>
                </div>
            </div>

            <!-- Clear Filters -->
            <a href="{{ route('shop') }}" style="display: block; width: 100%; padding: 10px; text-align: center; border: 2px solid var(--ud-orange, #FF8C42); color: var(--ud-orange, #FF8C42); border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.3s;">Clear All Filters</a>
        </form>
    </aside>

    <!-- Main Content -->
    <main style="flex: 1;">
        <!-- Toolbar -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
            <div style="font-size: 14px; color: #666;">
                Showing <strong>1-24</strong> of <strong>{{ $products->count() }}</strong> products
            </div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <button type="button" style="width: 36px; height: 36px; padding: 8px; background-color: var(--ud-orange, #FF8C42); color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">≣</button>
                <button type="button" style="width: 36px; height: 36px; padding: 8px; background-color: #f0f0f0; color: #333; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">≡</button>
                <select name="sort" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; background-color: white;">
                    <option value="featured">Featured</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                    <option value="newest">Newest</option>
                    <option value="best_sellers">Best Sellers</option>
                </select>
            </div>
        </div>

        <!-- Products Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
            @forelse($products as $product)
                <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s;">
                    <!-- Product Image -->
                    <div style="position: relative; background-color: #f5f5f5; height: 240px; overflow: hidden;">
                        <img src="{{ $product->image_url ?? asset('images/placeholder.png') }}" alt="{{ $product->product_name }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22280%22 height=%22240%22%3E%3Crect fill=%22%23f5f5f5%22 width=%22280%22 height=%22240%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-family=%22Arial%22 font-size=%2216%22 fill=%22%23999%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E';">
                        @if($product->is_on_sale)
                            <div style="position: absolute; top: 12px; right: 12px; background-color: var(--ud-orange, #FF8C42); color: white; padding: 4px 12px; border-radius: 4px; font-size: 12px; font-weight: 600;">SALE</div>
                        @endif
                        @if($product->is_new)
                            <div style="position: absolute; top: 12px; right: 12px; background-color: #333; color: white; padding: 4px 12px; border-radius: 4px; font-size: 12px; font-weight: 600;">NEW</div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div style="padding: 16px;">
                        <!-- Rating -->
                        <div style="display: flex; align-items: center; margin-bottom: 8px; font-size: 12px;">
                            <span style="color: #ffa500;">★★★★★</span>
                            <span style="color: #999; margin-left: 4px;">({{ $product->reviews_count ?? 0 }})</span>
                        </div>

                        <!-- Product Name -->
                        <h3 style="font-size: 14px; font-weight: 600; margin: 0 0 8px 0; color: #333; min-height: 40px;">{{ $product->product_name }}</h3>

                        <!-- Price -->
                        <div style="margin-bottom: 12px;">
                            <span style="font-size: 18px; font-weight: 700; color: var(--ud-orange, #FF8C42);">₱{{ number_format($product->price, 2) }}</span>
                            @if($product->original_price > $product->price)
                                <span style="font-size: 14px; color: #999; text-decoration: line-through; margin-left: 8px;">₱{{ number_format($product->original_price, 2) }}</span>
                            @endif
                        </div>

                        <!-- Stock Status -->
                        <div style="font-size: 12px; margin-bottom: 12px; color: {{ $product->stock > 0 ? '#4CAF50' : '#f44336' }};">
                            {{ $product->stock > 0 ? '✓ In Stock' : 'Out of Stock' }}
                        </div>

                        <!-- Add to Cart Button -->
                        <button {{ $product->stock > 0 ? '' : 'disabled' }} style="width: 100%; padding: 10px; background-color: {{ $product->stock > 0 ? 'var(--ud-orange, #FF8C42)' : '#ccc' }}; color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: {{ $product->stock > 0 ? 'pointer' : 'not-allowed' }}; transition: background-color 0.3s;" onclick="addToCart({{ $product->id }})">
                            Add to Cart
                        </button>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                    <p style="font-size: 18px; color: #666;">No products found. Try adjusting your filters.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div style="margin-top: 40px; text-align: center;">
                {{ $products->links() }}
            </div>
        @endif
    </main>
</div>

<script>
    function addToCart(productId) {
        // TODO: Implement add to cart functionality
        console.log('Added product ' + productId + ' to cart');
    }

    // Update price display
    document.querySelectorAll('input[name="price_min"]').forEach(el => {
        el.addEventListener('input', function() {
            document.getElementById('priceMin').textContent = this.value;
        });
    });
</script>

<style>
    [disabled] {
        opacity: 0.6;
    }

    a:hover {
        opacity: 0.8;
    }

    button:hover:not([disabled]) {
        opacity: 0.9;
    }
</style>
@endsection
