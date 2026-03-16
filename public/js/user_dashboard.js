/**
 * Petverse User Dashboard - Customer Homepage Interactivity
 */
(function() {
    'use strict';

    // DOM Ready
    document.addEventListener('DOMContentLoaded', function() {
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

        userBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.classList.toggle('open');
        });

        document.addEventListener('click', function() {
            dropdown.classList.remove('open');
        });
        dropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    // Trending products tabs
    function initTrendTabs() {
        const tabs = document.querySelectorAll('.ud-tab');
        const container = document.getElementById('udTrendingProducts');
        if (!tabs.length || !container) return;

        tabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                tabs.forEach(function(t) { t.classList.remove('active'); });
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
        const cartCount = document.querySelector('.ud-cart-count');
        let count = parseInt(localStorage.getItem('petverse_cart_count') || '0', 10);

        if (cartCount) cartCount.textContent = count;

        cartBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                count++;
                if (cartCount) cartCount.textContent = count;
                localStorage.setItem('petverse_cart_count', String(count));
                showNotification('Added to cart!');
            });
        });
    }

    // Wishlist toggle
    function initWishlist() {
        const wishBtns = document.querySelectorAll('.ud-wishlist-btn');
        wishBtns.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
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

        searchInput.addEventListener('keypress', function(e) {
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

        setTimeout(function() {
            toast.style.animation = 'udFadeOut 0.3s ease';
            setTimeout(function() { toast.remove(); }, 300);
        }, 2000);
    }

    // Add animation styles
    const style = document.createElement('style');
    style.textContent = '@keyframes udFadeIn{from{opacity:0;transform:translateX(-50%) translateY(10px)}to{opacity:1;transform:translateX(-50%) translateY(0)}}@keyframes udFadeOut{from{opacity:1}to{opacity:0}}';
    document.head.appendChild(style);
})();
