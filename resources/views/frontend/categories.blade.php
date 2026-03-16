@extends('frontend.layouts.app')

@section('title','Shop by Category')

@section('content')
    <section class="ud-section">
        <div class="ud-section-header">
            <h2 class="ud-section-title">Shop by Category</h2>
        </div>
        <div class="ud-category-grid">
            @forelse($categories as $category)
                <a href="{{ route('categories.show', $category->id) }}" class="ud-category-card">
                    <div class="ud-category-card-title">{{ $category->category_name }}</div>
                    <div class="ud-category-card-meta">{{ $category->products()->count() }} products</div>
                </a>
            @empty
                <div class="ud-category-card">No categories found.</div>
            @endforelse
        </div>
    </section>
@endsection
