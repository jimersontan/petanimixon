@extends('frontend.layouts.app')

@section('title', 'Checkout - Pet Markt-PH')

@push('styles')
<style>
/* ═══ Checkout Page ═══ */
.co-page { max-width: 960px; margin: 0 auto; padding: 32px 20px 60px; }

/* ═══ Stepper ═══ */
.co-stepper { display: flex; justify-content: space-between; margin-bottom: 32px; position: relative; }
.co-stepper::before { content:''; position:absolute; top:18px; left:40px; right:40px; height:3px; background:#e0e0e0; z-index:0; }
.co-step { display:flex; flex-direction:column; align-items:center; position:relative; z-index:1; flex:1; }
.co-step-circle {
    width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center;
    font-size:14px; font-weight:700; background:#e0e0e0; color:#999; transition:all .3s;
}
.co-step.active .co-step-circle { background:#3b7c42; color:#fff; box-shadow:0 4px 12px rgba(255,140,66,.35); }
.co-step.done .co-step-circle { background:#3DB868; color:#fff; }
.co-step-label { font-size:11px; margin-top:6px; color:#999; font-weight:600; text-align:center; }
.co-step.active .co-step-label, .co-step.done .co-step-label { color:#333; }

/* ═══ Step Panels ═══ */
.co-panel { display:none; }
.co-panel.active { display:block; }
.co-card { background:#fff; border-radius:14px; padding:28px; box-shadow:0 2px 12px rgba(0,0,0,.06); margin-bottom:20px; }
.co-card h2 { font-size:20px; font-weight:700; color:#222; margin:0 0 18px; }

/* ═══ Step 1: Order Summary ═══ */
.co-item { display:flex; gap:14px; padding:14px 0; border-bottom:1px solid #f0f0f0; }
.co-item:last-child { border-bottom:none; }
.co-item-img { width:70px; height:70px; border-radius:8px; object-fit:contain; flex-shrink:0; background:#f9f9f9; padding: 4px; box-sizing: border-box; }
.co-item-info { flex:1; }
.co-item-name { font-size:14px; font-weight:600; color:#222; margin-bottom:2px; }
.co-item-meta { font-size:12px; color:#888; }
.co-item-price { text-align:right; white-space:nowrap; }
.co-item-unit { font-size:12px; color:#888; }
.co-item-total { font-size:15px; font-weight:700; color:#3b7c42; }

/* ═══ Step 2: Address ═══ */
.co-addr-card {
    border:2px solid #e0e0e0; border-radius:12px; padding:16px; margin-bottom:12px;
    cursor:pointer; position:relative; transition:all .2s;
}
.co-addr-card.selected { border-color:#3b7c42; background:#fffaf5; }
.co-addr-card input[type=radio] { position:absolute; top:16px; right:16px; accent-color:#3b7c42; }
.co-addr-name { font-weight:700; font-size:15px; color:#222; }
.co-addr-detail { font-size:13px; color:#666; margin-top:4px; line-height:1.5; }
.co-new-addr-toggle { display:flex; align-items:center; gap:8px; padding:14px; border:2px dashed #ddd; border-radius:12px; cursor:pointer; color:#3b7c42; font-weight:600; font-size:14px; transition:all .2s; }
.co-new-addr-toggle:hover { border-color:#3b7c42; background:#fffaf5; }
.co-form-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
.co-form-group { margin-bottom:0; }
.co-form-group label { display:block; font-size:12px; font-weight:600; color:#555; margin-bottom:4px; }
.co-form-group input { width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:8px; font-size:14px; }
.co-form-group input:focus { border-color:#3b7c42; outline:none; }
.co-form-full { grid-column:1/-1; }

/* ═══ Geolocation Button ═══ */
.co-geo-btn {
    display:inline-flex; align-items:center; gap:8px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color:#fff; border:none; padding:12px 20px; border-radius:10px;
    font-size:14px; font-weight:600; cursor:pointer;
    transition:all .3s; box-shadow: 0 3px 12px rgba(37,99,235,.25);
    margin-bottom:16px;
}
.co-geo-btn:hover { box-shadow:0 6px 18px rgba(37,99,235,.35); transform:translateY(-1px); }
.co-geo-btn:disabled { opacity:.6; cursor:wait; transform:none; }
.co-geo-btn .geo-spinner {
    width:16px; height:16px; border:2px solid rgba(255,255,255,.3);
    border-top-color:#fff; border-radius:50%; animation:geoSpin 0.6s linear infinite; display:none;
}
.co-geo-btn.loading .geo-spinner { display:inline-block; }
.co-geo-btn.loading .geo-icon { display:none; }
@keyframes geoSpin { to { transform:rotate(360deg); } }
.co-geo-status {
    display:none; font-size:12px; padding:8px 14px; border-radius:8px;
    margin-bottom:12px; line-height:1.4;
}
.co-geo-status.success { display:block; background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; }
.co-geo-status.error { display:block; background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
.co-geo-status.loading { display:block; background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; }
.co-geo-divider {
    display:flex; align-items:center; gap:14px; margin:12px 0 16px; color:#999; font-size:12px; font-weight:600;
}
.co-geo-divider::before, .co-geo-divider::after {
    content:''; flex:1; height:1px; background:#e0e0e0;
}

/* ═══ Step 3: Shipping ═══ */
.co-ship-option {
    border:2px solid #e0e0e0; border-radius:12px; padding:18px 20px; margin-bottom:12px;
    cursor:pointer; display:flex; align-items:center; gap:16px; transition:all .2s;
}
.co-ship-option.selected { border-color:#3b7c42; background:#fffaf5; }
.co-ship-option input[type=radio] { accent-color:#3b7c42; flex-shrink:0; width:18px; height:18px; }
.co-ship-icon { font-size:28px; flex-shrink:0; }
.co-ship-info { flex:1; }
.co-ship-name { font-size:15px; font-weight:700; color:#222; }
.co-ship-desc { font-size:12px; color:#888; margin-top:2px; }
.co-ship-price { font-size:16px; font-weight:700; color:#3b7c42; white-space:nowrap; }
.co-ship-free { color:#3DB868; }

/* ═══ Step 4: Payment ═══ */
.co-pay-option {
    border:2px solid #e0e0e0; border-radius:12px; padding:18px 20px; margin-bottom:12px;
    cursor:pointer; display:flex; align-items:center; gap:16px; transition:all .2s;
}
.co-pay-option.selected { border-color:#3b7c42; background:#fffaf5; }
.co-pay-option input[type=radio] { accent-color:#3b7c42; flex-shrink:0; width:18px; height:18px; }
.co-pay-icon { font-size:28px; flex-shrink:0; }
.co-pay-name { font-size:15px; font-weight:700; color:#222; }
.co-pay-desc { font-size:12px; color:#888; margin-top:2px; }
.co-voucher-row { display:flex; gap:10px; margin-top:16px; }
.co-voucher-input { flex:1; padding:10px 14px; border:1px solid #ddd; border-radius:8px; font-size:14px; }
.co-voucher-input:focus { border-color:#3b7c42; outline:none; }
.co-voucher-btn { padding:10px 20px; background:#3b7c42; color:#fff; border:none; border-radius:8px; font-weight:700; cursor:pointer; font-size:14px; white-space:nowrap; }
.co-voucher-btn:hover { opacity:.88; }
.co-voucher-msg { font-size:13px; margin-top:8px; }
.co-voucher-msg.success { color:#3DB868; }
.co-voucher-msg.error { color:#e44; }

/* ═══ Step 5: Review ═══ */
.co-review-section { margin-bottom:20px; }
.co-review-label { font-size:12px; text-transform:uppercase; font-weight:700; color:#999; letter-spacing:.5px; margin-bottom:8px; }
.co-review-value { font-size:14px; color:#333; line-height:1.6; }
.co-summary-row { display:flex; justify-content:space-between; padding:8px 0; font-size:14px; color:#555; }
.co-summary-row.total { border-top:2px solid #eee; padding-top:14px; margin-top:6px; font-size:18px; font-weight:800; color:#222; }
.co-summary-row.total span:last-child { color:#3b7c42; }
.co-discount-row { color:#3DB868; }

/* ═══ Navigation Buttons ═══ */
.co-nav { display:flex; justify-content:space-between; margin-top:24px; }
.co-btn { padding:14px 32px; border-radius:10px; font-size:15px; font-weight:700; cursor:pointer; border:none; transition:all .2s; }
.co-btn-back { background:#f0f0f0; color:#555; }
.co-btn-back:hover { background:#e0e0e0; }
.co-btn-next { background:#3b7c42; color:#fff; }
.co-btn-next:hover { opacity:.9; }
.co-btn-place { background:#3b7c42; color:#fff; padding:16px 40px; font-size:16px; }
.co-btn-place:hover { opacity:.9; }

/* ═══ Responsive ═══ */
@media (max-width:768px) {
    .co-page { padding:16px 12px 100px; }
    .co-stepper::before { left:20px; right:20px; }
    .co-step-circle { width:30px; height:30px; font-size:12px; }
    .co-step-label { font-size:9px; }
    .co-card { padding:18px; }
    .co-form-grid { grid-template-columns:1fr; }
    .co-item-img { width:56px; height:56px; }
    .co-nav { gap:10px; }
    .co-btn { padding:12px 20px; font-size:13px; }
}
</style>
@endpush

@section('content')

<style>
.ph-dd-wrap { position: relative; width: 100%; }
.ph-dd-wrap::after { content: '▼'; position: absolute; right: 14px; top: 12px; font-size: 10px; color: #888; pointer-events: none; }
.ph-dd-list {
    position: absolute; top: calc(100% + 4px); left: 0; width: 100%;
    background: #fff; border: 1px solid #ddd; border-radius: 6px;
    max-height: 220px; overflow-y: auto; z-index: 9999;
    margin: 0; padding: 0; list-style: none;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    display: none;
}
.ph-dd-list li {
    padding: 10px 14px; cursor: pointer; font-size: 14px; color: #333;
    border-bottom: 1px solid #f0f0f0;
}
.ph-dd-list li:last-child { border-bottom: none; }
.ph-dd-list li:hover { background: #fdf3ed; color: #e85d04; font-weight: 500;}
</style>
<div class="co-page">
    {{-- ═══ STEPPER ═══ --}}
    <div class="co-stepper">
        <div class="co-step active" data-step="1"><div class="co-step-circle">1</div><div class="co-step-label">Summary</div></div>
        <div class="co-step" data-step="2"><div class="co-step-circle">2</div><div class="co-step-label">Address</div></div>
        <div class="co-step" data-step="3"><div class="co-step-circle">3</div><div class="co-step-label">Shipping</div></div>
        <div class="co-step" data-step="4"><div class="co-step-circle">4</div><div class="co-step-label">Payment</div></div>
        <div class="co-step" data-step="5"><div class="co-step-circle">5</div><div class="co-step-label">Review</div></div>
    </div>

    <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <input type="hidden" name="shipping_address_id" id="hAddr">
        <input type="hidden" name="shipping_type" id="hShip" value="local">
        <input type="hidden" name="payment_method" id="hPay" value="cod">
        <input type="hidden" name="voucher_code" id="hVoucher">

        {{-- ═══ STEP 1: ORDER SUMMARY ═══ --}}
        <div class="co-panel active" id="step1">
            <div class="co-card">
                <h2>🛒 Order Summary</h2>
                @foreach($cart->items as $item)
                <div class="co-item">
                    <img class="co-item-img" src="{{ $item->product->image_url }}" alt="{{ $item->product->product_name }}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2270%22 height=%2270%22%3E%3Crect fill=%22%23f5f5f5%22 width=%2270%22 height=%2270%22/%3E%3C/svg%3E'">
                    <div class="co-item-info">
                        <div class="co-item-name">{{ $item->product->product_name }}</div>
                        <div class="co-item-meta">Qty: {{ $item->quantity }} · ₱{{ number_format($item->unit_price, 2) }} each</div>
                    </div>
                    <div class="co-item-price">
                        <div class="co-item-total">₱{{ number_format($item->subtotal, 2) }}</div>
                    </div>
                </div>
                @endforeach
                <div class="co-summary-row total" style="margin-top:16px;">
                    <span>Subtotal</span>
                    <span>₱{{ number_format($subtotal, 2) }}</span>
                </div>
            </div>
            <div class="co-nav" style="justify-content:flex-end;">
                <button type="button" class="co-btn co-btn-next" onclick="goStep(2)">Continue to Address →</button>
            </div>
        </div>

        {{-- ═══ STEP 2: DELIVERY ADDRESS ═══ --}}
        <div class="co-panel" id="step2">
            <div class="co-card">
                <h2>📍 Delivery Address</h2>
                @foreach($addresses as $addr)
                <div class="co-addr-card {{ $loop->first ? 'selected' : '' }}" onclick="selectAddr(this, {{ $addr->id }})">
                    <input type="radio" name="_addr_radio" value="{{ $addr->id }}" {{ $loop->first ? 'checked' : '' }}>
                    <div class="co-addr-name">{{ $addr->recipient_name }}</div>
                    <div class="co-addr-detail">{{ $addr->phone_number }}<br>{{ $addr->street_address }}, {{ $addr->barangay ? $addr->barangay . ', ' : '' }}{{ $addr->city_municipality }}, {{ $addr->province }} {{ $addr->zip_code }}</div>
                </div>
                @endforeach

                @if($addresses->isEmpty())
                    <p style="font-size:13px; color:#666; margin-bottom:16px;">You don't have any saved addresses yet. Please enter one below. It will be saved for future orders.</p>
                @endif
                <div class="co-new-addr-toggle" onclick="toggleNewAddr()" @if($addresses->isEmpty()) style="display:none;" @endif>
                    <span style="font-size:20px;">＋</span> Add New Address
                </div>
                <div id="newAddrForm" style="display:{{ $addresses->isEmpty() ? 'block' : 'none' }}; margin-top:16px;">
                    <div style="font-size:13px; color:#3DB868; font-weight:600; margin-bottom:12px;">✓ This address will be saved to your account.</div>

                    {{-- ═══ USE MY CURRENT LOCATION ═══ --}}
                    <button type="button" class="co-geo-btn" id="geoLocateBtn" onclick="useMyLocation()">
                        <span class="geo-icon">📍</span>
                        <span class="geo-spinner"></span>
                        <span id="geoBtnText">Use My Current Location</span>
                    </button>
                    <div class="co-geo-status" id="geoStatus"></div>
                    <div class="co-geo-divider">or fill in manually</div>

                    <div class="co-form-grid">
                        <div class="co-form-group"><label>Full Name *</label><input type="text" name="new_address[recipient_name]"></div>
                        <div class="co-form-group"><label>Phone Number *</label><input type="text" name="new_address[phone_number]"></div>
                        <div class="co-form-group">
                            <label>Region</label>
                            <div class="ph-dd-wrap">
                                <input type="text" name="new_address[region]" id="ph-region-input" autocomplete="off" placeholder="Type or select...">
                                <ul class="ph-dd-list" id="ph-region-list"></ul>
                            </div>
                        </div>
                        <div class="co-form-group">
                            <label>Province *</label>
                            <div class="ph-dd-wrap">
                                <input type="text" name="new_address[province]" id="ph-province-input" autocomplete="off" placeholder="Type or select..." disabled>
                                <ul class="ph-dd-list" id="ph-province-list"></ul>
                            </div>
                        </div>
                        <div class="co-form-group">
                            <label>City / Municipality *</label>
                            <div class="ph-dd-wrap">
                                <input type="text" name="new_address[city_municipality]" id="ph-city-input" autocomplete="off" placeholder="Type or select..." disabled>
                                <ul class="ph-dd-list" id="ph-city-list"></ul>
                            </div>
                        </div>
                        <div class="co-form-group">
                            <label>Barangay</label>
                            <div class="ph-dd-wrap">
                                <input type="text" name="new_address[barangay]" id="ph-barangay-input" autocomplete="off" placeholder="Type or select..." disabled>
                                <ul class="ph-dd-list" id="ph-barangay-list"></ul>
                            </div>
                        </div>
                        <div class="co-form-group co-form-full"><label>Street / House No. *</label><input type="text" name="new_address[street_address]"></div>
                        <div class="co-form-group"><label>Zip Code</label><input type="text" name="new_address[zip_code]"></div>
                    </div>
                </div>
            </div>
            <div class="co-nav">
                <button type="button" class="co-btn co-btn-back" onclick="goStep(1)">← Back</button>
                <button type="button" class="co-btn co-btn-next" onclick="goStep(3)">Continue to Shipping →</button>
            </div>
        </div>

        {{-- ═══ STEP 3: SHIPPING ═══ --}}
        <div class="co-panel" id="step3">
            <div class="co-card">
                <h2>🚚 Shipping Option</h2>
                <div class="co-ship-option selected" onclick="selectShip(this,'local')">
                    <input type="radio" name="_ship_radio" value="local" checked>
                    <span class="co-ship-icon">🛵</span>
                    <div class="co-ship-info">
                        <div class="co-ship-name">Local Delivery</div>
                        <div class="co-ship-desc">Delivered by our own rider. Same/Next day.</div>
                    </div>
                    <div class="co-ship-price" id="priceLocal">₱50.00</div>
                </div>
                <div class="co-ship-option" onclick="selectShip(this,'courier')">
                    <input type="radio" name="_ship_radio" value="courier">
                    <span class="co-ship-icon">📦</span>
                    <div class="co-ship-info">
                        <div class="co-ship-name">Courier Shipping (J&T Express)</div>
                        <div class="co-ship-desc">Shipped nationwide. Estimated 3–7 days.</div>
                    </div>
                    <div class="co-ship-price" id="priceCourier">₱150.00</div>
                </div>
            </div>
            <div class="co-nav">
                <button type="button" class="co-btn co-btn-back" onclick="goStep(2)">← Back</button>
                <button type="button" class="co-btn co-btn-next" onclick="goStep(4)">Continue to Payment →</button>
            </div>
        </div>

        {{-- ═══ STEP 4: PAYMENT ═══ --}}
        <div class="co-panel" id="step4">
            <div class="co-card">
                <h2>💳 Payment Method</h2>
                <div class="co-pay-option selected" onclick="selectPay(this,'cod')">
                    <input type="radio" name="_pay_radio" value="cod" checked>
                    <span class="co-pay-icon">💵</span>
                    <div>
                        <div class="co-pay-name">Cash on Delivery (COD)</div>
                        <div class="co-pay-desc">Pay when your order arrives</div>
                    </div>
                </div>
                <div class="co-pay-option" onclick="selectPay(this,'gcash')">
                    <input type="radio" name="_pay_radio" value="gcash">
                    <span class="co-pay-icon">📱</span>
                    <div>
                        <div class="co-pay-name">GCash</div>
                        <div class="co-pay-desc">Pay via GCash e-wallet</div>
                    </div>
                </div>
            </div>
            <div class="co-card">
                <h2>🏷️ Voucher Code <span style="font-size:13px;color:#888;font-weight:400;">(optional)</span></h2>
                <div class="co-voucher-row">
                    <input type="text" class="co-voucher-input" id="voucherInput" placeholder="Enter voucher code (e.g. PETLOVE10)" value="{{ session('active_voucher') }}">
                    <button type="button" class="co-voucher-btn" onclick="applyVoucher()">Apply</button>
                </div>
                <div class="co-voucher-msg" id="voucherMsg"></div>
            </div>
            <div class="co-nav">
                <button type="button" class="co-btn co-btn-back" onclick="goStep(3)">← Back</button>
                <button type="button" class="co-btn co-btn-next" onclick="goStep(5)">Review Order →</button>
            </div>
        </div>

        {{-- ═══ STEP 5: REVIEW ═══ --}}
        <div class="co-panel" id="step5">
            <div class="co-card">
                <h2>📋 Order Review</h2>

                <div class="co-review-section">
                    <div class="co-review-label">Items</div>
                    @foreach($cart->items as $item)
                    <div style="display:flex; justify-content:space-between; font-size:13px; padding:4px 0; color:#555;">
                        <span>{{ $item->product->product_name }} × {{ $item->quantity }}</span>
                        <span>₱{{ number_format($item->subtotal, 2) }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="co-review-section">
                    <div class="co-review-label">Delivery Address</div>
                    <div class="co-review-value" id="reviewAddr">—</div>
                </div>

                <div class="co-review-section">
                    <div class="co-review-label">Shipping Method</div>
                    <div class="co-review-value" id="reviewShip">Local Delivery</div>
                </div>

                <div class="co-review-section">
                    <div class="co-review-label">Payment Method</div>
                    <div class="co-review-value" id="reviewPay">Cash on Delivery</div>
                </div>

                <hr style="border:0;border-top:1px solid #eee;margin:16px 0;">
                <div class="co-summary-row"><span>Subtotal</span><span>₱{{ number_format($subtotal, 2) }}</span></div>
                <div class="co-summary-row"><span>Shipping</span><span id="reviewShipFee">₱0.00</span></div>
                <div class="co-summary-row co-discount-row" id="reviewDiscountRow" style="display:none;"><span>Discount</span><span id="reviewDiscount">-₱0.00</span></div>
                <div class="co-summary-row total"><span>Total</span><span id="reviewTotal">₱{{ number_format($subtotal, 2) }}</span></div>
            </div>
            <div class="co-nav">
                <button type="button" class="co-btn co-btn-back" onclick="goStep(4)">← Back</button>
                <button type="submit" class="co-btn co-btn-place">✓ Place Order</button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
const SUBTOTAL = {{ $subtotal }};
let currentStep = 1;
let shipFee = 0;
let discount = 0;
let freeShipping = false;

// Addresses data for review
const addresses = @json($addresses);

function goStep(n) {
    // Validation before advancing
    if (n > currentStep) {
        if (currentStep === 2 && !document.getElementById('hAddr').value && !document.querySelector('#newAddrForm input[name="new_address[recipient_name]"]').value) {
            alert('Please select or enter a delivery address.');
            return;
        }
    }

    currentStep = n;
    document.querySelectorAll('.co-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('step' + n).classList.add('active');

    document.querySelectorAll('.co-step').forEach(s => {
        const sn = parseInt(s.dataset.step);
        s.classList.remove('active', 'done');
        if (sn < n) s.classList.add('done');
        if (sn === n) s.classList.add('active');
    });

    if (n === 5) buildReview();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Auto-activate session voucher on load
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('voucherInput').value) {
        setTimeout(applyVoucher, 500); 
    }
});

// Address selection
function selectAddr(el, id) {
    document.querySelectorAll('.co-addr-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    el.querySelector('input').checked = true;
    document.getElementById('hAddr').value = id;
    document.getElementById('newAddrForm').style.display = 'none';
}

// Auto-select first address
@if($addresses->isNotEmpty())
document.getElementById('hAddr').value = {{ $addresses->first()->id }};
@endif

function toggleNewAddr() {
    const f = document.getElementById('newAddrForm');
    f.style.display = f.style.display === 'none' ? 'block' : 'none';
    document.querySelectorAll('.co-addr-card').forEach(c => { c.classList.remove('selected'); c.querySelector('input').checked = false; });
    document.getElementById('hAddr').value = '';
}

// Shipping selection
function selectShip(el, method) {
    document.querySelectorAll('.co-ship-option').forEach(o => o.classList.remove('selected'));
    el.classList.add('selected');
    el.querySelector('input').checked = true;
    document.getElementById('hShip').value = method;
    calcShipFee(method);
}

function calcShipFee(method) {
    if (freeShipping) { shipFee = 0; return; }
    if (method === 'courier') { shipFee = 150.00; return; }
    // local
    shipFee = 50.00;
}
calcShipFee('local');

// Payment selection
function selectPay(el, method) {
    document.querySelectorAll('.co-pay-option').forEach(o => o.classList.remove('selected'));
    el.classList.add('selected');
    el.querySelector('input').checked = true;
    document.getElementById('hPay').value = method;
}

// Voucher
function applyVoucher() {
    const code = document.getElementById('voucherInput').value.trim();
    if (!code) return;
    const msg = document.getElementById('voucherMsg');
    msg.textContent = 'Checking...';
    msg.className = 'co-voucher-msg';

    fetch('{{ route("checkout.voucher") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ voucher_code: code, subtotal: SUBTOTAL })
    })
    .then(r => r.json())
    .then(data => {
        if (data.valid) {
            discount = data.discount;
            freeShipping = data.free_shipping || false;
            document.getElementById('hVoucher').value = code.toUpperCase();
            msg.textContent = '✓ ' + data.message;
            msg.className = 'co-voucher-msg success';
            if (freeShipping) {
                shipFee = 0;
                msg.textContent += ' + Free Shipping!';
            }
        } else {
            discount = 0;
            document.getElementById('hVoucher').value = '';
            msg.textContent = '✗ ' + data.message;
            msg.className = 'co-voucher-msg error';
        }
    })
    .catch(() => { msg.textContent = 'Error. Try again.'; msg.className = 'co-voucher-msg error'; });
}

// Build review
function buildReview() {
    // Address
    const addrId = document.getElementById('hAddr').value;
    let addrHtml = '';
    if (addrId) {
        const a = addresses.find(x => x.id == addrId);
        if (a) addrHtml = `<strong>${a.recipient_name}</strong><br>${a.phone_number}<br>${a.street_address}, ${a.barangay || ''} ${a.city_municipality}, ${a.province} ${a.zip_code}`;
    } else {
        const n = document.querySelector('input[name="new_address[recipient_name]"]').value;
        const p = document.querySelector('input[name="new_address[phone_number]"]').value;
        const s = document.querySelector('input[name="new_address[street_address]"]').value;
        const c = document.querySelector('input[name="new_address[city_municipality]"]').value;
        addrHtml = `<strong>${n}</strong><br>${p}<br>${s}, ${c}`;
    }
    document.getElementById('reviewAddr').innerHTML = addrHtml || '—';

    // Shipping
    const shipMap = { local: '🛵 Local Delivery (₱50)', courier: '📦 J&T Express (₱150)' };
    const sm = document.getElementById('hShip').value;
    document.getElementById('reviewShip').textContent = shipMap[sm] || sm;
    calcShipFee(sm);
    document.getElementById('reviewShipFee').textContent = shipFee > 0 ? '₱' + shipFee.toFixed(2) : 'FREE';

    // Payment
    const payMap = { cod: 'Cash on Delivery', gcash: 'GCash' };
    document.getElementById('reviewPay').textContent = payMap[document.getElementById('hPay').value] || '';

    // Discount
    const dr = document.getElementById('reviewDiscountRow');
    if (discount > 0) { dr.style.display = 'flex'; document.getElementById('reviewDiscount').textContent = '-₱' + discount.toFixed(2); }
    else { dr.style.display = 'none'; }

    // Total
    const total = SUBTOTAL + shipFee - discount;
    document.getElementById('reviewTotal').textContent = '₱' + total.toFixed(2);
}
</script>

{{-- ═══ GEOLOCATION: Use Current Location ═══ --}}
<script>
function useMyLocation() {
    const btn = document.getElementById('geoLocateBtn');
    const statusEl = document.getElementById('geoStatus');
    const btnText = document.getElementById('geoBtnText');

    if (!navigator.geolocation) {
        showGeoStatus('error', '❌ Geolocation is not supported by your browser.');
        return;
    }

    // Loading state
    btn.classList.add('loading');
    btn.disabled = true;
    btnText.textContent = 'Getting your location...';
    showGeoStatus('loading', '🔍 Requesting your GPS location...');

    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            showGeoStatus('loading', '📡 Location found! Resolving address...');
            btnText.textContent = 'Resolving address...';

            // Reverse geocode using free Nominatim API (OpenStreetMap)
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1&zoom=18&accept-language=en`, {
                headers: { 'User-Agent': 'Pet Markt-PH/1.0' }
            })
            .then(r => r.json())
            .then(data => {
                if (data && data.address) {
                    fillAddressFromGeo(data.address, lat, lng);
                    showGeoStatus('success', `✅ Address detected! (${lat.toFixed(5)}, ${lng.toFixed(5)})<br>📍 ${data.display_name || 'Location found'}.<br><small style="color:#888;">Please verify and adjust if needed.</small>`);
                } else {
                    showGeoStatus('error', '❌ Could not resolve address. Please fill in manually.');
                }
            })
            .catch(err => {
                console.error('Geocoding error:', err);
                showGeoStatus('error', '❌ Address lookup failed. Please fill in manually.');
            })
            .finally(() => {
                btn.classList.remove('loading');
                btn.disabled = false;
                btnText.textContent = '📍 Use My Current Location';
            });
        },
        function(error) {
            btn.classList.remove('loading');
            btn.disabled = false;
            btnText.textContent = '📍 Use My Current Location';

            const messages = {
                1: '🔒 Location permission denied. Please allow location access in your browser settings.',
                2: '📡 Position unavailable. Make sure GPS/Location is enabled on your device.',
                3: '⏱️ Location request timed out. Please try again.'
            };
            showGeoStatus('error', messages[error.code] || '❌ Could not get your location.');
        },
        {
            enableHighAccuracy: true,
            timeout: 15000,
            maximumAge: 60000
        }
    );
}

function showGeoStatus(type, message) {
    const el = document.getElementById('geoStatus');
    el.className = 'co-geo-status ' + type;
    el.innerHTML = message;
}

function fillAddressFromGeo(addr, lat, lng) {
    // Map Nominatim fields to Philippine address structure
    const regionInput = document.getElementById('ph-region-input');
    const provinceInput = document.getElementById('ph-province-input');
    const cityInput = document.getElementById('ph-city-input');
    const barangayInput = document.getElementById('ph-barangay-input');
    const streetInput = document.querySelector('input[name="new_address[street_address]"]');
    const zipInput = document.querySelector('input[name="new_address[zip_code]"]');

    // Strip disabled from all of them forcefully so they are fully unlocked
    if (regionInput) regionInput.removeAttribute('disabled');
    if (provinceInput) provinceInput.removeAttribute('disabled');
    if (cityInput) cityInput.removeAttribute('disabled');
    if (barangayInput) barangayInput.removeAttribute('disabled');

    // Region — Nominatim usually gives state_district or region
    let region = addr.region || addr.state_district || addr.state || '';
    if (region.includes('National Capital Region')) region = 'Metro Manila';
    
    if (regionInput && region) {
        regionInput.value = region;
        regionInput.dispatchEvent(new Event('input', { bubbles: true }));
        regionInput.dispatchEvent(new Event('change', { bubbles: true }));
    }

    // City / Municipality
    let city = addr.city || addr.town || addr.municipality || addr.village || '';
    
    // Lookup for Highly Urbanized Cities that Nominatim skips the province for
    const hucMap = {
        'Butuan': 'Agusan del Norte', 'Butuan City': 'Agusan del Norte',
        'Cebu': 'Cebu', 'Cebu City': 'Cebu', 'Lapu-Lapu': 'Cebu', 'Mandaue': 'Cebu',
        'Davao': 'Davao del Sur', 'Davao City': 'Davao del Sur',
        'Iloilo': 'Iloilo', 'Iloilo City': 'Iloilo',
        'Bacolod': 'Negros Occidental', 'Bacolod City': 'Negros Occidental',
        'Cagayan de Oro': 'Misamis Oriental', 'Cagayan de Oro City': 'Misamis Oriental',
        'Iligan': 'Lanao del Norte', 'Iligan City': 'Lanao del Norte',
        'General Santos': 'South Cotabato', 'General Santos City': 'South Cotabato',
        'Zamboanga': 'Zamboanga del Sur', 'Zamboanga City': 'Zamboanga del Sur',
        'Angeles': 'Pampanga', 'Angeles City': 'Pampanga',
        'Olongapo': 'Zambales', 'Olongapo City': 'Zambales',
        'Baguio': 'Benguet', 'Baguio City': 'Benguet',
        'Lucena': 'Quezon', 'Lucena City': 'Quezon',
        'Puerto Princesa': 'Palawan', 'Puerto Princesa City': 'Palawan',
        'Tacloban': 'Leyte', 'Tacloban City': 'Leyte',
        'Ormoc': 'Leyte', 'Ormoc City': 'Leyte',
        'Naga': 'Camarines Sur', 'Naga City': 'Camarines Sur',
        'Santiago': 'Isabela', 'Santiago City': 'Isabela',
        'Cotabato': 'Maguindanao', 'Cotabato City': 'Maguindanao'
    };

    // Province (In Philippines, Nominatim often maps provinces to 'state', 'county', or 'province')
    let province = addr.county || addr.province || addr.state || '';
    
    // Fallbacks if province is still missing or just says "Philippines"
    if (!province || province.toLowerCase() === 'philippines') {
        if (city && hucMap[city]) {
            province = hucMap[city];
        } else if (region === 'Metro Manila' || region.includes('National Capital')) {
            province = 'Metro Manila';
        }
    }

    if (provinceInput && province) {
        setTimeout(() => {
            provinceInput.value = province;
            provinceInput.dispatchEvent(new Event('input', { bubbles: true }));
            provinceInput.dispatchEvent(new Event('change', { bubbles: true }));
        }, 100);
    }

    if (cityInput && city) {
        setTimeout(() => {
            cityInput.value = city;
            cityInput.dispatchEvent(new Event('input', { bubbles: true }));
            cityInput.dispatchEvent(new Event('change', { bubbles: true }));
        }, 200);
    }

    // Barangay (suburb in Nominatim)
    const barangay = addr.suburb || addr.neighbourhood || addr.quarter || addr.village || '';
    if (barangayInput && barangay) {
        setTimeout(() => {
            barangayInput.value = barangay;
            barangayInput.dispatchEvent(new Event('input', { bubbles: true }));
        }, 300);
    }

    // Street / House No
    const houseNumber = addr.house_number || '';
    const road = addr.road || addr.pedestrian || addr.footway || '';
    const streetParts = [houseNumber, road].filter(Boolean);
    if (streetInput && streetParts.length) {
        streetInput.value = streetParts.join(' ');
    }

    // Zip Code
    const zip = addr.postcode || '';
    if (zipInput && zip) {
        zipInput.value = zip;
    }

    // Scroll to the form fields smoothly
    const formGrid = document.querySelector('.co-form-grid');
    if (formGrid) {
        formGrid.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}
</script>

<script src="{{ asset('js/ph-address.js') }}"></script>
@endpush
@endsection


