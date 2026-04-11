@extends('frontend.layouts.app')

@section('title','Shop by Category')

@push('styles')
<style>
/* ── Category Page ── */
.cat-page { max-width: 1100px; margin: 0 auto; padding: 32px 20px 60px; }

/* Header */
.cat-header { text-align: center; margin-bottom: 36px; }
.cat-title {
    font-size: 30px; font-weight: 800; color: #1a1a2e; margin: 0 0 8px;
}
.cat-subtitle { font-size: 14px; color: #888; margin: 0 0 14px; }
.cat-line { width: 48px; height: 3px; background: #E85D04; border-radius: 3px; margin: 0 auto; }

/* Grid */
.cat-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;
}

/* Card */
.cat-card {
    background: #fff; border: 1px solid #eee; border-radius: 14px;
    padding: 28px 20px 22px; text-align: center; text-decoration: none; color: inherit;
    transition: all 0.25s; display: flex; flex-direction: column; align-items: center;
}
.cat-card:hover {
    border-color: #E85D04; transform: translateY(-4px);
    box-shadow: 0 10px 28px rgba(232,93,4,0.1);
}

/* Icon circle */
.cat-icon {
    width: 64px; height: 64px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 16px; font-size: 26px;
}
.cat-icon.orange { background: #e9f2ea; color: #E85D04; }
.cat-icon.blue   { background: #e3f0ff; color: #2563eb; }
.cat-icon.red    { background: #fce4ec; color: #e53935; }
.cat-icon.teal   { background: #e0f2f1; color: #00897b; }

/* Text */
.cat-name { font-size: 15px; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
.cat-desc { font-size: 12.5px; color: #888; line-height: 1.45; margin-bottom: 10px; min-height: 36px; }
.cat-count { font-size: 12px; color: #aaa; margin-bottom: 12px; }
.cat-link {
    font-size: 13px; font-weight: 700; color: #E85D04; text-decoration: none;
    display: inline-flex; align-items: center; gap: 4px; transition: gap 0.2s;
}
.cat-card:hover .cat-link { gap: 8px; }

@media (max-width: 900px) {
    .cat-grid { grid-template-columns: repeat(3, 1fr); gap: 16px; }
}
@media (max-width: 600px) {
    .cat-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .cat-card { padding: 20px 14px 16px; }
    .cat-icon { width: 52px; height: 52px; font-size: 22px; }
    .cat-name { font-size: 13px; }
}
</style>
@endpush

@php
// Map category names to icon + color
$iconMap = [
    'Food and Nutritions'   => ['icon' => '🍖', 'color' => 'orange'],
    'Habitats & Housing'    => ['icon' => '🏠', 'color' => 'blue'],
    'Health & Care'         => ['icon' => '➕', 'color' => 'red'],
    'Medicine HealthCare'   => ['icon' => '➕', 'color' => 'red'],
    'Toys & Enrichment'     => ['icon' => '🎾', 'color' => 'teal'],
    'Toys'                  => ['icon' => '🎾', 'color' => 'teal'],
    'Grooming & Hygiene'    => ['icon' => '✂️', 'color' => 'orange'],
    'Travel & Safety'       => ['icon' => '✈️', 'color' => 'blue'],
    'Aquatic Supplies'      => ['icon' => '🐠', 'color' => 'teal'],
    'Reptile & Exotic Care' => ['icon' => '🦎', 'color' => 'teal'],
    'Invertebrate Care'     => ['icon' => '🦀', 'color' => 'red'],
    'Training & Behavior'   => ['icon' => '📋', 'color' => 'blue'],
];
@endphp

@section('content')
<div class="cat-page">

    {{-- Header --}}
    <div class="cat-header">
        <h1 class="cat-title">Shop by Category</h1>
        <p class="cat-subtitle">Browse products by what you need</p>
        <div class="cat-line"></div>
    </div>

    {{-- Grid --}}
    <div class="cat-grid">
        @forelse($categories as $category)
            @php
                $map = $iconMap[$category->category_name] ?? ['icon' => '📦', 'color' => 'orange'];
                $productCount = $category->products()->count();
            @endphp
            <a href="{{ route('categories.show', $category->id) }}" class="cat-card">
                @if($category->image_url)
                    <div style="width: 72px; height: 72px; margin-bottom: 16px; border-radius: 50%; background-color: #f9f9f9; box-shadow: 0 2px 8px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: center; padding: 12px; box-sizing: border-box;">
                        <img src="{{ asset('storage/' . $category->image_url) }}" alt="{{ $category->category_name }}" style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                @endif
                <div class="cat-name">{{ $category->category_name }}</div>
                <div class="cat-desc">{{ $category->description ?: 'Explore our selection' }}</div>
                <div class="cat-count">{{ $productCount }} {{ Str::plural('product', $productCount) }}</div>
                <span class="cat-link">Shop Now →</span>
            </a>
        @empty
            <div class="cat-card" style="grid-column: 1/-1; padding: 60px;">
                <div style="font-size: 48px; margin-bottom: 16px;">📭</div>
                <div class="cat-name">No categories found</div>
            </div>
        @endforelse
    </div>

</div>
@endsection


