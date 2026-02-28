@extends('layouts.admin')

@section('title','Categories')

@section('content')
<div class="content-header">
    <h1 class="page-title">Categories</h1>
    <div class="date-filter">
        <a href="{{ route('categories.create') }}" class="btn-primary">
            <span class="btn-icon">+</span>
            <span>Add Category</span>
        </a>
    </div>
</div>

<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-icon metric-icon-orders-orange">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3 3v8h8V3H3zm10 0v8h8V3h-8zM3 13v8h8v-8H3zm10 0v8h8v-8h-8z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ number_format($stats['total_categories'] ?? 0) }}</div>
            <div class="metric-label">Total Categories</div>
        </div>
    </div>
    <div class="metric-card">
        <div class="metric-icon metric-icon-completed">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ number_format($stats['active_categories'] ?? 0) }}</div>
            <div class="metric-label">Active Categories</div>
        </div>
    </div>
    <div class="metric-card">
        <div class="metric-icon metric-icon-orders">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M20 2H4c-1 0-2 .9-2 2v3.01c0 .72.43 1.34 1 1.69V20c0 1.1 1.1 2 2 2h14c.9 0 2-.9 2-2V8.7c.57-.35 1-.97 1-1.69V4c0-1.1-1-2-2-2zm-5 12H9v-2h6v2zm5-7H4V4h16v3z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ number_format($stats['total_products'] ?? 0) }}</div>
            <div class="metric-label">Total Products</div>
        </div>
    </div>
    <div class="metric-card">
        <div class="metric-icon metric-icon-avg">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ number_format($stats['avg_products_per_category'] ?? 0) }}</div>
            <div class="metric-label">Avg Products/Category</div>
        </div>
    </div>
</div>

<div class="card orders-table-card">
    <h2 class="card-title">Category Structure</h2>
    <div class="table-wrap">
        <table class="orders-table" id="categoriesTable">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Parent</th>
                    <th>Products</th>
                    <th>Status</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($categories ?? []) as $category)
                <tr>
                    <td>{{ $category->category_name ?? '' }}</td>
                    <td>{{ optional($category->parent)->category_name ?? '' }}</td>
                    <td>{{ $category->products_count ?? 0 }}</td>
                    <td>{{ ($category->is_active ?? true) ? 'Active' : 'Inactive' }}</td>
                    <td class="col-actions">
                        <a href="{{ route('categories.edit', $category) }}" class="action-btn" title="Edit" aria-label="Edit category">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn" title="Delete" onclick="return confirm('Delete this category?')">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-4.5l-1-1z"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center empty-orders">No categories defined yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/orders.js') }}"></script>
@endpush
