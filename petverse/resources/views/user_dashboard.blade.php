<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petverse - Everything Your Pet Needs</title>
    <link rel="stylesheet" href="{{ asset('css/user_dashboard.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="user-dashboard">
    @auth
    <!-- Top Navigation Bar -->
    <header class="ud-header">
        <div class="ud-header-inner">
            <a href="{{ route('home') }}" class="ud-logo">
                <span class="ud-logo-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 10a2 2 0 0 1 2 2 2 2 0 0 1-2 2 2 2 0 0 1-2-2 2 2 0 0 1 2-2zM4.5 8a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zm15 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zM7 15a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zm10 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3z"/></svg>
                </span>
                <span class="ud-logo-text"><strong>Pet</strong>verse</span>
            </a>
            <nav class="ud-nav">
                <a href="{{ route('home') }}" class="ud-nav-link active">Home</a>
                <a href="#" class="ud-nav-link">Shop</a>
                <a href="#" class="ud-nav-link">Categories</a>
                <a href="#" class="ud-nav-link">About Us</a>
                <a href="#" class="ud-nav-link">Contact Us</a>
            </nav>
            <div class="ud-search-bar">
                <input type="search" placeholder="Search products, categories..." class="ud-search-input">
                <svg class="ud-search-icon" viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
            </div>
            <div class="ud-header-actions">
                <button type="button" class="ud-icon-btn" aria-label="Cart" id="udCartBtn">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
                    <span class="ud-cart-count">0</span>
                </button>
                <button type="button" class="ud-icon-btn" aria-label="Wishlist" id="udWishlistBtn">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                </button>
                <div class="ud-user-dropdown">
                    <button type="button" class="ud-icon-btn ud-user-btn" aria-label="Profile" id="udUserBtn">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        <span class="ud-user-name">{{ Auth::user()->first_name ?? explode('@', Auth::user()->email)[0] }}</span>
                    </button>
                    <div class="ud-dropdown-menu" id="udUserDropdown">
                        <a href="{{ route('orders') }}">My Orders</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="ud-main">
        @if(session('message'))
        <div class="ud-msg">{{ session('message') }}</div>
        @endif

        <!-- Hero Section -->
        <section class="ud-hero">
            <div class="ud-hero-inner">
                <div class="ud-hero-left">
                    <h1 class="ud-hero-title">Everything your pet needs is here, just wait!</h1>
                    <div class="ud-hero-btns">
                        <a href="#" class="ud-btn ud-btn-primary">Shop Now</a>
                        <a href="#" class="ud-btn ud-btn-outline">View Our Products</a>
                    </div>
                </div>
                <div class="ud-hero-right">
                    <div class="ud-hero-image">
                        <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=600&h=400&fit=crop" alt="Happy pets - dog, cat, and rabbit">
                    </div>
                </div>
            </div>
            <div class="ud-hero-sub">
                <p class="ud-hero-tagline">We Sell Products Only — We Love Animals</p>
                <p class="ud-hero-desc">Shop the finest selection of pet products with care, quality, and love for every furry friend.</p>
            </div>
        </section>

        <!-- Key Features -->
        <section class="ud-features">
            <div class="ud-feature-card" style="--bg: #E3F2FD;">
                <div class="ud-feature-icon">🎁</div>
                <h3>Amazing Offers</h3>
                <p>Enjoy amazing offers to buy for your pet</p>
            </div>
            <div class="ud-feature-card" style="--bg: #E8F5E9;">
                <div class="ud-feature-icon">✨</div>
                <h3>Handpicked Products</h3>
                <p>Handpicked items for your family & pet</p>
            </div>
            <div class="ud-feature-card" style="--bg: #FFF3E0;">
                <div class="ud-feature-icon">🚚</div>
                <h3>Fast Shipping</h3>
                <p>Get your delivery fast & safely</p>
            </div>
            <div class="ud-feature-card" style="--bg: #F3E5F5;">
                <div class="ud-feature-icon">💬</div>
                <h3>Hyper Customer Service</h3>
                <p>Amazing customer service for you</p>
            </div>
        </section>

        <!-- Browse by Category -->
        <section class="ud-section ud-categories">
            <h2 class="ud-section-title">
                <span class="ud-paw">🐾</span>
                Browse by Inclusive Category
                <span class="ud-paw">🐾</span>
            </h2>
            <div class="ud-category-grid" id="udCategoryGrid">
                <a href="#" class="ud-category-card">🐕 Dog Food</a>
                <a href="#" class="ud-category-card">🐈 Cat Food</a>
                <a href="#" class="ud-category-card">🐦 Bird Food</a>
                <a href="#" class="ud-category-card">🐟 Fish Food</a>
                <a href="#" class="ud-category-card">🐹 Small Animals</a>
                <a href="#" class="ud-category-card">🎾 Toys & Play</a>
                <a href="#" class="ud-category-card">🦴 Dog Accessory</a>
                <a href="#" class="ud-category-card">🎀 Cat Accessory</a>
                <a href="#" class="ud-category-card">🏠 Bird Accessory</a>
                <a href="#" class="ud-category-card">🌊 Fish Accessory</a>
                <a href="#" class="ud-category-card">✂️ Grooming</a>
                <a href="#" class="ud-category-card">💊 Health Care</a>
            </div>
        </section>

        <!-- Flash Sale Products -->
        <section class="ud-section ud-flash-sale">
            <div class="ud-section-header">
                <h2 class="ud-section-title">Flash Sale Products</h2>
                <a href="#" class="ud-view-all">View All</a>
            </div>
            <div class="ud-flash-sale-grid">
                <div class="ud-flash-featured">
                    <div class="ud-flash-featured-inner">
                        <img src="https://images.unsplash.com/photo-1552728089-57bdde30beb3?w=400&h=500&fit=crop" alt="Parrot">
                        <span class="ud-flash-badge">FLASH SALE</span>
                    </div>
                </div>
                <div class="ud-flash-products">
                    <div class="ud-product-card">
                        <img src="https://images.unsplash.com/photo-1589924691995-400dc9ecc119?w=200&h=200&fit=crop" alt="Pet food">
                        <h4>Premium Dog Food</h4>
                        <p class="ud-price">P550</p>
                        <button type="button" class="ud-add-cart">Add to Cart</button>
                    </div>
                    <div class="ud-product-card">
                        <img src="https://images.unsplash.com/photo-1573865526739-10659fec78a5?w=200&h=200&fit=crop" alt="Cat treats">
                        <h4>Cat Treats Box</h4>
                        <p class="ud-price">P495</p>
                        <button type="button" class="ud-add-cart">Add to Cart</button>
                    </div>
                    <div class="ud-product-card">
                        <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=200&h=200&fit=crop" alt="Bird food">
                        <h4>Bird Seed Mix</h4>
                        <p class="ud-price">P310</p>
                        <button type="button" class="ud-add-cart">Add to Cart</button>
                    </div>
                    <div class="ud-product-card">
                        <img src="https://images.unsplash.com/photo-1589924691995-400dc9ecc119?w=200&h=200&fit=crop" alt="Pet snacks">
                        <h4>Pet Snacks Pack</h4>
                        <p class="ud-price">P490</p>
                        <button type="button" class="ud-add-cart">Add to Cart</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Promotional Banners -->
        <section class="ud-promo-banners">
            <div class="ud-promo-card ud-promo-orange">
                <div class="ud-promo-content">
                    <h3>Wholesome Nutrition for Pets</h3>
                    <a href="#" class="ud-btn ud-btn-promo">Read More</a>
                </div>
                <div class="ud-promo-image">
                    <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=300&h=200&fit=crop" alt="Happy dog with food">
                </div>
            </div>
            <div class="ud-promo-card ud-promo-blue">
                <div class="ud-promo-content">
                    <h3>Premium Food for Your Happy Pets</h3>
                    <a href="#" class="ud-btn ud-btn-promo">Shop Now</a>
                </div>
                <div class="ud-promo-image">
                    <img src="https://images.unsplash.com/photo-1589924691995-400dc9ecc119?w=300&h=200&fit=crop" alt="Pet food products">
                </div>
            </div>
        </section>

        <!-- Recently Added Items -->
        <section class="ud-section ud-recent">
            <div class="ud-section-header">
                <h2 class="ud-section-title">Recently Added Items</h2>
                <a href="#" class="ud-view-all">View All</a>
            </div>
            <div class="ud-product-grid" id="udRecentProducts">
                <div class="ud-product-card">
                    <button type="button" class="ud-wishlist-btn" aria-label="Add to wishlist">♡</button>
                    <img src="https://images.unsplash.com/photo-1589924691995-400dc9ecc119?w=200&h=200&fit=crop" alt="Product">
                    <h4>Pet Treats</h4>
                    <p class="ud-price">P400</p>
                    <button type="button" class="ud-add-cart">Add to Cart</button>
                </div>
                <div class="ud-product-card">
                    <button type="button" class="ud-wishlist-btn" aria-label="Add to wishlist">♡</button>
                    <img src="https://images.unsplash.com/photo-1573865526739-10659fec78a5?w=200&h=200&fit=crop" alt="Product">
                    <h4>Cat Litter Box</h4>
                    <p class="ud-price">P300</p>
                    <button type="button" class="ud-add-cart">Add to Cart</button>
                </div>
                <div class="ud-product-card">
                    <button type="button" class="ud-wishlist-btn" aria-label="Add to wishlist">♡</button>
                    <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=200&h=200&fit=crop" alt="Product">
                    <h4>Bird Toys</h4>
                    <p class="ud-price">P450</p>
                    <button type="button" class="ud-add-cart">Add to Cart</button>
                </div>
                <div class="ud-product-card">
                    <button type="button" class="ud-wishlist-btn" aria-label="Add to wishlist">♡</button>
                    <img src="https://images.unsplash.com/photo-1601758228041-f3b2795255f1?w=200&h=200&fit=crop" alt="Product">
                    <h4>Fish Tank Decor</h4>
                    <p class="ud-price">P510</p>
                    <button type="button" class="ud-add-cart">Add to Cart</button>
                </div>
                <div class="ud-product-card">
                    <button type="button" class="ud-wishlist-btn" aria-label="Add to wishlist">♡</button>
                    <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=200&h=200&fit=crop" alt="Product">
                    <h4>Pet Toothbrush</h4>
                    <p class="ud-price">P299</p>
                    <button type="button" class="ud-add-cart">Add to Cart</button>
                </div>
                <div class="ud-product-card">
                    <button type="button" class="ud-wishlist-btn" aria-label="Add to wishlist">♡</button>
                    <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=200&h=200&fit=crop" alt="Product">
                    <h4>Dog Outfit</h4>
                    <p class="ud-price">P350</p>
                    <button type="button" class="ud-add-cart">Add to Cart</button>
                </div>
                <div class="ud-product-card">
                    <button type="button" class="ud-wishlist-btn" aria-label="Add to wishlist">♡</button>
                    <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=200&h=200&fit=crop" alt="Product">
                    <h4>Rabbit Hutch</h4>
                    <p class="ud-price">P299</p>
                    <button type="button" class="ud-add-cart">Add to Cart</button>
                </div>
                <div class="ud-product-card">
                    <button type="button" class="ud-wishlist-btn" aria-label="Add to wishlist">♡</button>
                    <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=200&h=200&fit=crop" alt="Product">
                    <h4>Sleeping Pet Bed</h4>
                    <p class="ud-price">P450</p>
                    <button type="button" class="ud-add-cart">Add to Cart</button>
                </div>
            </div>
        </section>

        <!-- Why Choose Our Pet Products -->
        <section class="ud-why-choose">
            <div class="ud-why-inner">
                <div class="ud-why-image">
                    <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=400&h=300&fit=crop" alt="Happy pets together">
                </div>
                <div class="ud-why-content">
                    <h2>Why Choose Our Pet Products</h2>
                    <ul class="ud-why-list">
                        <li>High quality products</li>
                        <li>24/7 online support</li>
                        <li>Fast and secure delivery</li>
                        <li>Affordable prices</li>
                        <li>Discount and loyalty program</li>
                        <li>100% money back guarantee</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Trending Products -->
        <section class="ud-section ud-trending">
            <div class="ud-trending-header">
                <h2 class="ud-section-title">Trending Products</h2>
                <div class="ud-trend-tabs" id="udTrendTabs">
                    <button type="button" class="ud-tab active" data-tab="dog">Dog Products</button>
                    <button type="button" class="ud-tab" data-tab="cat">Cat Products</button>
                    <button type="button" class="ud-tab" data-tab="bird">Bird Products</button>
                    <button type="button" class="ud-tab" data-tab="fish">Fish Products</button>
                    <button type="button" class="ud-tab" data-tab="small">Small Pets</button>
                    <button type="button" class="ud-tab" data-tab="acc">Accessories</button>
                </div>
            </div>
            <div class="ud-trending-products" id="udTrendingProducts">
                <div class="ud-product-card">
                    <img src="https://images.unsplash.com/photo-1589924691995-400dc9ecc119?w=200&h=200&fit=crop" alt="Dog food">
                    <h4>Premium Dog Food 5kg</h4>
                    <p class="ud-price">P550</p>
                    <button type="button" class="ud-add-cart">Add to Cart</button>
                </div>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/user_dashboard.js') }}"></script>
    @else
    <script>window.location.href = '{{ route('login') }}';</script>
    @endauth
</body>
</html>
