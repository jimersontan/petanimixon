<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign Up - Pet Markt-PH</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="admin-page">
        <div class="admin-header">
            <div class="admin-logo" style="display:flex; align-items:center; gap:0;">
                <img src="{{ asset('images/logo.png') }}" alt="Pet Markt-PH Logo" style="max-height: 38px; margin-right: -8px;">
                <h1 style="margin:0; font-size:24px; color:#1f2937;">Pet <span style="color:#2E6C34;">Markt-PH</span></h1>
            </div>
            <a href="{{ route('admin.login') }}" class="back-link">← Back to Admin Log In</a>
        </div>

        <div class="admin-wrapper">
            <div class="admin-card">
                <div class="admin-icon">📝</div>
                <h2>Admin Sign Up</h2>
                <p class="muted">Request an administrator account – an existing admin must approve.</p>

                <form id="adminRegisterForm" method="POST" action="{{ route('admin.register.submit') }}">
                    @csrf
                    @if(session('success'))
                        <div class="alert alert-success" style="text-align:left; margin-bottom:16px;">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger" style="text-align:left; margin-bottom:16px;">{{ session('error') }}</div>
                    @endif
                    <div class="form-group">
                        <label for="admin_name">Full Name*</label>
                        <div class="input-wrapper">
                            <input type="text" id="admin_name" name="name" placeholder="Jane Doe" class="form-control" required>
                        </div>
                        <span id="adminNameError" class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="admin_email">Email*</label>
                        <div class="input-wrapper">
                            <input type="email" id="admin_email" name="email" placeholder="admin@petmrkt.com" class="form-control" required>
                        </div>
                        <span id="adminEmailError" class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="admin_password">Password*</label>
                        <div class="input-wrapper">
                            <input type="password" id="admin_password" name="password" placeholder="Enter your password" class="form-control" required>
                            <button type="button" class="toggle-password" onclick="togglePasswordFor('admin_password')">Show</button>
                        </div>
                        <span id="adminPasswordError" class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="admin_password_confirmation">Confirm Password*</label>
                        <div class="input-wrapper">
                            <input type="password" id="admin_password_confirmation" name="password_confirmation" placeholder="Re-enter password" class="form-control" required>
                            <button type="button" class="toggle-password" onclick="togglePasswordFor('admin_password_confirmation')">Show</button>
                        </div>
                        <span id="adminConfirmPasswordError" class="error-message"></span>
                    </div>

                    <button type="submit" class="login-btn dark">Create Admin Account</button>
                </form>

                <div class="admin-security-badges">
                    <div class="badge-item">
                        <div class="badge-icon">🔒</div>
                        <div class="badge-text">Secure Connection</div>
                    </div>
                    <div class="badge-item">
                        <div class="badge-icon">🛡️</div>
                        <div class="badge-text">Strong Password Required</div>
                    </div>
                    <div class="badge-item">
                        <div class="badge-icon">📋</div>
                        <div class="badge-text">Activity Logged</div>
                    </div>
                </div>

                <div class="admin-warning">
                    <small>⚠️ Only authorized staff should create admin accounts. All activity is monitored.</small>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.routes = window.routes || {};
        window.routes.adminRegisterSubmit = "{{ route('admin.register.submit') }}";
        window.routes.adminLogin = "{{ route('admin.login') }}";
    </script>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>

