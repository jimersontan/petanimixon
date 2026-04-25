/**
 * ════════════════════════════════════════════════════════════
 * PET MARKT-PH — GLOBAL ANIMATIONS ENGINE
 * Scroll-triggered reveals using IntersectionObserver
 * ════════════════════════════════════════════════════════════
 */
document.addEventListener('DOMContentLoaded', function () {

    // ── 1. SCROLL-TRIGGERED REVEAL ────────────────────────────
    // Any element with data-anim="fade-up|fade-down|..." will
    // get its matching CSS class + .anim-visible when it scrolls
    // into view.

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('anim-visible');
                    observer.unobserve(entry.target); // only animate once
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -40px 0px'
        });

        document.querySelectorAll('[data-anim]').forEach(function (el) {
            var animType = el.getAttribute('data-anim');
            el.classList.add('anim-' + animType);
            observer.observe(el);
        });
    } else {
        // Fallback: just show everything for older browsers
        document.querySelectorAll('[data-anim]').forEach(function (el) {
            el.style.opacity = '1';
        });
    }


    // ── 2. AUTO-DETECT COMMON ELEMENTS ────────────────────────
    // Automatically add scroll-reveal to known element patterns
    // without needing data-anim attributes on every element

    var autoRevealSelectors = [
        // Frontend product grids
        { sel: '.ud-popular-row .ud-product-card', anim: 'fade-up' },
        { sel: '.ud-latest-row .ud-product-card', anim: 'fade-up' },
        { sel: '.product-grid .product-card', anim: 'fade-up' },
        // Category cards
        { sel: '.ud-catcard', anim: 'scale-in' },
        // Section headings
        { sel: '.ud-section-title', anim: 'fade-up' },
        { sel: '.section-title', anim: 'fade-up' },
        // Footer columns
        { sel: '.footer-col', anim: 'fade-up' },
        // Brand cards
        { sel: '.brand-card', anim: 'fade-up' },
    ];

    if ('IntersectionObserver' in window) {
        var autoObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('anim-visible');
                    autoObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.08,
            rootMargin: '0px 0px -30px 0px'
        });

        autoRevealSelectors.forEach(function (item) {
            document.querySelectorAll(item.sel).forEach(function (el, idx) {
                // Don't double-apply if data-anim already set
                if (el.hasAttribute('data-anim') || el.classList.contains('anim-visible')) return;
                el.classList.add('anim-' + item.anim);
                // Stagger based on index
                el.style.animationDelay = (idx * 80) + 'ms';
                autoObserver.observe(el);
            });
        });
    }


    // ── 3. BUTTON RIPPLE EFFECT ───────────────────────────────
    // Adds a Material-style ripple on click for primary buttons

    var rippleSelectors = '.btn-primary, .btn-add-to-cart, .ud-add-cart, .ud-btn-primary';

    document.querySelectorAll(rippleSelectors).forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            var rect = btn.getBoundingClientRect();
            var size = Math.max(rect.width, rect.height);
            var x = e.clientX - rect.left - size / 2;
            var y = e.clientY - rect.top - size / 2;

            var ripple = document.createElement('span');
            ripple.classList.add('btn-ripple');
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';

            btn.appendChild(ripple);

            ripple.addEventListener('animationend', function () {
                ripple.remove();
            });
        });
    });


    // ── 4. COUNTER ANIMATION ──────────────────────────────────
    // Animates numbers in metric cards from 0 to their value

    var counterObserver = null;
    if ('IntersectionObserver' in window) {
        counterObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.metric-value').forEach(function (el) {
            counterObserver.observe(el);
        });
    }

    function animateCounter(el) {
        var text = el.textContent.trim();
        // Extract numeric part (handles ₱1,234 or 45.6% format)
        var match = text.match(/([\₱$]?)([\d,]+\.?\d*)(.*)/);
        if (!match) return;

        var prefix = match[1];
        var numStr = match[2].replace(/,/g, '');
        var suffix = match[3];
        var target = parseFloat(numStr);
        var isFloat = numStr.indexOf('.') !== -1;
        var decimals = isFloat ? (numStr.split('.')[1] || '').length : 0;

        if (isNaN(target) || target === 0) return;

        var duration = 800;
        var startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            // Ease out cubic
            var eased = 1 - Math.pow(1 - progress, 3);
            var current = target * eased;

            if (isFloat) {
                el.textContent = prefix + current.toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ',') + suffix;
            } else {
                el.textContent = prefix + Math.floor(current).toLocaleString() + suffix;
            }

            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                // Set final exact value
                if (isFloat) {
                    el.textContent = prefix + target.toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ',') + suffix;
                } else {
                    el.textContent = prefix + Math.floor(target).toLocaleString() + suffix;
                }
            }
        }

        requestAnimationFrame(step);
    }


    // ── 5. NAVBAR SCROLL EFFECT ──────────────────────────────
    // Adds subtle shadow to header when user scrolls down

    var header = document.querySelector('.ud-header') || document.querySelector('.dashboard-header');
    if (header) {
        var lastScroll = 0;
        window.addEventListener('scroll', function () {
            var scrollY = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollY > 10) {
                header.style.boxShadow = '0 2px 20px rgba(0,0,0,0.08)';
            } else {
                header.style.boxShadow = '';
            }
            lastScroll = scrollY;
        }, { passive: true });
    }

});
