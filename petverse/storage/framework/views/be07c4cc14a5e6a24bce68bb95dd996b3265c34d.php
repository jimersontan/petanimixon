

<?php $__env->startSection('title', 'Track Order - Pet Animixon'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
.track-page { max-width: 900px; margin: 0 auto; padding: 32px 20px 60px; }
.track-header { text-align: center; margin-bottom: 28px; }
.track-header h1 { font-size: 28px; font-weight: 800; color: #222; margin: 0 0 6px; }
.track-header p { font-size: 14px; color: #888; margin: 0; }
.track-id-badge { display: inline-block; background: #fff4ec; color: #FF8C42; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; margin-top: 10px; }

.track-card { background: #fff; border-radius: 14px; padding: 28px; box-shadow: 0 2px 12px rgba(0,0,0,.06); margin-bottom: 20px; position: relative; overflow: hidden; z-index: 0; }
.track-card h3 { font-size: 16px; font-weight: 700; color: #222; margin: 0 0 18px; }

/* ═══ LIVE MAP ═══ */
#trackingMap { width: 100%; height: 400px; border-radius: 12px; border: 2px solid #f0f0f0; }
.map-eta-bar {
    display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;
    margin-top: 16px; padding: 16px; background: linear-gradient(135deg, #fff4ec, #fffaf5);
    border-radius: 10px; border: 1px solid #ffe0c4;
}
.eta-item { text-align: center; flex: 1; min-width: 100px; }
.eta-label { font-size: 11px; text-transform: uppercase; font-weight: 700; color: #999; letter-spacing: .5px; }
.eta-value { font-size: 20px; font-weight: 800; color: #FF8C42; margin-top: 2px; }
.eta-value.live { animation: pulse 1.5s infinite; }
@keyframes  pulse { 0%,100% { opacity: 1; } 50% { opacity: .6; } }
.eta-sub { font-size: 11px; color: #888; margin-top: 2px; }

/* Notification banner */
.notif-banner {
    display: none; padding: 14px 20px; border-radius: 10px; margin-bottom: 20px;
    background: linear-gradient(135deg, #E8F5E9, #C8E6C9); border: 1px solid #A5D6A7;
    font-size: 14px; font-weight: 600; color: #2E7D32; text-align: center;
    animation: slideDown .4s ease;
}
.notif-banner.show { display: block; }
@keyframes  slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

/* Timeline */
.track-timeline { position: relative; padding-left: 32px; }
.track-timeline::before { content: ''; position: absolute; left: 12px; top: 4px; bottom: 4px; width: 3px; background: #e0e0e0; border-radius: 2px; }
.track-step { position: relative; padding-bottom: 28px; }
.track-step:last-child { padding-bottom: 0; }
.track-dot {
    position: absolute; left: -26px; top: 2px; width: 22px; height: 22px; border-radius: 50%;
    background: #e0e0e0; display: flex; align-items: center; justify-content: center;
    font-size: 10px; color: #fff;
}
.track-step.done .track-dot { background: #3DB868; }
.track-step.current .track-dot { background: #FF8C42; box-shadow: 0 0 0 5px rgba(255,140,66,.2); }
.track-step-title { font-size: 14px; font-weight: 700; color: #999; }
.track-step.done .track-step-title, .track-step.current .track-step-title { color: #222; }
.track-step-desc { font-size: 12px; color: #aaa; margin-top: 2px; }
.track-step.done .track-step-desc, .track-step.current .track-step-desc { color: #888; }

/* Order Details */
.track-detail-row { display: flex; justify-content: space-between; padding: 8px 0; font-size: 14px; border-bottom: 1px solid #f5f5f5; }
.track-detail-row:last-child { border-bottom: none; }
.track-detail-label { color: #888; }
.track-detail-value { color: #333; font-weight: 600; }
.track-detail-value.status { text-transform: uppercase; font-size: 12px; letter-spacing: .5px; padding: 3px 10px; border-radius: 12px; }
.status-pending { background: #FFF3E0; color: #FF8C42; }
.status-processing { background: #E3F2FD; color: #1976D2; }
.status-shipped { background: #E8F5E9; color: #2E7D32; }
.status-delivered { background: #E8F5E9; color: #2E7D32; }
.status-cancelled { background: #FFEBEE; color: #C62828; }

/* Items */
.track-item { display: flex; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f5f5f5; }
.track-item:last-child { border-bottom: none; }
.track-item-img { width: 50px; height: 50px; border-radius: 6px; object-fit: cover; background: #f5f5f5; }
.track-item-name { font-size: 13px; font-weight: 600; color: #222; }
.track-item-meta { font-size: 12px; color: #888; }
.track-item-price { margin-left: auto; font-size: 14px; font-weight: 700; color: #FF8C42; }

.track-actions { display: flex; gap: 12px; justify-content: center; margin-top: 24px; }
.track-btn { padding: 12px 28px; border-radius: 8px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all .2s; }
.track-btn-primary { background: #FF8C42; color: #fff; }
.track-btn-primary:hover { opacity: .88; }
.track-btn-secondary { background: #f0f0f0; color: #555; }
.track-btn-secondary:hover { background: #e0e0e0; }

@media (max-width: 768px) {
    .track-page { padding: 16px 12px 100px; }
    .track-header h1 { font-size: 22px; }
    .track-card { padding: 18px; }
    #trackingMap { height: 280px; }
    .eta-value { font-size: 16px; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="track-page">
    <div class="track-header">
        <h1>📦 Order Tracking</h1>
        <p>Monitor your order status in real time</p>
        <div class="track-id-badge">Order <?php echo e($order->order_id); ?></div>
    </div>

    
    <div class="notif-banner" id="notifBanner">🚚 Your order is on the way! The courier has picked up your package.</div>

    
    <div class="track-card">
        <h3>🗺️ Live Delivery Map</h3>
        <div id="trackingMap"></div>
        <div class="map-eta-bar">
            <div class="eta-item">
                <div class="eta-label">Distance</div>
                <div class="eta-value" id="etaDistance">—</div>
                <div class="eta-sub">km remaining</div>
            </div>
            <div class="eta-item">
                <div class="eta-label">ETA</div>
                <div class="eta-value live" id="etaTime">—</div>
                <div class="eta-sub" id="etaArrival">Calculating...</div>
            </div>
            <div class="eta-item">
                <div class="eta-label">Progress</div>
                <div class="eta-value" id="etaProgress">0%</div>
                <div class="eta-sub" id="etaStatus">
                    <?php if($order->order_status === 'shipped'): ?> In Transit
                    <?php elseif($order->order_status === 'delivered'): ?> Delivered
                    <?php else: ?> Waiting
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <div class="track-card">
        <h3>Delivery Status</h3>
        <?php
            $statuses = ['pending' => 'Order Placed', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered'];
            $statusDescs = [
                'pending' => 'Your order has been placed and is awaiting confirmation.',
                'processing' => 'Your order is being prepared for shipment.',
                'shipped' => 'Your order is on its way!',
                'delivered' => 'Your order has been delivered. Enjoy!'
            ];
            $currentFound = false;
            $orderStatus = $order->order_status;
        ?>
        <div class="track-timeline">
            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $isDone = false;
                    $isCurrent = false;
                    if (!$currentFound) {
                        if ($key === $orderStatus) {
                            $isCurrent = true;
                            $currentFound = true;
                        } else {
                            $isDone = true;
                        }
                    }
                ?>
                <div class="track-step <?php echo e($isDone ? 'done' : ''); ?> <?php echo e($isCurrent ? 'current' : ''); ?>">
                    <div class="track-dot"><?php echo e($isDone ? '✓' : ($isCurrent ? '●' : '')); ?></div>
                    <div class="track-step-title"><?php echo e($label); ?></div>
                    <div class="track-step-desc"><?php echo e($statusDescs[$key]); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="track-card">
        <h3>Order Details</h3>
        <div class="track-detail-row">
            <span class="track-detail-label">Order Date</span>
            <span class="track-detail-value"><?php echo e($order->created_at->format('M j, Y g:i A')); ?></span>
        </div>
        <div class="track-detail-row">
            <span class="track-detail-label">Status</span>
            <span class="track-detail-value status status-<?php echo e($order->order_status); ?>"><?php echo e(ucfirst($order->order_status)); ?></span>
        </div>
        <div class="track-detail-row">
            <span class="track-detail-label">Payment</span>
            <span class="track-detail-value"><?php echo e($order->payment_method === 'cod' ? 'Cash on Delivery' : 'GCash'); ?></span>
        </div>
        <div class="track-detail-row">
            <span class="track-detail-label">Shipping</span>
            <span class="track-detail-value"><?php echo e(ucfirst($order->shipping_method ?? 'Standard')); ?> Delivery</span>
        </div>
        <?php if($order->tracking_number): ?>
        <div class="track-detail-row">
            <span class="track-detail-label">Tracking #</span>
            <span class="track-detail-value"><?php echo e($order->tracking_number); ?></span>
        </div>
        <?php endif; ?>
        <?php if($order->shippingAddress): ?>
        <div class="track-detail-row">
            <span class="track-detail-label">Deliver to</span>
            <span class="track-detail-value"><?php echo e($order->shippingAddress->recipient_name); ?>, <?php echo e($order->shippingAddress->street_address); ?>, <?php echo e($order->shippingAddress->city_municipality); ?></span>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="track-card">
        <h3>Items Ordered</h3>
        <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="track-item">
            <?php if($oi->product): ?>
            <img class="track-item-img" src="<?php echo e($oi->product->image_url); ?>" alt="" onerror="this.style.display='none'">
            <?php endif; ?>
            <div>
                <div class="track-item-name"><?php echo e($oi->product->product_name ?? 'Product #'.$oi->product_id); ?></div>
                <div class="track-item-meta">Qty: <?php echo e($oi->quantity); ?> · ₱<?php echo e(number_format($oi->unit_price, 2)); ?></div>
            </div>
            <div class="track-item-price">₱<?php echo e(number_format($oi->total_amount, 2)); ?></div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <hr style="border:0; border-top:1px solid #f0f0f0; margin:14px 0;">
        <div class="track-detail-row"><span class="track-detail-label">Subtotal</span><span class="track-detail-value">₱<?php echo e(number_format($order->order_amount, 2)); ?></span></div>
        <div class="track-detail-row"><span class="track-detail-label">Shipping</span><span class="track-detail-value"><?php echo e($order->shipping_fee > 0 ? '₱'.number_format($order->shipping_fee, 2) : 'FREE'); ?></span></div>
        <?php if($order->discount_amount > 0): ?>
        <div class="track-detail-row"><span class="track-detail-label" style="color:#3DB868;">Discount</span><span class="track-detail-value" style="color:#3DB868;">-₱<?php echo e(number_format($order->discount_amount, 2)); ?></span></div>
        <?php endif; ?>
        <div class="track-detail-row" style="font-size:16px;font-weight:800;border-top:2px solid #eee;padding-top:12px;margin-top:4px;">
            <span>Total</span><span style="color:#FF8C42;">₱<?php echo e(number_format($order->total_amount, 2)); ?></span>
        </div>
    </div>

    <div class="track-actions">
        <a href="<?php echo e(route('orders')); ?>" class="track-btn track-btn-secondary">← My Orders</a>
        <a href="<?php echo e(route('shop.all')); ?>" class="track-btn track-btn-primary">Continue Shopping</a>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function() {
    // ═══ CONFIG ═══
    const ORDER_STATUS = '<?php echo e($order->order_status); ?>';

    // Origin: Petverse store — Libertad, Butuan City
    const ORIGIN = { lat: 8.9475, lng: 125.5406, label: 'Petverse Store (Butuan, Libertad)' };

    // Destination: buyer's address (approximate using city name for demo)
    <?php
        $destCity = $order->shippingAddress->city_municipality ?? 'Manila';
        // Known PH city coords for demo geocoding
        $cityCoords = [
            'manila' => [14.5995, 120.9842],
            'quezon city' => [14.6760, 121.0437],
            'cebu' => [10.3157, 123.8854],
            'davao' => [7.1907, 125.4553],
            'butuan' => [8.9475, 125.5406],
            'cagayan de oro' => [8.4542, 124.6319],
            'zamboanga' => [6.9214, 122.0790],
            'iloilo' => [10.7202, 122.5621],
            'makati' => [14.5547, 121.0244],
            'taguig' => [14.5176, 121.0509],
            'pasig' => [14.5764, 121.0851],
            'caloocan' => [14.6488, 120.9842],
            'surigao' => [9.7572, 125.5138],
            'bacolod' => [10.6840, 122.9563],
            'general santos' => [6.1164, 125.1716],
        ];
        $cityLower = strtolower(trim($destCity));
        $destLat = $cityCoords[$cityLower][0] ?? 14.5995;
        $destLng = $cityCoords[$cityLower][1] ?? 120.9842;
        $destLabel = $order->shippingAddress->recipient_name ?? 'Buyer';
    ?>
    const DEST = { lat: <?php echo e($destLat); ?>, lng: <?php echo e($destLng); ?>, label: '<?php echo e(addslashes($destLabel)); ?>' };

    // ═══ MAP SETUP ═══
    const map = L.map('trackingMap').fitBounds([[ORIGIN.lat, ORIGIN.lng], [DEST.lat, DEST.lng]], { padding: [40, 40] });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 18
    }).addTo(map);

    // Custom icons
    const storeIcon = L.divIcon({ html: '<div style="font-size:28px;">🏪</div>', iconSize: [32, 32], iconAnchor: [16, 16], className: '' });
    const destIcon = L.divIcon({ html: '<div style="font-size:28px;">📍</div>', iconSize: [32, 32], iconAnchor: [16, 32], className: '' });
    const truckIcon = L.divIcon({ html: '<div style="font-size:26px;filter:drop-shadow(0 2px 4px rgba(0,0,0,.3));">🚚</div>', iconSize: [30, 30], iconAnchor: [15, 15], className: '' });

    // Markers
    L.marker([ORIGIN.lat, ORIGIN.lng], { icon: storeIcon }).addTo(map).bindPopup('<b>' + ORIGIN.label + '</b><br>Origin');
    L.marker([DEST.lat, DEST.lng], { icon: destIcon }).addTo(map).bindPopup('<b>' + DEST.label + '</b><br>Destination');

    // Route line (generate a realistic curved path between origin and destination)
    const routePoints = generateRoute(ORIGIN, DEST, 60);
    // Full route in light gray
    L.polyline(routePoints, { color: '#ccc', weight: 4, opacity: 0.5 }).addTo(map);
    // Red trail showing traveled path
    const trailLine = L.polyline([], { color: '#e53935', weight: 5, opacity: 0.85 }).addTo(map);

    // Distance calc (Haversine)
    function haversine(p1, p2) {
        const R = 6371;
        const dLat = (p2[0] - p1[0]) * Math.PI / 180;
        const dLng = (p2[1] - p1[1]) * Math.PI / 180;
        const a = Math.sin(dLat/2)**2 + Math.cos(p1[0]*Math.PI/180) * Math.cos(p2[0]*Math.PI/180) * Math.sin(dLng/2)**2;
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    }

    const totalDistance = haversine([ORIGIN.lat, ORIGIN.lng], [DEST.lat, DEST.lng]);

    // Generate route with slight curve
    function generateRoute(origin, dest, numPoints) {
        const pts = [];
        for (let i = 0; i <= numPoints; i++) {
            const t = i / numPoints;
            const lat = origin.lat + (dest.lat - origin.lat) * t;
            const lng = origin.lng + (dest.lng - origin.lng) * t;
            // add slight curve for realism
            const offset = Math.sin(t * Math.PI) * (totalDistance * 0.008);
            pts.push([lat + offset * 0.1, lng + offset * 0.05]);
        }
        return pts;
    }

    // ═══ SIMULATION ═══
    let truckMarker = null;
    let progress = 0;
    const isShipped = ORDER_STATUS === 'shipped';
    const isDelivered = ORDER_STATUS === 'delivered';

    if (isShipped || isDelivered) {
        // Set initial progress based on order age (simulate real progression)
        if (isDelivered) {
            progress = 1;
        } else {
            // Simulate: order progresses over ~2 hours since shipped
            const orderAge = (Date.now() - new Date('<?php echo e($order->updated_at->toISOString()); ?>').getTime()) / 1000;
            const totalSimTime = 7200; // 2 hours
            progress = Math.min(orderAge / totalSimTime, 0.95);
        }

        const idx = Math.floor(progress * (routePoints.length - 1));
        truckMarker = L.marker(routePoints[idx], { icon: truckIcon, zIndexOffset: 1000 }).addTo(map);
        truckMarker.bindPopup('🚚 Your delivery is here!');

        // Draw initial red trail up to current position
        trailLine.setLatLngs(routePoints.slice(0, idx + 1));

        // Push notification
        if (isShipped) {
            requestNotification();
            showBanner();
        }

        // Animate truck along route
        if (isShipped) {
            animateTruck();
        }
    } else {
        // Order not yet shipped — show full red route and static ETA
        trailLine.setLatLngs(routePoints);
        document.getElementById('etaDistance').textContent = totalDistance.toFixed(1);
        document.getElementById('etaTime').textContent = 'Pending';
        document.getElementById('etaTime').classList.remove('live');
        document.getElementById('etaArrival').textContent = 'Order not yet shipped';
        document.getElementById('etaProgress').textContent = '—';
    }

    // Animate the truck along the route
    function animateTruck() {
        const startIdx = Math.floor(progress * (routePoints.length - 1));
        let currentIdx = startIdx;

        setInterval(() => {
            if (currentIdx >= routePoints.length - 1) return;
            currentIdx++;
            progress = currentIdx / (routePoints.length - 1);

            truckMarker.setLatLng(routePoints[currentIdx]);

            // Extend red trail
            trailLine.setLatLngs(routePoints.slice(0, currentIdx + 1));

            // Update ETA bar
            const remaining = totalDistance * (1 - progress);
            const speed = 40; // avg 40 km/h
            const etaHours = remaining / speed;
            const etaMins = Math.round(etaHours * 60);

            document.getElementById('etaDistance').textContent = remaining.toFixed(1);
            document.getElementById('etaProgress').textContent = Math.round(progress * 100) + '%';

            if (etaMins > 60) {
                const h = Math.floor(etaMins / 60);
                const m = etaMins % 60;
                document.getElementById('etaTime').textContent = h + 'h ' + m + 'm';
            } else {
                document.getElementById('etaTime').textContent = etaMins + ' min';
            }

            const arrival = new Date(Date.now() + etaMins * 60000);
            document.getElementById('etaArrival').textContent = 'Arrives ~' + arrival.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            // When arrived
            if (currentIdx >= routePoints.length - 1) {
                document.getElementById('etaTime').textContent = 'Arrived!';
                document.getElementById('etaTime').classList.remove('live');
                document.getElementById('etaArrival').textContent = 'Package delivered';
                document.getElementById('etaStatus').textContent = 'Delivered';
                document.getElementById('etaProgress').textContent = '100%';
            }
        }, 3000); // move every 3 seconds for demo
    }

    // Update ETA display immediately
    if (isShipped || isDelivered) {
        const remaining = totalDistance * (1 - progress);
        const speed = 40;
        const etaMins = Math.round((remaining / speed) * 60);
        document.getElementById('etaDistance').textContent = remaining.toFixed(1);
        document.getElementById('etaProgress').textContent = Math.round(progress * 100) + '%';

        if (isDelivered) {
            document.getElementById('etaTime').textContent = 'Arrived!';
            document.getElementById('etaTime').classList.remove('live');
            document.getElementById('etaArrival').textContent = 'Package delivered';
            document.getElementById('etaStatus').textContent = 'Delivered';
            document.getElementById('etaProgress').textContent = '100%';
        } else if (etaMins > 60) {
            const h = Math.floor(etaMins / 60);
            const m = etaMins % 60;
            document.getElementById('etaTime').textContent = h + 'h ' + m + 'm';
            const arrival = new Date(Date.now() + etaMins * 60000);
            document.getElementById('etaArrival').textContent = 'Arrives ~' + arrival.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        } else {
            document.getElementById('etaTime').textContent = etaMins + ' min';
            const arrival = new Date(Date.now() + etaMins * 60000);
            document.getElementById('etaArrival').textContent = 'Arrives ~' + arrival.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }
    }

    // ═══ PUSH NOTIFICATION ═══
    function requestNotification() {
        if (!('Notification' in window)) return;
        if (Notification.permission === 'granted') {
            sendNotification();
        } else if (Notification.permission !== 'denied') {
            Notification.requestPermission().then(p => {
                if (p === 'granted') sendNotification();
            });
        }
    }

    function sendNotification() {
        new Notification('🚚 Pet Animixon — Order On The Way!', {
            body: 'Your order <?php echo e($order->order_id); ?> has been shipped and is heading your way. Track it live on the tracking page!',
            icon: 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text y=".9em" font-size="90">🐾</text></svg>',
            tag: 'order-shipped-<?php echo e($order->order_id); ?>',
            requireInteraction: false
        });
    }

    function showBanner() {
        const banner = document.getElementById('notifBanner');
        banner.classList.add('show');
        setTimeout(() => banner.classList.remove('show'), 8000);
    }
})();
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\petverse\resources\views/frontend/order_tracking.blade.php ENDPATH**/ ?>