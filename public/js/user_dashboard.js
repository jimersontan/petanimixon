/**
 * Pet Markt-PH User Dashboard - Customer Homepage Interactivity
 */
(function () {
    'use strict';

    // DOM Ready
    document.addEventListener('DOMContentLoaded', function () {
        initUserDropdown();
        initTrendTabs();
        initAddToCart();
        initWishlist();
        initSearch();
        initProductModalLinks();
    });

    /**
     * Open product in modal instead of full page navigation (links / buttons with data-product-id).
     */
    function initProductModalLinks() {
        document.addEventListener('click', function (e) {
            const el = e.target.closest('.js-open-product-modal[data-product-id]');
            if (!el) return;
            if (e.target.closest('form, button, input, textarea, select, label')) return;
            const id = el.getAttribute('data-product-id');
            if (!id || typeof window.openProductModal !== 'function') return;
            e.preventDefault();
            window.openProductModal(id, e);
        });
    }

    // User dropdown toggle
    function initUserDropdown() {
        const userBtn = document.getElementById('udUserBtn');
        const dropdown = document.getElementById('udUserDropdown');
        if (!userBtn || !dropdown) return;

        userBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('open');
        });

        document.addEventListener('click', function () {
            dropdown.classList.remove('open');
        });
        dropdown.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }

    // Trending products tabs
    function initTrendTabs() {
        const tabs = document.querySelectorAll('.ud-tab');
        const container = document.getElementById('udTrendingProducts');
        if (!tabs.length || !container) return;

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(function (t) { t.classList.remove('active'); });
                tab.classList.add('active');
                const tabName = tab.getAttribute('data-tab');
                // In a real app, you'd fetch/filter products by category
                console.log('Trending tab:', tabName);
            });
        });
    }

    // Add to cart
    function initAddToCart() {
        const cartCounts = document.querySelectorAll('.ud-cart-count, .ud-cart-count-mobile');
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

        // Fetch real count from server
        function refreshCartCount() {
            fetch('/cart/count', { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                .then(response => response.json())
                .then(data => {
                    cartCounts.forEach(el => el.textContent = data.count || 0);
                })
                .catch(() => { /* silent */ });
        }

        function updateCartCount(count) {
            cartCounts.forEach(el => el.textContent = count || 0);
        }

        function animateToCart(sourceButton) {
            const cartTarget = document.querySelector('.ud-header-actions a[aria-label="Cart"]') || document.querySelector('.bottom-nav-item');
            if (!sourceButton || !cartTarget) return;
            const start = sourceButton.getBoundingClientRect();
            const end = cartTarget.getBoundingClientRect();

            const dot = document.createElement('div');
            dot.className = 'ud-cart-fly-dot';
            dot.style.left = (start.left + start.width / 2) + 'px';
            dot.style.top = (start.top + start.height / 2) + 'px';
            dot.style.setProperty('--fly-x', (end.left - start.left) + 'px');
            dot.style.setProperty('--fly-y', (end.top - start.top) + 'px');
            document.body.appendChild(dot);
            setTimeout(() => dot.remove(), 700);
        }

        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (!(form instanceof HTMLFormElement)) return;
            if (!form.action || !form.action.includes('/cart/add')) return;

            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('ud-cart-btn-loading');
            }

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(form),
                credentials: 'same-origin'
            })
                .then(async (response) => {
                    const data = await response.json().catch(() => ({}));
                    if (!response.ok) throw new Error(data.error || 'Could not add to cart.');
                    return data;
                })
                .then(data => {
                    if (typeof data.count === 'number') {
                        updateCartCount(data.count);
                    } else {
                        refreshCartCount();
                    }
                    if (submitBtn) {
                        submitBtn.classList.remove('ud-cart-btn-loading');
                        submitBtn.classList.add('ud-cart-btn-added');
                        setTimeout(() => submitBtn.classList.remove('ud-cart-btn-added'), 500);
                    }
                    animateToCart(submitBtn || form);
                    showNotification(data.message || 'Product added to cart!');
                })
                .catch(err => {
                    showNotification(err.message || 'Could not add to cart.');
                })
                .finally(() => {
                    if (submitBtn) submitBtn.disabled = false;
                });
        });

        // Legacy buttons (if any) that still use data-id without forms
        document.querySelectorAll('.ud-add-cart[data-id]').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const productId = btn.getAttribute('data-id');
                if (!productId) return;
                fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams({ product_id: productId, quantity: 1 }),
                    credentials: 'same-origin'
                })
                    .then(async (response) => {
                        const data = await response.json().catch(() => ({}));
                        if (!response.ok) throw new Error(data.error || 'Could not add to cart.');
                        return data;
                    })
                    .then(data => {
                        updateCartCount(data.count || 0);
                        animateToCart(btn);
                        showNotification(data.message || 'Product added to cart!');
                    })
                    .catch(err => showNotification(err.message || 'Could not add to cart.'));
            });
        });

        refreshCartCount();
    }

    // Wishlist toggle
    function initWishlist() {
        const wishBtns = document.querySelectorAll('.ud-wishlist-btn');
        wishBtns.forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                btn.classList.toggle('active');
                btn.textContent = btn.classList.contains('active') ? '\u2665' : '\u2661';
                btn.setAttribute('aria-label', btn.classList.contains('active') ? 'Remove from wishlist' : 'Add to wishlist');
                showNotification(btn.classList.contains('active') ? 'Added to wishlist!' : 'Removed from wishlist');
            });
        });
    }

    // Search
    function initSearch() {
        const searchInput = document.querySelector('.ud-search-input');
        if (!searchInput) return;

        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const q = searchInput.value.trim();
                if (q) {
                    // In a real app: window.location.href = '/shop?q=' + encodeURIComponent(q);
                    showNotification('Searching for: ' + q);
                }
            }
        });
    }

    // Toast notification
    function showNotification(message) {
        const existing = document.querySelector('.ud-toast');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.className = 'ud-toast';
        toast.textContent = message;
        toast.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#333;color:#fff;padding:12px 24px;border-radius:8px;z-index:9999;font-size:0.95rem;animation:udFadeIn 0.3s ease;';
        document.body.appendChild(toast);

        setTimeout(function () {
            toast.style.animation = 'udFadeOut 0.3s ease';
            setTimeout(function () { toast.remove(); }, 300);
        }, 2000);
    }

    // Add animation styles
    const style = document.createElement('style');
    style.textContent = '@keyframes udFadeIn{from{opacity:0;transform:translateX(-50%) translateY(10px)}to{opacity:1;transform:translateX(-50%) translateY(0)}}@keyframes udFadeOut{from{opacity:1}to{opacity:0}}@keyframes udCartFly{0%{opacity:1;transform:translate(0,0) scale(1)}100%{opacity:0;transform:translate(var(--fly-x),var(--fly-y)) scale(.3)}}.ud-cart-fly-dot{position:fixed;width:14px;height:14px;border-radius:999px;background:#ff8a00;z-index:10001;pointer-events:none;animation:udCartFly .65s ease-in forwards}.ud-cart-btn-loading{opacity:.75;cursor:wait}.ud-cart-btn-added{transform:scale(1.03);transition:transform .15s ease}';
    document.head.appendChild(style);
})();

// Global functions for Product Reviews (used in full page and modal)
window.previewImages = function (input) {
    const container = document.getElementById('imgPreview');
    if (!container) return;
    container.innerHTML = '';
    const files = Array.from(input.files).slice(0, 4);
    if (input.files.length > 4) {
        alert('Maximum 4 images allowed');
        const dt = new DataTransfer();
        files.forEach(f => dt.items.add(f));
        input.files = dt.files;
    }
    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'rv-img-thumb';
            container.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
};

window.toggleLike = function (reviewId, btn) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    fetch(`/review/${reviewId}/like`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    })
        .then(r => r.json())
        .then(data => {
            btn.classList.toggle('liked', data.liked);
            btn.querySelector('span').textContent = data.count;
        }).catch(e => console.error(e));
};

window.toggleReplyForm = function (reviewId) {
    const el = document.getElementById('replies-' + reviewId);
    if (el) {
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
    }
};

window.openLightbox = function (src) {
    const img = document.getElementById('lightboxImg');
    const lb = document.getElementById('lightbox');
    if (img && lb) {
        img.src = src;
        lb.classList.add('active');
    }
};

window.closeLightbox = function () {
    const lb = document.getElementById('lightbox');
    if (lb) lb.classList.remove('active');
};

// Global Product Modal Functions
window.openProductModal = function (productId, event) {
    if (event) {
        // Prevent default if it's an anchor link
        event.preventDefault();
        event.stopPropagation();
    }

    const modal = document.getElementById('globalProductModal');
    const content = document.getElementById('globalProductModalContent');
    if (!modal || !content) return;

    // Show loading spinner
    content.innerHTML = '<div style="text-align:center; padding: 60px 20px;"><div class="ud-spinner"></div><p style="color:#666;font-weight:600;">Loading product details...</p></div>';

    // Open modal and prevent body scroll
    modal.style.display = 'flex';
    // Small delay to allow display flex to apply before adding class for transition
    setTimeout(() => modal.classList.add('active'), 10);
    document.body.style.overflow = 'hidden';

    // Fetch content
    fetch(`/product/${productId}/modal`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(html => {
            content.innerHTML = html;
            if (typeof window.initVariantSelection === 'function') window.initVariantSelection();
        })
        .catch(err => {
            console.error(err);
            content.innerHTML = '<div style="text-align:center; padding: 60px 20px; color:#e53935;"><p>Failed to load product details. Please try again later.</p></div>';
        });
};

window.closeProductModal = function () {
    const modal = document.getElementById('globalProductModal');
    if (!modal) return;

    modal.classList.remove('active');
    setTimeout(() => {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }, 300); // 300ms transition time
};

window.initVariantSelection = function() {
    const chips = document.querySelectorAll('.pd-variant-chip');
    if (!chips || chips.length === 0) return;
    const forms = document.querySelectorAll('.pd-add-form');
    const priceCurrent = document.querySelector('.pd-price-current');
    const stockBadgeText = document.querySelector('.pd-stock-count, .pd-stock-badge');
    
    // Add hidden variant_id inputs to forms if not present
    let activeVariantId = null;
    forms.forEach(f => {
        if (!f.querySelector('.pd-variant-id-input')) {
            const inp = document.createElement('input');
            inp.type = 'hidden';
            inp.name = 'variant_id';
            inp.className = 'pd-variant-id-input';
            f.appendChild(inp);
        }
    });
    
    function updateSelectedVariant(chip) {
        if (!chip) return;
        activeVariantId = chip.getAttribute('data-id');
        const price = parseFloat(chip.getAttribute('data-price') || 0).toFixed(2);
        const stock = parseInt(chip.getAttribute('data-stock') || 0, 10);
        
        // Update styling
        chips.forEach(c => {
            c.style.borderColor = '#ddd';
            c.style.background = '#fff';
            c.style.color = '#333';
        });
        chip.style.borderColor = '#FF8C42';
        chip.style.background = '#FFF7ED';
        chip.style.color = '#FF8C42';
        
        // Update forms
        document.querySelectorAll('.pd-variant-id-input').forEach(inp => {
            inp.value = activeVariantId;
        });
        
        // Update price display
        if (priceCurrent && !isNaN(price)) {
            priceCurrent.textContent = '₱' + price;
        }
        
        // Update stock display and limits
        const qtyInputs = document.querySelectorAll('.pd-qty-input');
        qtyInputs.forEach(qi => {
            qi.max = stock;
            if (parseInt(qi.value, 10) > stock) qi.value = stock;
            if (stock === 0) qi.value = 1; // Default
        });
        
        const buyBtns = document.querySelectorAll('.pd-btn-cart, .pd-btn-buy');
        const dynamicStockWrapper = document.getElementById('dynamic-stock-wrapper');
        
        if (stock > 0) {
            buyBtns.forEach(b => { 
                b.disabled = false;
                if (b.classList.contains('pd-btn-cart')) {
                    b.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg> Add to Cart';
                }
            });
            if (dynamicStockWrapper) {
                if (stock > 10) {
                    dynamicStockWrapper.innerHTML = `
                        <div class="pd-stock-badge in">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                            In Stock <span class="pd-stock-count">(${stock} available)</span>
                        </div>
                    `;
                } else {
                    dynamicStockWrapper.innerHTML = `
                        <div class="pd-stock-badge low">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                            Only <span class="pd-stock-count">${stock}</span> left — order soon!
                        </div>
                    `;
                }
            }
        } else {
            buyBtns.forEach(b => { 
                b.disabled = true;
                if (b.classList.contains('pd-btn-cart')) {
                    b.innerHTML = 'Out of Stock';
                }
            });
            if (dynamicStockWrapper) {
                dynamicStockWrapper.innerHTML = `
                    <div class="pd-stock-badge out">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/></svg>
                        Out of Stock
                    </div>
                `;
            }
        }
    }
    
    chips.forEach(chip => {
        chip.addEventListener('click', () => updateSelectedVariant(chip));
    });
    
    // Init select
    if (chips.length > 0) {
        updateSelectedVariant(chips[0]);
    }
};