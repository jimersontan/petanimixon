@extends('frontend.layouts.app')

@section('title', 'Checkout - Pet Animixon')

@section('content')
<div style="max-width: 1000px; margin: 0 auto; padding: 40px 20px;">
    <!-- Header -->
    <div style="margin-bottom: 40px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
            <svg style="width: 24px; height: 24px; color: var(--ud-orange, #FF8C42);" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
            </svg>
            <h1 style="font-size: 24px; color: #333; margin: 0; font-weight: 700;">Secure Checkout</h1>
        </div>
        <p style="font-size: 14px; color: #666; margin: 0;">Your information is safe and encrypted</p>
    </div>

    <!-- Progress Steps -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 50px; padding: 0 20px;">
        <!-- Step 1 -->
        <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
            <div style="width: 40px; height: 40px; background-color: var(--ud-orange, #FF8C42); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 18px;">1</div>
            <span style="font-size: 12px; color: #666; font-weight: 600;">Shipping</span>
        </div>

        <!-- Line 1 -->
        <div style="flex: 1; height: 2px; background-color: var(--ud-orange, #FF8C42); margin: 0 10px 20px 10px;"></div>

        <!-- Step 2 -->
        <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
            <div style="width: 40px; height: 40px; background-color: var(--ud-orange, #FF8C42); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 18px;">2</div>
            <span style="font-size: 12px; color: #666; font-weight: 600;">Payment</span>
        </div>

        <!-- Line 2 -->
        <div style="flex: 1; height: 2px; background-color: #ddd; margin: 0 10px 20px 10px;"></div>

        <!-- Step 3 -->
        <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
            <div style="width: 40px; height: 40px; background-color: #ddd; color: #999; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 18px;">3</div>
            <span style="font-size: 12px; color: #999; font-weight: 600;">Review</span>
        </div>
    </div>

    <!-- Login Section -->
    <div style="background: white; border-radius: 8px; padding: 25px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 16px; color: #333; margin: 0; font-weight: 600;">Contact Information</h2>
            <a href="{{ route('login') }}" style="font-size: 14px; color: var(--ud-orange, #FF8C42); text-decoration: none; font-weight: 600; cursor: pointer;">Log in</a>
        </div>
        
        <div style="margin-top: 20px;">
            <div style="margin-bottom: 15px;">
                <label style="font-size: 14px; color: #333; font-weight: 600; display: block; margin-bottom: 8px;">Email Address *</label>
                <div style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; background-color: white;">
                    <span style="font-size: 16px; color: #666;">📧</span>
                    <input type="email" placeholder="your@email.com" style="flex: 1; border: none; outline: none; font-size: 14px; background: transparent;" required>
                </div>
            </div>

            <label style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: #666; cursor: pointer;">
                <input type="checkbox" style="width: 16px; height: 16px; cursor: pointer;">
                <span>Email me with news, offers, and updates tips *</span>
            </label>
        </div>
    </div>

    <!-- Shipping Address -->
    <div style="background: white; border-radius: 8px; padding: 25px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <h2 style="font-size: 16px; color: #333; margin: 0 0 20px 0; font-weight: 600;">Shipping Address</h2>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
            <div>
                <label style="font-size: 12px; color: #333; font-weight: 600; display: block; margin-bottom: 6px;">First Name *</label>
                <input type="text" placeholder="John" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box;" required>
            </div>
            <div>
                <label style="font-size: 12px; color: #333; font-weight: 600; display: block; margin-bottom: 6px;">Last Name *</label>
                <input type="text" placeholder="Doe" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box;" required>
            </div>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-size: 12px; color: #333; font-weight: 600; display: block; margin-bottom: 6px;">Address Line 1 *</label>
            <div style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px;">
                <span style="font-size: 14px;">📍</span>
                <input type="text" placeholder="Street address, P.O. box" style="flex: 1; border: none; outline: none; font-size: 14px; background: transparent;" required>
            </div>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-size: 12px; color: #333; font-weight: 600; display: block; margin-bottom: 6px;">Address Line 2</label>
            <input type="text" placeholder="Apartment, suite, unit, building, floor, etc." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
            <div>
                <label style="font-size: 12px; color: #333; font-weight: 600; display: block; margin-bottom: 6px;">City *</label>
                <input type="text" placeholder="Quezon City" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box;" required>
            </div>
            <div>
                <label style="font-size: 12px; color: #333; font-weight: 600; display: block; margin-bottom: 6px;">State *</label>
                <select style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box; background-color: white;" required>
                    <option>Mindanao</option>
                    <option>Luzon</option>
                    <option>Visayas</option>
                </select>
            </div>
            <div>
                <label style="font-size: 12px; color: #333; font-weight: 600; display: block; margin-bottom: 6px;">ZIP *</label>
                <input type="text" placeholder="8600" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box;" required>
            </div>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-size: 12px; color: #333; font-weight: 600; display: block; margin-bottom: 6px;">Country *</label>
            <select style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box; background-color: white;" required>
                <option>Philippines</option>
                <option>Other</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-size: 12px; color: #333; font-weight: 600; display: block; margin-bottom: 6px;">Phone Number *</label>
            <div style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px;">
                <span style="font-size: 14px;">📱</span>
                <input type="tel" placeholder="+639*29382923" style="flex: 1; border: none; outline: none; font-size: 14px; background: transparent;" required>
            </div>
        </div>

        <label style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: #666; cursor: pointer;">
            <input type="checkbox" style="width: 16px; height: 16px; cursor: pointer;">
            <span>Save this address living my account for future orders</span>
        </label>
    </div>

    <!-- Shipping Method -->
    <div style="background: white; border-radius: 8px; padding: 25px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <h2 style="font-size: 16px; color: #333; margin: 0 0 20px 0; font-weight: 600;">Shipping Method</h2>

        <!-- Option 1 -->
        <div style="border: 2px solid var(--ud-orange, #FF8C42); border-radius: 8px; padding: 15px; margin-bottom: 12px; cursor: pointer; background-color: #fff9f5;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <input type="radio" name="shipping" checked style="width: 18px; height: 18px; cursor: pointer;">
                    <div>
                        <p style="margin: 0 0 4px 0; font-weight: 600; font-size: 14px; color: #333;">🚚 Free Shipping</p>
                        <p style="margin: 0; font-size: 12px; color: #999;">5-7 business days</p>
                    </div>
                </div>
                <span style="font-weight: 700; color: #4CAF50; font-size: 14px;">FREE</span>
            </div>
            <span style="font-size: 11px; color: #4CAF50; margin-left: 40px;">Up to Feb 5, 2025</span>
        </div>

        <!-- Option 2 -->
        <div style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; margin-bottom: 12px; cursor: pointer;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <input type="radio" name="shipping" style="width: 18px; height: 18px; cursor: pointer;">
                    <div>
                        <p style="margin: 0 0 4px 0; font-weight: 600; font-size: 14px; color: #333;">📦 Standard Shipping</p>
                        <p style="margin: 0; font-size: 12px; color: #999;">3-5 business days</p>
                    </div>
                </div>
                <span style="font-weight: 700; color: var(--ud-orange, #FF8C42); font-size: 14px;">₱300</span>
            </div>
        </div>

        <!-- Option 3 -->
        <div style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; margin-bottom: 12px; cursor: pointer;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <input type="radio" name="shipping" style="width: 18px; height: 18px; cursor: pointer;">
                    <div>
                        <p style="margin: 0 0 4px 0; font-weight: 600; font-size: 14px; color: #333;">⚡ Express Shipping</p>
                        <p style="margin: 0; font-size: 12px; color: #999;">2-3 business days</p>
                    </div>
                </div>
                <span style="font-weight: 700; color: var(--ud-orange, #FF8C42); font-size: 14px;">₱200</span>
            </div>
        </div>

        <!-- Option 4 -->
        <div style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; cursor: pointer;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <input type="radio" name="shipping" style="width: 18px; height: 18px; cursor: pointer;">
                    <div>
                        <p style="margin: 0 0 4px 0; font-weight: 600; font-size: 14px; color: #333;">🐾 Overnight Shipping</p>
                        <p style="margin: 0; font-size: 12px; color: #999;">Next business day</p>
                    </div>
                </div>
                <span style="font-weight: 700; color: var(--ud-orange, #FF8C42); font-size: 14px;">₱200</span>
            </div>
        </div>

        <div style="background-color: #fffbf0; border-radius: 6px; padding: 12px 15px; margin-top: 15px; font-size: 12px; color: #666;">
            <strong>📦 Estimated delivery: </strong>February 5-7 2025
        </div>
    </div>

    <!-- Payment Method -->
    <div style="background: white; border-radius: 8px; padding: 25px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <h2 style="font-size: 16px; color: #333; margin: 0 0 20px 0; font-weight: 600;">Payment Method</h2>

        <!-- Payment Options -->
        <div style="display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap;">
            <button style="padding: 10px 20px; background-color: var(--ud-orange, #FF8C42); color: white; border: none; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer;">💳 Credit/Debit Card</button>
            <button style="padding: 10px 20px; background-color: white; color: #333; border: 1px solid #ddd; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.3s;">💳 PayPal</button>
            <button style="padding: 10px 20px; background-color: white; color: #333; border: 1px solid #ddd; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.3s;">🍎 Apple Pay</button>
            <button style="padding: 10px 20px; background-color: white; color: #333; border: 1px solid #ddd; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.3s;">🔵 Google Pay</button>
        </div>

        <!-- Card Details -->
        <div style="margin-bottom: 15px;">
            <label style="font-size: 12px; color: #333; font-weight: 600; display: block; margin-bottom: 6px;">Card number *</label>
            <div style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px;">
                <span style="font-size: 14px;">💳</span>
                <input type="text" placeholder="1234 5678 9012 3456" style="flex: 1; border: none; outline: none; font-size: 14px; background: transparent;" required>
                <span style="color: #4169E1; font-size: 12px; font-weight: 600;">Visa</span>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
            <div>
                <label style="font-size: 12px; color: #333; font-weight: 600; display: block; margin-bottom: 6px;">Name on Card *</label>
                <div style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px;">
                    <span style="font-size: 14px;">👤</span>
                    <input type="text" placeholder="John Doe" style="flex: 1; border: none; outline: none; font-size: 14px; background: transparent;" required>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div>
                    <label style="font-size: 12px; color: #333; font-weight: 600; display: block; margin-bottom: 6px;">Expiration Date *</label>
                    <div style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px;">
                        <span style="font-size: 14px;">📅</span>
                        <input type="text" placeholder="MM / YY" style="flex: 1; border: none; outline: none; font-size: 14px; background: transparent;" required>
                    </div>
                </div>
                <div>
                    <label style="font-size: 12px; color: #333; font-weight: 600; display: block; margin-bottom: 6px;">CVV *</label>
                    <div style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px;">
                        <span style="font-size: 14px;">🔒</span>
                        <input type="text" placeholder="123" style="flex: 1; border: none; outline: none; font-size: 14px; background: transparent;" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Info -->
        <div style="background-color: #f0f0f0; border-radius: 6px; padding: 12px 15px; display: flex; align-items: center; gap: 10px; font-size: 12px; color: #666; margin-bottom: 15px;">
            <span>🔒</span>
            <span>Encrypted</span>
            <span style="margin-left: auto;">Never Saved</span>
            <span>🛡️Compliant</span>
        </div>

        <!-- Checkboxes -->
        <label style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: #333; cursor: pointer; margin-bottom: 10px;">
            <input type="checkbox" checked style="width: 16px; height: 16px; cursor: pointer;">
            <span>Billing address is same as shipping</span>
        </label>

        <label style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: #333; cursor: pointer;">
            <input type="checkbox" style="width: 16px; height: 16px; cursor: pointer;">
            <span>Save this payment method for future purchases</span>
        </label>
    </div>

    <!-- Review Section -->
    <div style="background: white; border-radius: 8px; padding: 25px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <h2 style="font-size: 16px; color: #333; margin: 0 0 20px 0; font-weight: 600;">Review Your Order</h2>

        <!-- Shipping Address Review -->
        <div style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h3 style="font-size: 13px; color: #999; margin: 0 0 8px 0; font-weight: 600;">🏠 Shipping Address</h3>
                    <p style="margin: 0; font-size: 14px; color: #333;">John Doe<br>P.O. Box 123<br>Quezon City, Mindanao 8600<br>Philippines</p>
                </div>
                <a href="#" style="font-size: 12px; color: var(--ud-orange, #FF8C42); text-decoration: none; font-weight: 600; cursor: pointer;">Edit</a>
            </div>
        </div>

        <!-- Shipping Method Review -->
        <div style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h3 style="font-size: 13px; color: #999; margin: 0 0 8px 0; font-weight: 600;">📦 Shipping Method</h3>
                    <p style="margin: 0; font-size: 14px; color: #333;">Free Shipping<br>Estimated delivery: 5-7 business days</p>
                </div>
                <a href="#" style="font-size: 12px; color: var(--ud-orange, #FF8C42); text-decoration: none; font-weight: 600; cursor: pointer;">Edit</a>
            </div>
        </div>

        <!-- Payment Method Review -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h3 style="font-size: 13px; color: #999; margin: 0 0 8px 0; font-weight: 600;">💳 Payment Method</h3>
                    <p style="margin: 0; font-size: 14px; color: #333;">Visa ending in 3456</p>
                </div>
                <a href="#" style="font-size: 12px; color: var(--ud-orange, #FF8C42); text-decoration: none; font-weight: 600; cursor: pointer;">Edit</a>
            </div>
        </div>
    </div>

    <!-- Terms and Order Button -->
    <div style="background: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <label style="display: flex; align-items: flex-start; gap: 10px; font-size: 12px; color: #333; cursor: pointer; margin-bottom: 20px;">
            <input type="checkbox" required style="width: 16px; height: 16px; cursor: pointer; margin-top: 2px;">
            <span>I understand and accept the <a href="#" style="color: var(--ud-orange, #FF8C42); text-decoration: none;">Terms & Conditions</a>, <a href="#" style="color: var(--ud-orange, #FF8C42); text-decoration: none;">Privacy Policy</a>, and <a href="#" style="color: var(--ud-orange, #FF8C42); text-decoration: none;">Return Policy</a></span>
        </label>

        <button style="width: 100%; padding: 14px; background-color: var(--ud-orange, #FF8C42); color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: 700; cursor: pointer; transition: background-color 0.3s;">Complete Purchase</button>
    </div>
</div>

<style>
    input:focus, select:focus, textarea:focus {
        outline: none;
        border-color: var(--ud-orange, #FF8C42) !important;
        box-shadow: 0 0 0 2px rgba(255, 140, 66, 0.1);
    }

    button:hover {
        opacity: 0.95;
    }
</style>
@endsection
