/* ╔════════════════════════════════════════════════════════════════════╗
   ║  PET MARKT-PH — MOBILE JS                                       ║
   ║  Handles: search modal, auth sheet, bottom nav, animations      ║
   ╚════════════════════════════════════════════════════════════════════╝ */

(function() {
    'use strict';

    var IS_MOBILE = window.innerWidth <= 1024;
    var scrollY = 0;

    // ═══ Utility: Check if mobile ═══
    function isMobile() {
        return window.innerWidth <= 1024;
    }

    // ═══ FULL-SCREEN SEARCH MODAL ═══
    var searchModal = document.getElementById('mobSearchModal');
    var searchInput = document.getElementById('mobSearchInput');
    var searchBody  = document.getElementById('mobSearchBody');
    var searchBar   = document.getElementById('searchBarWrap');
    var searchTimer = null;

    // Open search modal when tapping search bar on mobile
    if (searchBar && searchModal) {
        searchBar.addEventListener('click', function(e) {
            if (!isMobile()) return;
            e.preventDefault();
            e.stopPropagation();
            openMobSearch();
        });
    }

    window.openMobSearch = function() {
        if (!searchModal) return;
        scrollY = window.pageYOffset;
        document.body.classList.add('mob-modal-open');
        document.body.style.top = '-' + scrollY + 'px';
        searchModal.classList.add('active');
        setTimeout(function() {
            if (searchInput) searchInput.focus();
        }, 350);
    };

    window.closeMobSearch = function() {
        if (!searchModal) return;
        searchModal.classList.remove('active');
        document.body.classList.remove('mob-modal-open');
        document.body.style.top = '';
        window.scrollTo(0, scrollY);
        if (searchInput) searchInput.value = '';
        resetSearchBody();
    };

    function resetSearchBody() {
        if (!searchBody) return;
        searchBody.innerHTML =
            '<div class="mob-search-section-title">🔍 Search for products</div>' +
            '<div class="mob-search-empty">' +
                '<div class="mob-search-empty-icon">🐾</div>' +
                '<div class="mob-search-empty-text">Type to find pet products, brands & more</div>' +
            '</div>';
    }

    // AJAX search inside modal
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimer);
            var q = this.value.trim();
            if (q.length < 2) {
                resetSearchBody();
                return;
            }
            searchTimer = setTimeout(function() {
                doMobSearch(q);
            }, 300);
        });

        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') window.closeMobSearch();
            if (e.key === 'Enter') {
                e.preventDefault();
                var q = this.value.trim();
                if (q.length > 0) {
                    window.location.href = '/shop/all?q=' + encodeURIComponent(q);
                }
            }
        });
    }

    function doMobSearch(q) {
        if (!searchBody) return;
        // Show loading
        searchBody.innerHTML =
            '<div class="mob-search-section-title">🔍 Searching...</div>' +
            '<div style="text-align:center; padding:32px; color:#9CA3AF;">' +
                '<div style="width:24px;height:24px;border:3px solid #E5E7EB;border-top-color:#F97316;border-radius:50%;animation:mobSpin 0.6s linear infinite;margin:0 auto;"></div>' +
            '</div>';

        var suggestUrl = document.querySelector('meta[name="search-suggest-url"]');
        var url = suggestUrl ? suggestUrl.content : '/search/suggestions';

        fetch(url + '?q=' + encodeURIComponent(q))
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (!data || data.length === 0) {
                    searchBody.innerHTML =
                        '<div class="mob-search-section-title">🔍 Search Results</div>' +
                        '<div class="mob-search-empty">' +
                            '<div class="mob-search-empty-icon">😿</div>' +
                            '<div class="mob-search-empty-text">No products found for "' + q + '"</div>' +
                        '</div>';
                    return;
                }

                var html = '<div class="mob-search-section-title">🔍 Search Results</div>';
                for (var i = 0; i < data.length; i++) {
                    var p = data[i];
                    html += '<a href="' + p.url + '" class="mob-search-result">';
                    html += '<img src="' + (p.image || '') + '" class="mob-search-result-img" loading="lazy" onerror="this.style.display=\'none\'">';
                    html += '<div class="mob-search-result-info">';
                    html += '<div class="mob-search-result-name">' + p.name + '</div>';
                    html += '<div class="mob-search-result-brand">' + (p.brand || 'Pet Markt-PH') + '</div>';
                    html += '</div>';
                    html += '<div class="mob-search-result-price">₱' + p.price + '</div>';
                    html += '</a>';
                }

                html += '<a href="/shop/all?q=' + encodeURIComponent(q) + '" style="display:block; text-align:center; padding:16px; font-size:14px; font-weight:700; color:#F97316; text-decoration:none; border-top:1px solid #E5E7EB; margin-top:8px;">View all results →</a>';

                searchBody.innerHTML = html;
            })
            .catch(function() {
                searchBody.innerHTML =
                    '<div class="mob-search-section-title">🔍 Search Results</div>' +
                    '<div class="mob-search-empty">' +
                        '<div class="mob-search-empty-icon">⚠️</div>' +
                        '<div class="mob-search-empty-text">Something went wrong. Please try again.</div>' +
                    '</div>';
            });
    }

    // ═══ GUEST AUTH BOTTOM SHEET ═══
    window.showAuthSheet = function(title, desc) {
        var overlay = document.getElementById('mobAuthOverlay');
        var sheet = document.getElementById('mobAuthSheet');
        var titleEl = document.getElementById('mobAuthTitle');
        var descEl = document.getElementById('mobAuthDesc');

        if (!overlay || !sheet) return;
        if (titleEl) titleEl.textContent = title || 'Sign in required';
        if (descEl) descEl.textContent = desc || 'Please sign in to continue.';

        overlay.classList.add('active');
        sheet.classList.add('active');
    };

    window.hideAuthSheet = function() {
        var overlay = document.getElementById('mobAuthOverlay');
        var sheet = document.getElementById('mobAuthSheet');
        if (overlay) overlay.classList.remove('active');
        if (sheet) sheet.classList.remove('active');
    };

    // ═══ SYNC CART BADGE ON BOTTOM NAV ═══
    function syncCartBadge() {
        var desktopBadges = document.querySelectorAll('.ud-cart-count');
        var mobBadge = document.querySelector('.ud-cart-count-mob');
        if (!mobBadge || desktopBadges.length === 0) return;

        var count = 0;
        desktopBadges.forEach(function(b) {
            var val = parseInt(b.textContent);
            if (!isNaN(val) && val > 0) count = val;
        });

        if (count > 0) {
            mobBadge.textContent = count > 99 ? '99+' : count;
            mobBadge.style.display = 'block';
        } else {
            mobBadge.style.display = 'none';
        }
    }

    // Observe changes to desktop cart badge
    var desktopBadge = document.querySelector('.ud-cart-count');
    if (desktopBadge) {
        var observer = new MutationObserver(syncCartBadge);
        observer.observe(desktopBadge, { childList: true, characterData: true, subtree: true });
    }

    // ═══ FADE-IN ANIMATION (IntersectionObserver) ═══
    function initFadeIn() {
        if (!('IntersectionObserver' in window)) return;

        var targets = document.querySelectorAll('.mob-fade-in');
        if (targets.length === 0) return;

        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        targets.forEach(function(el) { obs.observe(el); });
    }

    // ═══ INIT ═══
    document.addEventListener('DOMContentLoaded', function() {
        syncCartBadge();
        initFadeIn();
    });

    // Spin animation for loading state (injected once)
    if (!document.getElementById('mob-spin-style')) {
        var style = document.createElement('style');
        style.id = 'mob-spin-style';
        style.textContent = '@keyframes mobSpin { to { transform: rotate(360deg); } }';
        document.head.appendChild(style);
    }

})();
