

<?php $__env->startSection('title', 'Shop - Pet Markt-PH'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* ── Two-Column Hero Section ─────────────── */
        .shop-top-section {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-bottom: 40px !important;
            background: transparent;
        }

        .shop-top-grid {
            display: grid;
            grid-template-columns: 85fr 15fr;
            gap: 20px;
        }

        .shop-top-col {
            background: #fff;
            border-radius: 14px;
            padding: 18px 20px;
            border: 1px solid #eee;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Featured products header */
        .shop-top-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            flex-shrink: 0;
        }

        .shop-top-heading h2 {
            font-size: 17px;
            font-weight: 800;
            color: #1f2937;
            margin: 0;
        }

        .shop-top-heading a {
            font-size: 13px;
            font-weight: 600;
            color: var(--ud-orange);
            text-decoration: none;
            transition: color .2s;
        }

        .shop-top-heading a:hover {
            color: #e07830;
            text-decoration: underline;
        }

        /* ── Featured Products Carousel ── */
        .featured-carousel-wrap {
            flex: 1;
            overflow: hidden;
            position: relative;
            min-height: 0;
        }

        .featured-carousel {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            gap: 14px;
            height: 100%;
            scrollbar-width: none;
            padding-bottom: 4px;
        }

        .featured-carousel::-webkit-scrollbar {
            display: none;
        }

        .featured-slide {
            flex: 0 0 calc(33.333% - 10px);
            scroll-snap-align: start;
            display: flex;
            flex-direction: column;
            background: #fff;
            border: 1px solid #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
        }

        .featured-slide:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(0, 0, 0, .08);
        }

        .featured-slide-img {
            width: 100%;
            height: 130px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #f6f5f2;
            flex-shrink: 0;
        }

        .featured-slide-img img {
            max-width: 88%;
            max-height: 88%;
            object-fit: contain;
        }

        .featured-slide-body {
            padding: 8px 10px 10px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .featured-slide-name {
            font-size: 12px;
            font-weight: 600;
            color: #222;
            margin: 0 0 3px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.3;
        }

        .featured-slide-price {
            font-size: 14px;
            font-weight: 800;
            color: var(--ud-orange);
            margin: 0 0 6px;
        }

        .featured-slide-cart {
            width: 100%;
            padding: 5px;
            background: var(--ud-orange);
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity .2s;
            margin-top: auto;
        }

        .featured-slide-cart:hover {
            opacity: .88;
        }

        /* Carousel dots */
        .shop-carousel-dots {
            display: flex;
            gap: 5px;
            justify-content: center;
            margin-top: 8px;
            flex-shrink: 0;
        }

        .shop-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #ddd;
            transition: all .2s;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        .shop-dot.active {
            width: 20px;
            border-radius: 4px;
            background: var(--ud-orange);
        }

        /* ── Brands column ── */
        .brand-list-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
            flex: 1;
            overflow-y: auto;
            align-content: start;
            scrollbar-width: thin;
        }

        .brand-card-mini {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border: 1px solid #f0f0f0;
            border-radius: 10px;
            text-decoration: none;
            color: #333;
            transition: all .2s;
            cursor: pointer;
        }

        .brand-card-mini:hover {
            border-color: var(--ud-orange);
            background: #FFF7ED;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, .06);
        }

        .brand-card-logo {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .brand-card-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-card-logo span {
            font-size: 18px;
            font-weight: 700;
            color: #999;
        }

        .brand-card-name {
            font-size: 14px;
            font-weight: 700;
            color: #333;
        }

        /* Responsive: stack on mobile */
        @media (max-width: 850px) {
            .shop-top-grid {
                grid-template-columns: 1fr;
                max-height: none;
            }

            .featured-slide {
                flex: 0 0 calc(50% - 7px);
            }
        }

        @media (max-width: 480px) {
            .featured-slide {
                flex: 0 0 calc(50% - 7px);
            }

            .featured-slide-img {
                height: 100px;
            }

            .brand-list-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ── GLOBAL Product Image Fix ────────────── */
        .product-image-wrapper {
            width: 100%;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .product-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* ── Layout ───────────────────────────────── */
        .shop-layout {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            display: flex;
            gap: 28px;
        }

        /* ── Sidebar ──────────────────────────────── */
        .shop-sidebar {
            width: 220px;
            flex-shrink: 0;
        }

        .sidebar-section {
            margin-bottom: 14px;
        }

        .sidebar-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            padding-bottom: 6px;
            border-bottom: 1px solid #eee;
            margin-bottom: 8px;
        }

        .sidebar-section-header h3 {
            font-size: 13px;
            font-weight: 700;
            color: #222;
            margin: 0;
        }

        .sidebar-section-header span {
            font-size: 16px;
            color: #999;
        }

        .filter-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 4px;
            cursor: pointer;
            gap: 6px;
        }

        .filter-label-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-label input[type="checkbox"] {
            width: 14px;
            height: 14px;
            cursor: pointer;
            accent-color: var(--ud-orange);
            margin: 0;
        }

        .filter-label span {
            font-size: 12px;
            color: #444;
        }

        .filter-count {
            font-size: 10px;
            color: #aaa;
        }

        /* Price Range */
        .price-slider {
            width: 100%;
            accent-color: var(--ud-orange);
            cursor: pointer;
        }

        .price-range-labels {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #666;
            margin: 4px 0 8px;
        }

        .btn-apply {
            width: 100%;
            padding: 6px;
            background: var(--ud-orange);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity .2s;
        }

        .btn-apply:hover {
            opacity: .88;
        }

        /* Ratings stars */
        .rating-label {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 4px;
            cursor: pointer;
        }

        .rating-label input[type="radio"] {
            accent-color: var(--ud-orange);
            width: 14px;
            height: 14px;
            margin: 0;
        }

        .stars {
            color: #ffa500;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .rating-label span {
            font-size: 11px;
            color: #555;
        }

        /* Availability toggle */
        .availability-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .availability-row label {
            font-size: 13px;
            color: #444;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 22px;
        }

        .toggle-switch input {
            display: none;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background: #ccc;
            border-radius: 34px;
            transition: .3s;
        }

        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            left: 3px;
            bottom: 3px;
            background: white;
            border-radius: 50%;
            transition: .3s;
        }

        .toggle-switch input:checked+.toggle-slider {
            background: var(--ud-orange);
        }

        .toggle-switch input:checked+.toggle-slider::before {
            transform: translateX(18px);
        }

        .filter-label-on-sale {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
            cursor: pointer;
        }

        .filter-label-on-sale input {
            accent-color: var(--ud-orange);
            width: 16px;
            height: 16px;
        }

        .filter-label-on-sale span {
            font-size: 13px;
            color: #444;
        }

        .btn-clear-filters {
            width: 100%;
            padding: 10px;
            background: white;
            color: var(--ud-orange);
            border: 1.5px solid var(--ud-orange);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 10px;
            transition: all .2s;
        }

        .btn-clear-filters:hover {
            background: #fff5ef;
        }

        /* Dropdown Toggle Button */
        .btn-toggle-sub {
            background: none;
            border: none;
            cursor: pointer;
            color: #888;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s, color 0.2s;
            border-radius: 4px;
            margin-left: 8px;
            height: 20px;
            max-height: 20px;
            line-height: 1;
            outline: none;
        }

        .btn-toggle-sub:hover {
            color: var(--ud-orange);
            background: #FFF7ED;
        }

        .btn-toggle-sub.expanded {
            transform: rotate(180deg);
            color: var(--ud-orange);
        }

        /* ── Main area ───────────────────────────── */
        .shop-main {
            flex: 1;
            min-width: 0;
        }

        /* Toolbar */
        .shop-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .shop-count {
            font-size: 13.5px;
            color: #666;
        }

        .shop-count strong {
            color: #333;
        }

        .toolbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .view-btn {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
        }

        .view-btn.active {
            background: var(--ud-orange);
            color: white;
        }

        .view-btn:not(.active) {
            background: #f0f0f0;
            color: #555;
        }

        .sort-select {
            padding: 7px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 13px;
            background: white;
            cursor: pointer;
        }

        .sort-label {
            font-size: 13px;
            color: #666;
        }

        /* Product grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
            margin-bottom: 30px;
            }

            /* Product card */
            .product-card {
                background: white; border-radius: 8px;
                overflow: hidden; box-shadow: 0 1px 8px rgba(0,0,0,.06);
                transition: transform .25s, box-shadow .25s;
                display: flex;
                flex-direction: column;
                height: 100%;
            }
            .product-card:hover { transform: translateY(-3px); box-shadow: 0 6px 18px rgba(0,0,0,.1); }

            .product-img-wrap {
                position: relative; height: 140px;
                background: #f9f9f9; overflow: hidden;
                display: flex; align-items: center; justify-content: center;
            }
            .product-img-wrap img {
                width: 100%; height: 100%; object-fit: contain;
                transition: transform .35s;
            }
            .product-card:hover .product-img-wrap img { transform: scale(1.04); }
            .product-badge {
                position: absolute; top: 8px; right: 8px;
                padding: 2px 7px; border-radius: 4px;
                font-size: 9px; font-weight: 700; letter-spacing: .4px;
            }
            .badge-sale { background: var(--ud-orange); color: white; }
            .badge-new  { background: #222; color: white; }

            .product-body { padding: 8px 10px 10px; display: flex; flex-direction: column; flex: 1; }
            .product-rating { display: flex; align-items: center; gap: 4px; margin-bottom: 6px; margin-top: auto; }
            .product-rating .stars { font-size: 11px; }
            .product-rating .count { font-size: 10px; color: #aaa; }
            .product-name {
                font-size: 11.5px; font-weight: 600; color: #222;
                margin: 0 0 4px; line-height: 1.3;
                display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
                min-height: calc(1.3em * 2);
            }

            .product-price {
                font-size: 14px; font-weight: 800; color: var(--ud-orange);
            }
            .product-original { font-size: 11px; color: #bbb; text-decoration: line-through; }
            .product-stock {
                font-size: 12px; margin-bottom: 12px;
                display: flex; align-items: center; gap: 4px;
            }
            .stock-in  { color: #3DB868; }
            .stock-low { color: var(--ud-orange); }
            .stock-out { color: #e44; }
            .btn-add-to-cart {
                width: 100%; padding: 7px;
                background: var(--ud-orange); color: white;
                border: none; border-radius: 6px;
                font-size: 12px; font-weight: 700;
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
                .shop-top-section { padding: 12px; }

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
                    height: 160px;
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
                .product-img-wrap { height: 140px; }
                .product-body { padding: 6px 8px 8px; }
                .product-price { font-size: 14px; }
                .btn-add-to-cart { padding: 6px; font-size: 11px; }
                .shop-sidebar .sidebar-section { min-width: 100%; }
            }
        </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    
    <div class="shop-top-section">
        <div class="shop-top-grid">

            
            <div class="shop-top-col hero-banner-col" style="padding: 0; border: none; background: transparent;">
                <style>
                    .hero-banner {
                        width: 100%;
                        height: 100%;
                        min-height: 180px;
                        display: flex;
                        align-items: center;
                        border-radius: 12px;
                        overflow: hidden;
                        position: relative;
                    }
                    .hero-slide {
                        width: 100%;
                        height: 100%;
                        display: grid;
                        grid-template-columns: 55% 45%;
                        align-items: center;
                        padding: 16px 22px;
                        position: absolute;
                        top: 0; left: 0;
                        opacity: 0;
                        pointer-events: none;
                        transform: translateX(100%);
                        transition: transform 0.6s ease-in-out, opacity 0.6s ease-in-out;
                    }
                    .hero-slide.active { opacity: 1; pointer-events: auto; transform: translateX(0); z-index: 5; }
                    .hero-slide.exit { opacity: 0; transform: translateX(-100%); z-index: 1; }
                    .hero-left { display: flex; flex-direction: column; gap: 12px; z-index: 2; }
                    .hero-badge {
                        display: inline-flex; align-items: center; gap: 6px;
                        background: rgba(255,255,255,0.2); color: #ffffff;
                        font-size: 0.72rem; font-weight: 600; padding: 3px 10px;
                        border-radius: 50px; width: fit-content;
                    }
                    .hero-product-name {
                        font-size: 1.15rem; font-weight: 700; color: #ffffff;
                        line-height: 1.2; max-width: 400px; margin: 0;
                        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;
                    }
                    .hero-description {
                        font-size: 0.8rem; color: rgba(255,255,255,0.85);
                        max-width: 380px; line-height: 1.5; margin: 0;
                        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
                    }
                    .hero-price { display: flex; align-items: center; gap: 10px; }
                    .hero-price-current { font-size: 1.1rem; font-weight: 700; color: #ffffff; }
                    .hero-price-original { font-size: 1rem; color: rgba(255,255,255,0.6); text-decoration: line-through; }
                    .hero-cta {
                        display: inline-flex; align-items: center; justify-content: center;
                        gap: 8px; background: #ffffff; color: #F97316; font-weight: 600;
                        padding: 6px 16px; border-radius: 50px; font-size: 0.78rem;
                        width: fit-content; cursor: pointer; border: none; transition: all 0.2s;
                        text-decoration: none;
                    }
                    .hero-cta:hover { background: #FFF7ED; transform: scale(1.03); }
                    .hero-cta:disabled {
                        background: rgba(255,255,255,0.4); color: rgba(255,255,255,0.7);
                        cursor: not-allowed; transform: none;
                    }
                    .hero-right {
                        display: flex; align-items: center; justify-content: center;
                        position: relative; z-index: 2; height: 100%;
                    }
                    .hero-right img {
                        max-height: 150px; max-width: 100%; width: auto; height: auto;
                        object-fit: contain; filter: drop-shadow(0 8px 24px rgba(0,0,0,0.2));
                        mix-blend-mode: multiply; transform: translateX(30px);
                    }
                    .hero-circle {
                        position: absolute; width: 280px; height: 280px;
                        border-radius: 50%; 
                        background: radial-gradient(circle, rgba(255,255,255,0.6) 0%, rgba(255,255,255,0) 70%);
                        left: 75%; top: 50%; transform: translate(calc(-50% + 30px), -50%); z-index: 1;
                    }
                    .hero-dots {
                        position: absolute; bottom: 20px; left: 0; width: 100%;
                        display: flex; justify-content: center; gap: 6px; z-index: 10;
                    }
                    .hero-dot {
                        width: 6px !important; height: 6px !important; 
                        min-width: 0 !important; min-height: 0 !important;
                        border-radius: 50% !important; background: rgba(255,255,255,0.4) !important; 
                        cursor: pointer; transition: all 0.2s; padding: 0 !important; border: none !important;
                        display: block !important;
                    }
                    .hero-dot.active { background: #ffffff !important; width: 20px !important; border-radius: 4px !important; }

                    /* Toast Notification */
                    #toast-container {
                        position: fixed; bottom: 20px; right: 20px; z-index: 9999;
                        display: flex; flex-direction: column; gap: 10px;
                    }
                    .toast {
                        background: var(--ud-orange); color: white; padding: 12px 24px;
                        border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                        font-weight: 600; font-size: 14px; opacity: 0; transform: translateY(20px);
                        transition: opacity 0.3s, transform 0.3s;
                    }
                    .toast.show { opacity: 1; transform: translateY(0); }

                    @media (max-width: 768px) {
                        .hero-slide { grid-template-columns: 1fr; padding: 24px; text-align: center; align-items: center; }
                        .hero-product-name { font-size: 1.4rem; margin: 0 auto; }
                        .hero-description { margin: 0 auto; }
                        .hero-price { justify-content: center; }
                        .hero-badge { margin: 0 auto; }
                        .hero-right img { max-height: 200px; margin-top: 16px; transform: translateX(0px); }
                        .hero-cta { width: 100%; justify-content: center; margin: 0 auto; }
                        .hero-circle { left: 50%; transform: translate(-50%, -50%); width: 220px; height: 220px; }
                    }
                </style>

                <div id="toast-container"></div>

                <?php
                    $bgColors = [
                        'Food & Nutrition' => 'linear-gradient(135deg, #fb923c, #f97316)', // warm orange
                        'Toys & Enrichment' => 'linear-gradient(135deg, #60a5fa, #3b82f6)', // playful blue
                        'Habitats & Housing' => 'linear-gradient(135deg, #4ade80, #22c55e)', // soft green
                        'Health & Care' => 'linear-gradient(135deg, #2dd4bf, #14b8a6)', // clean teal
                        'Grooming & Hygiene' => 'linear-gradient(135deg, #c084fc, #a855f7)', // purple
                        'Travel & Safety' => 'linear-gradient(135deg, #f87171, #ef4444)', // rose
                        'Aquatic Supplies' => 'linear-gradient(135deg, #38bdf8, #0ea5e9)', // cyan
                        'Reptile & Exotic Care' => 'linear-gradient(135deg, #a3e635, #84cc16)', // lime
                        'Invertebrate Care' => 'linear-gradient(135deg, #9ca3af, #6b7280)', // cool gray
                        'Training & Behavior' => 'linear-gradient(135deg, #facc15, #eab308)' // yellow

                    ];
                    $defaultBg = 'linear-gradient(135deg, #10b981, #059669)';
                ?>

                <div class="hero-banner" id="splitHeroBanner">
                    <div class="hero-circle"></div>

                    <?php $__currentLoopData = $featuredProducts->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $fp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $catName = $fp->category ? $fp->category->category_name : '';
                            $bg = isset($bgColors[$catName]) ? $bgColors[$catName] : $defaultBg;

                            $salePrice = $fp->price;
                            if ($fp->discount_type === 'percent' && $fp->discount_amount > 0) {
                                $salePrice = $fp->price * (1 - ($fp->discount_amount / 100));
                            } elseif ($fp->discount_type === 'fixed' && $fp->discount_amount > 0) {
                                $salePrice = max(0, $fp->price - $fp->discount_amount);
                            }
                            $isOnSale = $salePrice < $fp->price;

                            $badgeText = "⭐ Featured";
                            if ($isOnSale)
                                $badgeText = "🏷️ Sale";
                            elseif ($fp->is_featured && $fp->stock > 0)
                                $badgeText = "🔥 Best Seller";
                        ?>
                        <div class="hero-slide <?php echo e($index === 0 ? 'active' : ''); ?>" data-bg="<?php echo e($bg); ?>" style="<?php echo e($index === 0 ? 'background: ' . $bg . '; opacity: 1;' : ''); ?>">
                            <div class="hero-left">
                                <span class="hero-badge"><?php echo e($badgeText); ?></span>
                                <h2 class="hero-product-name"><?php echo e($fp->product_name); ?></h2>
                                <p class="hero-description"><?php echo e($fp->short_description ?: 'High quality pet product for your awesome companion.'); ?></p>

                                <div class="hero-price">
                                    <span class="hero-price-current">₱<?php echo e(number_format((float) $salePrice, 2)); ?></span>
                                    <?php if($isOnSale): ?>
                                        <span class="hero-price-original">₱<?php echo e(number_format((float) $fp->price, 2)); ?></span>
                                    <?php endif; ?>
                                </div>

                                <?php if(auth()->guard()->check()): ?>
                                    <form action="<?php echo e(route('cart.add')); ?>" method="POST" onclick="event.stopPropagation();" class="hero-cart-form">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="product_id" value="<?php echo e($fp->id); ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="hero-cta" <?php echo e($fp->stock > 0 ? '' : 'disabled'); ?>>
                                            <?php echo e($fp->stock > 0 ? 'Add to Cart Now! →' : 'Out of Stock'); ?>

                                        </button>
                                    </form>
                                <?php else: ?>
                                    <a href="<?php echo e(route('login')); ?>" class="hero-cta" onclick="event.stopPropagation();">
                                        <?php echo e($fp->stock > 0 ? 'Add to Cart Now! →' : 'Out of Stock'); ?>

                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="hero-right" onclick="window.openProductModal(<?php echo e($fp->id); ?>, event); cursor:pointer;">
                                <img src="<?php echo e($fp->image_url); ?>" alt="<?php echo e($fp->product_name); ?>">
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="hero-dots">
                        <?php $__currentLoopData = $featuredProducts->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $fp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button class="hero-dot <?php echo e($index === 0 ? 'active' : ''); ?>" data-index="<?php echo e($index); ?>"></button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            
            <div class="shop-top-col">
                <div class="shop-top-heading">
                    <h2>🏷️ Shop by Brand</h2>
                </div>
                <div class="brand-list-grid">
                    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('shop.all', ['brand[]' => $brand->name])); ?>" class="brand-card-mini">
                            <div class="brand-card-logo">
                                <?php if(!empty($brand->logo_path)): ?>
                                    <img src="<?php echo e($brand->logo_full_url); ?>" alt="<?php echo e($brand->name); ?>">
                                <?php else: ?>
                                    <span><?php echo e(strtoupper(substr($brand->name, 0, 1))); ?></span>
                                <?php endif; ?>
                            </div>
                            <span class="brand-card-name"><?php echo e($brand->name); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

        </div>
    </div>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="shop-layout">
        
        <aside class="shop-sidebar" id="shopSidebar">
            <button type="button" class="sidebar-close-btn" onclick="toggleSidebar()" aria-label="Close filters">✕</button>
            <div class="mobile-filter-header">Filters</div>
            <form method="GET" action="<?php echo e(route('shop.all')); ?>" id="filterForm">

                
                <div class="sidebar-section">
                    <div class="sidebar-section-header">
                        <h3>Pet Type</h3>
                        <span>∨</span>
                    </div>
                    <?php
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
                    ?>
                    <?php $__currentLoopData = $petTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php 
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
                        ?>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px; height: 28px; min-height: 28px;">
                            <label class="filter-label" style="margin-bottom: 0; flex: 1; height: 100%; display: flex; align-items: center;">
                                <div class="filter-label-left" style="display: flex; align-items: center; height: 100%;">
                                    <input type="checkbox" name="pet_type[]" value="<?php echo e($pt->animal_type); ?>"
                                        <?php echo e(in_array($pt->animal_type, request()->input('pet_type', [])) ? 'checked' : ''); ?>

                                        onchange="document.getElementById('filterForm').submit()" style="margin: 0;">
                                    <span style="line-height: 1;"><?php echo e(ucfirst($pt->animal_type)); ?></span>
                                </div>
                                <span class="filter-count" style="line-height: 1;">(<?php echo e($pt->count); ?>)</span>
                            </label>
                            <?php if(isset($lifeStageMap[$ptKey])): ?>
                                <button type="button" class="btn-toggle-sub <?php echo e($hasSubFiltersChecked ? 'expanded' : ''); ?>" onclick="toggleSubgroup('sub_<?php echo e($ptKey); ?>', this)" aria-label="Toggle subfilters" style="margin: 0; margin-left: 8px;">
                                    <svg class="toggle-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                </button>
                            <?php endif; ?>
                        </div>
                        <?php if(isset($lifeStageMap[$ptKey])): ?>
                            <div id="sub_<?php echo e($ptKey); ?>" style="margin-left: 26px; margin-bottom: 6px; display: <?php echo e($hasSubFiltersChecked ? 'flex' : 'none'); ?>; flex-direction: column; gap: 6px;">
                                <?php $__currentLoopData = $lifeStageMap[$ptKey]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stageVal => $stageLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="filter-label" style="margin-bottom: 0;">
                                        <div class="filter-label-left">
                                            <input type="checkbox" name="life_stage[]" value="<?php echo e($pt->animal_type . '_' . $stageVal); ?>"
                                                <?php echo e(in_array($pt->animal_type . '_' . $stageVal, request()->input('life_stage', [])) ? 'checked' : ''); ?>

                                                onchange="document.getElementById('filterForm').submit()">
                                            <span style="font-size: 13px;"><?php echo e($stageLabel); ?></span>
                                        </div>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div class="sidebar-section">
                    <div class="sidebar-section-header">
                        <h3>Category</h3>
                        <span>∨</span>
                    </div>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php 
                            $hasFoodSubFiltersChecked = stripos($cat->category_name, 'food') !== false && !empty(request()->input('food_type', []));
                        ?>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px; height: 28px; min-height: 28px;">
                            <label class="filter-label" style="margin-bottom: 0; flex: 1; height: 100%; display: flex; align-items: center;">
                                <div class="filter-label-left" style="display: flex; align-items: center; height: 100%;">
                                    <input type="checkbox" name="category[]" value="<?php echo e($cat->id); ?>"
                                        <?php echo e(in_array($cat->id, request()->input('category', [])) ? 'checked' : ''); ?>

                                        onchange="document.getElementById('filterForm').submit()" style="margin: 0;">
                                    <span style="line-height: 1;"><?php echo e($cat->category_name); ?></span>
                                </div>
                                <span class="filter-count" style="line-height: 1;">(<?php echo e($cat->products_count ?? 0); ?>)</span>
                            </label>
                            <?php if(stripos($cat->category_name, 'food') !== false): ?>
                                <button type="button" class="btn-toggle-sub <?php echo e($hasFoodSubFiltersChecked ? 'expanded' : ''); ?>" onclick="toggleSubgroup('sub_cat_<?php echo e($cat->id); ?>', this)" aria-label="Toggle subfilters" style="margin: 0; margin-left: 8px;">
                                    <svg class="toggle-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                </button>
                            <?php endif; ?>
                        </div>
                        <?php if(stripos($cat->category_name, 'food') !== false): ?>
                            <div id="sub_cat_<?php echo e($cat->id); ?>" style="margin-left: 26px; margin-bottom: 6px; display: <?php echo e($hasFoodSubFiltersChecked ? 'flex' : 'none'); ?>; flex-direction: column; gap: 6px;">
                                <label class="filter-label" style="margin-bottom: 0;">
                                    <div class="filter-label-left">
                                        <input type="checkbox" name="food_type[]" value="wet"
                                            <?php echo e(in_array('wet', request()->input('food_type', [])) ? 'checked' : ''); ?>

                                            onchange="document.getElementById('filterForm').submit()">
                                        <span style="font-size: 13px;">Wet Food</span>
                                    </div>
                                </label>
                                <label class="filter-label" style="margin-bottom: 0;">
                                    <div class="filter-label-left">
                                        <input type="checkbox" name="food_type[]" value="dry"
                                            <?php echo e(in_array('dry', request()->input('food_type', [])) ? 'checked' : ''); ?>

                                            onchange="document.getElementById('filterForm').submit()">
                                        <span style="font-size: 13px;">Dry Food</span>
                                    </div>
                                </label>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div class="sidebar-section">
                    <div class="sidebar-section-header">
                        <h3>Brand</h3>
                        <span>∨</span>
                    </div>
                    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="filter-label">
                            <div class="filter-label-left">
                                <input type="checkbox" name="brand[]" value="<?php echo e($brand->name); ?>"
                                    <?php echo e(in_array($brand->name, (array) request()->input('brand', [])) ? 'checked' : ''); ?>

                                    onchange="document.getElementById('filterForm').submit()">
                                <span><?php echo e($brand->name); ?></span>
                            </div>
                            <span class="filter-count">(<?php echo e($brand->products_count ?? 0); ?>)</span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div class="sidebar-section">
                    <div class="sidebar-section-header">
                        <h3>Price Range</h3>
                        <span>∨</span>
                    </div>
                    <input type="range" class="price-slider" name="price_max"
                        min="0" max="5000" step="50"
                        value="<?php echo e(request()->input('price_max', 5000)); ?>"
                        id="priceSlider" oninput="updatePriceLabel(this.value)">
                    <div class="price-range-labels">
                        <span>₱0</span>
                        <span>₱<span id="priceMaxLabel"><?php echo e(request()->input('price_max', 5000)); ?></span></span>
                    </div>
                    <button type="button" class="btn-apply" onclick="document.getElementById('filterForm').submit()">Apply</button>
                </div>

                
                <div class="sidebar-section">
                    <div class="sidebar-section-header">
                        <h3>Ratings</h3>
                        <span>∨</span>
                    </div>
                    <?php $__currentLoopData = [5 => '5 stars & up', 4 => '4 stars & up', 3 => '3 stars & up']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="rating-label">
                            <input type="radio" name="rating" value="<?php echo e($r); ?>"
                                <?php echo e(request()->input('rating') == $r ? 'checked' : ''); ?>>
                            <span class="stars"><?php echo e(str_repeat('★', $r)); ?><?php echo e(str_repeat('☆', 5 - $r)); ?></span>
                            <span><?php echo e($lbl); ?></span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div class="sidebar-section">
                    <div class="sidebar-section-header">
                        <h3>Availability</h3>
                        <span>∨</span>
                    </div>
                    <div class="availability-row">
                        <label>In Stock Only</label>
                        <label class="toggle-switch">
                            <input type="checkbox" name="in_stock" value="1"
                                <?php echo e(request()->input('in_stock') ? 'checked' : ''); ?>

                                onchange="document.getElementById('filterForm').submit()">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <label class="filter-label-on-sale">
                        <input type="checkbox" name="on_sale" value="1"
                            <?php echo e(request()->input('on_sale') ? 'checked' : ''); ?>>
                        <span>On Sale</span>
                    </label>
                </div>

                <a href="<?php echo e(route('shop.all')); ?>" class="btn-clear-filters">Clear All Filters</a>
            </form>
        </aside>

        
        <main class="shop-main">
            
            <div class="shop-toolbar">
                <button type="button" class="mobile-filter-btn" onclick="toggleSidebar()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                    Filters
                </button>
                <div class="shop-count">
                    Showing <strong>1–<?php echo e(min(24, $products->count())); ?></strong>
                    of <strong><?php echo e($products->total() ?? $products->count()); ?></strong> products
                </div>
                <div class="toolbar-right">
                    <span class="sort-label">Sort by:</span>
                    <select class="sort-select" name="sort" onchange="applySort(this.value)">
                        <option value="featured"   <?php echo e(request('sort', 'featured') == 'featured' ? 'selected' : ''); ?>>Featured</option>
                        <option value="price_low"  <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>Price: Low to High</option>
                        <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>Price: High to Low</option>
                        <option value="newest"     <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>Newest</option>
                    </select>
                </div>
            </div>

            
            <div class="products-grid">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="product-card">
                        <div class="product-img-wrap">
                            <img
                                src="<?php echo e($product->image_url); ?>"
                                alt="<?php echo e($product->product_name); ?>"
                                onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22280%22 height=%22220%22%3E%3Crect fill=%22%23f5f5f5%22 width=%22280%22 height=%22220%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-family=%22Arial%22 font-size=%2215%22 fill=%22%23bbb%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E'"
                                onclick="window.openProductModal(<?php echo e($product->id); ?>, event)" style="cursor:pointer;">
                            <?php if($product->is_featured): ?>
                                <span class="product-badge badge-new">FEATURED</span>
                            <?php endif; ?>
                            <?php if($product->is_sale_active): ?>
                                <span class="product-badge" style="background: #ef4444; top: auto; bottom: 10px;"><?php echo e($product->discount_type === 'percent' ? '-' . (int)$product->discount_amount . '%' : 'SALE'); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="product-body">
                            <div style="font-size: 11px; color: #888; text-transform: uppercase; font-weight: 700; margin-bottom: 2px;"><?php echo e($product->brand_name); ?></div>
                            <h3 class="product-name" style="min-height: auto; margin-bottom: 4px; cursor:pointer; transition:color 0.2s;" onmouseover="this.style.color='var(--ud-orange)'" onmouseout="this.style.color='inherit'" onclick="window.openProductModal(<?php echo e($product->id); ?>, event)"><?php echo e($product->product_name); ?></h3>

                            <?php
                                $pReviewCount = $product->reviews()->count();
                                $pReviewAvg = $product->avg_rating > 0 ? $product->avg_rating : 0;
                                $pFmt = $pReviewCount >= 1000 ? round($pReviewCount / 1000, 1) . 'k' : $pReviewCount;
                            ?>
                            <div class="product-rating">
                                <span class="stars" style="position: relative; display: inline-block; color: #d1d5db; letter-spacing: 2px;" title="<?php echo e(number_format($pReviewAvg, 1)); ?> out of 5">
                                    ★★★★★
                                    <div style="position: absolute; top:0; left:0; width: <?php echo e(($pReviewAvg / 5) * 100); ?>%; overflow: hidden; color: #f59e0b; white-space: nowrap;">★★★★★</div>
                                </span>
                                <span class="count">(<?php echo e($pFmt); ?>)</span>
                            </div>

                            <div class="product-price-row">
                                <?php if($product->is_sale_active): ?>
                                    <span class="product-price">₱<?php echo e(number_format((float) $product->sale_price, 2)); ?></span>
                                    <span class="product-original">₱<?php echo e(number_format((float) $product->price, 2)); ?></span>
                                <?php else: ?>
                                    <span class="product-price">₱<?php echo e(number_format((float) $product->price, 2)); ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="product-stock">
                                <?php if($product->stock > 4): ?>
                                    <span class="stock-in">✓ In Stock (<?php echo e($product->stock); ?> left)</span>
                                <?php elseif($product->stock > 0): ?>
                                    <span class="stock-low">🔥 Only <?php echo e($product->stock); ?> left!</span>
                                <?php else: ?>
                                    <span class="stock-out">✗ Out of Stock</span>
                                <?php endif; ?>
                            </div>

                            <?php if(auth()->guard()->check()): ?>
                                <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button
                                        type="submit"
                                        class="btn-add-to-cart"
                                        <?php echo e($product->stock > 0 ? '' : 'disabled'); ?>>
                                        Add to Cart
                                    </button>
                                </form>
                            <?php else: ?>
                                <a href="<?php echo e(route('login')); ?>" class="btn-add-to-cart" style="display: block; text-align: center; text-decoration: none; box-sizing: border-box;">Add to Cart</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="no-products">
                        <p>No products found. Try adjusting your filters.</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if(method_exists($products, 'hasPages') && $products->hasPages()): ?>
                <div class="pagination-wrap"><?php echo e($products->links()); ?></div>
            <?php endif; ?>
        </main>
    </div>

    <?php $__env->startPush('scripts'); ?>
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

            // ── Split Hero Banner & AJAX Add To Cart ──
            document.addEventListener('DOMContentLoaded', () => {
                const banner = document.getElementById('splitHeroBanner');
                if (!banner) return;

                const slides = banner.querySelectorAll('.hero-slide');
                const dots = banner.querySelectorAll('.hero-dot');
                let currentIndex = 0;
                let slideInterval;

                // Initialize background to first slide
                if(slides.length > 0 && slides[0].dataset.bg) {
                    banner.style.background = slides[0].dataset.bg;
                }

                function showSlide(index) {
                    slides.forEach((slide, i) => {
                        slide.classList.remove('active', 'exit');
                        if (i === index) {
                            slide.classList.add('active');
                            // Update banner wrapper background
                            if (slide.dataset.bg) {
                                banner.style.background = slide.dataset.bg;
                            }
                        } else if (i === currentIndex) {
                            // The one leaving becomes exit
                            slide.classList.add('exit');
                        }
                    });
                    dots.forEach((dot, i) => {
                        dot.classList.toggle('active', i === index);
                    });
                    currentIndex = index;
                }

                function nextSlide() {
                    let next = (currentIndex + 1) % slides.length;
                    showSlide(next);
                }

                function startSlide() {
                    slideInterval = setInterval(nextSlide, 4500); // Auto-rotate every 4.5s
                }

                function pauseSlide() {
                    clearInterval(slideInterval);
                }

                dots.forEach((dot, i) => {
                    dot.addEventListener('click', () => {
                        showSlide(i);
                        pauseSlide();
                        startSlide();
                    });
                });

                banner.addEventListener('mouseenter', pauseSlide);
                banner.addEventListener('mouseleave', startSlide);

                startSlide();

                // AJAX Add to Cart for Hero Banner
                const toastContainer = document.getElementById('toast-container');
                window.showToast = function(message) {
                    const toast = document.createElement('div');
                    toast.className = 'toast';
                    toast.textContent = message;
                    toastContainer.appendChild(toast);

                    // Trigger animation
                    setTimeout(() => toast.classList.add('show'), 10);

                    // Remove after 3s
                    setTimeout(() => {
                        toast.classList.remove('show');
                        setTimeout(() => toast.remove(), 300);
                    }, 3000);
                };

                const cartForms = banner.querySelectorAll('.hero-cart-form');
                cartForms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const btn = this.querySelector('button');
                        const prevText = btn.innerHTML;
                        btn.innerHTML = 'Adding...';
                        btn.disabled = true;

                        // Pause rotation while interacting
                        pauseSlide();

                        fetch(this.action, {
                            method: 'POST',
                            body: new FormData(this),
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            if(response.ok) {
                                window.showToast("Added to cart! ✓");
                                // Wait a moment then restart slide
                                setTimeout(startSlide, 2000);
                            } else if(response.status === 401) {
                                window.location.href = "<?php echo e(route('login')); ?>";
                            }
                        })
                        .catch(error => console.error('Error adding to cart:', error))
                        .finally(() => {
                            btn.innerHTML = prevText;
                            btn.disabled = false;
                        });
                    });
                });
            });
        </script>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Pet Markt-PH\resources\views/frontend/shop.blade.php ENDPATH**/ ?>