<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Active Delivery - Pet Markt-PH Rider</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/rider.css')); ?>">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
    /* ══════ DELIVERY MAP ══════ */
    .delivery-map-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
        margin-bottom: 20px;
        border: 1px solid #e8f5e9;
    }
    .delivery-map-card h3 {
        font-size: 15px;
        font-weight: 800;
        color: #1a1a1a;
        margin: 0 0 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .delivery-map-wrapper {
        border-radius: 14px;
        overflow: hidden;
        border: 2px solid #e0e0e0;
    }
    #riderDeliveryMap {
        width: 100%;
        height: 340px;
    }

    /* ── ETA Summary Bar ── */
    .eta-summary-bar {
        display: flex;
        gap: 12px;
        margin-top: 14px;
        flex-wrap: wrap;
    }
    .eta-summary-item {
        flex: 1;
        min-width: 100px;
        background: linear-gradient(135deg, #f1f8e9, #e8f5e9);
        border-radius: 12px;
        padding: 14px;
        text-align: center;
        border: 1px solid #c8e6c9;
    }
    .eta-summary-item .label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 700;
        color: #888;
        margin-bottom: 4px;
    }
    .eta-summary-item .value {
        font-size: 20px;
        font-weight: 900;
        color: #2e7d32;
    }
    .eta-summary-item .sub {
        font-size: 11px;
        color: #888;
        margin-top: 2px;
    }

    /* ── Location Tracking Indicator ── */
    .location-tracker {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 12px;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .location-tracker.active {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        color: #2e7d32;
        border: 1px solid #a5d6a7;
    }
    .location-tracker.inactive {
        background: #fff3e0;
        color: #e65100;
        border: 1px solid #ffcc80;
    }
    .location-tracker.error {
        background: #ffebee;
        color: #c62828;
        border: 1px solid #ef9a9a;
    }
    .gps-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .gps-dot.on { background: #43a047; animation: gpsPulse 1.5s infinite; }
    .gps-dot.off { background: #ff9800; }
    .gps-dot.err { background: #ef5350; }
    @keyframes  gpsPulse { 0%,100% { box-shadow: 0 0 0 0 rgba(67,160,71,.4); } 50% { box-shadow: 0 0 0 6px rgba(67,160,71,.1); } }

    /* ── Navigation Button ── */
    .nav-external-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: linear-gradient(135deg, #1565c0, #1976d2);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
        margin-top: 12px;
    }
    .nav-external-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(21,101,192,.3);
        color: #fff;
    }

    /* ── Mobile responsive for map ── */
    @media (max-width: 768px) {
        #riderDeliveryMap { height: 260px; }
        .eta-summary-bar { gap: 8px; }
        .eta-summary-item { padding: 10px; min-width: 80px; }
        .eta-summary-item .value { font-size: 16px; }
    }
    </style>
</head>
<body class="rider-body">

    <?php if(session('success')): ?>
        <div class="rider-toast"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="rider-toast" style="background:#dc2626;"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <?php echo $__env->make('partials.rider_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="rider-layout">
        <aside class="rider-sidebar">
            <div class="nav-section-title">Navigation</div>
            <nav>
                <a href="<?php echo e(route('rider.dashboard')); ?>" class="nav-item" data-page="dashboard">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg></span>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo e(route('rider.available')); ?>" class="nav-item" data-page="available">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-3 10h-3v3h-2v-3H8v-2h3V8h2v3h3v2z"/></svg></span>
                    <span>Available Orders</span>
                </a>
                <a href="<?php echo e(route('rider.active')); ?>" class="nav-item active" data-page="active">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg></span>
                    <span>Active Delivery</span>
                </a>
                <a href="<?php echo e(route('rider.history')); ?>" class="nav-item" data-page="history">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/></svg></span>
                    <span>History</span>
                </a>
                <a href="<?php echo e(route('rider.products')); ?>" class="nav-item" data-page="products">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M5 8h2V6h10v2h2V6c0-1.1-.9-2-2-2H7V2H5v4c-1.1 0-2 .9-2 2v2zm-2 4v8c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-8H3z"/></svg></span>
                    <span>Products</span>
                </a>
            </nav>
            <div class="logout-link">
                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="nav-item" style="width:100%; border:none; background:none; cursor:pointer; text-align:left;">
                        <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg></span>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="rider-main">
            <div class="rider-page-header">
                <div>
                    <h1>Current Assignments</h1>
                    <div class="subtitle">Accepted pickups and deliveries currently assigned to you</div>
                </div>
            </div>

            <?php if($activeOrders->count() > 0): ?>
                <?php $__currentLoopData = $activeOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $destCity = optional($order->shippingAddress)->city_municipality ?? 'Butuan';
                    $cityCoords = [
                        'manila' => [14.5995, 120.9842], 'quezon city' => [14.6760, 121.0437],
                        'cebu' => [10.3157, 123.8854], 'davao' => [7.1907, 125.4553],
                        'butuan' => [8.9475, 125.5406], 'butuan city' => [8.9475, 125.5406],
                        'cagayan de oro' => [8.4542, 124.6319], 'zamboanga' => [6.9214, 122.0790],
                        'iloilo' => [10.7202, 122.5621], 'makati' => [14.5547, 121.0244],
                        'surigao' => [9.7572, 125.5138], 'bacolod' => [10.6840, 122.9563],
                        'nasipit' => [8.9953, 125.4987], 'cabadbaran' => [9.1233, 125.5339],
                        'bayugan' => [8.7167, 125.7500], 'buenavista' => [8.9833, 125.4087],
                    ];
                    $cl = strtolower(trim($destCity));
                    $dLat = $cityCoords[$cl][0] ?? 8.9575;
                    $dLng = $cityCoords[$cl][1] ?? 125.5506;
                    $hasPickedUp = $order->order_status === \App\Models\Order::STATUS_OUT_FOR_DELIVERY;
                    $statusLabel = $hasPickedUp ? 'In Transit' : 'Awaiting Pickup';
                    $statusBadgeClass = $hasPickedUp ? 'rider-badge-out_for_delivery' : 'rider-badge-rider_confirmed';
                    
                    $fullAddress = trim(implode(', ', array_filter([
                        $order->shippingAddress->street_address ?? '',
                        $order->shippingAddress->barangay ?? '',
                        $order->shippingAddress->city_municipality ?? 'Butuan',
                        $order->shippingAddress->province ?? '',
                        'Philippines'
                    ])));
                ?>

                
                <?php if($hasPickedUp): ?>
                <div class="delivery-map-card">
                    <h3>🗺️ Route to Customer — <?php echo e($order->display_id); ?></h3>
                    <div class="delivery-map-wrapper">
                        <div id="riderMap<?php echo e($order->id); ?>" style="width:100%; height:340px;"></div>
                    </div>

                    
                    <div class="eta-summary-bar">
                        <div class="eta-summary-item">
                            <div class="label">Distance</div>
                            <div class="value" id="riderDist<?php echo e($order->id); ?>">—</div>
                            <div class="sub">km remaining</div>
                        </div>
                        <div class="eta-summary-item">
                            <div class="label">ETA</div>
                            <div class="value" id="riderEta<?php echo e($order->id); ?>"><?php echo e($order->formatted_eta); ?></div>
                            <div class="sub">to customer</div>
                        </div>
                        <div class="eta-summary-item">
                            <div class="label">Progress</div>
                            <div class="value" id="riderProgress<?php echo e($order->id); ?>"><?php echo e($order->getDeliveryProgressPercent()); ?>%</div>
                            <div class="sub">complete</div>
                        </div>
                    </div>

                    
                    <div class="location-tracker inactive" id="gpsStatus<?php echo e($order->id); ?>">
                        <div class="gps-dot off" id="gpsDot<?php echo e($order->id); ?>"></div>
                        <span id="gpsText<?php echo e($order->id); ?>">📡 Enabling location tracking...</span>
                    </div>

                    
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo e(urlencode($fullAddress)); ?>" target="_blank" rel="noopener" class="nav-external-btn">
                        🗺️ Open accurate location in Google Maps
                    </a>
                </div>
                <?php endif; ?>

                
                <div class="active-order-detail">
                    <div class="order-header">
                        <h3><?php echo e($hasPickedUp ? '🚀' : '📦'); ?> <?php echo e($order->display_id); ?> — <?php echo e($statusLabel); ?></h3>
                        <span class="rider-badge-status <?php echo e($statusBadgeClass); ?>"><?php echo e($statusLabel); ?></span>
                    </div>
                    <div class="order-body">
                        <!-- Customer Info -->
                        <div class="customer-info">
                            <div class="info-item">
                                <div class="info-label">Customer Name</div>
                                <div class="info-value"><?php echo e(optional($order->user)->full_name ?? 'N/A'); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Phone</div>
                                <div class="info-value"><?php echo e(optional($order->user)->phone_number ?? 'N/A'); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Delivery Address</div>
                                <div class="info-value">
                                    <?php if($order->shippingAddress): ?>
                                        <?php echo e($order->shippingAddress->street_address ?? ''); ?>,
                                        <?php echo e($order->shippingAddress->barangay ?? ''); ?>

                                        <?php echo e($order->shippingAddress->city_municipality ?? ''); ?>,
                                        <?php echo e($order->shippingAddress->province ?? ''); ?>

                                        <?php echo e($order->shippingAddress->zip_code ?? ''); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Payment Method</div>
                                <div class="info-value"><?php echo e(strtoupper($order->payment_method)); ?></div>
                            </div>
                            <?php if($hasPickedUp && $order->estimated_delivery_minutes): ?>
                            <div class="info-item">
                                <div class="info-label">Estimated Arrival</div>
                                <div class="info-value" style="color: #2e7d32; font-weight: 700;">
                                    <?php echo e($order->formatted_eta); ?>

                                    <?php if($order->estimated_arrival): ?>
                                        (<?php echo e($order->estimated_arrival->format('g:i A')); ?>)
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Order Items -->
                        <div class="info-label" style="margin-bottom: 8px;">Order Items</div>
                        <ul class="items-list">
                            <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <span><?php echo e(optional($item->product)->product_name ?? 'Product'); ?> × <?php echo e($item->quantity); ?></span>
                                <span>₱<?php echo e(number_format((float)$item->total_amount, 0)); ?></span>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <li style="font-weight: 700;">
                                <span>Total</span>
                                <span><?php echo e($order->formatted_total); ?></span>
                            </li>
                        </ul>

                        <?php if($order->customer_notes): ?>
                        <div style="margin-bottom: 16px; padding: 12px 16px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; font-size: 0.85rem;">
                            <strong>Customer Notes:</strong> <?php echo e($order->customer_notes); ?>

                        </div>
                        <?php endif; ?>

                        <!-- Actions -->
                        <div class="order-actions">
                            <?php if(!$hasPickedUp): ?>
                                <form action="<?php echo e(route('rider.pickup', $order->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn-rider-warning" onclick="return confirm('Confirm: Order picked up from store?')">📦 Mark as Picked Up</button>
                                </form>
                            <?php else: ?>
                                <form action="<?php echo e(route('rider.deliver', $order->id)); ?>" method="POST" style="display: flex; flex-direction: column; width: 100%;">
                                    <?php echo csrf_field(); ?>
                                    <textarea name="rider_notes" class="delivery-notes-input" placeholder="Delivery notes (optional): e.g., Left with guard, delivered to door..." style="width: 100%; box-sizing: border-box; margin-bottom: 15px;"></textarea>
                                    <button type="submit" class="btn-rider-success" style="width: 100%; text-align: center; justify-content: center; padding: 14px 20px; font-size: 16px;">✅ Mark as Delivered</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <?php if($hasPickedUp): ?>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const STORE = { lat: 8.9475, lng: 125.5406 };
                    const DEST = { lat: <?php echo e($dLat); ?>, lng: <?php echo e($dLng); ?> };
                    const ORDER_ID = <?php echo e($order->id); ?>;
                    const CSRF = document.querySelector('meta[name="csrf-token"]').content;
                    const LOC_URL = '<?php echo e(route("rider.update-location", $order->id)); ?>';

                    // Map setup
                    const map = L.map('riderMap' + ORDER_ID, { zoomControl: true, attributionControl: false })
                        .fitBounds([[STORE.lat, STORE.lng], [DEST.lat, DEST.lng]], { padding: [40, 40], maxZoom: 15 });

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OSM', maxZoom: 18
                    }).addTo(map);

                    // Icons
                    const storePin = L.divIcon({ html: '<div style="font-size:28px;">🏪</div>', iconSize: [32, 32], iconAnchor: [16, 16], className: '' });
                    const destPin = L.divIcon({ html: '<div style="font-size:28px;">📍</div>', iconSize: [32, 32], iconAnchor: [16, 32], className: '' });
                    const mePin = L.divIcon({ html: '<div style="font-size:26px;filter:drop-shadow(0 2px 4px rgba(0,0,0,.3));">🛵</div>', iconSize: [30, 30], iconAnchor: [15, 15], className: '' });

                    L.marker([STORE.lat, STORE.lng], { icon: storePin }).addTo(map).bindPopup('<b>🏪 Store</b>');

                    const addr = `<?php echo e(addslashes($fullAddress)); ?>`;
                    let destMarker = null;

                    // Geocode customer address to find exact house instead of city center
                    fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(addr))
                        .then(r => r.json())
                        .then(data => {
                            if (data && data.length > 0) {
                                DEST.lat = parseFloat(data[0].lat);
                                DEST.lng = parseFloat(data[0].lon);
                            }
                            drawDestination();
                        })
                        .catch(() => drawDestination()); // Fallback to city center

                    let trail, remaining, pts;
                    
                    function drawDestination() {
                        destMarker = L.marker([DEST.lat, DEST.lng], { icon: destPin }).addTo(map).bindPopup('<b>📍 Customer</b><br>' + addr);
                        drawRoute();
                    }

                    // Route
                    function haversine(p1, p2) {
                        const R = 6371, dLat = (p2[0]-p1[0])*Math.PI/180, dLng = (p2[1]-p1[1])*Math.PI/180;
                        const a = Math.sin(dLat/2)**2 + Math.cos(p1[0]*Math.PI/180)*Math.cos(p2[0]*Math.PI/180)*Math.sin(dLng/2)**2;
                        return R*2*Math.atan2(Math.sqrt(a),Math.sqrt(1-a));
                    }

                    function drawRoute() {
                        // Fetch precise road network route
                        fetch(`https://router.project-osrm.org/route/v1/driving/${STORE.lng},${STORE.lat};${DEST.lng},${DEST.lat}?overview=full&geometries=geojson`)
                            .then(r => r.json())
                            .then(data => {
                                if (data && data.routes && data.routes.length > 0) {
                                    pts = data.routes[0].geometry.coordinates.map(c => [c[1], c[0]]);
                                } else {
                                    fallbackRoute();
                                }
                                renderLines();
                            })
                            .catch(() => {
                                fallbackRoute();
                                renderLines();
                            });
                    }

                    function fallbackRoute() {
                        const dist = haversine([STORE.lat, STORE.lng], [DEST.lat, DEST.lng]);
                        pts = [];
                        for (let i = 0; i <= 60; i++) {
                            const t = i/60;
                            const lat = STORE.lat + (DEST.lat-STORE.lat)*t;
                            const lng = STORE.lng + (DEST.lng-STORE.lng)*t;
                            const c = Math.sin(t*Math.PI) * dist * 0.006;
                            pts.push([lat+c*0.08, lng+c*0.04]);
                        }
                    }

                    function renderLines() {
                        L.polyline(pts, { color: '#bbb', weight: 3, opacity: 0.4, dashArray: '8,6' }).addTo(map);
                        if (!trail) trail = L.polyline([], { color: '#43a047', weight: 5, opacity: 0.8 }).addTo(map);
                        if (!remaining) remaining = L.polyline([], { color: '#ff9800', weight: 4, opacity: 0.6 }).addTo(map);
                        
                        // Setup trail and remaining lines based on current rider position
                        let minD = Infinity, bestIdx = 0;
                        for (let i = 0; i < pts.length; i++) {
                            const d = haversine([riderLat, riderLng], pts[i]);
                            if (d < minD) { minD = d; bestIdx = i; }
                        }
                        trail.setLatLngs(pts.slice(0, bestIdx + 1));
                        remaining.setLatLngs(pts.slice(bestIdx));
                        
                        // Initial distance calculation
                        const initRemaining = haversine([riderLat, riderLng], [DEST.lat, DEST.lng]);
                        document.getElementById('riderDist' + ORDER_ID).textContent = initRemaining.toFixed(1);
                    }

                    // Rider position
                    let riderLat = <?php echo e($order->rider_lat ?? $dLat); ?>;
                    let riderLng = <?php echo e($order->rider_lng ?? $dLng); ?>;
                    const riderMarker = L.marker([riderLat, riderLng], { icon: mePin, zIndexOffset: 1000 }).addTo(map);
                    riderMarker.bindPopup('🛵 You are here');

                    // ═══ GPS LOCATION BROADCASTING ═══
                    let gpsWatchId = null;
                    const gpsStatus = document.getElementById('gpsStatus' + ORDER_ID);
                    const gpsDot = document.getElementById('gpsDot' + ORDER_ID);
                    const gpsText = document.getElementById('gpsText' + ORDER_ID);

                    if ('geolocation' in navigator) {
                        gpsWatchId = navigator.geolocation.watchPosition(
                            function(pos) {
                                riderLat = pos.coords.latitude;
                                riderLng = pos.coords.longitude;

                                // Update marker
                                riderMarker.setLatLng([riderLat, riderLng]);

                                // Update trail
                                let minD = Infinity, bestIdx = 0;
                                for (let i = 0; i < pts.length; i++) {
                                    const d = haversine([riderLat, riderLng], pts[i]);
                                    if (d < minD) { minD = d; bestIdx = i; }
                                }
                                trail.setLatLngs(pts.slice(0, bestIdx + 1));
                                remaining.setLatLngs(pts.slice(bestIdx));

                                // Update distance & ETA
                                const rem = haversine([riderLat, riderLng], [DEST.lat, DEST.lng]);
                                document.getElementById('riderDist' + ORDER_ID).textContent = rem.toFixed(1);
                                const etaMins = Math.round(rem / 0.5);
                                document.getElementById('riderEta' + ORDER_ID).textContent = etaMins > 0 ? '~' + etaMins + 'm' : 'Arriving!';
                                
                                if (pts && pts.length > 0) {
                                    const dist = haversine([STORE.lat, STORE.lng], [DEST.lat, DEST.lng]);
                                    document.getElementById('riderProgress' + ORDER_ID).textContent = Math.round(Math.max(0, 1 - rem/dist) * 100) + '%';
                                }

                                // GPS indicator
                                gpsStatus.className = 'location-tracker active';
                                gpsDot.className = 'gps-dot on';
                                gpsText.textContent = '📡 GPS Active — Broadcasting location';

                                // Send to server
                                sendLocation(riderLat, riderLng);
                            },
                            function(err) {
                                gpsStatus.className = 'location-tracker error';
                                gpsDot.className = 'gps-dot err';
                                gpsText.textContent = '❌ GPS Error: ' + err.message;
                            },
                            { enableHighAccuracy: true, maximumAge: 10000, timeout: 15000 }
                        );
                    } else {
                        gpsStatus.className = 'location-tracker error';
                        gpsDot.className = 'gps-dot err';
                        gpsText.textContent = '❌ GPS not available in this browser';
                    }

                    // Throttled location send
                    let lastSend = 0;
                    function sendLocation(lat, lng) {
                        const now = Date.now();
                        if (now - lastSend < 3000) return; // Every 3 seconds
                        lastSend = now;

                        fetch(LOC_URL, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': CSRF,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ lat, lng }),
                            credentials: 'same-origin'
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.eta) {
                                document.getElementById('riderEta' + ORDER_ID).textContent = data.eta;
                            }
                            if (data.progress !== undefined) {
                                document.getElementById('riderProgress' + ORDER_ID).textContent = data.progress + '%';
                            }
                        })
                        .catch(() => {});
                    }
                });
                </script>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="rider-card">
                    <div class="rider-card-body">
                        <div class="rider-empty-state">
                            <div class="empty-icon">🛵</div>
                            <h3>No Current Assignments</h3>
                            <p>Accept an order from the Available Orders page, then pick it up and complete the delivery here.</p>
                            <a href="<?php echo e(route('rider.available')); ?>" class="btn-rider-primary" style="margin-top: 16px;">View Available Orders →</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Pet Markt-PH\resources\views/rider/active_delivery.blade.php ENDPATH**/ ?>