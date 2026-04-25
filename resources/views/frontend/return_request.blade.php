@extends('frontend.layouts.app')
@section('title', 'Request Return - Pet Markt-PH')

@push('styles')
<style>
.rr-page { max-width: 600px; margin: 0 auto; padding: 32px 20px 60px; }
.rr-heading { font-size: 24px; font-weight: 800; color: #1a1a2e; margin-bottom: 24px; }
.rr-heading span { color: var(--ud-orange); }
.rr-product { display: flex; gap: 16px; align-items: center; background: #f9fafb; border-radius: 12px; padding: 16px; margin-bottom: 24px; }
.rr-product img { width: 80px; height: 80px; border-radius: 8px; object-fit: cover; }
.rr-form .form-group { margin-bottom: 16px; }
.rr-form label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 14px; color: #333; }
.rr-form .form-control { width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; }
.rr-form select.form-control { appearance: auto; }
.rr-form .form-control:focus { border-color: var(--ud-orange); outline: none; box-shadow: 0 0 0 3px rgba(232,93,4,0.1); }
.rr-btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; border: none; }
.rr-btn-primary { background: var(--ud-orange); color: #fff; }
.rr-btn-primary:hover { background: #d14f00; }
.rr-btn-secondary { background: #fff; color: #666; border: 1px solid #ddd; text-decoration: none; }
</style>
@endpush

@section('content')
<div class="rr-page">
    <h1 class="rr-heading">Request a <span>Return</span></h1>

    <div class="rr-product">
        @if($orderItem->product)
            <img src="{{ $orderItem->product->image_url }}" alt="">
        @endif
        <div>
            <div style="font-weight: 700; color: #333;">{{ $orderItem->product->product_name ?? 'Product' }}</div>
            <div style="font-size: 13px; color: #888;">Qty: {{ $orderItem->quantity }} · ₱{{ number_format($orderItem->total_amount, 2) }}</div>
            <div style="font-size: 12px; color: #999;">Order {{ $orderItem->order->order_id }}</div>
        </div>
    </div>

    <form class="rr-form" method="POST" action="{{ route('returns.store') }}">
        @csrf
        <input type="hidden" name="order_item_id" value="{{ $orderItem->id }}">

        <div class="form-group">
            <label>Return Type *</label>
            <select name="return_type" class="form-control" required>
                <option value="refund">Refund</option>
                <option value="replacement">Replacement</option>
            </select>
        </div>

        <div class="form-group">
            <label>Reason *</label>
            <select name="return_reason" class="form-control" required>
                <option value="">Select a reason...</option>
                <option value="Defective/Damaged">Defective or Damaged</option>
                <option value="Wrong Item">Wrong Item Received</option>
                <option value="Not as Described">Not as Described</option>
                <option value="Changed Mind">Changed My Mind</option>
                <option value="Better Price Found">Found a Better Price</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="form-group">
            <label>Additional Details</label>
            <textarea name="return_reason_description" class="form-control" rows="4" placeholder="Please describe the issue in detail..."></textarea>
        </div>

        @if($errors->any())
            <div style="background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <a href="{{ route('orders') }}" class="rr-btn rr-btn-secondary">Cancel</a>
            <button type="submit" class="rr-btn rr-btn-primary">Submit Return Request</button>
        </div>
    </form>
</div>
@endsection
