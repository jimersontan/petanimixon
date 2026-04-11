<header class="dashboard-header">
    <div class="header-left">
        <button type="button" class="icon-btn btn-hamburger" id="sidebarToggle" aria-label="Toggle Sidebar" style="display: none;">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
        </button>
        <div class="logo" style="display:flex; align-items:center; gap:0;">
            <img src="{{ asset('images/logo.png') }}" alt="PetMarkt-PH Logo" style="max-height: 28px; margin-right: -6px;">
            <span class="logo-text" style="color:#1f2937; margin:0;">Pet <span style="color: #ea580c;">Markt-PH</span></span>
        </div>
    </div>
    <div class="header-center">
        <div class="search-bar">
            <svg class="search-icon" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
            <input type="text" class="search-input" placeholder="Search orders, products, customers...">
        </div>
    </div>
    <div class="header-right">
        <div style="position: relative;" id="adminNotificationRoot">
            <button type="button" class="icon-btn" aria-label="Notifications" id="adminNotificationBtn" title="Notifications">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
                <span id="notificationBadge" class="notification-badge" style="display: none;">0</span>
            </button>
            <div id="adminNotificationPanel" class="ud-notification-panel" style="
                position: absolute; top: 100%; right: 0; margin-top: 8px;
                background: #fff; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);
                width: min(350px, 92vw); max-height: 500px; overflow-y: auto; display: none;
                z-index: 1000; border: 1px solid #e5e7eb; text-align: left;">
                <div style="
                    padding: 16px; border-bottom: 1px solid #e5e7eb;
                    display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="margin: 0; font-size: 14px; font-weight: 700; color: #1f2937;">Notifications</h3>
                    <button type="button" id="adminMarkAllRead" style="
                        background: none; border: none; color: #ea580c; font-size: 12px;
                        font-weight: 600; cursor: pointer;">Mark all as read</button>
                </div>
                <div id="adminNotificationList" style="padding: 12px; min-height: 100px;">
                    <div style="text-align: center; padding: 24px; color: #9ca3af; font-size: 14px;">
                        Loading notifications...
                    </div>
                </div>
            </div>
        </div>
        <div class="dropdown">
            <button type="button" class="icon-btn dropdown-toggle" id="profileMenuButton" aria-haspopup="true" aria-expanded="false" aria-label="Profile">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </button>
            <div class="dropdown-menu" aria-labelledby="profileMenuButton">
                <a href="{{ route('admin.profile') }}">Your Profile</a>
                <a href="#" id="logoutLink">Logout</a>
                <form id="logoutForm" method="post" action="{{ route('logout') }}" style="display:none;">
                    @csrf
                </form>
            </div>
        </div>
        <button type="button" class="icon-btn" aria-label="Settings">
            <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M11.4 24H0V12.6h2.4v9.4h9v2.4zm12-12H12.6V0H24v2.4h-9.6v9.6H24V12zM2.4 9.6V0h2.4v9.6H2.4zm19.2 0V0H24v9.6h-2.4zM9.6 2.4V0h4.8v2.4H9.6zm4.8 19.2v-2.4h4.8V24h-4.8z"/></svg>
        </button>
    </div>
</header>

<style>
    .notification-badge {
        position: absolute;
        top: -6px;
        right: -6px;
        background: #ef4444;
        color: #fff;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        border: 2px solid #fff;
    }
</style>

<script>
    function csrfHeaders() {
        const t = document.querySelector('meta[name="csrf-token"]');
        return {
            'X-CSRF-TOKEN': t ? t.content : '',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        };
    }

    function timeAgo(dateString) {
        const date = new Date(dateString);
        const diff = Math.floor((new Date() - date) / 1000);
        if (diff < 60) return 'just now';
        if (diff < 3600) return Math.floor(diff / 60) + 'm ago';
        if (diff < 86400) return Math.floor(diff / 3600) + 'h ago';
        if (diff < 604800) return Math.floor(diff / 86400) + 'd ago';
        return date.toLocaleDateString();
    }

    function escapeHtml(s) {
        if (!s) return '';
        const d = document.createElement('div'); d.textContent = s; return d.innerHTML;
    }

    // Check unread notifications count for admin — SSE powered
    document.addEventListener('DOMContentLoaded', function() {
        updateAdminNotificationBadge();

        // Connect SSE for admin
        let adminSSE = null;
        function connectAdminSSE() {
            if (adminSSE) adminSSE.close();
            adminSSE = new EventSource('{{ route("sse.admin-stream") }}');

            adminSSE.addEventListener('notification_count', function(e) {
                try {
                    const data = JSON.parse(e.data);
                    const badge = document.getElementById('notificationBadge');
                    if (data.unread_count > 0) {
                        badge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                } catch(ex) {}
            });

            adminSSE.addEventListener('new_notification', function(e) {
                try {
                    const data = JSON.parse(e.data);
                    // Show toast if available
                    if (typeof window.showNotificationToast === 'function') {
                        window.showNotificationToast(data.title, data.message, data.icon);
                    }
                } catch(ex) {}
            });

            adminSSE.addEventListener('chat_count', function(e) {
                try {
                    const data = JSON.parse(e.data);
                    const chatBadge = document.getElementById('adminChatBadge');
                    if (chatBadge) {
                        if (data.unread_count > 0) {
                            chatBadge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                            chatBadge.style.display = 'flex';
                        } else {
                            chatBadge.style.display = 'none';
                        }
                    }
                } catch(ex) {}
            });

            adminSSE.addEventListener('reconnect', function() { adminSSE.close(); setTimeout(connectAdminSSE, 2000); });
            adminSSE.onerror = function() { adminSSE.close(); setTimeout(connectAdminSSE, 5000); };
        }

        connectAdminSSE();
        window.addEventListener('beforeunload', function() { if (adminSSE) adminSSE.close(); });
    });

    function updateAdminNotificationBadge() {
        fetch('{{ route("notifications.unread") }}', { headers: csrfHeaders() })
            .then(r => r.json())
            .then(data => {
                const badge = document.getElementById('notificationBadge');
                if (data.unread_count > 0) {
                    badge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            })
            .catch(e => console.error('Failed to fetch notifications:', e));
    }

    function loadAdminNotifications() {
        fetch('{{ route("notifications.list") }}?limit=10', { headers: csrfHeaders() })
            .then(r => r.json())
            .then(data => {
                const list = document.getElementById('adminNotificationList');
                if (data.data && data.data.length > 0) {
                    list.innerHTML = data.data.map(n => {
                        return '<div onclick="window.handleAdminNotifClick(' + n.id + ')" ' +
                            'style="padding: 12px; margin-bottom: 8px; background: ' + (n.read ? '#f9fafb' : '#fef3c7') + '; ' +
                            'border-radius: 6px; border-left: 4px solid #ea580c; cursor: pointer; transition: background 0.2s;">' +
                            '<span style="font-size:20px; margin-right:8px; display:inline-block;">' + (n.icon || '🔔') + '</span>' +
                            '<div style="display:inline-block; vertical-align: top; width: calc(100% - 32px);">' +
                                '<span style="font-weight:600; font-size:13px; color:#1f2937; display:block;">' + escapeHtml(n.title) + '</span>' +
                                '<span style="font-size:12px; color:#6b7280; display:block; margin-top:4px; line-height: 1.4;">' + escapeHtml(n.message) + '</span>' +
                                '<span style="font-size:11px; color:#9ca3af; display:block; margin-top:6px;">' + timeAgo(n.created_at) + '</span>' +
                            '</div></div>';
                    }).join('');
                } else {
                    list.innerHTML = '<div style="text-align: center; padding: 24px; color: #9ca3af; font-size: 14px;">No notifications</div>';
                }
            });
    }

    window.handleAdminNotifClick = function(id) {
        fetch('/api/notifications/' + id + '/read', { method: 'PATCH', headers: csrfHeaders() })
            .then(() => {
                loadAdminNotifications();
                updateAdminNotificationBadge();
            });
    };

    var adminNotifOpen = false;
    document.getElementById('adminNotificationBtn').addEventListener('click', function(e) {
        e.stopPropagation();
        var panel = document.getElementById('adminNotificationPanel');
        if (adminNotifOpen) {
            panel.style.display = 'none';
        } else {
            panel.style.display = 'block';
            loadAdminNotifications();
        }
        adminNotifOpen = !adminNotifOpen;
    });

    document.addEventListener('click', function(e) {
        var root = document.getElementById('adminNotificationRoot');
        var panel = document.getElementById('adminNotificationPanel');
        if (adminNotifOpen && root && !root.contains(e.target)) {
            panel.style.display = 'none';
            adminNotifOpen = false;
        }
    });

    document.getElementById('adminMarkAllRead').addEventListener('click', function(e) {
        e.stopPropagation();
        fetch('{{ route("notifications.mark-all-read") }}', { method: 'POST', headers: csrfHeaders() })
            .then(() => {
                loadAdminNotifications();
                updateAdminNotificationBadge();
            });
    });
</script>

