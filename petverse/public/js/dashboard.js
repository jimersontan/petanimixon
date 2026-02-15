/**
 * Pet Animixon Admin Dashboard - JavaScript
 */

(function () {
    'use strict';

    // Revenue data (sample - can be replaced with API data)
    var revenueMonthly = [8, 12, 15, 18, 22, 25, 28, 32, 35, 38, 42, 45]; // in thousands
    var revenueWeekly = [18, 22, 25, 28];
    var revenueDaily = [2.1, 2.4, 2.2, 2.8, 3.0, 2.5, 2.9];
    var monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    var currentChartData = revenueMonthly;
    var currentLabels = monthLabels;
    var chartCanvas = null;
    var chartCtx = null;

    function init() {
        initRevenueChart();
        initChartTabs();
        initSidebarNav();
        initDateFilter();
        initRestockButtons();
    }

    /**
     * Draw revenue line chart on canvas
     */
    function initRevenueChart() {
        var canvas = document.getElementById('revenueChart');
        if (!canvas) return;

        chartCanvas = canvas;
        chartCtx = canvas.getContext('2d');
        drawChart(currentChartData, currentLabels);

        window.addEventListener('resize', debounce(function () {
            drawChart(currentChartData, currentLabels);
        }, 200));
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
        var step = Math.ceil(maxVal / 4);

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
        var labelStep = Math.max(1, Math.floor(labels.length / 12));
        for (var j = 0; j < labels.length; j++) {
            var x = padding.left + (j / (labels.length - 1)) * chartW;
            chartCtx.fillText(labels[j], x, h - 8);
        }

        // Line
        chartCtx.beginPath();
        chartCtx.strokeStyle = '#ff6b35';
        chartCtx.lineWidth = 2.5;
        chartCtx.lineJoin = 'round';
        chartCtx.lineCap = 'round';

        for (var k = 0; k < data.length; k++) {
            var px = padding.left + (k / (data.length - 1)) * chartW;
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

                if (tabName === 'monthly') {
                    currentChartData = revenueMonthly;
                    currentLabels = monthLabels;
                } else if (tabName === 'weekly') {
                    currentChartData = revenueWeekly;
                    currentLabels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                } else {
                    currentChartData = revenueDaily;
                    currentLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                }
                drawChart(currentChartData, currentLabels);
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

    function initDateFilter() {
        var select = document.getElementById('dateRange');
        if (!select) return;
        select.addEventListener('change', function () {
            var value = this.value;
            // Could trigger data refresh here (e.g. fetch metrics for last N days)
            console.log('Date range changed to last', value, 'days');
        });
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
