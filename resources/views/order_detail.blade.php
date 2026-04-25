<!-- ===== ORDER DETAIL PAGE ===== -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order {{ $order->display_id }} - Pet Markt-PH Admin</title>
    <!-- Core Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}">
    <style>
        .order-detail-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            padding: 24px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .od-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 24px;
            margin-bottom: 24px;
        }

        .od-card-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .od-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .od-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .od-value {
            font-size: 14px;
            color: #111827;
        }

        /* Timeline Styles */
        .timeline {
            position: relative;
            padding-left: 20px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 5px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e5e7eb;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 24px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-marker {
            position: absolute;
            left: -20px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #f97316;
            border: 2px solid #fff;
            box-shadow: 0 0 0 1px #e5e7eb;
            top: 4px;
        }

        .timeline-item-active .timeline-marker {
            background: #22c55e;
            box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
        }

        .timeline-content {
            background: #f9fafb;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .timeline-title {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        .timeline-date {
            font-size: 12px;
            color: #6b7280;
            margin-top: 2px;
        }

        .timeline-note {
            font-size: 13px;
            color: #4b5563;
            margin-top: 6px;
            background: #fff;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
        }

        /* Action Forms */
        .action-form {
            background: #fff7ed;
            border: 1px solid #fdba74;
            padding: 16px;
            border-radius: 8px;
            margin-top: 16px;
        }

        .form-select, .form-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            margin-top: 8px;
            margin-bottom: 12px;
        }

        .btn-primary {
            background: var(--ud-orange-dark);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            width: 100%;
        }

        .btn-primary:hover {
            background: #c2410c;
        }

        .btn-secondary {
            background: #fff;
            color: #374151;
            border: 1px solid #d1d5db;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            width: 100%;
            margin-top: 8px;
        }

        .badge-local { background: #fef3c7; color: #d97706; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .badge-courier { background: #fce7f3; color: #be185d; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        
        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
        }
        .items-table th {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
        }
        .items-table td {
            padding: 12px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }
        .item-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .item-img {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            object-fit: cover;
        }

        /* Fulfillment Panel */
        .fulfillment-panel {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: linear-gradient(180deg, #ffffff 0%, #fcfcfd 100%);
            overflow: hidden;
        }

        .fulfillment-head {
            padding: 18px 18px 16px;
            border-bottom: 1px solid #eef2f7;
            background: linear-gradient(180deg, #fff7ed 0%, #ffffff 100%);
        }

        .fulfillment-kicker {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #9a3412;
            margin-bottom: 6px;
        }

        .fulfillment-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 8px;
        }

        .fulfillment-title {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
        }

        .fulfillment-subtitle {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.5;
        }

        .fulfillment-mode-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .fulfillment-mode-badge.local {
            background: #ffedd5;
            color: #c2410c;
            border: 1px solid #fdba74;
        }

        .fulfillment-mode-badge.courier {
            background: #fce7f3;
            color: #be185d;
            border: 1px solid #f9a8d4;
        }

        .fulfillment-body {
            padding: 18px;
        }

        .fulfillment-summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 16px;
        }

        .fulfillment-summary-card {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 14px;
        }

        .fulfillment-summary-label {
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 6px;
        }

        .fulfillment-summary-value {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
            line-height: 1.4;
        }

        .fulfillment-summary-helper {
            font-size: 12px;
            color: #6b7280;
            margin-top: 4px;
            line-height: 1.45;
        }

        .fulfillment-steps {
            display: grid;
            gap: 10px;
            margin-bottom: 16px;
        }

        .fulfillment-step {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
        }

        .fulfillment-step.completed {
            border-color: #bbf7d0;
            background: #f0fdf4;
        }

        .fulfillment-step.current {
            border-color: #fdba74;
            background: #fff7ed;
            box-shadow: inset 0 0 0 1px rgba(249, 115, 22, 0.08);
        }

        .fulfillment-step.upcoming {
            background: #f9fafb;
        }

        .fulfillment-step-index {
            width: 28px;
            height: 28px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
            flex-shrink: 0;
            background: #e5e7eb;
            color: #374151;
        }

        .fulfillment-step.completed .fulfillment-step-index {
            background: #16a34a;
            color: #fff;
        }

        .fulfillment-step.current .fulfillment-step-index {
            background: #f97316;
            color: #fff;
        }

        .fulfillment-step-content {
            min-width: 0;
        }

        .fulfillment-step-title {
            font-size: 13px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 2px;
        }

        .fulfillment-step-note {
            font-size: 12px;
            color: #6b7280;
            line-height: 1.45;
        }

        .fulfillment-action-box {
            border: 1px solid #fed7aa;
            background: #fff7ed;
            border-radius: 12px;
            padding: 16px;
        }

        .fulfillment-action-title {
            font-size: 13px;
            font-weight: 800;
            color: #9a3412;
            margin-bottom: 4px;
        }

        .fulfillment-action-copy {
            font-size: 12px;
            color: #7c2d12;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .fulfillment-empty {
            border: 1px dashed #d1d5db;
            border-radius: 12px;
            padding: 14px;
            text-align: center;
            background: #f9fafb;
            font-size: 13px;
            color: #6b7280;
        }

        .tracking-code {
            font-family: Consolas, Monaco, monospace;
            font-size: 14px;
            word-break: break-word;
        }
    </style>
</head>
<body class="dashboard-body">

    <!-- Header -->
    @include('partials.admin_header')

    <div class="dashboard-layout" style="display:block;">
        
        <div class="content-header" style="max-width: 1200px; margin: 0 auto; padding: 0 24px; margin-top:24px;">
            <div style="margin-bottom: 16px;">
                <a href="{{ route('admin.orders') }}" style="text-decoration: none; color: #374151; display:inline-flex; align-items:center; gap:8px;">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                    Back to Orders
                </a>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <h1 class="page-title">Order {{ $order->display_id }}</h1>
                <span class="badge {{ $order->isLocal() ? 'badge-local' : 'badge-courier' }}">
                    {{ $order->isLocal() ? '🛵 Local Delivery' : '📦 Courier (J&T)' }}
                </span>
                <span class="badge" style="background:#e0e7ff; color:#4f46e5;">{{ $order->status_label }}</span>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success" style="padding:12px; background:#dcfce7; color:#166534; border-radius:6px; margin-bottom:16px;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" style="padding:12px; background:#fee2e2; color:#991b1b; border-radius:6px; margin-bottom:16px;">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <div class="order-detail-layout">
            
            <!-- LEFT COLUMN: Order Details -->
            <div class="od-left">
                
                <!-- Customer Details -->
                <div class="od-card">
                    <div class="od-card-title">Customer & Delivery</div>
                    <div class="od-grid">
                        <div>
                            <div class="od-label">Customer Name</div>
                            <div class="od-value">{{ optional($order->user)->full_name ?? '—' }}</div>
                        </div>
                        <div>
                            <div class="od-label">Email / Phone</div>
                            <div class="od-value">{{ optional($order->user)->email ?? '—' }}<br>{{ optional($order->shippingAddress)->phone_number ?? '—' }}</div>
                        </div>
                        <div style="grid-column: span 2;">
                            <div class="od-label">Shipping Address</div>
                            <div class="od-value">
                                @if($order->shippingAddress)
                                    {{ $order->shippingAddress->recipient_name }}<br>
                                    {{ $order->shippingAddress->street_address }}, {{ $order->shippingAddress->barangay ? $order->shippingAddress->barangay . ', ' : '' }}
                                    {{ $order->shippingAddress->city_municipality }}, {{ $order->shippingAddress->province }} {{ $order->shippingAddress->zip_code }}
                                @else
                                    —
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="od-card">
                    <div class="od-card-title">Order Items</div>
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th style="text-align: right;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="item-row">
                                        <img src="{{ optional($item->product)->image_url }}" class="item-img" alt="">
                                        <div>
                                            {{ optional($item->product)->product_name }}
                                        </div>
                                    </div>
                                </td>
                                <td>₱{{ number_format((float)$item->unit_price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td style="text-align: right; font-weight: 500;">₱{{ number_format((float)$item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div style="margin-top: 24px; border-top: 1px solid #e5e7eb; padding-top: 16px; text-align: right;">
                        <div class="od-label">Subtotal: <span class="od-value">₱{{ number_format((float)$order->order_amount, 2) }}</span></div>
                        <div class="od-label">Shipping: <span class="od-value">₱{{ number_format((float)$order->shipping_fee, 2) }}</span></div>
                        @if($order->discount_amount > 0)
                        <div class="od-label" style="color: #10b981;">Discount: <span class="od-value" style="color: #10b981;">-₱{{ number_format((float)$order->discount_amount, 2) }}</span></div>
                        @endif
                        <div class="od-label" style="font-size: 16px; margin-top: 8px; color:#111827;">Total: <span class="od-value" style="font-size: 20px; font-weight: 700;">₱{{ number_format((float)$order->total_amount, 2) }}</span></div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: Timeline and Actions -->
            <div class="od-right">
                
                <!-- Assignment / Tracking Card -->
                <div class="od-card">
                    @php
                        $nextStatus = $order->getNextStatus();
                        $flow = $order->getStatusFlow();
                        $currentStepIndex = array_search($order->order_status, $flow);
                        $currentStepIndex = $currentStepIndex === false ? 0 : $currentStepIndex;
                    @endphp

                    <div class="fulfillment-panel">
                        <div class="fulfillment-head">
                            <div class="fulfillment-kicker">Admin Control</div>
                            <div class="fulfillment-title-row">
                                <div class="fulfillment-title">Fulfillment Control</div>
                                <span class="fulfillment-mode-badge {{ $order->isLocal() ? 'local' : 'courier' }}">
                                    {{ $order->isLocal() ? 'Local Delivery' : 'Courier Shipment' }}
                                </span>
                            </div>
                            <div class="fulfillment-subtitle">
                                Manage dispatch, shipment progression, and strict next-step actions for this order.
                            </div>
                        </div>

                        <div class="fulfillment-body">
                            <div class="fulfillment-summary-grid">
                                <div class="fulfillment-summary-card">
                                    <div class="fulfillment-summary-label">Current Status</div>
                                    <div class="fulfillment-summary-value">{{ $order->status_label }}</div>
                                    <div class="fulfillment-summary-helper">
                                        This order is currently parked at the active fulfillment checkpoint.
                                    </div>
                                </div>

                                <div class="fulfillment-summary-card">
                                    <div class="fulfillment-summary-label">Next Required Step</div>
                                    <div class="fulfillment-summary-value">
                                        {{ $nextStatus ? (App\Models\Order::STATUS_LABELS[$nextStatus] ?? ucfirst(str_replace('_', ' ', $nextStatus))) : 'Fulfillment Completed' }}
                                    </div>
                                    <div class="fulfillment-summary-helper">
                                        {{ $nextStatus ? 'Only the next valid action should be performed.' : 'No further admin action is required for fulfillment.' }}
                                    </div>
                                </div>

                                <div class="fulfillment-summary-card">
                                    <div class="fulfillment-summary-label">{{ $order->isLocal() ? 'Assigned Rider' : 'Tracking Number' }}</div>
                                    <div class="fulfillment-summary-value {{ $order->isCourier() ? 'tracking-code' : '' }}">
                                        @if($order->isLocal())
                                            {{ optional($order->rider)->full_name ?? 'Not Assigned Yet' }}
                                        @else
                                            {{ $order->tracking_number ?? 'Not Generated Yet' }}
                                        @endif
                                    </div>
                                    <div class="fulfillment-summary-helper">
                                        @if($order->isLocal())
                                            {{ $order->rider_id ? 'Dispatch owner already assigned to this delivery.' : 'Assignment is required before dispatch can proceed.' }}
                                        @else
                                            {{ $order->tracking_number ? 'Tracking is already attached to this courier shipment.' : 'Courier tracking must be saved before transit can proceed.' }}
                                        @endif
                                    </div>
                                </div>

                                <div class="fulfillment-summary-card">
                                    <div class="fulfillment-summary-label">Fulfillment Route</div>
                                    <div class="fulfillment-summary-value">
                                        {{ $order->isLocal() ? 'Store → Rider → Customer' : 'Store → Courier Hub → Customer' }}
                                    </div>
                                    <div class="fulfillment-summary-helper">
                                        {{ count($flow) }} strict status checkpoints are defined for this shipping method.
                                    </div>
                                </div>
                            </div>

                            <div class="fulfillment-steps">
                                @foreach($flow as $index => $status)
                                    @php
                                        $stepClass = 'upcoming';
                                        if ($index < $currentStepIndex) {
                                            $stepClass = 'completed';
                                        } elseif ($index === $currentStepIndex) {
                                            $stepClass = 'current';
                                        }
                                    @endphp
                                    <div class="fulfillment-step {{ $stepClass }}">
                                        <div class="fulfillment-step-index">{{ $index + 1 }}</div>
                                        <div class="fulfillment-step-content">
                                            <div class="fulfillment-step-title">{{ App\Models\Order::STATUS_LABELS[$status] ?? ucfirst(str_replace('_', ' ', $status)) }}</div>
                                            <div class="fulfillment-step-note">
                                                @if($index < $currentStepIndex)
                                                    Completed checkpoint.
                                                @elseif($index === $currentStepIndex)
                                                    Current active checkpoint for admin fulfillment handling.
                                                @else
                                                    Upcoming checkpoint in the strict order flow.
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($nextStatus)
                                <div class="fulfillment-action-box">
                                    @if($order->isLocal() && $nextStatus === App\Models\Order::STATUS_ASSIGNED_TO_RIDER && !$order->rider_id)
                                        <div class="fulfillment-action-title">Dispatch Rider Assignment Required</div>
                                        <div class="fulfillment-action-copy">
                                            Select one active rider to move this local delivery into dispatch. This is the only valid next fulfillment action.
                                        </div>
                                        <form action="{{ route('admin.orders.rider', $order->id) }}" method="POST" class="action-form" style="margin-top:0;">
                                            @csrf
                                            <div class="od-label" style="color:#c2410c;">Available Riders ({{ count($activeRiders) }})</div>
                                            <select name="rider_id" class="form-select" required>
                                                <option value="">Select a Rider...</option>
                                                @foreach($activeRiders as $r)
                                                    <option value="{{ $r->id }}">{{ $r->full_name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn-primary">Assign Rider & Update Status</button>
                                        </form>

                                    @elseif($order->isCourier() && $nextStatus === App\Models\Order::STATUS_IN_TRANSIT && !$order->tracking_number)
                                        <div class="fulfillment-action-title">Courier Tracking Required</div>
                                        <div class="fulfillment-action-copy">
                                            Save the official courier tracking reference before advancing this shipment into transit.
                                        </div>
                                        <form action="{{ route('admin.orders.tracking', $order->id) }}" method="POST" class="action-form" style="margin-top:0;">
                                            @csrf
                                            <div class="od-label" style="color:#c2410c;">Tracking Number</div>
                                            <input type="text" name="tracking_number" class="form-input" placeholder="e.g. JT123456789PH" required>
                                            <button type="submit" class="btn-primary">Save Tracking & Advance Status</button>
                                        </form>

                                    @else
                                        <div class="fulfillment-action-title">Advance Fulfillment</div>
                                        <div class="fulfillment-action-copy">
                                            Move this order to the next approved checkpoint in the fulfillment route. Review the current state before continuing.
                                        </div>
                                        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn-primary" style="width: 100%;">
                                                Advance to: {{ App\Models\Order::STATUS_LABELS[$nextStatus] }} →
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <div class="fulfillment-empty">
                                    Fulfillment is complete. This order has no remaining admin fulfillment actions.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Timeline Card -->
                <div class="od-card">
                    <div class="od-card-title">Status Timeline</div>
                    
                    <div class="timeline">
                        @forelse($order->statusHistory as $history)
                        <div class="timeline-item {{ $loop->last ? 'timeline-item-active' : '' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <div class="timeline-title">{{ $history->status_label }}</div>
                                <div class="timeline-date">{{ $history->created_at->format('M j, Y g:i A') }}</div>
                                @if($history->note)
                                    <div class="timeline-note">{{ $history->note }}</div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="timeline-item timeline-item-active">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <div class="timeline-title">{{ $order->status_label }}</div>
                                <div class="timeline-date">{{ $order->created_at->format('M j, Y g:i A') }}</div>
                            </div>
                        </div>
                        @endforelse
                    </div>

                </div>

            </div>

        </div>

    </div>

</body>
</html>
