<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider Login - Pet Animixon</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/auth.css')); ?>">
    <style>
        .register-left.rider-sidebar-bg {
            background: linear-gradient(135deg, #059669 0%, #0d9488 50%, #047857 100%) !important;
        }
        .rider-sidebar-bg .community-title { color: #fff !important; }
        .rider-sidebar-bg .check-benefits li { color: rgba(255,255,255,0.92) !important; }
        .rider-sidebar-bg .check-benefits li::before { color: #a7f3d0 !important; }
        .create-btn, .form-header-line {
            background: linear-gradient(135deg, #059669, #0d9488) !important;
        }
        .create-btn:hover {
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4) !important;
        }
        .login-link a { color: #059669 !important; }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header-top">
            <div class="register-logo"><h1>🐾 Pet Animixon</h1></div>
            <a href="<?php echo e(route('login')); ?>" class="need-help">Customer Login →</a>
        </div>

        <div class="register-content">
            <div class="register-left premium-auth-sidebar rider-sidebar-bg">
                <div class="bg-circle bc-1"></div>
                <div class="bg-circle bc-2"></div>
                <div class="bg-paws bp-1">🏍️🏍️</div>
                <div class="bg-paws bp-2">📦📦</div>
                <div class="bg-paws bp-3">🏍️🏍️</div>

                <div class="sidebar-inner-content">
                    <div class="main-illustration" style="font-size: 5rem; text-align: center; margin-bottom: 16px;">
                        🛵
                    </div>

                    <h2 class="community-title">Rider Delivery Portal 🚀</h2>

                    <ul class="check-benefits">
                        <li>View and accept delivery orders</li>
                        <li>Real-time delivery tracking</li>
                        <li>Track your delivery history</li>
                        <li>Manage your delivery schedule</li>
                        <li>View product catalog for verification</li>
                        <li>Earn per successful delivery</li>
                    </ul>
                </div>
            </div>

            <div class="register-right">
                <div class="register-form-wrapper">
                    <div class="form-header-line"></div>
                    <h2 class="register-title">Rider Login</h2>
                    <p class="register-subtitle">Sign in to your delivery dashboard</p>

                    <?php if(session('error')): ?>
                        <div style="background: #fef2f2; color: #991b1b; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 0.88rem; border: 1px solid #fecaca;">
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div style="background: #fef2f2; color: #991b1b; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 0.88rem; border: 1px solid #fecaca;">
                            <?php echo e($errors->first()); ?>

                        </div>
                    <?php endif; ?>

                    <form id="riderLoginForm" method="POST" action="<?php echo e(route('rider.login.submit')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-wrapper">
                                <i class="input-icon">📧</i>
                                <input type="email" id="email" name="email" placeholder="rider@petanimixon.com" class="form-control" value="<?php echo e(old('email')); ?>" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-wrapper">
                                <i class="input-icon">🔒</i>
                                <input type="password" id="password" name="password" placeholder="Enter your password" class="form-control" required>
                                <button type="button" class="toggle-password" onclick="togglePasswordFor('password')">👁️</button>
                            </div>
                        </div>

                        <div class="checkboxes-group" style="margin-bottom: 16px;">
                            <div class="checkbox-item">
                                <input type="checkbox" id="remember" name="remember" class="form-checkbox" value="1">
                                <label for="remember">Keep me signed in</label>
                            </div>
                        </div>

                        <button type="submit" class="create-btn">Sign In 🛵</button>
                    </form>

                    <div class="login-link" style="margin-top: 20px;">
                        Not a rider? <a href="<?php echo e(route('login')); ?>">Customer Login</a>
                    </div>

                    <div class="security-message">
                        <i>🛡️</i> Rider accounts are managed by administrators.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordFor(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        document.getElementById('riderLoginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const btn = form.querySelector('.create-btn');
            btn.textContent = 'Signing in...';
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
                    window.location.href = data.redirect;
                } else {
                    btn.textContent = 'Sign In 🛵';
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
<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/rider_login.blade.php ENDPATH**/ ?>