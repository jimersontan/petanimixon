/**
 * PetMarkt-PH Admin Dashboard - JavaScript
 */

(function () {
    'use strict';

    // Revenue data - fetched from API
    var currentChartData = [];
    var currentLabels = [];
    var chartCanvas = null;
    var chartCtx = null;
    var currentTab = 'monthly';

    function init() {
        initRevenueChart();
        initChartTabs();
        initSidebarNav();
        initSidebarToggle();
        initDateFilter();
        initRestockButtons();
        initProfileDropdown();
        initModals();
        fetchStockAlerts();
    }

    /**
     * Fetch stock alerts for notification bell
     */
    function fetchStockAlerts() {
        var bells = document.querySelectorAll('.dashboard-header button[aria-label="Notifications"]');
        if (!bells.length) return;
        
        // Ensure each admin bell has a stock badge dynamically so we don't need to manually update 10 different layout files
        bells.forEach(function(bell) {
            bell.style.position = 'relative';
            if (!bell.querySelector('.stock-badge')) {
                var badge = document.createElement('span');
                badge.className = 'notification-badge stock-badge';
                // Position it on the top-left to avoid colliding with the system notification SSE badge on the top-right
                badge.style.cssText = 'display: none; position: absolute; right: auto; left: -6px; top: -6px; padding: 0 4px; border-radius: 12px; background: #ea580c; border: 2px solid #fff; min-width: 20px; font-size: 11px; font-weight: 700; color: #fff; align-items: center; justify-content: center;';
                badge.textContent = '0';
                bell.appendChild(badge);
            }
        });

        fetch('/admin/api/stock-alerts', {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            bells.forEach(function(bell) {
                var badge = bell.querySelector('.stock-badge');
                if (badge) {
                    if (data.count > 0) {
                        badge.style.display = 'flex';
                        badge.textContent = data.count > 99 ? '99+' : data.count;
                    } else {
                        badge.style.display = 'none';
                    }
                }
            });
        })
        .catch(function(e) { console.error('Failed to fetch stock alerts', e); });
    }

    /**
     * Draw revenue line chart on canvas
     */
    function initRevenueChart() {
        var canvas = document.getElementById('revenueChart');
        if (!canvas) return;

        chartCanvas = canvas;
        chartCtx = canvas.getContext('2d');

        // Load initial data from API
        fetchChartData('monthly');

        window.addEventListener('resize', debounce(function () {
            drawChart(currentChartData, currentLabels);
        }, 200));
    }

    /**
     * Fetch revenue chart data from the API
     */
    function fetchChartData(type) {
        fetch('/admin/api/dashboard-chart?type=' + type, {
            headers: { 'Accept': 'application/json' }
        })
            .then(function (r) { return r.json(); })
            .then(function (resp) {
                currentChartData = resp.data;
                currentLabels = resp.labels;
                drawChart(currentChartData, currentLabels);
            })
            .catch(function () {
                // Fallback to zeros if API fails
                currentChartData = [0];
                currentLabels = ['No data'];
                drawChart(currentChartData, currentLabels);
            });
    }

    function drawChart(data, labels) {
        if (!chartCanvas || !chartCtx) return;

        var rect = chartCanvas.getBoundingClientRect();
        var w = rect.width;
        var h = rect.height;

        chartCanvas.width = w;
        chartCanvas.height = h;
        chartCtx.clearRect(0, 0, w, h);

        var padding = { top: 10, right: 10, bottom: 28, left: 36 };
        var chartW = w - padding.left - padding.right;
        var chartH = h - padding.top - padding.bottom;

        var maxVal = Math.max.apply(null, data);
        var minVal = Math.min.apply(null, data);
        var range = maxVal - minVal || 1;
        var step = Math.ceil(maxVal / 4) || 1;

        // Y-axis labels (10k, 20k, 30k, 40k style)
        chartCtx.fillStyle = '#9ca3af';
        chartCtx.font = '11px system-ui, sans-serif';
        chartCtx.textAlign = 'right';
        for (var i = 0; i <= 4; i++) {
            var yVal = step * i;
            var y = padding.top + chartH - (yVal / (step * 4)) * chartH;
            chartCtx.fillText((yVal) + 'k', padding.left - 8, y + 4);
        }

        // X-axis labels
        chartCtx.fillStyle = '#6b7280';
        chartCtx.textAlign = 'center';
        for (var j = 0; j < labels.length; j++) {
            var x = padding.left + (j / Math.max(labels.length - 1, 1)) * chartW;
            chartCtx.fillText(labels[j], x, h - 8);
        }

        // Line
        chartCtx.beginPath();
        chartCtx.strokeStyle = '#ff6b35';
        chartCtx.lineWidth = 2.5;
        chartCtx.lineJoin = 'round';
        chartCtx.lineCap = 'round';

        for (var k = 0; k < data.length; k++) {
            var px = padding.left + (k / Math.max(data.length - 1, 1)) * chartW;
            var py = padding.top + chartH - ((data[k] - minVal) / range) * chartH;
            if (k === 0) chartCtx.moveTo(px, py);
            else chartCtx.lineTo(px, py);
        }
        chartCtx.stroke();
    }

    function initChartTabs() {
        var tabs = document.querySelectorAll('.chart-tab');
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                var tabName = this.getAttribute('data-tab');
                tabs.forEach(function (t) {
                    t.classList.remove('active');
                    t.setAttribute('aria-selected', 'false');
                });
                this.classList.add('active');
                this.setAttribute('aria-selected', 'true');

                currentTab = tabName;
                fetchChartData(tabName);
            });
        });
    }

    function initSidebarNav() {
        var items = document.querySelectorAll('.sidebar-nav .nav-item');
        items.forEach(function (item) {
            item.addEventListener('click', function (e) {
                var href = this.getAttribute('href');
                if (href === '#') {
                    e.preventDefault();
                    items.forEach(function (i) { i.classList.remove('active'); });
                    this.classList.add('active');
                }
            });
        });
    }

    function initSidebarToggle() {
        var toggleBtn = document.getElementById('sidebarToggle');
        var sidebar = document.getElementById('adminSidebar');
        var overlay = document.getElementById('sidebarOverlay');

        if (!toggleBtn || !sidebar || !overlay) return;

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        toggleBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');

            // Prevent body scroll when sidebar is open on mobile
            if (sidebar.classList.contains('open')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });

        overlay.addEventListener('click', closeSidebar);
    }

    function initDateFilter() {
        // generic handler for any filter form with a select
        var forms = document.querySelectorAll('.date-filter-form');
        forms.forEach(function (form) {
            var select = form.querySelector('select');
            if (!select) return;
            select.addEventListener('change', function () {
                form.submit();
            });
        });

        // legacy dashboard select (no form)
        var dashboardSelect = document.getElementById('dateRange');
        if (dashboardSelect) {
            dashboardSelect.addEventListener('change', function () {
                var value = this.value;
                console.log('Date range changed to last', value, 'days');
            });
        }
    }

    function initRestockButtons() {
        document.querySelectorAll('.btn-restock').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var item = this.closest('.low-stock-item');
                var name = item ? item.querySelector('.stock-name') : null;
                var label = name ? name.textContent : 'Product';
                this.disabled = true;
                this.textContent = 'Requested';
                // In a real app: send restock request to API
            });
        });
    }

    function initProfileDropdown() {
        var btn = document.getElementById('profileMenuButton');
        var menu = document.querySelector('.dropdown-menu');
        var logoutLink = document.getElementById('logoutLink');
        if (btn && menu) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                menu.classList.toggle('show');
                btn.setAttribute('aria-expanded', menu.classList.contains('show'));
            });
            document.addEventListener('click', function (e) {
                if (!btn.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.remove('show');
                    btn.setAttribute('aria-expanded', 'false');
                }
            });
        }
        if (logoutLink) {
            logoutLink.addEventListener('click', function (e) {
                e.preventDefault();
                document.getElementById('logoutForm').submit();
            });
        }
    }

    function initModals() {
        var openers = document.querySelectorAll('[data-modal-open]');
        var closers = document.querySelectorAll('[data-modal-close]');
        var backdrops = document.querySelectorAll('.modal-backdrop');

        function openModal(id) {
            var modal = document.getElementById(id);
            if (!modal) return;
            modal.classList.add('open');
            var backdrop = document.querySelector('.modal-backdrop[data-modal-id="' + id + '"]');
            if (backdrop) {
                backdrop.classList.add('open');
            }
            document.body.style.overflow = 'hidden';
            modal.focus();
        }

        function closeModal(id) {
            var modal = document.getElementById(id);
            if (!modal) return;
            modal.classList.remove('open');
            var backdrop = document.querySelector('.modal-backdrop[data-modal-id="' + id + '"]');
            if (backdrop) {
                backdrop.classList.remove('open');
            }
            document.body.style.overflow = '';
        }

        openers.forEach(function (btn) {
            var target = btn.getAttribute('data-modal-open');
            btn.addEventListener('click', function () {
                openModal(target);
            });
        });

        closers.forEach(function (btn) {
            var target = btn.getAttribute('data-modal-close');
            btn.addEventListener('click', function () {
                closeModal(target);
            });
        });

        backdrops.forEach(function (backdrop) {
            backdrop.addEventListener('click', function () {
                var id = this.getAttribute('data-modal-id');
                closeModal(id);
            });
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                document.querySelectorAll('.modal.open').forEach(function (modal) {
                    closeModal(modal.id);
                });
            }
        });
    }

    function debounce(fn, ms) {
        var t;
        return function () {
            clearTimeout(t);
            t = setTimeout(fn, ms);
        };
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
