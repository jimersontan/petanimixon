<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile - Pet Animixon Admin</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body class="dashboard-body">
    @include('partials.admin_header')
    <div class="dashboard-layout">
        @include('partials.admin_sidebar')
        <main class="main-content">
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
        </main>
    </div>
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>