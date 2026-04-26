{{-- ═══════════════════════════════════════════════
     Mobile Bottom Navigation Bar
     Shopee-style 5-tab fixed bottom nav
     Hidden on desktop via CSS (min-width: 1025px)
     ═══════════════════════════════════════════════ --}}

<nav class="mob-bottom-nav" id="mobBottomNav" aria-label="Mobile navigation">
    {{-- Home --}}
    <a href="{{ route('shop') }}" class="mob-nav-item {{ request()->routeIs('shop') ? 'active' : '' }}" data-tab="home">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
            @if(request()->routeIs('shop'))
                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" fill="currentColor" stroke="currentColor"/>
                <polyline points="9 22 9 12 15 12 15 22" stroke="#fff" stroke-width="2"/>
            @else
                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            @endif
        </svg>
        <span class="mob-nav-label">Home</span>
    </a>

    {{-- Categories --}}
    <a href="{{ route('categories') }}" class="mob-nav-item {{ request()->routeIs('categories*') ? 'active' : '' }}" data-tab="categories">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
            @if(request()->routeIs('categories*'))
                <rect x="3" y="3" width="7" height="7" rx="1.5" fill="currentColor" stroke="currentColor"/>
                <rect x="14" y="3" width="7" height="7" rx="1.5" fill="currentColor" stroke="currentColor"/>
                <rect x="3" y="14" width="7" height="7" rx="1.5" fill="currentColor" stroke="currentColor"/>
                <rect x="14" y="14" width="7" height="7" rx="1.5" fill="currentColor" stroke="currentColor"/>
            @else
                <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                <rect x="14" y="14" width="7" height="7" rx="1.5"/>
            @endif
        </svg>
        <span class="mob-nav-label">Categories</span>
    </a>

    {{-- Shop --}}
    <a href="{{ route('shop.all') }}" class="mob-nav-item {{ request()->routeIs('shop.all') ? 'active' : '' }}" data-tab="shop">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
            @if(request()->routeIs('shop.all'))
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" fill="currentColor" stroke="currentColor"/>
                <line x1="3" y1="6" x2="21" y2="6" stroke="#fff" stroke-width="2"/>
                <path d="M16 10a4 4 0 0 1-8 0" stroke="#fff" stroke-width="2" fill="none"/>
            @else
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                <line x1="3" y1="6" x2="21" y2="6"/>
                <path d="M16 10a4 4 0 0 1-8 0"/>
            @endif
        </svg>
        <span class="mob-nav-label">Shop</span>
    </a>

    {{-- Orders --}}
    @auth
        <a href="{{ route('orders') }}" class="mob-nav-item {{ request()->routeIs('orders*') ? 'active' : '' }}" data-tab="orders">
    @else
        <button type="button" class="mob-nav-item" data-tab="orders" onclick="showAuthSheet('Sign in to view your orders', 'Track deliveries, manage returns, and view order history.')">
    @endauth
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
            @if(request()->routeIs('orders*'))
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" fill="currentColor" stroke="currentColor"/>
                <polyline points="14 2 14 8 20 8" stroke="#fff" stroke-width="2"/>
                <line x1="16" y1="13" x2="8" y2="13" stroke="#fff" stroke-width="2"/>
                <line x1="16" y1="17" x2="8" y2="17" stroke="#fff" stroke-width="2"/>
            @else
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
            @endif
        </svg>
        <span class="mob-nav-label">Orders</span>
    @auth
        </a>
    @else
        </button>
    @endauth

    {{-- Profile --}}
    @auth
        <a href="{{ route('profile.edit') }}" class="mob-nav-item {{ request()->routeIs('profile*') ? 'active' : '' }}" data-tab="profile">
    @else
        <button type="button" class="mob-nav-item" data-tab="profile" onclick="showAuthSheet('Sign in to your account', 'Manage your profile, addresses, and preferences.')">
    @endauth
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
            @if(request()->routeIs('profile*'))
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" fill="currentColor" stroke="currentColor"/>
                <circle cx="12" cy="7" r="4" fill="currentColor" stroke="currentColor"/>
            @else
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            @endif
        </svg>
        <span class="mob-nav-label">Profile</span>
    @auth
        </a>
    @else
        </button>
    @endauth
</nav>

{{-- ═══ Full-Screen Search Modal ═══ --}}
<div class="mob-search-modal" id="mobSearchModal">
    <div class="mob-search-header">
        <button class="mob-search-back" onclick="closeMobSearch()" aria-label="Close search">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
        </button>
        <div class="mob-search-input-wrap">
            <svg class="mob-search-input-icon" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C8.01 14 6 11.99 6 9.5S8.01 5 10.5 5 15 7.01 15 9.5 12.99 14 10.5 14z"/>
            </svg>
            <input type="text" class="mob-search-input" id="mobSearchInput" placeholder="Search products, brands..." autocomplete="off">
        </div>
    </div>
    <div class="mob-search-body" id="mobSearchBody">
        <div class="mob-search-section-title">🔍 Search for products</div>
        <div class="mob-search-empty">
            <div class="mob-search-empty-icon">🐾</div>
            <div class="mob-search-empty-text">Type to find pet products, brands & more</div>
        </div>
    </div>
</div>

{{-- ═══ Guest Auth Bottom Sheet ═══ --}}
@guest
<div class="mob-auth-sheet-overlay" id="mobAuthOverlay" onclick="hideAuthSheet()"></div>
<div class="mob-auth-sheet" id="mobAuthSheet">
    <div class="mob-auth-sheet-handle"></div>
    <div class="mob-auth-sheet-icon" id="mobAuthIcon">🔐</div>
    <h3 class="mob-auth-sheet-title" id="mobAuthTitle">Sign in required</h3>
    <p class="mob-auth-sheet-desc" id="mobAuthDesc">Please sign in to continue.</p>
    <a href="{{ route('login') }}" class="mob-auth-sheet-login">Sign In</a>
    <button class="mob-auth-sheet-dismiss" onclick="hideAuthSheet()">Continue browsing</button>
</div>
@endguest
