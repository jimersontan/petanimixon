<?php $__env->startSection('title', 'My Notifications'); ?>

<?php $__env->startSection('content'); ?>
<div class="notifications-page" style="max-width: 800px; margin: 0 auto; padding: 2rem;">
    <!-- Page Header -->
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 8px 0;">Notifications</h1>
        <p style="color: #6b7280; margin: 0;">Stay updated with order status, deliveries, and more</p>
    </div>

    <!-- Notification Filters -->
    <div style="display: flex; gap: 8px; margin-bottom: 2rem; flex-wrap: wrap;">
        <button class="notification-filter active" data-filter="all" style="
            padding: 8px 16px; border: 1px solid #ea580c; background: #ea580c;
            color: #fff; border-radius: 20px; font-size: 13px; font-weight: 600;
            cursor: pointer;">All</button>
        <button class="notification-filter" data-filter="order_status" style="
            padding: 8px 16px; border: 1px solid #d1d5db; background: #fff;
            color: #374151; border-radius: 20px; font-size: 13px; font-weight: 600;
            cursor: pointer;">Orders</button>
        <button class="notification-filter" data-filter="delivery" style="
            padding: 8px 16px; border: 1px solid #d1d5db; background: #fff;
            color: #374151; border-radius: 20px; font-size: 13px; font-weight: 600;
            cursor: pointer;">Delivery</button>
        <button class="notification-filter" data-filter="payment" style="
            padding: 8px 16px; border: 1px solid #d1d5db; background: #fff;
            color: #374151; border-radius: 20px; font-size: 13px; font-weight: 600;
            cursor: pointer;">Payments</button>
        <button class="notification-filter" data-filter="promotion" style="
            padding: 8px 16px; border: 1px solid #d1d5db; background: #fff;
            color: #374151; border-radius: 20px; font-size: 13px; font-weight: 600;
            cursor: pointer;">Promotions</button>
    </div>

    <!-- Notifications List -->
    <div id="notificationsList" style="display: flex; flex-direction: column; gap: 12px;">
        <div style="text-align: center; padding: 2rem; color: #9ca3af;">Loading notifications...</div>
    </div>

    <!-- Load More Button -->
    <div id="loadMoreContainer" style="text-align: center; margin-top: 2rem; display: none;">
        <button id="loadMoreBtn" style="
            padding: 12px 24px; background: #f3f4f6; border: 1px solid #d1d5db;
            color: #374151; border-radius: 6px; font-size: 14px; font-weight: 600;
            cursor: pointer;">Load More</button>
    </div>
</div>

<style>
    .notification-card {
        padding: 16px; background: #fff; border-radius: 8px;
        border-left: 4px solid #ea580c; box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        display: flex; gap: 12px; transition: all 0.2s;
    }

    .notification-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .notification-card.unread {
        background: #fef3c7;
        border-left-color: #f59e0b;
    }

    .notification-icon {
        font-size: 28px; min-width: 32px; text-align: center;
    }

    .notification-content {
        flex: 1;
    }

    .notification-title {
        font-weight: 700; font-size: 14px; color: #1f2937; margin: 0;
    }

    .notification-message {
        font-size: 13px; color: #6b7280; margin: 6px 0; line-height: 1.4;
    }

    .notification-meta {
        font-size: 12px; color: #9ca3af;
    }

    .notification-actions {
        display: flex; gap: 8px; align-items: flex-start;
    }

    .notification-action-btn {
        background: none; border: none; color: #ea580c; cursor: pointer;
        font-size: 12px; font-weight: 600; padding: 4px 8px;
    }

    .notification-action-btn:hover {
        text-decoration: underline;
    }
</style>

<script>
    let currentPage = 1;
    let currentFilter = 'all';
    let isLoading = false;

    function notificationApiFetch(url, options) {
        options = options || {};
        const t = document.querySelector('meta[name="csrf-token"]');
        return fetch(url, Object.assign({
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': t ? t.content : '',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        }, options));
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Filter button click handlers
        document.querySelectorAll('.notification-filter').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.notification-filter').forEach(b => {
                    b.style.background = '#fff';
                    b.style.color = '#374151';
                    b.style.borderColor = '#d1d5db';
                });
                this.style.background = '#ea580c';
                this.style.color = '#fff';
                this.style.borderColor = '#ea580c';
                
                currentFilter = this.dataset.filter;
                currentPage = 1;
                loadNotifications();
            });
        });

        // Load More button
        document.getElementById('loadMoreBtn').addEventListener('click', function() {
            currentPage++;
            loadNotifications(true);
        });

        // Initial load
        loadNotifications();
    });

    function loadNotifications(append = false) {
        if (isLoading) return;
        isLoading = true;

        const params = new URLSearchParams({
            limit: 10,
            page: currentPage,
            filter: currentFilter
        });

        notificationApiFetch(`/api/notifications?${params}`)
            .then(r => r.json())
            .then(data => {
                const list = document.getElementById('notificationsList');
                let html = '';

                if (data.data && data.data.length > 0) {
                    html = data.data.map(n => `
                        <div class="notification-card ${n.read ? '' : 'unread'}">
                            <div class="notification-icon">${n.icon}</div>
                            <div class="notification-content">
                                <h3 class="notification-title">${n.title}</h3>
                                <p class="notification-message">${n.message}</p>
                                <span class="notification-meta">${timeAgo(n.created_at)}</span>
                            </div>
                            <div class="notification-actions">
                                ${n.read ? '' : `<button class="notification-action-btn" onclick="markAsRead(${n.id})">Mark read</button>`}
                                <button class="notification-action-btn" onclick="deleteNotification(${n.id})" style="color: #ef4444;">Delete</button>
                            </div>
                        </div>
                    `).join('');

                    if (append) {
                        list.innerHTML += html;
                    } else {
                        list.innerHTML = html;
                    }

                    // Show/hide load more button
                    document.getElementById('loadMoreContainer').style.display = 
                        (data.total > data.to) ? 'block' : 'none';
                } else if (!append) {
                    list.innerHTML = '<div style="text-align: center; padding: 2rem; color: #9ca3af;">No notifications</div>';
                }

                isLoading = false;
            })
            .catch(e => {
                console.error('Failed to load notifications:', e);
                isLoading = false;
            });
    }

    function markAsRead(id) {
        notificationApiFetch(`/api/notifications/${id}/read`, {method: 'PATCH'})
            .then(() => {
                loadNotifications();
                if (typeof window.updateUserNotificationBadge === 'function') {
                    window.updateUserNotificationBadge();
                }
            });
    }

    function deleteNotification(id) {
        if (confirm('Delete this notification?')) {
            notificationApiFetch(`/api/notifications/${id}`, {method: 'DELETE'})
                .then(() => {
                    loadNotifications();
                    if (typeof window.updateUserNotificationBadge === 'function') {
                        window.updateUserNotificationBadge();
                    }
                });
        }
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
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/user/notifications.blade.php ENDPATH**/ ?>