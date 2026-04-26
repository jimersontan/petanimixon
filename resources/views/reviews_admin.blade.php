@extends('layouts.admin')

@section('title', 'Reviews')

@section('content')
<div class="content-header">
                <h1 class="page-title">Reviews</h1>
                <div class="date-filter">
                    <form method="get" action="{{ route('reviews.admin') }}" class="date-filter-form" id="reviewsDateForm">
                        <select name="days" id="reviewsDateRange" class="filter-select" aria-label="Date range">
                            <option value="7" {{ ($days ?? 30) == 7 ? 'selected' : '' }}>Last 7 days</option>
                            <option value="30" {{ ($days ?? 30) == 30 ? 'selected' : '' }}>Last 30 days</option>
                            <option value="90" {{ ($days ?? 30) == 90 ? 'selected' : '' }}>Last 90 days</option>
                        </select>
                    </form>
                    <button type="button" class="btn-primary">Export Reviews</button>
                </div>
            </div>

            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-icon metric-icon-avg">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">{{ number_format($stats['avg_rating'] ?? 0, 1) }}</div>
                        <div class="metric-label">Average Rating</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-orders-orange">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3 3v18l7-3 7 3V3z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">{{ number_format($stats['total_reviews'] ?? 0) }}</div>
                        <div class="metric-label">Total Reviews</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-pending">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">{{ number_format($stats['pending_reviews'] ?? 0) }}</div>
                        <div class="metric-label">Pending Reviews</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon metric-icon-avg">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                    <div class="metric-content">
                        <div class="metric-value">{{ number_format($stats['response_rate'] ?? 0, 1) }}%</div>
                        <div class="metric-label">Response Rate</div>
                    </div>
                </div>
            </div>

            <div class="card orders-table-card">
                <div class="orders-section-header">
                    <h2 class="card-title">All Reviews</h2>
                </div>

                <div class="order-status-tabs" role="tablist">
                    <button type="button" class="order-tab active" data-status="all" role="tab" aria-selected="true">All</button>
                    <button type="button" class="order-tab" data-status="published" role="tab">Published</button>
                    <button type="button" class="order-tab" data-status="pending" role="tab">Pending</button>
                    <button type="button" class="order-tab" data-status="flagged" role="tab">Flagged</button>
                </div>

                <div class="table-wrap">
                    <table class="orders-table" id="reviewsTable">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Status</th>
                                <th class="col-actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($reviews ?? []) as $review)
                            <tr data-status="{{ $review->status ?? 'published' }}">
                                <td>{{ optional($review->product)->product_name ?? '' }}</td>
                                <td>{{ optional($review->user)->first_name ?? '' }} {{ optional($review->user)->last_name ?? '' }}</td>
                                <td>{{ $review->rating ?? '' }}/5</td>
                                <td>{{ $review->review_title ?? '' }}</td>
                                <td>{{ ucfirst($review->status ?? 'published') }}</td>
                                <td class="col-actions">
                                    <a href="#" class="action-btn" title="Approve" aria-label="Approve review">
                                        ✓
                                    </a>
                                    <a href="#" class="action-btn" title="Reply" aria-label="Reply to review">
                                        ↩
                                    </a>
                                    <a href="#" class="action-btn" title="Delete" aria-label="Delete review">
                                        🗑
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center empty-orders">No reviews yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
@endsection
