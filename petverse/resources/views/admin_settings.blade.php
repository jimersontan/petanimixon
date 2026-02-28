<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Pet Animixon Admin</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <!-- additional styles for settings page -->
    <style>
        /* simple two‑column layout for settings sections */
        .settings-container {
            display: flex;
            gap: 24px;
            margin-top: 24px;
        }
        .settings-sidebar {
            width: 240px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 16px;
        }
        .settings-sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .settings-sidebar li {
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
            margin-bottom: 4px;
        }
        .settings-sidebar li.active,
        .settings-sidebar li:hover {
            background: var(--bg-page);
        }
        .settings-panel {
            flex: 1;
            background: #fff;
            padding: 24px;
            border: 1px solid var(--border);
            border-radius: 8px;
        }
        .settings-panel h2 {
            margin-top: 0;
        }
        .settings-panel .form-group {
            margin-bottom: 16px;
        }
        .settings-panel label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
        }
        .settings-panel input[type="text"],
        .settings-panel input[type="email"],
        .settings-panel select,
        .settings-panel textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid var(--border);
            border-radius: 4px;
            font-size: 14px;
        }
        .settings-panel .btn-save {
            margin-top: 24px;
        }
    </style>
</head>
<body class="dashboard-body">
    @include('partials.admin_header')

    <div class="dashboard-layout">
        @include('partials.admin_sidebar')

        <!-- Main content area -->
        <main class="main-content">
            <div class="content-header">
                <h1 class="page-title">Settings</h1>
            </div>

            <div class="settings-container">
                <!-- inner navigation for settings categories -->
                <aside class="settings-sidebar">
                    <ul>
                        <li class="active">Store Information</li>
                        <li>Currency</li>
                        <li>Tax Settings</li>
                        <li>Invoice</li>
                        <li class="separator"></li>
                        <li><strong>Payment</strong></li>
                        <li>Payment Gateways</li>
                        <li>Payout Settings</li>
                        <li>Transaction Fees</li>
                        <li class="separator"></li>
                        <li><strong>Shipping</strong></li>
                        <li>Shipping Zones</li>
                        <li>Delivery Providers</li>
                        <li>Rates & Fees</li>
                        <li class="separator"></li>
                        <li><strong>Users & Roles</strong></li>
                        <li>Admin Accounts</li>
                        <li>Staff Permissions</li>
                        <li class="separator"></li>
                        <li><strong>Notification</strong></li>
                        <li>Email Templates</li>
                        <li>SMS Settings</li>
                        <li class="separator"></li>
                        <li><strong>Integrations</strong></li>
                        <li>3rd-party Service</li>
                        <li>API Keys</li>
                        <li>Webhooks</li>
                        <li class="separator"></li>
                        <li><strong>Security</strong></li>
                        <li>Password Policy</li>
                        <li>Two-factor Authentication</li>
                        <li>Login Logs</li>
                    </ul>
                </aside>
                <section class="settings-panel">
                    <h2>General Store Settings</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Example input fields; replace with actual data bindings -->
                        <div class="form-group">
                            <label for="store_name">Store Name</label>
                            <input type="text" id="store_name" name="store_name" value="{{ old('store_name', $settings->store_name ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="store_email">Store Email</label>
                            <input type="email" id="store_email" name="store_email" value="{{ old('store_email', $settings->store_email ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="store_phone">Store Phone</label>
                            <input type="text" id="store_phone" name="store_phone" value="{{ old('store_phone', $settings->store_phone ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="store_url">Store URL</label>
                            <input type="text" id="store_url" name="store_url" value="{{ old('store_url', $settings->store_url ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="store_description">Store Description</label>
                            <textarea id="store_description" name="store_description" rows="3">{{ old('store_description', $settings->store_description ?? '') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="store_logo">Store Logo</label>
                            <input type="file" id="store_logo" name="store_logo">
                        </div>
                        <div class="form-group">
                            <label for="timezone">Timezone</label>
                            <select id="timezone" name="timezone">
                                <option value="GMT+0">GMT+0</option>
                                <!-- additional options omitted for brevity -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="default_currency">Default Currency</label>
                            <select id="default_currency" name="default_currency">
                                <option value="PHP">PHP - Philippine Peso (₱)</option>
                                <!-- additional options -->
                            </select>
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>
            </div>
        </main>
    </div>
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>