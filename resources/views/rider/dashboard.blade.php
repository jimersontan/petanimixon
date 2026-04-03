<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider Dashboard - Pet Animixon</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/rider.css') }}">
</head>
<body class="rider-body">

    @if(session('success'))
        <div class="rider-toast">{{ session('success') }}</div>
    @endif

    <!-- ===== HEADER ===== -->
    <header class="rider-header">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <span>Pet <span style="color: #059669;">Animixon</span></span>
            <span class="rider-badge">🛵 Rider</span>
        </div>
        <div class="header-right">
            <span class="rider-name">{{ Auth::user()->full_name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="icon-btn" aria-label="Logout" title="Logout">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                </button>
            </form>
        </div>
    </header>

    <div class="rider-layout">
        <!-- ===== SIDEBAR ===== -->
        <aside class="rider-sidebar">
            <div class="nav-section-title">Navigation</div>
            <nav>
                <a href="{{ route('rider.dashboard') }}" class="nav-item active" data-page="dashboard">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg></span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('rider.available') }}" class="nav-item" data-page="available">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-3 10h-3v3h-2v-3H8v-2h3V8h2v3h3v2z"/></svg></span>
                    <span>Available Orders</span>
                </a>
                <a href="{{ route('rider.active') }}" class="nav-item" data-page="active">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg></span>
                    <span>Active Delivery</span>
                </a>
                <a href="{{ route('rider.history') }}" class="nav-item" data-page="history">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/></svg></span>
                    <span>History</span>
                </a>
                <a href="{{ route('rider.products') }}" class="nav-item" data-page="products">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M5 8h2V6h10v2h2V6c0-1.1-.9-2-2-2H7V2H5v4c-1.1 0-2 .9-2 2v2zm-2 4v8c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-8H3zm2 2h2v6H5v-6zm4 0h2v6H9v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6z"/></svg></span>
                    <span>Products</span>
                </a>
            </nav>
            <div class="logout-link">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-item" style="width:100%; border:none; background:none; cursor:pointer; text-align:left;">
                        <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg></span>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- ===== MAIN CONTENT ===== -->
        <main class="rider-main">
            <div class="rider-page-header">
                <div>
                    <h1>Dashboard</h1>
                    <div class="subtitle">Welcome back, {{ Auth::user()->first_name }}! 🛵</div>
                </div>
                <div style="font-size:0.82rem; color: var(--rider-text-muted);">
                    {{ now()->format('l, M j, Y') }}
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="rider-stats-grid">
                <div class="rider-stat-card">
                    <div class="rider-stat-icon green">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg>
                    </div>
                    <div>
                        <div class="rider-stat-value">{{ $todayDeliveries }}</div>
                        <div class="rider-stat-label">Today's Deliveries</div>
                    </div>
                </div>
                <div class="rider-stat-card">
                    <div class="rider-stat-icon blue">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <div>
                        <div class="rider-stat-value">{{ $completedToday }}</div>
                        <div class="rider-stat-label">Completed Today</div>
                    </div>
                </div>
                <div class="rider-stat-card">
                    <div class="rider-stat-icon orange">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-3 10h-3v3h-2v-3H8v-2h3V8h2v3h3v2z"/></svg>
                    </div>
                    <div>
                        <div class="rider-stat-value">{{ $availableOrders->count() }}</div>
                        <div class="rider-stat-label">Available Orders</div>
                    </div>
                </div>
                <div class="rider-stat-card">
                    <div class="rider-stat-icon purple">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <div>
                        <div class="rider-stat-value">{{ $totalDeliveries }}</div>
                        <div class="rider-stat-label">Total Deliveries</div>
                    </div>
                </div>
            </div>

            <!-- Active Delivery Banner -->
            @if($activeDelivery)
            <div class="active-delivery-banner">
                <div class="banner-title">🚀 Active Delivery — {{ $activeDelivery->display_id }}</div>
                <div class="banner-details">
                    <div class="detail-item">
                        <div class="detail-label">Customer</div>
                        <div>{{ optional($activeDelivery->user)->full_name ?? 'N/A' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Total</div>
                        <div>{{ $activeDelivery->formatted_total }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Address</div>
                        <div>{{ optional($activeDelivery->shippingAddress)->address ?? 'N/A' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Items</div>
                        <div>{{ $activeDelivery->orderItems->count() }} item(s)</div>
                    </div>
                </div>
                <div class="banner-actions">
                    <a href="{{ route('rider.active') }}" class="btn-rider-white">View Details →</a>
                    @if(!$activeDelivery->rider_picked_up_at)
                        <form action="{{ route('rider.pickup', $activeDelivery->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-rider-white">📦 Mark Picked Up</button>
                        </form>
                    @endif
                </div>
            </div>
            @endif

            <!-- Available Orders Queue -->
            <div class="rider-card">
                <div class="rider-card-header">
                    <h2>📋 Available Orders</h2>
                    <a href="{{ route('rider.available') }}" class="btn-rider-secondary btn-rider-sm">View All</a>
                </div>
                <div class="rider-card-body" style="padding: 12px 22px;">
                    @if($availableOrders->count() > 0)
                        <div class="order-queue">
                            @foreach($availableOrders as $order)
                            <div class="order-queue-item">
                                <div class="order-queue-info">
                                    <div class="order-queue-id">{{ $order->display_id }}</div>
                                    <div class="order-queue-customer">{{ optional($order->user)->full_name ?? 'Customer' }}</div>
                                    <div class="order-queue-meta">
                                        <span>📦 {{ $order->orderItems->count() ?? '—' }} items</span>
                                        <span>📍 {{ optional($order->shippingAddress)->city_municipality ?? 'N/A' }}</span>
                                        <span>🕐 {{ $order->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <div class="order-queue-actions">
                                    <div class="order-queue-total">{{ $order->formatted_total }}</div>
                                    @if(!$activeDelivery)
                                    <form action="{{ route('rider.accept', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-rider-primary btn-rider-sm">Accept</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="rider-empty-state">
                            <div class="empty-icon">📭</div>
                            <h3>No Orders Available</h3>
                            <p>New orders will appear here when they're ready for delivery.</p>
                        </div>
                    @endif
                </div>
            </div>

        </main>
    </div>
</body>
</html>
