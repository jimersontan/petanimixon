@extends('layouts.admin')

@section('title', 'Edit Admin')

@section('content')
<div class="content-header">
                <h1 class="page-title">Edit Admin</h1>
            </div>

            <form method="post" action="{{ route('admin.users.update', $user->id) }}" class="form">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="form-group">
                    <label>Password <small>(leave blank to keep current)</small></label>
                    <input type="password" name="password">
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation">
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" required>
                        @foreach($roles as $roleKey => $roleLabel)
                            <option value="{{ $roleKey }}" @if(old('role', $user->adminProfile->admin_type ?? '') === $roleKey) selected @endif>{{ $roleLabel }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
@endsection
