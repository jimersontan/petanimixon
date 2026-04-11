@extends('layouts.admin')
@section('title', 'Returns & Refunds')
@section('content')

<div class="content-header">
    <h1 class="page-title">Returns & Refunds</h1>
</div>

<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-icon metric-icon-orders-orange"><svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 7l-7 7-7-7"/></svg></div>
        <div class="metric-content"><div class="metric-value">{{ $stats['total'] }}</div><div class="metric-label">Total Requests</div></div>
    </div>
    <div class="metric-card">
        <div class="metric-icon" style="background:#fef3c7; color:#d97706;"><svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg></div>
        <div class="metric-content"><div class="metric-value">{{ $stats['pending'] }}</div><div class="metric-label">Pending</div></div>
    </div>
    <div class="metric-card">
        <div class="metric-icon metric-icon-completed"><svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg></div>
        <div class="metric-content"><div class="metric-value">{{ $stats['approved'] }}</div><div class="metric-label">Approved</div></div>
    </div>
    <div class="metric-card">
        <div class="metric-icon" style="background:#fee2e2; color:#dc2626;"><svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/></svg></div>
        <div class="metric-content"><div class="metric-value">{{ $stats['rejected'] }}</div><div class="metric-label">Rejected</div></div>
    </div>
</div>

<div class="card orders-table-card">
    <div class="orders-section-header"><h2 class="card-title">Return Requests</h2></div>
    <div class="order-status-tabs" role="tablist">
        <a href="{{ route('returns.admin') }}" class="order-tab {{ $statusFilter === 'all' ? 'active' : '' }}">All</a>
        <a href="{{ route('returns.admin', ['status' => 'pending']) }}" class="order-tab {{ $statusFilter === 'pending' ? 'active' : '' }}">Pending</a>
        <a href="{{ route('returns.admin', ['status' => 'approved']) }}" class="order-tab {{ $statusFilter === 'approved' ? 'active' : '' }}">Approved</a>
        <a href="{{ route('returns.admin', ['status' => 'rejected']) }}" class="order-tab {{ $statusFilter === 'rejected' ? 'active' : '' }}">Rejected</a>
    </div>

    <div class="table-wrap">
        <table class="orders-table">
            <thead><tr><th>ID</th><th>Product</th><th>Customer</th><th>Reason</th><th>Type</th><th>Amount</th><th>Status</th><th class="col-actions">Actions</th></tr></thead>
            <tbody>
                @forelse($returns as $return)
                <tr>
                    <td><code>{{ $return->return_refund_id }}</code></td>
                    <td>{{ optional($return->orderItem)->product->product_name ?? '—' }}</td>
                    <td>{{ optional(optional($return->orderItem)->order)->user->full_name ?? '—' }}</td>
                    <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $return->return_reason }}">{{ $return->return_reason }}</td>
                    <td>{{ ucfirst($return->return_type) }}</td>
                    <td><strong>₱{{ number_format((float)$return->refund_amount, 2) }}</strong></td>
                    <td>
                        @if($return->refund_status === 'pending')
                            <span class="status-badge" style="background:#fef3c7; color:#d97706;">Pending</span>
                        @elseif($return->refund_status === 'approved')
                            <span class="status-badge" style="background:#dcfce7; color:#16a34a;">Approved</span>
                        @else
                            <span class="status-badge" style="background:#fee2e2; color:#dc2626;">Rejected</span>
                        @endif
                    </td>
                    <td class="col-actions">
                        @if($return->refund_status === 'pending')
                            <form method="POST" action="{{ route('returns.approve', $return->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="action-btn" title="Approve" style="color:#16a34a;" onclick="return confirm('Approve this return request?')">
                                    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('returns.reject', $return->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="action-btn" title="Reject" style="color:#dc2626;" onclick="return confirm('Reject this return request?')">
                                    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/></svg>
                                </button>
                            </form>
                        @else
                            <span style="font-size: 12px; color: #999;">{{ ucfirst($return->refund_status) }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center empty-orders">No return requests found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $returns->links() }}</div>
    </div>
</div>
@endsection
