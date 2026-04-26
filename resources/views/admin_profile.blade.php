@extends('layouts.admin')

@section('title', 'Your Profile')

@section('content')
<div class="content-header">
                <h1 class="page-title">Your Profile</h1>
            </div>

            @if(session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif

            <form method="post" action="{{ route('admin.profile.update') }}" class="form">
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
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
@endsection
