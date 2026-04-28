<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - Pet Markt-PH</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/auth.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/animations.css')); ?>">
</head>

<body>
    <div class="login-container">
        <div class="login-left gradient-orange">
            <div class="left-content">
                <div class="brand-logo" style="display:flex; align-items:center; gap:0;">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Pet Markt-PH Logo"
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
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                            <label for="password" style="margin-bottom: 0;">Password*</label>
                            <a href="<?php echo e(route('password.request')); ?>" style="font-size: 13px; color: #4B5563; text-decoration: none;">Forgot Password?</a>
                        </div>
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


                </form>

                <div class="form-footer" style="display: flex; flex-direction: column; align-items: center; gap: 16px; margin-top: 16px;">
                        <div style="font-size: 14px; color: #4B5563;">
                            Don't have an account? 
                            <a href="<?php echo e(route('register')); ?>" style="font-weight: 700; color: #2E7D32; text-decoration: none; margin-left: 4px;">Sign up</a>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px; font-size: 13px;">
                            <a href="<?php echo e(route('admin.login')); ?>" style="color: #6B7280; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#2E7D32'" onmouseout="this.style.color='#6B7280'">Log In As Admin</a>
                            <span style="color: #D1D5DB;">•</span>
                            <a href="<?php echo e(route('rider.login')); ?>" style="color: #6B7280; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#2E7D32'" onmouseout="this.style.color='#6B7280'">Log In As Rider</a>
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

</html><?php /**PATH C:\xampp\htdocs\Pet Markt-PH\resources\views/login.blade.php ENDPATH**/ ?>