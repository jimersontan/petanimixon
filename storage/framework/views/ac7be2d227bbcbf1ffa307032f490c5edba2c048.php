
<?php $__env->startSection('title', 'Track Order ' . $order->display_id); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
/* ══════════════════════════════════════════════════════════
   ADMIN ORDER TRACKING — Pet Markt-PH
   ══════════════════════════════════════════════════════════ */
@import  url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

.admin-track-page {
    max-width: 1100px;
    margin: 0 auto;
    padding: 24px 20px 60px;
    font-family: 'Inter', -apple-system, sans-serif;
}

/* ── HEADER ── */
.at-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
}
.at-header-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.at-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: #f5f5f5;
    color: #555;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.2s;
    border: 1px solid #e8e8e8;
}
.at-back-btn:hover { background: #eee; }
.at-header h1 {
    font-size: 22px;
    font-weight: 800;
    color: #111;
    margin: 0;
}
.at-order-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
}
.at-badge-status {
    background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7;
}
.at-badge-local { background: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
.at-badge-courier { background: #fce7f3; color: #be185d; border: 1px solid #fbcfe8; }

/* ── LAYOUT GRID ── */
.at-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 22px;
}

/* ── CARDS ── */
.at-card {
    background: #fff;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    border: 1px solid #f0f0f0;
    margin-bottom: 20px;
}
.at-card-title {
    font-size: 14px;
    font-weight: 800;
    color: #222;
    margin: 0 0 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.at-card-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}
.icon-map { background: #e8f5e9; }
.icon-timeline { background: #e3f2fd; }
.icon-details { background: #fff3e0; }
.icon-items { background: #fce4ec; }
.icon-customer { background: #f3e5f5; }

/* ── MAP ── */
.at-map-wrap {
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid #eee;
}
#adminTrackingMap {
    width: 100%;
    height: 380px;
    z-index: 0;
}

/* ── ETA PANEL ── */
.at-eta-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-top: 16px;
    padding: 14px;
    background: linear-gradient(135deg, #f8fdf8, #edf7ee);
    border-radius: 12px;
    border: 1px solid #c8e6c9;
}
.at-eta-cell {
    text-align: center;
}
.at-eta-label {
    font-size: 10px;
    text-transform: uppercase;
    font-weight: 700;
    color: #999;
    letter-spacing: 0.8px;
    margin-bottom: 3px;
}
.at-eta-value {
    font-size: 20px;
    font-weight: 900;
    color: #2e7d32;
    line-height: 1.1;
}
.at-eta-sub {
    font-size: 11px;
    color: #888;
    margin-top: 2px;
}

/* ── PROGRESS BAR ── */
.at-progress {
    margin-top: 12px;
    background: #f0f0f0;
    border-radius: 8px;
    height: 8px;
    overflow: hidden;
}
.at-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #43a047, #66bb6a, #aed581);
    border-radius: 8px;
    transition: width 1.5s ease;
}

/* ── RIDER INFO ── */
.at-rider-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 12px;
    padding: 10px 14px;
    background: #f9fbe7;
    border-radius: 10px;
    border: 1px solid #dce775;
    font-size: 13px;
    flex-wrap: wrap;
    gap: 8px;
}
.at-rider-name { font-weight: 700; color: #33691e; }
.at-rider-status { color: #689f38; font-weight: 600; }

/* ── TIMELINE ── */
.at-timeline {
    position: relative;
    padding-left: 34px;
}
.at-timeline::before {
    content: '';
    position: absolute;
    left: 14px;
    top: 6px;
    bottom: 6px;
    width: 3px;
    background: #e0e0e0;
    border-radius: 2px;
}
.at-tl-step {
    position: relative;
    padding-bottom: 22px;
}
.at-tl-step:last-child { padding-bottom: 0; }
.at-tl-dot {
    position: absolute;
    left: -28px;
    top: 2px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #e0e0e0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    color: #fff;
    z-index: 1;
}
.at-tl-step.done .at-tl-dot { background: #43a047; }
.at-tl-step.current .at-tl-dot { background: #f97316; box-shadow: 0 0 0 4px rgba(249,115,22,0.15); }
.at-tl-title {
    font-size: 13px;
    font-weight: 700;
    color: #bbb;
}
.at-tl-step.done .at-tl-title,
.at-tl-step.current .at-tl-title { color: #222; }
.at-tl-desc {
    font-size: 12px;
    color: #ccc;
    margin-top: 2px;
}
.at-tl-step.done .at-tl-desc,
.at-tl-step.current .at-tl-desc { color: #888; }
.at-tl-time {
    font-size: 11px;
    color: #aaa;
    margin-top: 2px;
    font-weight: 600;
}

/* ── DETAIL ROWS ── */
.at-detail-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    font-size: 13px;
    border-bottom: 1px solid #f5f5f5;
}
.at-detail-row:last-child { border-bottom: none; }
.at-detail-label { color: #888; }
.at-detail-value { color: #333; font-weight: 600; }

/* ── ITEMS ── */
.at-item {
    display: flex;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #f5f5f5;
    align-items: center;
}
.at-item:last-child { border-bottom: none; }
.at-item-img {
    width: 44px;
    height: 44px;
    border-radius: 8px;
    object-fit: cover;
    background: #f9f9f9;
    flex-shrink: 0;
}
.at-item-name { font-size: 13px; font-weight: 600; color: #222; }
.at-item-meta { font-size: 12px; color: #888; margin-top: 2px; }
.at-item-price { margin-left: auto; font-size: 14px; font-weight: 800; color: #2e7d32; white-space: nowrap; }

/* ── TOTAL ── */
.at-total-row {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    font-size: 13px;
}
.at-total-row.grand {
    font-size: 16px;
    font-weight: 900;
    border-top: 2px solid #e0e0e0;
    padding-top: 12px;
    margin-top: 6px;
}
.at-total-row.grand .at-total-amount { color: #2e7d32; }

/* ── RESPONSIVE ── */
@media (max-width: 900px) {
    .at-grid { grid-template-columns: 1fr; }
    #adminTrackingMap { height: 280px; }
    .at-eta-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
    .admin-track-page { padding: 12px 10px 40px; }
    .at-header h1 { font-size: 18px; }
    .at-card { padding: 16px; }
    #adminTrackingMap { height: 220px; }
}

/* Leaflet override */
.leaflet-popup-content-wrapper { border-radius: 10px !important; font-family: 'Inter', sans-serif !important; font-size: 13px !important; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-track-page">

    
    <div class="at-header">
        <div class="at-header-left">
            <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="at-back-btn">← Back to Order</a>
            <h1>📦 Track <?php echo e($order->display_id); ?></h1>
        </div>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <span class="at-order-badge at-badge-status"><?php echo e($order->status_label); ?></span>
            <span class="at-order-badge <?php echo e($order->isLocal() ? 'at-badge-local' : 'at-badge-courier'); ?>">
                <?php echo e($order->isLocal() ? '🛵 Local Delivery' : '📦 Courier'); ?>

            </span>
        </div>
    </div>

    <div class="at-grid">

        
        <div>
            <div class="at-card">
                <div class="at-card-title"><span class="at-card-icon icon-map">🗺️</span> Live Delivery Map</div>
                <div class="at-map-wrap">
                    <div id="adminTrackingMap"></div>
                </div>

                
                <div class="at-eta-grid">
                    <div class="at-eta-cell">
                        <div class="at-eta-label">Distance</div>
                        <div class="at-eta-value" id="etaDist">—</div>
                        <div class="at-eta-sub">km</div>
                    </div>
                    <div class="at-eta-cell">
                        <div class="at-eta-label">ETA</div>
                        <div class="at-eta-value" id="etaTime">—</div>
                        <div class="at-eta-sub" id="etaSub">Calculating...</div>
                    </div>
                    <div class="at-eta-cell">
                        <div class="at-eta-label">Progress</div>
                        <div class="at-eta-value" id="etaProg">0%</div>
                        <div class="at-eta-sub">
                            <?php if($order->order_status === 'out_for_delivery'): ?> In Transit
                            <?php elseif($order->order_status === 'delivered'): ?> Delivered
                            <?php else: ?> Waiting <?php endif; ?>
                        </div>
                    </div>
                    <div class="at-eta-cell">
                        <div class="at-eta-label">Method</div>
                        <div class="at-eta-value" style="font-size:14px;"><?php echo e($order->isLocal() ? 'Local' : 'Courier'); ?></div>
                        <div class="at-eta-sub"><?php echo e($order->shipping_type); ?></div>
                    </div>
                </div>

                
                <div class="at-progress">
                    <div class="at-progress-fill" id="progressBar" style="width: <?php echo e($order->getDeliveryProgressPercent()); ?>%;"></div>
                </div>

                
                <?php if($order->rider_id): ?>
                <div class="at-rider-bar">
                    <div>🛵 <span class="at-rider-name"><?php echo e(optional($order->rider)->full_name ?? 'Rider'); ?></span></div>
                    <div class="at-rider-status">
                        <?php if($order->rider_picked_up_at): ?> On the way to customer
                        <?php else: ?> Heading to store for pickup <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            
            <div class="at-card">
                <div class="at-card-title"><span class="at-card-icon icon-items">🛒</span> Items Ordered</div>
                <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="at-item">
                    <?php if($oi->product): ?>
                        <img class="at-item-img" src="<?php echo e($oi->product->image_url); ?>" alt="" onerror="this.style.display='none'">
                    <?php endif; ?>
                    <div>
                        <div class="at-item-name"><?php echo e(optional($oi->product)->product_name ?? 'Product #'.$oi->product_id); ?></div>
                        <div class="at-item-meta">Qty: <?php echo e($oi->quantity); ?> · ₱<?php echo e(number_format((float)$oi->unit_price, 2)); ?></div>
                    </div>
                    <div class="at-item-price">₱<?php echo e(number_format((float)$oi->total_amount, 2)); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <hr style="border:0; border-top:1px solid #f0f0f0; margin:12px 0;">
                <div class="at-total-row"><span class="at-detail-label">Subtotal</span><span>₱<?php echo e(number_format((float)$order->order_amount, 2)); ?></span></div>
                <div class="at-total-row"><span class="at-detail-label">Shipping</span><span><?php echo e($order->shipping_fee > 0 ? '₱'.number_format((float)$order->shipping_fee, 2) : 'FREE'); ?></span></div>
                <?php if($order->discount_amount > 0): ?>
                <div class="at-total-row"><span class="at-detail-label" style="color:#43a047;">Discount</span><span style="color:#43a047;">-₱<?php echo e(number_format((float)$order->discount_amount, 2)); ?></span></div>
                <?php endif; ?>
                <div class="at-total-row grand">
                    <span>Total</span>
                    <span class="at-total-amount">₱<?php echo e(number_format((float)$order->total_amount, 2)); ?></span>
                </div>
            </div>
        </div>

        
        <div>
            
            <div class="at-card">
                <div class="at-card-title"><span class="at-card-icon icon-timeline">📋</span> Status Timeline</div>
                <?php
                    $flow = $order->getStatusFlow();
                    $currentIdx = array_search($order->order_status, $flow);
                    $currentIdx = $currentIdx === false ? 0 : $currentIdx;
                ?>

                <div class="at-timeline">
                    <?php $__currentLoopData = $flow; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $stepKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $isDone = $idx < $currentIdx;
                        $isCurrent = $idx === $currentIdx;
                        $label = \App\Models\Order::STATUS_LABELS[$stepKey] ?? ucfirst(str_replace('_', ' ', $stepKey));
                    ?>
                    <div class="at-tl-step <?php echo e($isDone ? 'done' : ''); ?> <?php echo e($isCurrent ? 'current' : ''); ?>">
                        <div class="at-tl-dot"><?php echo e($isDone ? '✓' : ($isCurrent ? '●' : '')); ?></div>
                        <div class="at-tl-title"><?php echo e($label); ?></div>
                        <?php if($isDone || $isCurrent): ?>
                            <?php
                                $historyEntry = $order->statusHistory->where('status', $stepKey)->first();
                            ?>
                            <?php if($historyEntry): ?>
                                <div class="at-tl-time"><?php echo e($historyEntry->created_at->format('M j, g:i A')); ?></div>
                                <?php if($historyEntry->note): ?>
                                    <div class="at-tl-desc"><?php echo e($historyEntry->note); ?></div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <?php if($order->order_status === 'cancelled'): ?>
                <div style="padding: 12px; background: #ffebee; border-radius: 8px; margin-top: 12px; color: #c62828; font-weight: 600; text-align: center; font-size: 13px;">
                    ❌ This order was cancelled.
                </div>
                <?php endif; ?>
            </div>

            
            <div class="at-card">
                <div class="at-card-title"><span class="at-card-icon icon-customer">👤</span> Customer Details</div>
                <div class="at-detail-row">
                    <span class="at-detail-label">Customer</span>
                    <span class="at-detail-value"><?php echo e(optional($order->user)->full_name ?? '—'); ?></span>
                </div>
                <div class="at-detail-row">
                    <span class="at-detail-label">Email</span>
                    <span class="at-detail-value"><?php echo e(optional($order->user)->email ?? '—'); ?></span>
                </div>
                <div class="at-detail-row">
                    <span class="at-detail-label">Phone</span>
                    <span class="at-detail-value"><?php echo e(optional($order->shippingAddress)->phone_number ?? '—'); ?></span>
                </div>
                <?php if($order->shippingAddress): ?>
                <div class="at-detail-row">
                    <span class="at-detail-label">Address</span>
                    <span class="at-detail-value" style="text-align:right; max-width:200px;">
                        <?php echo e($order->shippingAddress->street_address); ?>,
                        <?php echo e($order->shippingAddress->barangay ? $order->shippingAddress->barangay . ', ' : ''); ?>

                        <?php echo e($order->shippingAddress->city_municipality); ?>

                    </span>
                </div>
                <?php endif; ?>
            </div>

            
            <div class="at-card">
                <div class="at-card-title"><span class="at-card-icon icon-details">📄</span> Order Details</div>
                <div class="at-detail-row">
                    <span class="at-detail-label">Order ID</span>
                    <span class="at-detail-value"><?php echo e($order->order_id); ?></span>
                </div>
                <div class="at-detail-row">
                    <span class="at-detail-label">Date</span>
                    <span class="at-detail-value"><?php echo e($order->created_at->format('M j, Y g:i A')); ?></span>
                </div>
                <div class="at-detail-row">
                    <span class="at-detail-label">Payment</span>
                    <span class="at-detail-value">Cash on Delivery</span>
                </div>
                <?php if($order->tracking_number): ?>
                <div class="at-detail-row">
                    <span class="at-detail-label">Tracking #</span>
                    <span class="at-detail-value" style="font-family:monospace; letter-spacing:1px;"><?php echo e($order->tracking_number); ?></span>
                </div>
                <?php endif; ?>
                <?php if($order->rider): ?>
                <div class="at-detail-row">
                    <span class="at-detail-label">Rider</span>
                    <span class="at-detail-value"><?php echo e($order->rider->full_name); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function() {
    'use strict';

    var STORE = { lat: 8.9475, lng: 125.5406 };

    <?php
        $destCity = optional($order->shippingAddress)->city_municipality ?? 'Butuan';
        $cityCoords = [
            'manila' => [14.5995, 120.9842], 'cebu' => [10.3157, 123.8854],
            'davao' => [7.1907, 125.4553], 'butuan' => [8.9475, 125.5406],
            'butuan city' => [8.9475, 125.5406], 'cagayan de oro' => [8.4542, 124.6319],
            'nasipit' => [8.9953, 125.4987], 'cabadbaran' => [9.1233, 125.5339],
            'surigao' => [9.7572, 125.5138], 'bayugan' => [8.7167, 125.7500],
        ];
        $cl = strtolower(trim($destCity));
        $dLat = $cityCoords[$cl][0] ?? 8.9575;
        $dLng = $cityCoords[$cl][1] ?? 125.5506;
        $rLat = $order->rider_lat ?? $dLat;
        $rLng = $order->rider_lng ?? $dLng;
    ?>

    var DEST = { lat: <?php echo e($dLat); ?>, lng: <?php echo e($dLng); ?> };
    var riderPos = { lat: <?php echo e($rLat); ?>, lng: <?php echo e($rLng); ?> };
    var hasRider = <?php echo e($order->rider_id ? 'true' : 'false'); ?>;

    var map = L.map('adminTrackingMap', { zoomControl: true, attributionControl: false })
        .fitBounds([ [STORE.lat, STORE.lng], [DEST.lat, DEST.lng] ], { padding: [40, 40], maxZoom: 15 });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);

    var storeIcon = L.divIcon({ html: '<div style="font-size:28px;filter:drop-shadow(0 2px 4px rgba(0,0,0,.3));">🏪</div>', iconSize: [32, 32], iconAnchor: [16, 16], className: '' });
    var destIcon = L.divIcon({ html: '<div style="font-size:28px;filter:drop-shadow(0 2px 4px rgba(0,0,0,.3));">📍</div>', iconSize: [32, 32], iconAnchor: [16, 32], className: '' });
    var riderIcon = L.divIcon({ html: '<div style="font-size:26px;filter:drop-shadow(0 3px 6px rgba(0,0,0,.4));">🛵</div>', iconSize: [30, 30], iconAnchor: [15, 15], className: '' });

    L.marker([STORE.lat, STORE.lng], { icon: storeIcon }).addTo(map).bindPopup('<b>🏪 Pet Markt-PH Store</b>');
    L.marker([DEST.lat, DEST.lng], { icon: destIcon }).addTo(map).bindPopup('<b>📍 Customer Location</b>');

    L.polyline([[STORE.lat, STORE.lng], [DEST.lat, DEST.lng]], {
        color: '#bbb', weight: 3, opacity: 0.4, dashArray: '8, 6'
    }).addTo(map);

    var riderMarker = null;
    if (hasRider) {
        riderMarker = L.marker([riderPos.lat, riderPos.lng], { icon: riderIcon }).addTo(map).bindPopup('<b>🛵 Rider</b>');
    }

    function haversine(p1, p2) {
        var R = 6371;
        var dLat = (p2[0] - p1[0]) * Math.PI / 180;
        var dLng = (p2[1] - p1[1]) * Math.PI / 180;
        var a = Math.sin(dLat/2)*Math.sin(dLat/2) + Math.cos(p1[0]*Math.PI/180) * Math.cos(p2[0]*Math.PI/180) * Math.sin(dLng/2)*Math.sin(dLng/2);
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    }

    var dist = haversine([STORE.lat, STORE.lng], [DEST.lat, DEST.lng]);
    var distEl = document.getElementById('etaDist');
    if (distEl) distEl.textContent = dist.toFixed(1);

    // Poll for updates every 15s
    var TRACKING_URL = '<?php echo e(route("admin.orders.tracking-data", $order->id)); ?>';

    function poll() {
        fetch(TRACKING_URL)
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.rider && riderMarker) {
                    riderMarker.setLatLng([data.rider.lat, data.rider.lng]);
                }
                var prog = document.getElementById('progressBar');
                var progText = document.getElementById('etaProg');
                var etaText = document.getElementById('etaTime');

                if (prog) prog.style.width = data.progress + '%';
                if (progText) progText.textContent = data.progress + '%';
                if (etaText) etaText.textContent = data.eta || '—';
            })
            .catch(function() {});
    }

    setInterval(poll, 15000);
    poll();
})();
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Pet Markt-PH\resources\views/admin_order_tracking.blade.php ENDPATH**/ ?>