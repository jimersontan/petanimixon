<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products - Pet Animixon</title>
    <link rel="stylesheet" href="{{ asset('css/shop_shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop_products.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
@auth
@include('partials.shop_nav')

<div class="sp-wrap">
    <div class="sp-container">
        <div class="sh-breadcrumb">
            <a href="{{ route('home') }}">Home</a> <span>›</span> <span>Shop</span>
        </div>

        <div class="sp-layout">
            <!-- Sidebar Filters -->
            <aside class="sp-sidebar">
                <!-- Pet Type -->
                <div class="sp-filter-group">
                    <div class="sp-filter-title" onclick="this.parentElement.classList.toggle('open')">
                        Pet Type <span class="sp-chevron">▾</span>
                    </div>
                    <div class="sp-filter-body">
                        @php
                        $petTypes = [['Dogs',623],['Cats',580],['Birds',341],['Fish',423],['Small Mammals',188],['Reptiles',177]];
                        @endphp
                        @foreach($petTypes as [$label,$count])
                        <label class="sp-check-label">
                            <input type="checkbox"> <span>{{ $label }}</span> <span class="sp-count">({{ $count }})</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Category -->
                <div class="sp-filter-group open">
                    <div class="sp-filter-title" onclick="this.parentElement.classList.toggle('open')">
                        Category <span class="sp-chevron">▾</span>
                    </div>
                    <div class="sp-filter-body">
                        @php
                        $cats = ['Food & Nutrition','Habitats & Housing','Health & Care','Toys & Enrichment','Grooming'];
                        @endphp
                        @foreach($cats as $c)
                        <label class="sp-check-label"><input type="checkbox"> <span>{{ $c }}</span></label>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range -->
                <div class="sp-filter-group open">
                    <div class="sp-filter-title" onclick="this.parentElement.classList.toggle('open')">
                        Price Range <span class="sp-chevron">▾</span>
                    </div>
                    <div class="sp-filter-body">
                        <div class="sp-price-range">
                            <input type="range" id="priceSlider" min="0" max="900" value="900" class="sp-slider">
                            <div class="sp-price-labels"><span>₱0</span><span id="priceMax">₱900</span></div>
                        </div>
                        <button class="sh-btn-orange sp-apply-btn">Apply</button>
                    </div>
                </div>

                <!-- Ratings -->
                <div class="sp-filter-group open">
                    <div class="sp-filter-title" onclick="this.parentElement.classList.toggle('open')">
                        Ratings <span class="sp-chevron">▾</span>
                    </div>
                    <div class="sp-filter-body">
                        @foreach([5,4,3] as $r)
                        <label class="sp-check-label">
                            <input type="checkbox">
                            <span class="sp-stars-filter">{{ str_repeat('★', $r) }}{{ str_repeat('☆', 5-$r) }}</span>
                            <span>& up</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Availability -->
                <div class="sp-filter-group open">
                    <div class="sp-filter-title" onclick="this.parentElement.classList.toggle('open')">
                        Availability <span class="sp-chevron">▾</span>
                    </div>
                    <div class="sp-filter-body">
                        <label class="sp-check-label"><input type="checkbox"> In Stock Only</label>
                        <label class="sp-check-label sp-toggle-label">
                            <span>On Sale</span>
                            <span class="sp-toggle" id="saleToggle" onclick="this.classList.toggle('active')"></span>
                        </label>
                    </div>
                </div>

                <button class="sp-clear-btn">Clear All Filters</button>
            </aside>

            <!-- Product area -->
            <div class="sp-main">
                <div class="sp-toolbar">
                    <p class="sp-count-text">Showing 1–24 of <strong>387 products</strong></p>
                    <div class="sp-toolbar-right">
                        <div class="sp-view-toggle">
                            <button class="sp-view-btn active" title="Grid"><svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M3 3h8v8H3zm10 0h8v8h-8zM3 13h8v8H3zm10 0h8v8h-8z"/></svg></button>
                            <button class="sp-view-btn" title="List"><svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M3 4h18v2H3zm0 7h18v2H3zm0 7h18v2H3z"/></svg></button>
                        </div>
                        <select class="sp-sort-select">
                            <option>Sort by: Featured</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Newest</option>
                            <option>Best Rating</option>
                        </select>
                    </div>
                </div>

                <div class="sp-product-grid" id="spGrid">
                    <!-- Products will be dynamically loaded here by admin -->
                </div>
                <!-- Empty State -->
                <div class="sp-empty-state" style="grid-column: 1/-1; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:4rem 2rem; background:#fff; border-radius:12px; text-align:center; color:#888;">
                    <span style="font-size:3.5rem; margin-bottom:1rem;">🛍️</span>
                    <h3 style="color:#333; margin-bottom:0.5rem; font-size:1.2rem;">No products found</h3>
                    <p style="margin:0; font-size:0.95rem;">Products added from the admin panel will appear here.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.shop_footer')

<script>
document.getElementById('priceSlider')?.addEventListener('input', function(){
    document.getElementById('priceMax').textContent = '₱' + this.value;
});
</script>
@else
<script>window.location.href='{{ route("login") }}';</script>
@endauth
</body>
</html>
