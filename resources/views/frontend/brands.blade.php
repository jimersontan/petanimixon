@extends('frontend.layouts.app')

@section('title', 'Brands - Pet Animixon')

@section('content')
<!-- Hero Section -->
<div class="brands-hero">
    <h1 class="brands-hero-title">Brands We Trust & Carry</h1>
    <p class="brands-hero-desc">Partnering with industry leaders committed to quality and safety</p>
</div>

<div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <!-- Brand Category Tabs -->
    <div class="brand-tabs-container">
        <div class="brand-tabs">
            <a href="#all" class="brand-tab active">All Brands</a>
            <a href="#premium" class="brand-tab">Premium</a>
            <a href="#budget" class="brand-tab">Budget-Friendly</a>
            <a href="#eco" class="brand-tab">Eco-Conscious</a>
            <a href="#specialty" class="brand-tab">Specialty Brands</a>
        </div>
    </div>

    <!-- Brands Grid -->
    <div class="brands-grid">
        @forelse($brands as $brand)
        <!-- Brand Card -->
        <div class="brand-card">
            <div class="brand-logo-wrap">
                @if($brand->logo_path)
                    <img src="{{ asset('storage/' . $brand->logo_path) }}" alt="{{ $brand->name }}" class="brand-logo-img" onerror="this.onerror=null; this.src='{{ asset('images/placeholder.png') }}'">
                @else
                    <div class="brand-logo-placeholder">{{ strtoupper(substr($brand->name, 0, 2)) }}</div>
                @endif
            </div>
            <h3 class="brand-name">{{ $brand->name }}</h3>
            <p class="brand-tagline">Quality products from {{ $brand->name }}</p>
            <p class="brand-product-count">{{ $brand->products_count }} products</p>
            <a href="{{ route('shop.all', ['brand' => $brand->name]) }}" class="btn-view-brand">View Products</a>
        </div>
        @empty
            <div class="no-brands-msg">
                No brands available at the moment.
            </div>
        @endforelse
    </div>

    <!-- Why These Brands Section -->
    <div style="background-color: #fef5f0; padding: 60px 40px; border-radius: 12px; margin-bottom: 60px;">
        <h2 style="font-size: 32px; color: #333; text-align: center; margin: 0 0 50px 0; font-weight: 700;">Why These Brands?</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px;">
            <!-- Quality -->
            <div style="text-align: center;">
                <div style="font-size: 40px; margin-bottom: 15px;">✓</div>
                <h3 style="font-size: 18px; color: #333; margin: 0 0 10px 0; font-weight: 600;">Quality Standards</h3>
                <p style="font-size: 14px; color: #666; margin: 0;">Every brand is vetted for ingredients and safety</p>
            </div>

            <!-- Track Record -->
            <div style="text-align: center;">
                <div style="font-size: 40px; margin-bottom: 15px; color: var(--ud-orange, #FF8C42);">★</div>
                <h3 style="font-size: 18px; color: #333; margin: 0 0 10px 0; font-weight: 600;">Proven Track Record</h3>
                <p style="font-size: 14px; color: #666; margin: 0;">Brands with years of positive customer feedback</p>
            </div>

            <!-- Ethics -->
            <div style="text-align: center;">
                <div style="font-size: 40px; margin-bottom: 15px;">✈</div>
                <h3 style="font-size: 18px; color: #333; margin: 0 0 10px 0; font-weight: 600;">Ethical Practices</h3>
                <p style="font-size: 14px; color: #666; margin: 0;">Companies committed to animal welfare and sustainability</p>
            </div>
        </div>
    </div>

    <!-- Featured Brand Section -->
    @if($featuredBrand)
    <div style="background: white; border-radius: 12px; padding: 50px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);" class="featured-brand-card">
        <div class="featured-brand-grid">
            <!-- Left: Image -->
            <div>
                <div style="background: linear-gradient(135deg, #7fb3a3 0%, #6a9e8f 100%); border-radius: 12px; height: 400px; display: flex; align-items: center; justify-content: center; overflow: hidden;" class="featured-brand-img-wrap">
                    @if($featuredBrand->logo_path)
                        <img src="{{ asset('storage/' . $featuredBrand->logo_path) }}" alt="{{ $featuredBrand->name }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.src='{{ asset('images/placeholder.png') }}'">
                    @else
                        <div style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;font-size:48px;font-weight:700;color:white;letter-spacing:2px;">{{ strtoupper(substr($featuredBrand->name, 0, 2)) }}</div>
                    @endif
                </div>
            </div>

            <!-- Right: Info -->
            <div class="featured-brand-info">
                <div style="display: inline-block; background-color: var(--ud-orange, #FF8C42); color: white; padding: 6px 15px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 20px;">Featured Brand</div>
                
                <h2 style="font-size: 32px; color: #333; margin: 0 0 15px 0; font-weight: 700;">{{ $featuredBrand->name }}</h2>
                
                <p style="font-size: 14px; color: #666; line-height: 1.6; margin: 0 0 15px 0;">{{ $featuredBrand->name }} is one of our trusted partners, providing high-quality products for your pets.</p>

                <p style="font-size: 14px; color: #666; line-height: 1.6; margin: 0 0 20px 0;">We work closely with {{ $featuredBrand->name }} to ensure that you get the best value and quality for your pet care needs.</p>

                <p style="font-size: 14px; color: #666; line-height: 1.6; margin: 0 0 25px 0;">Explore the full range of {{ $featuredBrand->name }} products available in our shop today.</p>

                <!-- Features List -->
                <ul style="list-style: none; padding: 0; margin: 0 0 30px 0;">
                    <li style="padding: 8px 0; font-size: 14px; color: #333;">✓ Quality assured</li>
                    <li style="padding: 8px 0; font-size: 14px; color: #333;">✓ Trusted by experts</li>
                    <li style="padding: 8px 0; font-size: 14px; color: #333;">✓ Pet-friendly materials</li>
                    <li style="padding: 8px 0; font-size: 14px; color: #333;">✓ Sustainable practices</li>
                </ul>

                <a href="{{ route('shop.all', ['brand' => $featuredBrand->name]) }}" style="display: inline-block; padding: 12px 35px; background-color: var(--ud-orange, #FF8C42); color: white; text-decoration: none; border-radius: 6px; font-weight: 600; transition: background-color 0.3s;" class="btn-shop-brand">Shop Brand</a>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    /* Hero */
    .brands-hero {
        background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%); 
        padding: 60px 20px; 
        text-align: center; 
        margin-bottom: 50px;
    }
    .brands-hero-title {
        font-size: 40px; 
        color: #333; 
        margin: 0 0 15px 0; 
        font-weight: 700;
    }
    .brands-hero-desc {
        font-size: 16px; 
        color: #666; 
        margin: 0;
    }

    /* Tabs Container */
    .brand-tabs-container {
        margin-bottom: 50px;
    }
    .brand-tabs {
        display: flex; 
        justify-content: center; 
        gap: 30px; 
        flex-wrap: wrap;
    }
    .brand-tab {
        padding-bottom: 10px; 
        color: #666; 
        text-decoration: none; 
        font-weight: 600; 
        cursor: pointer; 
        transition: all 0.3s;
        border-bottom: 3px solid transparent;
        white-space: nowrap;
    }
    .brand-tab.active {
        border-bottom-color: var(--ud-orange, #FF8C42); 
        color: var(--ud-orange, #FF8C42);
    }
    .brand-tab:hover {
        opacity: 0.8;
    }

    /* Brand Cards Grid */
    .brands-grid {
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); 
        gap: 25px; 
        margin-bottom: 60px;
    }
    .brand-card {
        background: white; 
        border-radius: 8px; 
        padding: 30px; 
        text-align: center; 
        box-shadow: 0 2px 8px rgba(0,0,0,0.08); 
        transition: transform 0.3s, box-shadow 0.3s;
        display: flex;
        flex-direction: column;
    }
    .brand-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
    .brand-logo-wrap {
        height: 100px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        margin-bottom: 20px;
    }
    .brand-logo-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .brand-logo-placeholder {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #FF8C42, #f97316);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: 1px;
    }
    .brand-name {
        font-size: 18px; 
        font-weight: 700; 
        color: #333; 
        margin: 0 0 10px 0;
    }
    .brand-tagline {
        font-size: 14px; 
        color: #666; 
        margin: 0 0 15px 0;
    }
    .brand-product-count {
        font-size: 13px; 
        color: #999; 
        margin: 0 0 20px 0;
        flex-grow: 1;
    }
    .btn-view-brand {
        display: inline-block; 
        padding: 10px 25px; 
        border: 2px solid var(--ud-orange, #FF8C42); 
        color: var(--ud-orange, #FF8C42); 
        text-decoration: none; 
        border-radius: 6px; 
        font-weight: 600; 
        transition: all 0.3s;
        width: 100%;
    }
    .btn-view-brand:hover {
        background-color: var(--ud-orange, #FF8C42);
        color: white !important;
        opacity: 0.9;
    }
    .no-brands-msg {
        grid-column: 1 / -1; 
        text-align: center; 
        padding: 40px; 
        color: #999;
    }

    /* Featured Brand Layout */
    .featured-brand-grid {
        display: grid; 
        grid-template-columns: 1fr 1fr; 
        gap: 40px; 
        align-items: center;
    }

    /* =========================================
       Mobile Responsive
       ========================================= */
    @media (max-width: 768px) {
        .brands-hero {
            padding: 28px 16px;
            margin-bottom: 20px;
            margin-left: -0.8rem;
            margin-right: -0.8rem;
            border-radius: 0;
        }
        .brands-hero-title {
            font-size: 22px;
        }
        .brands-hero-desc {
            font-size: 13px;
        }

        .brand-tabs-container {
            margin-bottom: 20px;
        }
        .brand-tabs {
            justify-content: flex-start;
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 8px;
            padding-bottom: 8px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .brand-tabs::-webkit-scrollbar {
            display: none;
        }
        .brand-tab {
            font-size: 13px;
            padding: 7px 14px;
            background: #fcfcfc;
            border: 1px solid #e0e0e0;
            border-bottom: none;
            border-radius: 20px;
            white-space: nowrap;
        }
        .brand-tab.active {
            background: var(--ud-orange-light, #FFF3E0);
            border: 1px solid var(--ud-orange, #FF8C42);
            color: var(--ud-orange, #FF8C42);
        }

        .brands-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 30px;
        }
        .brand-card {
            padding: 16px 12px;
            border-radius: 8px;
        }
        .brand-logo-wrap {
            height: 60px;
            margin-bottom: 10px;
        }
        .brand-name {
            font-size: 13px;
            margin-bottom: 4px;
        }
        .brand-tagline {
            display: none;
        }
        .brand-product-count {
            font-size: 11px;
            margin-bottom: 10px;
        }
        .btn-view-brand {
            padding: 7px 10px;
            font-size: 12px;
            border-radius: 5px;
        }

        /* Why These Brands */
        div[style*="background-color: #fef5f0"] {
            padding: 30px 16px !important;
            border-radius: 8px !important;
            margin-bottom: 30px !important;
        }
        div[style*="background-color: #fef5f0"] h2 {
            font-size: 22px !important;
            margin-bottom: 24px !important;
        }
        div[style*="font-size: 40px"] {
            font-size: 28px !important;
        }
        div[style*="background-color: #fef5f0"] h3 {
            font-size: 15px !important;
        }
        div[style*="background-color: #fef5f0"] p {
            font-size: 12.5px !important;
        }

        .featured-brand-grid {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 20px;
        }
        .featured-brand-card {
            padding: 20px !important;
            margin-bottom: 30px;
        }
        .featured-brand-img-wrap {
            height: 200px !important;
        }
        .featured-brand-info ul {
            text-align: left;
            display: inline-block;
        }
        .featured-brand-info h2 {
            font-size: 22px !important;
        }
        .featured-brand-info p {
            font-size: 13px !important;
        }
        .btn-shop-brand {
            width: 100%;
            text-align: center;
            padding: 10px 20px !important;
            font-size: 14px !important;
        }
    }

    @media (max-width: 480px) {
        .brands-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }
        .brand-card { padding: 12px 10px; }
        .brand-logo-wrap { height: 50px; }
        .brand-name { font-size: 12px; }
        .btn-view-brand { font-size: 11px; padding: 6px 8px; }
        .featured-brand-img-wrap { height: 160px !important; }
    }
</style>
@endsection
