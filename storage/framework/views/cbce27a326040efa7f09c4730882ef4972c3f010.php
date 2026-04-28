<?php echo $__env->make('components.notification_center', [
    'widgetId' => 'userNotificationCenter',
    'theme' => 'orange',
    'headerTitle' => 'Notifications',
    'viewAllUrl' => route('user.notifications'),
    'viewAllText' => 'Manage all notifications',
    'buttonClass' => 'ud-icon-btn',
    'panelWidth' => '390px',
    'panelRight' => '-120px',
    'limit' => 6,
    'loadHookName' => 'loadUserNotifications',
    'refreshHookName' => 'updateUserNotificationBadge',
    'setBadgeHookName' => 'updateNotifBadgeFromSSE',
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\xampp\htdocs\Pet Markt-PH\resources\views/components/user_notifications.blade.php ENDPATH**/ ?>