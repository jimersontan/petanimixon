@extends('frontend.layouts.app')

@section('title', 'Brands - Pet Markt-PH')

@push('styles')
<style>
/* ── Premium Brands Page ── */
.brands-page {
    width: 100% !important;
    max-width: 100% !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
}

/* Hero Banner */
.brands-hero {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    padding: 44px 32px;
    text-align: center;
    margin: 0;
    border-radius: 0;
}

.brands-hero-title {
    font-size: 28px;
    color: #1a1a1a;
    margin: 0 0 8px;
    font-weight: 800;
}

.brands-hero-desc {
    font-size: 14px;
    color: #555;
    margin: 0;
}

/* Tabs */
.brand-tabs-container {
    margin-bottom: 28px;
    padding-top: 24px;
}

.brand-tabs {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
}

.brand-tab {
    padding: 8px 20px;
    color: #666;
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s;
    border: 1.5px solid #e0e0e0;
    border-radius: 24px;
    background: #fff;
    white-space: nowrap;
}

.brand-tab.active {
    background: var(--ud-orange);
    color: #fff;
    border-color: var(--ud-orange);
}

.brand-tab:hover:not(.active) {
    border-color: var(--ud-orange);
    color: var(--ud-orange);
}

/* Brand Cards Grid */
.brands-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 48px;
}

.brand-card {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 14px;
    padding: 28px 20px 24px;
    text-align: center;
    transition: all 0.25s;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.brand-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    border-color: #e0e0e0;
}

.brand-logo-wrap {
    height: 80px;
    width: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
    flex-shrink: 0;
}

.brand-logo-img {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #f0f0f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.brand-logo-placeholder {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--ud-orange), var(--ud-accent));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: 800;
    letter-spacing: 1px;
}

.brand-name {
    font-size: 16px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 6px;
}

.brand-tagline {
    font-size: 13px;
    color: #888;
    margin: 0 0 8px;
    line-height: 1.4;
}

.brand-product-count {
    font-size: 12px;
    color: #aaa;
    margin: 0 0 16px;
    flex-grow: 1;
}

.btn-view-brand {
    display: inline-block;
    padding: 9px 20px;
    border: 1.5px solid var(--ud-orange);
    color: var(--ud-orange);
    text-decoration: none;
    border-radius: 8px;
    font-weight: 700;
    font-size: 13px;
    transition: all 0.2s;
    width: 100%;
    text-align: center;
}

.btn-view-brand:hover {
    background: var(--ud-orange);
    color: #fff;
}

/* Why These Brands */
.brands-why-section {
    background: #FFF7ED;
    padding: 48px 32px;
    border-radius: 16px;
    margin-bottom: 48px;
}

.brands-why-title {
    font-size: 24px;
    color: #1a1a1a;
    text-align: center;
    margin: 0 0 36px;
    font-weight: 800;
}

.brands-why-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 32px;
}

.brands-why-item {
    text-align: center;
}

.brands-why-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
    font-size: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.brands-why-item h3 {
    font-size: 15px;
    color: #1a1a1a;
    margin: 0 0 6px;
    font-weight: 700;
}

.brands-why-item p {
    font-size: 13px;
    color: #666;
    margin: 0;
    line-height: 1.5;
}

/* Featured Brand */
.featured-brand-section {
    background: #fff;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    margin-bottom: 40px;
    border: 1px solid #f0f0f0;
}

.featured-brand-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
}

.featured-brand-img-wrap {
    background: linear-gradient(135deg, var(--ud-orange) 0%, var(--ud-accent) 100%);
    border-radius: 14px;
    height: 320px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.featured-brand-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.featured-brand-img-wrap .fb-placeholder {
    font-size: 48px;
    font-weight: 800;
    color: rgba(255,255,255,0.8);
    letter-spacing: 2px;
}

.featured-brand-info {
    display: flex;
    flex-direction: column;
}

.fb-badge {
    display: inline-block;
    background: var(--ud-orange);
    color: #fff;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 16px;
    width: fit-content;
}

.fb-name {
    font-size: 28px;
    color: #1a1a1a;
    margin: 0 0 12px;
    font-weight: 800;
}

.fb-desc {
    font-size: 14px;
    color: #555;
    line-height: 1.7;
    margin: 0 0 20px;
}

.fb-features {
    list-style: none;
    padding: 0;
    margin: 0 0 24px;
}

.fb-features li {
    padding: 6px 0;
    font-size: 14px;
    color: #333;
    display: flex;
    align-items: center;
    gap: 8px;
}

.fb-features li::before {
    content: '✓';
    color: var(--ud-orange);
    font-weight: 800;
}

.btn-shop-brand {
    display: inline-block;
    padding: 12px 32px;
    background: var(--ud-orange);
    color: #fff;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 14px;
    transition: all 0.2s;
    width: fit-content;
}

.btn-shop-brand:hover {
    background: #e07830;
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(255,140,66,0.35);
}

.no-brands-msg {
    grid-column: 1 / -1;
    text-align: center;
    padding: 40px;
    color: #888;
    font-size: 15px;
}

/* ── Mobile ── */
@media (max-width: 768px) {
    .brands-page { padding: 0 14px 40px; }
    .brands-hero { padding: 28px 16px; margin-bottom: 20px; margin-top: 12px; border-radius: 12px; }
    .brands-hero-title { font-size: 22px; }
    .brands-hero-desc { font-size: 13px; }

    .brand-tabs { gap: 6px; overflow-x: auto; flex-wrap: nowrap; scrollbar-width: none; justify-content: flex-start; padding-bottom: 4px; }
    .brand-tabs::-webkit-scrollbar { display: none; }
    .brand-tab { font-size: 12px; padding: 6px 14px; }
    .brand-tabs-container { margin-bottom: 20px; }

    .brands-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 28px; }
    .brand-card { padding: 18px 14px 16px; border-radius: 10px; }
    .brand-logo-wrap { height: 56px; width: 56px; margin-bottom: 10px; }
    .brand-logo-img, .brand-logo-placeholder { width: 52px; height: 52px; font-size: 18px; }
    .brand-name { font-size: 13px; }
    .brand-tagline { display: none; }
    .brand-product-count { font-size: 11px; margin-bottom: 10px; }
    .btn-view-brand { padding: 7px 10px; font-size: 12px; }

    .brands-why-section { padding: 28px 16px; border-radius: 12px; margin-bottom: 28px; }
    .brands-why-title { font-size: 20px; margin-bottom: 24px; }
    .brands-why-grid { gap: 20px; }
    .brands-why-icon { width: 44px; height: 44px; font-size: 20px; }
    .brands-why-item h3 { font-size: 14px; }
    .brands-why-item p { font-size: 12px; }

    .featured-brand-section { padding: 20px; margin-bottom: 28px; border-radius: 12px; }
    .featured-brand-grid { grid-template-columns: 1fr; gap: 20px; text-align: center; }
    .featured-brand-img-wrap { height: 200px; border-radius: 10px; }
    .fb-badge { margin-left: auto; margin-right: auto; }
    .fb-name { font-size: 22px; }
    .fb-desc { font-size: 13px; }
    .fb-features { text-align: left; display: inline-block; }
    .btn-shop-brand { width: 100%; text-align: center; }
}

@media (max-width: 480px) {
    .brands-grid { gap: 8px; }
    .brand-card { padding: 14px 10px 12px; }
    .brand-logo-wrap { height: 48px; width: 48px; }
    .brand-logo-img, .brand-logo-placeholder { width: 44px; height: 44px; font-size: 16px; }
    .brand-name { font-size: 12px; }
    .btn-view-brand { font-size: 11px; padding: 6px 8px; }
    .featured-brand-img-wrap { height: 160px; }
}
</style>
@endpush

@section('content')
<div class="brands-page">

    {{-- Hero --}}
    <div class="brands-hero">
        <h1 class="brands-hero-title">Brands We Trust & Carry</h1>
        <p class="brands-hero-desc">Partnering with industry leaders committed to quality and safety</p>
    </div>

    {{-- Tabs --}}
    <div class="brand-tabs-container">
        <div class="brand-tabs">
            <a href="#all" class="brand-tab active">All Brands</a>
            <a href="#premium" class="brand-tab">Premium</a>
            <a href="#budget" class="brand-tab">Budget-Friendly</a>
            <a href="#eco" class="brand-tab">Eco-Conscious</a>
        </div>
    </div>

    {{-- Grid --}}
    <div class="brands-grid">
        @forelse($brands as $brand)
        <div class="brand-card">
            <div class="brand-logo-wrap">
                @if($brand->logo_path)
                    <img src="{{ $brand->logo_full_url }}" alt="{{ $brand->name }}" class="brand-logo-img" onerror="this.onerror=null; this.src='{{ asset('images/placeholder.png') }}'">
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
            <div class="no-brands-msg">No brands available at the moment.</div>
        @endforelse
    </div>

    {{-- Why These Brands --}}
    <div class="brands-why-section">
        <h2 class="brands-why-title">Why These Brands?</h2>
        <div class="brands-why-grid">
            <div class="brands-why-item">
                <div class="brands-why-icon">✓</div>
                <h3>Quality Standards</h3>
                <p>Every brand is vetted for ingredients and safety</p>
            </div>
            <div class="brands-why-item">
                <div class="brands-why-icon">★</div>
                <h3>Proven Track Record</h3>
                <p>Brands with years of positive customer feedback</p>
            </div>
            <div class="brands-why-item">
                <div class="brands-why-icon">🌱</div>
                <h3>Ethical Practices</h3>
                <p>Committed to animal welfare and sustainability</p>
            </div>
        </div>
    </div>

    {{-- Featured Brand --}}
    @if($featuredBrand)
    <div class="featured-brand-section">
        <div class="featured-brand-grid">
            <div>
                <div class="featured-brand-img-wrap">
                    @if($featuredBrand->logo_path)
                        <img src="{{ $featuredBrand->logo_full_url }}" alt="{{ $featuredBrand->name }}" onerror="this.onerror=null; this.src='{{ asset('images/placeholder.png') }}'">
                    @else
                        <div class="fb-placeholder">{{ strtoupper(substr($featuredBrand->name, 0, 2)) }}</div>
                    @endif
                </div>
            </div>
            <div class="featured-brand-info">
                <span class="fb-badge">Featured Brand</span>
                <h2 class="fb-name">{{ $featuredBrand->name }}</h2>
                <p class="fb-desc">{{ $featuredBrand->name }} is one of our trusted partners, providing high-quality products for your pets. Explore the full range.</p>
                <ul class="fb-features">
                    <li>Quality assured</li>
                    <li>Trusted by experts</li>
                    <li>Pet-friendly materials</li>
                    <li>Sustainable practices</li>
                </ul>
                <a href="{{ route('shop.all', ['brand' => $featuredBrand->name]) }}" class="btn-shop-brand">Shop Brand</a>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
