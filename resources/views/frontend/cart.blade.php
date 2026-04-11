@extends('frontend.layouts.app')

@section('title', 'Shopping Cart - PetMarkt-PH')

@push('styles')
<style>
    body.user-dashboard { background: #fdf5ec; }
    /* ========== PAGE WRAPPER ========== */
    .cart-page { max-width: 1100px; margin: 0 auto; padding: 32px 20px 60px; }
    .cart-heading { font-size: 26px; font-weight: 800; color: #222; margin: 0 0 4px; }
    .cart-sub     { font-size: 13px; color: #888; margin: 0 0 24px; }

    /* ========== LAYOUT ========== */
    .cart-layout { display: flex; gap: 24px; align-items: flex-start; }
    .cart-items-col { flex: 1; min-width: 0; }
    .cart-summary-col { width: 290px; flex-shrink: 0; }

    /* ========== ITEM CARDS ========== */
    .cart-item-card {
        background: white; border-radius: 14px;
        padding: 0; margin-bottom: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,.07);
        display: flex; overflow: hidden;
    }
    .cart-item-img {
        width: 160px; height: 160px; flex-shrink: 0;
        object-fit: cover;
    }
    .cart-item-body { flex: 1; padding: 18px 16px 14px; }
    .cart-item-name {
        font-size: 15px; font-weight: 700; color: #222; margin: 0 0 4px;
    }
    .cart-item-tag {
        display: inline-block; font-size: 11.5px; font-weight: 600;
        color: #3b7c42; background: #fff4ec; border-radius: 20px;
        padding: 2px 10px; margin-bottom: 6px;
    }
    .cart-item-details { font-size: 12.5px; color: #888; margin-bottom: 4px; }
    .cart-item-status-in   { font-size: 12px; color: #3DB868; font-weight: 600; }
    .cart-item-status-low  { font-size: 12px; color: #3b7c42; font-weight: 600; }
    .cart-item-wishlist    { font-size: 12px; color: #3b7c42; text-decoration: none; font-weight: 600; }
    .cart-item-wishlist:hover { text-decoration: underline; }

    /* Qty + price row */
    .cart-item-bottom {
        display: flex; align-items: center;
        justify-content: space-between; margin-top: 12px;
    }
    .qty-label { font-size: 12px; color: #888; margin-bottom: 4px; }
    .qty-control {
        display: flex; align-items: center; gap: 0;
        border: 1.5px solid #ddd; border-radius: 8px; overflow: hidden;
        width: fit-content;
    }
    .qty-btn {
        width: 32px; height: 32px; background: white; border: none;
        font-size: 18px; cursor: pointer; line-height: 1;
        color: #555; transition: background .15s;
    }
    .qty-btn:hover { background: #f5f5f5; }
    .qty-val {
        width: 32px; text-align: center;
        font-size: 14px; font-weight: 700; color: #222;
        border: none; outline: none;
    }
    .cart-item-price-col { text-align: right; }
    .each-label  { font-size: 11.5px; color: #aaa; }
    .item-total  { font-size: 17px; font-weight: 800; color: #3b7c42; }
    .delete-btn  {
        background: #fee2e2; border: none; cursor: pointer;
        font-size: 15px; color: #ef4444; 
        width: 36px; height: 36px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        transition: all .2s; margin-left: auto;
    }
    .delete-btn:hover { background: #fecaca; color: #dc2626; }

    /* ========== ORDER SUMMARY ========== */
    .order-summary-card {
        background: white; border-radius: 14px;
        padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,.07);
        position: sticky; top: 20px;
    }
    .summary-title { font-size: 16px; font-weight: 800; color: #222; margin: 0 0 20px; }
    .summary-row {
        display: flex; justify-content: space-between;
        align-items: center; font-size: 13.5px; color: #555;
        margin-bottom: 12px;
    }
    .summary-row.total {
        font-size: 16px; font-weight: 800; color: #222;
        border-top: 1px solid #eee; padding-top: 14px;
        margin-top: 4px;
    }
    .summary-row.total .total-val { color: #3b7c42; font-size: 20px; }
    .free-ship { color: #3DB868; font-weight: 700; font-size: 13px; }
    .promo-link {
        font-size: 12px; color: #888; cursor: pointer;
        display: block; margin-bottom: 18px;
    }
    .promo-link:hover { color: #3b7c42; }
    .btn-checkout {
        width: 100%; padding: 14px;
        background: #3b7c42; color: white;
        border: none; border-radius: 10px;
        font-size: 15px; font-weight: 800;
        cursor: pointer; transition: opacity .2s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-checkout:hover { opacity: .9; }

    /* Trust badges */
    .trust-badges {
        display: flex; justify-content: space-between;
        gap: 6px; margin-top: 14px; text-align: center;
    }
    .trust-badge { font-size: 10px; color: #888; display: flex; flex-direction: column; align-items: center; gap: 3px; }
    .trust-badge svg { width: 18px; height: 18px; color: #aaa; }

    /* Payment icons */
    .payment-icons { display: flex; justify-content: center; gap: 6px; margin-top: 12px; }
    .payment-icon {
        background: #f5f5f5; border-radius: 5px;
        padding: 4px 8px; font-size: 11px; font-weight: 700; color: #555;
    }

    /* ========== CONTINUE / CLEAR ========== */
    .cart-footer-row {
        display: flex; justify-content: space-between;
        align-items: center; margin-top: 16px;
    }
    .continue-link { 
        padding: 8px 20px; border-radius: 20px;
        font-size: 13px; color: #3b7c42; text-decoration: none; font-weight: 600; 
        background: #fff4ec; transition: all .2s;
        display: inline-flex; align-items: center; justify-content: center;
    }
    .continue-link:hover { background: #ffe6d5; }
    .btn-clear-cart {
        padding: 8px 16px;
        border: 1.5px solid #ffcdd2; background: white;
        border-radius: 20px; font-size: 13px; color: #ef4444;
        cursor: pointer; transition: all .2s;
        display: inline-flex; align-items: center; justify-content: center; text-decoration: none;
    }
    .btn-clear-cart:hover { background: #fee2e2; border-color: #fca5a5; }

    /* ========== YOU MIGHT ALSO LIKE ========== */
    .ymal-section { margin-top: 48px; }
    .ymal-title { font-size: 22px; font-weight: 800; color: #222; text-align: center; margin-bottom: 24px; }
    .ymal-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; }
    .ymal-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,.07); }
    .ymal-img   { width: 100%; height: 160px; object-fit: cover; }
    .ymal-body  { padding: 12px; }
    .ymal-name  { font-size: 13px; font-weight: 600; color: #222; margin: 0 0 4px; }
    .ymal-price { font-size: 14px; font-weight: 800; color: #3b7c42; }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .cart-page { padding: 16px 12px 100px; }
        .cart-heading { font-size: 20px; }
        .cart-sub { font-size: 12px; margin-bottom: 16px; }

        .cart-layout { flex-direction: column; gap: 16px; }
        .cart-summary-col { width: 100%; position: static; margin-top: 0; }

        /* Compact horizontal cart items */
        .cart-item-card {
            flex-direction: row;
            border-radius: 10px;
            margin-bottom: 10px;
            box-shadow: 0 1px 6px rgba(0,0,0,.06);
        }
        .cart-item-img {
            width: 90px; height: 90px;
            flex-shrink: 0;
            border-radius: 10px 0 0 10px;
        }
        .cart-item-body { padding: 10px 12px 8px; }
        .cart-item-name { font-size: 13px; margin-bottom: 2px; }
        .cart-item-tag { font-size: 10px; padding: 1px 7px; margin-bottom: 3px; }
        .cart-item-details { font-size: 11px; margin-bottom: 2px; }
        .cart-item-status-in,
        .cart-item-status-low { font-size: 11px; }
        .cart-item-wishlist { font-size: 11px; }

        .cart-item-bottom {
            flex-direction: row;
            align-items: center;
            gap: 8px;
            margin-top: 6px;
        }
        .qty-label { font-size: 0; margin: 0; height: 0; overflow: hidden; }
        .qty-control { border-width: 1px; }
        .qty-btn { width: 26px; height: 26px; font-size: 14px; }
        .qty-val { width: 26px; font-size: 12px; }
        .cart-item-price-col { text-align: right; }
        .each-label { font-size: 10px; }
        .item-total { font-size: 14px; }
        .delete-btn { font-size: 15px; margin-left: 6px; }

        /* Order summary compact */
        .order-summary-card { padding: 16px; border-radius: 10px; }
        .summary-title { font-size: 14px; margin-bottom: 14px; }
        .summary-row { font-size: 12.5px; margin-bottom: 8px; }
        .summary-row.total { font-size: 14px; }
        .summary-row.total .total-val { font-size: 18px; }
        .btn-checkout { font-size: 14px; padding: 12px; border-radius: 8px; }
        .trust-badges { gap: 4px; margin-top: 10px; }
        .trust-badge { font-size: 9px; }

        /* You might also like */
        .ymal-section { margin-top: 28px; }
        .ymal-title { font-size: 18px; margin-bottom: 16px; }
        .ymal-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
        .ymal-card { border-radius: 8px; }
        .ymal-img { height: 120px; }
        .ymal-body { padding: 8px; }
        .ymal-name { font-size: 12px; }
        .ymal-price { font-size: 13px; }

        /* Footer buttons */
        .cart-footer-row { margin-top: 10px; }
        .continue-link { font-size: 12px; }
        .btn-clear-cart { padding: 6px 14px; font-size: 12px; }
    }
    @media (max-width: 480px) {
        .cart-item-img { width: 75px; height: 75px; }
        .cart-item-name { font-size: 12px; }
        .item-total { font-size: 13px; }
        .ymal-img { height: 100px; }
    }
</style>
@endpush

@section('content')
<div class="cart-page">
    @if(session('error'))
        <div style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; border-radius: 10px; padding: 12px 16px; margin-bottom: 16px; font-size: 14px; font-weight: 600;">
            ⚠️ {{ session('error') }}
        </div>
    @endif
    @if(session('message'))
        <div style="background: #dcfce7; color: #16a34a; border: 1px solid #86efac; border-radius: 10px; padding: 12px 16px; margin-bottom: 16px; font-size: 14px; font-weight: 600;">
            ✓ {{ session('message') }}
        </div>
    @endif
    <h1 class="cart-heading">Shopping Cart</h1>
    <p class="cart-sub">({{ $cart->items->count() }} items in your cart)</p>

    <div class="cart-layout">
        {{-- ══════════════════ ITEMS ══════════════════ --}}
        <div class="cart-items-col">
            @forelse($cart->items as $item)
                <div class="cart-item-card">
                    <img class="cart-item-img"
                        src="{{ $item->product->image_url }}"
                        alt="{{ $item->product->product_name }}">
                    <div class="cart-item-body">
                        <h3 class="cart-item-name">{{ $item->product->product_name }}</h3>
                        <span class="cart-item-tag">🐕 {{ $item->product->category->category_name ?? 'Pet' }}</span>
                        <div class="cart-item-details">{{ $item->product->short_description }}</div>
                        @php $itemStock = $item->product->stock; @endphp
                        @if($itemStock > 4)
                            <div class="cart-item-status-in">✓ In Stock ({{ $itemStock }} available)</div>
                        @elseif($itemStock > 0)
                            <div class="cart-item-status-low" style="color: #e67e22;">🔥 Only {{ $itemStock }} left!</div>
                        @else
                            <div style="font-size: 12px; color: #ef4444; font-weight: 600;">✗ Out of Stock</div>
                        @endif
                        
                        <div class="cart-item-bottom">
                            <div>
                                <div class="qty-label">Qty</div>
                                <div class="qty-control">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: flex; align-items: center;">
                                        @csrf
                                        <button type="button" class="qty-btn" onclick="let v=this.form.quantity;if(+v.value>1){v.value=+v.value-1;this.form.submit();}">−</button>
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" class="qty-val" readonly>
                                        <button type="button" class="qty-btn" onclick="let v=this.form.quantity;let mx={{ $itemStock }};if(+v.value<mx){v.value=+v.value+1;this.form.submit();}else{alert('Only '+mx+' unit(s) available.')}">+</button>
                                    </form>
                                </div>
                            </div>
                            <div class="cart-item-price-col">
                                <div class="each-label">₱{{ number_format($item->unit_price, 2) }} each</div>
                                <div class="item-total">₱{{ number_format($item->subtotal, 2) }}</div>
                            </div>
                            <a href="{{ route('cart.remove', $item->id) }}" class="delete-btn" title="Remove">🗑</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="cart-item-card" style="padding: 40px; justify-content: center; align-items: center; flex-direction: column;">
                    <p>Your cart is empty.</p>
                    <a href="{{ route('shop.all') }}" class="btn-checkout" style="width: auto; margin-top: 20px;">Continue Shopping</a>
                </div>
            @endforelse
        </div>

        {{-- ══════════════════ SUMMARY ══════════════════ --}}
        @if($cart->items->isNotEmpty())
        <div class="cart-summary-col">
            <div class="order-summary-card">
                <h2 class="summary-title">Order Summary</h2>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>₱{{ number_format($cart->items->sum('subtotal'), 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span class="free-ship">FREE</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span class="total-val">₱{{ number_format($cart->items->sum('subtotal'), 2) }}</span>
                </div>

                <a href="{{ route('checkout') }}" class="btn-checkout" style="text-decoration: none;">
                    Proceed to Checkout
                </a>

                <div class="trust-badges">
                    <div class="trust-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Secure
                    </div>
                    <div class="trust-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                        Quality
                    </div>
                    <div class="trust-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        Fast
                    </div>
                </div>
            </div>
            
            <div class="cart-footer-row">
                <a href="{{ route('shop.all') }}" class="continue-link">← Continue Shopping</a>
                <a href="{{ route('cart.clear') }}" class="btn-clear-cart" style="text-decoration: none;">Clear Cart</a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection


