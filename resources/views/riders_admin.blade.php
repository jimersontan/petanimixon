<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riders Management - Pet Animixon Admin</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/rider.css') }}">
</head>
<body class="dashboard-body">

    @if(session('success'))
        <div class="rider-toast">{{ session('success') }}</div>
    @endif

    @include('partials.admin_header')

    <div class="dashboard-layout">

        <!-- ===== SIDEBAR ===== -->
        <aside class="sidebar">
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="nav-item" data-page="dashboard">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg></span>
                    <span class="nav-label">Dashboard</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="nav-item" data-page="orders">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg></span>
                    <span class="nav-label">Orders</span>
                </a>
                <a href="{{ route('products.readonly') }}" class="nav-item" data-page="products">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M5 8h2V6h10v2h2V6c0-1.1-.9-2-2-2H7V2H5v4c-1.1 0-2 .9-2 2v2zm-2 4v8c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-8H3z"/></svg></span>
                    <span class="nav-label">Products</span>
                </a>
                <a href="{{ route('inventory.admin') }}" class="nav-item" data-page="inventory">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/></svg></span>
                    <span class="nav-label">Inventory</span>
                </a>
                <a href="{{ route('customers.admin') }}" class="nav-item" data-page="customers">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg></span>
                    <span class="nav-label">Customers</span>
                </a>
                <a href="{{ route('riders.admin') }}" class="nav-item active" data-page="riders">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg></span>
                    <span class="nav-label">Riders</span>
                </a>
                <a href="{{ route('analytics.admin') }}" class="nav-item" data-page="analytics">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M5 9.2h3V19H5V9.2zM10.6 5h2.8v14h-2.8V5zm5.6 8H19v6h-2.8v-6z"/></svg></span>
                    <span class="nav-label">Analytics</span>
                </a>
                <a href="{{ route('reviews.admin') }}" class="nav-item" data-page="reviews">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></span>
                    <span class="nav-label">Reviews</span>
                </a>
                <a href="{{ route('categories.admin') }}" class="nav-item" data-page="categories">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M3 3v8h8V3H3zm6 6H5V5h4v4zm-6 4v8h8v-8H3zm6 6H5v-4h4v4zm4-16v8h8V3h-8zm6 6h-4V5h4v4zm-6 4v8h8v-8h-8zm6 6h-4v-4h4v4z"/></svg></span>
                    <span class="nav-label">Categories</span>
                </a>
                <a href="{{ route('brands.admin') }}" class="nav-item" data-page="brands">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"/></svg></span>
                    <span class="nav-label">Brands</span>
                </a>
                <a href="{{ route('revenue.admin') }}" class="nav-item" data-page="revenue">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg></span>
                    <span class="nav-label">Revenue</span>
                </a>
                <a href="{{ route('settings.admin') }}" class="nav-item" data-page="settings">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M19.14 12.94c.04-.31.06-.63.06-.94 0-.31-.02-.63-.06-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.04.31-.06.63-.06.94s.02.63.06.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg></span>
                    <span class="nav-label">Settings</span>
                </a>
                <a href="{{ route('admin.users') }}" class="nav-item" data-page="admin-users">
                    <span class="nav-icon"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg></span>
                    <span class="nav-label">Admin Users</span>
                </a>
            </nav>
        </aside>

        <!-- ===== MAIN CONTENT ===== -->
        <main class="main-content">
            <div class="content-header">
                <h1 class="page-title">Riders Management</h1>
                <button type="button" class="btn-rider-primary" id="btnCreateRider" onclick="document.getElementById('createRiderModal').style.display='flex'">
                    + Add Rider
                </button>
            </div>

            <!-- Stats -->
            <div class="rider-stats-grid" style="margin-bottom: 24px;">
                <div class="rider-stat-card">
                    <div class="rider-stat-icon green">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg>
                    </div>
                    <div>
                        <div class="rider-stat-value">{{ $totalRiders ?? 0 }}</div>
                        <div class="rider-stat-label">Total Riders</div>
                    </div>
                </div>
                <div class="rider-stat-card">
                    <div class="rider-stat-icon blue">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <div>
                        <div class="rider-stat-value">{{ $activeRiders ?? 0 }}</div>
                        <div class="rider-stat-label">Active Riders</div>
                    </div>
                </div>
                <div class="rider-stat-card">
                    <div class="rider-stat-icon orange">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-3 10h-3v3h-2v-3H8v-2h3V8h2v3h3v2z"/></svg>
                    </div>
                    <div>
                        <div class="rider-stat-value">{{ $deliveriesToday ?? 0 }}</div>
                        <div class="rider-stat-label">Deliveries Today</div>
                    </div>
                </div>
            </div>

            <!-- Riders Table -->
            <div class="rider-card">
                <div class="rider-card-header">
                    <h2>🛵 All Riders</h2>
                </div>
                <div class="rider-table-wrap">
                    <table class="rider-table">
                        <thead>
                            <tr>
                                <th>Rider</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Deliveries</th>
                                <th>Active</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riders ?? [] as $rider)
                            <tr>
                                <td>
                                    <div class="rider-name-cell">{{ $rider->full_name }}</div>
                                </td>
                                <td>
                                    <div class="rider-email-cell">{{ $rider->email }}</div>
                                </td>
                                <td>{{ $rider->phone_number ?? '—' }}</td>
                                <td>
                                    <span class="rider-badge-status rider-badge-{{ $rider->account_status }}">
                                        {{ ucfirst($rider->account_status) }}
                                    </span>
                                </td>
                                <td><strong>{{ $rider->total_deliveries ?? 0 }}</strong></td>
                                <td>{{ $rider->active_deliveries ?? 0 }}</td>
                                <td>{{ $rider->created_at->format('M j, Y') }}</td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <a href="{{ route('riders.edit', $rider->id) }}" class="btn-rider-secondary btn-rider-sm">Edit</a>
                                        <form action="{{ route('riders.toggle', $rider->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-rider-sm {{ $rider->account_status === 'active' ? 'btn-rider-warning' : 'btn-rider-success' }}"
                                                onclick="return confirm('{{ $rider->account_status === 'active' ? 'Deactivate' : 'Activate' }} this rider?')">
                                                {{ $rider->account_status === 'active' ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px 20px; color: var(--rider-text-muted);">
                                    <div style="font-size: 2rem; margin-bottom: 8px;">🛵</div>
                                    <strong>No riders yet.</strong><br>
                                    Click "Add Rider" to create the first delivery rider account.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(isset($riders) && $riders->hasPages())
                <div class="rider-pagination">
                    {{ $riders->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- ===== CREATE RIDER MODAL ===== -->
    <div class="rider-modal-overlay" id="createRiderModal" style="display: none;">
        <div class="rider-modal">
            <div class="rider-modal-header">
                <h2>🛵 Create New Rider</h2>
                <button type="button" class="rider-modal-close" onclick="document.getElementById('createRiderModal').style.display='none'">&times;</button>
            </div>
            <form action="{{ route('riders.store') }}" method="POST">
                @csrf
                <div class="rider-modal-body">
                    @if($errors->any())
                        <div style="background: #fef2f2; color: #991b1b; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 0.85rem; border: 1px solid #fecaca;">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="rider-form-row">
                        <div class="rider-form-group">
                            <label for="first_name">First Name *</label>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required placeholder="Juan">
                        </div>
                        <div class="rider-form-group">
                            <label for="last_name">Last Name *</label>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required placeholder="Dela Cruz">
                        </div>
                    </div>
                    <div class="rider-form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="rider@email.com">
                    </div>
                    <div class="rider-form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" placeholder="09XX-XXX-XXXX">
                    </div>
                    <div class="rider-form-row">
                        <div class="rider-form-group">
                            <label for="password">Password *</label>
                            <input type="password" id="password" name="password" required placeholder="Min 6 characters">
                        </div>
                        <div class="rider-form-group">
                            <label for="password_confirmation">Confirm Password *</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Confirm password">
                        </div>
                    </div>
                </div>
                <div class="rider-modal-footer">
                    <button type="button" class="btn-rider-secondary" onclick="document.getElementById('createRiderModal').style.display='none'">Cancel</button>
                    <button type="submit" class="btn-rider-primary">Create Rider 🛵</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== EDIT RIDER MODAL ===== -->
    @if(isset($showEditModal) && isset($editRider))
    <div class="rider-modal-overlay" id="editRiderModal" style="display: flex;">
        <div class="rider-modal">
            <div class="rider-modal-header">
                <h2>✏️ Edit Rider</h2>
                <a href="{{ route('riders.admin') }}" class="rider-modal-close">&times;</a>
            </div>
            <form action="{{ route('riders.update', $editRider->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="rider-modal-body">
                    <div class="rider-form-row">
                        <div class="rider-form-group">
                            <label for="edit_first_name">First Name *</label>
                            <input type="text" id="edit_first_name" name="first_name" value="{{ $editRider->first_name }}" required>
                        </div>
                        <div class="rider-form-group">
                            <label for="edit_last_name">Last Name *</label>
                            <input type="text" id="edit_last_name" name="last_name" value="{{ $editRider->last_name }}" required>
                        </div>
                    </div>
                    <div class="rider-form-group">
                        <label for="edit_email">Email Address *</label>
                        <input type="email" id="edit_email" name="email" value="{{ $editRider->email }}" required>
                    </div>
                    <div class="rider-form-group">
                        <label for="edit_phone_number">Phone Number</label>
                        <input type="text" id="edit_phone_number" name="phone_number" value="{{ $editRider->phone_number }}">
                    </div>
                    <div class="rider-form-group">
                        <label for="edit_password">New Password (leave blank to keep current)</label>
                        <input type="password" id="edit_password" name="password" placeholder="Leave blank to keep current">
                    </div>
                </div>
                <div class="rider-modal-footer">
                    <a href="{{ route('riders.admin') }}" class="btn-rider-secondary">Cancel</a>
                    <button type="submit" class="btn-rider-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <script>
        // Auto-show create modal if there are errors and we were creating
        @if($errors->any() && !isset($showEditModal))
            document.getElementById('createRiderModal').style.display = 'flex';
        @endif

        // Close modals on overlay click
        document.querySelectorAll('.rider-modal-overlay').forEach(function(overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    overlay.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
