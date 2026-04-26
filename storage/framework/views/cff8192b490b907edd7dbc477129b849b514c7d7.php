<header class="dashboard-header">
    <div class="header-left">
        <button type="button" class="icon-btn btn-hamburger" id="sidebarToggle" aria-label="Toggle Sidebar" style="display: none;">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
        </button>
        <div class="logo" style="display:flex; align-items:center; gap:0;">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Pet Markt-PH Logo" style="max-height: 28px; margin-right: -6px;">
            <span class="logo-text" style="color:#1f2937; margin:0;">Pet <span style="color: var(--ud-orange-dark);">Markt-PH</span></span>
        </div>
    </div>
    <div class="header-center">
        <div class="search-bar">
            <svg class="search-icon" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
            <input type="text" class="search-input" placeholder="Search orders, products, customers...">
        </div>
    </div>
    <div class="header-right">
        <?php echo $__env->make('components.notification_center', [
            'widgetId' => 'adminNotificationCenter',
            'theme' => 'slate',
            'headerTitle' => 'Admin notifications',
            'viewAllUrl' => route('admin.orders'),
            'viewAllText' => 'Open orders board',
            'buttonClass' => 'icon-btn',
            'panelWidth' => '390px',
            'limit' => 8,
            'refreshHookName' => 'updateAdminNotificationBadge',
            'loadHookName' => 'loadAdminNotifications',
            'setBadgeHookName' => 'setAdminNotificationBadgeCount',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="dropdown">
            <button type="button" class="icon-btn dropdown-toggle" id="profileMenuButton" aria-haspopup="true" aria-expanded="false" aria-label="Profile">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </button>
            <div class="dropdown-menu" aria-labelledby="profileMenuButton">
                <a href="<?php echo e(route('admin.profile')); ?>">Your Profile</a>
                <a href="#" id="logoutLink">Logout</a>
                <form id="logoutForm" method="post" action="<?php echo e(route('logout')); ?>" style="display:none;">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.updateAdminNotificationBadge === 'function') {
            window.updateAdminNotificationBadge();
        }

        let adminSSE = null;

        function connectAdminSSE() {
            if (adminSSE) {
                adminSSE.close();
            }

            adminSSE = new EventSource('<?php echo e(route("sse.admin-stream")); ?>');

            adminSSE.addEventListener('notification_count', function(event) {
                try {
                    const data = JSON.parse(event.data);
                    if (typeof window.setAdminNotificationBadgeCount === 'function') {
                        window.setAdminNotificationBadgeCount(data.unread_count || 0);
                    }

                    const widget = window.PetMarktNotifications && window.PetMarktNotifications.registry.adminNotificationCenter;
                    if (widget && widget.isOpen && typeof window.loadAdminNotifications === 'function') {
                        window.loadAdminNotifications();
                    }
                } catch (error) {}
            });

            adminSSE.addEventListener('new_notification', function(event) {
                try {
                    const data = JSON.parse(event.data);
                    if (typeof window.showNotificationToast === 'function') {
                        window.showNotificationToast(data.title, data.message, data.icon);
                    }

                    if (typeof window.loadAdminNotifications === 'function') {
                        window.loadAdminNotifications();
                    }
                } catch (error) {}
            });

            adminSSE.addEventListener('chat_count', function(event) {
                try {
                    const data = JSON.parse(event.data);
                    const chatBadge = document.getElementById('adminChatBadge');
                    if (!chatBadge) {
                        return;
                    }

                    if ((data.unread_count || 0) > 0) {
                        chatBadge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                        chatBadge.style.display = 'flex';
                    } else {
                        chatBadge.style.display = 'none';
                    }
                } catch (error) {}
            });

            adminSSE.addEventListener('reconnect', function() {
                adminSSE.close();
                setTimeout(connectAdminSSE, 2000);
            });

            adminSSE.onerror = function() {
                adminSSE.close();
                setTimeout(connectAdminSSE, 5000);
            };
        }

        connectAdminSSE();

        window.addEventListener('beforeunload', function() {
            if (adminSSE) {
                adminSSE.close();
            }
        });
    });
</script>
<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\Pet Markt-PH\resources\views/partials/admin_header.blade.php ENDPATH**/ ?>