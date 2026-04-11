@extends('frontend.layouts.app')

@section('title', 'Shop - PetMarkt-PH')

@push('styles')
<style>
    /* ── Hero Banner ───────────────────────────── */
    .shop-hero {
        background-color: #FF8C42;
        background-image: url("{{ asset('images/premium_pet_banner.png') }}");
        background-size: cover;
        background-position: center 30%;
        padding: 90px 20px 105px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .shop-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(80, 30, 0, 0.45) 0%, rgba(200, 70, 0, 0.3) 100%);
        opacity: 1;
    }
    .shop-hero-title { font-size: 52px; font-weight: 900; color: #fff; margin: 0 0 10px; position: relative; text-shadow: 0 4px 15px rgba(0,0,0,0.3); letter-spacing: -1px; }
    .shop-hero-sub   { font-size: 18px; color: rgba(255,255,255,0.95); margin: 0; position: relative; font-weight: 500; text-shadow: 0 2px 8px rgba(0,0,0,0.2); }
    /* curved bottom wave */
    .shop-hero-wave {
        position: absolute; bottom: -2px; left: 0; right: 0;
        height: 40px; background: white;
        clip-path: ellipse(55% 100% at 50% 100%);
    }

    /* ── Layout ───────────────────────────────── */
    .shop-layout {
        max-width: 1280px; margin: 0 auto;
        padding: 30px 24px;
        display: flex; gap: 28px;
    }

    /* ── Sidebar ──────────────────────────────── */
    .shop-sidebar {
        width: 220px; flex-shrink: 0;
    }
    .sidebar-section { margin-bottom: 28px; }
    .sidebar-section-header {
        display: flex; justify-content: space-between; align-items: center;
        cursor: pointer; padding-bottom: 10px;
        border-bottom: 1px solid #eee; margin-bottom: 14px;
    }
    .sidebar-section-header h3 {
        font-size: 15px; font-weight: 700; color: #222; margin: 0;
    }
    .sidebar-section-header span { font-size: 16px; color: #999; }

    .filter-label {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 10px; cursor: pointer; gap: 8px;
    }
    .filter-label-left { display: flex; align-items: center; gap: 8px; }
    .filter-label input[type="checkbox"] {
        width: 16px; height: 16px; cursor: pointer;
        accent-color: #3b7c42;
    }
    .filter-label span { font-size: 13.5px; color: #444; }
    .filter-count { font-size: 12px; color: #aaa; }

    /* Price Range */
    .price-slider { width: 100%; accent-color: #3b7c42; cursor: pointer; }
    .price-range-labels { display: flex; justify-content: space-between; font-size: 12px; color: #666; margin: 6px 0 12px; }
    .btn-apply {
        width: 100%; padding: 10px;
        background: #3b7c42; color: #fff; border: none;
        border-radius: 8px; font-size: 13px; font-weight: 700;
        cursor: pointer; transition: opacity .2s;
    }
    .btn-apply:hover { opacity: .88; }

    /* Ratings stars */
    .rating-label { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; cursor: pointer; }
    .rating-label input[type="radio"] { accent-color: #3b7c42; width: 15px; height: 15px; }
    .stars { color: #ffa500; font-size: 14px; letter-spacing: 1px; }
    .rating-label span { font-size: 13px; color: #555; }

    /* Availability toggle */
    .availability-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
    .availability-row label { font-size: 13px; color: #444; }
    .toggle-switch { position: relative; display: inline-block; width: 40px; height: 22px; }
    .toggle-switch input { display: none; }
    .toggle-slider {
        position: absolute; cursor: pointer; inset: 0;
        background: #ccc; border-radius: 34px; transition: .3s;
    }
    .toggle-slider::before {
        content: ''; position: absolute;
        width: 16px; height: 16px; left: 3px; bottom: 3px;
        background: white; border-radius: 50%; transition: .3s;
    }
    .toggle-switch input:checked + .toggle-slider { background: #3b7c42; }
    .toggle-switch input:checked + .toggle-slider::before { transform: translateX(18px); }

    .filter-label-on-sale { display: flex; align-items: center; gap: 8px; margin-top: 8px; cursor: pointer; }
    .filter-label-on-sale input { accent-color: #3b7c42; width: 16px; height: 16px; }
    .filter-label-on-sale span { font-size: 13px; color: #444; }

    .btn-clear-filters {
        width: 100%; padding: 10px;
        background: white; color: #3b7c42;
        border: 1.5px solid #3b7c42;
        border-radius: 8px; font-size: 13px; font-weight: 600;
        cursor: pointer; text-decoration: none; display: block;
        text-align: center; margin-top: 10px; transition: all .2s;
    }
    .btn-clear-filters:hover { background: #fff5ef; }

    /* Dropdown Toggle Button */
    .btn-toggle-sub {
        background: none; border: none; cursor: pointer; color: #888;
        padding: 0; display: flex; align-items: center; justify-content: center;
        transition: transform 0.2s, color 0.2s;
        border-radius: 4px;
        margin-left: 8px;
        height: 20px;
        max-height: 20px;
        line-height: 1;
        outline: none;
    }
    .btn-toggle-sub:hover { color: #3b7c42; background: #f0fdf4; }
    .btn-toggle-sub.expanded { transform: rotate(180deg); color: #3b7c42; }

    /* ── Main area ───────────────────────────── */
    .shop-main { flex: 1; min-width: 0; }

    /* Toolbar */
    .shop-toolbar {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 24px; flex-wrap: wrap; gap: 12px;
    }
    .shop-count { font-size: 13.5px; color: #666; }
    .shop-count strong { color: #333; }
    .toolbar-right { display: flex; align-items: center; gap: 8px; }
    .view-btn {
        width: 34px; height: 34px; border: none; border-radius: 6px;
        cursor: pointer; font-size: 16px; display: flex; align-items: center; justify-content: center;
        transition: all .2s;
    }
    .view-btn.active { background: #3b7c42; color: white; }
    .view-btn:not(.active) { background: #f0f0f0; color: #555; }
    .sort-select {
        padding: 7px 12px; border: 1px solid #ddd;
        border-radius: 6px; font-size: 13px; background: white; cursor: pointer;
    }
    .sort-label { font-size: 13px; color: #666; }

    /* Product grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 16px;
    }

    /* Product card */
    .product-card {
        background: white; border-radius: 12px;
        overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.08);
        transition: transform .25s, box-shadow .25s;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .product-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,.13); }

    .product-img-wrap {
        position: relative; height: 160px;
        background: #f5f5f5; overflow: hidden;
    }
    .product-img-wrap img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform .35s;
    }
    .product-card:hover .product-img-wrap img { transform: scale(1.04); }
    .product-badge {
        position: absolute; top: 12px; right: 12px;
        padding: 3px 10px; border-radius: 5px;
        font-size: 11px; font-weight: 700; letter-spacing: .5px;
    }
    .badge-sale { background: #3b7c42; color: white; }
    .badge-new  { background: #222; color: white; }

    .product-body { padding: 12px 14px 14px; display: flex; flex-direction: column; flex: 1; }
    .product-rating { display: flex; align-items: center; gap: 4px; margin-bottom: 6px; margin-top: auto; }
    .product-rating .stars { font-size: 13px; }
    .product-rating .count { font-size: 12px; color: #aaa; }
    .product-name {
        font-size: 13px; font-weight: 600; color: #222;
        margin: 0 0 6px; line-height: 1.4;
        display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        min-height: calc(1.4em * 2);
    }

    .product-price-row { display: flex; align-items: baseline; gap: 8px; margin-bottom: 6px; }
    .product-price {
        font-size: 18px; font-weight: 800; color: #3b7c42;
    }
    .product-original { font-size: 13px; color: #bbb; text-decoration: line-through; }
    .product-stock {
        font-size: 12px; margin-bottom: 12px;
        display: flex; align-items: center; gap: 4px;
    }
    .stock-in  { color: #3DB868; }
    .stock-low { color: #3b7c42; }
    .stock-out { color: #e44; }
    .btn-add-to-cart {
        width: 100%; padding: 10px;
        background: #3b7c42; color: white;
        border: none; border-radius: 8px;
        font-size: 14px; font-weight: 700;
        cursor: pointer; transition: opacity .2s;
        margin-top: auto;
    }
    .btn-add-to-cart:hover { opacity: .88; }
    .btn-add-to-cart:disabled { background: #ccc; cursor: not-allowed; }

    /* no products */
    .no-products { grid-column: 1/-1; text-align: center; padding: 60px 20px; }
    .no-products p { font-size: 17px; color: #888; }

    /* Pagination */
    .pagination-wrap { margin-top: 40px; text-align: center; }

    /* Mobile Filter Sidebar */
    .mobile-filter-btn {
        display: none;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }
    .sidebar-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 999;
        display: none;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .sidebar-overlay.active {
        opacity: 1;
    }
    .sidebar-close-btn {
        display: none;
        background: none;
        border: none;
        font-size: 24px;
        position: absolute;
        top: 15px;
        right: 15px;
        cursor: pointer;
        color: #555;
    }
    .mobile-filter-header {
        display: none;
        margin-bottom: 20px;
        font-size: 18px;
        font-weight: 800;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 850px) {
        .shop-layout { flex-direction: column; }
        .shop-sidebar { width: 100%; display: flex; flex-wrap: wrap; gap: 20px; }
        .shop-sidebar .sidebar-section { flex: 1; min-width: 250px; }
        .products-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 768px) {
        .shop-hero {
            margin-left: -0.8rem;
            margin-right: -0.8rem;
            padding: 28px 16px 36px;
        }
        .shop-hero-title { font-size: 24px; }
        .shop-hero-sub { font-size: 13px; }
        .shop-hero-wave { height: 24px; }

        .shop-layout { padding: 12px 0; gap: 12px; }

        .products-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .product-card {
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
        }
        .product-card:hover { transform: none; box-shadow: 0 1px 4px rgba(0,0,0,.06); }

        .product-img-wrap {
            height: 140px;
        }
        .product-img-wrap img { transition: none; }
        .product-card:hover .product-img-wrap img { transform: none; }
        .product-badge { top: 6px; right: 6px; padding: 2px 6px; font-size: 9px; }

        .product-body { padding: 8px 10px 10px; }
        .product-rating .stars { font-size: 11px; }
        .product-rating .count { font-size: 10px; }
        .product-name {
            font-size: 12px; min-height: auto; margin-bottom: 2px;
            display: -webkit-box; -webkit-line-clamp: 2;
            -webkit-box-orient: vertical; overflow: hidden;
            line-height: 1.3;
        }
        .product-pet-icon { font-size: 14px; margin-bottom: 2px; }
        .product-price-row { margin-bottom: 4px; }
        .product-price { font-size: 16px; }
        .product-original { font-size: 11px; }
        .product-stock { font-size: 10px; margin-bottom: 6px; }
        .btn-add-to-cart {
            padding: 7px; font-size: 12px; border-radius: 6px;
        }

        /* Shop toolbar */
        .shop-toolbar {
            flex-wrap: wrap; gap: 8px;
            margin-bottom: 12px;
        }
        .shop-count { font-size: 12px; width: auto; order: 0; margin: 0; }
        .toolbar-right { margin-left: auto; }
        .sort-select { padding: 5px 8px; font-size: 12px; }
        .sort-label { font-size: 12px; }
        .view-btn { width: 28px; height: 28px; font-size: 13px; }

        /* Sidebar drawer */
        .shop-sidebar {
            position: fixed;
            top: 0; left: -100%; bottom: 0;
            width: 85%; max-width: 300px;
            background: white; z-index: 1000;
            padding: 20px 16px; overflow-y: auto;
            display: block;
            transition: left 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            margin: 0;
        }
        .shop-sidebar.active { left: 0; }
        .mobile-filter-btn { display: flex; }
        .sidebar-close-btn { display: block; }
        .mobile-filter-header { display: block; }
    }
    @media (max-width: 480px) {
        .products-grid { grid-template-columns: repeat(2, 1fr); gap: 6px; }
        .product-img-wrap { height: 120px; }
        .product-body { padding: 6px 8px 8px; }
        .product-price { font-size: 14px; }
        .btn-add-to-cart { padding: 6px; font-size: 11px; }
        .shop-sidebar .sidebar-section { min-width: 100%; }
    }
</style>
@endpush

@section('content')

{{-- Hero Banner --}}
<div class="shop-hero">
    <div class="shop-hero-wave"></div>
    <h1 class="shop-hero-title">All Products</h1>
    <p class="shop-hero-sub">Discover quality products for every pet</p>
</div>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<div class="shop-layout">
    {{-- ══════════════════ SIDEBAR ══════════════════ --}}
    <aside class="shop-sidebar" id="shopSidebar">
        <button type="button" class="sidebar-close-btn" onclick="toggleSidebar()" aria-label="Close filters">✕</button>
        <div class="mobile-filter-header">Filters</div>
        <form method="GET" action="{{ route('shop.all') }}" id="filterForm">

            {{-- Pet Type --}}
            <div class="sidebar-section">
                <div class="sidebar-section-header">
                    <h3>Pet Type</h3>
                    <span>∨</span>
                </div>
                @php
                    $lifeStageMap = [
                        'dog' => ['puppy' => 'Puppy', 'adult' => 'Adult', 'senior' => 'Senior'],
                        'dogs' => ['puppy' => 'Puppy', 'adult' => 'Adult', 'senior' => 'Senior'],
                        'cat' => ['kitten' => 'Kitten', 'adult' => 'Adult', 'senior' => 'Senior'],
                        'cats' => ['kitten' => 'Kitten', 'adult' => 'Adult', 'senior' => 'Senior'],
                        'bird' => ['chick' => 'Chick', 'adult' => 'Adult'],
                        'birds' => ['chick' => 'Chick', 'adult' => 'Adult'],
                        'fish' => ['fry' => 'Fry', 'adult' => 'Adult'],
                        'reptile' => ['juvenile' => 'Juvenile', 'adult' => 'Adult'],
                        'reptiles' => ['juvenile' => 'Juvenile', 'adult' => 'Adult'],
                        'small-mammals' => ['young' => 'Young', 'adult' => 'Adult'],
                        'small mammals' => ['young' => 'Young', 'adult' => 'Adult'],
                    ];
                @endphp
                @foreach($petTypes as $pt)
                    @php 
                        $ptKey = strtolower($pt->animal_type); 
                        $hasSubFiltersChecked = false;
                        if (isset($lifeStageMap[$ptKey])) {
                            foreach (array_keys($lifeStageMap[$ptKey]) as $v) {
                                if (in_array($pt->animal_type . '_' . $v, request()->input('life_stage', []))) {
                                    $hasSubFiltersChecked = true;
                                    break;
                                }
                            }
                        }
                    @endphp
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px; height: 28px; min-height: 28px;">
                        <label class="filter-label" style="margin-bottom: 0; flex: 1; height: 100%; display: flex; align-items: center;">
                            <div class="filter-label-left" style="display: flex; align-items: center; height: 100%;">
                                <input type="checkbox" name="pet_type[]" value="{{ $pt->animal_type }}"
                                    {{ in_array($pt->animal_type, request()->input('pet_type', [])) ? 'checked' : '' }}
                                    onchange="document.getElementById('filterForm').submit()" style="margin: 0;">
                                <span style="line-height: 1;">{{ ucfirst($pt->animal_type) }}</span>
                            </div>
                            <span class="filter-count" style="line-height: 1;">({{ $pt->count }})</span>
                        </label>
                        @if(isset($lifeStageMap[$ptKey]))
                        <button type="button" class="btn-toggle-sub {{ $hasSubFiltersChecked ? 'expanded' : '' }}" onclick="toggleSubgroup('sub_{{ $ptKey }}', this)" aria-label="Toggle subfilters" style="margin: 0; margin-left: 8px;">
                            <svg class="toggle-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                        </button>
                        @endif
                    </div>
                    @if(isset($lifeStageMap[$ptKey]))
                    <div id="sub_{{ $ptKey }}" style="margin-left: 26px; margin-bottom: 6px; display: {{ $hasSubFiltersChecked ? 'flex' : 'none' }}; flex-direction: column; gap: 6px;">
                        @foreach($lifeStageMap[$ptKey] as $stageVal => $stageLabel)
                        <label class="filter-label" style="margin-bottom: 0;">
                            <div class="filter-label-left">
                                <input type="checkbox" name="life_stage[]" value="{{ $pt->animal_type . '_' . $stageVal }}"
                                    {{ in_array($pt->animal_type . '_' . $stageVal, request()->input('life_stage', [])) ? 'checked' : '' }}
                                    onchange="document.getElementById('filterForm').submit()">
                                <span style="font-size: 13px;">{{ $stageLabel }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @endif
                @endforeach
            </div>

            {{-- Category --}}
            <div class="sidebar-section">
                <div class="sidebar-section-header">
                    <h3>Category</h3>
                    <span>∨</span>
                </div>
                @foreach($categories as $cat)
                    @php 
                        $hasFoodSubFiltersChecked = stripos($cat->category_name, 'food') !== false && !empty(request()->input('food_type', []));
                    @endphp
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px; height: 28px; min-height: 28px;">
                        <label class="filter-label" style="margin-bottom: 0; flex: 1; height: 100%; display: flex; align-items: center;">
                            <div class="filter-label-left" style="display: flex; align-items: center; height: 100%;">
                                <input type="checkbox" name="category[]" value="{{ $cat->id }}"
                                    {{ in_array($cat->id, request()->input('category', [])) ? 'checked' : '' }}
                                    onchange="document.getElementById('filterForm').submit()" style="margin: 0;">
                                <span style="line-height: 1;">{{ $cat->category_name }}</span>
                            </div>
                            <span class="filter-count" style="line-height: 1;">({{ $cat->products_count ?? 0 }})</span>
                        </label>
                        @if(stripos($cat->category_name, 'food') !== false)
                        <button type="button" class="btn-toggle-sub {{ $hasFoodSubFiltersChecked ? 'expanded' : '' }}" onclick="toggleSubgroup('sub_cat_{{ $cat->id }}', this)" aria-label="Toggle subfilters" style="margin: 0; margin-left: 8px;">
                            <svg class="toggle-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                        </button>
                        @endif
                    </div>
                    @if(stripos($cat->category_name, 'food') !== false)
                    <div id="sub_cat_{{ $cat->id }}" style="margin-left: 26px; margin-bottom: 6px; display: {{ $hasFoodSubFiltersChecked ? 'flex' : 'none' }}; flex-direction: column; gap: 6px;">
                        <label class="filter-label" style="margin-bottom: 0;">
                            <div class="filter-label-left">
                                <input type="checkbox" name="food_type[]" value="wet"
                                    {{ in_array('wet', request()->input('food_type', [])) ? 'checked' : '' }}
                                    onchange="document.getElementById('filterForm').submit()">
                                <span style="font-size: 13px;">Wet Food</span>
                            </div>
                        </label>
                        <label class="filter-label" style="margin-bottom: 0;">
                            <div class="filter-label-left">
                                <input type="checkbox" name="food_type[]" value="dry"
                                    {{ in_array('dry', request()->input('food_type', [])) ? 'checked' : '' }}
                                    onchange="document.getElementById('filterForm').submit()">
                                <span style="font-size: 13px;">Dry Food</span>
                            </div>
                        </label>
                    </div>
                    @endif
                @endforeach
            </div>

            {{-- Brand --}}
            <div class="sidebar-section">
                <div class="sidebar-section-header">
                    <h3>Brand</h3>
                    <span>∨</span>
                </div>
                @foreach($brands as $brand)
                    <label class="filter-label">
                        <div class="filter-label-left">
                            <input type="checkbox" name="brand[]" value="{{ $brand->name }}"
                                {{ in_array($brand->name, (array)request()->input('brand', [])) ? 'checked' : '' }}
                                onchange="document.getElementById('filterForm').submit()">
                            <span>{{ $brand->name }}</span>
                        </div>
                        <span class="filter-count">({{ $brand->products_count ?? 0 }})</span>
                    </label>
                @endforeach
            </div>

            {{-- Price Range --}}
            <div class="sidebar-section">
                <div class="sidebar-section-header">
                    <h3>Price Range</h3>
                    <span>∨</span>
                </div>
                <input type="range" class="price-slider" name="price_max"
                    min="0" max="5000" step="50"
                    value="{{ request()->input('price_max', 5000) }}"
                    id="priceSlider" oninput="updatePriceLabel(this.value)">
                <div class="price-range-labels">
                    <span>₱0</span>
                    <span>₱<span id="priceMaxLabel">{{ request()->input('price_max', 5000) }}</span></span>
                </div>
                <button type="button" class="btn-apply" onclick="document.getElementById('filterForm').submit()">Apply</button>
            </div>

            {{-- Ratings --}}
            <div class="sidebar-section">
                <div class="sidebar-section-header">
                    <h3>Ratings</h3>
                    <span>∨</span>
                </div>
                @foreach([5 => '5 stars & up', 4 => '4 stars & up', 3 => '3 stars & up'] as $r => $lbl)
                    <label class="rating-label">
                        <input type="radio" name="rating" value="{{ $r }}"
                            {{ request()->input('rating') == $r ? 'checked' : '' }}>
                        <span class="stars">{{ str_repeat('★', $r) }}{{ str_repeat('☆', 5-$r) }}</span>
                        <span>{{ $lbl }}</span>
                    </label>
                @endforeach
            </div>

            {{-- Availability --}}
            <div class="sidebar-section">
                <div class="sidebar-section-header">
                    <h3>Availability</h3>
                    <span>∨</span>
                </div>
                <div class="availability-row">
                    <label>In Stock Only</label>
                    <label class="toggle-switch">
                        <input type="checkbox" name="in_stock" value="1"
                            {{ request()->input('in_stock') ? 'checked' : '' }}
                            onchange="document.getElementById('filterForm').submit()">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <label class="filter-label-on-sale">
                    <input type="checkbox" name="on_sale" value="1"
                        {{ request()->input('on_sale') ? 'checked' : '' }}>
                    <span>On Sale</span>
                </label>
            </div>

            <a href="{{ route('shop.all') }}" class="btn-clear-filters">Clear All Filters</a>
        </form>
    </aside>

    {{-- ══════════════════ MAIN ══════════════════ --}}
    <main class="shop-main">
        {{-- Toolbar --}}
        <div class="shop-toolbar">
            <button type="button" class="mobile-filter-btn" onclick="toggleSidebar()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                Filters
            </button>
            <div class="shop-count">
                Showing <strong>1–{{ min(24, $products->count()) }}</strong>
                of <strong>{{ $products->total() ?? $products->count() }}</strong> products
            </div>
            <div class="toolbar-right">
                <span class="sort-label">Sort by:</span>
                <select class="sort-select" name="sort" onchange="applySort(this.value)">
                    <option value="featured"   {{ request('sort','featured')=='featured'   ? 'selected':'' }}>Featured</option>
                    <option value="price_low"  {{ request('sort')=='price_low'  ? 'selected':'' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort')=='price_high' ? 'selected':'' }}>Price: High to Low</option>
                    <option value="newest"     {{ request('sort')=='newest'     ? 'selected':'' }}>Newest</option>
                </select>
            </div>
        </div>

        {{-- Products Grid --}}
        <div class="products-grid">
            @forelse($products as $product)
                <div class="product-card">
                    <div class="product-img-wrap">
                        <img
                            src="{{ $product->image_url }}"
                            alt="{{ $product->product_name }}"
                            onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22280%22 height=%22220%22%3E%3Crect fill=%22%23f5f5f5%22 width=%22280%22 height=%22220%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-family=%22Arial%22 font-size=%2215%22 fill=%22%23bbb%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E'"
                            onclick="window.openProductModal({{ $product->id }}, event)" style="cursor:pointer;">
                        @if($product->is_featured)
                            <span class="product-badge badge-new">FEATURED</span>
                        @endif
                    </div>

                    <div class="product-body">
                        <div style="font-size: 11px; color: #888; text-transform: uppercase; font-weight: 700; margin-bottom: 2px;">{{ $product->brand_name }}</div>
                        <h3 class="product-name" style="min-height: auto; margin-bottom: 4px; cursor:pointer; transition:color 0.2s;" onmouseover="this.style.color='#3b7c42'" onmouseout="this.style.color='inherit'" onclick="window.openProductModal({{ $product->id }}, event)">{{ $product->product_name }}</h3>

                        <div class="product-rating">
                            <span class="stars">★★★★★</span>
                            <span class="count">(0)</span>
                        </div>

                        <div class="product-price-row">
                            <span class="product-price">₱{{ number_format((float)$product->price, 0) }}</span>
                        </div>

                        <div class="product-stock">
                            @if($product->stock > 4)
                                <span class="stock-in">✓ In Stock ({{ $product->stock }} left)</span>
                            @elseif($product->stock > 0)
                                <span class="stock-low">🔥 Only {{ $product->stock }} left!</span>
                            @else
                                <span class="stock-out">✗ Out of Stock</span>
                            @endif
                        </div>

                        @auth
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button
                                    type="submit"
                                    class="btn-add-to-cart"
                                    {{ $product->stock > 0 ? '' : 'disabled' }}>
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn-add-to-cart" style="display: block; text-align: center; text-decoration: none; box-sizing: border-box;">Add to Cart</a>
                        @endauth
                    </div>
                </div>
            @empty
                <div class="no-products">
                    <p>No products found. Try adjusting your filters.</p>
                </div>
            @endforelse
        </div>

        @if(method_exists($products, 'hasPages') && $products->hasPages())
            <div class="pagination-wrap">{{ $products->links() }}</div>
        @endif
    </main>
</div>

@push('scripts')
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('shopSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('active');
        
        if (sidebar.classList.contains('active')) {
            overlay.style.display = 'block';
            setTimeout(() => overlay.classList.add('active'), 10);
            document.body.style.overflow = 'hidden';
        } else {
            overlay.classList.remove('active');
            setTimeout(() => overlay.style.display = 'none', 300);
            document.body.style.overflow = '';
        }
    }

    function applySort(val) {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', val);
        window.location.href = url.toString();
    }
    function updatePriceLabel(val) {
        document.getElementById('priceMaxLabel').textContent = val;
    }
    function toggleSubgroup(id, btn) {
        var el = document.getElementById(id);
        if (el.style.display === 'none') {
            el.style.display = 'flex';
            btn.classList.add('expanded');
        } else {
            el.style.display = 'none';
            btn.classList.remove('expanded');
        }
    }
</script>
@endpush

@endsection


