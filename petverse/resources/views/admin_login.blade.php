<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Log in - Pet Animixon</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="admin-page">
        <div class="admin-header">
            <div class="admin-logo"><h1>🐾 Pet Animixon</h1></div>
            <a href="{{ route('login') }}" class="back-link">← Back to Log In</a>
        </div>

        <div class="admin-wrapper">
            <div class="admin-card">
                <div class="admin-icon">🔐</div>
                <h2>Admin Log in</h2>
                <p class="muted">Authorized personnel only</p>

                <form id="adminLoginForm" method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf
                    <div class="form-group">
                        <label for="admin_email">Email or Username*</label>
                        <div class="input-wrapper">
                            <input type="text" id="admin_email" name="email" placeholder="admin@petanimixon.com" class="form-control" required>
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

                    <div class="admin-form-footer">
                        <div class="form-group checkbox-group">
                            <input type="checkbox" id="keep_signed" name="keep_signed" class="form-checkbox">
                            <label for="keep_signed">Keep me signed in</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-password">Forgot password?</a>
                    </div>

                    <button type="submit" class="login-btn dark">Access Admin Panel 🔒</button>
                </form>

                <div class="admin-signup-link">
                    <a href="#">Sign Up As Admin</a>
                </div>

                <div class="admin-security-badges">
                    <div class="badge-item">
                        <div class="badge-icon">🔒</div>
                        <div class="badge-text">SSL Encrypted</div>
                    </div>
                    <div class="badge-item">
                        <div class="badge-icon">🛡️</div>
                        <div class="badge-text">2FA Protected</div>
                    </div>
                    <div class="badge-item">
                        <div class="badge-icon">📋</div>
                        <div class="badge-text">Activity Logged</div>
                    </div>
                </div>

                <div class="admin-warning">
                    <small>⚠️ All login attempts are monitored and logged for security purposes.</small>
                </div>

                <div class="admin-support">
                    <small>Need help accessing your account? <a href="#">Contact IT Support</a></small>
                </div>

                <div class="admin-timestamp">
                    <small>Jan 28, 2026 at 2:45 PM</small>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.routes = window.routes || {};
        window.routes.adminLogin = "{{ route('admin.login.submit') }}";
        window.routes.login = "{{ route('login') }}";
    </script>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>