{{-- ═══ POLISHED PRODUCT DETAIL MODAL ═══ --}}
{{-- Inspired by Shopee / Lazada / Amazon product detail pages --}}

<div class="pd-layout">
    {{-- ═══ LEFT: Product Gallery ═══ --}}
    <div class="pd-gallery">
        <img class="pd-main-img" src="{{ $product->image_url }}" alt="{{ $product->product_name }}">
        @if($product->is_sale_active)
        <div class="pd-badge-sale">
            {{ $product->discount_type === 'percent' ? $product->discount_amount . '% OFF' : '₱' . number_format($product->discount_amount) . ' OFF' }}
        </div>
        @endif
    </div>

    {{-- ═══ RIGHT: Product Info ═══ --}}
    <div class="pd-info">
        {{-- Category Label --}}
        <div class="pd-category">{{ $product->category->category_name ?? 'General' }}</div>

        {{-- Product Name --}}
        <h1 class="pd-name">{{ $product->product_name }}</h1>

        {{-- Rating Row --}}
        <div class="pd-rating-row">
            <span class="pd-stars" style="{{ $reviewStats['count'] == 0 ? 'color: #d1d5db;' : '' }}">
                @for($i = 1; $i <= 5; $i++)
                    {{ $i <= round($reviewStats['average']) ? '★' : '☆' }}
                @endfor
            </span>
            <span class="pd-rating-num">{{ $reviewStats['average'] }}</span>
            <span class="pd-divider">|</span>
            <span class="pd-rating-count">{{ $reviewStats['count'] }} {{ Str::plural('Rating', $reviewStats['count']) }}</span>
            <span class="pd-divider">|</span>
            <span class="pd-sold">{{ $product->total_sold }} Sold</span>
        </div>

        {{-- Price Block --}}
        <div class="pd-price-block">
            @if($product->is_sale_active)
                <span class="pd-price-current">₱{{ number_format($product->sale_price, 2) }}</span>
                <span class="pd-price-original">₱{{ number_format($product->price, 2) }}</span>
                <span class="pd-price-discount">
                    -{{ $product->discount_type === 'percent' ? $product->discount_amount . '%' : '₱' . number_format($product->discount_amount) }}
                </span>
            @else
                <span class="pd-price-current">₱{{ number_format($product->price, 2) }}</span>
            @endif
        </div>

        {{-- Short Description --}}
        @if($product->short_description || $product->animal_description)
        <p class="pd-desc">{{ $product->short_description ?? $product->animal_description }}</p>
        @endif

        {{-- Product Details Chips --}}
        <div class="pd-details-row">
            @if($product->brand_name)
            <div class="pd-detail-chip">
                <span class="pd-detail-label">Brand</span>
                <span class="pd-detail-value">{{ $product->brand_name }}</span>
            </div>
            @endif
            @if($product->animal_type)
            <div class="pd-detail-chip">
                <span class="pd-detail-label">For</span>
                <span class="pd-detail-value">{{ $product->animal_type }}</span>
            </div>
            @endif
            @if($product->life_stage)
            <div class="pd-detail-chip">
                <span class="pd-detail-label">Life Stage</span>
                <span class="pd-detail-value">{{ $product->life_stage }}</span>
            </div>
            @endif
            @if($product->wet_or_dry)
            <div class="pd-detail-chip">
                <span class="pd-detail-label">Type</span>
                <span class="pd-detail-value">{{ ucfirst($product->wet_or_dry) }}</span>
            </div>
            @endif
            @if($product->weight_in_grams)
            <div class="pd-detail-chip">
                <span class="pd-detail-label">Weight</span>
                <span class="pd-detail-value">{{ $product->weight_in_grams >= 1000 ? ($product->weight_in_grams / 1000) . ' KG' : $product->weight_in_grams . ' g' }}</span>
            </div>
            @endif
        </div>

        {{-- Divider --}}
        <hr class="pd-hr">

                {{-- Product Variants --}}
        @if($product->variants && $product->variants->count() > 0 && $product->variants->where('uom', '!=', null)->count() > 0)
        <div class="pd-variants-section" style="margin-bottom: 20px;">
            <div style="font-size: 13px; font-weight: 600; color: #444; margin-bottom: 8px;">Select Variant</div>
            <div class="pd-variant-chips" style="display: flex; flex-wrap: wrap; gap: 10px;">
                @foreach($product->variants as $index => $variant)
                    @if($variant->uom)
                    <button type="button" 
                        class="pd-variant-chip {{ $index === 0 ? 'active' : '' }}" 
                        data-id="{{ $variant->id }}" 
                        data-price="{{ $variant->variant_price > 0 ? $variant->variant_price : $product->sale_price }}" 
                        data-stock="{{ $variant->variant_quantity }}"
                        style="padding: 6px 12px; border: 1.5px solid {{ $index === 0 ? 'var(--ud-orange)' : '#ddd' }}; border-radius: 6px; background: {{ $index === 0 ? '#FFF7ED' : '#fff' }}; color: {{ $index === 0 ? 'var(--ud-orange)' : '#333' }}; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                        {{ $variant->variant_name }}
                    </button>
                    @endif
                @endforeach
            </div>
        </div>
        
        @endif
{{-- Stock Status --}}
        <div id="dynamic-stock-wrapper">
        @if($product->stock > 10)
            <div class="pd-stock-badge in">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                In Stock
                <span class="pd-stock-count">({{ $product->stock }} available)</span>
            </div>
        @elseif($product->stock > 0)
            <div class="pd-stock-badge low">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                Only <span class="pd-stock-count">{{ $product->stock }}</span> left — order soon!
            </div>
        @else
            <div class="pd-stock-badge out">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/></svg>
                Out of Stock
            </div>
        @endif
        </div>

        {{-- Action Buttons --}}
        @auth
            <div class="pd-actions">
                {{-- Quantity Selector --}}
                <div class="pd-qty-row">
                    <span class="pd-qty-label">Quantity</span>
                    <div class="pd-qty-wrap">
                        <button type="button" class="pd-qty-btn" onclick="let v=this.nextElementSibling;v.value=Math.max(1,+v.value-1);v.dispatchEvent(new Event('change'))">−</button>
                        <input type="number" value="1" min="1" max="{{ $product->stock }}" class="pd-qty-input pd-main-qty" readonly>
                        <button type="button" class="pd-qty-btn" onclick="let v=this.previousElementSibling;let mx=+(v.getAttribute('max')||999);v.value=Math.min(mx,+v.value+1);v.dispatchEvent(new Event('change'))">+</button>
                    </div>
                </div>

                {{-- CTA Buttons Row --}}
                <div class="pd-cta-row">
                    <form action="{{ route('cart.add') }}" method="POST" class="pd-add-form pd-add-cart-form" style="margin: 0; flex: 1;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1" class="pd-cart-add-qty">
                        <button type="submit" class="pd-btn pd-btn-cart" {{ $product->stock < 1 ? 'disabled' : '' }}>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                            {{ $product->stock < 1 ? 'Out of Stock' : 'Add to Cart' }}
                        </button>
                    </form>

                    @if($product->stock > 0)
                        <form action="{{ route('cart.buy-now') }}" method="POST" class="pd-add-form pd-buy-now-form" style="margin: 0; flex: 1;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1" class="pd-buy-now-qty">
                            <button type="submit" class="pd-btn pd-btn-buy">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                                Buy Now
                            </button>
                        </form>
                        <script>
                            (function() {
                                var mainQty = document.querySelector('.pd-main-qty');
                                var cartAddQty = document.querySelector('.pd-cart-add-qty');
                                var buyNowQty = document.querySelector('.pd-buy-now-form .pd-buy-now-qty');
                                if (!mainQty) return;
                                var syncQty = function() { 
                                    if(buyNowQty) buyNowQty.value = mainQty.value || 1; 
                                    if(cartAddQty) cartAddQty.value = mainQty.value || 1;
                                };
                                mainQty.addEventListener('change', syncQty);
                                mainQty.addEventListener('input', syncQty);
                            })();
                        </script>
                    @endif

                    {{-- Wishlist Button --}}
                    <form action="{{ route('wishlist.toggle') }}" method="POST" style="margin: 0;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="pd-btn pd-btn-wish {{ (Auth::check() && \App\Models\Wishlist::where('user_id', Auth::id())->where('product_id', $product->id)->exists()) ? 'active' : '' }}" title="Toggle Wishlist">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="{{ (Auth::check() && \App\Models\Wishlist::where('user_id', Auth::id())->where('product_id', $product->id)->exists()) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="pd-actions">
                <div class="pd-cta-row">
                    <a href="{{ route('login') }}" class="pd-btn pd-btn-cart" style="text-decoration: none; text-align: center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                        Add to Cart
                    </a>
                    @if($product->stock > 0)
                    <a href="{{ route('login') }}" class="pd-btn pd-btn-buy" style="text-decoration: none; text-align: center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        Buy Now
                    </a>
                    @endif
                    <a href="{{ route('login') }}" class="pd-btn pd-btn-wish" title="Add to Wishlist" style="text-decoration: none;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    </a>
                </div>
            </div>
        @endauth

        {{-- Trust Badges --}}
        <div class="pd-trust-row">
            <div class="pd-trust-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3DB868" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span>Secure Payment</span>
            </div>
            <div class="pd-trust-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><rect x="1" y="3" width="22" height="18" rx="2"/><path d="M1 9h22"/></svg>
                <span>Free Returns</span>
            </div>
            <div class="pd-trust-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--ud-orange)" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 12 16 16 16 8"/><path d="M1 16h15"/></svg>
                <span>Fast Delivery</span>
            </div>
        </div>
    </div>
</div>

{{-- ═══ REVIEWS SECTION ═══ --}}
<div class="rv-section">
    <h2>Customer Reviews</h2>

    {{-- Rating Summary --}}
    <div class="rv-summary">
        <div class="rv-avg">
            <div class="rv-avg-num">{{ $reviewStats['average'] }}</div>
            <div class="rv-avg-stars" style="{{ $reviewStats['count'] == 0 ? 'color: #d1d5db;' : '' }}">
                @for($i = 1; $i <= 5; $i++)
                    {{ $i <= round($reviewStats['average']) ? '★' : '☆' }}
                @endfor
            </div>
            <div class="rv-avg-count">{{ $reviewStats['count'] }} {{ Str::plural('review', $reviewStats['count']) }}</div>
        </div>
        <div class="rv-bars">
            @foreach($reviewStats['distribution'] as $star => $count)
            <div class="rv-bar-row">
                <span class="rv-bar-label">{{ $star }}</span>
                <span class="rv-bar-star">★</span>
                <div class="rv-bar-track">
                    <div class="rv-bar-fill" style="width: {{ $reviewStats['count'] > 0 ? ($count / $reviewStats['count'] * 100) : 0 }}%"></div>
                </div>
                <span class="rv-bar-count">{{ $count }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Review List --}}
    <div class="rv-list">
        @forelse($reviews as $review)
        <div class="rv-card" id="review-{{ $review->id }}">
            <div class="rv-card-header">
                <div class="rv-avatar">{{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}</div>
                <div>
                    <div class="rv-user-name">{{ $review->user->name ?? 'Anonymous' }}</div>
                </div>
                <span class="rv-date">{{ $review->created_at->diffForHumans() }}</span>
            </div>
            <div class="rv-card-stars">
                @for($i = 1; $i <= 5; $i++)
                    {{ $i <= $review->rating ? '★' : '☆' }}
                @endfor
            </div>
            @if($review->comment)
            <div class="rv-card-text">{{ $review->comment }}</div>
            @endif

            {{-- Review Images --}}
            @if(!empty($review->image_urls))
            <div class="rv-card-images">
                @foreach($review->image_urls as $imgUrl)
                <img class="rv-card-img" src="{{ $imgUrl }}" alt="Review photo" onclick="window.openLightbox('{{ $imgUrl }}')">
                @endforeach
            </div>
            @endif

            {{-- Like & Reply --}}
            <div class="rv-actions">
                @auth
                <button type="button" class="rv-like-btn {{ $review->isLikedBy(Auth::id()) ? 'liked' : '' }}" onclick="window.toggleLike({{ $review->id }}, this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    <span>{{ $review->likes->count() }}</span>
                </button>
                <button type="button" class="rv-reply-toggle" onclick="window.toggleReplyForm({{ $review->id }})">💬 Reply ({{ $review->replies->count() }})</button>
                @else
                <span style="font-size:13px;color:#888;">❤️ {{ $review->likes->count() }} · 💬 {{ $review->replies->count() }}</span>
                @endauth
            </div>

            {{-- Replies --}}
            <div class="rv-replies" id="replies-{{ $review->id }}" style="{{ $review->replies->count() > 0 ? '' : 'display:none;' }}">
                @foreach($review->replies as $reply)
                <div class="rv-reply">
                    <span class="rv-reply-name">{{ $reply->user->name ?? 'User' }}</span>
                    <span class="rv-reply-date">· {{ $reply->created_at->diffForHumans() }}</span>
                    <div class="rv-reply-text">{{ $reply->reply }}</div>
                </div>
                @endforeach
                @auth
                <form class="rv-reply-form" action="{{ route('review.reply', $review->id) }}" method="POST">
                    @csrf
                    <input type="text" name="reply" class="rv-reply-input" placeholder="Write a reply..." required>
                    <button type="submit" class="rv-reply-submit">Reply</button>
                </form>
                @endauth
            </div>
        </div>
        @empty
        <div class="rv-no-reviews">No reviews yet. Be the first to review this product! 🐾</div>
        @endforelse
    </div>
</div>
