/**
 * Pet Animixon Admin - Orders Page
 */

(function () {
    'use strict';

    function init() {
        initStatusTabs();
        initSelectAll();
        initExportFilterButtons();
        initActionButtons();
        initDateFilter();
    }

    function initStatusTabs() {
        var tabs = document.querySelectorAll('.order-tab');
        var tbody = document.querySelector('#ordersTable tbody');
        if (!tbody) return;

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                var status = this.getAttribute('data-status');
                tabs.forEach(function (t) {
                    t.classList.remove('active');
                    t.setAttribute('aria-selected', t === tab ? 'true' : 'false');
                });
                this.classList.add('active');
                this.setAttribute('aria-selected', 'true');

                var rows = tbody.querySelectorAll('tr');
                rows.forEach(function (row) {
                    var rowStatus = row.getAttribute('data-status');
                    var show = status === 'all' || rowStatus === status;
                    row.style.display = show ? '' : 'none';
                });
            });
        });
    }

    function initSelectAll() {
        var selectAll = document.getElementById('selectAllOrders');
        var checkboxes = document.querySelectorAll('.order-checkbox');
        if (!selectAll || !checkboxes.length) return;

        selectAll.addEventListener('change', function () {
            checkboxes.forEach(function (cb) {
                cb.checked = selectAll.checked;
            });
        });

        checkboxes.forEach(function (cb) {
            cb.addEventListener('change', function () {
                var checked = document.querySelectorAll('.order-checkbox:checked').length;
                selectAll.checked = checked === checkboxes.length;
                selectAll.indeterminate = checked > 0 && checked < checkboxes.length;
            });
        });
    }

    function initExportFilterButtons() {
        var btnExport = document.getElementById('btnExport');
        var btnFilter = document.getElementById('btnFilter');

        if (btnExport) {
            btnExport.addEventListener('click', function () {
                // In a real app: trigger CSV/Excel export or open modal
                console.log('Export clicked');
            });
        }

        if (btnFilter) {
            btnFilter.addEventListener('click', function () {
                // In a real app: open filter panel/modal
                console.log('Filter clicked');
            });
        }
    }

    function initActionButtons() {
        document.querySelectorAll('.orders-table .action-btn[aria-label="View order"]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var row = this.closest('tr');
                var orderId = row ? row.querySelector('.order-id') : null;
                var id = orderId ? orderId.textContent : '';
                // In a real app: navigate to order detail or open modal
                console.log('View order', id);
            });
        });

        document.querySelectorAll('.orders-table .action-btn[aria-label="Edit order"]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var row = this.closest('tr');
                var orderId = row ? row.querySelector('.order-id') : null;
                var id = orderId ? orderId.textContent : '';
                // In a real app: navigate to edit order or open modal
                console.log('Edit order', id);
            });
        });
    }

    function initDateFilter() {
        var select = document.getElementById('ordersDateRange');
        var form = document.getElementById('ordersDateForm');
        if (!select) return;
        select.addEventListener('change', function () {
            if (form) form.submit();
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
