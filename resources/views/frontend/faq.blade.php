@extends('frontend.layouts.app')

@section('title', 'FAQ - Pet Animixon')

@push('styles')
<style>
    .faq-hero {
        background: linear-gradient(135deg, #fff5eb 0%, #ffe8d6 100%);
        padding: 50px 20px 60px;
        text-align: center;
        position: relative;
    }
    .faq-hero h1 { font-size: 38px; font-weight: 800; color: #222; margin: 0 0 10px; }
    .faq-hero p { font-size: 15px; color: #777; margin: 0; }
    .faq-hero-wave { position: absolute; bottom: -2px; left: 0; right: 0; height: 40px; background: #fafafa; clip-path: ellipse(55% 100% at 50% 100%); }

    .faq-container { max-width: 800px; margin: 40px auto; padding: 0 20px 60px; }

    .faq-category { margin-bottom: 36px; }
    .faq-category-title { font-size: 20px; font-weight: 700; color: #FF8C42; margin: 0 0 16px; display: flex; align-items: center; gap: 10px; }
    .faq-category-title svg { flex-shrink: 0; }

    .faq-item { background: #fff; border-radius: 12px; margin-bottom: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); overflow: hidden; }
    .faq-question {
        padding: 18px 20px;
        font-size: 15px; font-weight: 600; color: #333;
        cursor: pointer;
        display: flex; justify-content: space-between; align-items: center;
        transition: background 0.2s;
        border: none; background: none; width: 100%; text-align: left;
    }
    .faq-question:hover { background: #fff8f3; }
    .faq-question .arrow { font-size: 18px; color: #999; transition: transform 0.3s; flex-shrink: 0; }
    .faq-item.open .faq-question .arrow { transform: rotate(180deg); color: #FF8C42; }
    .faq-answer {
        max-height: 0; overflow: hidden;
        transition: max-height 0.35s ease, padding 0.35s ease;
        padding: 0 20px;
    }
    .faq-item.open .faq-answer {
        max-height: 300px;
        padding: 0 20px 18px;
    }
    .faq-answer p { margin: 0; font-size: 14px; color: #666; line-height: 1.7; }

    .faq-cta { text-align: center; margin-top: 50px; padding: 40px 20px; background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
    .faq-cta h3 { font-size: 22px; font-weight: 700; margin: 0 0 8px; color: #222; }
    .faq-cta p { font-size: 14px; color: #777; margin: 0 0 20px; }
    .faq-cta a {
        display: inline-block; padding: 12px 30px;
        background: #FF8C42; color: #fff; border-radius: 8px;
        text-decoration: none; font-weight: 700; font-size: 15px;
        transition: opacity 0.2s;
    }
    .faq-cta a:hover { opacity: 0.88; }

    @media (max-width: 768px) {
        .faq-hero { padding: 30px 16px 40px; }
        .faq-hero h1 { font-size: 26px; }
        .faq-hero-wave { height: 24px; }
        .faq-container { padding: 0 12px 40px; margin-top: 20px; }
        .faq-question { padding: 14px 16px; font-size: 14px; }
    }
</style>
@endpush

@section('content')
<div class="faq-hero">
    <div class="faq-hero-wave"></div>
    <h1>🐾 Frequently Asked Questions</h1>
    <p>Everything you need to know about shopping at Pet Animixon</p>
</div>

<div class="faq-container">
    {{-- Ordering --}}
    <div class="faq-category">
        <h2 class="faq-category-title">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M18.36 9l.6 3H5.04l.6-3h12.72M20 4H4v2h16V4zm0 3H4l-1 5v2h1v6h10v-6h4v6h2v-6h1v-2l-1-5zM6 18v-4h6v4H6z"/></svg>
            Ordering
        </h2>
        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">How do I place an order? <span class="arrow">▾</span></button>
            <div class="faq-answer"><p>Browse our shop, add items to your cart, and proceed to checkout. You can choose your shipping address and payment method before confirming your order.</p></div>
        </div>
        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">Can I modify or cancel my order after placing it? <span class="arrow">▾</span></button>
            <div class="faq-answer"><p>You can request modifications or cancellations within 1 hour of placing your order by contacting our support team. After that, orders enter processing and cannot be changed.</p></div>
        </div>
        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">Do I need an account to order? <span class="arrow">▾</span></button>
            <div class="faq-answer"><p>Yes, you'll need to create a free account to place orders. This helps us track your orders, manage your addresses, and provide a better shopping experience.</p></div>
        </div>
    </div>

    {{-- Shipping --}}
    <div class="faq-category">
        <h2 class="faq-category-title">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg>
            Shipping & Delivery
        </h2>
        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">How long does shipping take? <span class="arrow">▾</span></button>
            <div class="faq-answer"><p>Standard delivery takes 3–5 business days for Metro Manila and 5–7 business days for provincial areas. Express shipping is available at checkout for faster delivery.</p></div>
        </div>
        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">Is there a free shipping option? <span class="arrow">▾</span></button>
            <div class="faq-answer"><p>Yes! We offer free standard shipping on all orders over ₱1,500. Orders below that amount have a flat shipping fee of ₱99.</p></div>
        </div>
        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">Do you deliver nationwide? <span class="arrow">▾</span></button>
            <div class="faq-answer"><p>We currently deliver to all major cities and provinces in the Philippines. Check our Shipping Info page for the full list of covered areas.</p></div>
        </div>
    </div>

    {{-- Returns --}}
    <div class="faq-category">
        <h2 class="faq-category-title">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/></svg>
            Returns & Refunds
        </h2>
        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">What is your return policy? <span class="arrow">▾</span></button>
            <div class="faq-answer"><p>We accept returns within 7 days of delivery for unopened items in original packaging. Perishable items like food and treats are non-returnable for safety reasons.</p></div>
        </div>
        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">How do I request a refund? <span class="arrow">▾</span></button>
            <div class="faq-answer"><p>Contact our support team via the Contact page or email us. Refunds are processed within 5–7 business days after we receive the returned item.</p></div>
        </div>
    </div>

    {{-- Payment --}}
    <div class="faq-category">
        <h2 class="faq-category-title">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/></svg>
            Payment
        </h2>
        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">What payment methods do you accept? <span class="arrow">▾</span></button>
            <div class="faq-answer"><p>We accept Cash on Delivery (COD) and GCash. More payment options including credit/debit cards and bank transfers are coming soon!</p></div>
        </div>
        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">Is it safe to pay online? <span class="arrow">▾</span></button>
            <div class="faq-answer"><p>Absolutely. All online payments are processed through secure, encrypted channels. Your payment information is never stored on our servers.</p></div>
        </div>
    </div>

    {{-- Account --}}
    <div class="faq-category">
        <h2 class="faq-category-title">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            Account & Profile
        </h2>
        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">How do I create an account? <span class="arrow">▾</span></button>
            <div class="faq-answer"><p>Click the "Sign up" button in the header and fill in your details. Registration is free and takes less than a minute!</p></div>
        </div>
        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">How do I update my profile or address? <span class="arrow">▾</span></button>
            <div class="faq-answer"><p>Go to your account settings via the user dropdown menu. You can edit your name, email, phone number, and manage your saved shipping addresses.</p></div>
        </div>
    </div>

    <div class="faq-cta">
        <h3>Still have questions?</h3>
        <p>Our friendly support team is here to help!</p>
        <a href="{{ route('contact') }}">Contact Us</a>
    </div>
</div>

@push('scripts')
<script>
function toggleFaq(btn) {
    const item = btn.closest('.faq-item');
    const wasOpen = item.classList.contains('open');
    // Close all in same category
    item.closest('.faq-category').querySelectorAll('.faq-item').forEach(el => el.classList.remove('open'));
    if (!wasOpen) item.classList.add('open');
}
</script>
@endpush

@endsection
