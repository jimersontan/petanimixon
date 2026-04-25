<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider Log in - Pet Markt-PH</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="admin-page" style="background-color: #f1f5f9;">
        <div class="admin-header">
            <div class="admin-logo" style="display:flex; align-items:center; gap:0;">
                <img src="{{ asset('images/logo.png') }}" alt="Pet Markt-PH Logo" style="max-height: 38px; margin-right: -8px;">
                <h1 style="margin:0; font-size:24px; color:#1f2937;">Pet <span style="color:#059669;">Markt-PH</span></h1>
            </div>
            <a href="{{ route('login') }}" class="back-link">← Back to Log In</a>
        </div>

        <div class="admin-wrapper">
            <div class="admin-card" style="border-top: 4px solid #059669;">
                <div class="admin-icon" style="background: rgba(5, 150, 105, 0.1);">🛵</div>
                <h2>Rider Log in</h2>
                <p class="muted">Authorized delivery personnel only</p>

                @if(session('error'))
                    <div style="background: #fef2f2; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 0.88rem; border: 1px solid #fecaca; text-align: left;">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div style="background: #fef2f2; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 0.88rem; border: 1px solid #fecaca; text-align: left;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form id="riderLoginForm" method="POST" action="{{ route('rider.login.submit') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address*</label>
                        <div class="input-wrapper">
                            <input type="email" id="email" name="email" placeholder="rider@petmarkt.com" class="form-control" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password*</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" placeholder="Enter your password" class="form-control" required>
                            <button type="button" class="toggle-password" onclick="togglePasswordFor('password')" style="color: #059669;">Show</button>
                        </div>
                    </div>

                    <div class="admin-form-footer">
                        <div class="form-group checkbox-group">
                            <input type="checkbox" id="remember" name="remember" class="form-checkbox" value="1">
                            <label for="remember">Keep me signed in</label>
                        </div>
                    </div>

                    <button type="submit" class="login-btn dark" style="background-color: #059669; border-color: #059669;">Access Rider Portal 🚀</button>
                </form>

                <div class="admin-security-badges">
                    <div class="badge-item">
                        <div class="badge-icon">📍</div>
                        <div class="badge-text" style="color: #64748b;">GPS Tracking</div>
                    </div>
                    <div class="badge-item">
                        <div class="badge-icon">📦</div>
                        <div class="badge-text" style="color: #64748b;">Live Orders</div>
                    </div>
                </div>

                <div class="admin-warning" style="margin-top:20px;">
                    <small>⚠️ Drive safely. Follow all local traffic regulations while on duty.</small>
                </div>

                <div class="admin-support">
                    <small>Need help accessing your account? <a href="#" style="color: #059669;">Contact Dispatch</a></small>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordFor(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
            const btn = input.nextElementSibling;
            btn.textContent = input.type === 'password' ? 'Show' : 'Hide';
        }

        document.addEventListener('DOMContentLoaded', () => {
            const rememberedEmail = localStorage.getItem('petMarkt_riderEmail');
            if (rememberedEmail) {
                const emailInput = document.getElementById('email');
                if (emailInput) {
                    emailInput.value = rememberedEmail;
                    document.getElementById('remember').checked = true;
                }
            }
        });

        document.getElementById('riderLoginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const btn = form.querySelector('.login-btn');
            btn.textContent = 'Authenticating...';
            btn.disabled = true;

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const rememberChecked = document.getElementById('remember') && document.getElementById('remember').checked;
                    if (rememberChecked) {
                        localStorage.setItem('petMarkt_riderEmail', document.getElementById('email').value);
                    } else {
                        localStorage.removeItem('petMarkt_riderEmail');
                    }
                    window.location.href = data.redirect;
                } else {
                    btn.textContent = 'Access Rider Portal 🚀';
                    btn.disabled = false;
                    alert(data.message || 'Login failed');
                }
            })
            .catch(() => {
                form.submit();
            });
        });
    </script>
</body>
</html>
