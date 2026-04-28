@extends('frontend.layouts.app')

@section('title', 'My Orders - Pet Markt-PH')

@push('styles')
<style>
/* ── Orders Page ── */
.mo-page { width: 100%; padding: 32px 2rem 60px; }

/* Header */
.mo-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; flex-wrap: wrap; gap: 12px; }
.mo-heading { font-size: 28px; font-weight: 800; color: #1a1a2e; }
.mo-heading span { color: var(--ud-orange); }
.mo-subtitle { font-size: 14px; color: #888; margin-top: 4px; }

/* Stats Cards */
.mo-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 14px; margin-bottom: 28px; }
.mo-stat-card {
    background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 18px 16px;
    display: flex; align-items: center; gap: 12px; transition: all 0.2s;
}
.mo-stat-card:hover { border-color: var(--ud-orange); transform: translateY(-2px); box-shadow: 0 6px 16px rgba(232,93,4,0.08); }
.mo-stat-icon {
    width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.mo-stat-icon.total { background: #e9f2ea; color: var(--ud-orange); }
.mo-stat-icon.pending { background: #fff8e1; color: #ff9800; }
.mo-stat-icon.out_for_delivery { background: #e3f2fd; color: #1e88e5; }
.mo-stat-icon.shipped { background: #f3e5f5; color: #9c27b0; }
.mo-stat-icon.delivered { background: #e8f5e9; color: #4caf50; }
.mo-stat-num { font-size: 22px; font-weight: 800; color: #1a1a2e; }
.mo-stat-label { font-size: 12px; color: #999; }

/* Status Tabs */
.mo-tabs { display: flex; gap: 8px; margin-bottom: 24px; flex-wrap: wrap; }
.mo-tab {
    display: inline-flex; align-items: center; justify-content: center; gap: 6px;
    padding: 8px 18px; border-radius: 20px; background: #f5f5f5; color: #666;
    font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s;
    border: 1px solid transparent;
}
.mo-tab:hover { background: #fdf3ed; color: var(--ud-orange); border-color: #fce0cc; }
.mo-tab.active { background: var(--ud-orange); color: #fff; border-color: var(--ud-orange); }
.mo-tab .mo-tab-count {
    background: rgba(255,255,255,0.3); padding: 2px 8px; border-radius: 10px;
    font-size: 11px; margin-left: 0; line-height: 1; display: inline-flex; align-items: center; justify-content: center;
}
.mo-tab.active .mo-tab-count { background: rgba(255,255,255,0.3); }
.mo-tab:not(.active) .mo-tab-count { background: #e0e0e0; color: #666; }

/* Order Cards */
.mo-order-list { display: flex; flex-direction: column; gap: 16px; }
.mo-order-card {
    background: #fff; border: 1px solid #eee; border-radius: 14px; padding: 20px 24px;
    transition: all 0.2s; position: relative; overflow: hidden;
}
.mo-order-card:hover { border-color: var(--ud-orange); box-shadow: 0 6px 20px rgba(232,93,4,0.07); }
.mo-order-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 8px; }
.mo-order-id { font-weight: 700; font-size: 15px; color: var(--ud-orange); text-decoration: none; }
.mo-order-id:hover { text-decoration: underline; }
.mo-order-date { font-size: 13px; color: #999; }
.mo-badge {
    padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;
    text-transform: capitalize; display: inline-flex; align-items: center; justify-content: center;
}
.mo-badge.pending { background: #e9f2ea; color: #e65100; }
.mo-badge.out_for_delivery, .mo-badge.out_for_delivery { background: #e1f5fe; color: #0277bd; }
.mo-badge.shipped { background: #f3e5f5; color: #7b1fa2; }
.mo-badge.delivered { background: #e8f5e9; color: #2e7d32; }
.mo-badge.cancelled { background: #fbe9e7; color: #c62828; }

/* Products row */
.mo-products { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; margin-bottom: 16px; }
.mo-product-item { display: flex; align-items: center; gap: 10px; background: #fafafa; border-radius: 10px; padding: 8px 12px 8px 8px; }
.mo-product-img { width: 48px; height: 48px; border-radius: 8px; object-fit: cover; background: #eee; flex-shrink: 0; border: 1px solid #eee; }
.mo-product-name { font-size: 13px; font-weight: 600; color: #333; max-width: 160px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.mo-product-qty { font-size: 12px; color: #999; }
.mo-product-more {
    width: 48px; height: 48px; border-radius: 8px; background: #f0f0f0;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700; color: #666;
}

/* Bottom row */
.mo-order-bottom { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; padding-top: 14px; border-top: 1px solid #f0f0f0; }
.mo-total-label { font-size: 13px; color: #999; }
.mo-total-value { font-size: 20px; font-weight: 800; color: #1a1a2e; }
.mo-actions { display: flex; gap: 8px; }
.mo-btn {
    padding: 9px 20px; border-radius: 8px; font-size: 13px; font-weight: 600;
    text-decoration: none; transition: all 0.2s; border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px;
}
.mo-btn-outline { background: #fff; color: #333; border: 1px solid #ddd; }
.mo-btn-outline:hover { border-color: var(--ud-orange); color: var(--ud-orange); }
.mo-btn-primary { background: var(--ud-orange); color: #fff; }
.mo-btn-primary:hover { background: #d14f00; }

/* Empty state */
.mo-empty {
    text-align: center; padding: 60px 20px; background: #fff; border: 1px dashed #ddd;
    border-radius: 14px;
}
.mo-empty-icon { font-size: 56px; margin-bottom: 16px; }
.mo-empty-title { font-size: 20px; font-weight: 700; color: #333; margin-bottom: 8px; }
.mo-empty-text { font-size: 14px; color: #999; margin-bottom: 20px; }

/* Pagination */
.mo-pagination { margin-top: 28px; display: flex; justify-content: center; }

/* Recommended Section */
.mo-rec-section { margin-top: 56px; }
.mo-rec-title { font-size: 22px; font-weight: 800; color: #1a1a2e; margin-bottom: 20px; }
.mo-rec-title span { color: var(--ud-orange); }
.mo-rec-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 18px; }
.mo-rec-card {
    background: #fff; border: 1px solid #eee; border-radius: 14px; overflow: hidden;
    text-decoration: none; color: inherit; transition: all 0.25s; display: block;
}
.mo-rec-card:hover { border-color: var(--ud-orange); transform: translateY(-4px); box-shadow: 0 10px 24px rgba(232,93,4,0.1); }
.mo-rec-img-wrap { width: 100%; aspect-ratio: 1; overflow: hidden; background: #f9f9f9; position: relative; }
.mo-rec-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
.mo-rec-card:hover .mo-rec-img { transform: scale(1.06); }
.mo-rec-body { padding: 14px 16px 18px; }
.mo-rec-brand { font-size: 11px; color: var(--ud-orange); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
.mo-rec-name {
    font-size: 14px; font-weight: 600; color: #222; margin-bottom: 8px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    min-height: 40px;
}
.mo-rec-rating { display: flex; align-items: center; gap: 4px; margin-bottom: 8px; font-size: 13px; }
.mo-rec-stars { color: #facc15; }
.mo-rec-count { color: #999; }
.mo-rec-price { font-size: 18px; font-weight: 800; color: var(--ud-orange); }

@media (max-width: 768px) {
    .mo-page { padding: 20px 14px 40px; }
    .mo-heading { font-size: 22px; }
    .mo-stats { grid-template-columns: repeat(2, 1fr); }
    .mo-order-card { padding: 16px; }
    .mo-product-name { max-width: 100px; }
    .mo-rec-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
}

/* ── REVIEW MODAL ── */
.rm-modal-backdrop {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);
    display: none; align-items: center; justify-content: center;
    z-index: 10000; opacity: 0; transition: opacity 0.3s;
}
.rm-modal-backdrop.open { display: flex; opacity: 1; }

.rm-modal {
    background: #fff; width: 90%; max-width: 500px; border-radius: 20px;
    overflow: hidden; transform: translateY(20px); transition: transform 0.3s;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}
.rm-modal-backdrop.open .rm-modal { transform: translateY(0); }

.rm-header {
    padding: 20px 24px; border-bottom: 1px solid #eee;
    display: flex; justify-content: space-between; align-items: center;
}
.rm-title { font-size: 18px; font-weight: 800; color: #1a1a2e; }
.rm-close { background: none; border: none; font-size: 24px; cursor: pointer; color: #999; }

.rm-body { padding: 24px; }
.rm-product-preview { display: flex; gap: 12px; align-items: center; margin-bottom: 20px; padding: 12px; background: #f9f9f9; border-radius: 12px; }
.rm-product-img { width: 50px; height: 50px; border-radius: 8px; object-fit: cover; }
.rm-product-name { font-size: 14px; font-weight: 700; color: #333; }

.rm-stars-container { display: flex; flex-direction: column; align-items: center; margin-bottom: 24px; }
.rm-stars-label { font-size: 13px; font-weight: 600; color: #666; margin-bottom: 10px; }
.rm-stars { display: flex; gap: 8px; flex-direction: row-reverse; }
.rm-star-input { display: none; }
.rm-star-label { font-size: 32px; color: #ddd; cursor: pointer; transition: color 0.2s; }
.rm-star-input:checked ~ .rm-star-label,
.rm-star-label:hover,
.rm-star-label:hover ~ .rm-star-label { color: #facc15; }

.rm-textarea {
    width: 100%; border: 1px solid #ddd; border-radius: 12px; padding: 12px;
    font-size: 14px; min-height: 100px; resize: vertical; outline: none; transition: border-color 0.2s;
}
.rm-textarea:focus { border-color: var(--ud-orange); }

.rm-upload-section { margin-top: 16px; }
.rm-upload-label { font-size: 13px; font-weight: 600; color: #666; margin-bottom: 8px; display: block; }
.rm-upload-grid { display: flex; gap: 8px; flex-wrap: wrap; }
.rm-upload-btn {
    width: 60px; height: 60px; border: 2px dashed #ddd; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.2s; color: #999;
}
.rm-upload-btn:hover { border-color: var(--ud-orange); color: var(--ud-orange); background: #fff7ed; }
.rm-preview-img { width: 60px; height: 60px; border-radius: 10px; object-fit: cover; border: 1px solid #eee; position: relative; }
.rm-preview-remove {
    position: absolute; top: -5px; right: -5px; background: #ef4444; color: #fff;
    width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center;
    justify-content: center; font-size: 10px; cursor: pointer; border: 2px solid #fff;
}

.rm-footer { padding: 0 24px 24px; display: flex; gap: 12px; }
.rm-btn { flex: 1; padding: 12px; border-radius: 10px; font-weight: 700; font-size: 14px; cursor: pointer; border: none; transition: all 0.2s; }
.rm-btn-cancel { background: #f5f5f5; color: #666; }
.rm-btn-submit { background: var(--ud-orange); color: #fff; }
.rm-btn-submit:hover { background: #d14f00; }
</style>
@endpush

@section('content')
<div class="mo-page">

    {{-- ── HEADER ── --}}
    <div class="mo-header">
        <div>
            <h1 class="mo-heading">My <span>Orders</span></h1>
            <p class="mo-subtitle">Track and manage all your purchases</p>
        </div>
        <a href="{{ route('shop') }}" class="mo-btn mo-btn-primary">🛒 Continue Shopping</a>
    </div>

    {{-- ── STATS CARDS ── --}}
    <div class="mo-stats">
        <div class="mo-stat-card">
            <div class="mo-stat-icon total">📦</div>
            <div>
                <div class="mo-stat-num">{{ $stats['total'] ?? 0 }}</div>
                <div class="mo-stat-label">Total Orders</div>
            </div>
        </div>
        <div class="mo-stat-card">
            <div class="mo-stat-icon pending">⏳</div>
            <div>
                <div class="mo-stat-num">{{ $stats['pending'] ?? 0 }}</div>
                <div class="mo-stat-label">Pending</div>
            </div>
        </div>
        <div class="mo-stat-card">
            <div class="mo-stat-icon out_for_delivery">🛵</div>
            <div>
                <div class="mo-stat-num">{{ $stats['out_for_delivery'] ?? 0 }}</div>
                <div class="mo-stat-label">Out For Delivery</div>
            </div>
        </div>
        <div class="mo-stat-card">
            <div class="mo-stat-icon delivered">✅</div>
            <div>
                <div class="mo-stat-num">{{ $stats['delivered'] ?? 0 }}</div>
                <div class="mo-stat-label">Delivered</div>
            </div>
        </div>
    </div>

    {{-- ── STATUS TABS ── --}}
    @php $sf = $statusFilter ?? 'all'; @endphp
    <div class="mo-tabs">
        <a href="{{ route('orders', ['status' => 'all']) }}" class="mo-tab {{ $sf === 'all' ? 'active' : '' }}">
            All <span class="mo-tab-count">{{ $stats['total'] ?? 0 }}</span>
        </a>
        <a href="{{ route('orders', ['status' => 'pending']) }}" class="mo-tab {{ $sf === 'pending' ? 'active' : '' }}">
            Pending <span class="mo-tab-count">{{ $stats['pending'] ?? 0 }}</span>
        </a>
        <a href="{{ route('orders', ['status' => 'processing']) }}" class="mo-tab {{ $sf === 'processing' ? 'active' : '' }}">
            Processing <span class="mo-tab-count">{{ $stats['processing'] ?? 0 }}</span>
        </a>
        <a href="{{ route('orders', ['status' => 'out_for_delivery']) }}" class="mo-tab {{ $sf === 'out_for_delivery' ? 'active' : '' }}">
            Out For Delivery <span class="mo-tab-count">{{ $stats['out_for_delivery'] ?? 0 }}</span>
        </a>
        <a href="{{ route('orders', ['status' => 'delivered']) }}" class="mo-tab {{ $sf === 'delivered' ? 'active' : '' }}">
            Delivered <span class="mo-tab-count">{{ $stats['delivered'] ?? 0 }}</span>
        </a>
        <a href="{{ route('orders', ['status' => 'cancelled']) }}" class="mo-tab {{ $sf === 'cancelled' ? 'active' : '' }}">
            Cancelled <span class="mo-tab-count">{{ $stats['cancelled'] ?? 0 }}</span>
        </a>
    </div>

    {{-- ── ORDER LIST ── --}}
    @if($orders->isEmpty())
        <div class="mo-empty">
            <div class="mo-empty-icon">📭</div>
            <div class="mo-empty-title">No orders found</div>
            <div class="mo-empty-text">
                @if($sf !== 'all')
                    You don't have any {{ $sf }} orders yet.
                @else
                    You haven't placed any orders yet. Let's change that!
                @endif
            </div>
            <a href="{{ route('shop') }}" class="mo-btn mo-btn-primary">Browse Products</a>
        </div>
    @else
        <div class="mo-order-list">
            @foreach($orders as $order)
                <div class="mo-order-card">
                    {{-- Top Row: ID, Date, Badge --}}
                    <div class="mo-order-top">
                        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                            <a href="{{ route('order.track', $order->order_id) }}" class="mo-order-id">
                                {{ $order->display_id }}
                            </a>
                            <span class="mo-order-date">{{ $order->created_at->format('M j, Y · g:i A') }}</span>
                        </div>
                        <div style="display:flex; gap:8px; align-items:center;">
                            @if($order->isLocal())
                                <span class="mo-badge" style="background:#fef3c7; color:#d97706;">🛵 Local</span>
                            @else
                                <span class="mo-badge" style="background:#fce7f3; color:#be185d;">📦 Courier</span>
                            @endif
                            <span class="mo-badge {{ $order->order_status }}">
                                {{ $order->status_label }}
                            </span>
                        </div>
                    </div>

                    {{-- Products Row --}}
                    <div class="mo-products">
                        @foreach($order->orderItems->take(3) as $item)
                            <div class="mo-product-item">
                                <img src="{{ optional($item->product)->image_url ?? asset('images/placeholder.png') }}" alt="" class="mo-product-img">
                                <div>
                                    <div class="mo-product-name">{{ optional($item->product)->product_name ?? 'Product' }}</div>
                                    <div class="mo-product-qty">x{{ $item->quantity }} · ₱{{ number_format((float)($item->unit_price ?? 0), 2) }}</div>
                                    @if($order->order_status === 'delivered')
                                        @php $userReview = $item->product->reviews->first(); @endphp
                                        @if($userReview)
                                            <button type="button" class="mo-btn-review-sm" 
                                                    onclick="openReviewModal({{ $item->product_id }}, '{{ addslashes($item->product->product_name) }}', '{{ $item->product->image_url }}', {{ $userReview->id }}, {{ $userReview->rating }}, '{{ addslashes($userReview->comment) }}')"
                                                    style="background:none; border:none; color:#16a34a; font-size:11px; font-weight:700; padding:0; cursor:pointer; margin-top:4px;">
                                                ✅ Edited Review
                                            </button>
                                        @else
                                            <button type="button" class="mo-btn-review-sm" 
                                                    onclick="openReviewModal({{ $item->product_id }}, '{{ addslashes($item->product->product_name) }}', '{{ $item->product->image_url }}')"
                                                    style="background:none; border:none; color:var(--ud-orange); font-size:11px; font-weight:700; padding:0; cursor:pointer; margin-top:4px;">
                                                ⭐ Rate Product
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        @if($order->orderItems->count() > 3)
                            <div class="mo-product-more">+{{ $order->orderItems->count() - 3 }}</div>
                        @endif
                    </div>

                    {{-- Bottom Row --}}
                    <div class="mo-order-bottom">
                        <div>
                            <div class="mo-total-label">{{ $order->orderItems->count() }} {{ Str::plural('item', $order->orderItems->count()) }} · Order Total</div>
                            <div class="mo-total-value">₱{{ number_format((float)$order->total_amount, 2) }}</div>
                        </div>
                        <div class="mo-actions">
                            <a href="{{ route('order.track', $order->order_id) }}" class="mo-btn mo-btn-outline">📋 View Details</a>
                            @if($order->order_status === 'out_for_delivery')
                                <a href="{{ route('order.track', $order->order_id) }}" class="mo-btn mo-btn-primary">📍 Track Package</a>
                            @elseif($order->order_status === 'delivered')
                                @php 
                                    $firstItem = $order->orderItems->first(); 
                                    $firstReview = $firstItem ? $firstItem->product->reviews->first() : null;
                                @endphp
                                @if($firstItem)
                                    @if($firstReview)
                                        <button type="button" class="mo-btn mo-btn-outline" style="border-color: #16a34a; color: #16a34a;"
                                                onclick="openReviewModal({{ $firstItem->product_id }}, '{{ addslashes($firstItem->product->product_name) }}', '{{ $firstItem->product->image_url }}', {{ $firstReview->id }}, {{ $firstReview->rating }}, '{{ addslashes($firstReview->comment) }}')">
                                            ✅ Edit Review
                                        </button>
                                    @else
                                        <button type="button" class="mo-btn mo-btn-primary" 
                                                onclick="openReviewModal({{ $firstItem->product_id }}, '{{ addslashes($firstItem->product->product_name) }}', '{{ $firstItem->product->image_url }}')">
                                            ⭐ Write Review
                                        </button>
                                    @endif
                                    <a href="{{ route('returns.create', $firstItem->id) }}" class="mo-btn mo-btn-outline" style="border-color: #ef4444; color: #ef4444;">↩ Return</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
            <div class="mo-pagination">
                {{ $orders->links() }}
            </div>
        @endif
    @endif

    {{-- ── YOU MAY ALSO LIKE ── --}}
    @if(isset($recommendedProducts) && $recommendedProducts->isNotEmpty())
        <div class="mo-rec-section">
            <h3 class="mo-rec-title">You May Also <span>Like</span></h3>
            <div class="mo-rec-grid">
                @foreach($recommendedProducts as $product)
                    <a href="{{ route('product.show', $product->id) }}" class="mo-rec-card js-open-product-modal" data-product-id="{{ $product->id }}">
                        <div class="mo-rec-img-wrap">
                            <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}" class="mo-rec-img">
                        </div>
                        <div class="mo-rec-body">
                            <div class="mo-rec-brand">{{ $product->brand_name ?: 'Pet Markt-PH' }}</div>
                            <h4 class="mo-rec-name">{{ $product->product_name }}</h4>
                            <div class="mo-rec-rating">
                                <span class="mo-rec-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= round($product->avg_rating) ? '★' : '☆' }}
                                    @endfor
                                </span>
                                <span class="mo-rec-count">({{ $product->reviews_count }})</span>
                            </div>
                            <div class="mo-rec-price">₱{{ number_format((float)$product->price, 2) }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>

{{-- ── REVIEW MODAL ── --}}
<div class="rm-modal-backdrop" id="reviewModal">
    <div class="rm-modal">
        <div class="rm-header">
            <h2 class="rm-title">Write a Review</h2>
            <button type="button" class="rm-close" onclick="closeReviewModal()">&times;</button>
        </div>
        <form id="reviewForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="rm-body">
                <div class="rm-product-preview">
                    <img id="rmProductImg" src="" alt="" class="rm-product-img">
                    <div id="rmProductName" class="rm-product-name"></div>
                </div>

                <div class="rm-stars-container">
                    <span class="rm-stars-label">Rate your experience</span>
                    <div class="rm-stars">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="rm-star-input" required>
                            <label for="star{{ $i }}" class="rm-star-label">★</label>
                        @endfor
                    </div>
                </div>

                <textarea name="comment" class="rm-textarea" placeholder="Share your thoughts about this product..." required></textarea>

                <div class="rm-upload-section">
                    <span class="rm-upload-label">Add Photos (Max 4)</span>
                    <div class="rm-upload-grid" id="rmUploadGrid">
                        <label class="rm-upload-btn">
                            <span>+</span>
                            <input type="file" name="review_images[]" multiple accept="image/*" style="display:none;" onchange="handleReviewImages(this)">
                        </label>
                    </div>
                </div>
            </div>
            <div class="rm-footer">
                <button type="button" class="rm-btn rm-btn-cancel" onclick="closeReviewModal()">Cancel</button>
                <button type="submit" class="rm-btn rm-btn-submit">Submit Review</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openReviewModal(productId, productName, productImg, reviewId = null, rating = null, comment = '') {
    const modal = document.getElementById('reviewModal');
    const form = document.getElementById('reviewForm');
    const nameEl = document.getElementById('rmProductName');
    const imgEl = document.getElementById('rmProductImg');
    const titleEl = modal.querySelector('.rm-title');
    const submitBtn = modal.querySelector('.rm-btn-submit');
    const methodContainer = form.querySelector('input[name="_method"]') || document.createElement('input');
    
    // Reset form
    form.reset();
    document.getElementById('rmUploadGrid').querySelectorAll('.rm-preview-img').forEach(p => p.remove());
    
    if (reviewId) {
        titleEl.textContent = 'Edit Your Review';
        submitBtn.textContent = 'Update Review';
        form.action = `/review/${reviewId}`;
        
        // Add PUT method
        methodContainer.type = 'hidden';
        methodContainer.name = '_method';
        methodContainer.value = 'PUT';
        if (!form.contains(methodContainer)) form.appendChild(methodContainer);
        
        // Set rating
        if (rating) {
            const star = document.getElementById(`star${rating}`);
            if (star) star.checked = true;
        }
        
        // Set comment
        form.querySelector('.rm-textarea').value = comment;
        
        // Hide upload section for edit (optional, or just allow it if backend supports it)
        modal.querySelector('.rm-upload-section').style.display = 'none';
    } else {
        titleEl.textContent = 'Write a Review';
        submitBtn.textContent = 'Submit Review';
        form.action = `/product/${productId}/review`;
        
        // Remove PUT method if exists
        const existingMethod = form.querySelector('input[name="_method"]');
        if (existingMethod) existingMethod.remove();
        
        modal.querySelector('.rm-upload-section').style.display = 'block';
    }
    
    nameEl.textContent = productName;
    imgEl.src = productImg;
    
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeReviewModal() {
    const modal = document.getElementById('reviewModal');
    modal.classList.remove('open');
    document.body.style.overflow = '';
}

function handleReviewImages(input) {
    const grid = document.getElementById('rmUploadGrid');
    const existingPreviews = grid.querySelectorAll('.rm-preview-img');
    existingPreviews.forEach(p => p.remove());
    
    if (input.files) {
        Array.from(input.files).slice(0, 4).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'rm-preview-img';
                div.style.backgroundImage = `url(${e.target.result})`;
                div.style.backgroundSize = 'cover';
                div.style.backgroundPosition = 'center';
                div.innerHTML = `<span class="rm-preview-remove" onclick="this.parentElement.remove()">×</span>`;
                grid.insertBefore(div, grid.querySelector('.rm-upload-btn'));
            }
            reader.readAsDataURL(file);
        });
    }
}

// Close on backdrop click
document.getElementById('reviewModal').addEventListener('click', function(e) {
    if (e.target === this) closeReviewModal();
});
</script>
@endpush
@endsection


