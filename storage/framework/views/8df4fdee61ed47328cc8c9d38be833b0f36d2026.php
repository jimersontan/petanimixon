

<?php $__env->startSection('title', 'Shipping Info - PetMarkt-PH'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .shipping-hero {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        padding: 50px 20px 60px; text-align: center; position: relative;
    }
    .shipping-hero h1 { font-size: 38px; font-weight: 800; color: #222; margin: 0 0 10px; }
    .shipping-hero p { font-size: 15px; color: #555; margin: 0; }
    .shipping-hero-wave { position: absolute; bottom: -2px; left: 0; right: 0; height: 40px; background: #fafafa; clip-path: ellipse(55% 100% at 50% 100%); }
    .shipping-container { max-width: 900px; margin: 40px auto; padding: 0 20px 60px; }
    .shipping-section { margin-bottom: 40px; }
    .shipping-section h2 { font-size: 22px; font-weight: 700; color: #222; margin: 0 0 6px; }
    .shipping-section .section-desc { font-size: 14px; color: #888; margin: 0 0 20px; }
    .shipping-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
    .shipping-card { background: #fff; border-radius: 14px; padding: 28px 22px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.06); transition: transform 0.3s; }
    .shipping-card:hover { transform: translateY(-4px); }
    .shipping-card .card-icon { font-size: 36px; margin-bottom: 12px; display: block; }
    .shipping-card h3 { font-size: 17px; font-weight: 700; color: #222; margin: 0 0 8px; }
    .shipping-card p { font-size: 13px; color: #666; line-height: 1.6; margin: 0; }
    .time-badge { display: inline-block; margin-top: 12px; padding: 5px 14px; background: #e8f5e9; color: #2e7d32; border-radius: 20px; font-size: 12px; font-weight: 700; }
    .shipping-table-wrap { overflow-x: auto; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
    .shipping-table { width: 100%; border-collapse: collapse; background: #fff; }
    .shipping-table th, .shipping-table td { padding: 14px 18px; text-align: left; border-bottom: 1px solid #f0f0f0; }
    .shipping-table th { background: #fafafa; font-weight: 700; color: #555; font-size: 13px; text-transform: uppercase; }
    .shipping-table td { font-size: 14px; color: #444; }
    .free-badge { background: #e8f5e9; color: #2e7d32; padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: 700; }
    .info-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .info-card { background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    .info-card h4 { font-size: 16px; font-weight: 700; color: #222; margin: 0 0 8px; }
    .info-card p { font-size: 13px; color: #666; line-height: 1.7; margin: 0; }
    .note-box { background: #e9f2ea; border-left: 4px solid #3b7c42; border-radius: 0 8px 8px 0; padding: 16px 20px; margin-top: 30px; }
    .note-box strong { color: #3b7c42; }
    .note-box p { font-size: 13px; color: #666; margin: 4px 0 0; line-height: 1.6; }
    @media (max-width: 768px) {
        .shipping-hero { padding: 30px 16px 40px; }
        .shipping-hero h1 { font-size: 26px; }
        .shipping-cards { grid-template-columns: 1fr; }
        .info-cards { grid-template-columns: 1fr; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="shipping-hero">
    <div class="shipping-hero-wave"></div>
    <h1>🚚 Shipping Information</h1>
    <p>Fast, reliable delivery for all your pet needs</p>
</div>
<div class="shipping-container">
    <div class="shipping-section">
        <h2>Delivery Options</h2>
        <p class="section-desc">Choose the shipping method that works best for you.</p>
        <div class="shipping-cards">
            <div class="shipping-card">
                <span class="card-icon">📦</span>
                <h3>Standard Delivery</h3>
                <p>Affordable and reliable shipping for all orders.</p>
                <span class="time-badge">3–5 Business Days</span>
            </div>
            <div class="shipping-card">
                <span class="card-icon">⚡</span>
                <h3>Express Delivery</h3>
                <p>Get your items faster with our express option.</p>
                <span class="time-badge">1–2 Business Days</span>
            </div>
            <div class="shipping-card">
                <span class="card-icon">🏪</span>
                <h3>Store Pickup</h3>
                <p>Order online and pick up at our Butuan, Libertad store.</p>
                <span class="time-badge">Same Day</span>
            </div>
        </div>
    </div>
    <div class="shipping-section">
        <h2>Shipping Fees</h2>
        <p class="section-desc">Transparent pricing — no hidden charges.</p>
        <div class="shipping-table-wrap">
            <table class="shipping-table">
                <thead><tr><th>Order Total</th><th>Standard</th><th>Express</th><th>Store Pickup</th></tr></thead>
                <tbody>
                    <tr><td>Below ₱500</td><td>₱99</td><td>₱199</td><td><span class="free-badge">FREE</span></td></tr>
                    <tr><td>₱500 – ₱1,499</td><td>₱59</td><td>₱149</td><td><span class="free-badge">FREE</span></td></tr>
                    <tr><td>₱1,500 and above</td><td><span class="free-badge">FREE</span></td><td>₱99</td><td><span class="free-badge">FREE</span></td></tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="shipping-section">
        <h2>Coverage & Tracking</h2>
        <p class="section-desc">We ship nationwide and keep you updated every step of the way.</p>
        <div class="info-cards">
            <div class="info-card">
                <h4>🗺️ Coverage Areas</h4>
                <p>We deliver to all major cities across the Philippines including Metro Manila, Cebu, Davao, and more. Remote areas may need extra delivery time.</p>
            </div>
            <div class="info-card">
                <h4>📍 Order Tracking</h4>
                <p>Once shipped, you get a tracking number via email. Track your order anytime from "My Orders" in your account.</p>
            </div>
        </div>
    </div>
    <div class="note-box">
        <strong>📌 Important Note</strong>
        <p>Delivery times may vary during peak seasons or holidays. Perishable items are shipped in temperature-controlled packaging.</p>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/frontend/shipping.blade.php ENDPATH**/ ?>