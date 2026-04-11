@extends('frontend.layouts.app')

@section('title', 'PetMarkt-PH - Everything Your Pet Needs')

@section('content')
    @if(session('message'))
        <div class="ud-msg">{{ session('message') }}</div>
    @endif

    <!-- Hero Section -->
    <section class="ud-hero">
        <style>
            .pawnest-hero-wrapper {
                display: flex; 
                gap: 2rem; 
                align-items: stretch; 
                padding: 0 2rem;
                max-width: 1400px;
                margin: 2.5rem auto 3rem auto;
                font-family: 'Inter', -apple-system, sans-serif;
            }
            .pawnest-hero-main {
                flex: 1.6;
                background: #fff;
                border-radius: 20px;
                padding: 2.5rem;
                display: flex;
                flex-direction: column;
                border: 1px solid #eaeaea;
                /* Note: avoiding heavy shadow to match the flat/clean look from the image */
            }
            .pawnest-hero-right {
                flex: 1;
                display: flex;
                flex-direction: column;
                gap: 2rem;
            }
            
            /* Banner Header */
            .pn-cat-heading {
                font-size: 2rem; 
                font-weight: 500; /* Classy thin or normal weight serif feel */
                font-family: 'Georgia', serif; /* Use serif for that specific heading look in image */
                color: #212c3d; 
                margin: 0 0 0.3rem 0;
                letter-spacing: -0.2px;
            }
            .pn-cat-subtitle {
                color: #8c98a4;
                margin: 0;
                font-size: 1rem;
            }
            .pn-view-all {
                color: var(--ud-orange, #2E6C34);
                font-weight: 600;
                text-decoration: none;
                font-size: 1rem;
            }
            
            /* Slider */
            .pn-slider {
                display: flex;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                scroll-behavior: smooth;
                gap: 1.5rem;
                padding-bottom: 0rem;
                scrollbar-width: none; /* Firefox */
                margin-top: 2rem;
                flex: 1;
            }
            .pn-slider::-webkit-scrollbar {
                display: none; /* Safari and Chrome */
            }
            .pn-slide-item {
                flex: 0 0 calc(50% - 0.75rem);
                scroll-snap-align: start;
                display: flex;
                flex-direction: column;
            }
            
            .pn-slide-img-box {
                background: #f6f5f2;
                border-radius: 16px;
                height: 220px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1.2rem;
            }
            .pn-slide-img-box img {
                max-height: 85%;
                max-width: 85%;
                object-fit: contain;
                mix-blend-mode: multiply;
            }
            
            .pn-pill {
                display: inline-block;
                border-radius: 20px;
                padding: 0.25rem 0.75rem;
                font-weight: 600;
                font-size: 0.75rem;
                margin-bottom: 0.8rem;
                width: max-content;
            }
            .pn-pill-green {
                background: var(--ud-orange-light, #e9f2ea);
                color: var(--ud-orange, #3b7c42);
            }
            .pn-pill-red {
                background: var(--ud-accent-light, #fdeaea);
                color: var(--ud-accent, #c94646);
            }
            
            /* Product info */
            .pn-prod-title {
                font-size: 1.1rem;
                font-weight: 700;
                color: #1a202c;
                margin: 0 0 0.5rem;
                line-height: 1.4;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .pn-prod-reviews {
                font-size: 0.85rem;
                color: #9aa2ac;
                margin-bottom: 0.8rem;
            }
            .pn-prod-price-area {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin-bottom: 1rem;
            }
            .pn-price-current {
                font-weight: 800;
                color: var(--ud-orange, #3b7c42);
                font-size: 1.2rem;
            }
            .pn-price-old {
                color: #bdc3c7;
                text-decoration: line-through;
                font-size: 0.9rem;
            }
            
            .pn-btn-faint {
                width: 100%;
                padding: 0.8rem;
                background: #fff;
                border: 1px solid var(--ud-orange, #ea580c);
                color: var(--ud-orange, #ea580c);
                border-radius: 8px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s;
                text-align: center;
                margin-top: auto;
            }
            .pn-btn-faint:hover {
                background: var(--ud-orange, #ea580c);
                color: #fff;
            }
            
            /* Bottom pagination */
            .pn-slider-controls {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 1.5rem;
                padding-top: 1.5rem;
                border-top: 1px solid #f0f0f0;
            }
            .pn-dots {
                display: flex;
                gap: 6px;
            }
            .pn-dot-active {
                width: 24px;
                height: 6px;
                background: var(--ud-orange, #3b7c42);
                border-radius: 4px;
            }
            .pn-dot-inactive {
                width: 6px;
                height: 6px;
                background: #e2e2e2;
                border-radius: 50%;
            }
            .pn-arrow-btn {
                border: 1px solid #f0f0f0;
                background: #fff;
                width: 38px;
                height: 38px;
                border-radius: 10px;
                cursor: pointer;
                color: #ccc;
                font-size: 1.2rem;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                transition: border-color 0.2s, color 0.2s;
            }
            .pn-arrow-btn:hover {
                border-color: var(--ud-orange, #3b7c42);
                color: var(--ud-orange, #3b7c42);
            }
            
            /* Right Cards */
            .pn-right-card {
                background: #fff;
                border-radius: 20px;
                padding: 1.5rem;
                display: flex;
                flex-direction: column;
                gap: 1rem;
                flex: 1;
                border: 1px solid #eaeaea;
                align-items: stretch;
            }
            .pn-right-img-box {
                width: 100%;
                height: 155px;
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .pn-right-img-box img {
                max-width: 90%;
                max-height: 90%;
                object-fit: contain;
                mix-blend-mode: multiply;
            }
            /* Colors for right card image backgrounds */
            .bg-cream { background: var(--ud-hero-bg, #fdf5eb); }
            .bg-blue { background: var(--ud-category-1, #eff4f8); }
            
            .pn-plus-btn {
                border: 1px solid #f0f0f0;
                background: #fff;
                width: 34px;
                height: 34px;
                border-radius: 8px;
                color: #ddd;
                font-size: 1.2rem;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: border-color 0.2s, color 0.2s;
            }
            .pn-plus-btn:hover {
                border-color: var(--ud-orange, #3b7c42);
                color: var(--ud-orange, #3b7c42);
            }

            @media (max-width: 1100px) {
                .pawnest-hero-wrapper {
                    padding: 0 1rem;
                    gap: 1.5rem;
                }
                .pawnest-hero-main {
                    padding: 1.5rem;
                }
                .pn-right-card {
                    padding: 1.25rem;
                    gap: 1rem;
                }
                .pn-right-img-box {
                    width: 100%;
                    height: 140px;
                }
            }
            @media (max-width: 900px) {
                .pawnest-hero-wrapper {
                    padding: 0 1rem;
                    gap: 1rem;
                }
                .pawnest-hero-main {
                    padding: 1.2rem;
                }
                .pn-right-card {
                    padding: 1rem;
                    gap: 0.8rem;
                }
                .pn-right-img-box {
                    width: 100%;
                    height: 120px;
                }
                .pn-cat-heading { 
                    font-size: 1.8rem !important; 
                    font-weight: 700 !important;
                }
                .pn-cat-subtitle { font-size: 0.9rem; }
                .pn-prod-title { font-size: 1rem; }
                .pn-popular-header-img {
                    width: 60px !important;
                    height: 60px !important;
                }
            }

            @media (max-width: 600px) {
                .pawnest-hero-wrapper {
                    padding: 0 0.5rem;
                    gap: 0.5rem;
                    margin: 1rem auto 1.5rem auto;
                    /* Core requirement: keep exact PC arrangement (row) */
                    flex-direction: row; 
                    align-items: stretch;
                }
                .pawnest-hero-main {
                    flex: 1.6;
                    padding: 0.6rem;
                    border-radius: 12px;
                    overflow: hidden;
                }
                .pawnest-hero-right {
                    flex: 1;
                    gap: 0.5rem;
                    overflow: hidden;
                }
                .pn-cat-heading {
                    font-size: 1.25rem !important;
                    margin-bottom: 2px;
                    font-weight: 700 !important;
                    white-space: normal;
                    line-height: 1.1;
                }
                .pn-cat-subtitle {
                    font-size: 0.75rem !important;
                    white-space: normal;
                    line-height: 1.2;
                }
                .pn-view-all {
                    font-size: 0.65rem;
                    white-space: nowrap;
                }
                .pn-popular-header-img {
                    width: 32px !important;
                    height: 32px !important;
                }
                
                .pn-slider {
                    gap: 0.4rem;
                    margin-top: 0.6rem;
                }
                .pn-slide-item {
                    /* ensure 2 items fit exactly side by side */
                    flex: 0 0 calc(50% - 0.2rem);
                    min-width: 0; 
                }
                .pn-slide-img-box {
                    height: 85px;
                    border-radius: 8px;
                    margin-bottom: 0.3rem;
                }
                .pn-pill {
                    font-size: 0.50rem;
                    padding: 2px 5px;
                    margin-bottom: 0.3rem;
                }
                .pn-prod-title {
                    font-size: 0.70rem;
                    margin-bottom: 0.2rem;
                    -webkit-line-clamp: 2;
                    line-height: 1.2;
                }
                .pn-prod-reviews {
                    font-size: 0.55rem;
                    margin-bottom: 0.3rem;
                }
                .pn-prod-price-area {
                    margin-bottom: 0.4rem;
                    gap: 3px;
                }
                .pn-price-current {
                    font-size: 0.80rem;
                }
                .pn-price-old {
                    font-size: 0.60rem;
                }
                .pn-btn-faint {
                    padding: 0.3rem;
                    font-size: 0.60rem;
                    border-radius: 6px;
                }
                .pn-slider-controls {
                    margin-top: 0.6rem;
                    padding-top: 0.5rem;
                }
                .pn-dots {
                    gap: 3px;
                }
                .pn-dot-active {
                    width: 12px; height: 4px; border-radius: 2px;
                }
                .pn-dot-inactive {
                    width: 4px; height: 4px;
                }

                /* Right cards on mobile */
                .pn-right-card {
                    padding: 0.55rem;
                    border-radius: 12px;
                    gap: 0.45rem;
                    flex-direction: column;
                    align-items: stretch;
                }
                .pn-right-img-box {
                    width: 100%;
                    height: 92px;
                    border-radius: 10px;
                    min-width: 0;
                }
                /* text container inside right card needs to fit */
                .pn-right-card > div:last-child {
                    display: flex;
                    flex-direction: column;
                    justify-content: flex-start;
                    overflow: hidden;
                    min-width: 0;
                    width: 100%;
                }
                .pn-right-card .pn-pill {
                    font-size: 0.52rem;
                    padding: 2px 5px;
                    margin-bottom: 3px;
                    align-self: flex-start;
                    line-height: 1;
                }
                .pn-right-card .pn-prod-title {
                    font-size: 0.72rem !important;
                    margin-bottom: 0.18rem;
                    line-height: 1.2;
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                    white-space: normal;
                    overflow: hidden;
                }
                .pn-right-card p {
                    display: none; /* hide description to save space */
                }
                .pn-right-card .pn-prod-price-area {
                    margin-top: 1px !important;
                    margin-bottom: 0 !important;
                    flex-wrap: wrap;
                    align-items: baseline;
                    gap: 4px;
                    min-width: 0;
                }
                .pn-right-card .pn-price-current {
                    font-size: 0.82rem;
                    line-height: 1;
                    white-space: nowrap;
                }
                .pn-right-card .pn-price-old {
                    font-size: 0.62rem;
                    line-height: 1;
                    white-space: nowrap;
                }
                .pn-right-card .explore-now-text {
                    display: none; /* hide "Explore now" text on small mobile */
                }
                .pn-plus-btn {
                    width: 20px; height: 20px; font-size: 0.8rem; border-radius: 4px;
                    padding: 0;
                }
            }

            /* Mobile optimized sales section */
            @media (max-width: 900px) {
                .sales-section {
                    padding: 0 1rem;
                    margin-bottom: 2rem !important;
                    margin-top: 1.5rem !important;
                }
                .sales-header {
                    flex-direction: column !important;
                    align-items: flex-start !important;
                    margin-bottom: 16px !important;
                }
                .sales-grid {
                    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)) !important;
                    gap: 12px !important;
                }
            }

            @media (max-width: 600px) {
                .sales-section {
                    padding: 0 0.75rem;
                    margin-bottom: 2rem !important;
                    margin-top: 1rem !important;
                }
                .sales-header h2 {
                    font-size: 1.25rem !important;
                }
                .sales-header p {
                    font-size: 0.85rem !important;
                }
                .sales-view-all {
                    font-size: 0.85rem !important;
                }
                .sales-grid {
                    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)) !important;
                    gap: 10px !important;
                }
                .sales-card {
                    border-radius: 10px !important;
                }
                .sales-card-img {
                    aspect-ratio: 1 !important;
                }
                .sales-card-content {
                    padding: 10px !important;
                }
                .sales-card-title {
                    font-size: 12px !important;
                    min-height: 24px !important;
                }
                .sales-card-brand {
                    font-size: 11px !important;
                }
                .sales-card-price {
                    font-size: 14px !important;
                }
                .sales-card-original {
                    font-size: 12px !important;
                }
                .sales-badge {
                    padding: 4px 8px !important;
                    font-size: 10px !important;
                }
            }

            /* Product grid */
            .products-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
                gap: 20px;
                margin-top: 2rem;
            }

            /* Product card */
            .product-card {
                text-decoration: none;
                color: inherit;
                background: white; border-radius: 12px;
                overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.08);
                transition: transform .25s, box-shadow .25s;
                display: flex;
                flex-direction: column;
            }
            .product-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,.13); }

            .product-img-wrap {
                position: relative; height: 220px;
                background: #f5f5f5; overflow: hidden;
            }
            .product-img-wrap img {
                width: 100%; height: 100%; object-fit: contain;
                mix-blend-mode: multiply;
                transition: transform .35s;
            }
            .product-card:hover .product-img-wrap img { transform: scale(1.04); }
            .product-badge {
                position: absolute; top: 12px; right: 12px;
                padding: 3px 10px; border-radius: 5px;
                font-size: 11px; font-weight: 700; letter-spacing: .5px;
                z-index: 2;
            }
            .badge-sale { background: #FF8C42; color: white; }
            .badge-new  { background: #222; color: white; }

            .product-body { padding: 14px 16px 16px; display: flex; flex-direction: column; flex: 1; }
            .product-rating { display: flex; align-items: center; gap: 4px; margin-bottom: 6px; margin-top: auto; }
            .product-rating .stars { font-size: 13px; color: #ffa500; }
            .product-rating .count { font-size: 12px; color: #aaa; }
            .product-name {
                font-size: 14px; font-weight: 600; color: #222;
                margin: 0 0 6px; line-height: 1.4; min-height: 40px;
                display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
            }

            .product-price-row { display: flex; align-items: baseline; gap: 8px; margin-bottom: 6px; }
            .product-price {
                font-size: 20px; font-weight: 800; color: #FF8C42;
            }
            .product-original { font-size: 13px; color: #bbb; text-decoration: line-through; }
            .product-stock {
                font-size: 12px; margin-bottom: 12px;
                display: flex; align-items: center; gap: 4px;
            }
            .stock-in  { color: #3DB868; }
            .stock-low { color: #FF8C42; }
            .stock-out { color: #e44; }
            .btn-add-to-cart {
                width: 100%; padding: 10px;
                background: #FF8C42; color: white;
                border: none; border-radius: 8px;
                font-size: 14px; font-weight: 700;
                cursor: pointer; transition: opacity .2s;
                margin-top: auto;
            }
            .btn-add-to-cart:hover { opacity: .88; }
            .btn-add-to-cart:disabled { background: #ccc; cursor: not-allowed; }

            @media (max-width: 768px) {
                .products-grid {
                    grid-template-columns: repeat(3, 1fr);
                    gap: 8px;
                }
                .product-card {
                    border-radius: 8px;
                    box-shadow: 0 1px 4px rgba(0,0,0,.06);
                }
                .product-card:hover { transform: none; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
                .product-img-wrap { height: 140px; }
                .product-img-wrap img { transition: none; }
                .product-card:hover .product-img-wrap img { transform: none; }
                .product-badge { top: 6px; right: 6px; padding: 2px 6px; font-size: 9px; }
                .product-body { padding: 8px 10px 10px; }
                .product-rating .stars { font-size: 11px; }
                .product-rating .count { font-size: 10px; }
                .product-name {
                    font-size: 12px; min-height: auto; margin-bottom: 2px;
                }
                .product-pet-icon { font-size: 14px; margin-bottom: 2px; }
                .product-price-row { margin-bottom: 4px; }
                .product-price { font-size: 16px; }
                .product-original { font-size: 11px; }
                .product-stock { font-size: 10px; margin-bottom: 6px; }
                .btn-add-to-cart {
                    padding: 7px; font-size: 12px; border-radius: 6px;
                }
            }
            @media (max-width: 480px) {
                .products-grid { grid-template-columns: repeat(3, 1fr); gap: 6px; }
                .product-img-wrap { height: 120px; }
                .product-body { padding: 6px 8px 8px; }
                .product-price { font-size: 14px; }
                .btn-add-to-cart { padding: 6px; font-size: 11px; }
            }
        </style>

        <div class="pawnest-hero-wrapper">
            {{-- Main Big Banner (Left/Center) --}}
            <div class="pawnest-hero-main">
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; width: 100%;">
                    <div style="min-width: 0;">
                        <div style="display: flex; align-items: center; gap: 0.4rem;">
                            <img src="{{ asset('images/sport-fire-sticker.gif') }}" alt="Sport Fire Sticker" class="pn-popular-header-img" style="width: 30px; height: 30px; object-fit: contain; flex-shrink: 0;">
                            <h1 class="pn-cat-heading" style="margin: 0; font-size: 1.5rem; font-weight: 800; color: #1a1a1a; line-height: 1.1;">Popular Products</h1>
                        </div>
                        <p class="pn-cat-subtitle" style="margin: 0; font-size: 0.9rem; color: #888; line-height: 1.2; margin-top: 2px;">Loved by pet parents everywhere</p>
                    </div>
                    <a href="{{ route('shop.all') }}" class="pn-view-all" style="flex-shrink: 0;">View all &rarr;</a>
                </div>

                <div class="pn-slider" id="pn-banner-slider">
                    <!-- Default to a collection to ensure it doesn't break, mapping 4 generic cards if empty -->
                    @php 
                        $slides = ($heroProducts ?? collect())->take(6);
                        if ($slides->isEmpty()) {
                            // Dummy items just in case
                            $slides = collect([
                                (object)['id'=>1, 'product_name'=>'Royal Canin Adult Dog Dry Food', 'price'=>1290, 'image_url'=>asset('images/default.png')],
                                (object)['id'=>2, 'product_name'=>'Whiskas Tuna Flavour Cat Food', 'price'=>890, 'image_url'=>asset('images/default.png')]
                            ]);
                        }
                    @endphp
                    @foreach($slides as $index => $hp)
                        <div class="pn-slide-item">
                            <a href="{{ route('product.show', $hp->id) }}" style="text-decoration: none; color: inherit; flex-grow: 1; display: flex; flex-direction: column;" onclick="window.openProductModal({{ $hp->id }}, event)">
                                <div class="pn-slide-img-box">
                                    <img src="{{ $hp->image_url }}" alt="{{ $hp->product_name }}" 
                                         onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22150%22 height=%22150%22%3E%3Crect fill=%22%23f5f5f5%22 width=%22150%22 height=%22150%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-family=%22Arial%22 font-size=%2215%22 fill=%22%23bbb%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E';">
                                </div>
                                <div class="pn-pill pn-pill-green">
                                    {{ $index % 2 == 0 ? 'Best Seller' : 'Top Rated' }}
                                </div>
                                <h4 class="pn-prod-title">{{ $hp->product_name }}</h4>
                                @php
                                    $hpReviewCount = $hp->reviews()->count();
                                    $hpReviewAvg = $hp->avg_rating > 0 ? number_format($hp->avg_rating, 1) : '0.0';
                                    $hpReviewFmt = $hpReviewCount >= 1000 ? round($hpReviewCount / 1000, 1) . 'k' : $hpReviewCount;
                                @endphp
                                <div class="pn-prod-reviews">{{ $hpReviewAvg }} &starf; &middot; {{ $hpReviewFmt }} {{ Str::plural('review', $hpReviewCount) }}</div>
                                @php
                                    $currentPrice = $hp->price;
                                    $hasDiscount = false;
                                    if ($hp->discount_type === 'percent' && $hp->discount_amount > 0) {
                                        $currentPrice = $hp->price * (1 - ($hp->discount_amount / 100));
                                        $hasDiscount = true;
                                    } elseif ($hp->discount_type === 'fixed' && $hp->discount_amount > 0) {
                                        $currentPrice = max(0, $hp->price - $hp->discount_amount);
                                        $hasDiscount = true;
                                    }
                                @endphp
                                <div class="pn-prod-price-area">
                                    <span class="pn-price-current">₱{{ number_format((float)$currentPrice, 2) }}</span>
                                    @if($hasDiscount)
                                        <span class="pn-price-old">₱{{ number_format((float)$hp->price, 0) }}</span>
                                    @endif
                                </div>
                            </a>
                            @auth
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $hp->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="pn-btn-faint">Add to Cart</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="pn-btn-faint" style="display: block; text-decoration: none; box-sizing: border-box; text-align: center;">Add to Cart</a>
                            @endauth
                        </div>
                    @endforeach
                </div>
                
                {{-- Pagination controls --}}
                <div class="pn-slider-controls">
                    <div class="pn-dots" id="pn-slider-dots">
                        <div class="pn-dot-active"></div>
                        <div class="pn-dot-inactive"></div>
                        <div class="pn-dot-inactive"></div>
                    </div>
                </div>
            </div>

            {{-- Right Side Cards (Promo Coupon Cards or Featured Sale Products) --}}
            <div class="pawnest-hero-right">
                @if(isset($promoCoupons) && $promoCoupons->count() > 0)
                    @foreach($promoCoupons as $index => $promo)
                        @php
                            $promoProduct = $promo->featuredProduct;
                            if (!$promoProduct) continue;
                            $isFirst = ($index === 0);
                            $imgBgClass = $isFirst ? 'bg-cream' : 'bg-blue';
                            
                            // Build discount label
                            if ($promo->discount_type === 'percent' || $promo->discount_type === 'percentage') {
                                $discountLabel = (int)$promo->discount_amount . '% OFF';
                                $originalPrice = $promoProduct->price / (1 - (float)$promo->discount_amount / 100);
                            } else {
                                $discountLabel = '₱' . number_format((float)$promo->discount_amount, 0) . ' OFF';
                                $originalPrice = (float)$promoProduct->price + (float)$promo->discount_amount;
                            }
                        @endphp
                        <a href="{{ route('product.show', $promoProduct->id) }}" class="pn-right-card" style="text-decoration: none; color: inherit;" onclick="window.openProductModal({{ $promoProduct->id }}, event)">
                            <div class="pn-right-img-box {{ $imgBgClass }}">
                                <img src="{{ $promoProduct->image_url }}" alt="{{ $promoProduct->product_name }}" onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22150%22 height=%22150%22%3E%3Crect fill=%22%23f5f5f5%22 width=%22150%22 height=%22150%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-family=%22Arial%22 font-size=%2215%22 fill=%22%23bbb%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E';">
                            </div>
                            <div style="flex: 1; display: flex; flex-direction: column;">
                                <div class="pn-pill pn-pill-red">{{ $discountLabel }}</div>
                                <h4 class="pn-prod-title" style="font-size: 1.05rem;">{{ $promoProduct->product_name }}</h4>
                                <p style="font-size: 13px; color: #888; margin: 0 0 auto; line-height: 1.4;">{{ $promo->description ?: Str::limit($promoProduct->short_description, 60) }}</p>
                                
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px;">
                                    <div class="pn-prod-price-area" style="margin-bottom: 0;">
                                        <span class="pn-price-current">₱{{ number_format((float)$promoProduct->price, 2) }}</span>
                                        <span class="pn-price-old">₱{{ number_format($originalPrice, 0) }}</span>
                                    </div>
                                    <span class="explore-now-text" style="font-size: 13px; color: var(--ud-orange, #2E6C34); font-weight: 600;">Explore now &rarr;</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @elseif(isset($featuredSaleProducts) && $featuredSaleProducts->count() > 0)
                    {{-- Show featured sale products when no promo coupons are set --}}
                    @foreach($featuredSaleProducts as $index => $saleProduct)
                        @php
                            $isFirst = ($index === 0);
                            $imgBgClass = $isFirst ? 'bg-cream' : 'bg-blue';
                        @endphp
                        <a href="{{ route('product.show', $saleProduct->id) }}" class="pn-right-card" style="text-decoration: none; color: inherit;" onclick="window.openProductModal({{ $saleProduct->id }}, event)">
                            <div class="pn-right-img-box {{ $imgBgClass }}">
                                <img src="{{ $saleProduct->image_url }}" alt="{{ $saleProduct->product_name }}" onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22150%22 height=%22150%22%3E%3Crect fill=%22%23f5f5f5%22 width=%22150%22 height=%22150%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-family=%22Arial%22 font-size=%2215%22 fill=%22%23bbb%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E';">
                            </div>
                            <div style="flex: 1; display: flex; flex-direction: column;">
                                <div class="pn-pill pn-pill-red">🏷️ SALE</div>
                                <h4 class="pn-prod-title" style="font-size: 1.05rem;">{{ $saleProduct->product_name }}</h4>
                                <p style="font-size: 13px; color: #888; margin: 0 0 auto; line-height: 1.4;">{{ Str::limit($saleProduct->short_description, 60) }}</p>
                                
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px;">
                                    <div class="pn-prod-price-area" style="margin-bottom: 0;">
                                        @php
                                            $salePrice = $saleProduct->price;
                                            if ($saleProduct->discount_type === 'percent' && $saleProduct->discount_amount > 0) {
                                                $salePrice = $saleProduct->price * (1 - ($saleProduct->discount_amount / 100));
                                            } elseif ($saleProduct->discount_type === 'fixed' && $saleProduct->discount_amount > 0) {
                                                $salePrice = max(0, $saleProduct->price - $saleProduct->discount_amount);
                                            }
                                        @endphp
                                        <span class="pn-price-current">₱{{ number_format((float)$salePrice, 2) }}</span>
                                        <span class="pn-price-old">₱{{ number_format((float)$saleProduct->price, 0) }}</span>
                                    </div>
                                    <span class="explore-now-text" style="font-size: 13px; color: var(--ud-orange, #2E6C34); font-weight: 600;">Shop now &rarr;</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    {{-- Fallback: Show featured products when no promo coupons or featured sales are set --}}
                    @php 
                        $featuredArray = ($featuredProducts ?? collect())->take(2)->values();
                    @endphp
                    @foreach($featuredArray as $index => $fp)
                        @php
                            $isFirst = ($index === 0);
                            $discount = $isFirst ? 'Featured' : '30% OFF';
                            $pillClass = $isFirst ? 'pn-pill-green' : 'pn-pill-red';
                            $imgBgClass = $isFirst ? 'bg-cream' : 'bg-blue';
                        @endphp
                        <div class="pn-right-card">
                            <div class="pn-right-img-box {{ $imgBgClass }}">
                                <img src="{{ $fp->image_url }}" alt="{{ $fp->product_name }}" onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22150%22 height=%22150%22%3E%3Crect fill=%22%23f5f5f5%22 width=%22150%22 height=%22150%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-family=%22Arial%22 font-size=%2215%22 fill=%22%23bbb%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E';">
                            </div>
                            <div style="flex: 1; display: flex; flex-direction: column;">
                                <div class="pn-pill {{ $pillClass }}">{{ $discount }}</div>
                                <h4 class="pn-prod-title" style="font-size: 1.15rem;">{{ $fp->product_name }}</h4>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                                    @php
                                        $currentPrice = $fp->price;
                                        $hasDiscount = false;
                                        if ($fp->discount_type === 'percent' && $fp->discount_amount > 0) {
                                            $currentPrice = $fp->price * (1 - ($fp->discount_amount / 100));
                                            $hasDiscount = true;
                                        } elseif ($fp->discount_type === 'fixed' && $fp->discount_amount > 0) {
                                            $currentPrice = max(0, $fp->price - $fp->discount_amount);
                                            $hasDiscount = true;
                                        }
                                    @endphp
                                    <div class="pn-prod-price-area" style="margin-bottom: 0;">
                                        <span class="pn-price-current">₱{{ number_format((float)$currentPrice, 2) }}</span>
                                        @if($hasDiscount)
                                            <span class="pn-price-old">₱{{ number_format((float)$fp->price, 0) }}</span>
                                        @endif
                                    </div>
                                    @auth
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $fp->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="pn-plus-btn">&plus;</button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="pn-plus-btn" style="display: flex; align-items: center; justify-content: center; text-decoration: none;">&plus;</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Sales Products Section -->
        @if(isset($saleProducts) && $saleProducts->count() > 0)
        <div class="sales-section">
            <div class="sales-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <div>
                    <h2 style="font-size: 28px; font-weight: 700; color: #1a202c; font-family: 'Inter', sans-serif; margin: 0 0 4px 0;">🏷️ Sale Items</h2>
                    <p style="font-size: 14px; color: #666; margin: 0;">Limited time discounts on selected products</p>
                </div>
                <a href="{{ route('shop.all', ['discount' => 'on_sale']) }}" class="sales-view-all" style="color: var(--ud-orange, #E85D04); font-weight: 700; font-size: 15px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    View all sales <span style="font-size: 18px;">→</span>
                </a>
            </div>

            <div class="sales-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 20px;">
                @foreach($saleProducts as $saleProduct)
                <a href="{{ route('product.show', $saleProduct->id) }}" style="text-decoration: none; color: inherit;" onclick="window.openProductModal({{ $saleProduct->id }}, event)">
                    <div class="sales-card" style="border: 1px solid #eee; border-radius: 12px; overflow: hidden; transition: all 0.25s; hover:box-shadow: 0 8px 20px rgba(0,0,0,0.06); hover:border-color: var(--ud-orange, #E85D04);">
                        <div class="sales-card-img" style="position: relative; width: 100%; aspect-ratio: 1; background: #f9f9f9; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                            <img src="{{ $saleProduct->image_url }}" alt="{{ $saleProduct->product_name }}" 
                                 style="width: 100%; height: 100%; object-fit: cover;"
                                 onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22150%22 height=%22150%22%3E%3Crect fill=%22%23f5f5f5%22 width=%22150%22 height=%22150%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-family=%22Arial%22 font-size=%2214%22 fill=%22%23bbb%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E';">
                            <span class="sales-badge" style="position: absolute; top: 10px; right: 10px; background: #ef4444; color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">SALE</span>
                        </div>
                        <div class="sales-card-content" style="padding: 12px;">
                            <h3 class="sales-card-title" style="font-size: 13px; font-weight: 600; color: #1a202c; margin: 0 0 8px; line-height: 1.3; min-height: 26px;">{{ Str::limit($saleProduct->product_name, 50) }}</h3>
                            <div class="sales-card-brand" style="font-size: 12px; color: #888; margin-bottom: 8px;">{{ $saleProduct->brand_name ?? 'N/A' }}</div>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                @php
                                    $salePrice = $saleProduct->price;
                                    if ($saleProduct->discount_type === 'percent' && $saleProduct->discount_amount > 0) {
                                        $salePrice = $saleProduct->price * (1 - ($saleProduct->discount_amount / 100));
                                    } elseif ($saleProduct->discount_type === 'fixed' && $saleProduct->discount_amount > 0) {
                                        $salePrice = max(0, $saleProduct->price - $saleProduct->discount_amount);
                                    }
                                @endphp
                                <span class="sales-card-price" style="font-size: 15px; font-weight: 700; color: var(--ud-orange, #E85D04);">₱{{ number_format((float)$salePrice, 0) }}</span>
                                <span class="sales-card-original" style="font-size: 13px; color: #bbb; text-decoration: line-through;">₱{{ number_format((float)$saleProduct->price, 0) }}</span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Pet Specific Categories -->
        <div class="ud-pet-categories" style="margin-bottom: 3rem; margin-top: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-size: 20px; font-weight: 700; color: #1a202c; font-family: 'Inter', sans-serif;">Categories
                </h3>
                <a href="{{ route('shop.all') }}"
                    style="color: var(--ud-orange); font-weight: 600; font-size: 14px; text-decoration: none;">See All</a>
            </div>

            <div class="pet-categories-grid"
                style="display: flex; gap: 20px; overflow-x: auto; padding-bottom: 10px; scrollbar-width: none;">
                @forelse($animalTypes ?? collect() as $at)
                <a href="{{ route('shop.all', ['pet_type' => [$at->animal_type]]) }}" class="pet-cat-item"
                    style="display: flex; flex-direction: column; align-items: center; text-decoration: none; min-width: 85px;">
                    <div class="pet-cat-circle"
                        style="width: 85px; height: 85px; border-radius: 50%; background-color: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.06); display: flex; align-items: center; justify-content: center; margin-bottom: 10px; transition: all 0.3s ease;">
                        @if($at->image_url)
                            <img src="{{ asset('storage/' . $at->image_url) }}" alt="{{ $at->animal_type }}" style="width: 70%; height: 70%; object-fit: contain;">
                        @else
                            <span style="font-size: 42px;">🐾</span>
                        @endif
                    </div>
                    <span style="font-size: 15px; font-weight: 600; color: #333;">{{ $at->animal_type }}</span>
                </a>
                @empty
                <p style="color: #888;">No animal types configured yet.</p>
                @endforelse
            </div>
        </div>

        <div class="ud-purple-banner">
            <div class="ud-banner-header">
                <div class="ud-banner-icon">
                    <svg viewBox="0 0 24 24" fill="#6B46C1" width="28" height="28">
                        <path
                            d="M19 6h-4a3 3 0 0 0-6 0H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2zm-7-2a1 1 0 0 1 1 1h-2a1 1 0 0 1 1-1z" />
                    </svg>
                </div>
                <h2 class="ud-banner-title">We Sell Products Only, No Live Animals</h2>
            </div>
            <p class="ud-banner-desc">PetMarkt-PH is your trusted source for premium pet supplies, food, toys, and
                accessories. We're dedicated to providing quality products that keep your pets happy and healthy.</p>
            <a href="#" class="ud-banner-link">Learn More About Us &rarr;</a>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const slider = document.getElementById('pn-banner-slider');
                const dotsContainer = document.getElementById('pn-slider-dots');
                if(slider) {
                    const updateDots = () => {
                        if (!dotsContainer) return;
                        const scrollLeft = slider.scrollLeft;
                        const maxScroll = slider.scrollWidth - slider.clientWidth;
                        // Calculate active index (0 to 2 for 3 pages)
                        let activeIndex = 0;
                        if (maxScroll > 0) {
                            activeIndex = Math.round((scrollLeft / maxScroll) * 2);
                        }
                        
                        // Update dots classes
                        Array.from(dotsContainer.children).forEach((dot, index) => {
                            if (index === activeIndex) {
                                dot.className = 'pn-dot-active';
                            } else {
                                dot.className = 'pn-dot-inactive';
                            }
                        });
                    };

                    slider.addEventListener('scroll', updateDots);
                    
                    const autoSlide = () => {
                        // If we reached the end, reset to start smoothly, otherwise scroll right
                        if (slider.scrollLeft >= (slider.scrollWidth - slider.clientWidth - 10)) {
                            slider.scrollTo({ left: 0, behavior: 'smooth' });
                        } else {
                            // Scroll by approximately the width of one card + gap
                            slider.scrollBy({ left: 320, behavior: 'smooth' });
                        }
                    };
                    let slideInterval = setInterval(autoSlide, 3500); // 3.5 seconds
                    
                    // Optional: Pause on hover
                    slider.addEventListener('mouseenter', () => clearInterval(slideInterval));
                    slider.addEventListener('mouseleave', () => {
                        slideInterval = setInterval(autoSlide, 3500);
                    });
                }
            });
        </script>
    </section>

    <!-- Key Features (Trust Strip) -->
    <section class="ud-features">
        <div class="ud-feature-card">
            <div class="ud-feature-icon-wrapper icon-blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="2" y1="12" x2="22" y2="12"></line>
                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                    </path>
                </svg>
            </div>
            <h3>All Pets Welcome</h3>
            <p>Support for every species, from dogs to birds</p>
        </div>
        <div class="ud-feature-card">
            <div class="ud-feature-icon-wrapper icon-green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <h3>Family-Safe Products</h3>
            <p>Vetted for safety and quality standards</p>
        </div>
        <div class="ud-feature-card">
            <div class="ud-feature-icon-wrapper icon-orange">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path
                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                    </path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
            </div>
            <h3>Fast Shipping</h3>
            <p>Quick, reliable delivery to your door</p>
        </div>
        <div class="ud-feature-card">
            <div class="ud-feature-icon-wrapper icon-purple">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                </svg>
            </div>
            <h3>Expert Guides</h3>
            <p>Free care resources and pet tips</p>
        </div>
    </section>

    <!-- Browse by Category -->
    <section class="ud-section ud-categories">
        <h2 class="ud-section-title">
            Browse by Inclusive Category
        </h2>
        <div class="ud-category-grid" id="udCategoryGrid">
            @php
                $bgClasses = [
                    'bg-cat-0', 'bg-cat-1', 'bg-cat-2', 'bg-cat-3',
                    'bg-cat-4', 'bg-cat-5', 'bg-cat-6', 'bg-cat-7'
                ];
            @endphp
            @forelse($categories as $index => $category)
                @php
                    $bgClass = $bgClasses[$index % count($bgClasses)];
                @endphp
                <a href="{{ route('categories.show', $category->id) }}" class="ud-category-card {{ $bgClass }}">
                    <div class="ud-category-card-inner">
                        @if(!empty($category->image_url))
                            <img src="{{ asset('storage/' . $category->image_url) }}" alt="{{ $category->category_name }}" class="ud-cat-image">
                        @endif
                        <div class="ud-category-card-title">{{ $category->category_name }}</div>
                        <div class="ud-category-card-meta">{{ $category->products()->count() }} items available</div>
                    </div>
                </a>
            @empty
                <div class="ud-category-card" style="grid-column: 1 / -1; background: #fdf5e6;">
                    <div class="ud-category-card-inner">
                        <div class="ud-category-card-title">Check Back Soon!</div>
                        <div class="ud-category-card-meta">0 items available</div>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Latest Products -->
    <section class="ud-section" style="max-width: 1400px; margin: 0 auto; padding: 0 2rem; margin-bottom: 4rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.5rem;">
            <div>
                <h2 style="font-size: 2rem; font-weight: 700; font-family: 'Inter', sans-serif; color: #1a202c; margin-bottom: 0.5rem;">Recently Added Products</h2>
                <p style="color: #64748b; margin: 0;">Explore our latest pet essentials directly from the shop</p>
            </div>
            <a href="{{ route('shop.all') }}" style="color: var(--ud-orange, #FF8C42); font-weight: 600; text-decoration: none; padding-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">View All <span style="font-size: 1.2rem;">&rarr;</span></a>
        </div>
        
        <div class="products-grid">
            @forelse($latestProducts ?? [] as $product)
                @php /** @var \App\Models\Product $product */ @endphp
                <div class="product-card">
                    <div style="cursor:pointer;" onclick="window.openProductModal({{ $product->id }}, event)">
                        <div class="product-img-wrap" onclick="event.stopPropagation(); window.openProductModal({{ $product->id }}, event)">
                            <img
                                src="{{ $product->image_url }}"
                                alt="{{ $product->product_name }}"
                                onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22280%22 height=%22220%22%3E%3Crect fill=%22%23f5f5f5%22 width=%22280%22 height=%22220%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-family=%22Arial%22 font-size=%2215%22 fill=%22%23bbb%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E'">
                            @if($product->is_featured)
                                <span class="product-badge badge-new">FEATURED</span>
                            @endif
                        </div>

                        <div class="product-body">
                            <div style="font-size: 11px; color: #888; text-transform: uppercase; font-weight: 700; margin-bottom: 2px;">{{ $product->brand_name }}</div>
                            <h3 class="product-name" style="cursor:pointer; transition:color 0.2s;" onmouseover="this.style.color='var(--ud-orange)'" onmouseout="this.style.color='inherit'" onclick="event.stopPropagation(); window.openProductModal({{ $product->id }}, event)">{{ $product->product_name }}</h3>

                            @php
                                $pReviewCount = $product->reviews()->count();
                                $pReviewAvg = $product->avg_rating > 0 ? $product->avg_rating : 0;
                                $roundedAvg = round($pReviewAvg);
                                $pFmt = $pReviewCount >= 1000 ? round($pReviewCount / 1000, 1) . 'k' : $pReviewCount;
                            @endphp
                            <div class="product-rating" title="{{ number_format($pReviewAvg, 1) }} out of 5 stars">
                                <span class="stars">{!! str_repeat('★', $roundedAvg) !!}{!! str_repeat('☆', 5 - $roundedAvg) !!}</span>
                                <span class="count">({{ $pFmt }})</span>
                            </div>

                            <div class="product-price-row">
                                <span class="product-price">₱{{ number_format((float)$product->price, 0) }}</span>
                                @if($product->is_reduced)
                                    <span style="font-size: 13px; color: #bbb; text-decoration: line-through;">₱{{ number_format((float)$product->price * 1.2, 0) }}</span>
                                @endif
                            </div>

                            <div class="product-stock" style="margin-bottom: 16px;">
                                @if($product->stock > 4)
                                    <span class="stock-in">✓ In Stock ({{ $product->stock }} left)</span>
                                @elseif($product->stock > 0)
                                    <span class="stock-low">🔥 Only {{ $product->stock }} left!</span>
                                @else
                                    <span class="stock-out">✗ Out of Stock</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div style="padding: 0 16px 16px 16px; margin-top: auto;">
                        @auth
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button
                                    type="submit"
                                    class="btn-add-to-cart"
                                    style="width: 100%; border: none; outline: none;"
                                    {{ $product->stock > 0 ? '' : 'disabled' }}>
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn-add-to-cart" style="display: block; text-align: center; text-decoration: none; width: 100%; box-sizing: border-box;">Add to Cart</a>
                        @endauth
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #64748b; background: white; border-radius: 12px; border: 1px solid #eaeaea;">
                    <p style="margin: 0; font-size: 1.1rem;">No products available at the moment.</p>
                </div>
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
                <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=300&h=200&fit=crop"
                    alt="Happy dog with food">
            </div>
        </div>
        <div class="ud-promo-card ud-promo-blue">
            <div class="ud-promo-content">
                <h3>Premium Food for Your Happy Pets</h3>
                <a href="#" class="ud-btn ud-btn-promo">Shop Now</a>
            </div>
            <div class="ud-promo-image">
                <img src="https://images.unsplash.com/photo-1589924691995-400dc9ecc119?w=300&h=200&fit=crop"
                    alt="Pet food products">
            </div>
        </div>
    </section>

    <!-- Why Choose Our Pet Products -->
    <section class="ud-why-choose">
        <div class="ud-why-inner">
            <div class="ud-why-image">
                <img src="https://images.unsplash.com/photo-1576087001033-5e1e2d7a5b51?w=500&h=400&fit=crop"
                    alt="Happy pets">
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