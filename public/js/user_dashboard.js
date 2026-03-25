/**
 * Petverse User Dashboard - Customer Homepage Interactivity
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
    });

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
        const cartBtns = document.querySelectorAll('.ud-add-cart');
        const cartCounts = document.querySelectorAll('.ud-cart-count, .ud-cart-count-mobile');

        // Fetch real count from server
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                cartCounts.forEach(el => el.textContent = data.count);
            });

        cartBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                const productId = btn.getAttribute('data-id');
                // Submit form or use AJAX
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/cart/add';
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

                const html = `
                    <input type="hidden" name="_token" value="${csrf}">
                    <input type="hidden" name="product_id" value="${productId}">
                    <input type="hidden" name="quantity" value="1">
                `;
                form.innerHTML = html;
                document.body.appendChild(form);
                form.submit();
            });
        });
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
    style.textContent = '@keyframes udFadeIn{from{opacity:0;transform:translateX(-50%) translateY(10px)}to{opacity:1;transform:translateX(-50%) translateY(0)}}@keyframes udFadeOut{from{opacity:1}to{opacity:0}}';
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
