<!-- ===== ADMIN LAYOUT: Main wrapper for all admin pages ===== -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Pet Animixon Admin</title>
    <!-- CSRF Token: Used by AJAX requests for security -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Core Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}">
    <!-- Select2: Searchable dropdown library -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Paste Upload: Shared styles for drag-and-drop + paste image zones -->
    <style>
        /* ===== PASTE UPLOAD ZONE ===== */
        .paste-upload-zone {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 20px 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fafbfc;
            position: relative;
        }
        .paste-upload-zone:hover,
        .paste-upload-zone.dragover {
            border-color: #ea580c;
            background: #fff7ed;
        }
        .paste-upload-zone.has-file {
            border-color: #22c55e;
            background: #f0fdf4;
        }
        .paste-upload-zone .upload-icon {
            width: 40px; height: 40px;
            margin: 0 auto 8px;
            color: #9ca3af;
            transition: color 0.3s;
        }
        .paste-upload-zone:hover .upload-icon,
        .paste-upload-zone.dragover .upload-icon { color: #ea580c; }
        .paste-upload-zone.has-file .upload-icon { color: #22c55e; }
        .paste-upload-zone .upload-title {
            font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 4px;
        }
        .paste-upload-zone .upload-hint {
            font-size: 11px; color: #9ca3af;
        }
        .paste-upload-zone .upload-hint kbd {
            background: #f3f4f6; border: 1px solid #e5e7eb;
            border-radius: 4px; padding: 1px 5px; font-size: 10px;
            font-family: inherit; color: #6b7280;
        }
        .paste-upload-zone .upload-preview {
            margin-top: 10px;
        }
        .paste-upload-zone .upload-preview img {
            max-height: 90px; max-width: 100%;
            border-radius: 8px; border: 2px solid #e5e7eb;
            object-fit: cover;
        }
        .paste-upload-zone .upload-filename {
            font-size: 11px; color: #16a34a; font-weight: 600;
            margin-top: 6px; word-break: break-all;
        }
        .paste-upload-zone .remove-file-btn {
            position: absolute; top: 8px; right: 8px;
            background: #fee2e2; border: none; color: #dc2626;
            width: 22px; height: 22px; border-radius: 50%;
            cursor: pointer; font-size: 12px; line-height: 22px;
            display: none; transition: all 0.2s;
        }
        .paste-upload-zone.has-file .remove-file-btn { display: block; }
        .paste-upload-zone .remove-file-btn:hover { background: #fca5a5; }
    </style>
    <!-- Page-specific styles injected here -->
    @stack('styles')
</head>
<body class="dashboard-body">

    <!-- ===== HEADER SECTION ===== -->
    <!-- Top navigation bar with logo, search, and user actions -->
    <header class="dashboard-header">

        <!-- Logo and Brand Name -->
        <div class="header-left">
            <div class="logo" style="display:flex; align-items:center; gap:8px;">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-height: 28px;">
                <span class="logo-text" style="color:#1f2937;">Pet <span style="color: #ea580c;">Animixon</span></span>
            </div>
        </div>
        <!-- End: Logo -->

        <!-- Search Bar -->
        <div class="header-center">
            <div class="search-bar">
                <svg class="search-icon" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                <input type="text" class="search-input" placeholder="Search orders, products, customers...">
            </div>
        </div>
        <!-- End: Search Bar -->

        <!-- User Actions: Notifications, Profile, Settings -->
        <div class="header-right">
            <!-- Notifications Bell -->
            <button type="button" class="icon-btn" aria-label="Notifications">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
            </button>
            <!-- Profile Icon -->
            <button type="button" class="icon-btn" aria-label="Profile">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </button>
            <!-- Settings Gear -->
            <button type="button" class="icon-btn" aria-label="Settings">
                <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M11.4 24H0V12.6h2.4v9.4h9v2.4zm12-12H12.6V0H24v2.4h-9.6v9.6H24V12zM2.4 9.6V0h2.4v9.6H2.4zm19.2 0V0H24v9.6h-2.4zM9.6 2.4V0h4.8v2.4H9.6zm4.8 19.2v-2.4h4.8V24h-4.8z"/></svg>
            </button>
        </div>
        <!-- End: User Actions -->

    </header>
    <!-- ===== END HEADER SECTION ===== -->

    <!-- ===== DASHBOARD LAYOUT: Sidebar + Main Content wrapper ===== -->
    <div class="dashboard-layout">

        <!-- Mobile Sidebar Overlay: Dark background when sidebar is open on mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- ===== SIDEBAR NAVIGATION ===== -->
        <!-- Left-side navigation menu with links to all admin pages -->
        <aside class="sidebar" id="adminSidebar">
            <nav class="sidebar-nav">
                <!-- Dashboard Link -->
                <a href="{{ route('dashboard') }}" class="nav-item" data-page="dashboard">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg></span>
                    <span class="nav-label">Dashboard</span>
                </a>
                <!-- Orders Link -->
                <a href="{{ route('admin.orders') }}" class="nav-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}" data-page="orders">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg></span>
                    <span class="nav-label">Orders</span>
                </a>
                <!-- Products Link -->
                <a href="{{ route('products.admin') }}" class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}" data-page="products">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M5 8h2V6h10v2h2V6c0-1.1-.9-2-2-2H7V2H5v4c-1.1 0-2 .9-2 2v2zm-2 4v8c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-8H3zm2 2h2v6H5v-6zm4 0h2v6H9v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6z"/></svg></span>
                    <span class="nav-label">Products</span>
                </a>
                <!-- Customers Link -->
                <a href="{{ route('customers.admin') }}" class="nav-item" data-page="customers">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg></span>
                    <span class="nav-label">Customers</span>
                </a>
                <!-- Analytics Link -->
                <a href="{{ route('analytics.admin') }}" class="nav-item" data-page="analytics">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M5 9.2h3V19H5V9.2zM10.6 5h2.8v14h-2.8V5zm5.6 8H19v6h-2.8v-6z"/></svg></span>
                    <span class="nav-label">Analytics</span>
                </a>
                <!-- Reviews Link -->
                <a href="{{ route('reviews.admin') }}" class="nav-item" data-page="reviews">
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
                <!-- Revenue Link -->
                <a href="{{ route('revenue.admin') }}" class="nav-item" data-page="revenue">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg></span>
                    <span class="nav-label">Revenue</span>
                </a>
                <!-- Settings Link -->
                <a href="{{ route('settings.admin') }}" class="nav-item" data-page="settings">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M19.14 12.94c.04-.31.06-.63.06-.94 0-.31-.02-.63-.06-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.04.31-.06.63-.06.94s.02.63.06.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96 c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96 c.22.08.47 0 .59-.22l1.92-3.32 c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg></span>
                    <span class="nav-label">Settings</span>
                </a>
                <!-- Admin Users Link -->
                <a href="{{ route('admin.users') }}" class="nav-item" data-page="admin-users">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg></span>
                    <span class="nav-label">Admin Users</span>
                </a>
            </nav>
        </aside>
        <!-- ===== END SIDEBAR NAVIGATION ===== -->

        <!-- ===== MAIN CONTENT AREA ===== -->
        <!-- This is where each page's content is injected via yield -->
        <main class="main-content">

            <!-- Flash Messages: Success and Error alerts -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <!-- End: Flash Messages -->

            <!-- Page Content: Injected by child views -->
            @yield('content')

            <!-- Page Modals: Injected by child views using push modals -->
            @stack('modals')
        </main>
        <!-- ===== END MAIN CONTENT AREA ===== -->

    </div>
    <!-- ===== END DASHBOARD LAYOUT ===== -->

    <!-- ===== SCRIPTS SECTION ===== -->
    <!-- jQuery: Required by Select2 and other plugins -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Select2: Searchable dropdown plugin -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Dashboard JS: Sidebar toggle, hamburger menu, global UI logic -->
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <!-- Orders JS: Order-specific page interactions -->
    <script src="{{ asset('js/orders.js') }}"></script>
    <!-- Paste Upload: Shared JS for drag-and-drop + paste image zones -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.paste-upload-zone').forEach(function(zone) {
            const fileInput = zone.querySelector('input[type="file"]');
            const preview = zone.querySelector('.upload-preview');
            const titleEl = zone.querySelector('.upload-title');
            const hintEl = zone.querySelector('.upload-hint');
            const removeBtn = zone.querySelector('.remove-file-btn');
            const origTitle = titleEl ? titleEl.textContent : '';
            const origHint = hintEl ? hintEl.innerHTML : '';

            // Click zone to trigger file input
            zone.addEventListener('click', function(e) {
                if (e.target === removeBtn || e.target.closest('.remove-file-btn')) return;
                fileInput.click();
            });

            // File input change
            fileInput.addEventListener('change', function() {
                if (fileInput.files.length > 0) showPreview(fileInput.files[0]);
            });

            // Drag events
            zone.addEventListener('dragover', function(e) { e.preventDefault(); zone.classList.add('dragover'); });
            zone.addEventListener('dragleave', function() { zone.classList.remove('dragover'); });
            zone.addEventListener('drop', function(e) {
                e.preventDefault(); zone.classList.remove('dragover');
                if (e.dataTransfer.files.length > 0) {
                    const dt = new DataTransfer();
                    dt.items.add(e.dataTransfer.files[0]);
                    fileInput.files = dt.files;
                    showPreview(e.dataTransfer.files[0]);
                }
            });

            // Paste (Ctrl+V) — listen on the zone's closest modal or the document
            function handlePaste(e) {
                const items = e.clipboardData ? e.clipboardData.items : [];
                for (let i = 0; i < items.length; i++) {
                    if (items[i].type.indexOf('image') !== -1) {
                        e.preventDefault();
                        const file = items[i].getAsFile();
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        fileInput.files = dt.files;
                        showPreview(file);
                        break;
                    }
                }
            }
            // Attach paste to the closest modal or document
            const modal = zone.closest('.modal-body') || zone.closest('.modal') || zone.closest('form');
            if (modal) {
                modal.addEventListener('paste', handlePaste);
            } else {
                document.addEventListener('paste', handlePaste);
            }

            // Remove file
            if (removeBtn) {
                removeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    fileInput.value = '';
                    zone.classList.remove('has-file');
                    if (preview) preview.innerHTML = '';
                    if (titleEl) titleEl.textContent = origTitle;
                    if (hintEl) hintEl.innerHTML = origHint;
                });
            }

            // Show preview
            function showPreview(file) {
                zone.classList.add('has-file');
                if (titleEl) titleEl.textContent = '✓ Image ready';
                if (hintEl) hintEl.innerHTML = '';
                if (preview && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        preview.innerHTML = '<img src="' + ev.target.result + '" alt="Preview">' +
                            '<div class="upload-filename">' + file.name + '</div>';
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    });
    </script>
    <!-- Page-specific scripts injected here -->
    @stack('scripts')
    <!-- ===== END SCRIPTS SECTION ===== -->

</body>
</html>
<!-- ===== END ADMIN LAYOUT ===== -->
