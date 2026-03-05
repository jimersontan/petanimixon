<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Dry Dog Food - Pet Animixon</title>
    <link rel="stylesheet" href="{{ asset('css/shop_shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop_product.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
@auth
@include('partials.shop_nav')

<div class="pd-wrap">
    <div class="pd-container">
        <div class="sh-breadcrumb">
            <a href="{{ route('home') }}">Home</a> <span>›</span>
            <a href="{{ route('shop.products') }}">Shop</a> <span>›</span>
            <span>Premium Dry Dog Food</span>
        </div>

        <!-- Product Top -->
        <div class="pd-top">
            <!-- Image Gallery -->
            <div class="pd-gallery">
                <div class="pd-main-img-wrap">
                    <img id="pdMainImg" src="https://images.unsplash.com/photo-1589924691995-400dc9ecc119?w=500&h=500&fit=crop" alt="Premium Dry Dog Food" class="pd-main-img">
                    <button class="pd-rotate-btn" title="View 360°">↺</button>
                </div>
                <div class="pd-thumbs">
                    @php
                    $thumbs = [
                        'https://images.unsplash.com/photo-1589924691995-400dc9ecc119?w=100&h=100&fit=crop',
                        'https://images.unsplash.com/photo-1573865526739-10659fec78a5?w=100&h=100&fit=crop',
                        'https://images.unsplash.com/photo-1601758228041-f3b2795255f1?w=100&h=100&fit=crop',
                        'https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=100&h=100&fit=crop',
                    ];
                    @endphp
                    @foreach($thumbs as $i => $t)
                    <img src="{{ $t }}" alt="View {{ $i+1 }}" class="pd-thumb {{ $i===0 ? 'active' : '' }}" onclick="pdSwap(this, '{{ str_replace('100&h=100','500&h=500',$t) }}')">
                    @endforeach
                </div>
            </div>

            <!-- Info -->
            <div class="pd-info">
                <div class="pd-rating-row">
                    <span class="pd-stars">★★★★<span style="color:#ddd">★</span></span>
                    <span class="pd-review-count">(487 reviews)</span>
                    <a href="#reviews" class="pd-write-review">Write a review</a>
                </div>
                <h1 class="pd-title">Premium Dry Dog Food – Chicken & Vegetables</h1>
                <div class="pd-price-row">
                    <span class="pd-price">₱600</span>
                    <span class="pd-old-price">₱750</span>
                    <span class="pd-discount">Save ₱150 off!</span>
                </div>
                <div class="pd-stock-row">
                    <span class="pd-in-stock">✓ In Stock</span>
                    <span class="pd-sku">SKU: 52 Units</span>
                </div>
                <div class="pd-suit-row">
                    Suit For: <a href="#">🐕 Dogs</a> <a href="#">🐱 Cats</a>
                </div>
                <p class="pd-short-desc">High quality dry food made with real chicken and fresh vegetables. Premium content…</p>
                <ul class="pd-bullets">
                    <li>Real chicken as first ingredient</li>
                    <li>No artificial preservatives or colors</li>
                    <li>Rich in omega fatty acids</li>
                    <li>Supports healthy digestion</li>
                </ul>

                <!-- Size -->
                <div class="pd-option-group">
                    <label class="pd-option-label">Size</label>
                    <div class="pd-size-chips">
                        @foreach(['1kg','3kg','5kg','10kg'] as $s)
                        <button class="pd-size-chip {{ $s==='3kg' ? 'active' : '' }}" onclick="pdSelectSize(this)">{{ $s }}</button>
                        @endforeach
                    </div>
                </div>

                <!-- Qty & Actions -->
                <div class="pd-qty-row">
                    <div class="ct-qty">
                        <button class="ct-qty-btn" onclick="pdQty(-1)">−</button>
                        <span class="ct-qty-val" id="pdQtyVal">1</span>
                        <button class="ct-qty-btn" onclick="pdQty(1)">+</button>
                    </div>
                </div>

                <a href="{{ route('cart') }}" class="sh-btn-orange pd-add-cart-btn">+ Add to Cart</a>

                <div class="pd-secondary-actions">
                    <button class="sh-btn-outline pd-sec-btn">♡ Wishlist</button>
                    <button class="sh-btn-outline pd-sec-btn">⇄ Compare</button>
                </div>

                <div class="pd-badges">
                    <div class="pd-badge"><span>🔒</span><small>Secure Pay</small></div>
                    <div class="pd-badge"><span>★</span><small>Premium Quality</small></div>
                    <div class="pd-badge"><span>🚚</span><small>Free Delivery</small></div>
                </div>

                <p class="pd-delivery-note">🟢 Free shipping orders over ₱500 · Arrives in 3–5 business days</p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="pd-tabs" id="reviews">
            <div class="pd-tab-nav">
                @foreach(['Description','Specifications','Reviews','Q&A','Shipping'] as $tab)
                <button class="pd-tab-btn {{ $tab==='Description' ? 'active' : '' }}" onclick="pdTab(this)">{{ $tab }}</button>
                @endforeach
            </div>
            <div class="pd-tab-content">
                <div class="pd-tab-panel active" id="tab-Description">
                    <h3>Product Description</h3>
                    <p>Our Premium Dry Dog Food is crafted with real chicken as the first ingredient, providing your dog with the high-quality protein they need for strong muscles and sustained energy.</p>
                    <h4 style="margin-top:18px;">Feeding Instructions</h4>
                    <ul style="font-size:13px;color:#555;padding-left:20px;line-height:2;">
                        <li>Feed according to your dog's weight and activity level</li>
                        <li>Always have fresh water available</li>
                        <li>Transition gradually over 7–10 days</li>
                    </ul>
                </div>
                <div class="pd-tab-panel" id="tab-Specifications"><p>Detailed specifications coming soon.</p></div>
                <div class="pd-tab-panel" id="tab-Reviews"><p>Customer reviews coming soon.</p></div>
                <div class="pd-tab-panel" id="tab-Q&A"><p>Q&A section coming soon.</p></div>
                <div class="pd-tab-panel" id="tab-Shipping"><p>Shipping info coming soon.</p></div>
            </div>
        </div>

        <!-- You May Also Like -->
        <section class="pd-also-like">
            <h2>You May Also Like</h2>
            <div class="pd-also-grid">
                @php
                $also = [
                    ['Premium Cat Food','₱33.99','https://images.unsplash.com/photo-1573865526739-10659fec78a5?w=200&h=200&fit=crop', 5],
                    ['Natural Dog Treats','₱19.99','https://images.unsplash.com/photo-1589924691995-400dc9ecc119?w=200&h=200&fit=crop', 4],
                    ['Puppy Food','₱49.99','https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=200&h=200&fit=crop', 4],
                    ['Senior Dog Formula','₱52.99','https://images.unsplash.com/photo-1601758228041-f3b2795255f1?w=200&h=200&fit=crop', 5],
                ];
                @endphp
                @foreach($also as $a)
                <a href="{{ route('shop.product', 1) }}" class="pd-also-card">
                    <img src="{{ $a[2] }}" alt="{{ $a[0] }}">
                    <p>{{ $a[0] }}</p>
                    <div class="pd-also-stars">{{ str_repeat('★',$a[3]) }}{{ str_repeat('☆',5-$a[3]) }}</div>
                    <span>{{ $a[1] }}</span>
                </a>
                @endforeach
            </div>
        </section>
    </div>
</div>

@include('partials.shop_footer')

<script>
function pdSwap(el, src) {
    document.querySelectorAll('.pd-thumb').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('pdMainImg').src = src;
}
function pdQty(d) {
    const el = document.getElementById('pdQtyVal');
    el.textContent = Math.max(1, parseInt(el.textContent) + d);
}
function pdSelectSize(el) {
    document.querySelectorAll('.pd-size-chip').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
}
function pdTab(el) {
    document.querySelectorAll('.pd-tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.pd-tab-panel').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    const target = el.textContent.trim();
    const panel = document.getElementById('tab-' + target);
    if (panel) panel.classList.add('active');
}
</script>
@else
<script>window.location.href='{{ route("login") }}';</script>
@endauth
</body>
</html>
