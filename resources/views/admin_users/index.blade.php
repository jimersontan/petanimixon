@extends('layouts.admin')

@section('title', 'Admin Users')

@section('content')
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
@endsection
