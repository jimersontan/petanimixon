@extends('frontend.layouts.app')

@section('title', 'Pet Markt-PH - Everything Your Pet Needs')

@section('content')
    @if(session('message'))
        <div class="ud-msg">{{ session('message') }}</div>
    @endif

    <div class="hm-container">
        
        {{-- 1. HERO SECTION (Classic E-Commerce 3-pane style) --}}
        <section class="hm-hero-section">
            <div class="hm-hero-main">
                <div class="hm-carousel" id="hm-main-carousel">
                    @php 
                        $slides = ($heroProducts ?? collect())->take(5);
                        if ($slides->isEmpty()) {
                            $slides = collect([(object)['id'=>1, 'product_name'=>'Premium Pet Food', 'image_url'=>asset('images/default.png'), 'price'=>0, 'original_price'=>0, 'average_rating'=>5]]);
                        }
                        $slideBadges = ['🔥 HOT DEALS', '⭐ TOP RATED', '💎 BEST SELLER', '🎯 TRENDING', '✨ NEW ARRIVAL'];
                        $slideSubtitles = [
                            'Limited time offer — Don\'t miss out!',
                            'Loved by thousands of pet parents',
                            'Most popular choice this month',
                            'Rising star in pet nutrition',
                            'Fresh from our latest collection'
                        ];
                    @endphp
                    @foreach($slides as $index => $hp)
                        <div class="hm-slide {{ $index === 0 ? 'active' : '' }}">
                            {{-- Decorative background shapes --}}
                            <div class="hm-slide-decor">
                                <div class="hm-slide-circle hm-slide-circle-1"></div>
                                <div class="hm-slide-circle hm-slide-circle-2"></div>
                            </div>
                            <div class="hm-slide-content">
                                <span class="hm-slide-badge">{{ $slideBadges[$index % count($slideBadges)] }}</span>
                                <h1 class="hm-slide-title">{{ Str::limit($hp->product_name, 45) }}</h1>
                                <p class="hm-slide-subtitle">{{ $slideSubtitles[$index % count($slideSubtitles)] }}</p>
                                <div class="hm-slide-pricing">
                                    <span class="hm-slide-price">₱{{ number_format($hp->price, 0) }}</span>
                                    @if(isset($hp->original_price) && $hp->original_price > $hp->price)
                                        <span class="hm-slide-original">₱{{ number_format($hp->original_price, 0) }}</span>
                                        <span class="hm-slide-discount">-{{ round((1 - $hp->price / $hp->original_price) * 100) }}%</span>
                                    @endif
                                </div>
                                <div class="hm-slide-rating">
                                    @php $rating = $hp->average_rating ?? 5; @endphp
                                    @for($s = 1; $s <= 5; $s++)
                                        <span class="hm-star {{ $s <= round($rating) ? 'filled' : '' }}">★</span>
                                    @endfor
                                    <span class="hm-rating-text">{{ number_format($rating, 1) }}</span>
                                </div>
                                <a href="{{ route('product.show', $hp->id) }}" class="hm-btn hm-btn-primary" onclick="window.openProductModal({{ $hp->id }}, event)">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                    Shop Now
                                </a>
                            </div>
                            <div class="hm-slide-image">
                                <div class="hm-slide-image-glow"></div>
                                <img src="{{ $hp->image_url }}" alt="{{ $hp->product_name }}"
                                    onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 150 150%22%3E%3Crect width=%22150%22 height=%22150%22 fill=%22%23f5f5f5%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2214%22 fill=%22%23bbb%22%3ENo Image%3C/text%3E%3C/svg%3E';">
                            </div>
                        </div>
                    @endforeach

                    {{-- Carousel Controls --}}
                    <button class="hm-carousel-btn prev" onclick="moveSlide(-1)">❮</button>
                    <button class="hm-carousel-btn next" onclick="moveSlide(1)">❯</button>
                    <div class="hm-carousel-dots">
                        @foreach($slides as $index => $hp)
                            <div class="hm-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})"></div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="hm-hero-side">
                @php 
                    $sideBanners = isset($promoCoupons) && $promoCoupons->count() >= 2 
                        ? $promoCoupons->take(2)->map(fn($p) => $p->featuredProduct) 
                        : ($featuredSaleProducts ?? collect())->take(2);
                    $sideTags = ['🎟️ VOUCHER', '🔥 MEGA SALE'];
                    $sideSubtitles = ['Save big on every order', 'Flash deal — limited stock!'];
                @endphp
                
                @foreach($sideBanners as $idx => $sb)
                @if($sb)
                <a href="{{ route('product.show', $sb->id) }}" class="hm-side-banner hm-side-banner-{{ $idx + 1 }}" onclick="window.openProductModal({{ $sb->id }}, event)">
                    <div class="hm-sb-decor"></div>
                    <div class="hm-sb-content">
                        <span class="hm-sb-tag">{{ $sideTags[$idx] ?? 'DEAL' }}</span>
                        <h3 class="hm-sb-title">{{ Str::limit($sb->product_name, 30) }}</h3>
                        <p class="hm-sb-subtitle">{{ $sideSubtitles[$idx] ?? '' }}</p>
                        <div class="hm-sb-pricing">
                            <span class="hm-sb-price">₱{{ number_format($sb->price, 0) }}</span>
                            @if(isset($sb->original_price) && $sb->original_price > $sb->price)
                                <span class="hm-sb-discount">-{{ round((1 - $sb->price / $sb->original_price) * 100) }}%</span>
                            @endif
                        </div>
                        <span class="hm-sb-link">Grab it &rarr;</span>
                    </div>
                    <div class="hm-sb-image">
                        <img src="{{ $sb->image_url }}" alt="{{ $sb->product_name }}"
                             onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 150 150%22%3E%3Crect width=%22150%22 height=%22150%22 fill=%22transparent%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2214%22 fill=%22%23bbb%22%3ENo Image%3C/text%3E%3C/svg%3E';">
                    </div>
                </a>
                @endif
                @endforeach
            </div>
        </section>

        {{-- 2. TRUST STRIP --}}
        <section class="hm-trust-strip">
            <div class="hm-trust-item">
                <div class="hm-trust-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 8v4l3 3"></path></svg>
                </div>
                <div class="hm-trust-text">
                    <strong>24/7 Support</strong>
                    <span>Dedicated assistance</span>
                </div>
            </div>
            <div class="hm-trust-item">
                <div class="hm-trust-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                </div>
                <div class="hm-trust-text">
                    <strong>Fast Shipping</strong>
                    <span>Nationwide delivery</span>
                </div>
            </div>
            <div class="hm-trust-item">
                <div class="hm-trust-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </div>
                <div class="hm-trust-text">
                    <strong>100% Authentic</strong>
                    <span>Guaranteed quality</span>
                </div>
            </div>
            <div class="hm-trust-item">
                <div class="hm-trust-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                </div>
                <div class="hm-trust-text">
                    <strong>Secure Payment</strong>
                    <span>100% encrypted</span>
                </div>
            </div>
        </section>

        {{-- 3. CATEGORIES SECTION --}}
        <section class="hm-section hm-categories-section">
            <div class="hm-section-header">
                <h2 class="hm-section-title">Shop by Category</h2>
                <a href="{{ route('shop.all') }}" class="hm-section-link">View All &rarr;</a>
            </div>
            <div class="hm-category-grid">
                @forelse($animalTypes ?? collect() as $at)
                <a href="{{ route('shop.all', ['pet_type' => [$at->animal_type]]) }}" class="hm-category-item">
                    <div class="hm-cat-icon">
                        @if($at->image_url)
                            <img src="{{ $at->image_full_url }}" alt="{{ $at->animal_type }}" onerror="this.onerror=null; this.src='{{ asset('images/placeholder.png') }}'; this.style.objectFit='contain';">
                        @else
                            <span>🐾</span>
                        @endif
                    </div>
                    <span class="hm-cat-name">{{ $at->animal_type }}</span>
                </a>
                @empty
                <p>No categories configured.</p>
                @endforelse
            </div>
        </section>

        {{-- 4. FLASH SALE SECTION --}}
        @if(isset($saleProducts) && $saleProducts->count() > 0)
        <section class="hm-section hm-flash-sale-section">
            <div class="hm-section-header hm-flash-header">
                <div class="hm-flash-title">
                    <h2 class="hm-section-title">⚡ Flash Deals</h2>
                    <div class="hm-flash-timer">
                        <span class="hm-time-box">12</span> : <span class="hm-time-box">45</span> : <span class="hm-time-box">00</span>
                    </div>
                </div>
                <a href="{{ route('shop.all', ['discount' => 'on_sale']) }}" class="hm-section-link">See All Deals &rarr;</a>
            </div>
            
            <div class="hm-product-scroller">
                @foreach($saleProducts as $saleProduct)
                <div class="hm-product-card hm-flash-card">
                    <div class="hm-pc-image" onclick="window.openProductModal({{ $saleProduct->id }}, event)">
                        <img src="{{ $saleProduct->image_url }}" alt="{{ $saleProduct->product_name }}"
                             onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 150 150%22%3E%3Crect width=%22150%22 height=%22150%22 fill=%22%23f5f5f5%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-family=%22Arial%22 font-size=%2214%22 fill=%22%23bbb%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22%3ENo Image%3C/text%3E%3C/svg%3E';">
                        @php
                            $discountLabel = 'SALE';
                            if ($saleProduct->discount_type === 'percent' && $saleProduct->discount_amount > 0) {
                                $discountLabel = '-' . (int)$saleProduct->discount_amount . '%';
                            }
                        @endphp
                        <span class="hm-badge hm-badge-sale">{{ $discountLabel }}</span>
                    </div>
                    <div class="hm-pc-info">
                        <h3 class="hm-pc-title" onclick="window.openProductModal({{ $saleProduct->id }}, event)">{{ $saleProduct->product_name }}</h3>
                        <div class="hm-pc-price-row">
                            @php
                                $salePrice = $saleProduct->price;
                                if ($saleProduct->discount_type === 'percent' && $saleProduct->discount_amount > 0) {
                                    $salePrice = $saleProduct->price * (1 - ($saleProduct->discount_amount / 100));
                                } elseif ($saleProduct->discount_type === 'fixed' && $saleProduct->discount_amount > 0) {
                                    $salePrice = max(0, $saleProduct->price - $saleProduct->discount_amount);
                                }
                            @endphp
                            <span class="hm-price-current">₱{{ number_format((float)$salePrice, 2) }}</span>
                            <span class="hm-price-old">₱{{ number_format((float)$saleProduct->price, 2) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        {{-- 5. BANNER STRIP --}}
        <section class="hm-banner-strip">
            <div class="hm-banner hm-banner-blue">
                <div class="hm-banner-content">
                    <h3>Premium Nutrition for Your Happy Pets</h3>
                    <p>Discover our top-rated selection of organic foods.</p>
                </div>
            </div>
            <div class="hm-banner hm-banner-orange">
                <div class="hm-banner-content">
                    <h3>Everything Your Pet Needs</h3>
                    <p>Accessories, toys, and hygiene essentials.</p>
                </div>
            </div>
        </section>

        {{-- 6. JUST FOR YOU (LATEST PRODUCTS) --}}
        <section class="hm-section hm-latest-section">
            <div class="hm-section-header" style="justify-content: center;">
                <h2 class="hm-section-title" style="font-size: 1.8rem; color: var(--ud-orange);">Just For You</h2>
            </div>
            <div class="hm-product-grid">
                @forelse($latestProducts ?? [] as $product)
                    @php /** @var \App\Models\Product $product */ @endphp
                    <div class="hm-product-card">
                        <div class="hm-pc-image" onclick="window.openProductModal({{ $product->id }}, event)">
                            <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}"
                                 onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 150 150%22%3E%3Crect width=%22150%22 height=%22150%22 fill=%22%23f5f5f5%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-family=%22Arial%22 font-size=%2214%22 fill=%22%23bbb%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22%3ENo Image%3C/text%3E%3C/svg%3E';">
                            @if($product->is_featured)
                                <span class="hm-badge hm-badge-featured">HOT</span>
                            @endif
                            @if($product->is_sale_active)
                                <span class="hm-badge hm-badge-sale">
                                    {{ $product->discount_type === 'percent' ? '-' . (int)$product->discount_amount . '%' : 'SALE' }}
                                </span>
                            @endif
                        </div>
                        <div class="hm-pc-info">
                            <h3 class="hm-pc-title" onclick="window.openProductModal({{ $product->id }}, event)">{{ $product->product_name }}</h3>
                            
                            @php
                                $pReviewCount = $product->reviews()->count();
                                $pReviewAvg = $product->avg_rating > 0 ? $product->avg_rating : 0;
                                $roundedAvg = round($pReviewAvg);
                                $pFmt = $pReviewCount >= 1000 ? round($pReviewCount / 1000, 1) . 'k' : $pReviewCount;
                            @endphp
                            <div class="hm-pc-rating">
                                <div class="hm-stars-wrap" style="--rating: {{ $pReviewAvg }};" title="{{ number_format($pReviewAvg, 1) }} out of 5"></div>
                                <span class="hm-count">({{ $pFmt }})</span>
                            </div>

                            <div class="hm-pc-price-row" style="margin-bottom: 8px;">
                                @if($product->is_sale_active)
                                    <span class="hm-price-current">₱{{ number_format((float)$product->sale_price, 2) }}</span>
                                    <span class="hm-price-old">₱{{ number_format((float)$product->price, 2) }}</span>
                                @else
                                    <span class="hm-price-current">₱{{ number_format((float)$product->price, 2) }}</span>
                                @endif
                                <span class="hm-sold-count">{{ $product->total_sold ?? 0 }} Sold</span>
                            </div>

                            @auth
                                @if($product->variants && $product->variants->where('uom', '!=', null)->count() > 0)
                                    <button type="button" class="hm-btn hm-btn-outline hm-btn-block" style="margin-top:auto;" onclick="window.openProductModal({{ $product->id }}, event)">
                                        Select Options
                                    </button>
                                @else
                                    <form action="{{ route('cart.add') }}" method="POST" style="margin-top:auto;">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="hm-btn hm-btn-outline hm-btn-block" {{ $product->stock > 0 ? '' : 'disabled' }}>
                                            {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="hm-btn hm-btn-outline hm-btn-block" style="text-align:center;">Add to Cart</a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #888;">
                        <p>No products available at the moment.</p>
                    </div>
                @endforelse
            </div>
            
            <div style="text-align: center; margin-top: 32px;">
                <a href="{{ route('shop.all') }}" class="hm-btn hm-btn-secondary" style="padding: 12px 32px; font-size: 16px;">View All Products</a>
            </div>
        </section>

    </div>

    {{-- Script for Hero Carousel --}}
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hm-slide');
        const dots = document.querySelectorAll('.hm-dot');
        const carousel = document.getElementById('hm-main-carousel');
        let slideInterval;

        function showSlide(index) {
            if (!slides || slides.length === 0) return;
            dots[currentSlide].classList.remove('active');
            
            currentSlide = (index + slides.length) % slides.length;
            
            dots[currentSlide].classList.add('active');
            carousel.style.transform = 'translateX(-' + (currentSlide * 100) + '%)';
        }

        function moveSlide(dir) {
            showSlide(currentSlide + dir);
            resetInterval();
        }

        function goToSlide(index) {
            showSlide(index);
            resetInterval();
        }

        function resetInterval() {
            clearInterval(slideInterval);
            slideInterval = setInterval(() => moveSlide(1), 5000);
        }

        if (slides.length > 0) {
            slideInterval = setInterval(() => moveSlide(1), 5000);
        }
    </script>
@endsection
