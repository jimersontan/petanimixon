@extends('layouts.admin')

@section('title','Brands')

@section('content')
<div class="content-header">
    <h1 class="page-title">Brands</h1>
    <div class="date-filter">
        <a href="{{ route('brands.create') }}" class="btn-primary">
            <span class="btn-icon">+</span>
            <span>Add Brand</span>
        </a>
    </div>
</div>

<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-icon metric-icon-orders-orange">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3 3h18v4H3z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ number_format($stats['total_brands'] ?? 0) }}</div>
            <div class="metric-label">Total Brands</div>
        </div>
    </div>
    <div class="metric-card">
        <div class="metric-icon metric-icon-completed">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ number_format($stats['active_brands'] ?? 0) }}</div>
            <div class="metric-label">Active</div>
        </div>
    </div>
    <div class="metric-card">
        <div class="metric-icon metric-icon-avg">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ number_format($stats['featured_brands'] ?? 0) }}</div>
            <div class="metric-label">Featured</div>
        </div>
    </div>
    <div class="metric-card">
        <div class="metric-icon metric-icon-avg">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3 17h18v4H3z"/></svg>
        </div>
        <div class="metric-content">
            <div class="metric-value">{{ number_format($stats['avg_products_per_brand'] ?? 0, 1) }}</div>
            <div class="metric-label">Avg Products/Brand</div>
        </div>
    </div>
</div>

<div class="card orders-table-card">
    <h2 class="card-title">All Brands</h2>
    <div class="table-wrap">
        <table class="orders-table" id="brandsTable">
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Products</th>
                    <th>Status</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($brands ?? []) as $brand)
                <tr>
                    <td>{{ $brand->name ?? '—' }}</td>
                    <td>{{ $brand->products_count ?? 0 }}</td>
                    <td>{{ ($brand->is_active ?? true) ? 'Active' : 'Inactive' }}</td>
                    <td class="col-actions">
                        <a href="{{ route('brands.edit', $brand) }}" class="action-btn" title="Edit" aria-label="Edit brand">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('brands.destroy', $brand) }}" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn" title="Delete" onclick="return confirm('Delete this brand?')">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-4.5l-1-1z"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center empty-orders">No brands defined yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $brands->links() ?? '' }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/orders.js') }}"></script>
@endpush

