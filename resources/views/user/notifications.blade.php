@extends('frontend.layouts.app')

@section('title', 'My Notifications')

@section('content')
<div class="notifications-shell">
    <div class="notifications-hero">
        <div>
            <p class="notifications-kicker">Activity Center</p>
            <h1>Notifications</h1>
            <p class="notifications-subtitle">Open updates faster, filter what matters, and keep your order history tidy.</p>
        </div>
        <div class="notifications-hero-card">
            <span class="hero-stat-label">Unread now</span>
            <strong id="notificationsUnreadCount">0</strong>
            <span class="hero-stat-meta">Live inbox for your orders and account</span>
        </div>
    </div>

    <div class="notifications-toolbar">
        <div class="notification-filters">
            <button class="notification-filter is-active" data-filter="all">All</button>
            <button class="notification-filter" data-filter="order_status">Orders</button>
            <button class="notification-filter" data-filter="delivery">Delivery</button>
            <button class="notification-filter" data-filter="payment">Payments</button>
            <button class="notification-filter" data-filter="support">Support</button>
        </div>
        <div class="notification-toolbar-actions">
            <button id="toggleUnreadBtn" class="notification-ghost-btn" type="button">Unread only</button>
            <button id="markAllNotificationsRead" class="notification-primary-btn" type="button">Mark all as read</button>
        </div>
    </div>

    <div class="notifications-summary">
        <span id="notificationsSummaryText">Loading your latest updates...</span>
        <span id="notificationsPageMeta"></span>
    </div>

    <div id="notificationsList" class="notifications-list">
        <div class="notification-empty-state">
            <strong>Loading notifications...</strong>
            <span>Please wait a moment.</span>
        </div>
    </div>

    <div id="loadMoreContainer" class="notifications-load-more" style="display: none;">
        <button id="loadMoreBtn" class="notification-ghost-btn" type="button">Load more</button>
    </div>
</div>

<style>
    .notifications-shell {
        max-width: 920px;
        margin: 0 auto;
        padding: 2rem 1rem 3rem;
    }

    .notifications-hero {
        display: flex;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 1.5rem;
        padding: 1.5rem;
        border-radius: 28px;
        background: linear-gradient(135deg, #fff7ed 0%, #ffffff 55%, #fffbeb 100%);
        border: 1px solid rgba(251, 146, 60, 0.18);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
    }

    .notifications-kicker {
        margin: 0 0 0.45rem;
        font-size: 0.76rem;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--ud-orange-dark);
    }

    .notifications-hero h1 {
        margin: 0;
        font-size: 2rem;
        line-height: 1.1;
        color: #111827;
    }

    .notifications-subtitle {
        margin: 0.7rem 0 0;
        max-width: 600px;
        font-size: 0.98rem;
        line-height: 1.6;
        color: #6b7280;
    }

    .notifications-hero-card {
        min-width: 180px;
        padding: 1rem 1.1rem;
        border-radius: 22px;
        background: #ffffff;
        border: 1px solid #fed7aa;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9);
    }

    .hero-stat-label,
    .hero-stat-meta {
        color: #6b7280;
        font-size: 0.82rem;
    }

    .notifications-hero-card strong {
        margin: 0.35rem 0;
        font-size: 2rem;
        line-height: 1;
        color: #111827;
    }

    .notifications-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        margin-bottom: 0.9rem;
        flex-wrap: wrap;
    }

    .notification-filters,
    .notification-toolbar-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .notification-filter,
    .notification-ghost-btn,
    .notification-primary-btn,
    .notification-action-btn {
        border: none;
        cursor: pointer;
        transition: all 0.18s ease;
        font-family: inherit;
    }

    .notification-filter,
    .notification-ghost-btn {
        padding: 10px 15px;
        border-radius: 999px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        color: #4b5563;
        font-size: 0.86rem;
        font-weight: 700;
    }

    .notification-filter:hover,
    .notification-ghost-btn:hover {
        border-color: #fdba74;
        color: var(--ud-orange-dark);
        background: #fff7ed;
    }

    .notification-filter.is-active,
    .notification-ghost-btn.is-active {
        background: var(--ud-orange-dark);
        border-color: var(--ud-orange-dark);
        color: #fff;
        box-shadow: 0 12px 22px rgba(234, 88, 12, 0.2);
    }

    .notification-primary-btn {
        padding: 11px 18px;
        border-radius: 999px;
        background: #111827;
        color: #fff;
        font-size: 0.86rem;
        font-weight: 800;
    }

    .notification-primary-btn:hover {
        background: #1f2937;
    }

    .notifications-summary {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 0 4px;
        margin-bottom: 1rem;
        color: #6b7280;
        font-size: 0.88rem;
        flex-wrap: wrap;
    }

    .notifications-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .notification-card {
        display: grid;
        grid-template-columns: 56px minmax(0, 1fr) auto;
        gap: 16px;
        align-items: start;
        padding: 18px;
        background: #fff;
        border-radius: 24px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.06);
        transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
    }

    .notification-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 36px rgba(15, 23, 42, 0.09);
        border-color: #fed7aa;
    }

    .notification-card.unread {
        background: linear-gradient(135deg, #fff7ed 0%, #ffffff 72%);
        border-color: rgba(251, 146, 60, 0.35);
    }

    .notification-icon {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        background: #fff7ed;
        box-shadow: inset 0 0 0 1px rgba(251, 146, 60, 0.16);
    }

    .notification-content {
        min-width: 0;
    }

    .notification-topline {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .notification-type {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--ud-orange-dark);
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .notification-unread-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: var(--ud-orange-dark);
        box-shadow: 0 0 0 6px rgba(255, 237, 213, 0.7);
    }

    .notification-title {
        margin: 0.35rem 0 0;
        color: #111827;
        font-size: 1rem;
        font-weight: 800;
    }

    .notification-message {
        margin: 0.55rem 0 0;
        color: #6b7280;
        line-height: 1.65;
        font-size: 0.93rem;
    }

    .notification-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 0.9rem;
        color: #9ca3af;
        font-size: 0.82rem;
        flex-wrap: wrap;
    }

    .notification-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        color: #4b5563;
        font-size: 0.78rem;
        font-weight: 700;
    }

    .notification-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
    }

    .notification-action-btn {
        padding: 9px 13px;
        border-radius: 999px;
        background: #fff;
        border: 1px solid #e5e7eb;
        color: #374151;
        font-size: 0.82rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .notification-action-btn:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }

    .notification-action-btn.primary {
        background: var(--ud-orange-dark);
        border-color: var(--ud-orange-dark);
        color: #fff;
    }

    .notification-action-btn.primary:hover {
        filter: brightness(0.98);
    }

    .notification-action-btn.danger {
        color: #dc2626;
        border-color: #fecaca;
        background: #fff5f5;
    }

    .notification-empty-state {
        padding: 2.5rem 1.5rem;
        text-align: center;
        border-radius: 24px;
        background: #fff;
        border: 1px solid #e5e7eb;
        color: #6b7280;
    }

    .notification-empty-state strong {
        display: block;
        margin-bottom: 0.35rem;
        color: #111827;
        font-size: 1rem;
    }

    .notifications-load-more {
        text-align: center;
        margin-top: 1.35rem;
    }

    @media (max-width: 780px) {
        .notifications-hero {
            flex-direction: column;
        }

        .notifications-hero-card {
            min-width: 0;
        }

        .notification-card {
            grid-template-columns: 48px minmax(0, 1fr);
        }

        .notification-actions {
            grid-column: 1 / -1;
            flex-direction: row;
            flex-wrap: wrap;
            align-items: center;
        }

        .notification-icon {
            width: 48px;
            height: 48px;
            font-size: 1.5rem;
        }
    }
</style>

<script>
    let currentPage = 1;
    let currentFilter = 'all';
    let unreadOnly = false;
    let isLoading = false;

    function notificationApiFetch(url, options) {
        options = options || {};
        const token = document.querySelector('meta[name="csrf-token"]');
        return fetch(url, Object.assign({
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': token ? token.content : '',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        }, options));
    }

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value == null ? '' : String(value);
        return div.innerHTML;
    }

    function setSummary(text, pageMeta) {
        document.getElementById('notificationsSummaryText').textContent = text;
        document.getElementById('notificationsPageMeta').textContent = pageMeta || '';
    }

    function updateUnreadCount(count) {
        document.getElementById('notificationsUnreadCount').textContent = count || 0;
    }

    function refreshUnreadCount() {
        return notificationApiFetch('{{ route("notifications.unread") }}')
            .then(r => r.json())
            .then(data => {
                updateUnreadCount(data.unread_count || 0);
                return data;
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.notification-filter').forEach(function(button) {
            button.addEventListener('click', function() {
                document.querySelectorAll('.notification-filter').forEach(function(item) {
                    item.classList.remove('is-active');
                });

                this.classList.add('is-active');
                currentFilter = this.dataset.filter;
                currentPage = 1;
                loadNotifications();
            });
        });

        document.getElementById('toggleUnreadBtn').addEventListener('click', function() {
            unreadOnly = !unreadOnly;
            this.classList.toggle('is-active', unreadOnly);
            this.textContent = unreadOnly ? 'Showing unread' : 'Unread only';
            currentPage = 1;
            loadNotifications();
        });

        document.getElementById('markAllNotificationsRead').addEventListener('click', function() {
            notificationApiFetch('{{ route("notifications.mark-all-read") }}', {
                method: 'POST',
                body: JSON.stringify({})
            }).then(function() {
                currentPage = 1;
                loadNotifications();
                if (typeof window.updateUserNotificationBadge === 'function') {
                    window.updateUserNotificationBadge();
                }
            });
        });

        document.getElementById('loadMoreBtn').addEventListener('click', function() {
            currentPage += 1;
            loadNotifications(true);
        });

        refreshUnreadCount();
        loadNotifications();
    });

    function loadNotifications(append = false) {
        if (isLoading) {
            return;
        }

        isLoading = true;

        if (!append) {
            setSummary('Loading your latest updates...', '');
        }

        const params = new URLSearchParams({
            limit: 10,
            page: currentPage
        });

        if (currentFilter !== 'all') {
            params.set('filter', currentFilter);
        }

        if (unreadOnly) {
            params.set('unread_only', 'true');
        }

        notificationApiFetch(`/api/notifications?${params.toString()}`)
            .then(r => r.json())
            .then(data => {
                const list = document.getElementById('notificationsList');
                const items = data.data || [];

                if (!items.length && !append) {
                    list.innerHTML = '<div class="notification-empty-state"><strong>No notifications found.</strong><span>Try a different filter or check back after your next order update.</span></div>';
                    document.getElementById('loadMoreContainer').style.display = 'none';
                    setSummary('No notifications matched your current view.', '');
                    return refreshUnreadCount();
                }

                const html = items.map(function(notification) {
                    const unreadDot = notification.read ? '' : '<span class="notification-unread-dot" aria-hidden="true"></span>';
                    const openButton = notification.action_url
                        ? '<button type="button" class="notification-action-btn primary" onclick="openNotification(' + notification.id + ', \'' + escapeHtml(notification.action_url) + '\')">' + escapeHtml(notification.action_label || 'Open') + '</button>'
                        : '';
                    const markReadButton = notification.read
                        ? ''
                        : '<button type="button" class="notification-action-btn" onclick="markAsRead(' + notification.id + ')">Mark read</button>';

                    return '' +
                        '<article class="notification-card ' + (notification.read ? '' : 'unread') + '">' +
                            '<div class="notification-icon">' + escapeHtml(notification.icon || '!') + '</div>' +
                            '<div class="notification-content">' +
                                '<div class="notification-topline">' +
                                    '<span class="notification-type">' + unreadDot + escapeHtml(notification.type_label || 'Update') + '</span>' +
                                    '<span class="notification-chip">' + escapeHtml(timeAgo(notification.created_at)) + '</span>' +
                                '</div>' +
                                '<h3 class="notification-title">' + escapeHtml(notification.title) + '</h3>' +
                                '<p class="notification-message">' + escapeHtml(notification.message) + '</p>' +
                                '<div class="notification-meta">' +
                                    '<span>' + (notification.read ? 'Read' : 'Unread') + '</span>' +
                                    (notification.action_label ? '<span class="notification-chip">' + escapeHtml(notification.action_label) + '</span>' : '') +
                                '</div>' +
                            '</div>' +
                            '<div class="notification-actions">' +
                                openButton +
                                markReadButton +
                                '<button type="button" class="notification-action-btn danger" onclick="deleteNotification(' + notification.id + ')">Delete</button>' +
                            '</div>' +
                        '</article>';
                }).join('');

                if (append) {
                    list.insertAdjacentHTML('beforeend', html);
                } else {
                    list.innerHTML = html;
                }

                const showingTo = data.to || items.length;
                setSummary(
                    unreadOnly ? 'Showing unread notifications only.' : 'Showing your latest notifications.',
                    'Showing ' + showingTo + ' of ' + (data.total || items.length)
                );

                document.getElementById('loadMoreContainer').style.display = (data.total > data.to) ? 'block' : 'none';
                return refreshUnreadCount();
            })
            .then(function() {
                if (typeof window.updateUserNotificationBadge === 'function') {
                    window.updateUserNotificationBadge();
                }
            })
            .catch(function(error) {
                console.error('Failed to load notifications:', error);
                if (!append) {
                    document.getElementById('notificationsList').innerHTML = '<div class="notification-empty-state"><strong>Could not load notifications.</strong><span>Please refresh and try again.</span></div>';
                    setSummary('Something went wrong while loading notifications.', '');
                }
            })
            .finally(function() {
                isLoading = false;
            });
    }

    function markAsRead(id) {
        notificationApiFetch('/api/notifications/' + id + '/read', {
            method: 'PATCH',
            body: JSON.stringify({})
        }).then(function() {
            currentPage = 1;
            loadNotifications();
        });
    }

    function openNotification(id, url) {
        notificationApiFetch('/api/notifications/' + id + '/read', {
            method: 'PATCH',
            body: JSON.stringify({})
        }).finally(function() {
            window.location.href = url;
        });
    }

    function deleteNotification(id) {
        if (!confirm('Delete this notification?')) {
            return;
        }

        notificationApiFetch('/api/notifications/' + id, {
            method: 'DELETE'
        }).then(function() {
            currentPage = 1;
            loadNotifications();
        });
    }

    function timeAgo(dateString) {
        const date = new Date(dateString);
        const diff = Math.floor((Date.now() - date.getTime()) / 1000);

        if (diff < 60) return 'just now';
        if (diff < 3600) return Math.floor(diff / 60) + 'm ago';
        if (diff < 86400) return Math.floor(diff / 3600) + 'h ago';
        if (diff < 604800) return Math.floor(diff / 86400) + 'd ago';
        return date.toLocaleDateString();
    }
</script>
@endsection
