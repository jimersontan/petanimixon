
<div data-ud-notification-widget="root" style="position: relative; display: inline-block; margin-right: -13px;">
    <button type="button" id="userNotificationBell" class="ud-icon-btn" aria-label="Notifications" title="Notifications" style="text-decoration: none; background: none; border: none; cursor: pointer; padding: 0; position: relative;">
        <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20" aria-hidden="true">
            <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
        </svg>
        <span id="userNotificationBadge" class="notification-badge-header" style="
            position: absolute; top: -4px; right: -4px;
            background: #ef4444; color: #fff; border-radius: 50%;
            width: 18px; height: 18px; align-items: center;
            justify-content: center; font-size: 10px; font-weight: 700;
            display: none; border: 2px solid #fff;">0</span>
    </button>

    <div id="userNotificationPanel" class="ud-notification-panel" style="
        position: absolute; top: 100%; right: 0; margin-top: 8px;
        background: #fff; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        width: min(350px, 92vw); max-height: 500px; overflow-y: auto; display: none;
        z-index: 1000; border: 1px solid #e5e7eb;">
        <style>
            @media (max-width: 600px) {
                #userNotificationPanel {
                    position: fixed !important;
                    top: 56px !important;
                    left: 4vw !important;
                    right: 4vw !important;
                    width: 92vw !important;
                    margin-top: 0 !important;
                    max-height: 70vh !important;
                    border-radius: 12px !important;
                }
            }
        </style>

        <div style="
            padding: 16px; border-bottom: 1px solid #e5e7eb;
            display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 14px; font-weight: 700; color: #1f2937;">Notifications</h3>
            <button type="button" id="markAllRead" class="ud-mark-all-read" style="
                background: none; border: none; color: #ea580c; font-size: 12px;
                font-weight: 600; cursor: pointer;">Mark all as read</button>
        </div>

        <div id="notificationList" style="padding: 12px; min-height: 100px;">
            <div style="text-align: center; padding: 24px; color: #9ca3af; font-size: 14px;">
                Loading notifications...
            </div>
        </div>

        <div style="
            padding: 12px 16px; border-top: 1px solid #e5e7eb;
            text-align: center;">
            <a href="<?php echo e(route('user.notifications')); ?>" style="
                color: #ea580c; text-decoration: none; font-size: 13px;
                font-weight: 600;">View all notifications →</a>
        </div>
    </div>
</div>

<style>
    .ud-notification-item {
        padding: 8px 10px;
        margin-bottom: 4px;
        background: #f9fafb;
        border-radius: 5px;
        border-left: 3px solid #ea580c;
        cursor: pointer;
        transition: all 0.2s;
    }

    .ud-notification-item:hover {
        background: #f3f4f6;
        transform: translateX(2px);
    }

    .ud-notification-item.unread {
        background: #fef3c7;
    }

    .ud-notification-item-icon {
        font-size: 14px;
        margin-right: 6px;
        display: inline-block;
    }

    .ud-notification-item-title {
        font-weight: 600;
        font-size: 11px;
        color: #1f2937;
        display: block;
    }

    .ud-notification-item-message {
        font-size: 10px;
        color: #6b7280;
        display: block;
        margin-top: 2px;
    }

    .ud-notification-item-time {
        font-size: 9px;
        color: #9ca3af;
        display: block;
        margin-top: 3px;
    }

    /* Toast CSS */
    .ud-toast {
        background: #fff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        padding: 16px; min-width: 250px; max-width: 350px;
        display: flex; align-items: flex-start; gap: 12px;
        transform: translateX(120%); opacity: 0;
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.4s ease;
        border-left: 4px solid #ea580c;
        position: relative;
    }
    .ud-toast.show {
        transform: translateX(0); opacity: 1;
    }
    .ud-toast-close {
        background: none; border: none; font-size: 16px; color: #999;
        cursor: pointer; position: absolute; top: 8px; right: 8px;
        padding: 4px; line-height: 1;
    }
    .ud-toast-close:hover { color: #333; }
</style>

<!-- Toast Container -->
<div id="udToastContainer" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px;"></div>

<script>
(function() {
    function csrfHeaders() {
        const t = document.querySelector('meta[name="csrf-token"]');
        return {
            'X-CSRF-TOKEN': t ? t.content : '',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        };
    }

    function notificationFetch(url, options) {
        options = options || {};
        return fetch(url, Object.assign({
            credentials: 'same-origin',
            headers: Object.assign(csrfHeaders(), options.headers || {})
        }, options));
    }

    function escapeHtml(s) {
        if (!s) return '';
        const d = document.createElement('div');
        d.textContent = s;
        return d.innerHTML;
    }

    function timeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diff = Math.floor((now - date) / 1000);

        if (diff < 60) return 'just now';
        if (diff < 3600) return Math.floor(diff / 60) + 'm ago';
        if (diff < 86400) return Math.floor(diff / 3600) + 'h ago';
        if (diff < 604800) return Math.floor(diff / 86400) + 'd ago';
        return date.toLocaleDateString();
    }

    function loadUserNotifications() {
        notificationFetch('<?php echo e(route("notifications.list")); ?>?limit=5')
            .then(function(r) { if (!r.ok) throw new Error('notifications'); return r.json(); })
            .then(function(data) {
                const list = document.getElementById('notificationList');
                if (!list) return;
                if (data.data && data.data.length > 0) {
                    list.innerHTML = data.data.map(function(n) {
                        return '<div class="ud-notification-item ' + (n.read ? '' : 'unread') + '" onclick="window.handleNotificationClick(' + n.id + ')">' +
                            '<span class="ud-notification-item-icon">' + (n.icon || '🔔') + '</span>' +
                            '<span class="ud-notification-item-title">' + escapeHtml(n.title) + '</span>' +
                            '<span class="ud-notification-item-message">' + escapeHtml(n.message) + '</span>' +
                            '<span class="ud-notification-item-time">' + timeAgo(n.created_at) + '</span></div>';
                    }).join('');
                } else {
                    list.innerHTML = '<div style="text-align: center; padding: 24px; color: #9ca3af;">No notifications</div>';
                }
            })
            .catch(function() {
                const list = document.getElementById('notificationList');
                if (list) list.innerHTML = '<div style="text-align: center; padding: 24px; color: #9ca3af;">Could not load notifications</div>';
            });
    }

    var previousUnreadCount = -1;

    window.showNotificationToast = function(title, message, icon) {
        var container = document.getElementById('udToastContainer');
        if (!container) return;

        var toast = document.createElement('div');
        toast.className = 'ud-toast';
        toast.innerHTML = `
            <span style="font-size: 24px; line-height: 1;">${icon || '🔔'}</span>
            <div style="flex: 1; padding-right: 12px;">
                <div style="font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">${escapeHtml(title)}</div>
                <div style="font-size: 13px; color: #6b7280;">${escapeHtml(message)}</div>
            </div>
            <button class="ud-toast-close" onclick="this.parentElement.remove()">×</button>
        `;
        container.appendChild(toast);

        requestAnimationFrame(function() {
            requestAnimationFrame(function() {
                toast.classList.add('show');
            });
        });

        setTimeout(function() {
            if (!toast.parentElement) return;
            toast.style.transform = 'translateX(120%)';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 400);
        }, 6000);
    }

    function checkNewNotifications(newCount) {
        if (previousUnreadCount !== -1 && newCount > previousUnreadCount) {
            notificationFetch('<?php echo e(route("notifications.list")); ?>?limit=1&unread_only=true')
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.data && data.data.length > 0) {
                        var n = data.data[0];
                        window.showNotificationToast(n.title, n.message, n.icon);
                    }
                })
                .catch(function() {});
        }
        previousUnreadCount = newCount;
    }

    function updateUserNotificationBadge() {
        notificationFetch('<?php echo e(route("notifications.unread")); ?>')
            .then(function(r) { if (!r.ok) throw new Error('unread'); return r.json(); })
            .then(function(data) {
                const badge = document.getElementById('userNotificationBadge');
                if (!badge) return;
                var c = data.unread_count || 0;
                
                checkNewNotifications(c);

                if (c > 0) {
                    badge.textContent = c > 99 ? '99+' : c;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            })
            .catch(function() {});
    }

    window.handleNotificationClick = function(notificationId) {
        notificationFetch('/api/notifications/' + notificationId + '/read', { method: 'PATCH' })
            .then(function() {
                loadUserNotifications();
                updateUserNotificationBadge();
            });
    };

    window.loadUserNotifications = loadUserNotifications;
    window.updateUserNotificationBadge = updateUserNotificationBadge;

    var notificationPanelOpen = false;

    document.addEventListener('DOMContentLoaded', function() {
        var root = document.querySelector('[data-ud-notification-widget="root"]');
        if (!root) return;

        var bell = document.getElementById('userNotificationBell');
        var panel = document.getElementById('userNotificationPanel');
        var markAllReadBtn = document.getElementById('markAllRead');
        if (!bell || !panel) return;

        bell.addEventListener('click', function(e) {
            e.stopPropagation();
            if (notificationPanelOpen) {
                panel.style.display = 'none';
                notificationPanelOpen = false;
            } else {
                panel.style.display = 'block';
                notificationPanelOpen = true;
                loadUserNotifications();
            }
        });

        document.addEventListener('click', function(e) {
            if (!notificationPanelOpen) return;
            if (root.contains(e.target)) return;
            panel.style.display = 'none';
            notificationPanelOpen = false;
        });

        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                notificationFetch('<?php echo e(route("notifications.mark-all-read")); ?>', { method: 'POST' })
                    .then(function() {
                        loadUserNotifications();
                        updateUserNotificationBadge();
                    });
            });
        }

        loadUserNotifications();
        updateUserNotificationBadge();

        // SSE-powered badge updates (replaces polling)
        window.updateNotifBadgeFromSSE = function(count) {
            const badge = document.getElementById('userNotificationBadge');
            if (!badge) return;
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        };

        // Fallback: refresh on tab visibility change
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'visible') {
                updateUserNotificationBadge();
                if (notificationPanelOpen) loadUserNotifications();
            }
        });
    });
})();
</script>
<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/components/user_notifications.blade.php ENDPATH**/ ?>