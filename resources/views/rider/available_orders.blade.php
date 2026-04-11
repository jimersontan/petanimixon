<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Orders - PetMarkt-PH Rider</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/rider.css') }}">
</head>
<body class="rider-body">

    @if(session('success'))
        <div class="rider-toast">{{ session('success') }}</div>
    @endif

    <header class="rider-header">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <span>Pet <span style="color: #059669;">Markt-PH</span></span>
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
        <aside class="rider-sidebar">
            <div class="nav-section-title">Navigation</div>
            <nav>
                <a href="{{ route('rider.dashboard') }}" class="nav-item" data-page="dashboard">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg></span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('rider.available') }}" class="nav-item active" data-page="available">
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
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M5 8h2V6h10v2h2V6c0-1.1-.9-2-2-2H7V2H5v4c-1.1 0-2 .9-2 2v2zm-2 4v8c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-8H3z"/></svg></span>
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

        <main class="rider-main">
            <div class="rider-page-header">
                <div>
                    <h1>Available Orders</h1>
                    <div class="subtitle">Orders ready for delivery pickup</div>
                </div>
            </div>

            <div class="rider-card">
                <div class="rider-card-header">
                    <h2>📦 Ready for Pickup ({{ $orders->total() }})</h2>
                </div>
                <div class="rider-card-body" style="padding: 12px 22px;">
                    @if($orders->count() > 0)
                        <div class="order-queue">
                            @foreach($orders as $order)
                            <div class="order-queue-item">
                                <div class="order-queue-info">
                                    <div class="order-queue-id">{{ $order->display_id }}</div>
                                    <div class="order-queue-customer">{{ optional($order->user)->full_name ?? 'Customer' }}</div>
                                    <div class="order-queue-meta">
                                        <span>📦 {{ $order->orderItems->count() }} items</span>
                                        <span>📍 {{ optional($order->shippingAddress)->city_municipality ?? 'N/A' }}</span>
                                        <span>🕐 {{ $order->created_at->diffForHumans() }}</span>
                                        <span>💳 {{ ucfirst($order->payment_method) }}</span>
                                    </div>
                                </div>
                                <div class="order-queue-actions">
                                    <div class="order-queue-total">{{ $order->formatted_total }}</div>
                                    <form action="{{ route('rider.accept', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-rider-primary btn-rider-sm" onclick="return confirm('Accept this order for delivery?')">🛵 Accept Order</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="rider-empty-state">
                            <div class="empty-icon">📭</div>
                            <h3>No Orders Available</h3>
                            <p>All current orders are either pending or already claimed. Check back soon!</p>
                        </div>
                    @endif
                </div>

                @if($orders->hasPages())
                <div class="rider-pagination">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>


