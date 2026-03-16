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
                <div class="brand-logo"><h1>🐾 Pet Animixon</h1></div>
                <div class="illustration-box">
                    <div class="pet-illustration">
                        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                            <!-- Pet mascot: friendly dog face (orange/red/green palette) -->
                            <ellipse cx="100" cy="145" rx="42" ry="18" fill="#4CAF50"/>
                            <circle cx="100" cy="95" r="38" fill="#FFB366"/>
                            <circle cx="83" cy="88" r="6" fill="#1f1f1f"/>
                            <circle cx="117" cy="88" r="6" fill="#1f1f1f"/>
                            <ellipse cx="100" cy="105" rx="5" ry="3" fill="#FF4444"/>
                            <path d="M62 68 Q55 50 72 62 Q68 75 62 68" fill="#FF8844"/>
                            <path d="M138 68 Q145 50 128 62 Q132 75 138 68" fill="#FF8844"/>
                            <path d="M70 115 Q85 125 100 122 Q115 125 130 115" stroke="#FF8844" stroke-width="3" fill="none"/>
                        </svg>
                    </div>
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
                        <button type="button" class="social-btn google-btn" onclick="showNotification('Google login coming soon')">
                            <svg class="social-icon" viewBox="0 0 24 24" width="20" height="20"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                            Continue with Google
                        </button>
                        <button type="button" class="social-btn facebook-btn" onclick="showNotification('Facebook login coming soon')">
                            <svg class="social-icon" viewBox="0 0 24 24" width="20" height="20"><path fill="#1877F2" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            Continue with Facebook
                        </button>
                        <button type="button" class="social-btn apple-btn" onclick="showNotification('Apple login coming soon')">
                            <svg class="social-icon" viewBox="0 0 24 24" width="20" height="20"><path fill="#000" d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/></svg>
                            Continue with Apple
                        </button>
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