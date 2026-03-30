

<?php $__env->startSection('title', 'Contact Us - Pet Animixon'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .contact-hero {
        background: linear-gradient(135deg, #fff5eb 0%, #ffe8d6 100%);
        padding: 50px 20px 60px;
        text-align: center;
        position: relative;
    }
    .contact-hero h1 { font-size: 38px; font-weight: 800; color: #222; margin: 0 0 10px; }
    .contact-hero p { font-size: 15px; color: #777; margin: 0; }
    .contact-hero-wave { position: absolute; bottom: -2px; left: 0; right: 0; height: 40px; background: #fafafa; clip-path: ellipse(55% 100% at 50% 100%); }

    .contact-container { max-width: 1000px; margin: 40px auto; padding: 0 20px 60px; }

    .contact-info-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 40px; }
    .contact-info-card {
        background: #fff; border-radius: 14px; padding: 24px 18px; text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .contact-info-card:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    .contact-info-card .card-icon {
        width: 54px; height: 54px; border-radius: 50%; margin: 0 auto 14px;
        display: flex; align-items: center; justify-content: center;
        background: #FFF3E0; color: #FF8C42;
    }
    .contact-info-card h4 { font-size: 15px; font-weight: 700; color: #222; margin: 0 0 6px; }
    .contact-info-card p { font-size: 13px; color: #666; margin: 0; line-height: 1.5; }

    .contact-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; align-items: start; }

    .contact-form-card {
        background: #fff; border-radius: 16px; padding: 32px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    .contact-form-card h2 { font-size: 22px; font-weight: 700; color: #222; margin: 0 0 6px; }
    .contact-form-card .subtitle { font-size: 14px; color: #888; margin: 0 0 24px; }

    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px; }
    .form-group input,
    .form-group textarea {
        width: 100%; padding: 11px 14px; border: 1px solid #e0e0e0; border-radius: 8px;
        font-size: 14px; background: #fafafa;
        transition: border-color 0.2s, background 0.2s;
    }
    .form-group input:focus,
    .form-group textarea:focus { border-color: #FF8C42; background: #fff; outline: none; }
    .form-group textarea { resize: vertical; min-height: 120px; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    .btn-send {
        width: 100%; padding: 14px; background: #FF8C42; color: #fff;
        border: none; border-radius: 8px; font-size: 15px; font-weight: 700;
        cursor: pointer; transition: opacity 0.2s;
    }
    .btn-send:hover { opacity: 0.88; }

    .contact-map-card {
        background: #fff; border-radius: 16px; padding: 32px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    .contact-map-card h2 { font-size: 22px; font-weight: 700; color: #222; margin: 0 0 6px; }
    .contact-map-card .subtitle { font-size: 14px; color: #888; margin: 0 0 24px; }
    .map-placeholder {
        background: #f0f0f0; border-radius: 12px; height: 260px;
        display: flex; align-items: center; justify-content: center;
        color: #aaa; font-size: 14px;
    }
    .store-hours { margin-top: 20px; }
    .store-hours h4 { font-size: 15px; font-weight: 700; color: #222; margin: 0 0 10px; }
    .store-hours ul { list-style: none; padding: 0; margin: 0; }
    .store-hours ul li { font-size: 13px; color: #666; padding: 5px 0; display: flex; justify-content: space-between; }
    .store-hours ul li strong { color: #333; }

    @media (max-width: 768px) {
        .contact-hero { padding: 30px 16px 40px; }
        .contact-hero h1 { font-size: 26px; }
        .contact-hero-wave { height: 24px; }
        .contact-container { padding: 0 12px 40px; margin-top: 20px; }
        .contact-info-grid { grid-template-columns: 1fr 1fr; }
        .contact-layout { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
        .contact-info-grid { grid-template-columns: 1fr; }
        .form-row { grid-template-columns: 1fr; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="contact-hero">
    <div class="contact-hero-wave"></div>
    <h1>📬 Contact Us</h1>
    <p>We'd love to hear from you! Reach out with questions, feedback, or just to say hi.</p>
</div>

<div class="contact-container">
    
    <div class="contact-info-grid">
        <div class="contact-info-card">
            <div class="card-icon">
                <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
            </div>
            <h4>Phone</h4>
            <p>+63 912 345 6789</p>
        </div>
        <div class="contact-info-card">
            <div class="card-icon">
                <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
            </div>
            <h4>Email</h4>
            <p>support@petanimixon.com</p>
        </div>
        <div class="contact-info-card">
            <div class="card-icon">
                <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
            </div>
            <h4>Address</h4>
            <p>Libertad, Butuan City, Agusan del Norte, Philippines</p>
        </div>
        <div class="contact-info-card">
            <div class="card-icon">
                <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
            </div>
            <h4>Hours</h4>
            <p>Mon–Sat: 9AM–6PM</p>
        </div>
    </div>

    
    <div class="contact-layout">
        <div class="contact-form-card">
            <h2>Send us a message</h2>
            <p class="subtitle">Fill out the form below and we'll get back to you within 24 hours.</p>
            <form>
                <div class="form-row">
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" placeholder="Juan Dela Cruz">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" placeholder="juan@example.com">
                    </div>
                </div>
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" placeholder="How can we help?">
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea placeholder="Tell us more about your inquiry..."></textarea>
                </div>
                <button type="button" class="btn-send">Send Message</button>
            </form>
        </div>

        <div class="contact-map-card">
            <h2>Find Us</h2>
            <p class="subtitle">Visit our physical store in Butuan City.</p>
            <div class="map-placeholder">
                📍 Map — Libertad, Butuan City
            </div>
            <div class="store-hours">
                <h4>🕒 Store Hours</h4>
                <ul>
                    <li><span>Monday – Friday</span> <strong>9:00 AM – 6:00 PM</strong></li>
                    <li><span>Saturday</span> <strong>9:00 AM – 5:00 PM</strong></li>
                    <li><span>Sunday</span> <strong>Closed</strong></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views\frontend\contact.blade.php ENDPATH**/ ?>