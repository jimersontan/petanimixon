<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - Pet Animixon</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="login-container">
        <div class="login-left gradient-orange">
            <div class="left-content">
                <div class="brand-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Pet Animixon Logo" style="height: 48px; width: auto; max-width: 100%;">
                    <h1 style="display:none;">🐾 Pet Animixon</h1>
                </div>
                <div class="illustration-box" style="padding: 0; display:flex; justify-content:center;">
                    <img src="{{ asset('images/auth_banner.png') }}" alt="Auth Banner" style="max-height: 400px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); object-fit: cover;">
                </div>
                <div class="welcome-section">
                    <h2>Welcome Back!</h2>
                    <p>Log in to continue shopping for your furry, feathered, and scaly friends!</p>
                </div>
            </div>
        </div>

        <div class="login-right">
            <div class="login-form-container">
                <h2 class="form-title">Log In</h2>
                <p class="form-subtitle">Enter your credentials to access your account</p>

                <form id="loginForm" method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address*</label>
                        <div class="input-wrapper">
                            <input type="email" id="email" name="email" placeholder="your@email.com" class="form-control" required>
                        </div>
                        <span id="emailError" class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="password">Password*</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" placeholder="Enter your password" class="form-control" required>
                            <button type="button" class="toggle-password" onclick="togglePassword()">Show</button>
                        </div>
                        <span id="passwordError" class="error-message"></span>
                    </div>

                    <div class="form-group checkbox-group">
                        <input type="checkbox" id="remember" name="remember" class="form-checkbox">
                        <label for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="login-btn">Log In</button>

                    <div class="divider">or</div>

                    <div class="social-login">
                        <button type="button" class="social-btn google-btn" onclick="showNotification('Google login coming soon')">Continue with Google</button>
                        <button type="button" class="social-btn facebook-btn" onclick="showNotification('Facebook login coming soon')">Continue with Facebook</button>
                        <button type="button" class="social-btn apple-btn" onclick="showNotification('Apple login coming soon')">Continue with Apple</button>
                    </div>
                </form>

                <div class="form-footer">
                    <div>
                        <span>Don't have an account?</span>
                        <a href="{{ route('register') }}">Sign up</a>
                    </div>
                    <a href="{{ route('admin.login') }}" class="forgot-password">Log In As Admin</a>
                </div>

                <div class="security-note">
                    <small>Your information is secure and encrypted</small>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.routes = window.routes || {};
        window.routes.loginSubmit = "{{ route('login.submit') }}";
        window.routes.adminLogin = "{{ route('admin.login') }}";
    </script>
    <script src="{{ asset('js/auth.js') }}"></script>
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>