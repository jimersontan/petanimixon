<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Users - PetMarkt-PH Admin</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}"> <!-- reuse whatever table styles exist -->
</head>
<body class="dashboard-body">
    @include('partials.admin_header')

    <div class="dashboard-layout">
        @include('partials.admin_sidebar')

        <main class="main-content">
            <div class="content-header">
                <h1 class="page-title">Admin Users</h1>
                <div class="actions">
                    <button type="button" class="btn btn-primary" data-modal-open="add-admin-modal">Add Admin</button>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                        @php
                            $currentUser = auth()->user();
                            $canEdit = $currentUser->isMainAdmin() || ($currentUser->isSupervisor() && $admin->adminRole() === 'staff_admin');
                        @endphp
                        <tr>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $admin->adminProfile->admin_type ?? 'staff_admin')) }}</td>
                            <td>
                                @if($canEdit)
                                    <a href="{{ route('admin.users.edit', $admin->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                @else
                                    <span class="btn btn-sm btn-secondary disabled" title="Not allowed">Locked</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </main>
    </div>

    @push('modals')
    <div class="modal-backdrop {{ $errors->any() ? 'open' : '' }}" data-modal-id="add-admin-modal"></div>
    <div id="add-admin-modal" class="modal {{ $errors->any() ? 'open' : '' }}" role="dialog" aria-modal="true" aria-labelledby="addAdminTitle" tabindex="-1">
        <div class="modal-header">
            <h2 id="addAdminTitle" class="modal-title">Add Admin</h2>
            <button type="button" class="modal-close" data-modal-close="add-admin-modal" aria-label="Close modal">&times;</button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{ route('admin.users.store') }}" class="form">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" required>
                        @foreach($roles as $roleKey => $roleLabel)
                            <option value="{{ $roleKey }}" @if(old('role') === $roleKey) selected @endif>{{ $roleLabel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-modal-close="add-admin-modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
    @endpush

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>

