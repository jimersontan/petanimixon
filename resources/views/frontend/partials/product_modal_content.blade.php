{{-- Product Layout --}}
<div class="pd-layout">
    <div class="pd-gallery">
        <img class="pd-main-img" src="{{ $product->image_url }}" alt="{{ $product->product_name }}">
    </div>
    <div class="pd-info">
        <div class="pd-category">{{ $product->category->category_name ?? 'General' }}</div>
        <h1 class="pd-name">{{ $product->product_name }}</h1>

        <div class="pd-rating-row">
            <span class="pd-stars">
                @for($i = 1; $i <= 5; $i++)
                    {{ $i <= round($reviewStats['average']) ? '★' : '☆' }}
                @endfor
            </span>
            <span class="pd-rating-num">{{ $reviewStats['average'] }}</span>
            <span class="pd-rating-count">({{ $reviewStats['count'] }} {{ Str::plural('review', $reviewStats['count']) }})</span>
            <span class="pd-sold">{{ $product->total_sold }} sold</span>
        </div>

        <div class="pd-price">₱{{ number_format($product->price, 2) }}</div>

        <p class="pd-desc">{{ $product->short_description ?? $product->animal_description }}</p>

        @if($product->stock > 0)
            <div class="pd-stock">✓ In Stock ({{ $product->stock }} available)</div>
        @else
            <div class="pd-stock out">✕ Out of Stock</div>
        @endif

        <form action="{{ route('cart.add') }}" method="POST" class="pd-add-form">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="pd-qty-wrap">
                <button type="button" class="pd-qty-btn" onclick="let v=this.nextElementSibling;v.value=Math.max(1,+v.value-1)">−</button>
                <input type="number" name="quantity" value="1" min="1" class="pd-qty-input" readonly>
                <button type="button" class="pd-qty-btn" onclick="let v=this.previousElementSibling;v.value=+v.value+1">+</button>
            </div>
            <button type="submit" class="pd-add-btn">🛒 Add to Cart</button>
        </form>
    </div>
</div>

{{-- ═══ REVIEWS SECTION ═══ --}}
<div class="rv-section">
    <h2>⭐ Customer Reviews</h2>

    {{-- Rating Summary --}}
    <div class="rv-summary">
        <div class="rv-avg">
            <div class="rv-avg-num">{{ $reviewStats['average'] }}</div>
            <div class="rv-avg-stars">
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
    @auth
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
