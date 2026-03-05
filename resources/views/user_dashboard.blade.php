<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petverse - Everything Your Pet Needs</title>
    <link rel="stylesheet" href="{{ asset('css/shop_shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user_dashboard.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="user-dashboard">
    @auth
    <!-- Top Navigation Bar -->
    @include('partials.shop_nav')

    <main class="ud-main">
        @if(session('message'))
        <div class="ud-msg">{{ session('message') }}</div>
        @endif

        <!-- Hero Section -->
        <section class="ud-hero-new">
            <div class="ud-hero-new-inner">
                <!-- Left: Cream/Beige side -->
                <div class="ud-hero-new-left">
                    <p class="ud-hero-new-tag">🐾 Pet Animixon</p>
                    <h1 class="ud-hero-new-title">Everything your pet needs from the everyday to the extraordinary</h1>
                    <div class="ud-hero-new-btns">
                        <a href="{{ route('shop.products') }}" class="ud-btn-shop">Shop Products</a>
                        <a href="{{ route('shop.categories') }}" class="ud-btn-browse">Browse Categories</a>
                    </div>
                </div>
                <!-- Right: Orange side with pets -->
                <div class="ud-hero-new-right">
                    <!-- Decorative icons -->
                    <span class="ud-deco ud-deco-paw ud-deco-1">🐾</span>
                    <span class="ud-deco ud-deco-bone ud-deco-2">🦴</span>
                    <span class="ud-deco ud-deco-paw ud-deco-3">🐾</span>
                    <!-- Pet images stacked/overlapping -->
                    <div class="ud-hero-pets">
                        <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=380&h=380&fit=crop&crop=center" alt="Golden Retriever" class="ud-pet-img ud-pet-dog">
                        <img src="https://images.unsplash.com/photo-1573865526739-10659fec78a5?w=220&h=220&fit=crop&crop=center" alt="Cat" class="ud-pet-img ud-pet-cat">
                        <img src="https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308?w=180&h=180&fit=crop&crop=center" alt="Rabbit" class="ud-pet-img ud-pet-rabbit">
                    </div>
                </div>
            </div>
            <!-- Trust Strip -->
            <div class="ud-hero-trust">
                <div class="ud-trust-title-row">
                    <span class="ud-trust-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                            <path d="M19 6h-2c0-2.76-2.24-5-5-5S7 3.24 7 6H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-7-3c1.66 0 3 1.34 3 3H9c0-1.66 1.34-3 3-3zm0 10c-2.76 0-5-2.24-5-5h2c0 1.66 1.34 3 3 3s3-1.34 3-3h2c0 2.76-2.24 5-5 5z"/>
                        </svg>
                    </span>
                    We Sell Products Only—No Live Animals
                </div>
                <p>Pet Animixon is your trusted source for premium pet supplies, food, toys, and accessories. We're dedicated to providing quality products that keep your pets happy and healthy.</p>
                <a href="#" class="ud-trust-link">Learn More About Us →</a>
            </div>
        </section>


        <!-- Key Features -->
        <section class="ud-features">
            <div class="ud-feature-card">
                <div class="ud-feature-icon-wrap" style="--bg: #bee3f8; --icon-color: #3182ce;">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                    </svg>
                </div>
                <h3>All Pets Welcome</h3>
                <p>Support for every species, from dogs to birds</p>
            </div>
            <div class="ud-feature-card">
                <div class="ud-feature-icon-wrap" style="--bg: #c6f6d5; --icon-color: #38a169;">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="32" height="32">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <h3>Family-Safe Products</h3>
                <p>Vetted for safety and quality standards</p>
            </div>
            <div class="ud-feature-card">
                <div class="ud-feature-icon-wrap" style="--bg: #feebc8; --icon-color: #dd6b20;">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28">
                        <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                    </svg>
                </div>
                <h3>Fast Shipping</h3>
                <p>Quick, reliable delivery to your door</p>
            </div>
            <div class="ud-feature-card">
                <div class="ud-feature-icon-wrap" style="--bg: #e9d8fd; --icon-color: #805ad5;">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="26" height="26">
                        <path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9H9V9h10v2zm-4 4H9v-2h6v2zm4-8H9V5h10v2z"/>
                    </svg>
                </div>
                <h3>Expert Guides</h3>
                <p>Free care resources and pet tips</p>
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
            <div class="ud-empty-state">
                <span class="ud-empty-icon">⚡</span>
                <p>No flash sale products yet. Add products from the admin panel.</p>
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
            <div class="ud-empty-state">
                <span class="ud-empty-icon">🛍️</span>
                <p>No products have been added yet. Add products from the admin panel.</p>
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
            <div class="ud-empty-state" id="udTrendingProducts">
                <span class="ud-empty-icon">📈</span>
                <p>No trending products yet. Products will appear here once added.</p>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/user_dashboard.js') }}"></script>
    @else
    <script>window.location.href = '{{ route('login') }}';</script>
    @endauth
</body>
</html>
