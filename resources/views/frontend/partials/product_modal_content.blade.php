{{-- Product Layout --}}
<div class="pd-layout">
    <div class="pd-gallery">
        <img class="pd-main-img" src="{{ $product->image_url }}" alt="{{ $product->product_name }}">
    </div>
    <div class="pd-info">
        <div class="pd-category">{{ $product->category->category_name ?? 'General' }}</div>
        <h1 class="pd-name">{{ $product->product_name }}</h1>

        <div class="pd-rating-row">
            <span class="pd-stars" style="{{ $reviewStats['count'] == 0 ? 'color: #d1d5db;' : '' }}">
                @for($i = 1; $i <= 5; $i++)
                    {{ $i <= round($reviewStats['average']) ? '★' : '☆' }}
                @endfor
            </span>
            <span class="pd-rating-num">{{ $reviewStats['average'] }}</span>
            <span class="pd-rating-count">({{ $reviewStats['count'] }} {{ Str::plural('review', $reviewStats['count']) }})</span>
            <span class="pd-sold">{{ $product->total_sold }} sold</span>
        </div>

        <div class="pd-price">
            @if($product->is_sale_active)
                ₱{{ number_format($product->sale_price, 2) }}
                <span style="font-size:14px; color:#9ca3af; text-decoration:line-through; margin-left:8px;">₱{{ number_format($product->price, 2) }}</span>
            @else
                ₱{{ number_format($product->price, 2) }}
            @endif
        </div>

        <p class="pd-desc">{{ $product->short_description ?? $product->animal_description }}</p>

        @if($product->stock > 4)
            <div class="pd-stock">✓ In Stock ({{ $product->stock }} available)</div>
        @elseif($product->stock > 0)
            <div class="pd-stock" style="color: #e67e22;">🔥 Only {{ $product->stock }} left — order soon!</div>
        @else
            <div class="pd-stock out">✕ Out of Stock</div>
        @endif

        @auth
            <div style="display: flex; gap: 10px; margin-top: 15px; align-items: center; flex-wrap: wrap;">
                <form action="{{ route('cart.add') }}" method="POST" class="pd-add-form pd-add-cart-form" style="margin: 0; flex: 1; display:flex;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div style="display: flex; gap: 10px; width: 100%;">
                        <div class="pd-qty-wrap" style="height: 48px;">
                            <button type="button" class="pd-qty-btn" style="height: 100%; border-radius: 0;" onclick="let v=this.nextElementSibling;v.value=Math.max(1,+v.value-1)">−</button>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="pd-qty-input" style="height: 100%;" readonly>
                            <button type="button" class="pd-qty-btn" style="height: 100%; border-radius: 0;" onclick="let v=this.previousElementSibling;let mx=+(v.getAttribute('max')||999);v.value=Math.min(mx,+v.value+1)">+</button>
                        </div>
                        <button type="submit" class="pd-add-btn" style="height: 48px; border-radius: 10px;" {{ $product->stock < 1 ? 'disabled style="opacity:.5;cursor:not-allowed;"' : '' }}>🛒 {{ $product->stock < 1 ? 'Out of Stock' : 'Add to Cart' }}</button>
                    </div>
                </form>

                @if($product->stock > 0)
                    <form action="{{ route('cart.buy-now') }}" method="POST" class="pd-add-form pd-buy-now-form" style="margin: 0; flex: 1;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1" class="pd-buy-now-qty">
                        <button type="submit" class="pd-add-btn" style="background:#3b82f6; width: 100%; height: 48px; border-radius: 10px;">⚡ Buy Now</button>
                    </form>
                    <script>
                        (function() {
                            var qtyInput = document.querySelector('.pd-add-cart-form input[name="quantity"]');
                            var buyNowQty = document.querySelector('.pd-buy-now-form .pd-buy-now-qty');
                            if (!qtyInput || !buyNowQty) return;
                            var syncQty = function() { buyNowQty.value = qtyInput.value || 1; };
                            qtyInput.addEventListener('change', syncQty);
                            qtyInput.addEventListener('input', syncQty);
                        })();
                    </script>
                @endif
                
                {{-- Wishlist Button --}}
                <form action="{{ route('wishlist.toggle') }}" method="POST" style="margin: 0; height: 48px;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" style="height: 100%; width: 48px; border-radius: 10px; background: #fff1f2; border: 1px solid #fecdd3; color: #e11d48; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" title="Toggle Wishlist" onmouseover="this.style.background='#ffe4e6'" onmouseout="this.style.background='#fff1f2'">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="{{ (Auth::check() && \App\Models\Wishlist::where('user_id', Auth::id())->where('product_id', $product->id)->exists()) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    </button>
                </form>
            </div>
        @else
            <div style="display: flex; gap: 10px; margin-top: 15px; align-items: center;">
                <a href="{{ route('login') }}" class="pd-add-btn" style="flex: 1; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center; box-sizing: border-box; height: 48px;">🛒 Add to Cart</a>
                @if($product->stock > 0)
                <a href="{{ route('login') }}" class="pd-add-btn" style="flex: 1; background: #3b82f6; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center; box-sizing: border-box; height: 48px;">⚡ Buy Now</a>
                @endif
                <a href="{{ route('login') }}" style="height: 48px; width: 48px; border-radius: 10px; background: #fff1f2; border: 1px solid #fecdd3; color: #e11d48; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" title="Add to Wishlist">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                </a>
            </div>
        @endauth
    </div>
</div>

{{-- ═══ REVIEWS SECTION ═══ --}}
<div class="rv-section">
    <h2>⭐ Customer Reviews</h2>

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

    {{-- Write Review Form --}}
    @php
        $hasBought = false;
        if (Auth::check()) {
            $hasBought = \App\Models\Order::where('user_id', Auth::id())
                ->where('order_status', \App\Models\Order::STATUS_DELIVERED)
                ->whereHas('orderItems', function ($query) use ($product) {
                    $query->where('product_id', $product->id);
                })->exists();
        }
    @endphp
    @auth
        @if($hasBought)
        <div class="rv-write">
            <h3>Write a Review</h3>
            <form action="{{ route('review.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="rv-star-input">
                    @for($i = 5; $i >= 1; $i--)
                    <input type="radio" name="rating" id="modal-star{{ $i }}" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                    <label for="modal-star{{ $i }}">★</label>
                    @endfor
                </div>
                <textarea name="comment" class="rv-textarea" placeholder="Share your experience with this product..."></textarea>
                <div class="rv-img-upload">
                    <label class="rv-img-label">📷 Add photos (max 4)</label>
                    <input type="file" name="review_images[]" multiple accept="image/*" onchange="window.previewImages(this)" style="font-size:13px;">
                    <div class="rv-img-preview" id="imgPreview"></div>
                </div>
                <button type="submit" class="rv-submit">Submit Review</button>
            </form>
        </div>
        @else
        <div class="rv-login-cta" style="background:#f9fafb; padding:20px; border-radius:10px; text-align:center; color:#6b7280; font-size:14px; margin-bottom:24px;">
            You must purchase and receive this product to write a review.
        </div>
        @endif
    @else
    <div class="rv-login-cta">
        <a href="{{ route('login') }}">Log in</a> to write a review
    </div>
    @endauth

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


