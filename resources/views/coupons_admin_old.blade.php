@extends('layouts.admin')

@section('title', 'Coupons')

@section('content')

<div class="content-header">
    <h1 class="page-title">Coupons & Vouchers</h1>
    <div class="date-filter">
        <button type="button" class="btn-primary" onclick="openCouponModal('add')">
            <span class="btn-icon">+</span>
            <span>Add Coupon</span>
        </button>
    </div>
</div>

<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-icon metric-icon-orders-orange">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58s1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ $stats['total'] }}</div>
            <div class="metric-label">Total Coupons</div>
        </div>
    </div>
    <div class="metric-card">
        <div class="metric-icon metric-icon-completed">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ $stats['active'] }}</div>
            <div class="metric-label">Active</div>
        </div>
    </div>
    <div class="metric-card">
        <div class="metric-icon metric-icon-avg">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ $stats['expired'] }}</div>
            <div class="metric-label">Expired</div>
        </div>
    </div>
    <div class="metric-card">
        <div class="metric-icon metric-icon-revenue">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ $stats['total_uses'] }}</div>
            <div class="metric-label">Total Uses</div>
        </div>
    </div>
</div>

<div class="card orders-table-card">
    <div class="orders-section-header">
        <h2 class="card-title">All Coupons</h2>
    </div>

    <div class="order-status-tabs" role="tablist">
        <a href="{{ route('coupons.admin') }}" class="order-tab {{ !request('status') ? 'active' : '' }}">All</a>
        <a href="{{ route('coupons.admin', ['status' => 'active']) }}" class="order-tab {{ request('status') === 'active' ? 'active' : '' }}">Active</a>
        <a href="{{ route('coupons.admin', ['status' => 'expired']) }}" class="order-tab {{ request('status') === 'expired' ? 'active' : '' }}">Expired</a>
        <a href="{{ route('coupons.admin', ['status' => 'inactive']) }}" class="order-tab {{ request('status') === 'inactive' ? 'active' : '' }}">Inactive</a>
    </div>

    <div class="table-wrap">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Discount</th>
                    <th>Min Order</th>
                    <th>Valid Period</th>
                    <th>Uses</th>
                    <th>Status</th>
                    <th>Homepage</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                <tr>
                    <td><strong style="color: var(--ud-orange-dark); font-family: monospace; font-size: 14px;">{{ $coupon->coupon_code }}</strong></td>
                    <td>{{ $coupon->coupon_name }}</td>
                    <td>
                        @if($coupon->discount_type === 'percent')
                            {{ (int)$coupon->discount_amount }}% OFF
                        @else
                            ₱{{ number_format($coupon->discount_amount, 0) }} OFF
                        @endif
                    </td>
                    <td>{{ $coupon->min_order_value ? '₱'.number_format($coupon->min_order_value, 0) : '—' }}</td>
                    <td style="font-size: 12px;">{{ $coupon->valid_from->format('M j') }} – {{ $coupon->valid_until->format('M j, Y') }}</td>
                    <td>{{ $coupon->usages_count ?? 0 }}{{ $coupon->max_usage_limit ? '/'.$coupon->max_usage_limit : '' }}</td>
                    <td>
                        @if(!$coupon->is_active)
                            <span class="status-badge" style="background:#fee2e2; color:#dc2626;">Inactive</span>
                        @elseif($coupon->valid_until < now())
                            <span class="status-badge" style="background:#fef3c7; color:#d97706;">Expired</span>
                        @else
                            <span class="status-badge" style="background:#dcfce7; color:#16a34a;">Active</span>
                        @endif
                    </td>
                    <td>
                        @if($coupon->show_on_homepage && $coupon->featured_product_id)
                            <span class="status-badge" style="background:#ede9fe; color:#7c3aed;">★ Promo</span>
                        @else
                            <span style="color:#ccc;">—</span>
                        @endif
                    </td>
                    <td class="col-actions">
                        <button type="button" class="action-btn" title="Edit" onclick="openCouponModal('edit', {
                            id: {{ $coupon->id }},
                            coupon_code: '{{ $coupon->coupon_code }}',
                            coupon_name: '{{ addslashes($coupon->coupon_name) }}',
                            description: '{{ addslashes($coupon->description ?? '') }}',
                            discount_type: '{{ $coupon->discount_type }}',
                            discount_amount: '{{ $coupon->discount_amount }}',
                            usage_limit_per_user: '{{ $coupon->usage_limit_per_user ?? '' }}',
                            max_usage_limit: '{{ $coupon->max_usage_limit ?? '' }}',
                            valid_from: '{{ $coupon->valid_from->format('Y-m-d\TH:i') }}',
                            valid_until: '{{ $coupon->valid_until->format('Y-m-d\TH:i') }}',
                            min_order_value: '{{ $coupon->min_order_value ?? '' }}',
                            show_on_homepage: {{ $coupon->show_on_homepage ? 'true' : 'false' }},
                            featured_product_id: '{{ $coupon->featured_product_id ?? '' }}'
                        })">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                        </button>
                        <form method="POST" action="{{ route('coupons.toggle', $coupon->id) }}" style="display:inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="action-btn" title="{{ $coupon->is_active ? 'Deactivate' : 'Activate' }}">
                                @if($coupon->is_active)
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                @else
                                    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18" style="color:#16a34a"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                @endif
                            </button>
                        </form>
                        <form method="POST" action="{{ route('coupons.destroy', $coupon->id) }}" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn" title="Delete" onclick="return confirm('Delete this coupon?')" style="color:#ef4444;">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-4.5l-1-1zM18 7H6v12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7z"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center empty-orders">No coupons found. Create your first coupon!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $coupons->links() }}</div>
    </div>
</div>

@endsection

@push('modals')
<div class="modal-backdrop {{ $errors->any() ? 'open' : '' }}" data-modal-id="coupon-modal"></div>
<div id="coupon-modal" class="modal {{ $errors->any() ? 'open' : '' }}" style="max-width: 700px; width: 95%;">
    <div class="modal-header">
        <h2 id="couponModalTitle" class="modal-title">Add Coupon</h2>
        <button type="button" class="modal-close" data-modal-close="coupon-modal">&times;</button>
    </div>
    <div class="modal-body">
        <form id="couponModalForm" method="POST" action="{{ route('coupons.store') }}">
            @csrf
            <div id="couponMethodContainer"></div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="coupon_code">Coupon Code *</label>
                    <input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="e.g. PETLOVE20" required style="text-transform: uppercase;">
                </div>
                <div class="form-group">
                    <label for="coupon_name">Display Name *</label>
                    <input type="text" name="coupon_name" id="coupon_name" class="form-control" placeholder="e.g. Pet Love 20% Off" required>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="coupon_description" class="form-control" rows="2" placeholder="Optional description"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="discount_type">Discount Type *</label>
                    <select name="discount_type" id="discount_type" class="form-control" required>
                        <option value="percent">Percentage (%)</option>
                        <option value="fixed">Fixed Amount (₱)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="discount_amount">Discount Value *</label>
                    <input type="number" name="discount_amount" id="discount_amount" class="form-control" step="0.01" min="0" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="valid_from">Valid From *</label>
                    <input type="datetime-local" name="valid_from" id="valid_from" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="valid_until">Valid Until *</label>
                    <input type="datetime-local" name="valid_until" id="valid_until" class="form-control" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="min_order_value">Min Order (₱)</label>
                    <input type="number" name="min_order_value" id="min_order_value" class="form-control" step="0.01" min="0" placeholder="0">
                </div>
                <div class="form-group">
                    <label for="usage_limit_per_user">Per-User Limit</label>
                    <input type="number" name="usage_limit_per_user" id="usage_limit_per_user" class="form-control" min="1" placeholder="Unlimited">
                </div>
                <div class="form-group">
                    <label for="max_usage_limit">Max Total Uses</label>
                    <input type="number" name="max_usage_limit" id="max_usage_limit" class="form-control" min="1" placeholder="Unlimited">
                </div>
            </div>

            <div style="background: #faf5ff; border: 1px solid #e9d5ff; border-radius: 10px; padding: 16px; margin-top: 8px;">
                <h4 style="margin: 0 0 12px; font-size: 14px; color: #7c3aed; font-weight: 700;">★ Homepage Promo Card</h4>
                <p style="font-size: 12px; color: #888; margin: 0 0 12px;">Feature this coupon as a promotional card on the homepage. Select a product to display alongside the discount.</p>
                <div style="display: grid; grid-template-columns: 1fr auto; gap: 16px; align-items: end;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="featured_product_id">Featured Product</label>
                        <select name="featured_product_id" id="featured_product_id" class="form-control">
                            <option value="">— Select a product —</option>
                            @foreach($products ?? [] as $p)
                                <option value="{{ $p->id }}">{{ $p->product_name }} (₱{{ number_format($p->price, 0) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; white-space: nowrap;">
                            <input type="checkbox" name="show_on_homepage" id="show_on_homepage" value="1" style="width: 18px; height: 18px;">
                            <span>Show on Homepage</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="modal-footer" style="padding-top: 20px; border-top: 1px solid #f3f4f6; margin-top: 20px;">
                <button type="button" class="btn-secondary" data-modal-close="coupon-modal">Cancel</button>
                <button type="submit" id="couponSubmitBtn" class="btn-primary">Save Coupon</button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
function openCouponModal(mode, data = null) {
    const modal = document.getElementById('coupon-modal');
    const backdrop = document.querySelector('.modal-backdrop[data-modal-id="coupon-modal"]');
    const form = document.getElementById('couponModalForm');
    const title = document.getElementById('couponModalTitle');
    const submitBtn = document.getElementById('couponSubmitBtn');
    const methodContainer = document.getElementById('couponMethodContainer');

    form.reset();

    if (mode === 'add') {
        title.textContent = 'Add Coupon';
        submitBtn.textContent = 'Save Coupon';
        form.action = "{{ route('coupons.store') }}";
        methodContainer.innerHTML = '';
    } else if (mode === 'edit' && data) {
        title.textContent = 'Edit Coupon';
        submitBtn.textContent = 'Save Changes';
        form.action = `/admin/coupons/${data.id}`;
        methodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('coupon_code').value = data.coupon_code;
        document.getElementById('coupon_name').value = data.coupon_name;
        document.getElementById('coupon_description').value = data.description;
        document.getElementById('discount_type').value = data.discount_type;
        document.getElementById('discount_amount').value = data.discount_amount;
        document.getElementById('valid_from').value = data.valid_from;
        document.getElementById('valid_until').value = data.valid_until;
        document.getElementById('min_order_value').value = data.min_order_value;
        document.getElementById('usage_limit_per_user').value = data.usage_limit_per_user;
        document.getElementById('max_usage_limit').value = data.max_usage_limit;
        document.getElementById('featured_product_id').value = data.featured_product_id || '';
        document.getElementById('show_on_homepage').checked = !!data.show_on_homepage;
    }

    modal.classList.add('open');
    backdrop.classList.add('open');
}
</script>
@endpush
