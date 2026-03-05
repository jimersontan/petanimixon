<header class="sh-header">
    <div class="sh-header-inner">
        <a href="{{ route('home') }}" class="sh-logo">
            <span class="sh-logo-icon">🐾</span>
            <span class="sh-logo-text"><strong>Pet</strong> Animixon</span>
        </a>
        <nav class="sh-nav">
            <a href="{{ route('home') }}" class="sh-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('shop.categories') }}" class="sh-nav-link {{ request()->routeIs('shop.categories') ? 'active' : '' }}">Categories</a>
            <a href="{{ route('shop.products') }}" class="sh-nav-link {{ request()->routeIs('shop.products') ? 'active' : '' }}">Shop</a>
            <a href="#" class="sh-nav-link">Blog</a>
            <a href="#" class="sh-nav-link">Contact</a>
            <a href="#" class="sh-nav-link">Brands</a>
            <a href="#" class="sh-nav-link">FAQ</a>
            <a href="#" class="sh-nav-link">About</a>
        </nav>
        <div class="sh-header-actions">
            <button class="sh-icon-btn" aria-label="Search"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg></button>
            <a href="{{ route('cart') }}" class="sh-icon-btn" aria-label="Wishlist"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></a>
            <a href="{{ route('cart') }}" class="sh-icon-btn sh-cart-btn" aria-label="Cart">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
                <span class="sh-cart-badge">3</span>
            </a>
            <div class="sh-user-wrap">
                <button class="sh-icon-btn sh-user-btn" id="shUserBtn">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </button>
                <div class="sh-user-drop" id="shUserDrop">
                    <a href="{{ route('orders') }}">My Orders</a>
                    <a href="#">FAQ</a>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Logout</button></form>
                </div>
            </div>
        </div>
    </div>
</header>
