@extends('layouts.admin')
@section('title', 'Sellers')
@section('content')

<div class="content-header">
    <h1 class="page-title">Sellers & Marketplace</h1>
    <div class="date-filter">
        <button type="button" class="btn-primary" onclick="openSellerModal('add')">
            <span class="btn-icon">+</span><span>Add Seller</span>
        </button>
    </div>
</div>

<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-icon metric-icon-orders-orange"><svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg></div>
        <div class="metric-content"><div class="metric-value">{{ $stats['total'] }}</div><div class="metric-label">Total Sellers</div></div>
    </div>
    <div class="metric-card">
        <div class="metric-icon metric-icon-completed"><svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg></div>
        <div class="metric-content"><div class="metric-value">{{ $stats['verified'] }}</div><div class="metric-label">Verified</div></div>
    </div>
    <div class="metric-card">
        <div class="metric-icon metric-icon-avg"><svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg></div>
        <div class="metric-content"><div class="metric-value">{{ $stats['pending'] }}</div><div class="metric-label">Pending Review</div></div>
    </div>
    <div class="metric-card">
        <div class="metric-icon metric-icon-revenue"><svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"/></svg></div>
        <div class="metric-content"><div class="metric-value">{{ $stats['inactive'] }}</div><div class="metric-label">Inactive</div></div>
    </div>
</div>

<div class="card orders-table-card">
    <div class="orders-section-header"><h2 class="card-title">All Sellers</h2></div>
    <div class="order-status-tabs" role="tablist">
        <a href="{{ route('sellers.admin') }}" class="order-tab {{ !request('status') ? 'active' : '' }}">All</a>
        <a href="{{ route('sellers.admin', ['status' => 'verified']) }}" class="order-tab {{ request('status') === 'verified' ? 'active' : '' }}">Verified</a>
        <a href="{{ route('sellers.admin', ['status' => 'pending']) }}" class="order-tab {{ request('status') === 'pending' ? 'active' : '' }}">Pending</a>
        <a href="{{ route('sellers.admin', ['status' => 'inactive']) }}" class="order-tab {{ request('status') === 'inactive' ? 'active' : '' }}">Inactive</a>
    </div>
    <div class="table-wrap">
        <table class="orders-table">
            <thead><tr><th>Store</th><th>Business</th><th>Email</th><th>Products</th><th>Status</th><th class="col-actions">Actions</th></tr></thead>
            <tbody>
                @forelse($sellers as $seller)
                <tr>
                    <td><strong>{{ $seller->store_name }}</strong></td>
                    <td>{{ $seller->business_name }}</td>
                    <td>{{ $seller->business_email }}</td>
                    <td>{{ $seller->products_count ?? 0 }}</td>
                    <td>
                        @if($seller->verification_status === 'verified')
                            <span class="status-badge" style="background:#dcfce7; color:#16a34a;">Verified</span>
                        @elseif($seller->verification_status === 'pending')
                            <span class="status-badge" style="background:#fef3c7; color:#d97706;">Pending</span>
                        @else
                            <span class="status-badge" style="background:#fee2e2; color:#dc2626;">{{ ucfirst($seller->verification_status) }}</span>
                        @endif
                    </td>
                    <td class="col-actions">
                        <button type="button" class="action-btn" title="Edit" onclick="openSellerModal('edit', {
                            id: {{ $seller->id }},
                            business_name: '{{ addslashes($seller->business_name) }}',
                            business_email: '{{ $seller->business_email }}',
                            business_phone: '{{ $seller->business_phone }}',
                            business_registration_number: '{{ $seller->business_registration_number }}',
                            business_registration_number_type: '{{ $seller->business_registration_number_type }}',
                            business_description: '{{ addslashes($seller->business_description ?? '') }}',
                            store_name: '{{ addslashes($seller->store_name) }}',
                            store_description: '{{ addslashes($seller->store_description ?? '') }}',
                            verification_status: '{{ $seller->verification_status }}'
                        })">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                        </button>
                        <form method="POST" action="{{ route('sellers.toggle', $seller->id) }}" style="display:inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="action-btn" title="{{ $seller->is_active ? 'Deactivate' : 'Activate' }}">
                                @if($seller->is_active)
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                @else
                                    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18" style="color:#16a34a"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                @endif
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center empty-orders">No sellers registered yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $sellers->links() }}</div>
    </div>
</div>

{{-- Payouts Section --}}
<div class="card orders-table-card" style="margin-top: 24px;">
    <div class="orders-section-header">
        <h2 class="card-title">Recent Payouts</h2>
        <button type="button" class="btn-primary" onclick="document.getElementById('payout-modal').classList.add('open'); document.querySelector('.modal-backdrop[data-modal-id=payout-modal]').classList.add('open');">
            <span class="btn-icon">+</span><span>Process Payout</span>
        </button>
    </div>
    <div class="table-wrap">
        <table class="orders-table">
            <thead><tr><th>Ref</th><th>Seller</th><th>Amount</th><th>Method</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
                @forelse($payouts as $payout)
                <tr>
                    <td><code>{{ $payout->transaction_reference }}</code></td>
                    <td>{{ $payout->seller->store_name ?? '—' }}</td>
                    <td><strong>₱{{ number_format($payout->payout_amount, 2) }}</strong></td>
                    <td>{{ ucfirst(str_replace('_',' ',$payout->payout_method)) }}</td>
                    <td><span class="status-badge" style="background:#dcfce7; color:#16a34a;">{{ ucfirst($payout->payout_status) }}</span></td>
                    <td>{{ $payout->created_at->format('M j, Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center empty-orders">No payouts processed yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('modals')
{{-- Seller Modal --}}
<div class="modal-backdrop" data-modal-id="seller-modal"></div>
<div id="seller-modal" class="modal" style="max-width: 700px; width: 95%;">
    <div class="modal-header">
        <h2 id="sellerModalTitle" class="modal-title">Add Seller</h2>
        <button type="button" class="modal-close" data-modal-close="seller-modal">&times;</button>
    </div>
    <div class="modal-body">
        <form id="sellerModalForm" method="POST" action="{{ route('sellers.store') }}">
            @csrf
            <div id="sellerMethodContainer"></div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group"><label>Store Name *</label><input type="text" name="store_name" id="s_store_name" class="form-control" required></div>
                <div class="form-group"><label>Business Name *</label><input type="text" name="business_name" id="s_business_name" class="form-control" required></div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group"><label>Business Email *</label><input type="email" name="business_email" id="s_business_email" class="form-control" required></div>
                <div class="form-group"><label>Phone *</label><input type="text" name="business_phone" id="s_business_phone" class="form-control" required></div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group"><label>Registration # *</label><input type="text" name="business_registration_number" id="s_business_reg" class="form-control" required></div>
                <div class="form-group"><label>Reg. Type *</label>
                    <select name="business_registration_number_type" id="s_business_reg_type" class="form-control" required>
                        <option value="DTI">DTI</option><option value="SEC">SEC</option><option value="BIR">BIR</option><option value="other">Other</option>
                    </select>
                </div>
            </div>
            <div class="form-group"><label>Business Description</label><textarea name="business_description" id="s_business_desc" class="form-control" rows="2"></textarea></div>
            <div class="form-group"><label>Store Description</label><textarea name="store_description" id="s_store_desc" class="form-control" rows="2"></textarea></div>
            <div class="form-group" id="verificationStatusGroup" style="display:none;">
                <label>Verification Status</label>
                <select name="verification_status" id="s_verification_status" class="form-control">
                    <option value="pending">Pending</option><option value="verified">Verified</option><option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="modal-footer" style="padding-top: 20px; border-top: 1px solid #f3f4f6; margin-top: 20px;">
                <button type="button" class="btn-secondary" data-modal-close="seller-modal">Cancel</button>
                <button type="submit" id="sellerSubmitBtn" class="btn-primary">Save Seller</button>
            </div>
        </form>
    </div>
</div>

{{-- Payout Modal --}}
<div class="modal-backdrop" data-modal-id="payout-modal"></div>
<div id="payout-modal" class="modal" style="max-width: 500px; width: 95%;">
    <div class="modal-header">
        <h2 class="modal-title">Process Payout</h2>
        <button type="button" class="modal-close" data-modal-close="payout-modal">&times;</button>
    </div>
    <div class="modal-body">
        <form method="POST" action="{{ route('sellers.payout') }}">
            @csrf
            <div class="form-group"><label>Seller *</label>
                <select name="seller_id" class="form-control" required>
                    <option value="">Select seller...</option>
                    @foreach(\App\Models\Seller::where('is_active', true)->get() as $s)
                        <option value="{{ $s->id }}">{{ $s->store_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group"><label>Amount (₱) *</label><input type="number" name="payout_amount" class="form-control" step="0.01" min="1" required></div>
            <div class="form-group"><label>Method *</label>
                <select name="payout_method" class="form-control" required>
                    <option value="gcash">GCash</option><option value="bank_transfer">Bank Transfer</option><option value="cash">Cash</option>
                </select>
            </div>
            <div class="form-group"><label>Bank/Account Details *</label><input type="text" name="bank_account_details" class="form-control" required></div>
            <div class="form-group"><label>Notes</label><textarea name="notes" class="form-control" rows="2"></textarea></div>
            <div class="modal-footer" style="padding-top: 20px; border-top: 1px solid #f3f4f6; margin-top: 20px;">
                <button type="button" class="btn-secondary" data-modal-close="payout-modal">Cancel</button>
                <button type="submit" class="btn-primary">Process Payout</button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
function openSellerModal(mode, data = null) {
    const modal = document.getElementById('seller-modal');
    const backdrop = document.querySelector('.modal-backdrop[data-modal-id="seller-modal"]');
    const form = document.getElementById('sellerModalForm');
    const title = document.getElementById('sellerModalTitle');
    const mc = document.getElementById('sellerMethodContainer');
    form.reset();

    if (mode === 'add') {
        title.textContent = 'Add Seller';
        form.action = "{{ route('sellers.store') }}";
        mc.innerHTML = '';
        document.getElementById('verificationStatusGroup').style.display = 'none';
    } else if (mode === 'edit' && data) {
        title.textContent = 'Edit Seller';
        form.action = `/admin/sellers/${data.id}`;
        mc.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('s_store_name').value = data.store_name;
        document.getElementById('s_business_name').value = data.business_name;
        document.getElementById('s_business_email').value = data.business_email;
        document.getElementById('s_business_phone').value = data.business_phone;
        document.getElementById('s_business_reg').value = data.business_registration_number;
        document.getElementById('s_business_reg_type').value = data.business_registration_number_type;
        document.getElementById('s_business_desc').value = data.business_description;
        document.getElementById('s_store_desc').value = data.store_description;
        document.getElementById('s_verification_status').value = data.verification_status;
        document.getElementById('verificationStatusGroup').style.display = 'block';
    }
    modal.classList.add('open');
    backdrop.classList.add('open');
}
</script>
@endpush
