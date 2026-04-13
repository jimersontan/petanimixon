

<?php $__env->startSection('title', 'About Us - PetMarkt-PH'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .about-hero {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        color: #fff;
        text-align: center;
        padding: 70px 20px 80px;
        position: relative;
    }
    .about-hero h1 { font-size: 42px; font-weight: 800; margin: 0 0 14px; }
    .about-hero h1 span { color: #3b7c42; }
    .about-hero p { font-size: 16px; color: rgba(255,255,255,0.7); margin: 0; max-width: 600px; margin: 0 auto; }
    .about-hero-wave { position: absolute; bottom: -2px; left: 0; right: 0; height: 40px; background: #fafafa; clip-path: ellipse(55% 100% at 50% 100%); }

    .about-container { max-width: 1000px; margin: 0 auto; padding: 50px 20px 60px; }

    .about-section { margin-bottom: 60px; }
    .about-section h2 { font-size: 28px; font-weight: 800; color: #222; margin: 0 0 16px; text-align: center; }
    .about-section .accent-line { width: 50px; height: 3px; background: #3b7c42; border-radius: 2px; margin: 0 auto 30px; }

    .about-story { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; }
    .about-story-text p { font-size: 15px; line-height: 1.8; color: #555; margin: 0 0 16px; }
    .about-story-img { border-radius: 16px; overflow: hidden; background: linear-gradient(135deg, #3b7c42, #2E6C34); min-height: 300px; display: flex; align-items: center; justify-content: center; }
    .about-story-img .emoji-placeholder { font-size: 80px; }

    .mission-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
    .mission-card {
        background: #fff; border-radius: 16px; padding: 30px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .mission-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
    .mission-card .icon { font-size: 40px; margin-bottom: 14px; display: block; }
    .mission-card h3 { font-size: 20px; font-weight: 700; color: #222; margin: 0 0 10px; }
    .mission-card p { font-size: 14px; color: #666; line-height: 1.7; margin: 0; }

    .values-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
    .value-card {
        background: #fff; border-radius: 12px; padding: 24px; text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: transform 0.3s;
    }
    .value-card:hover { transform: translateY(-3px); }
    .value-card .icon-circle {
        width: 60px; height: 60px; border-radius: 50%; margin: 0 auto 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 26px;
    }
    .value-card h4 { font-size: 16px; font-weight: 700; color: #222; margin: 0 0 8px; }
    .value-card p { font-size: 13px; color: #777; line-height: 1.6; margin: 0; }

    .about-cta {
        text-align: center; margin-top: 50px;
        background: linear-gradient(135deg, #3b7c42, #2E6C34);
        border-radius: 20px; padding: 50px 30px; color: #fff;
    }
    .about-cta h3 { font-size: 26px; font-weight: 800; margin: 0 0 10px; }
    .about-cta p { font-size: 15px; opacity: 0.9; margin: 0 0 24px; }
    .about-cta a {
        display: inline-block; padding: 14px 36px;
        background: #fff; color: #3b7c42; border-radius: 8px;
        text-decoration: none; font-weight: 700; font-size: 15px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .about-cta a:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }

    @media (max-width: 768px) {
        .about-hero { padding: 40px 16px 50px; }
        .about-hero h1 { font-size: 28px; }
        .about-hero-wave { height: 24px; }
        .about-container { padding: 30px 12px 40px; }
        .about-story { grid-template-columns: 1fr; gap: 24px; }
        .about-story-img { min-height: 180px; }
        .mission-grid { grid-template-columns: 1fr; }
        .values-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
        .about-cta { padding: 30px 20px; border-radius: 14px; }
        .about-cta h3 { font-size: 20px; }
    }
    @media (max-width: 480px) {
        .values-grid { grid-template-columns: 1fr; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="about-hero">
    <div class="about-hero-wave"></div>
    <h1>About <span>PetMarkt-PH</span></h1>
    <p>We're passionate pet lovers on a mission to provide the best products for your furry, feathered, and scaly family members.</p>
</div>

<div class="about-container">
    
    <div class="about-section">
        <h2>Our Story</h2>
        <div class="accent-line"></div>
        <div class="about-story">
            <div class="about-story-text">
                <p>PetMarkt-PH was born from a simple belief: every pet deserves access to quality products that enhance their health, happiness, and well-being.</p>
                <p>Founded by a group of dedicated pet enthusiasts, we've grown from a small local shop to a trusted online destination for pet parents across the Philippines. We carefully curate our product selection, partnering with top brands to bring you only the best.</p>
                <p>Whether you have a playful pup, a curious cat, a chirpy bird, or a scaly companion — we're here to make pet parenthood a joyful experience.</p>
            </div>
            <div class="about-story-img">
                <span class="emoji-placeholder">🐾</span>
            </div>
        </div>
    </div>

    
    <div class="about-section">
        <h2>Mission & Vision</h2>
        <div class="accent-line"></div>
        <div class="mission-grid">
            <div class="mission-card">
                <span class="icon">🎯</span>
                <h3>Our Mission</h3>
                <p>To provide pet parents with high-quality, affordable products and an exceptional shopping experience — making pet care easy, accessible, and enjoyable for everyone.</p>
            </div>
            <div class="mission-card">
                <span class="icon">🔭</span>
                <h3>Our Vision</h3>
                <p>To become the most trusted and loved pet shop in the Philippines, where every pet parent finds exactly what they need for their beloved companions.</p>
            </div>
        </div>
    </div>

    
    <div class="about-section">
        <h2>Our Values</h2>
        <div class="accent-line"></div>
        <div class="values-grid">
            <div class="value-card">
                <div class="icon-circle" style="background: #E3F2FD;">❤️</div>
                <h4>Love for Pets</h4>
                <p>Every decision we make starts with what's best for your pets.</p>
            </div>
            <div class="value-card">
                <div class="icon-circle" style="background: #E8F5E9;">✅</div>
                <h4>Quality First</h4>
                <p>We only stock products we'd use for our own pets.</p>
            </div>
            <div class="value-card">
                <div class="icon-circle" style="background: #e9f2ea;">🤝</div>
                <h4>Trust & Care</h4>
                <p>Honest pricing, genuine products, and responsive support.</p>
            </div>
        </div>
    </div>

    
    <div class="about-cta">
        <h3>Ready to explore?</h3>
        <p>Browse our curated collection of premium pet products.</p>
        <a href="<?php echo e(route('shop.all')); ?>">Shop Now</a>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/frontend/about.blade.php ENDPATH**/ ?>