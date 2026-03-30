@extends('frontend.layouts.app')

@section('title', $product->product_name . ' - Pet Animixon')

@push('styles')
<style>
/* ═══ Product Detail Page ═══ */
.pd-page { max-width: 1100px; margin: 0 auto; padding: 24px 20px 60px; }
.pd-breadcrumb { font-size: 13px; color: #888; margin-bottom: 18px; }
.pd-breadcrumb a { color: #FF8C42; text-decoration: none; }

.pd-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; margin-bottom: 40px; }

/* Gallery */
.pd-gallery { border-radius: 14px; overflow: hidden; background: #f8f8f8; }
.pd-main-img { width: 100%; aspect-ratio: 1; object-fit: cover; }

/* Info */
.pd-info { display: flex; flex-direction: column; gap: 12px; }
.pd-category { font-size: 12px; text-transform: uppercase; letter-spacing: .5px; color: #FF8C42; font-weight: 700; }
.pd-name { font-size: 24px; font-weight: 800; color: #222; margin: 0; line-height: 1.3; }
.pd-rating-row { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.pd-stars { color: #FFB800; font-size: 16px; letter-spacing: 2px; }
.pd-rating-num { font-size: 14px; font-weight: 700; color: #222; }
.pd-rating-count { font-size: 13px; color: #888; }
.pd-sold { font-size: 13px; color: #666; background: #f5f5f5; padding: 4px 10px; border-radius: 6px; }
.pd-price { font-size: 28px; font-weight: 800; color: #FF8C42; }
.pd-desc { font-size: 14px; color: #555; line-height: 1.7; }
.pd-stock { font-size: 13px; color: #3DB868; font-weight: 600; }
.pd-stock.out { color: #e53935; }

.pd-add-form { display: flex; align-items: center; gap: 12px; margin-top: 8px; }
.pd-qty-wrap { display: flex; align-items: center; border: 2px solid #eee; border-radius: 8px; overflow: hidden; }
.pd-qty-btn { width: 38px; height: 38px; border: none; background: #f8f8f8; font-size: 18px; cursor: pointer; font-weight: 700; color: #555; }
.pd-qty-btn:hover { background: #eee; }
.pd-qty-input { width: 44px; height: 38px; border: none; text-align: center; font-size: 15px; font-weight: 600; }
.pd-add-btn { flex: 1; padding: 12px 24px; background: #FF8C42; color: #fff; border: none; border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer; transition: opacity .2s; min-height: 48px; }
.pd-add-btn:hover { opacity: .88; }

/* ═══ Reviews Section ═══ */
.rv-section { margin-top: 32px; }
.rv-section h2 { font-size: 20px; font-weight: 800; color: #222; margin: 0 0 20px; }

/* Review summary */
.rv-summary { display: flex; gap: 24px; padding: 24px; background: #fff; border-radius: 14px; box-shadow: 0 2px 10px rgba(0,0,0,.05); margin-bottom: 24px; }
.rv-avg { text-align: center; min-width: 120px; }
.rv-avg-num { font-size: 48px; font-weight: 800; color: #222; line-height: 1; }
.rv-avg-stars { color: #FFB800; font-size: 18px; margin: 6px 0 4px; }
.rv-avg-count { font-size: 13px; color: #888; }
.rv-bars { flex: 1; display: flex; flex-direction: column; gap: 6px; justify-content: center; }
.rv-bar-row { display: flex; align-items: center; gap: 8px; font-size: 13px; }
.rv-bar-label { width: 14px; font-weight: 700; color: #555; text-align: right; }
.rv-bar-star { color: #FFB800; font-size: 12px; }
.rv-bar-track { flex: 1; height: 8px; background: #f0f0f0; border-radius: 4px; overflow: hidden; }
.rv-bar-fill { height: 100%; background: #FFB800; border-radius: 4px; transition: width .3s; }
.rv-bar-count { width: 24px; font-size: 12px; color: #888; text-align: right; }

/* Write review */
.rv-write { background: #fff; border-radius: 14px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,.05); margin-bottom: 24px; }
.rv-write h3 { font-size: 16px; font-weight: 700; margin: 0 0 14px; }
.rv-star-input { display: flex; gap: 4px; margin-bottom: 12px; flex-direction: row-reverse; justify-content: flex-end; }
.rv-star-input input { display: none; }
.rv-star-input label { font-size: 28px; color: #ddd; cursor: pointer; transition: color .15s; }
.rv-star-input label:hover, .rv-star-input label:hover ~ label, .rv-star-input input:checked ~ label { color: #FFB800; }
.rv-textarea { width: 100%; border: 2px solid #eee; border-radius: 10px; padding: 12px; font-size: 14px; resize: vertical; min-height: 80px; font-family: inherit; }
.rv-textarea:focus { border-color: #FF8C42; outline: none; }
.rv-img-upload { margin: 12px 0; }
.rv-img-label { font-size: 13px; color: #666; margin-bottom: 6px; display: block; }
.rv-img-preview { display: flex; gap: 8px; margin-top: 8px; flex-wrap: wrap; }
.rv-img-thumb { width: 60px; height: 60px; border-radius: 6px; object-fit: cover; border: 2px solid #eee; }
.rv-submit { padding: 12px 28px; background: #FF8C42; color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; min-height: 48px; }
.rv-submit:hover { opacity: .88; }

/* Review card */
.rv-list { display: flex; flex-direction: column; gap: 16px; }
.rv-card { background: #fff; border-radius: 14px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,.05); }
.rv-card-header { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
.rv-avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #FF8C42, #FFB800); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 14px; flex-shrink: 0; }
.rv-user-name { font-size: 14px; font-weight: 700; color: #222; }
.rv-date { font-size: 12px; color: #aaa; margin-left: auto; }
.rv-card-stars { color: #FFB800; font-size: 14px; margin-bottom: 6px; }
.rv-card-text { font-size: 14px; color: #444; line-height: 1.6; margin-bottom: 10px; }
.rv-card-images { display: flex; gap: 8px; margin-bottom: 12px; flex-wrap: wrap; }
.rv-card-img { width: 80px; height: 80px; border-radius: 8px; object-fit: cover; cursor: pointer; border: 1px solid #eee; transition: transform .2s; }
.rv-card-img:hover { transform: scale(1.05); }

/* Like & Reply */
.rv-actions { display: flex; gap: 16px; align-items: center; padding-top: 8px; border-top: 1px solid #f5f5f5; }
.rv-like-btn { display: flex; align-items: center; gap: 4px; background: none; border: none; font-size: 13px; color: #888; cursor: pointer; padding: 6px 10px; border-radius: 6px; transition: all .2s; min-height: 36px; min-width: auto; }
.rv-like-btn:hover, .rv-like-btn.liked { color: #e53935; background: #FFF0F0; }
.rv-like-btn.liked svg { fill: #e53935; }
.rv-reply-toggle { background: none; border: none; font-size: 13px; color: #888; cursor: pointer; padding: 6px 10px; border-radius: 6px; min-height: 36px; min-width: auto; }
.rv-reply-toggle:hover { color: #FF8C42; background: #FFF4EC; }

/* Replies */
.rv-replies { margin-top: 12px; padding-left: 20px; border-left: 3px solid #f0f0f0; }
.rv-reply { padding: 10px 0; border-bottom: 1px solid #f8f8f8; }
.rv-reply:last-child { border-bottom: none; }
.rv-reply-name { font-size: 13px; font-weight: 700; color: #333; }
.rv-reply-text { font-size: 13px; color: #555; margin-top: 2px; }
.rv-reply-date { font-size: 11px; color: #aaa; }
.rv-reply-form { display: flex; gap: 8px; margin-top: 8px; }
.rv-reply-input { flex: 1; padding: 8px 12px; border: 2px solid #eee; border-radius: 8px; font-size: 13px; font-family: inherit; }
.rv-reply-input:focus { border-color: #FF8C42; outline: none; }
.rv-reply-submit { padding: 8px 16px; background: #FF8C42; color: #fff; border: none; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; min-height: 36px; min-width: auto; }

/* Image lightbox */
.rv-lightbox { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,.85); z-index: 9999; align-items: center; justify-content: center; }
.rv-lightbox.active { display: flex; }
.rv-lightbox img { max-width: 90vw; max-height: 90vh; border-radius: 8px; }
.rv-lightbox-close { position: absolute; top: 16px; right: 20px; color: #fff; font-size: 28px; cursor: pointer; background: none; border: none; min-height: auto; min-width: auto; }

.rv-no-reviews { text-align: center; padding: 40px 20px; color: #888; font-size: 15px; }
.rv-login-cta { text-align: center; padding: 20px; background: #fff4ec; border-radius: 10px; margin-bottom: 24px; }
.rv-login-cta a { color: #FF8C42; font-weight: 700; text-decoration: none; }

/* Responsive */
@media (max-width: 768px) {
    .pd-layout { grid-template-columns: 1fr; gap: 16px; }
    .pd-name { font-size: 20px; }
    .pd-price { font-size: 22px; }
    .rv-summary { flex-direction: column; gap: 16px; padding: 18px; }
    .rv-avg { min-width: auto; }
    .rv-write, .rv-card { padding: 16px; }
    .rv-card-img { width: 60px; height: 60px; }
}
</style>
@endpush

@section('content')
<div class="pd-page">
    {{-- Breadcrumb --}}
    <div class="pd-breadcrumb">
        <a href="{{ route('shop') }}">Home</a> /
        <a href="{{ route('shop.all') }}">Shop</a> /
        @if($product->category)
        <a href="{{ route('categories.show', $product->category->id) }}">{{ $product->category->category_name }}</a> /
        @endif
        {{ $product->product_name }}
    </div>

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
                    <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                    <label for="star{{ $i }}">★</label>
                    @endfor
                </div>
                <textarea name="comment" class="rv-textarea" placeholder="Share your experience with this product..."></textarea>
                <div class="rv-img-upload">
                    <label class="rv-img-label">📷 Add photos (max 4)</label>
                    <input type="file" name="review_images[]" multiple accept="image/*" onchange="previewImages(this)" style="font-size:13px;">
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
                    <img class="rv-card-img" src="{{ $imgUrl }}" alt="Review photo" onclick="openLightbox('{{ $imgUrl }}')">
                    @endforeach
                </div>
                @endif

                {{-- Like & Reply --}}
                <div class="rv-actions">
                    @auth
                    <button class="rv-like-btn {{ $review->isLikedBy(Auth::id()) ? 'liked' : '' }}" onclick="toggleLike({{ $review->id }}, this)">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        <span>{{ $review->likes->count() }}</span>
                    </button>
                    <button class="rv-reply-toggle" onclick="toggleReplyForm({{ $review->id }})">💬 Reply ({{ $review->replies->count() }})</button>
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
</div>

{{-- Image Lightbox --}}
<div class="rv-lightbox" id="lightbox" onclick="closeLightbox()">
    <button class="rv-lightbox-close">&times;</button>
    <img id="lightboxImg" src="" alt="Review photo">
</div>

@push('scripts')
<script>
function previewImages(input) {
    const container = document.getElementById('imgPreview');
    container.innerHTML = '';
    const files = Array.from(input.files).slice(0, 4);
    // Limit file input to 4
    if (input.files.length > 4) {
        alert('Maximum 4 images allowed');
        const dt = new DataTransfer();
        files.forEach(f => dt.items.add(f));
        input.files = dt.files;
    }
    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'rv-img-thumb';
            container.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}

function toggleLike(reviewId, btn) {
    fetch(`/review/${reviewId}/like`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        btn.classList.toggle('liked', data.liked);
        btn.querySelector('span').textContent = data.count;
    });
}

function toggleReplyForm(reviewId) {
    const el = document.getElementById('replies-' + reviewId);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}

function openLightbox(src) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightbox').classList.add('active');
}

function closeLightbox() {
    document.getElementById('lightbox').classList.remove('active');
}
</script>
@endpush
@endsection
