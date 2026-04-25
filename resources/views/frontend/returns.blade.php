@extends('frontend.layouts.app')
@section('title', 'My Returns - Pet Markt-PH')

@push('styles')
<style>
.rt-page { width: 100%; padding: 32px 2rem 60px; }
.rt-header { margin-bottom: 28px; }
.rt-heading { font-size: 28px; font-weight: 800; color: #1a1a2e; }
.rt-heading span { color: var(--ud-orange); }
.rt-subtitle { font-size: 14px; color: #888; margin-top: 4px; }
.rt-list { display: flex; flex-direction: column; gap: 16px; }
.rt-card {
    background: #fff; border: 1px solid #eee; border-radius: 14px; padding: 20px 24px;
    transition: all 0.2s;
}
.rt-card:hover { border-color: var(--ud-orange); box-shadow: 0 6px 20px rgba(232,93,4,0.07); }
.rt-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 8px; }
.rt-id { font-weight: 700; font-size: 14px; color: var(--ud-orange); font-family: monospace; }
.rt-date { font-size: 13px; color: #999; }
.rt-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; }
.rt-badge.pending { background: #fef3c7; color: #d97706; }
.rt-badge.approved { background: #dcfce7; color: #16a34a; }
.rt-badge.rejected { background: #fee2e2; color: #dc2626; }
.rt-details { display: flex; gap: 16px; align-items: center; }
.rt-img { width: 60px; height: 60px; border-radius: 8px; object-fit: cover; background: #f5f5f5; }
.rt-product { font-weight: 600; color: #333; }
.rt-reason { font-size: 13px; color: #666; margin-top: 4px; }
.rt-amount { font-size: 18px; font-weight: 800; color: #1a1a2e; }
.rt-empty { text-align: center; padding: 60px 20px; background: #fff; border: 1px dashed #ddd; border-radius: 14px; }
@media (max-width: 768px) {
    .rt-page { padding: 20px 14px 40px; }
    .rt-card { padding: 16px; }
}
</style>
@endpush

@section('content')
<div class="rt-page">
    <div class="rt-header">
        <h1 class="rt-heading">My <span>Returns</span></h1>
        <p class="rt-subtitle">Track your return and refund requests</p>
    </div>

    @if($returns->isEmpty())
        <div class="rt-empty">
            <div style="font-size: 56px; margin-bottom: 16px;">📦</div>
            <div style="font-size: 20px; font-weight: 700; color: #333; margin-bottom: 8px;">No return requests</div>
            <div style="font-size: 14px; color: #999;">You haven't submitted any return requests yet.</div>
        </div>
    @else
        <div class="rt-list">
            @foreach($returns as $return)
            <div class="rt-card">
                <div class="rt-top">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <span class="rt-id">{{ $return->return_refund_id }}</span>
                        <span class="rt-date">{{ $return->created_at->format('M j, Y') }}</span>
                    </div>
                    <span class="rt-badge {{ $return->refund_status }}">{{ ucfirst($return->refund_status) }}</span>
                </div>
                <div class="rt-details">
                    @if($return->orderItem && $return->orderItem->product)
                        <img src="{{ $return->orderItem->product->image_url }}" alt="" class="rt-img">
                    @endif
                    <div style="flex: 1;">
                        <div class="rt-product">{{ optional(optional($return->orderItem)->product)->product_name ?? 'Product' }}</div>
                        <div class="rt-reason">{{ $return->return_reason }} · {{ ucfirst($return->return_type) }}</div>
                        @if($return->return_reason_description)
                            <div style="font-size: 12px; color: #888; margin-top: 4px;">{{ Str::limit($return->return_reason_description, 120) }}</div>
                        @endif
                    </div>
                    <div class="rt-amount">₱{{ number_format((float)$return->refund_amount, 2) }}</div>
                </div>
                @if($return->admin_notes)
                    <div style="margin-top: 12px; padding: 10px; background: #f9fafb; border-radius: 8px; font-size: 13px; color: #666;">
                        <strong>Admin Note:</strong> {{ $return->admin_notes }}
                    </div>
                @endif
            </div>
            @endforeach
        </div>
        @if($returns->hasPages())
            <div style="margin-top: 28px; display: flex; justify-content: center;">{{ $returns->links() }}</div>
        @endif
    @endif
</div>
@endsection
