<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password - PetMarkt-PH</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
</head>
<body>
    <div class="login-container">
        <div class="login-left gradient-orange">
            <div class="left-content">
                <div class="brand-logo" style="display:flex; align-items:center; gap:14px;">
                    <img src="{{ asset('images/logo.png') }}" alt="PetMarkt-PH Logo" style="max-height: 64px;">
                    <h1 style="margin:0; font-size:30px;">Pet <span style="color: #e9f2ea;">Markt-PH</span></h1>
                </div>
                <div class="welcome-section" style="margin-bottom: 20px;">
                    <h2 style="font-size: 38px; margin-bottom: 8px;">New Password</h2>
                    <p style="font-size: 17px; opacity: 0.9;">Choose a strong password to secure your account.</p>
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
                <h2 class="form-title">Set New Password</h2>
                <p class="form-subtitle">Enter your new password below</p>

                @if($errors->any())
                    <div style="background: #fee2e2; color: #dc2626; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="form-group">
                        <label for="password">New Password*</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" placeholder="Min 8 characters" class="form-control" required minlength="8">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password*</label>
                        <div class="input-wrapper">
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="login-btn">Reset Password</button>
                </form>

                <div class="form-footer" style="margin-top: 20px;">
                    <a href="{{ route('login') }}">Back to login</a>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/animations.js') }}"></script>
</body>
</html>
