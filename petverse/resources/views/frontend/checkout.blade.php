@extends('frontend.layouts.app')

@section('title', 'Checkout - Pet Animixon')

@push('styles')
<style>
    .checkout-page { max-width: 900px; margin: 40px auto; padding: 0 20px; }
    .checkout-layout { display: grid; grid-template-columns: 1fr 350px; gap: 30px; }
    .checkout-section { background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px; }
    .section-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-size: 14px; font-weight: 600; }
    .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; }
    .summary-item { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; }
    .summary-total { border-top: 2px solid #eee; padding-top: 15px; margin-top: 15px; font-weight: 700; font-size: 18px; color: #FF8C42; }
    .btn-place-order { width: 100%; padding: 15px; background: #FF8C42; color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 16px; cursor: pointer; margin-top: 20px; }
    .address-card { border: 1px solid #ddd; padding: 15px; border-radius: 8px; margin-bottom: 10px; cursor: pointer; position: relative; }
    .address-card.selected { border-color: #FF8C42; background: #fffaf7; }
    .address-card input { position: absolute; top: 15px; right: 15px; }
    @media (max-width: 768px) {
        .checkout-layout { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="checkout-page">
    <h1>Checkout</h1>
    
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="checkout-layout">
            <div class="checkout-main">
                <div class="checkout-section">
                    <h2 class="section-title">Shipping Address</h2>
                    
                    @if($addresses->isNotEmpty())
                        <div class="saved-addresses">
                            @foreach($addresses as $address)
                                <div class="address-card @if($loop->first) selected @endif">
                                    <input type="radio" name="shipping_address_id" value="{{ $address->id }}" @if($loop->first) checked @endif onclick="toggleNewAddress(false)">
                                    <strong>{{ $address->recipient_name }}</strong><br>
                                    {{ $address->phone_number }}<br>
                                    {{ $address->street_address }}, {{ $address->city_municipality }}, {{ $address->province }}, {{ $address->zip_code }}
                                </div>
                            @endforeach
                            <div class="address-card" onclick="toggleNewAddress(true)">
                                <input type="radio" name="shipping_address_id" value="" id="use_new_address" onclick="toggleNewAddress(true)">
                                <strong>Use a new address</strong>
                            </div>
                        </div>
                    @endif

                    <div id="new_address_form" @if($addresses->isNotEmpty()) style="display:none;" @endif>
                        <h3 style="font-size: 16px; margin: 20px 0 10px;">New Shipping Address</h3>
                        <div class="form-group">
                            <label>Recipient Name*</label>
                            <input type="text" name="new_address[recipient_name]" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Phone Number*</label>
                            <input type="text" name="new_address[phone_number]" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Street Address*</label>
                            <input type="text" name="new_address[street_address]" class="form-control">
                        </div>
                        <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div class="form-group">
                                <label>City/Municipality*</label>
                                <input type="text" name="new_address[city_municipality]" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Province*</label>
                                <input type="text" name="new_address[province]" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Zip Code*</label>
                            <input type="text" name="new_address[zip_code]" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="checkout-section">
                    <h2 class="section-title">Payment Method</h2>
                    <div class="form-group">
                        <label>
                            <input type="radio" name="payment_method" value="cod" checked> Cash on Delivery (COD)
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="radio" name="payment_method" value="gcash"> GCash
                        </label>
                    </div>
                </div>
            </div>

            <div class="checkout-sidebar">
                <div class="checkout-section">
                    <h2 class="section-title">Order Summary</h2>
                    @foreach($cart->items as $item)
                        <div class="summary-item">
                            <span>{{ $item->product->product_name }} (x{{ $item->quantity }})</span>
                            <span>₱{{ number_format($item->subtotal, 2) }}</span>
                        </div>
                    @endforeach
                    <div class="summary-item" style="margin-top: 20px;">
                        <span>Subtotal</span>
                        <span>₱{{ number_format($cart->items->sum('subtotal'), 2) }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Shipping</span>
                        <span style="color: #3DB868; font-weight: 700;">FREE</span>
                    </div>
                    <div class="summary-total">
                        <span>Total</span>
                        <span>₱{{ number_format($cart->items->sum('subtotal'), 2) }}</span>
                    </div>

                    <button type="submit" class="btn-place-order">Place Order</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function toggleNewAddress(show) {
        const form = document.getElementById('new_address_form');
        form.style.display = show ? 'block' : 'none';
        
        // Handle visual selection
        document.querySelectorAll('.address-card').forEach(card => {
            card.classList.remove('selected');
        });
        
        if (show) {
            document.getElementById('use_new_address').checked = true;
            document.getElementById('use_new_address').parentElement.classList.add('selected');
        } else {
            event.target.parentElement.classList.add('selected');
        }
    }
</script>
@endsection
