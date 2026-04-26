@extends('layouts.admin')

@section('title', 'Create Admin')

@section('content')
<div class="content-header">
                <h1 class="page-title">Add New Admin</h1>
            </div>

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
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
@endsection
