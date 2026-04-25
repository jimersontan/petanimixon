<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Pet Markt-PH</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
</head>
<body>
    <div class="login-container">
        <div class="login-left gradient-orange">
            <div class="left-content">
                <div class="brand-logo" style="display:flex; align-items:center; gap:14px;">
                    <img src="{{ asset('images/logo.png') }}" alt="Pet Markt-PH Logo" style="max-height: 64px;">
                    <h1 style="margin:0; font-size:30px;">Pet <span style="color: #e9f2ea;">Markt-PH</span></h1>
                </div>
                <div class="welcome-section" style="margin-bottom: 20px;">
                    <h2 style="font-size: 38px; margin-bottom: 8px;">Forgot Password?</h2>
                    <p style="font-size: 17px; opacity: 0.9;">No worries! Enter your email and we'll send you a reset link.</p>
                </div>
                <div class="illustration-box">
                    <div class="pet-illustration">
                        <img src="{{ asset('images/login_pets.png') }}" alt="Pets">
                    </div>
                </div>
            </div>
        </div>

        <div class="login-right">
            <div class="login-form-container">
                <h2 class="form-title">Reset Password</h2>
                <p class="form-subtitle">Enter the email address associated with your account</p>

                @if(session('status'))
                    <div style="background: #dcfce7; color: #16a34a; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;">
                        {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div style="background: #fee2e2; color: #dc2626; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address*</label>
                        <div class="input-wrapper">
                            <input type="email" id="email" name="email" placeholder="your@email.com" class="form-control" required value="{{ old('email') }}">
                        </div>
                    </div>

                    <button type="submit" class="login-btn">Send Reset Link</button>
                </form>

                <div class="form-footer" style="margin-top: 20px;">
                    <div>
                        <span>Remember your password?</span>
                        <a href="{{ route('login') }}">Log In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/animations.js') }}"></script>
</body>
</html>
