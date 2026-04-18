<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - PetMarkt-PH Admin</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <input type="text" class="search-input" placeholder="Search orders, products, customers...">
            </div>
        </div>
        <div class="header-right">
            <button type="button" class="icon-btn" aria-label="Notifications" id="adminBellIcon" style="position: relative;">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
                <span id="adminStockBadge" style="position:absolute; right:4px; top:4px; background:#ef4444; color:#fff; border-radius:50%; width:16px; height:16px; font-size:10px; font-weight:700; display:none; align-items:center; justify-content:center;"></span>
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

        <main class="main-content">
            <div class="content-header">
                <h1 class="page-title">Analytics & Revenue</h1>
                <div class="date-filter">
                    <form method="get" action="{{ route('analytics.admin') }}" class="date-filter-form" id="analyticsDateForm">
                        <select name="days" id="analyticsDateRange" class="filter-select" aria-label="Date range" onchange="document.getElementById('analyticsDateForm').submit()">
                            <option value="7" {{ ($days ?? 30) == 7 ? 'selected' : '' }}>Last 7 days</option>
                            <option value="30" {{ ($days ?? 30) == 30 ? 'selected' : '' }}>Last 30 days</option>
                            <option value="90" {{ ($days ?? 30) == 90 ? 'selected' : '' }}>Last 90 days</option>
                        </select>
                    </form>
                    <button type="button" class="btn-primary" onclick="window.print()">Export Report</button>
                </div>
            </div>

            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-icon metric-icon-revenue">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">₱{{ number_format($stats['revenue'] ?? 0) }}</div>
                        <div class="metric-label">Total Revenue</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-orders">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M20 2H4c-1 0-2 .9-2 2v3.01c0 .72.43 1.34 1 1.69V20c0 1.1 1.1 2 2 2h14c.9 0 2-.9 2-2V8.7c.57-.35 1-.97 1-1.69V4c0-1.1-1-2-2-2zm-5 12H9v-2h6v2zm5-7H4V4h16v3z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">{{ number_format($stats['orders'] ?? 0) }}</div>
                        <div class="metric-label">Sales Orders</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-pending">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">{{ number_format($stats['conversion_rate'] ?? 0, 1) }}%</div>
                        <div class="metric-label">Conversion Rate</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-avg">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">₱{{ number_format($stats['avg_order_value'] ?? 0) }}</div>
                        <div class="metric-label">Avg Order Value</div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="dashboard-grid-two">
                <div class="card revenue-card">
                    <h2 class="card-title">Revenue Overview</h2>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="analyticsRevenueChart"></canvas>
                    </div>
                </div>
                <div class="card top-products-card">
                    <h2 class="card-title">Sales by Category</h2>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="dashboard-grid-two">
                <!-- Top Products Table -->
                <div class="card top-products-card">
                    <h2 class="card-title">Top Selling Products</h2>
                    <div class="table-wrap">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Units Sold</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts ?? [] as $item)
                                @php /** @var object $item */ @endphp
                                <tr>
                                    <td>
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            @if(optional($item->product)->animal_image_url)
                                                <img src="{{ asset('storage/'.optional($item->product)->animal_image_url) }}" style="width:36px; height:36px; border-radius:6px; object-fit:cover;">
                                            @else
                                                <div style="width:36px; height:36px; border-radius:6px; background:#f3f4f6; display:flex; align-items:center; justify-content:center;">📦</div>
                                            @endif
                                            <div style="font-weight: 500; color:#1f2937;">{{ optional($item->product)->product_name ?? 'Unknown' }}</div>
                                        </div>
                                    </td>
                                    <td>{{ number_format($item->total_sold) }}</td>
                                    <td style="font-weight: 600;">₱{{ number_format($item->total_revenue, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center empty-orders">No sales data available.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Recent Transactions -->
                <div class="card top-products-card">
                    <h2 class="card-title">Recent Transactions</h2>
                    <div class="table-wrap">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders ?? [] as $order)
                                @php /** @var \App\Models\Order $order */ @endphp
                                <tr>
                                    <td>
                                        <div style="font-weight: 500; color:#1f2937;">{{ $order->user ? trim($order->user->first_name . ' ' . $order->user->last_name) : 'Guest' }}</div>
                                        <div style="font-size: 12px; color: #6b7280;">#{{ $order->id }}</div>
                                    </td>
                                    <td>{{ $order->created_at->format('M j, Y') }}</td>
                                    <td style="font-weight: 600; color:#059669;">₱{{ number_format((float) $order->total_amount, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center empty-orders">No recent transactions.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/animations.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category Chart Data
            const catLabels = {!! json_encode(collect($salesByCategory ?? [])->pluck('category_name')) !!};
            const catData = {!! json_encode(collect($salesByCategory ?? [])->pluck('total_revenue')) !!};
            
            if (catLabels.length > 0 && document.getElementById('categoryChart')) {
                const ctxCat = document.getElementById('categoryChart').getContext('2d');
                new Chart(ctxCat, {
                    type: 'doughnut',
                    data: {
                        labels: catLabels,
                        datasets: [{
                            data: catData,
                            backgroundColor: [
                                '#f97316', // Orange
                                '#3b82f6', // Blue
                                '#10b981', // Green
                                '#8b5cf6', // Purple
                                '#f43f5e'  // Rose
                            ],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: { boxWidth: 12, padding: 20, font: { family: 'Inter', size: 12 } }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return ' ₱' + context.raw.toLocaleString();
                                    }
                                }
                            }
                        },
                        cutout: '70%'
                    }
                });
            } else if (document.getElementById('categoryChart')) {
                 document.getElementById('categoryChart').parentElement.innerHTML = '<div class="empty-chart">No category data available yet.</div>';
            }

            // Revenue Trend Chart (Reuse the Dashboard API data)
            fetch('/admin/api/dashboard-chart?type=daily')
                .then(res => res.json())
                .then(data => {
                    const ctx = document.getElementById('analyticsRevenueChart');
                    if (!ctx) return;
                    
                    const chartCtx = ctx.getContext('2d');
                    
                    // Create gradient for the line chart
                    const gradient = chartCtx.createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, 'rgba(249, 115, 22, 0.2)');
                    gradient.addColorStop(1, 'rgba(249, 115, 22, 0)');

                    new Chart(chartCtx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Revenue (k ₱)',
                                data: data.data,
                                borderColor: '#f97316',
                                backgroundColor: gradient,
                                borderWidth: 3,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '#f97316',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: '#1f2937',
                                    titleFont: { family: 'Inter', size: 13 },
                                    bodyFont: { family: 'Inter', size: 14, weight: 'bold' },
                                    padding: 12,
                                    displayColors: false,
                                    callbacks: {
                                        label: function(context) {
                                            return '₱' + (context.raw * 1000).toLocaleString();
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { color: '#f3f4f6', drawBorder: false },
                                    ticks: { color: '#6b7280', font: { family: 'Inter' } }
                                },
                                x: {
                                    grid: { display: false, drawBorder: false },
                                    ticks: { color: '#6b7280', font: { family: 'Inter' } }
                                }
                            },
                            interaction: {
                                intersect: false,
                                mode: 'index',
                            },
                        }
                    });
                })
                .catch(err => {
                    if (document.getElementById('analyticsRevenueChart')) {
                        document.getElementById('analyticsRevenueChart').parentElement.innerHTML = '<div class="empty-chart">No revenue data available yet.</div>';
                    }
                });
        });
    </script>
</body>
</html>



