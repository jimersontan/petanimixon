<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Pet Animixon</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/auth.css')); ?>">
</head>
<body>
    <div class="register-container">
        <div class="register-header-top">
            <div class="register-logo"><h1>🐾 Pet Animixon</h1></div>
            <a href="#" class="need-help">Need help?</a>
        </div>

        <div class="register-content">
            <div class="register-left premium-auth-sidebar">
                <!-- Decorative background elements -->
                <div class="bg-circle bc-1"></div>
                <div class="bg-circle bc-2"></div>
                <div class="bg-paws bp-1">🐾🐾</div>
                <div class="bg-paws bp-2">🐾🐾</div>
                <div class="bg-paws bp-3">🐾🐾</div>

                <div class="sidebar-inner-content">
                    <div class="main-illustration">
                        <img src="<?php echo e(asset('images/register_pets.png')); ?>" alt="Pet Community">
                    </div>
                    
                    <h2 class="community-title">Join Our Pet-Loving Community! 🎉</h2>
                    
                    <ul class="check-benefits">
                        <li>Fast checkout with saved addresses</li>
                        <li>Order tracking and history</li>
                        <li>Personalized product recommendations</li>
                        <li>Exclusive deals and birthday discounts</li>
                        <li>Wishlist and favorites</li>
                        <li>Pet profiles for tailored suggestions</li>
                    </ul>
                </div>
            </div>

            <div class="register-right">
                <div class="register-form-wrapper">
                    <div class="form-header-line"></div>
                    <h2 class="register-title">Create Your Account</h2>
                    <p class="register-subtitle">Join thousands of happy pet parents!</p>

                    <form id="registerForm" method="POST" action="<?php echo e(route('register.submit')); ?>">
                        <?php echo csrf_field(); ?>
                        
                        <div class="form-row">
                            <div class="form-group half">
                                <label for="first_name">First Name*</label>
                                <div class="input-wrapper">
                                    <i class="input-icon">👤</i>
                                    <input type="text" id="first_name" name="first_name" placeholder="John" class="form-control" required>
                                </div>
                                <span id="firstNameError" class="error-message"></span>
                            </div>

                            <div class="form-group half">
                                <label for="last_name">Last Name*</label>
                                <div class="input-wrapper">
                                    <i class="input-icon">👤</i>
                                    <input type="text" id="last_name" name="last_name" placeholder="Doe" class="form-control" required>
                                </div>
                                <span id="lastNameError" class="error-message"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address*</label>
                            <div class="input-wrapper">
                                <i class="input-icon">📧</i>
                                <input type="email" id="email" name="email" placeholder="your@email.com" class="form-control" required>
                            </div>
                            <span id="emailError" class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="password">Create Password*</label>
                            <div class="input-wrapper">
                                <i class="input-icon">🔒</i>
                                <input type="password" id="password" name="password" placeholder="Create a strong password" class="form-control" required>
                                <button type="button" class="toggle-password" onclick="togglePasswordFor('password')">👁️</button>
                            </div>
                            <ul class="password-requirements">
                                <li>At least 8 characters</li>
                                <li>One uppercase letter</li>
                                <li>One number</li>
                                <li>One special character (e.g, !,&, etc.)</li>
                            </ul>
                            <span id="passwordError" class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password*</label>
                            <div class="input-wrapper">
                                <i class="input-icon">🔒</i>
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-enter your password" class="form-control" required>
                                <button type="button" class="toggle-password" onclick="togglePasswordFor('password_confirmation')">👁️</button>
                            </div>
                            <span id="confirmPasswordError" class="error-message"></span>
                        </div>

                        <div class="form-group pet-section">
                            <label class="pet-label">Tell Us About Your Pet (Optional)</label>
                            <p class="pet-subtitle">Get personalized product recommendations!</p>
                            <div class="pet-grid">
                                <button type="button" class="pet-chip" data-value="dog">
                                    <span class="pet-emoji">🐕</span>
                                    <span>Dog</span>
                                </button>
                                <button type="button" class="pet-chip" data-value="cat">
                                    <span class="pet-emoji">🐱</span>
                                    <span>Cat</span>
                                </button>
                                <button type="button" class="pet-chip" data-value="bird">
                                    <span class="pet-emoji">🐦</span>
                                    <span>Bird</span>
                                </button>
                                <button type="button" class="pet-chip" data-value="fish">
                                    <span class="pet-emoji">🐠</span>
                                    <span>Fish</span>
                                </button>
                                <button type="button" class="pet-chip" data-value="rabbit">
                                    <span class="pet-emoji">🐰</span>
                                    <span>Rabbit</span>
                                </button>
                                <button type="button" class="pet-chip" data-value="reptile">
                                    <span class="pet-emoji">🦎</span>
                                    <span>Reptile</span>
                                </button>
                                <button type="button" class="pet-chip" data-value="insect">
                                    <span class="pet-emoji">🐛</span>
                                    <span>Insect</span>
                                </button>
                                <button type="button" class="pet-chip" data-value="other">
                                    <span class="pet-emoji">🐾</span>
                                    <span>Other</span>
                                </button>
                            </div>
                            <div id="custom-pet-input" style="display: none; margin-top: 10px;">
                                <input type="text" id="custom_pet_type" name="custom_pet_type" placeholder="Enter your pet type (e.g., hamster, turtle)" class="form-control">
                            </div>
                            <input type="hidden" id="pet_type" name="pet_type" value="">
                            <span id="petError" class="error-message"></span>
                        </div>

                        <div class="checkboxes-group">
                            <div class="checkbox-item">
                                <input type="checkbox" id="promos" name="promos" class="form-checkbox" value="1">
                                <label for="promos">I'd like to receive promotional emails and special offers</label>
                            </div>

                            <div class="checkbox-item">
                                <input type="checkbox" id="tips" name="tips" class="form-checkbox" value="1">
                                <label for="tips">Send me pet care tips and helpful guides</label>
                            </div>

                            <div class="checkbox-item">
                                <input type="checkbox" id="terms" name="terms" class="form-checkbox" value="1">
                                <label for="terms">
                                    I agree to the 
                                    <a href="#" class="terms-link">Terms & Conditions</a> 
                                    and 
                                    <a href="#" class="terms-link">Privacy Policy</a>
                                </label>
                                <span id="termsError" class="error-message"></span>
                            </div>
                        </div>

                        <button type="submit" class="create-btn">Create Account 🎉</button>

                        <div class="divider">or</div>

                        <div class="social-login">
                            <button type="button" class="social-btn google-btn">
                                <i>G</i> Sign up with Google
                            </button>
                            <button type="button" class="social-btn facebook-btn">
                                <i>f</i> Sign up with Facebook
                            </button>
                            <button type="button" class="social-btn apple-btn">
                                <i>🍎</i> Sign up with Apple
                            </button>
                        </div>
                    </form>

                    <div class="login-link">
                        Already have an account? <a href="<?php echo e(route('login')); ?>">Log in</a>
                    </div>

                    <div class="security-message">
                        <i>🛡️</i> Your information is secure. We never share your data with third parties.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.routes = window.routes || {};
        window.routes.registerSubmit = "<?php echo e(route('register.submit')); ?>";
        window.routes.login = "<?php echo e(route('login')); ?>";
    </script>
    <script src="<?php echo e(asset('js/auth.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views\register.blade.php ENDPATH**/ ?>