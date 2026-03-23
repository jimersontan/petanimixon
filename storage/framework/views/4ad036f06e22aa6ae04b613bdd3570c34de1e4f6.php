

<?php $__env->startSection('title', 'Free Trial - Pet Animixon'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .trial-hero {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        color: #fff; text-align: center; padding: 60px 20px 80px; position: relative;
    }
    .trial-hero h1 { font-size: 42px; font-weight: 800; margin: 0 0 14px; }
    .trial-hero h1 span { color: #FF8C42; }
    .trial-hero p { font-size: 16px; color: rgba(255,255,255,0.7); margin: 0 auto; max-width: 550px; }
    .trial-hero-wave { position: absolute; bottom: -2px; left: 0; right: 0; height: 40px; background: #fafafa; clip-path: ellipse(55% 100% at 50% 100%); }

    .trial-container { max-width: 900px; margin: 40px auto; padding: 0 20px 60px; }

    .trial-steps { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 50px; }
    .trial-step {
        background: #fff; border-radius: 16px; padding: 30px 22px; text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06); position: relative;
        transition: transform 0.3s;
    }
    .trial-step:hover { transform: translateY(-4px); }
    .trial-step .step-num {
        width: 40px; height: 40px; border-radius: 50%; background: #FF8C42; color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; font-weight: 800; margin: 0 auto 16px;
    }
    .trial-step .step-icon { font-size: 36px; margin-bottom: 12px; display: block; }
    .trial-step h3 { font-size: 17px; font-weight: 700; color: #222; margin: 0 0 8px; }
    .trial-step p { font-size: 13px; color: #666; line-height: 1.6; margin: 0; }

    .trial-benefits {
        background: #fff; border-radius: 16px; padding: 36px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06); margin-bottom: 40px;
    }
    .trial-benefits h2 { font-size: 24px; font-weight: 700; color: #222; margin: 0 0 24px; text-align: center; }
    .benefit-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .benefit-item { display: flex; gap: 12px; align-items: flex-start; padding: 12px 0; }
    .benefit-item .check {
        width: 28px; height: 28px; border-radius: 50%; background: #e8f5e9;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        color: #2e7d32; font-size: 14px; font-weight: 700;
    }
    .benefit-item div h4 { font-size: 15px; font-weight: 600; color: #222; margin: 0 0 4px; }
    .benefit-item div p { font-size: 13px; color: #777; margin: 0; line-height: 1.5; }

    .trial-cta {
        text-align: center;
        background: linear-gradient(135deg, #FF8C42, #FF6B35);
        border-radius: 20px; padding: 50px 30px; color: #fff;
    }
    .trial-cta h3 { font-size: 26px; font-weight: 800; margin: 0 0 10px; }
    .trial-cta p { font-size: 15px; opacity: 0.9; margin: 0 0 24px; }
    .trial-cta a {
        display: inline-block; padding: 14px 36px;
        background: #fff; color: #FF8C42; border-radius: 8px;
        text-decoration: none; font-weight: 700; font-size: 15px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .trial-cta a:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }

    @media (max-width: 768px) {
        .trial-hero { padding: 40px 16px 50px; }
        .trial-hero h1 { font-size: 28px; }
        .trial-steps { grid-template-columns: 1fr; }
        .benefit-grid { grid-template-columns: 1fr; }
        .trial-cta { padding: 30px 20px; }
        .trial-cta h3 { font-size: 20px; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="trial-hero">
    <div class="trial-hero-wave"></div>
    <h1>Try Before You <span>Buy</span> 🎁</h1>
    <p>Experience our premium pet products risk-free with our sample & trial program.</p>
</div>
<div class="trial-container">
    <div class="trial-steps">
        <div class="trial-step">
            <div class="step-num">1</div>
            <span class="step-icon">📝</span>
            <h3>Sign Up</h3>
            <p>Create your free Pet Animixon account and browse eligible trial products.</p>
        </div>
        <div class="trial-step">
            <div class="step-num">2</div>
            <span class="step-icon">📦</span>
            <h3>Get a Sample</h3>
            <p>Order a trial-size sample shipped to your door. Only pay for shipping!</p>
        </div>
        <div class="trial-step">
            <div class="step-num">3</div>
            <span class="step-icon">🐾</span>
            <h3>Love It? Buy It!</h3>
            <p>If your pet loves it, order the full size with an exclusive trial discount.</p>
        </div>
    </div>

    <div class="trial-benefits">
        <h2>Why Try Our Trial Program?</h2>
        <div class="benefit-grid">
            <div class="benefit-item">
                <div class="check">✓</div>
                <div><h4>No obligation</h4><p>Try samples without committing to full-size purchases.</p></div>
            </div>
            <div class="benefit-item">
                <div class="check">✓</div>
                <div><h4>Exclusive discounts</h4><p>Get 15% off full sizes after trying a sample.</p></div>
            </div>
            <div class="benefit-item">
                <div class="check">✓</div>
                <div><h4>Curated for your pet</h4><p>Samples matched to your pet's type, size, and needs.</p></div>
            </div>
            <div class="benefit-item">
                <div class="check">✓</div>
                <div><h4>Top brands only</h4><p>Samples from our most trusted and popular brands.</p></div>
            </div>
        </div>
    </div>

    <div class="trial-cta">
        <h3>Ready to get started?</h3>
        <p>Browse our shop and look for products with the "Trial Available" badge.</p>
        <a href="<?php echo e(route('shop.all')); ?>">Browse Products</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\petverse\resources\views/frontend/trial.blade.php ENDPATH**/ ?>