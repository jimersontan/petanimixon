@extends('frontend.layouts.app')

@section('title', 'Track Order - Pet Markt-PH')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
/* ═══════════════════════════════════════════════════════
   PREMIUM ORDER TRACKING PAGE — Pet Markt-PH
   ═══════════════════════════════════════════════════════ */

@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

.track-page {
    max-width: 960px;
    margin: 0 auto;
    padding: 32px 20px 80px;
    font-family: 'Inter', -apple-system, sans-serif;
}

/* ── HEADER ── */
.track-hero {
    text-align: center;
    margin-bottom: 28px;
    position: relative;
}
.track-hero h1 {
    font-size: 30px;
    font-weight: 900;
    color: #111;
    margin: 0 0 4px;
    letter-spacing: -0.5px;
}
.track-hero p {
    font-size: 14px;
    color: #888;
    margin: 0 0 14px;
}
.track-order-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
    color: #2e7d32;
    padding: 8px 20px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.3px;
    border: 1px solid #a5d6a7;
}

/* ── NOTIFICATION BANNERS ── */
.track-notif {
    display: none;
    padding: 14px 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    animation: trackSlideDown 0.4s ease;
}
.track-notif.show { display: block; }
.track-notif.info { background: linear-gradient(135deg, #e3f2fd, #bbdefb); border: 1px solid #90caf9; color: #1565c0; }
.track-notif.success { background: linear-gradient(135deg, #e8f5e9, #c8e6c9); border: 1px solid #a5d6a7; color: #2e7d32; }
.track-notif.urgent { background: linear-gradient(135deg, #fff3e0, #ffe0b2); border: 1px solid #ffcc80; color: #e65100; animation: trackPulseGlow 1.5s infinite; }
@keyframes trackSlideDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }
@keyframes trackPulseGlow { 0%,100% { box-shadow: 0 0 0 0 rgba(255,152,0,.25); } 50% { box-shadow: 0 0 16px 4px rgba(255,152,0,.25); } }

/* ── CARDS ── */
.track-card {
    background: #fff;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 2px 16px rgba(0,0,0,.05);
    margin-bottom: 22px;
    border: 1px solid #f0f0f0;
    transition: box-shadow 0.3s;
    position: relative;
    overflow: hidden;
}
.track-card:hover { box-shadow: 0 4px 24px rgba(0,0,0,.08); }
.track-card h3 {
    font-size: 15px;
    font-weight: 800;
    color: #222;
    margin: 0 0 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.card-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}
.card-icon.map { background: #e8f5e9; }
.card-icon.timeline { background: #e3f2fd; }
.card-icon.details { background: #fff3e0; }
.card-icon.items { background: #fce4ec; }

/* ══════ LIVE MAP ══════ */
.map-wrapper {
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    border: 2px solid #eee;
}
#trackingMap {
    width: 100%;
    height: 420px;
    z-index: 0;
}

/* ── ETA PANEL ── */
.eta-panel {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-top: 18px;
    padding: 18px;
    background: linear-gradient(135deg, #f8fdf8, #edf7ee);
    border-radius: 14px;
    border: 1px solid #c8e6c9;
}
.eta-cell {
    text-align: center;
    padding: 2px 0;
}
.eta-cell .label {
    font-size: 10px;
    text-transform: uppercase;
    font-weight: 700;
    color: #999;
    letter-spacing: 0.8px;
    margin-bottom: 4px;
}
.eta-cell .value {
    font-size: 22px;
    font-weight: 900;
    color: #2e7d32;
    line-height: 1.1;
}
.eta-cell .value.live {
    animation: etaPulse 1.5s infinite;
}
@keyframes etaPulse { 0%,100% { opacity: 1; } 50% { opacity: 0.5; } }
.eta-cell .sub {
    font-size: 11px;
    color: #888;
    margin-top: 3px;
}

/* ── PROGRESS BAR ── */
.delivery-progress {
    margin-top: 16px;
    background: #f5f5f5;
    border-radius: 10px;
    height: 10px;
    overflow: hidden;
    position: relative;
}
.delivery-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #43a047, #66bb6a, #aed581);
    border-radius: 10px;
    transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}
.delivery-progress-fill::after {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    width: 20px;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6));
    animation: progressShimmer 2s infinite;
}
@keyframes progressShimmer { 0% { opacity: 0; } 50% { opacity: 1; } 100% { opacity: 0; } }

/* ── RIDER INFO BAR ── */
.rider-info-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 14px;
    padding: 12px 16px;
    background: #f9fbe7;
    border-radius: 10px;
    border: 1px solid #dce775;
    font-size: 13px;
    gap: 10px;
    flex-wrap: wrap;
}
.rider-info-bar .rider-name { font-weight: 700; color: #33691e; }
.rider-info-bar .rider-status { color: #689f38; font-weight: 600; }

/* ══════ TIMELINE ══════ */
.delivery-timeline {
    position: relative;
    padding-left: 40px;
}
.delivery-timeline::before {
    content: '';
    position: absolute;
    left: 16px;
    top: 8px;
    bottom: 8px;
    width: 3px;
    background: #e0e0e0;
    border-radius: 2px;
}
.timeline-step {
    position: relative;
    padding-bottom: 26px;
}
.timeline-step:last-child { padding-bottom: 0; }

.timeline-dot {
    position: absolute;
    left: -32px;
    top: 2px;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: #e0e0e0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    color: #fff;
    transition: all 0.4s ease;
    z-index: 1;
}
.timeline-step.done .timeline-dot {
    background: #43a047;
    box-shadow: 0 0 0 3px rgba(67,160,71,.15);
}
.timeline-step.current .timeline-dot {
    background: #2e7d32;
    box-shadow: 0 0 0 6px rgba(46,125,50,.18);
    animation: dotPulse 2s infinite;
}
@keyframes dotPulse {
    0%, 100% { box-shadow: 0 0 0 6px rgba(46,125,50,.18); }
    50% { box-shadow: 0 0 0 10px rgba(46,125,50,.10); }
}

.timeline-title {
    font-size: 14px;
    font-weight: 700;
    color: #bbb;
    transition: color 0.3s;
}
.timeline-step.done .timeline-title,
.timeline-step.current .timeline-title { color: #222; }

.timeline-desc {
    font-size: 12px;
    color: #ccc;
    margin-top: 2px;
    transition: color 0.3s;
}
.timeline-step.done .timeline-desc,
.timeline-step.current .timeline-desc { color: #888; }

.timeline-time {
    font-size: 11px;
    color: #aaa;
    margin-top: 3px;
    font-weight: 600;
}

/* ══════ ORDER DETAILS ══════ */
.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    font-size: 14px;
    border-bottom: 1px solid #f5f5f5;
}
.detail-row:last-child { border-bottom: none; }
.detail-label { color: #888; }
.detail-value { color: #333; font-weight: 600; }
.detail-value.status-badge {
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 0.5px;
    padding: 4px 12px;
    border-radius: 16px;
    font-weight: 700;
}
.badge-pending { background: #fff3e0; color: #e65100; }
.badge-processing { background: #e3f2fd; color: #1565c0; }
.badge-out_for_delivery { background: #f3e5f5; color: #7b1fa2; }
.badge-shipped { background: #e8f5e9; color: #2e7d32; }
.badge-delivered { background: #e8f5e9; color: #2e7d32; }
.badge-cancelled { background: #ffebee; color: #c62828; }

/* ══════ ORDER ITEMS ══════ */
.track-item {
    display: flex;
    gap: 14px;
    padding: 12px 0;
    border-bottom: 1px solid #f5f5f5;
    align-items: center;
}
.track-item:last-child { border-bottom: none; }
.track-item-img {
    width: 54px;
    height: 54px;
    border-radius: 10px;
    object-fit: contain;
    background: #f9f9f9;
    padding: 3px;
    box-sizing: border-box;
    flex-shrink: 0;
}
.track-item-name { font-size: 13px; font-weight: 600; color: #222; }
.track-item-meta { font-size: 12px; color: #888; margin-top: 2px; }
.track-item-price { margin-left: auto; font-size: 14px; font-weight: 800; color: #2e7d32; white-space: nowrap; }

/* ──── TOTALS ──── */
.total-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    font-size: 14px;
    border-bottom: 1px solid #f5f5f5;
}
.total-row.grand {
    font-size: 17px;
    font-weight: 900;
    border-top: 2px solid #e0e0e0;
    padding-top: 14px;
    margin-top: 6px;
    border-bottom: none;
}
.total-row.grand .total-amount { color: #2e7d32; }

/* ──── ACTIONS ──── */
.track-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
    margin-top: 28px;
    flex-wrap: wrap;
}
.track-btn {
    padding: 14px 32px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.25s;
    border: 2px solid transparent;
}
.track-btn-primary {
    background: linear-gradient(135deg, #2e7d32, #388e3c);
    color: #fff;
    box-shadow: 0 4px 14px rgba(46,125,50,.25);
}
.track-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(46,125,50,.35);
}
.track-btn-secondary {
    background: #f5f5f5;
    color: #555;
    border-color: #eee;
}
.track-btn-secondary:hover {
    background: #eee;
    transform: translateY(-2px);
}

/* ──── RESPONSIVE ──── */
@media (max-width: 768px) {
    .track-page { padding: 16px 12px 100px; }
    .track-hero h1 { font-size: 22px; }
    .track-card { padding: 18px; border-radius: 12px; }
    #trackingMap { height: 300px; }
    .eta-panel { grid-template-columns: repeat(2, 1fr); gap: 10px; padding: 14px; }
    .eta-cell .value { font-size: 18px; }
    .rider-info-bar { flex-direction: column; align-items: flex-start; gap: 4px; }
    .delivery-timeline { padding-left: 36px; }
    .track-actions { flex-direction: column; }
    .track-btn { text-align: center; width: 100%; }
}

@media (max-width: 480px) {
    .track-hero h1 { font-size: 20px; }
    .track-card { padding: 14px; }
    #trackingMap { height: 240px; }
    .eta-cell .value { font-size: 16px; }
}

/* Leaflet popup override */
.leaflet-popup-content-wrapper {
    border-radius: 10px !important;
    font-family: 'Inter', sans-serif !important;
    font-size: 13px !important;
}
</style>
@endpush

@section('content')
<div class="track-page">

    {{-- ═══ HERO HEADER ═══ --}}
    <div class="track-hero">
        <h1>📦 Order Tracking</h1>
        <p>Live delivery tracking & ETA prediction</p>
        <div class="track-order-badge">
            <span>🧾</span>
            <span>{{ $order->order_id }}</span>
            <span style="margin-left: 8px; padding-left: 8px; border-left: 1px solid rgba(46,125,50,.3);">
                {{ $order->status_label }}
            </span>
        </div>
    </div>

    {{-- ═══ NOTIFICATION BANNERS ═══ --}}
    <div class="track-notif info" id="notifInfo"></div>
    <div class="track-notif success" id="notifSuccess"></div>
    <div class="track-notif urgent" id="notifUrgent"></div>

    {{-- ═══ LIVE MAP CARD ═══ --}}
    <div class="track-card">
        <h3><span class="card-icon map">🗺️</span> Live Delivery Map</h3>
        <div class="map-wrapper">
            <div id="trackingMap"></div>
        </div>

        {{-- ETA Panel --}}
        <div class="eta-panel">
            <div class="eta-cell">
                <div class="label">Distance</div>
                <div class="value" id="etaDistance">—</div>
                <div class="sub">km remaining</div>
            </div>
            <div class="eta-cell">
                <div class="label">ETA</div>
                <div class="value live" id="etaTime">—</div>
                <div class="sub" id="etaArrival">Calculating...</div>
            </div>
            <div class="eta-cell">
                <div class="label">Progress</div>
                <div class="value" id="etaProgress">0%</div>
                <div class="sub" id="etaStatus">
                    @if($order->order_status === 'out_for_delivery') In Transit
                    @elseif($order->order_status === 'delivered') Delivered
                    @else Waiting
                    @endif
                </div>
            </div>
            <div class="eta-cell">
                <div class="label">Arrives At</div>
                <div class="value" id="etaArriveAt" style="font-size:16px;">—</div>
                <div class="sub" id="etaMethod">{{ $order->isLocal() ? 'Local Delivery' : 'Courier Shipping' }}</div>
            </div>
        </div>

        {{-- Progress Bar --}}
        <div class="delivery-progress">
            <div class="delivery-progress-fill" id="progressBar" style="width: 0%;"></div>
        </div>

        {{-- Rider Info --}}
        <div class="rider-info-bar" id="riderBar" style="{{ $order->rider_id ? '' : 'display:none;' }}">
            <div>
                <span>🛵</span>
                <span class="rider-name" id="riderName">{{ optional($order->rider)->full_name ?? 'Rider' }}</span>
            </div>
            <div class="rider-status" id="riderStatusText">
                @if($order->rider_picked_up_at)
                    On the way to you
                @elseif($order->rider_id)
                    Heading to store for pickup
                @endif
            </div>
        </div>
    </div>

    {{-- ═══ DELIVERY TIMELINE ═══ --}}
    <div class="track-card">
        <h3><span class="card-icon timeline">📋</span> Delivery Status</h3>
        @php
            $steps = [
                'pending' => ['label' => 'Order Placed', 'desc' => 'Your order has been placed and is awaiting confirmation.', 'icon' => '📝'],
                'processing' => ['label' => 'Processing', 'desc' => 'Your order is being prepared for shipment.', 'icon' => '⚙️'],
                'out_for_delivery_pickup' => ['label' => 'Rider Assigned', 'desc' => 'A rider has been assigned and is heading to the store.', 'icon' => '🛵'],
                'out_for_delivery_transit' => ['label' => 'Out for Delivery', 'desc' => 'Your package is on its way to you!', 'icon' => '🚀'],
                'arriving' => ['label' => 'Arriving', 'desc' => 'Your rider is nearby. Please prepare to receive.', 'icon' => '📍'],
                'delivered' => ['label' => 'Delivered', 'desc' => 'Your order has been delivered. Enjoy! 🎉', 'icon' => '✅'],
            ];

            $currentStatus = $order->order_status;
            $hasRider = $order->rider_id !== null;
            $pickedUp = $order->rider_picked_up_at !== null;
            $delivered = $currentStatus === 'delivered';
            $cancelled = $currentStatus === 'cancelled';

            // Determine which step is "current"
            if ($cancelled) {
                $activeStep = 'cancelled';
            } elseif ($delivered) {
                $activeStep = 'delivered';
            } elseif ($pickedUp) {
                $progress = $order->getDeliveryProgressPercent();
                $activeStep = $progress >= 85 ? 'arriving' : 'out_for_delivery_transit';
            } elseif ($hasRider) {
                $activeStep = 'out_for_delivery_pickup';
            } elseif ($currentStatus === 'processing') {
                $activeStep = 'processing';
            } else {
                $activeStep = 'pending';
            }

            $stepKeys = array_keys($steps);
            $activeIdx = array_search($activeStep, $stepKeys);
        @endphp

        <div class="delivery-timeline" id="deliveryTimeline">
            @foreach($steps as $key => $step)
                @php
                    $idx = array_search($key, $stepKeys);
                    $isDone = $idx < $activeIdx;
                    $isCurrent = $idx === $activeIdx;
                @endphp
                <div class="timeline-step {{ $isDone ? 'done' : '' }} {{ $isCurrent ? 'current' : '' }}" data-step="{{ $key }}">
                    <div class="timeline-dot">{{ $isDone ? '✓' : ($isCurrent ? $step['icon'] : '') }}</div>
                    <div class="timeline-title">{{ $step['label'] }}</div>
                    <div class="timeline-desc">{{ $step['desc'] }}</div>
                    @if($isDone || $isCurrent)
                        <div class="timeline-time" data-step-time="{{ $key }}">
                            @if($key === 'pending')
                                {{ $order->created_at->format('M j, g:i A') }}
                            @elseif($key === 'out_for_delivery_pickup' && $hasRider && !$pickedUp)
                                Rider en route to store
                            @elseif($key === 'out_for_delivery_transit' && $pickedUp)
                                {{ $order->rider_picked_up_at->format('g:i A') }} — Picked up
                            @elseif($key === 'delivered' && $delivered)
                                {{ optional($order->rider_delivered_at)->format('M j, g:i A') }}
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        @if($cancelled)
        <div style="padding: 14px 16px; background: #ffebee; border-radius: 10px; margin-top: 16px; color: #c62828; font-weight: 600; text-align: center;">
            ❌ This order has been cancelled.
            @if($order->cancellation_reason)
                <div style="font-weight: 400; margin-top: 4px; font-size: 13px;">Reason: {{ $order->cancellation_reason }}</div>
            @endif
        </div>
        @endif
    </div>

    {{-- ═══ ORDER DETAILS ═══ --}}
    <div class="track-card">
        <h3><span class="card-icon details">📄</span> Order Details</h3>
        <div class="detail-row">
            <span class="detail-label">Order Date</span>
            <span class="detail-value">{{ $order->created_at->format('M j, Y g:i A') }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Status</span>
            <span class="detail-value status-badge badge-{{ $order->order_status }}">{{ $order->status_label }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Payment</span>
            <span class="detail-value">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'GCash' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Shipping</span>
            <span class="detail-value">{{ $order->isLocal() ? 'Local Delivery' : 'Courier Shipping' }}</span>
        </div>
        @if($order->tracking_number)
        <div class="detail-row">
            <span class="detail-label">Tracking #</span>
            <span class="detail-value" style="font-family: monospace; letter-spacing: 1px;">{{ $order->tracking_number }}</span>
        </div>
        @endif
        @if($order->shippingAddress)
        <div class="detail-row">
            <span class="detail-label">Deliver to</span>
            <span class="detail-value">{{ $order->shippingAddress->recipient_name }}, {{ $order->shippingAddress->street_address }}, {{ $order->shippingAddress->barangay ? $order->shippingAddress->barangay . ', ' : '' }}{{ $order->shippingAddress->city_municipality }}</span>
        </div>
        @endif
    </div>

    {{-- ═══ ORDER ITEMS ═══ --}}
    <div class="track-card">
        <h3><span class="card-icon items">🛒</span> Items Ordered</h3>
        @foreach($order->orderItems as $oi)
        <div class="track-item">
            @if($oi->product)
                <img class="track-item-img" src="{{ $oi->product->image_url }}" alt="" onerror="this.style.display='none'">
            @endif
            <div>
                <div class="track-item-name">{{ $oi->product->product_name ?? 'Product #'.$oi->product_id }}</div>
                <div class="track-item-meta">Qty: {{ $oi->quantity }} · ₱{{ number_format($oi->unit_price, 2) }}</div>
            </div>
            <div class="track-item-price">₱{{ number_format($oi->total_amount, 2) }}</div>
        </div>
        @endforeach

        <hr style="border:0; border-top:1px solid #f0f0f0; margin:14px 0;">
        <div class="total-row"><span class="detail-label">Subtotal</span><span>₱{{ number_format($order->order_amount, 2) }}</span></div>
        <div class="total-row"><span class="detail-label">Shipping</span><span>{{ $order->shipping_fee > 0 ? '₱'.number_format($order->shipping_fee, 2) : 'FREE' }}</span></div>
        @if($order->discount_amount > 0)
        <div class="total-row"><span class="detail-label" style="color:#43a047;">Discount</span><span style="color:#43a047;">-₱{{ number_format($order->discount_amount, 2) }}</span></div>
        @endif
        <div class="total-row grand">
            <span>Total</span>
            <span class="total-amount">₱{{ number_format($order->total_amount, 2) }}</span>
        </div>
    </div>

    {{-- ═══ ACTIONS ═══ --}}
    <div class="track-actions">
        <a href="{{ route('orders') }}" class="track-btn track-btn-secondary">← My Orders</a>
        <a href="{{ route('shop.all') }}" class="track-btn track-btn-primary">Continue Shopping</a>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function() {
    'use strict';

    // ═══ CONFIG ═══
    const ORDER_STATUS = '{{ $order->order_status }}';
    const ORDER_ID = '{{ $order->order_id }}';
    const TRACKING_URL = '{{ route("order.tracking-data", $order->order_id) }}';

    // Origin: Pet Markt-PH store — Libertad, Butuan City
    const STORE = { lat: 8.9475, lng: 125.5406 };

    // Destination from server
    @php
        $destCity = $order->shippingAddress->city_municipality ?? 'Butuan';
        $cityCoords = [
            'manila' => [14.5995, 120.9842], 'quezon city' => [14.6760, 121.0437],
            'cebu' => [10.3157, 123.8854], 'cebu city' => [10.3157, 123.8854],
            'davao' => [7.1907, 125.4553], 'davao city' => [7.1907, 125.4553],
            'butuan' => [8.9475, 125.5406], 'butuan city' => [8.9475, 125.5406],
            'cagayan de oro' => [8.4542, 124.6319], 'cagayan de oro city' => [8.4542, 124.6319],
            'zamboanga' => [6.9214, 122.0790], 'iloilo' => [10.7202, 122.5621],
            'makati' => [14.5547, 121.0244], 'taguig' => [14.5176, 121.0509],
            'pasig' => [14.5764, 121.0851], 'caloocan' => [14.6488, 120.9842],
            'surigao' => [9.7572, 125.5138], 'bacolod' => [10.6840, 122.9563],
            'general santos' => [6.1164, 125.1716],
            'nasipit' => [8.9953, 125.4987], 'cabadbaran' => [9.1233, 125.5339],
            'bayugan' => [8.7167, 125.7500], 'buenavista' => [8.9833, 125.4087],
        ];
        $cl = strtolower(trim($destCity));
        $dLat = $cityCoords[$cl][0] ?? 8.9575;
        $dLng = $cityCoords[$cl][1] ?? 125.5506;
        $recipientName = $order->shippingAddress->recipient_name ?? 'Buyer';
        $riderLat = $order->rider_lat ?? $dLat;
        $riderLng = $order->rider_lng ?? $dLng;
    @endphp

    let DEST = { lat: {{ $dLat }}, lng: {{ $dLng }} };
    const RECIPIENT = '{{ addslashes($recipientName) }}';
    
    @php
        $fullAddress = trim(implode(', ', array_filter([
            $order->shippingAddress->street_address ?? '',
            $order->shippingAddress->barangay ?? '',
            $order->shippingAddress->city_municipality ?? 'Butuan',
            $order->shippingAddress->province ?? '',
            'Philippines'
        ])));
    @endphp
    
    const FULL_ADDR = '{{ addslashes($fullAddress) }}';
    
    let riderPos = { lat: {{ $riderLat }}, lng: {{ $riderLng }} };
    const hasRider = {{ $order->rider_id ? 'true' : 'false' }};
    const pickedUp = {{ $order->rider_picked_up_at ? 'true' : 'false' }};

    // ═══ MAP SETUP ═══
    const map = L.map('trackingMap', { zoomControl: true, attributionControl: false })
        .fitBounds([ [STORE.lat, STORE.lng], [DEST.lat, DEST.lng] ], { padding: [50, 50], maxZoom: 15 });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap', maxZoom: 18
    }).addTo(map);

    // ── Custom Icons ──
    const storeIcon = L.divIcon({ html: '<div style="font-size:30px;filter:drop-shadow(0 2px 4px rgba(0,0,0,.3));">🏪</div>', iconSize: [36, 36], iconAnchor: [18, 18], className: '' });
    const destIcon = L.divIcon({ html: '<div style="font-size:30px;filter:drop-shadow(0 2px 4px rgba(0,0,0,.3));">📍</div>', iconSize: [36, 36], iconAnchor: [18, 36], className: '' });
    const riderIcon = L.divIcon({ html: '<div style="font-size:28px;filter:drop-shadow(0 3px 6px rgba(0,0,0,.4));animation:riderBob 1.5s infinite ease-in-out;">🛵</div>', iconSize: [34, 34], iconAnchor: [17, 17], className: '' });

    // Store and destination markers
    L.marker([STORE.lat, STORE.lng], { icon: storeIcon })
        .addTo(map).bindPopup('<b>🏪 Pet Markt-PH Store</b><br>Libertad, Butuan City');

    let destMarker = L.marker([DEST.lat, DEST.lng], { icon: destIcon })
        .addTo(map).bindPopup('<b>📍 ' + RECIPIENT + '</b><br>' + FULL_ADDR);

    // ── Route Line ──
    let totalDistance = 0;
    let routePoints = [];
    
    // Initial draw
    calcRoute();
    
    // Full route (light gray)
    let fullRouteLine = L.polyline(routePoints, { color: '#bbb', weight: 3, opacity: 0.4, dashArray: '8, 6' }).addTo(map);
    // Completed trail (green)
    const trailLine = L.polyline([], { color: '#43a047', weight: 5, opacity: 0.85 }).addTo(map);
    // Remaining route (orange)
    const remainingLine = L.polyline([], { color: '#ff9800', weight: 4, opacity: 0.6 }).addTo(map);

    // ── Rider marker ──
    let riderMarker = null;

    // Haversine distance
    function haversine(p1, p2) {
        const R = 6371;
        const dLat = (p2[0] - p1[0]) * Math.PI / 180;
        const dLng = (p2[1] - p1[1]) * Math.PI / 180;
        const a = Math.sin(dLat/2)**2 + Math.cos(p1[0]*Math.PI/180) * Math.cos(p2[0]*Math.PI/180) * Math.sin(dLng/2)**2;
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    }

    function generateRoute(origin, dest, numPts) {
        const pts = [];
        for (let i = 0; i <= numPts; i++) {
            const t = i / numPts;
            const lat = origin.lat + (dest.lat - origin.lat) * t;
            const lng = origin.lng + (dest.lng - origin.lng) * t;
            const curve = Math.sin(t * Math.PI) * (totalDistance * 0.006);
            pts.push([lat + curve * 0.08, lng + curve * 0.04]);
        }
        return pts;
    }

    function calcRoute(callback) {
        // Fetch accurate road route from OSRM
        fetch(`https://router.project-osrm.org/route/v1/driving/${STORE.lng},${STORE.lat};${DEST.lng},${DEST.lat}?overview=full&geometries=geojson`)
            .then(r => r.json())
            .then(data => {
                if (data && data.routes && data.routes.length > 0) {
                    routePoints = data.routes[0].geometry.coordinates.map(c => [c[1], c[0]]);
                    totalDistance = data.routes[0].distance / 1000; // km
                } else {
                    totalDistance = haversine([STORE.lat, STORE.lng], [DEST.lat, DEST.lng]);
                    routePoints = generateRoute(STORE, DEST, 80);
                }
                if (callback) callback();
            })
            .catch(() => {
                totalDistance = haversine([STORE.lat, STORE.lng], [DEST.lat, DEST.lng]);
                routePoints = generateRoute(STORE, DEST, 80);
                if (callback) callback();
            });
    }

    // Initialize map sequence
    calcRoute(() => {
        fullRouteLine.setLatLngs(routePoints);
        renderMap(initialProgress, riderPos.lat, riderPos.lng);
    });

    // Attempt to precise geocode
    fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(FULL_ADDR))
        .then(r => r.json())
        .then(data => {
            if (data && data.length > 0) {
                DEST.lat = parseFloat(data[0].lat);
                DEST.lng = parseFloat(data[0].lon);
                destMarker.setLatLng([DEST.lat, DEST.lng]);
                calcRoute(() => {
                    fullRouteLine.setLatLngs(routePoints);
                    renderMap(initialProgress, riderPos.lat, riderPos.lng);
                    map.fitBounds([ [STORE.lat, STORE.lng], [DEST.lat, DEST.lng] ], { padding: [50, 50], maxZoom: 15 });
                });
            }
        }).catch(e => console.log('Geocoding fallback applied.'));

    // Find closest route point to a GPS position
    function closestRouteIdx(lat, lng) {
        let minD = Infinity, bestIdx = 0;
        for (let i = 0; i < routePoints.length; i++) {
            const d = haversine([lat, lng], routePoints[i]);
            if (d < minD) { minD = d; bestIdx = i; }
        }
        return bestIdx;
    }

    // ═══ INITIAL RENDER ═══
    function renderMap(progress, rLat, rLng) {
        const isDelivered = ORDER_STATUS === 'delivered' || progress >= 100;

        if (!riderMarker && (hasRider || isDelivered)) {
            riderMarker = L.marker([rLat || STORE.lat, rLng || STORE.lng], { icon: riderIcon, zIndexOffset: 1000 }).addTo(map);
            riderMarker.bindPopup('🛵 Your rider is here!');
        }

        if (isDelivered) {
            trailLine.setLatLngs(routePoints);
            remainingLine.setLatLngs([]);
            if (riderMarker) riderMarker.setLatLng([DEST.lat, DEST.lng]);
            updateEtaDisplay(0, 100, 'Delivered!', 'Arrived');
            return;
        }

        if (pickedUp && rLat && rLng) {
            // Rider has real position — use it
            const idx = closestRouteIdx(rLat, rLng);
            trailLine.setLatLngs(routePoints.slice(0, idx + 1));
            remainingLine.setLatLngs(routePoints.slice(idx));
            if (riderMarker) riderMarker.setLatLng([rLat, rLng]);
        } else if (pickedUp) {
            // Use progress-based estimate
            const idx = Math.floor((progress / 100) * (routePoints.length - 1));
            trailLine.setLatLngs(routePoints.slice(0, idx + 1));
            remainingLine.setLatLngs(routePoints.slice(idx));
            if (riderMarker) riderMarker.setLatLng(routePoints[idx]);
        } else if (hasRider) {
            // Rider assigned but hasn't picked up
            trailLine.setLatLngs([]);
            remainingLine.setLatLngs(routePoints);
            if (riderMarker) riderMarker.setLatLng([rLat || STORE.lat, rLng || STORE.lng]);
        } else {
            trailLine.setLatLngs([]);
            remainingLine.setLatLngs(routePoints);
        }
    }

    function updateEtaDisplay(remaining, progress, etaText, arrivalText) {
        document.getElementById('etaDistance').textContent = remaining !== null ? remaining.toFixed(1) : '—';
        document.getElementById('etaProgress').textContent = progress + '%';
        document.getElementById('etaTime').textContent = etaText || '—';
        document.getElementById('etaArrival').textContent = arrivalText || '';
        document.getElementById('progressBar').style.width = progress + '%';

        // Nearby detection
        if (remaining !== null && remaining < 1 && remaining > 0 && progress < 100) {
            document.getElementById('etaStatus').textContent = 'Almost there!';
            showNotif('urgent', '🎉 Your rider is nearby! Please prepare to receive your order.');
        } else if (progress >= 100) {
            document.getElementById('etaStatus').textContent = 'Delivered';
            document.getElementById('etaTime').classList.remove('live');
        } else if (progress > 0) {
            document.getElementById('etaStatus').textContent = 'In Transit';
        }
    }

    // Initial state
    let initialProgress = {{ $order->getDeliveryProgressPercent() }};

    // Set initial ETA values from server
    @php
        $initRemaining = 0;
        if ($order->delivery_started_at && $order->estimated_delivery_minutes) {
            $progressPct = $order->getDeliveryProgressPercent();
            $initRemaining = round(10 * (1 - $progressPct / 100), 1);
        }
    @endphp

    if (initialProgress > 0) {
        const remaining = totalDistance * (1 - initialProgress / 100);
        updateEtaDisplay(remaining, initialProgress, '{{ $order->formatted_eta }}', '{{ optional($order->estimated_arrival)->format("g:i A") ?? "—" }}');
        document.getElementById('etaArriveAt').textContent = '{{ optional($order->estimated_arrival)->format("g:i A") ?? "—" }}';
    } else if (ORDER_STATUS === 'delivered') {
        updateEtaDisplay(0, 100, 'Delivered!', 'Arrived');
    } else {
        document.getElementById('etaDistance').textContent = totalDistance.toFixed(1);
        document.getElementById('etaTime').textContent = 'Pending';
        document.getElementById('etaTime').classList.remove('live');
        document.getElementById('etaArrival').textContent = 'Order not yet shipped';
    }

    // ═══ LIVE POLLING ═══
    let lastStatus = ORDER_STATUS;
    let pollInterval = null;

    function pollTracking() {
        fetch(TRACKING_URL, { credentials: 'same-origin' })
            .then(r => r.json())
            .then(data => {
                const progress = data.progress || 0;
                const isDelivered = data.status === 'delivered';

                // Update rider position on map
                if (data.rider && data.rider.lat && data.rider.lng) {
                    renderMap(progress, data.rider.lat, data.rider.lng);
                    document.getElementById('riderBar').style.display = '';
                    document.getElementById('riderName').textContent = data.rider.name || 'Rider';
                    document.getElementById('riderStatusText').textContent =
                        data.picked_up_at ? 'On the way to you' : 'Heading to store';
                }

                // Update ETA
                const remaining = totalDistance * (1 - progress / 100);
                updateEtaDisplay(remaining, progress, data.eta || '—', data.estimated_arrival || '—');
                document.getElementById('etaArriveAt').textContent = data.estimated_arrival || '—';

                // Status change notification
                if (data.status !== lastStatus) {
                    handleStatusChange(lastStatus, data.status, data);
                    lastStatus = data.status;
                }

                // Stop polling when delivered
                if (isDelivered && pollInterval) {
                    clearInterval(pollInterval);
                    pollInterval = null;
                    showNotif('success', '✅ Your order has been delivered! Thank you for shopping at Pet Markt-PH.');
                }
            })
            .catch(() => { /* silent fail — retry next interval */ });
    }

    // Poll every 3 seconds for active orders to get ultra real-time feel
    if (ORDER_STATUS !== 'delivered' && ORDER_STATUS !== 'cancelled') {
        pollInterval = setInterval(pollTracking, 3000);
        // Also poll once immediately if out for delivery
        if (ORDER_STATUS === 'out_for_delivery') {
            setTimeout(pollTracking, 2000);
        }
    }

    // Status change handler
    function handleStatusChange(oldStatus, newStatus, data) {
        if (newStatus === 'out_for_delivery' && data.picked_up_at) {
            showNotif('info', '🚚 Your order has been picked up and is on its way!');
            requestBrowserNotification('Order On The Way!', 'Your order has been picked up by the rider.');
        } else if (newStatus === 'out_for_delivery') {
            showNotif('info', '🛵 A rider has been assigned to your order!');
        } else if (newStatus === 'delivered') {
            showNotif('success', '✅ Your order has been delivered!');
            requestBrowserNotification('Order Delivered!', 'Your Pet Markt-PH order has arrived.');
        }
    }

    // Notification helpers
    function showNotif(type, msg) {
        const el = document.getElementById('notif' + type.charAt(0).toUpperCase() + type.slice(1));
        if (!el) return;
        el.textContent = msg;
        el.classList.add('show');
        setTimeout(() => el.classList.remove('show'), 10000);
    }

    function requestBrowserNotification(title, body) {
        if (!('Notification' in window)) return;
        const send = () => new Notification('🐾 Pet Markt-PH — ' + title, { body, tag: 'order-' + ORDER_ID });
        if (Notification.permission === 'granted') send();
        else if (Notification.permission !== 'denied') Notification.requestPermission().then(p => { if (p === 'granted') send(); });
    }

    // Real-time tracking is handled solely by the Live Polling fetch interval above.
})();
</script>
<style>
@keyframes riderBob {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-3px); }
}
</style>
@endpush
@endsection
