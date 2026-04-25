<?php
    $widgetId = $widgetId ?? 'notificationCenter';
    $theme = $theme ?? 'orange';
    $headerTitle = $headerTitle ?? 'Notifications';
    $viewAllUrl = $viewAllUrl ?? null;
    $viewAllText = $viewAllText ?? 'View all notifications';
    $emptyMessage = $emptyMessage ?? 'No notifications yet.';
    $loadingMessage = $loadingMessage ?? 'Loading notifications...';
    $buttonClass = $buttonClass ?? '';
    $panelWidth = $panelWidth ?? '380px';
    $panelRight = $panelRight ?? '0';
    $limit = $limit ?? 8;
    $showFooter = $showFooter ?? true;
    $refreshHookName = $refreshHookName ?? null;
    $loadHookName = $loadHookName ?? null;
    $setBadgeHookName = $setBadgeHookName ?? null;
?>

<div
    id="<?php echo e($widgetId); ?>"
    class="pmn-root pmn-theme-<?php echo e($theme); ?>"
    data-pmn-root
    data-limit="<?php echo e($limit); ?>"
    data-empty-message="<?php echo e($emptyMessage); ?>"
    style="--pmn-width: <?php echo e($panelWidth); ?>; --pmn-right: <?php echo e($panelRight); ?>;"
>
    <button
        type="button"
        class="pmn-trigger <?php echo e($buttonClass); ?>"
        data-pmn="trigger"
        aria-label="<?php echo e($headerTitle); ?>"
        title="<?php echo e($headerTitle); ?>"
    >
        <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20" aria-hidden="true">
            <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
        </svg>
        <span class="pmn-badge" data-pmn="badge" style="display:none;">0</span>
    </button>

    <div class="pmn-panel" data-pmn="panel" style="display:none;">
        <div class="pmn-panel-arrow" aria-hidden="true"></div>
        <div class="pmn-header">
            <div>
                <h3><?php echo e($headerTitle); ?></h3>
                <p data-pmn="summary">Stay updated with the latest activity.</p>
            </div>
            <div class="pmn-header-actions">
                <button type="button" class="pmn-chip is-active" data-pmn="filter">All</button>
                <button type="button" class="pmn-chip" data-pmn="filter-orders">Orders</button>
                <button type="button" class="pmn-chip" data-pmn="filter-delivery">Delivery</button>
                <button type="button" class="pmn-link-btn" data-pmn="mark-all">Mark all</button>
            </div>
        </div>

        <div class="pmn-list-wrap">
            <div class="pmn-list" data-pmn="list">
                <div class="pmn-empty">
                    <strong><?php echo e($loadingMessage); ?></strong>
                </div>
            </div>
        </div>

        <?php if($showFooter && $viewAllUrl): ?>
            <div class="pmn-footer">
                <a href="<?php echo e($viewAllUrl); ?>"><?php echo e($viewAllText); ?></a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .pmn-root {
        position: relative;
        display: inline-flex;
        align-items: center;
        --pmn-accent: #ea580c;
        --pmn-accent-soft: #fff7ed;
        --pmn-badge-shadow: rgba(234, 88, 12, 0.28);
        --pmn-border: #e5e7eb;
        --pmn-text: #111827;
        --pmn-muted: #6b7280;
        --pmn-surface: #ffffff;
        --pmn-item: #f8fafc;
        --pmn-unread: #fff7ed;
    }

    .pmn-root.pmn-theme-slate {
        --pmn-accent: #f97316;
        --pmn-accent-soft: #fff7ed;
        --pmn-badge-shadow: rgba(249, 115, 22, 0.28);
    }

    .pmn-root.pmn-theme-emerald {
        --pmn-accent: #059669;
        --pmn-accent-soft: #ecfdf5;
        --pmn-badge-shadow: rgba(5, 150, 105, 0.24);
        --pmn-unread: #ecfdf5;
    }

    .pmn-root.pmn-theme-orange {
        --pmn-accent: #ea580c;
        --pmn-accent-soft: #fff7ed;
        --pmn-badge-shadow: rgba(234, 88, 12, 0.28);
    }

    .pmn-trigger {
        position: relative;
    }

    .pmn-badge {
        position: absolute;
        top: -4px;
        right: -5px;
        min-width: 18px;
        height: 18px;
        padding: 0 5px;
        border-radius: 999px;
        background: #ef4444;
        color: #fff;
        border: 2px solid #fff;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 700;
        line-height: 1;
        box-shadow: 0 6px 16px var(--pmn-badge-shadow);
        pointer-events: none;
    }

    .pmn-panel {
        position: absolute;
        top: calc(100% + 14px);
        right: var(--pmn-right);
        width: min(var(--pmn-width), calc(100vw - 24px));
        max-height: min(560px, calc(100vh - 110px));
        background: var(--pmn-surface);
        border: 1px solid rgba(229, 231, 235, 0.95);
        border-radius: 20px;
        box-shadow: 0 22px 48px rgba(15, 23, 42, 0.16);
        overflow: hidden;
        z-index: 1100;
        text-align: left;
    }

    .pmn-panel-arrow {
        position: absolute;
        top: -7px;
        right: 26px;
        width: 14px;
        height: 14px;
        background: var(--pmn-surface);
        border-top: 1px solid rgba(229, 231, 235, 0.95);
        border-left: 1px solid rgba(229, 231, 235, 0.95);
        transform: rotate(45deg);
    }

    .pmn-header {
        padding: 18px 18px 14px;
        border-bottom: 1px solid var(--pmn-border);
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(249, 250, 251, 0.92));
    }

    .pmn-header h3 {
        margin: 0;
        font-size: 15px;
        font-weight: 800;
        color: var(--pmn-text);
    }

    .pmn-header p {
        margin: 5px 0 0;
        font-size: 12px;
        color: var(--pmn-muted);
    }

    .pmn-header-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        margin-top: 14px;
        flex-wrap: wrap;
    }

    .pmn-chip,
    .pmn-link-btn {
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .pmn-chip {
        padding: 7px 11px;
        border-radius: 999px;
        background: #f3f4f6;
        color: #4b5563;
        font-size: 11px;
        font-weight: 700;
    }

    .pmn-chip.is-active,
    .pmn-chip:hover {
        background: var(--pmn-accent-soft);
        color: var(--pmn-accent);
    }

    .pmn-link-btn {
        margin-left: auto;
        background: transparent;
        color: var(--pmn-accent);
        font-size: 12px;
        font-weight: 700;
        padding: 6px 0;
    }

    .pmn-link-btn:hover {
        opacity: 0.75;
    }

    .pmn-list-wrap {
        max-height: 410px;
        overflow-y: auto;
        background: linear-gradient(180deg, #fff 0%, #fafafa 100%);
    }

    .pmn-list {
        padding: 12px;
    }

    .pmn-item {
        position: relative;
        display: grid;
        grid-template-columns: 44px minmax(0, 1fr);
        gap: 12px;
        padding: 14px;
        margin-bottom: 10px;
        border-radius: 16px;
        background: var(--pmn-item);
        border: 1px solid rgba(229, 231, 235, 0.9);
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
    }

    .pmn-item:hover {
        transform: translateY(-1px);
        border-color: rgba(209, 213, 219, 0.95);
        box-shadow: 0 14px 24px rgba(15, 23, 42, 0.08);
    }

    .pmn-item.is-unread {
        background: var(--pmn-unread);
        border-color: rgba(253, 186, 116, 0.4);
    }

    .pmn-item:last-child {
        margin-bottom: 0;
    }

    .pmn-item-icon {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        background: var(--pmn-accent-soft);
        color: var(--pmn-accent);
        box-shadow: inset 0 0 0 1px rgba(234, 88, 12, 0.08);
    }

    .pmn-item-body {
        min-width: 0;
    }

    .pmn-item-top {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        align-items: flex-start;
    }

    .pmn-item-title {
        margin: 0;
        color: var(--pmn-text);
        font-size: 13px;
        font-weight: 800;
        line-height: 1.35;
    }

    .pmn-type {
        flex-shrink: 0;
        border-radius: 999px;
        padding: 4px 8px;
        background: rgba(255, 255, 255, 0.9);
        color: var(--pmn-accent);
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .pmn-item-message {
        margin: 8px 0 0;
        color: var(--pmn-muted);
        font-size: 12px;
        line-height: 1.55;
    }

    .pmn-item-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-top: 12px;
    }

    .pmn-time {
        color: #9ca3af;
        font-size: 11px;
        font-weight: 600;
    }

    .pmn-unread-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: var(--pmn-accent);
        box-shadow: 0 0 0 5px rgba(255, 255, 255, 0.7);
    }

    .pmn-item-actions {
        display: flex;
        gap: 8px;
        margin-top: 12px;
        flex-wrap: wrap;
    }

    .pmn-action-btn {
        border: 1px solid rgba(209, 213, 219, 0.95);
        background: #fff;
        color: #374151;
        border-radius: 999px;
        padding: 7px 11px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.18s ease;
    }

    .pmn-action-btn:hover {
        border-color: rgba(156, 163, 175, 0.95);
        background: #f9fafb;
    }

    .pmn-action-btn.primary {
        background: var(--pmn-accent);
        border-color: var(--pmn-accent);
        color: #fff;
    }

    .pmn-action-btn.primary:hover {
        filter: brightness(0.96);
    }

    .pmn-empty {
        padding: 28px 20px;
        text-align: center;
        color: var(--pmn-muted);
        font-size: 13px;
    }

    .pmn-empty strong {
        display: block;
        font-size: 14px;
        color: var(--pmn-text);
        margin-bottom: 6px;
    }

    .pmn-footer {
        border-top: 1px solid var(--pmn-border);
        background: #fff;
    }

    .pmn-footer a {
        display: block;
        padding: 14px 18px;
        text-align: center;
        font-size: 12px;
        font-weight: 800;
        color: var(--pmn-accent);
        text-decoration: none;
    }

    .pmn-footer a:hover {
        background: var(--pmn-accent-soft);
    }

    .pmn-toast-stack {
        position: fixed;
        right: 18px;
        bottom: 18px;
        z-index: 4000;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .pmn-toast {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        min-width: 280px;
        max-width: 360px;
        padding: 14px 16px;
        border-radius: 16px;
        background: #fff;
        border: 1px solid rgba(229, 231, 235, 0.95);
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.16);
        transform: translateX(120%);
        opacity: 0;
        transition: transform 0.28s ease, opacity 0.28s ease;
    }

    .pmn-toast.is-visible {
        transform: translateX(0);
        opacity: 1;
    }

    .pmn-toast-icon {
        font-size: 22px;
        line-height: 1;
    }

    .pmn-toast-title {
        margin: 0 0 4px;
        font-size: 13px;
        font-weight: 800;
        color: #111827;
    }

    .pmn-toast-message {
        margin: 0;
        font-size: 12px;
        line-height: 1.5;
        color: #6b7280;
    }

    .pmn-toast-close {
        margin-left: auto;
        border: none;
        background: transparent;
        color: #9ca3af;
        cursor: pointer;
        font-size: 16px;
        line-height: 1;
        padding: 0;
    }

    @media (max-width: 640px) {
        .pmn-panel {
            position: fixed;
            top: 68px;
            left: 12px;
            right: 12px;
            width: auto;
            max-height: calc(100vh - 88px);
        }

        .pmn-panel-arrow {
            display: none;
        }

        .pmn-link-btn {
            margin-left: 0;
        }
    }
</style>

<script>
    (function () {
        function ready(callback) {
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', callback, { once: true });
                return;
            }

            callback();
        }

        if (!window.PetMarktNotifications) {
            const registry = {};

            function getToastStack() {
                let stack = document.querySelector('.pmn-toast-stack');
                if (!stack) {
                    stack = document.createElement('div');
                    stack.className = 'pmn-toast-stack';
                    document.body.appendChild(stack);
                }

                return stack;
            }

            function csrfHeaders() {
                const token = document.querySelector('meta[name="csrf-token"]');

                return {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token ? token.content : '<?php echo e(csrf_token()); ?>',
                    'X-Requested-With': 'XMLHttpRequest'
                };
            }

            function request(url, options) {
                const config = Object.assign({
                    credentials: 'same-origin',
                    headers: csrfHeaders()
                }, options || {});

                config.headers = Object.assign(csrfHeaders(), (options && options.headers) || {});

                return fetch(url, config).then(function (response) {
                    if (!response.ok) {
                        throw new Error('notification-request-failed');
                    }

                    return response.json();
                });
            }

            function escapeHtml(value) {
                const div = document.createElement('div');
                div.textContent = value == null ? '' : String(value);
                return div.innerHTML;
            }

            function timeAgo(dateString) {
                const date = new Date(dateString);
                const seconds = Math.floor((Date.now() - date.getTime()) / 1000);

                if (seconds < 60) {
                    return 'just now';
                }

                if (seconds < 3600) {
                    return Math.floor(seconds / 60) + 'm ago';
                }

                if (seconds < 86400) {
                    return Math.floor(seconds / 3600) + 'h ago';
                }

                if (seconds < 604800) {
                    return Math.floor(seconds / 86400) + 'd ago';
                }

                return date.toLocaleDateString();
            }

            function showToast(title, message, icon) {
                const stack = getToastStack();
                const toast = document.createElement('div');
                toast.className = 'pmn-toast';
                toast.innerHTML = '' +
                    '<div class="pmn-toast-icon">' + escapeHtml(icon || '!') + '</div>' +
                    '<div>' +
                        '<p class="pmn-toast-title">' + escapeHtml(title || 'Notification') + '</p>' +
                        '<p class="pmn-toast-message">' + escapeHtml(message || '') + '</p>' +
                    '</div>' +
                    '<button type="button" class="pmn-toast-close" aria-label="Close">x</button>';

                stack.appendChild(toast);

                const removeToast = function () {
                    toast.classList.remove('is-visible');
                    setTimeout(function () {
                        if (toast.parentNode) {
                            toast.parentNode.removeChild(toast);
                        }
                    }, 240);
                };

                toast.querySelector('.pmn-toast-close').addEventListener('click', removeToast);

                requestAnimationFrame(function () {
                    toast.classList.add('is-visible');
                });

                setTimeout(removeToast, 5000);
            }

            function setBadge(widget, count) {
                widget.unreadCount = count;
                widget.refs.badge.textContent = count > 99 ? '99+' : count;
                widget.refs.badge.style.display = count > 0 ? 'flex' : 'none';

                if (widget.refs.summary) {
                    if (count > 0) {
                        widget.refs.summary.textContent = count + ' unread notification' + (count === 1 ? '' : 's') + '.';
                    } else {
                        widget.refs.summary.textContent = 'All caught up.';
                    }
                }
            }

            function renderList(widget, items) {
                if (!items.length) {
                    widget.refs.list.innerHTML = '' +
                        '<div class="pmn-empty">' +
                            '<strong>' + escapeHtml(widget.emptyMessage) + '</strong>' +
                            '<span>New updates will appear here.</span>' +
                        '</div>';
                    return;
                }

                widget.refs.list.innerHTML = items.map(function (item) {
                    const unreadClass = item.read ? '' : ' is-unread';
                    const unreadDot = item.read ? '' : '<span class="pmn-unread-dot" aria-hidden="true"></span>';
                    const openLabel = escapeHtml(item.action_label || 'Open');
                    const openButton = item.action_url
                        ? '<button type="button" class="pmn-action-btn primary" data-notification-action="open">' + openLabel + '</button>'
                        : '';
                    const markReadButton = item.read
                        ? ''
                        : '<button type="button" class="pmn-action-btn" data-notification-action="mark-read">Mark read</button>';

                    return '' +
                        '<article class="pmn-item' + unreadClass + '" tabindex="0" data-id="' + item.id + '" data-url="' + escapeHtml(item.action_url || '') + '">' +
                            '<div class="pmn-item-icon">' + escapeHtml(item.icon || '!') + '</div>' +
                            '<div class="pmn-item-body">' +
                                '<div class="pmn-item-top">' +
                                    '<h4 class="pmn-item-title">' + escapeHtml(item.title) + '</h4>' +
                                    '<span class="pmn-type">' + escapeHtml(item.type_label || 'Update') + '</span>' +
                                '</div>' +
                                '<p class="pmn-item-message">' + escapeHtml(item.message) + '</p>' +
                                '<div class="pmn-item-meta">' +
                                    '<span class="pmn-time">' + escapeHtml(timeAgo(item.created_at)) + '</span>' +
                                    unreadDot +
                                '</div>' +
                                '<div class="pmn-item-actions">' +
                                    openButton +
                                    markReadButton +
                                '</div>' +
                            '</div>' +
                        '</article>';
                }).join('');
            }

            function refreshBadge(widget) {
                return request('<?php echo e(route("notifications.unread")); ?>').then(function (data) {
                    setBadge(widget, data.unread_count || 0);
                    return data;
                }).catch(function () {
                    return null;
                });
            }

            function load(widget) {
                widget.refs.list.innerHTML = '<div class="pmn-empty"><strong><?php echo e($loadingMessage); ?></strong></div>';

                let url = '<?php echo e(route("notifications.list")); ?>?limit=' + widget.limit;
                if (widget.unreadOnly) {
                    url += '&unread_only=true';
                }

                return request(url).then(function (payload) {
                    renderList(widget, payload.data || []);
                    return refreshBadge(widget);
                }).catch(function () {
                    widget.refs.list.innerHTML = '' +
                        '<div class="pmn-empty">' +
                            '<strong>Could not load notifications.</strong>' +
                            '<span>Please try again.</span>' +
                        '</div>';
                    return null;
                });
            }

            function markRead(widget, id) {
                return request('/api/notifications/' + id + '/read', {
                    method: 'PATCH',
                    body: JSON.stringify({})
                }).then(function () {
                    return load(widget);
                });
            }

            function markAll(widget) {
                return request('<?php echo e(route("notifications.mark-all-read")); ?>', {
                    method: 'POST',
                    body: JSON.stringify({})
                }).then(function () {
                    return load(widget);
                });
            }

            function togglePanel(widget, forceState) {
                const shouldOpen = typeof forceState === 'boolean' ? forceState : widget.refs.panel.style.display === 'none';
                widget.refs.panel.style.display = shouldOpen ? 'block' : 'none';
                widget.isOpen = shouldOpen;

                if (shouldOpen) {
                    load(widget);
                }
            }

            function initRoot(root) {
                if (!root || root.dataset.pmnReady === 'true') {
                    return;
                }

                root.dataset.pmnReady = 'true';

                const widget = {
                    id: root.id,
                    root: root,
                    limit: Number(root.dataset.limit || 8),
                    emptyMessage: root.dataset.emptyMessage || 'No notifications yet.',
                    unreadOnly: false,
                    unreadCount: 0,
                    isOpen: false,
                    refs: {
                        trigger: root.querySelector('[data-pmn="trigger"]'),
                        panel: root.querySelector('[data-pmn="panel"]'),
                        badge: root.querySelector('[data-pmn="badge"]'),
                        list: root.querySelector('[data-pmn="list"]'),
                        filter: root.querySelector('[data-pmn="filter"]'),
                        refresh: root.querySelector('[data-pmn="refresh"]'),
                        orders: root.querySelector('[data-pmn="filter-orders"]'),
                        delivery: root.querySelector('[data-pmn="filter-delivery"]'),
                        markAll: root.querySelector('[data-pmn="mark-all"]'),
                        summary: root.querySelector('[data-pmn="summary"]')
                    }
                };

                registry[widget.id] = widget;
                root.__notificationWidget = widget;

                widget.refs.trigger.addEventListener('click', function (event) {
                    event.stopPropagation();
                    togglePanel(widget);
                });

                if (widget.refs.refresh) {
                    widget.refs.refresh.addEventListener('click', function (event) {
                        event.stopPropagation();
                        load(widget);
                    });
                }

                if (widget.refs.orders) {
                    widget.refs.orders.addEventListener('click', function (event) {
                        event.stopPropagation();
                        // For now, toggle active state
                        widget.refs.filter.classList.remove('is-active');
                        if (widget.refs.delivery) widget.refs.delivery.classList.remove('is-active');
                        widget.refs.orders.classList.add('is-active');
                        load(widget);
                    });
                }

                if (widget.refs.delivery) {
                    widget.refs.delivery.addEventListener('click', function (event) {
                        event.stopPropagation();
                        // For now, toggle active state
                        widget.refs.filter.classList.remove('is-active');
                        if (widget.refs.orders) widget.refs.orders.classList.remove('is-active');
                        widget.refs.delivery.classList.add('is-active');
                        load(widget);
                    });
                }

                if (widget.refs.filter) {
                    widget.refs.filter.addEventListener('click', function (event) {
                        event.stopPropagation();
                        widget.unreadOnly = !widget.unreadOnly;
                        widget.refs.filter.textContent = widget.unreadOnly ? 'Unread only' : 'All';
                        if (widget.refs.orders) widget.refs.orders.classList.remove('is-active');
                        if (widget.refs.delivery) widget.refs.delivery.classList.remove('is-active');
                        widget.refs.filter.classList.toggle('is-active', widget.unreadOnly || !widget.unreadOnly);
                        load(widget);
                    });
                }

                if (widget.refs.markAll) {
                    widget.refs.markAll.addEventListener('click', function (event) {
                        event.stopPropagation();
                        markAll(widget);
                    });
                }

                widget.refs.list.addEventListener('click', function (event) {
                    const actionButton = event.target.closest('[data-notification-action]');
                    const item = event.target.closest('.pmn-item');
                    if (!item) {
                        return;
                    }

                    const notificationId = item.getAttribute('data-id');
                    const actionUrl = item.getAttribute('data-url');

                    if (actionButton) {
                        event.stopPropagation();

                        if (actionButton.getAttribute('data-notification-action') === 'mark-read') {
                            markRead(widget, notificationId);
                            return;
                        }

                        markRead(widget, notificationId).finally(function () {
                            if (actionUrl) {
                                window.location.href = actionUrl;
                            }
                        });
                        return;
                    }

                    markRead(widget, notificationId).finally(function () {
                        if (actionUrl) {
                            window.location.href = actionUrl;
                        }
                    });
                });

                widget.refs.list.addEventListener('keydown', function (event) {
                    if (event.key !== 'Enter' && event.key !== ' ') {
                        return;
                    }

                    const item = event.target.closest('.pmn-item');
                    if (!item) {
                        return;
                    }

                    event.preventDefault();
                    item.click();
                });

                document.addEventListener('click', function (event) {
                    if (!widget.isOpen) {
                        return;
                    }

                    if (widget.root.contains(event.target)) {
                        return;
                    }

                    togglePanel(widget, false);
                });

                document.addEventListener('visibilitychange', function () {
                    if (document.visibilityState !== 'visible') {
                        return;
                    }

                    refreshBadge(widget);
                    if (widget.isOpen) {
                        load(widget);
                    }
                });

                refreshBadge(widget);
            }

            window.PetMarktNotifications = {
                registry: registry,
                initRoot: initRoot,
                refreshById: function (id) {
                    const widget = registry[id];
                    return widget ? load(widget) : Promise.resolve();
                },
                refreshBadgeById: function (id) {
                    const widget = registry[id];
                    return widget ? refreshBadge(widget) : Promise.resolve();
                },
                setBadgeCountById: function (id, count) {
                    const widget = registry[id];
                    if (widget) {
                        setBadge(widget, count);
                    }
                },
                showToast: showToast
            };

            window.showNotificationToast = showToast;
        }

        ready(function () {
            document.querySelectorAll('[data-pmn-root]').forEach(window.PetMarktNotifications.initRoot);
        });
    })();
</script>

<?php if($loadHookName || $refreshHookName || $setBadgeHookName): ?>
    <script>
        (function () {
            function assignHooks() {
                <?php if($loadHookName): ?>
                    window['<?php echo e($loadHookName); ?>'] = function () {
                        return window.PetMarktNotifications.refreshById('<?php echo e($widgetId); ?>');
                    };
                <?php endif; ?>

                <?php if($refreshHookName): ?>
                    window['<?php echo e($refreshHookName); ?>'] = function () {
                        return window.PetMarktNotifications.refreshBadgeById('<?php echo e($widgetId); ?>');
                    };
                <?php endif; ?>

                <?php if($setBadgeHookName): ?>
                    window['<?php echo e($setBadgeHookName); ?>'] = function (count) {
                        return window.PetMarktNotifications.setBadgeCountById('<?php echo e($widgetId); ?>', count || 0);
                    };
                <?php endif; ?>
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', assignHooks, { once: true });
            } else {
                assignHooks();
            }
        })();
    </script>
<?php endif; ?>
<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\Pet Markt-PH\resources\views/components/notification_center.blade.php ENDPATH**/ ?>