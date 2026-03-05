<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Pet Animixon</title>
    <link rel="stylesheet" href="{{ asset('css/shop_shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
@auth
@include('partials.shop_nav')

<div class="ct-wrap">
    <div class="ct-container">
        <h1 class="ct-title">Shopping Cart <span class="ct-item-count">3 items in your cart</span></h1>

        <div class="ct-layout">
            <!-- Cart Items -->
            <div class="ct-items">
                @php
                $cartItems = [
                    [
                        'name' => 'Premium Dog Food – Chicken & Rice',
                        'img'  => 'https://images.unsplash.com/photo-1589924691995-400dc9ecc119?w=200&h=200&fit=crop',
                        'size' => '5kg', 'flavor' => 'Chicken', 'stock' => 'In Stock',
                        'unit' => 365, 'qty' => 2, 'total' => 400,
                    ],
                    [
                        'name' => 'Interactive Cat Toy Set',
                        'img'  => 'https://images.unsplash.com/photo-1573865526739-10659fec78a5?w=200&h=200&fit=crop',
                        'size' => 'One Size', 'flavor' => 'Multicolor', 'stock' => 'Only 2 left',
                        'unit' => 200, 'qty' => 1, 'total' => 200,
                    ],
                    [
                        'name' => 'Tropical Fish Food Flakes',
                        'img'  => 'https://images.unsplash.com/photo-1601758228041-f3b2795255f1?w=200&h=200&fit=crop',
                        'size' => '200g', 'flavor' => 'Tropical', 'stock' => 'In Stock',
                        'unit' => 120, 'qty' => 1, 'total' => 120,
                    ],
                ];
                @endphp

                @foreach($cartItems as $i => $item)
                <div class="ct-item" id="ctItem{{ $i }}">
                    <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}" class="ct-item-img">
                    <div class="ct-item-info">
                        <h3>{{ $item['name'] }}</h3>
                        <div class="ct-item-meta">
                            <span>Size: {{ $item['size'] }}</span>
                            <span>Color / Flavor: {{ $item['flavor'] }}</span>
                        </div>
                        <div class="ct-stock {{ str_contains($item['stock'],'left') ? 'low' : '' }}">{{ $item['stock'] }}</div>
                        <div class="ct-item-actions">
                            <div class="ct-qty">
                                <button class="ct-qty-btn" onclick="changeQty({{ $i }}, -1)">−</button>
                                <span class="ct-qty-val" id="qty{{ $i }}">{{ $item['qty'] }}</span>
                                <button class="ct-qty-btn" onclick="changeQty({{ $i }}, 1)">+</button>
                            </div>
                            <button class="ct-delete-btn" onclick="document.getElementById('ctItem{{ $i }}').remove()">🗑</button>
                        </div>
                        <div class="ct-wishlist-link">Move to Wishlist</div>
                    </div>
                    <div class="ct-item-price">
                        <div class="ct-unit-price">₱{{ $item['unit'] }}/item</div>
                        <div class="ct-total-price" id="total{{ $i }}">₱{{ $item['total'] }}</div>
                    </div>
                </div>
                @endforeach

                <a href="{{ route('checkout') }}" class="ct-continue-btn">↩ Continue Shopping</a>
            </div>

            <!-- Order Summary -->
            <aside class="ct-summary">
                <h2 class="ct-summary-title">Order Summary</h2>
                <div class="ct-summary-rows">
                    <div class="ct-summary-row"><span>Subtotal (3 items)</span><span>₱720</span></div>
                    <div class="ct-summary-row"><span>Shipping</span><span class="ct-free">Free Shipping</span></div>
                    <div class="ct-summary-row"><span>Estimated Tax</span><span>₱50.60</span></div>
                </div>
                <div class="ct-summary-total"><span>Total</span><span>₱770.60</span></div>
                <div class="ct-coupon">
                    <input type="text" placeholder="Have a coupon?">
                </div>
                <a href="{{ route('checkout') }}" class="sh-btn-orange ct-checkout-btn">Proceed to Checkout</a>
                <div class="ct-pay-icons">
                    <span class="sh-pay">VISA</span>
                    <span class="sh-pay">MC</span>
                    <span class="sh-pay">PP</span>
                    <span class="sh-pay">GP</span>
                    <span class="ct-secure">🔒 Secure</span>
                    <span class="ct-secure">🚚 Free Ship</span>
                    <span class="ct-secure">↩ Easy Return</span>
                </div>
            </aside>
        </div>

        <!-- You Might Also Like -->
        <section class="ct-also-like">
            <h2>You Might Also Like</h2>
            <div class="ct-also-grid">
                @php
                $similar = [
                    ['Leather Dog Leash Set','59.99','https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=200&h=200&fit=crop'],
                    ['Cat Scratching Tower','124.99','https://images.unsplash.com/photo-1573865526739-10659fec78a5?w=200&h=200&fit=crop'],
                    ['Bird Cage Accessories','49.99','https://images.unsplash.com/photo-1552728089-57bdde30beb3?w=200&h=200&fit=crop'],
                    ['Aquarium Filter System','79.99','https://images.unsplash.com/photo-1601758228041-f3b2795255f1?w=200&h=200&fit=crop'],
                ];
                @endphp
                @foreach($similar as $s)
                <a href="{{ route('shop.product', 1) }}" class="ct-also-card">
                    <img src="{{ $s[2] }}" alt="{{ $s[0] }}">
                    <p>{{ $s[0] }}</p>
                    <span class="ct-also-price">₱{{ $s[1] }}</span>
                </a>
                @endforeach
            </div>
        </section>
    </div>
</div>

@include('partials.shop_footer')

<script>
const prices = [365, 200, 120];
function changeQty(i, d) {
    const el = document.getElementById('qty'+i);
    let v = Math.max(1, parseInt(el.textContent) + d);
    el.textContent = v;
    document.getElementById('total'+i).textContent = '₱' + (prices[i] * v);
}
</script>
@else
<script>window.location.href='{{ route("login") }}';</script>
@endauth
</body>
</html>
