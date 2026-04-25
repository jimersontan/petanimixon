<header class="rider-header">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
        <span>Pet <span style="color: #059669;">Markt-PH</span></span>
        <span class="rider-badge">Rider</span>
    </div>
    <div class="header-right">
        @include('components.notification_center', [
            'widgetId' => 'riderNotificationCenter',
            'theme' => 'emerald',
            'headerTitle' => 'Rider notifications',
            'viewAllUrl' => route('rider.active'),
            'viewAllText' => 'Open delivery board',
            'buttonClass' => 'icon-btn',
            'panelWidth' => '390px',
            'limit' => 8,
            'refreshHookName' => 'updateRiderNotificationBadge',
            'loadHookName' => 'loadRiderNotifications',
        ])
        <span class="rider-name">{{ Auth::user()->full_name }}</span>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="icon-btn" aria-label="Logout" title="Logout">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
            </button>
        </form>
    </div>
</header>
