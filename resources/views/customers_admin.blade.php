<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - PetMarkt-PH Admin</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
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
                <div>
                    <h1 class="page-title">Customers</h1>
                    <p class="page-subtitle">Manage and track your customer base</p>
                </div>
                <div class="date-filter">
                    <form method="get" action="{{ route('customers.admin') }}" class="date-filter-form" id="customersDateForm">
                        <select name="days" id="customersDateRange" class="filter-select" aria-label="Date range">
                            <option value="7" {{ ($days ?? 30) == 7 ? 'selected' : '' }}>Last 7 days</option>
                            <option value="30" {{ ($days ?? 30) == 30 ? 'selected' : '' }}>Last 30 days</option>
                            <option value="90" {{ ($days ?? 30) == 90 ? 'selected' : '' }}>Last 90 days</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Summary cards -->
            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-icon metric-icon-orders-orange">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">{{ number_format($stats['total_customers'] ?? 0) }}</div>
                        <div class="metric-label">Total Customers</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-pending">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">{{ number_format($stats['new_this_month'] ?? 0) }}</div>
                        <div class="metric-label">New This Month</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-completed">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">{{ number_format($stats['active_customers'] ?? 0) }}</div>
                        <div class="metric-label">Active</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-avg">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">₱{{ number_format($stats['avg_clv'] ?? 0) }}</div>
                        <div class="metric-label">Avg CLV</div>
                    </div>
                </div>
            </div>

            <!-- Customers table -->
            <div class="card orders-table-card">
                <div class="orders-section-header">
                    <h2 class="card-title">All Customers</h2>
                    <div class="orders-actions">
                        <button type="button" class="btn-secondary btn-export">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                            Export
                        </button>
                    </div>
                </div>

                <div class="order-status-tabs" role="tablist">
                    <button type="button" class="order-tab active" data-status="all" role="tab" aria-selected="true">All</button>
                    <button type="button" class="order-tab" data-status="active" role="tab">Active</button>
                    <button type="button" class="order-tab" data-status="inactive" role="tab">Inactive</button>
                    <button type="button" class="order-tab" data-status="vip" role="tab">VIP</button>
                </div>

                <div class="table-wrap">
                    <table class="orders-table" id="customersTable">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Orders</th>
                                <th>Total Spent</th>
                                <th>Registered</th>
                                <th>Status</th>
                                <th class="col-actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $statusBadge = [
                                    'active' => 'badge-paid',
                                    'inactive' => 'badge-failed',
                                    'vip' => 'badge-processing',
                                ];
                            @endphp
                            @forelse(($customers ?? []) as $customer)
                            @php /** @var \App\Models\User $customer */ @endphp
                            <tr data-status="{{ $customer->account_status ?? 'active' }}">
                                <td>
                                    <div class="customer-cell">{{ trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '')) ?: '—' }}</div>
                                    <div class="customer-email">ID: #{{ $customer->id }}</div>
                                </td>
                                <td>{{ $customer->email ?? '—' }}</td>
                                <td>{{ $customer->phone_number ?? '—' }}</td>
                                <td>{{ $customer->orders_count ?? 0 }}</td>
                                <td>{{ isset($customer->total_spent) ? '₱' . number_format($customer->total_spent, 2) : '₱0.00' }}</td>
                                <td>{{ optional($customer->created_at)->format('M j, Y') ?? '—' }}</td>
                                <td>
                                    @php $status = $customer->account_status ?? 'active'; @endphp
                                    <span class="badge {{ $statusBadge[$status] ?? 'badge-pending' }}">{{ strtoupper($status) }}</span>
                                </td>
                                <td class="col-actions">
                                    <button type="button" class="action-btn" title="View Details" aria-label="View customer" onclick="openCustomerModal({{ $customer->id }})">
                                        <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z"/></svg>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center empty-orders">No customers found yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(isset($customers) && $customers instanceof \Illuminate\Pagination\LengthAwarePaginator && $customers->hasPages())
                <div class="orders-pagination">
                    {{ $customers->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Customer Details Modal -->
    <div class="modal-backdrop" id="customerModalBackdrop"></div>
    <div id="customerModal" class="modal" style="max-width: 600px; width: 95%;" role="dialog" aria-modal="true" tabindex="-1">
        <div class="modal-header">
            <h2 class="modal-title">Customer Details</h2>
            <button type="button" class="modal-close" onclick="closeCustomerModal()" aria-label="Close modal">&times;</button>
        </div>
        <div class="modal-body" id="customerModalBody" style="padding-top: 10px;">
            <div style="text-align: center; color: #6b7280; padding: 20px;">Loading customer details...</div>
        </div>
        <div class="modal-footer" style="padding-top: 20px; border-top: 1px solid #f3f4f6; margin-top: 20px;">
            <button type="button" class="btn-secondary" onclick="closeCustomerModal()">Close</button>
        </div>
    </div>

    <script src="{{ asset('js/orders.js') }}"></script>
    <script src="{{ asset('js/animations.js') }}"></script>
    <script>
        function openCustomerModal(id) {
            const modal = document.getElementById('customerModal');
            const backdrop = document.getElementById('customerModalBackdrop');
            const body = document.getElementById('customerModalBody');
            
            modal.classList.add('open');
            backdrop.classList.add('open');
            
            body.innerHTML = '<div style="text-align: center; color: #6b7280; padding: 20px;">Loading customer details...</div>';
            
            fetch(`/admin/api/customers/${id}`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                let html = `
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
                        <div style="width: 56px; height: 56px; border-radius: 50%; background: #ea580c; color: white; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold;">
                            ${(data.first_name?.[0] || '') + (data.last_name?.[0] || '') || 'C'}
                        </div>
                        <div>
                            <h3 style="margin: 0; font-size: 18px; color: #1f2937;">${data.first_name || ''} ${data.last_name || ''}</h3>
                            <div style="color: #6b7280; font-size: 14px;">${data.email}</div>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                        <div style="background: #f9fafb; padding: 16px; border-radius: 8px; border: 1px solid #e5e7eb;">
                            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Contact</div>
                            <div style="font-size: 14px; color: #1f2937;">${data.phone_number || 'No phone'}</div>
                        </div>
                        <div style="background: #f9fafb; padding: 16px; border-radius: 8px; border: 1px solid #e5e7eb;">
                            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Status</div>
                            <div style="font-size: 14px; color: #1f2937; text-transform: capitalize;">${data.account_status || 'Active'}</div>
                        </div>
                    </div>
                    
                    <h4 style="margin: 0 0 12px 0; font-size: 15px; color: #374151; border-bottom: 1px solid #e5e7eb; padding-bottom: 8px;">Shipping Address</h4>
                    <div style="font-size: 14px; color: #4b5563; margin-bottom: 24px; line-height: 1.5;">
                        ${data.full_address || '<ul><li>No address provided.</li></ul>'}
                    </div>
                    
                    <h4 style="margin: 0 0 12px 0; font-size: 15px; color: #374151; border-bottom: 1px solid #e5e7eb; padding-bottom: 8px;">Recent Orders</h4>
                `;
                
                if (data.recent_orders && data.recent_orders.length > 0) {
                    html += '<table class="orders-table" style="margin-top: 0;"><thead><tr><th>Order ID</th><th>Date</th><th>Status</th><th>Total</th></tr></thead><tbody>';
                    data.recent_orders.forEach(order => {
                        html += `
                            <tr>
                                <td>#${order.id}</td>
                                <td>${new Date(order.created_at).toLocaleDateString()}</td>
                                <td><span class="badge ${order.status === 'delivered' ? 'badge-paid' : (order.status === 'cancelled' ? 'badge-failed' : 'badge-pending')}">${order.status}</span></td>
                                <td>₱${parseFloat(order.total_amount).toFixed(2)}</td>
                            </tr>
                        `;
                    });
                    html += '</tbody></table>';
                } else {
                    html += '<div style="color: #6b7280; font-size: 14px;">No recent orders.</div>';
                }
                
                body.innerHTML = html;
            })
            .catch(err => {
                body.innerHTML = '<div style="text-align: center; color: #ef4444; padding: 20px;">Failed to load customer details.</div>';
            });
        }
        
        function closeCustomerModal() {
            document.getElementById('customerModal').classList.remove('open');
            document.getElementById('customerModalBackdrop').classList.remove('open');
        }
    </script>
</body>
</html>



