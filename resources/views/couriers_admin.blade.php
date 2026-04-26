@extends('layouts.admin')

@section('title', 'Couriers Management')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/rider.css') }}">
@endpush

@section('content')
<div class="content-header">
                <div>
                    <h1 class="page-title">Couriers Management</h1>
                    <p style="color: #64748b; font-size: 0.88rem; margin: 4px 0 0;">Manage your third-party courier partners</p>
                </div>
                <button type="button" class="btn-rider-primary" style="background: linear-gradient(135deg, #F97316, var(--ud-orange-dark));" id="btnCreateCourier" onclick="document.getElementById('createCourierModal').style.display='flex'">
                    + Add Courier
                </button>
            </div>

            <!-- Stats -->
            <div class="rider-stats-grid" style="margin-bottom: 24px;">
                <div class="rider-stat-card">
                    <div class="rider-stat-icon" style="background: linear-gradient(135deg, #fef3c7, #fde68a); color: #F97316;">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg>
                    </div>
                    <div>
                        <div class="rider-stat-value">{{ $totalCouriers }}</div>
                        <div class="rider-stat-label">Total Couriers</div>
                    </div>
                </div>
                <div class="rider-stat-card">
                    <div class="rider-stat-icon green">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <div>
                        <div class="rider-stat-value">{{ $activeCouriers }}</div>
                        <div class="rider-stat-label">Active Couriers</div>
                    </div>
                </div>
                <div class="rider-stat-card">
                    <div class="rider-stat-icon blue">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-3 10h-3v3h-2v-3H8v-2h3V8h2v3h3v2z"/></svg>
                    </div>
                    <div>
                        <div class="rider-stat-value">{{ $deliveriesToday }}</div>
                        <div class="rider-stat-label">Deliveries Today</div>
                    </div>
                </div>
            </div>

            <!-- Couriers Table -->
            <div class="rider-card">
                <div class="rider-card-header">
                    <h2>🚚 All Couriers</h2>
                </div>
                <div class="rider-table-wrap">
                    <table class="rider-table">
                        <thead>
                            <tr>
                                <th>Courier</th>
                                <th>Tracking URL</th>
                                <th>Status</th>
                                <th>Deliveries</th>
                                <th>Added</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($couriers as $courier)
                            <tr style="{{ !$courier->is_active ? 'opacity: 0.5; background: #f9fafb;' : '' }}">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        @if($courier->logo_url)
                                            <img src="{{ asset($courier->logo_url) }}" alt="{{ $courier->name }}" style="width: 40px; height: 40px; border-radius: 10px; object-fit: contain; background: #f5f5f5; padding: 4px; border: 1px solid #e2e8f0;">
                                        @else
                                            <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #F97316, var(--ud-orange-dark)); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 16px;">
                                                {{ strtoupper(substr($courier->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="rider-name-cell">{{ $courier->name }}</div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ $courier->tracking_url }}" target="_blank" style="color: #3b82f6; font-size: 0.82rem; text-decoration: none; word-break: break-all;">
                                        {{ Str::limit($courier->tracking_url, 45) }}
                                    </a>
                                </td>
                                <td>
                                    <span class="rider-badge-status {{ $courier->is_active ? 'rider-badge-active' : 'rider-badge-suspended' }}">
                                        {{ $courier->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td><strong>{{ $courier->deliveries_count }}</strong></td>
                                <td>{{ $courier->created_at->format('M j, Y') }}</td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <a href="{{ route('couriers.edit', $courier->id) }}" class="btn-rider-secondary btn-rider-sm">Edit</a>
                                        <form action="{{ route('couriers.toggle', $courier->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-rider-sm {{ $courier->is_active ? 'btn-rider-warning' : 'btn-rider-success' }}"
                                                onclick="return confirm('{{ $courier->is_active ? 'Deactivate' : 'Activate' }} this courier?')">
                                                {{ $courier->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px 20px; color: var(--rider-text-muted);">
                                    <div style="font-size: 2rem; margin-bottom: 8px;">🚚</div>
                                    <strong>No couriers yet.</strong><br>
                                    Click "+ Add Courier" to add your first courier partner.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($couriers->hasPages())
                <div class="rider-pagination">
                    {{ $couriers->links() }}
                </div>
                @endif
            </div>
@endsection

@push('modals')
<!-- ===== CREATE COURIER MODAL ===== -->
    <div class="rider-modal-overlay" id="createCourierModal" style="display: none;">
        <div class="rider-modal">
            <div class="rider-modal-header">
                <h2>🚚 Add New Courier</h2>
                <button type="button" class="rider-modal-close" onclick="document.getElementById('createCourierModal').style.display='none'">&times;</button>
            </div>
            <form action="{{ route('couriers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="rider-modal-body">
                    @if($errors->any() && !isset($showEditModal))
                        <div style="background: #fef2f2; color: #991b1b; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 0.85rem; border: 1px solid #fecaca;">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="rider-form-group">
                        <label for="name">Courier Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. Flash Express">
                    </div>
                    <div class="rider-form-group">
                        <label for="tracking_url">Tracking URL *</label>
                        <input type="url" id="tracking_url" name="tracking_url" value="{{ old('tracking_url') }}" required placeholder="e.g. https://www.flashexpress.ph/tracking?id=">
                        <small style="color: #64748b; font-size: 0.75rem; margin-top: 4px; display: block;">Base tracking URL — tracking number will be appended automatically</small>
                    </div>
                    <div class="rider-form-group">
                        <label for="logo">Logo / Icon</label>
                        <input type="file" id="logo" name="logo" accept="image/*" style="padding: 8px;">
                    </div>
                    <div class="rider-form-group">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                            <input type="checkbox" name="is_active" checked style="width: 18px; height: 18px; accent-color: #F97316;">
                            <span>Active</span>
                        </label>
                    </div>
                </div>
                <div class="rider-modal-footer">
                    <button type="button" class="btn-rider-secondary" onclick="document.getElementById('createCourierModal').style.display='none'">Cancel</button>
                    <button type="submit" class="btn-rider-primary" style="background: linear-gradient(135deg, #F97316, var(--ud-orange-dark));">Save Courier 🚚</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== EDIT COURIER MODAL ===== -->
    @if(isset($showEditModal) && isset($editCourier))
    <div class="rider-modal-overlay" id="editCourierModal" style="display: flex;">
        <div class="rider-modal">
            <div class="rider-modal-header">
                <h2>✏️ Edit Courier</h2>
                <a href="{{ route('couriers.admin') }}" class="rider-modal-close">&times;</a>
            </div>
            <form action="{{ route('couriers.update', $editCourier->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="rider-modal-body">
                    <div class="rider-form-group">
                        <label for="edit_name">Courier Name *</label>
                        <input type="text" id="edit_name" name="name" value="{{ $editCourier->name }}" required>
                    </div>
                    <div class="rider-form-group">
                        <label for="edit_tracking_url">Tracking URL *</label>
                        <input type="url" id="edit_tracking_url" name="tracking_url" value="{{ $editCourier->tracking_url }}" required>
                        <small style="color: #64748b; font-size: 0.75rem; margin-top: 4px; display: block;">Base tracking URL — tracking number will be appended automatically</small>
                    </div>
                    <div class="rider-form-group">
                        <label for="edit_logo">Logo / Icon (leave empty to keep current)</label>
                        @if($editCourier->logo_url)
                            <div style="margin-bottom: 8px;">
                                <img src="{{ asset($editCourier->logo_url) }}" alt="Current logo" style="width: 48px; height: 48px; border-radius: 8px; object-fit: contain; background: #f5f5f5; padding: 4px; border: 1px solid #e2e8f0;">
                            </div>
                        @endif
                        <input type="file" id="edit_logo" name="logo" accept="image/*" style="padding: 8px;">
                    </div>
                    <div class="rider-form-group">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                            <input type="checkbox" name="is_active" {{ $editCourier->is_active ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #F97316;">
                            <span>Active</span>
                        </label>
                    </div>
                </div>
                <div class="rider-modal-footer">
                    <a href="{{ route('couriers.admin') }}" class="btn-rider-secondary">Cancel</a>
                    <button type="submit" class="btn-rider-primary" style="background: linear-gradient(135deg, #F97316, var(--ud-orange-dark));">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    @endif
@endpush

@push('scripts')
<script>
        // Auto-show create modal if there are errors and we were creating
        @if($errors->any() && !isset($showEditModal))
            document.getElementById('createCourierModal').style.display = 'flex';
        @endif

        // Close modals on overlay click
        document.querySelectorAll('.rider-modal-overlay').forEach(function(overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    overlay.style.display = 'none';
                }
            });
        });
    </script>
@endpush
