@extends('frontend.layouts.app')

@section('title', 'Order Success - Pet Animixon')

@section('content')
<div class="checkout-page" style="text-align: center; max-width: 600px; margin: 100px auto;">
    <div style="font-size: 64px; color: #3DB868; margin-bottom: 20px;">✅</div>
    <h1>Thank You for Your Order!</h1>
    <p>Your order <strong>{{ $order->order_id }}</strong> has been placed successfully.</p>
    <p>We've sent a confirmation email to {{ $order->user->email }}.</p>
    
    <div style="margin-top: 40px; background: #f9f9f9; padding: 20px; border-radius: 12px; text-align: left;">
        <h3 style="margin-top: 0;">Order Summary</h3>
        <p><strong>Total Amount:</strong> ₱{{ number_format($order->total_amount, 2) }}</p>
        <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->order_status) }}</p>
    </div>

    <div style="margin-top: 40px; display: flex; gap: 20px; justify-content: center;">
        <a href="{{ route('orders') }}" class="ud-btn ud-btn-primary" style="text-decoration: none;">View My Orders</a>
        <a href="{{ route('shop.all') }}" class="ud-btn ud-btn-outline" style="text-decoration: none;">Continue Shopping</a>
    </div>
</div>
@endsection
