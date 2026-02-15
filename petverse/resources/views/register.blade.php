<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Pet Animixon</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="register-container">
        <div class="register-header-top">
            <div class="register-logo"><h1>🐾 Pet Animixon</h1></div>
            <a href="#" class="need-help">Need help?</a>
        </div>

        <div class="register-content">
            <div class="register-left gradient-green">
                <div class="left-illustration">
                    <svg viewBox="0 0 300 400" xmlns="http://www.w3.org/2000/svg">
                        <!-- Family with pets illustration -->
                        <circle cx="150" cy="100" r="80" fill="rgba(255,255,255,0.1)"/>
                        
                        <!-- Person 1 (woman in red) -->
                        <circle cx="100" cy="120" r="18" fill="#FFB6A3"/>
                        <rect x="85" y="140" width="30" height="50" rx="6" fill="#E85A4A"/>
                        <rect x="75" y="145" width="12" height="40" fill="#FFB6A3"/>
                        <rect x="113" y="145" width="12" height="40" fill="#FFB6A3"/>
                        
                        <!-- Dog 1 (left) -->
                        <circle cx="60" cy="150" r="22" fill="#D4884B"/>
                        <circle cx="45" cy="135" r="16" fill="#D4884B"/>
                        <circle cx="70" cy="135" r="14" fill="#D4884B"/>
                        
                        <!-- Cat (center-left) -->
                        <circle cx="130" cy="155" r="20" fill="#FF8C42"/>
                        <polygon points="125,135 135,125 145,135" fill="#FF8C42"/>
                        
                        <!-- Person 2 (child) -->
                        <circle cx="180" cy="130" r="15" fill="#FFB6A3"/>
                        <rect x="170" y="150" width="20" height="35" rx="4" fill="#4CAF50"/>
                        
                        <!-- Dog 2 (right) -->
                        <circle cx="210" cy="155" r="20" fill="#FFD700"/>
                        <circle cx="200" cy="140" r="14" fill="#FFD700"/>
                        
                        <!-- Rabbit -->
                        <circle cx="240" cy="145" r="18" fill="#FFC0CB"/>
                        <rect x="250" y="120" width="6" height="20" fill="#FFC0CB"/>
                        <rect x="260" y="120" width="6" height="20" fill="#FFC0CB"/>
                        
                        <!-- Bird -->
                        <circle cx="155" cy="155" r="12" fill="#FFD700"/>
                        <polygon points="167,155 175,150 175,160" fill="#FFD700"/>
                        
                        <!-- Decorative elements -->
                        <circle cx="80" cy="220" r="60" fill="rgba(255,255,255,0.05)"/>
                    </svg>
                </div>
                
                <div class="left-content">
                    <h2>Join Our Pet-Loving Community! 🎉</h2>
                    <ul class="benefits-list">
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

                    <form id="registerForm" method="POST" action="{{ route('register.submit') }}">
                        @csrf
                        
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
                            <input type="hidden" id="pet_type" name="pet_type" value="">
                        </div>

                        <div class="checkboxes-group">
                            <div class="checkbox-item">
                                <input type="checkbox" id="promos" name="promos" class="form-checkbox">
                                <label for="promos">I'd like to receive promotional emails and special offers</label>
                            </div>

                            <div class="checkbox-item">
                                <input type="checkbox" id="tips" name="tips" class="form-checkbox">
                                <label for="tips">Send me pet care tips and helpful guides</label>
                            </div>

                            <div class="checkbox-item">
                                <input type="checkbox" id="terms" name="terms" class="form-checkbox">
                                <label for="terms">
                                    I agree to the 
                                    <a href="#" class="terms-link">Terms & Conditions</a> 
                                    and 
                                    <a href="#" class="terms-link">Privacy Policy</a>
                                </label>
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
                        Already have an account? <a href="{{ route('login') }}">Log in</a>
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
        window.routes.registerSubmit = "{{ route('register.submit') }}";
        window.routes.login = "{{ route('login') }}";
    </script>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>
