@include('components.notification_center', [
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
])
