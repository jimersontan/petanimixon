<aside class="sidebar" id="adminSidebar">
            <nav class="sidebar-nav">
                <!-- Dashboard Link -->
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-page="dashboard">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg></span>
                    <span class="nav-label">Dashboard</span>
                </a>
                <!-- Orders Link -->
                <a href="{{ route('admin.orders') }}" class="nav-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}" data-page="orders">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg></span>
                    <span class="nav-label">Orders</span>
                </a>
                <!-- Products Link -->
                <a href="{{ route('products.readonly') }}" class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}" data-page="products">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M5 8h2V6h10v2h2V6c0-1.1-.9-2-2-2H7V2H5v4c-1.1 0-2 .9-2 2v2zm-2 4v8c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-8H3zm2 2h2v6H5v-6zm4 0h2v6H9v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6z"/></svg></span>
                    <span class="nav-label">Products</span>
                </a>
                <a href="{{ route('inventory.admin') }}" class="nav-item {{ request()->routeIs('inventory.*') ? 'active' : '' }}" data-page="inventory">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/></svg></span>
                    <span class="nav-label">Inventory</span>
                </a>
                <!-- Customers Link -->
                <a href="{{ route('customers.admin') }}" class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }}" data-page="customers">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg></span>
                    <span class="nav-label">Customers</span>
                </a>
                <!-- Riders Link -->
                <a href="{{ route('riders.admin') }}" class="nav-item {{ request()->routeIs('riders.*') ? 'active' : '' }}" data-page="riders">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg></span>
                    <span class="nav-label">Riders</span>
                </a>
                <!-- Couriers Link -->
                <a href="{{ route('couriers.admin') }}" class="nav-item {{ request()->routeIs('couriers.*') ? 'active' : '' }}" data-page="couriers">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M18 18.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5-1.5.67-1.5 1.5.67 1.5 1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c.83 0 1.5-.67 1.5-1.5S6.83 15.5 6 15.5 4.5 16.17 4.5 17s.67 1.5 1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.11.89-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1s1.69.39 2.24 1H15V6H3z"/></svg></span>
                    <span class="nav-label">Couriers</span>
                </a>
                
                <!-- Analytics Link -->
                <a href="{{ route('analytics.admin') }}" class="nav-item {{ request()->routeIs('analytics.*') ? 'active' : '' }}" data-page="analytics">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M5 9.2h3V19H5V9.2zM10.6 5h2.8v14h-2.8V5zm5.6 8H19v6h-2.8v-6z"/></svg></span>
                    <span class="nav-label">Analytics</span>
                </a>
                <!-- Reviews Link -->
                <a href="{{ route('reviews.admin') }}" class="nav-item {{ request()->routeIs('reviews.*') ? 'active' : '' }}" data-page="reviews">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></span>
                    <span class="nav-label">Reviews</span>
                </a>
                <!-- Categories Link -->
                <a href="{{ route('categories.admin') }}" class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}" data-page="categories">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M3 3v8h8V3H3zm6 6H5V5h4v4zm-6 4v8h8v-8H3zm6 6H5v-4h4v4zm4-16v8h8V3h-8zm6 6h-4V5h4v4zm-6 4v8h8v-8h-8zm6 6h-4v-4h4v4z"/></svg></span>
                    <span class="nav-label">Categories</span>
                </a>
                <!-- Brands Link -->
                <a href="{{ route('brands.admin') }}" class="nav-item {{ request()->routeIs('brands.*') ? 'active' : '' }}" data-page="brands">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"/></svg></span>
                    <span class="nav-label">Brands</span>
                </a>

                <!-- Settings Link -->
                <a href="{{ route('settings.admin') }}" class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}" data-page="settings">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M19.14 12.94c.04-.31.06-.63.06-.94 0-.31-.02-.63-.06-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.04.31-.06.63-.06.94s.02.63.06.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96 c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96 c.22.08.47 0 .59-.22l1.92-3.32 c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg></span>
                    <span class="nav-label">Settings</span>
                </a>
                <!-- Coupons Link -->
                <a href="{{ route('coupons.admin') }}" class="nav-item {{ request()->routeIs('coupons.*') ? 'active' : '' }}" data-page="coupons">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58s1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"/></svg></span>
                    <span class="nav-label">Coupons</span>
                </a>
                <!-- Sellers Link -->
                <a href="{{ route('sellers.admin') }}" class="nav-item {{ request()->routeIs('sellers.*') ? 'active' : '' }}" data-page="sellers">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z"/></svg></span>
                    <span class="nav-label">Sellers</span>
                </a>
                <!-- Q&A Link -->
                <a href="{{ route('qa.admin') }}" class="nav-item {{ request()->routeIs('qa.*') ? 'active' : '' }}" data-page="qa">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-7 12h-2v-2h2v2zm0-4h-2V6h2v4z"/></svg></span>
                    <span class="nav-label">Q&A</span>
                </a>
                <!-- Returns Link -->
                <a href="{{ route('returns.admin') }}" class="nav-item {{ request()->routeIs('returns.*') ? 'active' : '' }}" data-page="returns">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/></svg></span>
                    <span class="nav-label">Returns</span>
                </a>
                <!-- Support Chat Link -->
                <a href="{{ route('admin.support-chat') }}" class="nav-item {{ request()->routeIs('admin.support-chat') ? 'active' : '' }}" data-page="support-chat" style="position: relative;">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H5.17L4 17.17V4h16v12z"/><path d="M7 9h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2z"/></svg></span>
                    <span class="nav-label">Support Chat</span>
                    <span id="adminChatBadge" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:#ef4444; color:#fff; border-radius:50%; width:20px; height:20px; font-size:10px; font-weight:700; display:none; align-items:center; justify-content:center;"></span>
                </a>
                <!-- Admin Users Link -->
                <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}" data-page="admin-users">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg></span>
                    <span class="nav-label">Admin Users</span>
                </a>
            </nav>
        </aside>