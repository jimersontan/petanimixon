@extends('layouts.admin')

@section('title', 'Analytics Dashboard')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')

<style>
    /* Scoped Analytics CSS to prevent layout overflow bugs */
    .analytics-dashboard {
        display: flex;
        flex-direction: column;
        gap: 24px;
        width: 100%;
        max-width: 100%;
    }

    .analytics-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 8px;
        margin-bottom: 8px;
    }

    .analytics-title {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }

    .analytics-controls {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .analytics-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        width: 100%;
    }

    .analytics-grid-2 {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        width: 100%;
    }

    .analytics-grid-2-equal {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        width: 100%;
    }

    .analytics-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        min-width: 0; /* CRITICAL FIX: Prevents flex/grid children from overflowing */
        display: flex;
        flex-direction: column;
    }

    .stat-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 12px;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon.revenue { background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%); color: #ea580c; }
    .stat-icon.orders { background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); color: #2563eb; }
    .stat-icon.units { background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); color: #9333ea; }
    .stat-icon.aov { background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); color: #059669; }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
        margin: 0;
        line-height: 1.2;
    }

    .stat-label {
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
        margin-top: 4px;
    }

    .chart-header {
        margin-bottom: 20px;
    }

    .chart-title {
        font-size: 18px;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }

    .chart-wrapper {
        position: relative;
        width: 100%;
        height: 350px;
        min-width: 0; /* CRITICAL FIX */
        flex-grow: 1;
    }

    .chart-wrapper canvas {
        max-width: 100% !important; /* CRITICAL FIX: Chart.js infinite growth prevention */
    }

    .analytics-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .analytics-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 500px;
    }

    .analytics-table th {
        text-align: left;
        padding: 12px 16px;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #e5e7eb;
    }

    .analytics-table td {
        padding: 16px;
        font-size: 14px;
        color: #1f2937;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    .analytics-table tbody tr:last-child td {
        border-bottom: none;
    }

    .product-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .product-img {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        object-fit: cover;
        background: #f3f4f6;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .empty-state {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #9ca3af;
        font-size: 14px;
        font-style: italic;
    }

    @media (max-width: 1400px) {
        .analytics-grid-4 { grid-template-columns: repeat(2, 1fr); }
        .analytics-grid-2 { grid-template-columns: 1fr; }
    }

    @media (max-width: 992px) {
        .analytics-grid-2-equal { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .analytics-header { flex-direction: column; align-items: flex-start; gap: 16px; }
        .analytics-grid-4 { grid-template-columns: 1fr; }
    }
</style>

<div class="analytics-dashboard">
    
    <!-- Header -->
    <div class="analytics-header">
        <h1 class="analytics-title">Analytics Dashboard</h1>
        <div class="analytics-controls">
            <form method="get" action="{{ route('analytics.admin') }}" id="dateFilterForm" style="margin:0;">
                <select name="days" class="filter-select" style="padding: 8px 16px; border-radius: 8px; border: 1px solid #d1d5db; outline: none; font-weight: 500;" onchange="document.getElementById('dateFilterForm').submit()">
                    <option value="7" {{ $days == 7 ? 'selected' : '' }}>Last 7 days</option>
                    <option value="30" {{ $days == 30 ? 'selected' : '' }}>Last 30 days</option>
                    <option value="90" {{ $days == 90 ? 'selected' : '' }}>Last 90 days</option>
                </select>
            </form>
            <button type="button" class="btn-primary" style="padding: 8px 16px; border-radius: 8px; background: #ea580c; color: #fff; border: none; font-weight: 600; cursor: pointer;" onclick="window.print()">Export</button>
        </div>
    </div>

    <!-- Metrics -->
    <div class="analytics-grid-4">
        <!-- Revenue -->
        <div class="analytics-card">
            <div class="stat-header">
                <div class="stat-icon revenue">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                </div>
            </div>
            <div class="stat-value">₱{{ number_format($stats['revenue'], 2) }}</div>
            <div class="stat-label">Total Revenue</div>
        </div>

        <!-- Orders -->
        <div class="analytics-card">
            <div class="stat-header">
                <div class="stat-icon orders">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M20 2H4c-1 0-2 .9-2 2v3.01c0 .72.43 1.34 1 1.69V20c0 1.1 1.1 2 2 2h14c.9 0 2-.9 2-2V8.7c.57-.35 1-.97 1-1.69V4c0-1.1-1-2-2-2zm-5 12H9v-2h6v2zm5-7H4V4h16v3z"/></svg>
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['orders']) }}</div>
            <div class="stat-label">Sales Orders</div>
        </div>

        <!-- Units Sold -->
        <div class="analytics-card">
            <div class="stat-header">
                <div class="stat-icon units">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M22 10V6a2 2 0 00-2-2H4a2 2 0 00-2 2v4c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zm-2-4v4H4V6h16z"/></svg>
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['units_sold']) }}</div>
            <div class="stat-label">Units Sold</div>
        </div>

        <!-- AOV -->
        <div class="analytics-card">
            <div class="stat-header">
                <div class="stat-icon aov">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                </div>
            </div>
            <div class="stat-value">₱{{ number_format($stats['avg_order_value'], 2) }}</div>
            <div class="stat-label">Average Order Value</div>
        </div>
    </div>

    <!-- Charts -->
    <div class="analytics-grid-2">
        <div class="analytics-card">
            <div class="chart-header">
                <h2 class="chart-title">Revenue Trend</h2>
            </div>
            <div class="chart-wrapper">
                <canvas id="mainRevenueChart"></canvas>
            </div>
        </div>
        <div class="analytics-card">
            <div class="chart-header">
                <h2 class="chart-title">Sales by Category</h2>
            </div>
            <div class="chart-wrapper">
                @if(count($categoryData) > 0)
                    <canvas id="categoryDoughnutChart"></canvas>
                @else
                    <div class="empty-state">No category data available yet.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tables -->
    <div class="analytics-grid-2-equal">
        <div class="analytics-card">
            <div class="chart-header">
                <h2 class="chart-title">Top Selling Products</h2>
            </div>
            <div class="analytics-table-wrap">
                <table class="analytics-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th style="text-align: right;">Units Sold</th>
                            <th style="text-align: right;">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $item)
                        <tr>
                            <td>
                                <div class="product-cell">
                                    @if(optional($item->product)->animal_image_url)
                                        <img src="{{ asset('storage/' . $item->product->animal_image_url) }}" class="product-img">
                                    @else
                                        <div class="product-img" style="display:flex;align-items:center;justify-content:center;">📦</div>
                                    @endif
                                    <span style="font-weight: 500;">{{ optional($item->product)->product_name ?? 'Unknown Product' }}</span>
                                </div>
                            </td>
                            <td style="text-align: right; color: #4b5563;">{{ number_format($item->total_sold) }}</td>
                            <td style="text-align: right; font-weight: 600; color: #059669;">₱{{ number_format($item->total_revenue, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="empty-state" style="padding: 32px 0;">No product data available.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="analytics-card">
            <div class="chart-header">
                <h2 class="chart-title">Recent Transactions</h2>
            </div>
            <div class="analytics-table-wrap">
                <table class="analytics-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th style="text-align: right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td style="font-family: monospace; color: #6b7280;">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td style="font-weight: 500;">{{ $order->user ? $order->user->full_name : 'Guest' }}</td>
                            <td style="color: #4b5563;">{{ $order->created_at->format('M j, Y') }}</td>
                            <td style="text-align: right; font-weight: 600;">₱{{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="empty-state" style="padding: 32px 0;">No recent orders.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Shared Tooltip Options
    const tooltipOptions = {
        backgroundColor: '#1f2937',
        titleFont: { family: 'Inter', size: 13 },
        bodyFont: { family: 'Inter', size: 14, weight: 'bold' },
        padding: 12,
        displayColors: false,
    };

    // Revenue Chart
    const revenueLabels = {!! json_encode($chartLabels ?? []) !!};
    const revenueData = {!! json_encode($chartData ?? []) !!};
    
    if (revenueLabels.length > 0 && document.getElementById('mainRevenueChart')) {
        const ctxRev = document.getElementById('mainRevenueChart').getContext('2d');
        const gradient = ctxRev.createLinearGradient(0, 0, 0, 350);
        gradient.addColorStop(0, 'rgba(234, 88, 12, 0.2)'); // var(--ud-orange-dark) with opacity
        gradient.addColorStop(1, 'rgba(234, 88, 12, 0)');

        new Chart(ctxRev, {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Revenue',
                    data: revenueData,
                    borderColor: '#ea580c',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#ea580c',
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
                        ...tooltipOptions,
                        callbacks: {
                            label: function(context) {
                                return '₱' + context.raw.toLocaleString(undefined, {minimumFractionDigits: 2});
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
                        ticks: { color: '#6b7280', font: { family: 'Inter' }, maxTicksLimit: 10 }
                    }
                },
                interaction: { intersect: false, mode: 'index' }
            }
        });
    }

    // Category Doughnut Chart
    const catLabels = {!! json_encode($categoryLabels ?? []) !!};
    const catData = {!! json_encode($categoryData ?? []) !!};

    if (catLabels.length > 0 && document.getElementById('categoryDoughnutChart')) {
        const ctxCat = document.getElementById('categoryDoughnutChart').getContext('2d');
        new Chart(ctxCat, {
            type: 'doughnut',
            data: {
                labels: catLabels,
                datasets: [{
                    data: catData,
                    backgroundColor: ['#ea580c', '#f97316', '#fdba74', '#fed7aa', '#ffedd5'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { color: '#4b5563', font: { family: 'Inter', size: 12 }, padding: 20, usePointStyle: true, pointStyle: 'circle' }
                    },
                    tooltip: {
                        ...tooltipOptions,
                        callbacks: {
                            label: function(context) {
                                return ' ₱' + context.raw.toLocaleString(undefined, {minimumFractionDigits: 2});
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
