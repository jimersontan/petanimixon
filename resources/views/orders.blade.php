@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<!-- ===== PAGE HEADER: Title and Date Filter ===== -->
            <div class="content-header">
                <h1 class="page-title">Orders</h1>
                <div class="date-filter">
                    <!-- Date Range Filter Form: Filters orders by time period -->
                    <form method="get" action="{{ route('admin.orders') }}" class="date-filter-form" id="ordersDateForm">
                        <select name="days" id="ordersDateRange" class="filter-select" aria-label="Date range">
                            <option value="7" {{ ($days ?? 30) == 7 ? 'selected' : '' }}>Last 7 days</option>
                            <option value="30" {{ ($days ?? 30) == 30 ? 'selected' : '' }}>Last 30 days</option>
                            <option value="90" {{ ($days ?? 30) == 90 ? 'selected' : '' }}>Last 90 days</option>
                        </select>
                    </form>
                    <!-- End: Date Range Filter -->
                </div>
            </div>
            <!-- ===== END PAGE HEADER ===== -->

            <!-- ===== METRICS CARDS SECTION ===== -->
            <!-- Four summary cards: Total Orders, Pending, Completed, Cancelled -->
            <div class="metrics-grid">

                <!-- Metric Card: Total Orders -->
                <div class="metric-card">
                    <div class="metric-icon metric-icon-orders-orange">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value" id="ordersTotal">{{ number_format($stats['total'] ?? 0) }}</div>
                        <div class="metric-label">Total Orders</div>
                    </div>
                </div>
                <!-- End: Total Orders Card -->

                <!-- Metric Card: Pending Orders -->
                <div class="metric-card">
                    <div class="metric-icon metric-icon-pending">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value" id="ordersPending">{{ number_format($stats['pending'] ?? 0) }}</div>
                        <div class="metric-label">Pending</div>
                    </div>
                </div>
                <!-- End: Pending Orders Card -->

                <!-- Metric Card: Completed Orders -->
                <div class="metric-card">
                    <div class="metric-icon metric-icon-completed">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value" id="ordersCompleted">{{ number_format($stats['completed'] ?? 0) }}</div>
                        <div class="metric-label">Completed</div>
                    </div>
                </div>
                <!-- End: Completed Orders Card -->

                <!-- Metric Card: Cancelled Orders -->
                <div class="metric-card">
                    <div class="metric-icon metric-icon-cancelled">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value" id="ordersCancelled">{{ number_format($stats['cancelled'] ?? 0) }}</div>
                        <div class="metric-label">Cancelled</div>
                    </div>
                </div>
                <!-- End: Cancelled Orders Card -->

            </div>
            <!-- ===== END METRICS CARDS SECTION ===== -->

            <!-- ===== ORDERS TABLE SECTION ===== -->
            <!-- Main table listing all orders with filtering and actions -->
            <div class="card orders-table-card">

                <!-- Table Header: Title, Export and Filter Buttons -->
                <div class="orders-section-header">
                    <h2 class="card-title">All Orders</h2>
                    <div class="orders-actions">
                        <!-- Export Button -->
                        <button type="button" class="btn-secondary btn-export" id="btnExport">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                            Export
                        </button>
                        <!-- Filter Button -->
                        <button type="button" class="btn-secondary btn-filter" id="btnFilter">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/></svg>
                            Filter
                        </button>
                    </div>
                </div>
                <!-- End: Table Header -->

                <!-- Status Filter Tabs: All, Pending, Processing, Shipped, Delivered, Cancelled -->
                <div class="order-status-tabs" role="tablist">
                    <button type="button" class="order-tab active" data-status="all" role="tab" aria-selected="true">All</button>
                    <button type="button" class="order-tab" data-status="pending" role="tab">Pending</button>
                    <button type="button" class="order-tab" data-status="processing" role="tab">Processing</button>
                    <button type="button" class="order-tab" data-status="shipped" role="tab">Shipped</button>
                    <button type="button" class="order-tab" data-status="delivered" role="tab">Delivered</button>
                    <button type="button" class="order-tab" data-status="cancelled" role="tab">Cancelled</button>
                </div>
                <!-- End: Status Filter Tabs -->

                <!-- Orders Data Table -->
                <div class="table-wrap">
                    <table class="orders-table" id="ordersTable">
                        <!-- Table Header Columns -->
                        <thead>
                            <tr>
                                <th class="col-checkbox">
                                    <input type="checkbox" class="select-all" id="selectAllOrders" aria-label="Select all orders">
                                </th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Type</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th class="col-actions">Actions</th>
                            </tr>
                        </thead>
                        <!-- End: Table Header -->

                        <!-- Table Body: Order Rows -->
                        <tbody>
                            <!-- Badge CSS class mappings for payment and order statuses -->
                            @php
                                $paymentBadge = [
                                    'paid' => 'badge-paid',
                                    'pending' => 'badge-pending',
                                    'failed' => 'badge-failed',
                                ];
                                $statusBadge = [
                                    'pending' => 'badge-pending',
                                    'confirmed' => 'badge-pending',
                                    'preparing' => 'badge-processing',
                                    'assigned_to_rider' => 'badge-processing',
                                    'rider_confirmed' => 'badge-processing',
                                    'handed_to_courier' => 'badge-processing',
                                    'in_transit' => 'badge-shipped',
                                    'processing' => 'badge-processing',
                                    'out_for_delivery' => 'badge-shipped',
                                    'shipped' => 'badge-shipped',
                                    'delivered' => 'badge-delivered',
                                    'cancelled' => 'badge-cancelled',
                                ];
                                $paymentLabel = ['paid' => 'Paid', 'pending' => 'Pending', 'failed' => 'Failed'];
                                $statusLabel = [
                                    'pending' => 'Pending',
                                    'processing' => 'Processing',
                                    'shipped' => 'Shipped',
                                    'delivered' => 'Delivered',
                                    'cancelled' => 'Cancelled',
                                ];
                            @endphp

                            <!-- Loop: Render each order row -->
                            @forelse($orders as $order)
                            <tr data-status="{{ $order->order_status }}">
                                <!-- Checkbox Column -->
                                <td class="col-checkbox"><input type="checkbox" class="order-checkbox" value="{{ $order->id }}"></td>
                                <!-- Order ID -->
                                <td><span class="order-id">{{ $order->display_id }}</span></td>
                                <!-- Customer Name and Email -->
                                <td>
                                    <div class="customer-cell">{{ optional($order->user)->full_name ?? '—' }}</div>
                                    <div class="customer-email">{{ optional($order->user)->email ?? '—' }}</div>
                                </td>
                                <!-- First Product in Order -->
                                <td>
                                    <div class="product-cell">
                                        @php
                                            $firstItem = $order->orderItems && $order->orderItems->isNotEmpty() ? $order->orderItems->first() : null;
                                            $firstProduct = $firstItem ? $firstItem->product : null;
                                            $imageUrl = $firstProduct ? $firstProduct->image_url : null;
                                        @endphp
                                        <span class="product-thumb-sm">
                                            @if($imageUrl)
                                                <img src="{{ $imageUrl }}" alt="" style="width: 100%; height: 100%; object-fit: cover; border-radius: inherit;">
                                            @endif
                                        </span>
                                        <span class="product-meta">
                                            {{ $firstItem ? ($firstItem->summary ?? '—') : '—' }}
                                        </span>
                                    </div>
                                </td>
                                <!-- Order Date and Time -->
                                <td>
                                    <div class="date-cell">{{ optional($order->created_at)->format('M j, Y') ?? '—' }}</div>
                                    <div class="time-cell">{{ optional($order->created_at)->format('g:i A') ?? '—' }}</div>
                                </td>
                                <!-- Order Total -->
                                <td class="total-cell">{{ $order->formatted_total ?? '—' }}</td>
                                <!-- Shipping Type Badge -->
                                <td>
                                    @if($order->isLocal())
                                        <span class="badge" style="background:#fef3c7;color:#d97706;"><span style="margin-right:4px;">🛵</span> Local</span>
                                    @else
                                        <span class="badge" style="background:#fce7f3;color:#be185d;"><span style="margin-right:4px;">📦</span> Courier</span>
                                    @endif
                                </td>
                                <!-- Payment Status Badge -->
                                <td><span class="badge {{ $paymentBadge[$order->payment_status] ?? 'badge-pending' }}">{{ $paymentLabel[$order->payment_status] ?? ucfirst($order->payment_status) }}</span></td>
                                <!-- Order Status Badge -->
                                <td><span class="badge {{ $statusBadge[$order->order_status] ?? 'badge-pending' }}">{{ $order->status_label }}</span></td>
                                <!-- Action Buttons: View and Edit -->
                                <td class="col-actions">
                                    <!-- View Button -->
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="action-btn" title="View" aria-label="View order"><svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg></a>
                                    <!-- Edit Button -->
                                    <a href="#" class="action-btn" title="Edit" aria-label="Edit order"><svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg></a>
                                </td>
                                <!-- End: Action Buttons -->
                            </tr>
                            @empty
                            <!-- Empty State: Shown when no orders exist for the period -->
                            <tr>
                                <td colspan="10" class="text-center empty-orders">No orders found for the selected period.</td>
                            </tr>
                            @endforelse
                            <!-- End: Order Rows Loop -->
                        </tbody>
                        <!-- End: Table Body -->
                    </table>
                </div>
                <!-- End: Orders Data Table -->

                <!-- Pagination: Only shown if orders span multiple pages -->
                @if(isset($orders) && $orders->hasPages())
                <div class="orders-pagination">
                    {{ $orders->withQueryString()->links() }}
                </div>
                @endif
                <!-- End: Pagination -->

            </div>
            <!-- ===== END ORDERS TABLE SECTION ===== -->
@endsection
