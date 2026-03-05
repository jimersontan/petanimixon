<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop by Category - Pet Animixon</title>
    <link rel="stylesheet" href="{{ asset('css/shop_shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop_categories.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
@auth
@include('partials.shop_nav')

<div class="sc-wrap">
    <div class="sh-container">
        <div class="sh-breadcrumb">
            <a href="{{ route('home') }}">Home</a> <span>›</span> <span>Shop by Category</span>
        </div>

        <div class="sh-page-title">
            <h1>Shop by Category</h1>
            <p>Browse products by what you need</p>
            <div class="sh-title-bar"></div>
        </div>

        <div class="sc-grid">
            <!-- Categories will be dynamically loaded here by admin -->
            <!-- Empty State -->
            <div class="sp-empty-state" style="grid-column: 1/-1; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:4rem 2rem; background:#fff; border-radius:12px; text-align:center; color:#888;">
                <span style="font-size:3.5rem; margin-bottom:1rem;">🗂️</span>
                <h3 style="color:#333; margin-bottom:0.5rem; font-size:1.2rem;">No categories found</h3>
                <p style="margin:0; font-size:0.95rem;">Categories added from the admin panel will appear here.</p>
            </div>
        </div>
    </div>
</div>

@include('partials.shop_footer')

@else
<script>window.location.href='{{ route("login") }}';</script>
@endauth
</body>
</html>
