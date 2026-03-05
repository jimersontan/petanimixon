<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Log in - Pet Animixon</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --brand-orange: #FF6B35;
            --brand-dark: #1A202C;
            --brand-blue-dark: #1e293b;
            --text-muted: #64748b;
            --bg-color: #f8fafc;
        }
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-color);
            color: var(--brand-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .admin-page {
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 48px;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .admin-logo h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
        }
        .admin-logo h1 span.dark { color: #333; }
        .admin-logo h1 span.orange { color: var(--brand-orange); }
        .back-link {
            color: var(--brand-orange);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .admin-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }
        .admin-card {
            background: #fff;
            width: 100%;
            max-width: 440px;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            position: relative;
            padding: 40px 48px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-sizing: border-box;
            border-top: 4px solid var(--brand-orange);
        }
        .admin-icon-wrapper {
            width: 72px;
            height: 72px;
            background-color: #FFF2EB;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 24px;
        }
        .admin-icon-wrapper i {
            font-size: 32px;
            color: var(--brand-orange);
        }
        .admin-card h2 {
            margin: 0 0 8px 0;
            color: var(--brand-blue-dark);
            font-size: 26px;
            font-weight: 800;
        }
        .admin-card .muted-subtitle {
            color: var(--text-muted);
            margin: 0 0 32px 0;
            font-size: 14px;
        }
        .admin-form {
            width: 100%;
        }
        .form-group {
            margin-bottom: 20px;
            width: 100%;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            font-size: 12px;
            color: var(--brand-blue-dark);
        }
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .prefix-icon {
            position: absolute;
            left: 14px;
            color: #94a3b8;
            font-size: 14px;
            pointer-events: none;
        }
        .suffix-icon {
            position: absolute;
            right: 14px;
            color: #94a3b8;
            font-size: 14px;
            cursor: pointer;
        }
        .form-control {
            width: 100%;
            padding: 12px 14px 12px 40px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
            box-sizing: border-box;
            color: var(--brand-blue-dark);
        }
        .form-control:focus {
            border-color: var(--brand-orange);
            box-shadow: 0 0 0 3px rgba(255,107,53,0.1);
        }
        .admin-form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 0;
        }
        .checkbox-group input[type="checkbox"] {
            width: 14px;
            height: 14px;
            accent-color: var(--brand-orange);
            cursor: pointer;
        }
        .checkbox-group label {
            margin: 0;
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .checkbox-group label i {
            color: #cbd5e1;
            font-size: 14px;
        }
        .forgot-password {
            color: var(--brand-orange);
            font-size: 13px;
            text-decoration: none;
        }
        .login-btn {
            width: 100%;
            background-color: var(--brand-blue-dark);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 14px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            transition: background 0.2s;
        }
        .login-btn:hover {
            background-color: #0f172a;
        }
        .admin-security-badges {
            display: flex;
            justify-content: stretch;
            background: #f8fafc;
            border-radius: 6px;
            padding: 16px;
            width: 100%;
            box-sizing: border-box;
            margin-top: 32px;
            margin-bottom: 24px;
        }
        .badge-item {
            flex: 1;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }
        .badge-icon {
            color: #64748b;
            font-size: 18px;
        }
        .badge-text {
            font-size: 10px;
            color: #94a3b8;
            text-transform: capitalize;
            font-weight: 600;
        }
        .admin-warning {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 0 0 0 16px;
            border-left: 3px solid var(--brand-orange);
            margin-bottom: 32px;
            width: 100%;
            box-sizing: border-box;
        }
        .admin-warning i {
            color: var(--brand-orange);
            margin-top: 2px;
            font-size: 14px;
        }
        .admin-warning small {
            font-size: 11px;
            color: #475569;
            line-height: 1.5;
        }
        .admin-support {
            text-align: center;
            margin-bottom: 24px;
            width: 100%;
            border-top: 1px solid #f1f5f9;
            padding-top: 24px;
        }
        .admin-support small {
            color: #94a3b8;
            font-size: 12px;
            display: block;
            margin-bottom: 8px;
        }
        .admin-support a {
            color: var(--brand-orange);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
        }
        .admin-timestamp {
            color: #cbd5e1;
            font-size: 11px;
            text-align: center;
        }
        .error-message {
            color: #ef4444;
            font-size: 12px;
            margin-top: 6px;
            display: block;
        }
        .page-footer {
            text-align: center;
            padding: 20px;
            color: #cbd5e1;
            font-size: 12px;
            background: transparent;
        }
    </style>
</head>
<body>
    <div class="admin-page">
        <header class="admin-header">
            <div class="admin-logo">
                <h1>🐾 <span class="dark">Pet</span> <span class="orange">Animixon</span></h1>
            </div>
            <a href="{{ route('login') }}" class="back-link"><i class="fa-solid fa-arrow-left"></i> Back to Log In</a>
        </header>

        <main class="admin-wrapper">
            <div class="admin-card">
                <div class="admin-icon-wrapper">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h2>Admin Log in</h2>
                <p class="muted-subtitle">Authorized personnel only</p>

                <form id="adminLoginForm" method="POST" action="{{ route('admin.login.submit') }}" class="admin-form">
                    @csrf
                    <div class="form-group">
                        <label for="admin_email">Email or Username*</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-user prefix-icon"></i>
                            <input type="text" id="admin_email" name="email" placeholder="admin@petanimixon.com" class="form-control" required>
                        </div>
                        <!-- Validation Message Area -->
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="admin_password">Password*</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock prefix-icon"></i>
                            <input type="password" id="admin_password" name="password" placeholder="Enter your password" class="form-control" required>
                            <i class="fa-solid fa-eye-slash suffix-icon" onclick="togglePasswordVisibility()"></i>
                        </div>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="admin-form-footer">
                        <div class="checkbox-group">
                            <input type="checkbox" id="keep_signed" name="keep_signed">
                            <label for="keep_signed">Keep me signed in <i class="fa-solid fa-circle-info"></i></label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-password">Forgot password?</a>
                    </div>

                    <button type="submit" class="login-btn">
                        Access Admin Panel <i class="fa-solid fa-lock"></i>
                    </button>
                    <!-- "Sign Up As Admin" link removed per prior request. -->
                </form>

                <div class="admin-security-badges">
                    <div class="badge-item">
                        <i class="fa-solid fa-lock badge-icon"></i>
                        <span class="badge-text" style="text-transform: none;">SSL Encrypted</span>
                    </div>
                    <div class="badge-item">
                        <i class="fa-solid fa-shield-halved badge-icon"></i>
                        <span class="badge-text" style="text-transform: none;">2FA Protected</span>
                    </div>
                    <div class="badge-item">
                        <i class="fa-solid fa-clipboard-list badge-icon"></i>
                        <span class="badge-text" style="text-transform: none;">Activity Logged</span>
                    </div>
                </div>

                <div class="admin-warning">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <small>All login attempts are monitored and logged for security purposes.</small>
                </div>

                <div class="admin-support">
                    <small>Need help accessing your account?</small>
                    <a href="#"><i class="fa-solid fa-envelope"></i> Contact IT Support</a>
                </div>

                <div class="admin-timestamp">
                    Jan 28, 2026 at 2:45 PM
                </div>
            </div>
        </main>
        
        <footer class="page-footer">
            &copy; 2026 Pet Animixon. All rights reserved.
        </footer>
    </div>

    <script>
        function togglePasswordVisibility() {
            var input = document.getElementById("admin_password");
            var icon = document.querySelector(".suffix-icon");
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        }

        window.routes = window.routes || {};
        window.routes.adminLogin = "{{ route('admin.login.submit') }}";
        window.routes.login = "{{ route('login') }}";
    </script>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>