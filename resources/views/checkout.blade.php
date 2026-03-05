<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout - Pet Animixon</title>
    <link rel="stylesheet" href="{{ asset('css/shop_shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
@auth
@include('partials.shop_nav')

<div class="ck-wrap">
    <div class="ck-container">
        <!-- Header -->
        <div class="ck-header">
            <h1><span class="ck-shield">🔒</span> Secure Checkout</h1>
            <p class="ck-sub">Your payment information is encrypted and secure</p>
        </div>

        <!-- Progress steps -->
        <div class="ck-steps">
            <div class="ck-step active">
                <div class="ck-step-circle">1</div>
                <span>Shipping</span>
            </div>
            <div class="ck-step-line active"></div>
            <div class="ck-step active">
                <div class="ck-step-circle">2</div>
                <span>Payment Method</span>
            </div>
            <div class="ck-step-line"></div>
            <div class="ck-step">
                <div class="ck-step-circle">3</div>
                <span>Review order</span>
            </div>
        </div>

        <div class="ck-layout">
            <div class="ck-main">

                <!-- Contact Info -->
                <div class="ck-card">
                    <h2 class="ck-card-title">Contact Information</h2>
                    <div class="ck-field-group">
                        <label>Email Address *</label>
                        <div class="ck-input-wrap">
                            <span class="ck-input-icon">📧</span>
                            <input type="email" placeholder="user@gmail.com" value="{{ Auth::user()->email ?? '' }}" class="ck-input">
                        </div>
                        <label class="ck-checkbox-label"><input type="checkbox"> Save for next time (connect to my account)</label>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="ck-card">
                    <h2 class="ck-card-title">Shipping Address</h2>
                    <div class="ck-row-2">
                        <div class="ck-field-group">
                            <label>First Name</label>
                            <div class="ck-input-wrap"><span class="ck-input-icon">👤</span><input type="text" placeholder="John" class="ck-input" value="{{ Auth::user()->first_name ?? '' }}"></div>
                        </div>
                        <div class="ck-field-group">
                            <label>Last Name</label>
                            <div class="ck-input-wrap"><span class="ck-input-icon">👤</span><input type="text" placeholder="One" class="ck-input" value="{{ Auth::user()->last_name ?? '' }}"></div>
                        </div>
                    </div>
                    <div class="ck-field-group">
                        <label>Address Line 1 *</label>
                        <div class="ck-input-wrap"><span class="ck-input-icon">📍</span><input type="text" placeholder="Street address, P.O. Box" class="ck-input"></div>
                    </div>
                    <div class="ck-field-group">
                        <label>Address Line 2</label>
                        <div class="ck-input-wrap"><span class="ck-input-icon">🏢</span><input type="text" placeholder="Apt, Suite, Unit, Building, Floor, etc." class="ck-input"></div>
                    </div>
                    <div class="ck-row-3">
                        <div class="ck-field-group">
                            <label>City*</label>
                            <input type="text" placeholder="Los Angeles" class="ck-input">
                        </div>
                        <div class="ck-field-group">
                            <label>State*</label>
                            <select class="ck-input"><option>CA</option><option>NY</option><option>TX</option></select>
                        </div>
                        <div class="ck-field-group">
                            <label>ZIP Code*</label>
                            <input type="text" placeholder="90210" class="ck-input">
                        </div>
                    </div>
                    <div class="ck-field-group">
                        <label>Country*</label>
                        <select class="ck-input"><option>United States</option><option>Philippines</option><option>Canada</option></select>
                    </div>
                    <div class="ck-field-group">
                        <label>Phone Number</label>
                        <div class="ck-input-wrap"><span class="ck-input-icon">📞</span><input type="tel" placeholder="+1 (555) 123-4567" class="ck-input"></div>
                    </div>
                    <label class="ck-checkbox-label"><input type="checkbox"> Ship to a different address for a present?</label>
                </div>

                <!-- Shipping Method -->
                <div class="ck-card">
                    <h2 class="ck-card-title">Shipping Method</h2>
                    @php
                    $methods = [
                        ['Free Shipping','FREE','Estimated delivery: Today','free', true],
                        ['Standard Shipping','₱5.99','3–5 business days','standard', false],
                        ['Express Shipping','₱12.99','2–3 business days','express', false],
                        ['Overnight Shipping','₱24.99','Next business day','overnight', false],
                    ];
                    @endphp
                    <div class="ck-ship-methods">
                        @foreach($methods as $m)
                        <label class="ck-ship-option {{ $m[4] ? 'selected' : '' }}">
                            <input type="radio" name="shipping" value="{{ $m[3] }}" {{ $m[4] ? 'checked' : '' }} onchange="ckSelectShip(this.closest('.ck-ship-option'))">
                            <div class="ck-ship-details">
                                <span class="ck-ship-name">{{ $m[0] }}</span>
                                <small class="ck-ship-eta">{{ $m[2] }}</small>
                            </div>
                            <span class="ck-ship-price {{ $m[3]==='free' ? 'ck-free' : '' }}">{{ $m[1] }}</span>
                        </label>
                        @endforeach
                    </div>
                    <div class="ck-date-note">📅 Estimated delivery: <strong>February 17, 2025</strong></div>
                </div>

                <!-- Payment Method -->
                <div class="ck-card">
                    <h2 class="ck-card-title">Payment Method</h2>
                    <div class="ck-pay-tabs">
                        <button class="ck-pay-tab active" onclick="ckPayTab(this,'ck-cc')">💳 Credit/Debit Card</button>
                        <button class="ck-pay-tab" onclick="ckPayTab(this,'ck-pp')">PayPal</button>
                        <button class="ck-pay-tab" onclick="ckPayTab(this,'ck-ap')">Apple Pay</button>
                        <button class="ck-pay-tab" onclick="ckPayTab(this,'ck-gp')">Google Pay</button>
                    </div>
                    <div id="ck-cc" class="ck-pay-panel active">
                        <div class="ck-field-group">
                            <label>Card Number *</label>
                            <div class="ck-input-wrap"><span class="ck-input-icon">💳</span><input type="text" placeholder="1234 5678 9012 3456" class="ck-input" maxlength="19"></div>
                        </div>
                        <div class="ck-field-group">
                            <label>Name on Card</label>
                            <div class="ck-input-wrap"><span class="ck-input-icon">👤</span><input type="text" placeholder="John One" class="ck-input"></div>
                        </div>
                        <div class="ck-row-2">
                            <div class="ck-field-group">
                                <label>Expiration Date *</label>
                                <input type="text" placeholder="MM/YY" class="ck-input">
                            </div>
                            <div class="ck-field-group">
                                <label>CVV *</label>
                                <div class="ck-input-wrap"><span class="ck-input-icon">🔒</span><input type="text" placeholder="123" class="ck-input" maxlength="4"></div>
                            </div>
                        </div>
                        <label class="ck-checkbox-label"><input type="checkbox"> Save this card for future purchases</label>
                        <div class="ck-secure-note">🔒 Your payment information is encrypted and protected</div>
                        <div class="ck-pay-icons-row">
                            <span class="sh-pay">VISA</span>
                            <span class="sh-pay">MC</span>
                            <span class="sh-pay">AMEX</span>
                            <span class="sh-pay">PP</span>
                        </div>
                    </div>
                    <div id="ck-pp" class="ck-pay-panel"><p style="padding:16px;color:#888;font-size:13px;">You will be redirected to PayPal to complete your purchase.</p></div>
                    <div id="ck-ap" class="ck-pay-panel"><p style="padding:16px;color:#888;font-size:13px;">Apple Pay will open on your device.</p></div>
                    <div id="ck-gp" class="ck-pay-panel"><p style="padding:16px;color:#888;font-size:13px;">Google Pay will open in a new window.</p></div>
                </div>

                <!-- Review Your Order -->
                <div class="ck-card">
                    <h2 class="ck-card-title">Review Your Order</h2>
                    <div class="ck-review-rows">
                        <div class="ck-review-row">
                            <div class="ck-review-label"><span class="ck-dot orange"></span> Shipping Address</div>
                            <div class="ck-review-val">123 Main Street, Apt 4B, Los Angeles, CA 90210</div>
                            <a href="#" class="ck-edit">Edit</a>
                        </div>
                        <div class="ck-review-row">
                            <div class="ck-review-label"><span class="ck-dot orange"></span> Shipping Method</div>
                            <div class="ck-review-val">Free Shipping – Estimated Feb 17, 2025</div>
                            <span class="ck-review-price">FREE</span>
                        </div>
                        <div class="ck-review-row">
                            <div class="ck-review-label"><span class="ck-dot orange"></span> Payment Method</div>
                            <div class="ck-review-val">Mastercard ending in 3791</div>
                            <a href="#" class="ck-edit">Edit</a>
                        </div>
                    </div>
                    <label class="ck-checkbox-label ck-terms">
                        <input type="checkbox">
                        I have read and agree to the <a href="#" style="color:#FF6B35">Terms & Conditions</a> and <a href="#" style="color:#FF6B35">Privacy Policy</a>
                    </label>
                    <button class="sh-btn-orange ck-place-btn">Place Order →</button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.shop_footer')

<script>
function ckSelectShip(el) {
    document.querySelectorAll('.ck-ship-option').forEach(o => o.classList.remove('selected'));
    el.classList.add('selected');
}
function ckPayTab(btn, panelId) {
    document.querySelectorAll('.ck-pay-tab').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.ck-pay-panel').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById(panelId)?.classList.add('active');
}
</script>
@else
<script>window.location.href='{{ route("login") }}';</script>
@endauth
</body>
</html>
