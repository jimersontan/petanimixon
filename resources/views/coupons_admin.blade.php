@extends('layouts.admin')

@section('title', 'Coupons & Vouchers')

@section('content')

<div class="content-header">
    <div>
        <h1 class="page-title">Coupons & Promotions</h1>
        <p class="page-subtitle">Manage coupon codes and product sales</p>
    </div>
    <div class="date-filter">
        <button type="button" class="btn-primary" onclick="switchTab('all-coupons'); openCouponModal('add')">
            <span class="btn-icon">+</span>
            <span>New Coupon</span>
        </button>
    </div>
</div>

<!-- ===== TABS: All Coupons vs Product Sales ===== -->
<div class="card">
    <div class="orders-section-header">
        <h2 class="card-title">📋 Coupon & Sales Management</h2>
    </div>

    <div style="display: flex; gap: 8px; border-bottom: 2px solid #f3f4f6; margin-bottom: 20px;">
        <button type="button" id="tab-all-coupons" class="order-tab active" onclick="switchTab('all-coupons')" style="border-bottom: 3px solid var(--ud-orange-dark); margin-bottom: -2px;">
            All Coupons
        </button>
        <button type="button" id="tab-product-sales" class="order-tab" onclick="switchTab('product-sales')">
            Product Sales
        </button>
    </div>

    <!-- ===== TAB 1: ALL COUPONS ===== -->
    <div id="tab-content-all-coupons" class="tab-content">
        <div class="metrics-grid" style="margin-bottom: 24px;">
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
                    <div class="metric-label">Active Now</div>
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

        <!-- Status Tabs -->
        <div class="order-status-tabs" role="tablist" style="margin-bottom: 16px;">
            <a href="{{ route('coupons.admin') }}" class="order-tab {{ !request('status') ? 'active' : '' }}">All</a>
            <a href="{{ route('coupons.admin', ['status' => 'active']) }}" class="order-tab {{ request('status') === 'active' ? 'active' : '' }}">Active</a>
            <a href="{{ route('coupons.admin', ['status' => 'expired']) }}" class="order-tab {{ request('status') === 'expired' ? 'active' : '' }}">Expired</a>
            <a href="{{ route('coupons.admin', ['status' => 'inactive']) }}" class="order-tab {{ request('status') === 'inactive' ? 'active' : '' }}">Inactive</a>
        </div>

        <!-- Coupons Table -->
        <div class="table-wrap">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Discount</th>
                        <th>Valid Until</th>
                        <th>Uses</th>
                        <th>Status</th>
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
                                <span class="badge" style="background:#e0f2fe; color:#0369a1;">{{ (int)$coupon->discount_amount }}% OFF</span>
                            @else
                                <span class="badge" style="background:#fce7f3; color:#be185d;">₱{{ number_format($coupon->discount_amount, 0) }} OFF</span>
                            @endif
                        </td>
                        <td style="font-size: 12px;">{{ $coupon->valid_until->format('M j, Y') }}</td>
                        <td>{{ $coupon->usages_count ?? 0 }}{{ $coupon->max_usage_limit ? '/'.$coupon->max_usage_limit : '' }}</td>
                        <td>
                            @if(!$coupon->is_active)
                                <span class="status-badge" style="background:#fee2e2; color:#dc2626;">Draft</span>
                            @elseif($coupon->valid_until < now())
                                <span class="status-badge" style="background:#fef3c7; color:#d97706;">Expired</span>
                            @else
                                <span class="status-badge" style="background:#dcfce7; color:#16a34a;">✓ Active</span>
                            @endif
                        </td>
                        <td class="col-actions" style="display: flex; gap: 8px; align-items: center; justify-content: flex-start; flex-wrap: nowrap;">
                            <!-- Edit Button -->
                            <button type="button" class="action-btn" title="Edit" style="white-space: nowrap; padding: 6px 10px; font-size: 16px; background: none; border: none; cursor: pointer;" onclick="openCouponModal('edit', {
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
                                ✏️
                            </button>

                            <!-- Toggle Status Button -->
                            <form method="POST" action="{{ route('coupons.toggle', $coupon->id) }}" style="display: contents;">
                                @csrf @method('PATCH')
                                <button type="submit" class="action-btn" title="{{ $coupon->is_active ? 'Deactivate' : 'Activate' }}" style="white-space: nowrap; padding: 6px 10px; font-size: 16px; background: none; border: none; cursor: pointer;">
                                    {{ $coupon->is_active ? '⊘' : '✓' }}
                                </button>
                            </form>

                            <!-- Delete Button -->
                            <form method="POST" action="{{ route('coupons.destroy', $coupon->id) }}" style="display: contents;" onsubmit="return confirm('Delete this coupon? This action cannot be undone.');">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn" title="Delete" style="white-space: nowrap; padding: 6px 10px; font-size: 16px; background: none; border: none; cursor: pointer;">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center" style="padding: 40px 20px; color: #999;">
                            📭 No coupons yet. <a href="#" onclick="openCouponModal('add'); return false;" style="color: var(--ud-orange-dark); font-weight: 600;">Create one →</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @if($coupons->hasPages())
                <div class="mt-4">{{ $coupons->links() }}</div>
            @endif
        </div>
    </div>

    <!-- ===== TAB 2: PRODUCT SALES ===== -->
    <div id="tab-content-product-sales" class="tab-content" style="display: none;">
        <div class="metrics-grid" style="margin-bottom: 24px;">
            <div class="metric-card">
                <div class="metric-icon metric-icon-orders-orange">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                </div>
                <div class="metric-content">
                    <div class="metric-value">{{ $saleProducts->total() }}</div>
                    <div class="metric-label">Products on Sale</div>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-icon metric-icon-completed">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                </div>
                <div class="metric-content">
                    <div class="metric-value">{{ $saleProducts->where('is_featured', true)->count() }}</div>
                    <div class="metric-label">Featured for Homepage</div>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <button type="button" class="btn-primary" onclick="openSalesModal('add')">
                <span class="btn-icon">+</span>
                <span>Add Featured Product</span>
            </button>
        </div>

        <!-- Sales Products Table -->
        <div class="table-wrap">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Brand</th>
                        <th>Original Price</th>
                        <th>Discount</th>
                        <th>Sale Price</th>
                        <th>Valid Until</th>
                        <th>Homepage</th>
                        <th class="col-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($saleProducts as $product)
                    <tr>
                        <td style="max-width: 250px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 40px; height: 40px; border-radius: 8px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <span style="font-size: 16px;">📦</span>
                                    @endif
                                </div>
                                <span style="font-weight: 500;">{{ Str::limit($product->product_name, 40) }}</span>
                            </div>
                        </td>
                        <td>{{ $product->brand_name ?? '—' }}</td>
                        <td>
                            <span style="color: #6b7280; text-decoration: line-through;">₱{{ number_format($product->price, 2) }}</span>
                        </td>
                        <td>
                            @if($product->discount_type === 'percent')
                                <span class="badge" style="background:#e0f2fe; color:#0369a1;">{{ (int)$product->discount_amount }}% OFF</span>
                            @elseif($product->discount_type === 'fixed')
                                <span class="badge" style="background:#fce7f3; color:#be185d;">₱{{ number_format((float)$product->discount_amount, 0) }} OFF</span>
                            @else
                                <span class="badge" style="background:#f3f4f6; color:#6b7280;">N/A</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $salePrice = $product->price;
                                if ($product->discount_type === 'percent' && $product->discount_amount > 0) {
                                    $salePrice = $product->price * (1 - ($product->discount_amount / 100));
                                } elseif ($product->discount_type === 'fixed' && $product->discount_amount > 0) {
                                    $salePrice = max(0, $product->price - $product->discount_amount);
                                }
                            @endphp
                            <span style="font-weight: 600; color: var(--ud-orange, #E85D04);">₱{{ number_format($salePrice, 2) }}</span>
                        </td>
                        <td style="font-size: 12px;">
                            {{ $product->sale_valid_until ? $product->sale_valid_until->format('M j, Y') : '—' }}
                        </td>
                        <td>
                            @if($product->is_featured)
                                <span style="padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; background: #dcfce7; color: #16a34a;">
                                    ✓ Featured
                                </span>
                            @else
                                <span style="padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; background: #f3f4f6; color: #6b7280;">
                                    —
                                </span>
                            @endif
                        </td>
                        <td class="col-actions" style="display: flex; gap: 8px; align-items: center;">
                            <button type="button" class="action-btn" title="Edit Sale" style="padding: 6px 10px; font-size: 16px; background: none; border: none; cursor: pointer;" onclick="openSalesModal('edit', {
                                product_id: {{ $product->id }},
                                product_name: '{{ addslashes($product->product_name) }}',
                                discount_type: '{{ $product->discount_type }}',
                                discount_amount: '{{ $product->discount_amount }}',
                                valid_from: '{{ $product->sale_valid_from ? $product->sale_valid_from->format('Y-m-d\TH:i') : '' }}',
                                valid_until: '{{ $product->sale_valid_until ? $product->sale_valid_until->format('Y-m-d\TH:i') : '' }}',
                                is_featured: {{ $product->is_featured ? 'true' : 'false' }}
                            })">
                                ✏️
                            </button>
                            <form method="POST" action="{{ route('products.toggle-featured', $product->id) }}" style="display: contents;">
                                @csrf @method('PATCH')
                                <button type="submit" class="action-btn" title="{{ $product->is_featured ? 'Remove from Homepage' : 'Add to Homepage' }}" style="padding: 6px 10px; font-size: 16px; background: none; border: none; cursor: pointer;">
                                    {{ $product->is_featured ? '⭐' : '☆' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('products.toggle-sale', $product->id) }}" style="display: contents;">
                                @csrf @method('PATCH')
                                <button type="submit" class="action-btn" title="Remove from Sale" style="padding: 6px 10px; font-size: 16px; background: none; border: none; cursor: pointer;">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center" style="padding: 40px 20px; color: #999;">
                            🏷️ No products on sale yet. <a href="{{ route('products.readonly') }}" style="color: var(--ud-orange-dark); font-weight: 600;">Manage products →</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @if($saleProducts->hasPages())
                <div class="mt-4">{{ $saleProducts->links() }}</div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('modals')
<div class="modal-backdrop {{ $errors->any() ? 'open' : '' }}" data-modal-id="coupon-modal"></div>
<div id="coupon-modal" class="modal {{ $errors->any() ? 'open' : '' }}" style="max-width: 800px; width: 95%;">
    <div class="modal-header">
        <h2 id="couponModalTitle" class="modal-title">Add Coupon</h2>
        <button type="button" class="modal-close" data-modal-close="coupon-modal">&times;</button>
    </div>
    <div class="modal-body">
        <form id="couponModalForm" method="POST" action="{{ route('coupons.store') }}">
            @csrf
            <div id="couponMethodContainer"></div>

            <div style="background: #fafafa; padding: 16px; border-radius: 10px; margin-bottom: 20px;">
                <h3 style="margin: 0 0 16px; font-size: 14px; color: #333; font-weight: 700;">📝 Basic Information</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label for="coupon_code" style="font-weight: 700; display: block; margin-bottom: 8px;">Coupon Code *</label>
                        <input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="e.g. PETLOVE20" required style="text-transform: uppercase; font-weight: 600; font-size: 16px;">
                        <small style="color: #888;">Use uppercase letters and numbers only</small>
                    </div>
                    <div class="form-group">
                        <label for="coupon_name" style="font-weight: 700; display: block; margin-bottom: 8px;">Display Name *</label>
                        <input type="text" name="coupon_name" id="coupon_name" class="form-control" placeholder="e.g. Pet Love 20% Off" required>
                        <small style="color: #888;">What customers will see</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="coupon_description" style="font-weight: 700; display: block; margin-bottom: 8px;">Description</label>
                    <textarea name="description" id="coupon_description" class="form-control" rows="2" placeholder="e.g. Limited time offer! Save 20% on pet food and supplies" style="resize: vertical;"></textarea>
                </div>
            </div>

            <div style="background: #f0f9ff; padding: 16px; border-radius: 10px; margin-bottom: 20px;">
                <h3 style="margin: 0 0 16px; font-size: 14px; color: #0369a1; font-weight: 700;">💰 Discount & Conditions</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div class="form-group">
                        <label for="discount_type" style="font-weight: 700; display: block; margin-bottom: 8px;">Discount Type *</label>
                        <select name="discount_type" id="discount_type" class="form-control" required>
                            <option value="percent">Percentage (%)</option>
                            <option value="fixed">Fixed Amount (₱)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="discount_amount" style="font-weight: 700; display: block; margin-bottom: 8px;">Amount *</label>
                        <input type="number" name="discount_amount" id="discount_amount" class="form-control" step="0.01" min="0" placeholder="e.g. 20" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="min_order_value" style="font-weight: 700; display: block; margin-bottom: 8px;">Minimum Order Amount</label>
                    <input type="number" name="min_order_value" id="min_order_value" class="form-control" step="0.01" min="0" placeholder="e.g. 500 (optional)">
                    <small style="color: #888;">Leave empty for no minimum</small>
                </div>
            </div>

            <div style="background: #fef3c7; padding: 16px; border-radius: 10px; margin-bottom: 20px;">
                <h3 style="margin: 0 0 16px; font-size: 14px; color: #d97706; font-weight: 700;">📅 Validity Period</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label for="valid_from" style="font-weight: 700; display: block; margin-bottom: 8px;">Valid From *</label>
                        <input type="datetime-local" name="valid_from" id="valid_from" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="valid_until" style="font-weight: 700; display: block; margin-bottom: 8px;">Valid Until *</label>
                        <input type="datetime-local" name="valid_until" id="valid_until" class="form-control" required>
                    </div>
                </div>
            </div>

            <div style="background: #f5f3ff; padding: 16px; border-radius: 10px; margin-bottom: 20px;">
                <h3 style="margin: 0 0 16px; font-size: 14px; color: #7c3aed; font-weight: 700;">🔢 Usage Limits</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label for="usage_limit_per_user" style="font-weight: 700; display: block; margin-bottom: 8px;">Per Customer Limit</label>
                        <input type="number" name="usage_limit_per_user" id="usage_limit_per_user" class="form-control" min="1" placeholder="e.g. 1 (or leave empty)">
                        <small style="color: #888;">How many times one customer can use</small>
                    </div>
                    <div class="form-group">
                        <label for="max_usage_limit" style="font-weight: 700; display: block; margin-bottom: 8px;">Total Usage Limit</label>
                        <input type="number" name="max_usage_limit" id="max_usage_limit" class="form-control" min="1" placeholder="e.g. 100 (or leave empty)">
                        <small style="color: #888;">Total times coupon can be used</small>
                    </div>
                </div>
            </div>

            <div style="background: #fce7f3; padding: 16px; border-radius: 10px;">
                <h3 style="margin: 0 0 16px; font-size: 14px; color: #be185d; font-weight: 700;">⭐ Homepage Promotion</h3>
                
                <div class="form-group">
                    <label for="featured_product_id" style="font-weight: 700; display: block; margin-bottom: 8px;">Featured Product</label>
                    <select name="featured_product_id" id="featured_product_id" class="form-control">
                        <option value="">— Select a product to feature —</option>
                        @foreach($products ?? [] as $p)
                            <option value="{{ $p->id }}">{{ $p->product_name }} (₱{{ number_format($p->price, 0) }})</option>
                        @endforeach
                    </select>
                    <small style="color: #888;">Show this product with the coupon on homepage</small>
                </div>

                <div class="form-group" style="margin-top: 12px;">
                    <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-weight: 600;">
                        <input type="checkbox" name="show_on_homepage" id="show_on_homepage" value="1" style="width: 20px; height: 20px;">
                        <span>📍 Show this coupon on homepage</span>
                    </label>
                </div>
            </div>

            <div class="modal-footer" style="padding-top: 20px; border-top: 2px solid #f3f4f6; margin-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn-secondary" data-modal-close="coupon-modal">Cancel</button>
                <button type="submit" id="couponSubmitBtn" class="btn-primary">Save Coupon</button>
            </div>
        </form>
    </div>
</div>

<!-- Sales Modal -->
<div class="modal-backdrop" data-modal-id="sales-modal"></div>
<div id="sales-modal" class="modal" style="max-width: 600px; width: 95%;">
    <div class="modal-header">
        <h2 id="salesModalTitle" class="modal-title">Add Product to Sale</h2>
        <button type="button" class="modal-close" onclick="closeSalesModal()">&times;</button>
    </div>
    <div class="modal-body">
        <form method="POST" action="{{ route('products.storeSale') }}">
            @csrf
            <div id="salesMethodContainer"></div>
            <div class="form-group" style="margin-bottom: 16px;">
                <label for="sale_product_id" style="font-weight: 700; display: block; margin-bottom: 8px;">Select Product *</label>
                <select name="product_id" id="sale_product_id" class="form-control" required>
                    <option value="">— Select a product —</option>
                    @foreach($products ?? [] as $p)
                        <option value="{{ $p->id }}">{{ $p->product_name }} (₱{{ number_format($p->price, 0) }})</option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group">
                    <label for="sale_discount_type" style="font-weight: 700; display: block; margin-bottom: 8px;">Discount Type *</label>
                    <select name="discount_type" id="sale_discount_type" class="form-control" required>
                        <option value="percent">Percentage (%)</option>
                        <option value="fixed">Fixed Amount (₱)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sale_discount_amount" style="font-weight: 700; display: block; margin-bottom: 8px;">Discount Amount *</label>
                    <input type="number" name="discount_amount" id="sale_discount_amount" class="form-control" step="0.01" min="0" required placeholder="e.g. 20">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group">
                    <label for="sale_valid_from" style="font-weight: 700; display: block; margin-bottom: 8px;">Valid From *</label>
                    <input type="datetime-local" name="valid_from" id="sale_valid_from" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="sale_valid_until" style="font-weight: 700; display: block; margin-bottom: 8px;">Valid Until *</label>
                    <input type="datetime-local" name="valid_until" id="sale_valid_until" class="form-control" required>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 24px; padding: 12px; background: #fef3c7; border-radius: 8px; border: 1px solid #fde68a;">
                <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-weight: 600; color: #b45309;">
                    <input type="checkbox" name="is_featured" value="1" style="width: 20px; height: 20px; cursor: pointer;">
                    <span>⭐ Feature on Homepage</span>
                </label>
                <div style="margin-top: 4px; font-size: 13px; color: #d97706; padding-left: 32px;">
                    This will showcase the sale product on the right side of the popular products section.
                </div>
            </div>
            
            <div class="modal-footer" style="padding-top: 20px; border-top: 1px solid #f3f4f6; margin-top: 20px; display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" class="btn-secondary" onclick="closeSalesModal()">Cancel</button>
                <button type="submit" class="btn-primary">Save Sale Product</button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
function switchTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
    document.querySelectorAll('[id^="tab-"]').forEach(el => el.classList.remove('active'));
    
    document.getElementById('tab-content-' + tab).style.display = 'block';
    document.getElementById('tab-' + tab).classList.add('active');
}

function openCouponModal(mode, data = null) {
    const modal = document.getElementById('coupon-modal');
    const backdrop = document.querySelector('.modal-backdrop[data-modal-id="coupon-modal"]');
    const form = document.getElementById('couponModalForm');
    const title = document.getElementById('couponModalTitle');
    const submitBtn = document.getElementById('couponSubmitBtn');
    const methodContainer = document.getElementById('couponMethodContainer');

    form.reset();

    if (mode === 'add') {
        title.textContent = '➕ Add New Coupon';
        submitBtn.textContent = 'Save Coupon';
        form.action = "{{ route('coupons.store') }}";
        methodContainer.innerHTML = '';
    } else if (mode === 'edit' && data) {
        title.textContent = '✏️ Edit Coupon';
        submitBtn.textContent = 'Save Changes';
        form.action = `/admin/coupons/${data.id}`;
        methodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('coupon_code').value = data.coupon_code || '';
        document.getElementById('coupon_name').value = data.coupon_name || '';
        document.getElementById('coupon_description').value = data.description || '';
        document.getElementById('discount_type').value = data.discount_type || 'percent';
        document.getElementById('discount_amount').value = data.discount_amount || '';
        document.getElementById('valid_from').value = data.valid_from || '';
        document.getElementById('valid_until').value = data.valid_until || '';
        document.getElementById('min_order_value').value = data.min_order_value || '';
        document.getElementById('usage_limit_per_user').value = data.usage_limit_per_user || '';
        document.getElementById('max_usage_limit').value = data.max_usage_limit || '';
        document.getElementById('featured_product_id').value = data.featured_product_id || '';
        document.getElementById('show_on_homepage').checked = !!data.show_on_homepage;
    }

    modal.classList.add('open');
    backdrop.classList.add('open');
}

function openSalesModal(mode = 'add', data = null) {
    const modal = document.getElementById('sales-modal');
    const backdrop = document.querySelector('.modal-backdrop[data-modal-id="sales-modal"]');
    const title = document.getElementById('salesModalTitle');
    const form = modal.querySelector('form');
    const methodContainer = document.getElementById('salesMethodContainer');
    const productSelect = document.getElementById('sale_product_id');

    // Reset form
    form.reset();
    methodContainer.innerHTML = '';
    form.action = "{{ route('products.storeSale') }}";
    if (productSelect) productSelect.disabled = false;

    if (mode === 'edit' && data) {
        title.textContent = 'Edit Sale';
        // Pre-fill fields
        if (productSelect) {
            productSelect.value = data.product_id;
            productSelect.disabled = true;
        }
        // Add a hidden input so the disabled select value still submits
        methodContainer.innerHTML = '<input type="hidden" name="product_id" value="' + data.product_id + '">';
        document.getElementById('sale_discount_type').value = data.discount_type || 'percent';
        document.getElementById('sale_discount_amount').value = data.discount_amount || '';
        document.getElementById('sale_valid_from').value = data.valid_from || '';
        document.getElementById('sale_valid_until').value = data.valid_until || '';
        const featuredCheckbox = form.querySelector('input[name="is_featured"]');
        if (featuredCheckbox) featuredCheckbox.checked = !!data.is_featured;
    } else {
        title.textContent = 'Add Product to Sale';
    }

    if (modal && backdrop) {
        modal.classList.add('open');
        backdrop.classList.add('open');
    }
}

function closeSalesModal() {
    const modal = document.getElementById('sales-modal');
    const backdrop = document.querySelector('.modal-backdrop[data-modal-id="sales-modal"]');
    
    if (modal && backdrop) {
        modal.classList.remove('open');
        backdrop.classList.remove('open');
    }
}

// Modal backdrop close functionality
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-backdrop') && e.target.classList.contains('open')) {
        const modalId = e.target.getAttribute('data-modal-id');
        if (modalId === 'sales-modal') {
            closeSalesModal();
        }
    }
});
</script>
@endpush
