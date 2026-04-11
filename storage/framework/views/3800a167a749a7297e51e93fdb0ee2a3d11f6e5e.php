<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - PetMarkt-PH</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/auth.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/animations.css')); ?>">
</head>

<body>
    <div class="login-container">
        <div class="login-left gradient-orange">
            <div class="left-content">
                <div class="brand-logo" style="display:flex; align-items:center; gap:0;">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="PetMarkt-PH Logo"
                        style="max-height: 64px; margin-right: -10px;">
                    <h1 style="margin:0; font-size:30px;">Pet <span style="color: #e9f2ea;">Markt-PH</span></h1>
                </div>
                <div class="welcome-section" style="margin-bottom: 20px;">
                    <h2 style="font-size: 44px; margin-bottom: 8px;">Welcome Back!</h2>
                    <p style="font-size: 17px; opacity: 0.9;">Log in to continue shopping for your furry, feathered, and
                        scaly friends!</p>
                </div>
                <div class="illustration-box">
                    <div class="pet-illustration">
                        <img src="<?php echo e(asset('images/login_pets.png')); ?>" alt="Happy pets with supplies">
                    </div>
                </div>
            </div>
        </div>

        <div class="login-right">
            <div class="login-form-container">
                <h2 class="form-title">Log In</h2>
                <p class="form-subtitle">Enter your credentials to access your account</p>

                <form id="loginForm" method="POST" action="<?php echo e(route('login.submit')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="email">Email Address*</label>
                        <div class="input-wrapper">
                            <input type="email" id="email" name="email" placeholder="your@email.com"
                                class="form-control" required>
                        </div>
                        <span id="emailError" class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="password">Password*</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" placeholder="Enter your password"
                                class="form-control" required>
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
                        <button type="button" class="social-btn google-btn"
                            onclick="showNotification('Google login coming soon')">Continue with Google</button>
                        <button type="button" class="social-btn facebook-btn"
                            onclick="showNotification('Facebook login coming soon')">Continue with Facebook</button>
                        <button type="button" class="social-btn apple-btn"
                            onclick="showNotification('Apple login coming soon')">Continue with Apple</button>
                    </div>
                </form>

                <div class="form-footer">
                    <div>
                        <span>Don't have an account?</span>
                        <a href="<?php echo e(route('register')); ?>">Sign up</a>
                    </div>
                    <div style="display: flex; gap: 16px;">
                        <a href="<?php echo e(route('password.request')); ?>" class="forgot-password">Forgot Password?</a>
                        <a href="<?php echo e(route('admin.login')); ?>" class="forgot-password">Log In As Admin</a>
                    </div>
                </div>

                <div class="security-note">
                    <small>Your information is secure and encrypted</small>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.routes = window.routes || {};
        window.routes.loginSubmit = "<?php echo e(route('login.submit')); ?>";
        window.routes.adminLogin = "<?php echo e(route('admin.login')); ?>";
    </script>
    <script src="<?php echo e(asset('js/auth.js')); ?>"></script>
    <script src="<?php echo e(asset('js/login.js')); ?>"></script>
    <script src="<?php echo e(asset('js/animations.js')); ?>"></script>
</body>

</html><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/login.blade.php ENDPATH**/ ?>