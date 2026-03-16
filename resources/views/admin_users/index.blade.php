@extends('layouts.admin')

@section('title','Admin Users')

@section('content')
<div class="content-header">
    <div>
        <h1 class="page-title">Admin Users</h1>
        <p class="page-subtitle">Manage administrator accounts</p>
    </div>
    <div class="actions">
        <button type="button" class="btn-primary" data-modal-open="add-admin-modal">
            <span class="btn-icon">+</span>
            <span>Add Admin</span>
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card orders-table-card">
    <div class="orders-section-header">
        <h2 class="card-title">All Admin Users</h2>
    </div>

    <div class="table-wrap">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                    @php
                        $currentUser = auth()->user();
                        $canEdit = $currentUser->isMainAdmin() || ($currentUser->isSupervisor() && $admin->adminRole() === 'staff_admin');
                        $roleLabels = [
                            'main_admin' => 'Main Admin',
                            'supervisor' => 'Supervisor',
                            'staff_admin' => 'Staff Admin'
                        ];
                    @endphp
                    <tr>
                        <td>{{ $admin->full_name ?? $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            <span class="badge badge-paid">{{ $roleLabels[$admin->adminProfile->admin_type ?? 'staff_admin'] ?? 'Staff Admin' }}</span>
                        </td>
                        <td class="col-actions">
                            @if($canEdit)
                                <a href="{{ route('admin.users.edit', $admin->id) }}" class="action-btn" title="Edit" aria-label="Edit admin user">
                                    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                </a>
                            @else
                                <span class="action-btn disabled" title="Not allowed">
                                    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/></svg>
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center empty-orders">No admin users yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('modals')
<div class="modal-backdrop {{ $errors->any() ? 'open' : '' }}" data-modal-id="add-admin-modal"></div>
<div id="add-admin-modal" class="modal {{ $errors->any() ? 'open' : '' }}" role="dialog" aria-modal="true" aria-labelledby="addAdminTitle" tabindex="-1">
    <div class="modal-header">
        <h2 id="addAdminTitle" class="modal-title">Add New Admin</h2>
        <button type="button" class="modal-close" data-modal-close="add-admin-modal" aria-label="Close modal">&times;</button>
    </div>
    <div class="modal-body">
        <form method="post" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
                @if($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" required>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" required>
                    <option value="">Select a role</option>
                    @foreach($roles as $roleKey => $roleLabel)
                        <option value="{{ $roleKey }}" @if(old('role') === $roleKey) selected @endif>{{ $roleLabel }}</option>
                    @endforeach
                </select>
                @if($errors->has('role'))
                    <span class="text-danger">{{ $errors->first('role') }}</span>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" data-modal-close="add-admin-modal">Cancel</button>
                <button type="submit" class="btn-primary">Create Admin</button>
            </div>
        </form>
    </div>
</div>
@endpush