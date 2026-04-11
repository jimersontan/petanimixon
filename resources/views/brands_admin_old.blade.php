<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brands - PetMarkt-PH Admin</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}">
</head>
<body class="dashboard-body">
    <!-- Header -->
    <header class="dashboard-header">
        <div class="header-left">
            <div class="logo" style="display:flex; align-items:center; gap:8px;">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-height: 28px;">
                <span class="logo-text" style="color:#1f2937;">Pet <span style="color: #ea580c;">Markt-PH</span></span>
            </div>
        </div>
        <div class="header-center">
            <div class="search-bar">
                <svg class="search-icon" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                <input type="text" class="search-input" placeholder="Search brands...">
            </div>
        </div>
        <div class="header-right">
            <button type="button" class="icon-btn" aria-label="Notifications">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
            </button>
            <button type="button" class="icon-btn" aria-label="Profile">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </button>
            <button type="button" class="icon-btn" aria-label="Settings">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M11.4 24H0V12.6h2.4v9.4h9v2.4zm12-12H12.6V0H24v2.4h-9.6v9.6H24V12zM2.4 9.6V0h2.4v9.6H2.4zm19.2 0V0H24v9.6h-2.4zM9.6 2.4V0h4.8v2.4H9.6zm4.8 19.2v-2.4h4.8V24h-4.8z"/></svg>
            </button>
        </div>
    </header>

    <div class="dashboard-layout">
        <!-- Sidebar -->
        @include('partials.admin_sidebar')

        <!-- Main content -->
        <main class="main-content">
            <div class="content-header">
                <h1 class="page-title">Brands</h1>
                <div class="date-filter">
                    <button type="button" class="btn-secondary">Import Brands</button>
                    <button type="button" class="btn-primary">+ Add Brand</button>
                </div>
            </div>

            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-icon metric-icon-orders-orange">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3 3h18v4H3z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">{{ number_format($stats['total_brands'] ?? 0) }}</div>
                        <div class="metric-label">Total Brands</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-completed">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">{{ number_format($stats['active_brands'] ?? 0) }}</div>
                        <div class="metric-label">Active</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-avg">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">{{ number_format($stats['featured_brands'] ?? 0) }}</div>
                        <div class="metric-label">Featured</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-avg">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3 17h18v4H3z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">{{ number_format($stats['avg_products_per_brand'] ?? 0, 1) }}</div>
                        <div class="metric-label">Avg Products/Brand</div>
                    </div>
                </div>
            </div>

            <div class="card orders-table-card">
                <h2 class="card-title">All Brands</h2>
                <div class="table-wrap">
                    <table class="orders-table" id="brandsTable">
                        <thead>
                            <tr>
                                <th>Brand</th>
                                <th>Products</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($brands ?? []) as $brand)
                            <tr>
                                <td>{{ $brand->name ?? '—' }}</td>
                                <td>{{ $brand->products_count ?? 0 }}</td>
                                <td>{{ ($brand->is_active ?? true) ? 'Active' : 'Inactive' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center empty-orders">No brands defined yet. You can still use the brand_name field on products.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/orders.js') }}"></script>
</body>
</html>



