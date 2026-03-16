@extends('frontend.layouts.app')

@section('title','Petverse - Everything Your Pet Needs')

@section('content')3
    @if(session('message'))
        <div class="ud-msg">{{ session('message') }}</div>
    @endif

    <!-- Hero Section -->
    <section class="ud-hero">
        <div class="ud-hero-inner">
            <div class="ud-hero-left">
                <h1 class="ud-hero-title">Everything your pet needs is here, just wait!</h1>
                <div class="ud-hero-btns">
                    <a href="{{ route('shop') }}" class="ud-btn ud-btn-primary">Shop Now</a>
                    <a href="{{ route('categories') }}" class="ud-btn ud-btn-outline">View Categories</a>
                </div>
            </div>
            <div class="ud-hero-right">
                <div class="ud-hero-image">
                    <img src="https://images.unsplash.com/photo-1544568100-847a948585b9?w=600&h=400&fit=crop" alt="Happy pets - dog, cat, and rabbit">
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
            <div class="ud-feature-icon">�</div>
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
            @forelse($categories as $category)
                <a href="{{ route('categories.show', $category->id) }}" class="ud-category-card">
                    <div class="ud-category-card-title">{{ $category->category_name }}</div>
                    <div class="ud-category-card-meta">{{ $category->products()->count() }} products</div>
                </a>
            @empty
                <div class="ud-category-card">No categories available yet.</div>
            @endforelse
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

    <!-- Why Choose Our Pet Products -->
    <section class="ud-why-choose">
        <div class="ud-why-inner">
            <div class="ud-why-image">
                <img src="https://images.unsplash.com/photo-1576087001033-5e1e2d7a5b51?w=500&h=400&fit=crop" alt="Happy pets">
            </div>
            <div class="ud-why-content">
                <h2>Why Choose Our Pet Products</h2>
                <ul class="ud-why-list">
                    <li>High-Quality Pet Items</li>
                    <li>24/7 Customer Support</li>
                    <li>Fast & Reliable Delivery</li>
                    <li>Safety & Hygiene Standards</li>
                    <li>Satisfaction Guaranteed</li>
                </ul>
            </div>
        </div>
    </section>
@endsection
