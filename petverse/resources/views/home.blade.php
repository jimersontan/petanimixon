<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Petverse</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        .home-header { display: flex; justify-content: space-between; align-items: center; padding: 1rem 2rem; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .home-header .brand { font-size: 1.5rem; font-weight: 700; color: #333; }
        .home-nav { display: flex; gap: 1rem; align-items: center; }
        .home-nav a { color: #555; text-decoration: none; padding: 0.5rem 1rem; border-radius: 6px; }
        .home-nav a:hover { background: #f5f5f5; color: #333; }
        .home-main { max-width: 800px; margin: 4rem auto; padding: 2rem; text-align: center; }
        .home-main h1 { font-size: 2rem; margin-bottom: 0.5rem; color: #333; }
        .home-main p { color: #666; margin-bottom: 2rem; }
        .home-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .btn { display: inline-block; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.2s; }
        .btn-primary { background: #FF8844; color: #fff; border: none; }
        .btn-primary:hover { background: #e67333; color: #fff; }
        .btn-secondary { background: #f0f0f0; color: #333; }
        .btn-secondary:hover { background: #e0e0e0; color: #333; }
        .msg { padding: 0.75rem; margin-bottom: 1rem; background: #e8f5e9; color: #2e7d32; border-radius: 6px; }
    </style>
</head>
<body>
    <header class="home-header">
        <span class="brand">🐾 Petverse</span>
        <nav class="home-nav">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('orders') }}">My Orders</a>
            <span>{{ Auth::user()->full_name ?? Auth::user()->email }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-secondary" style="cursor:pointer; border:none; font-size:inherit;">Logout</button>
            </form>
        </nav>
    </header>

    <main class="home-main">
        @if(session('message'))
            <div class="msg">{{ session('message') }}</div>
        @endif
        <h1>Welcome to Petverse!</h1>
        <p>Hi {{ Auth::user()->full_name ?? Auth::user()->email }}, browse pet products and shop for your furry friends.</p>
        <div class="home-actions">
            <a href="{{ route('orders') }}" class="btn btn-primary">View My Orders</a>
        </div>
    </main>
</body>
</html>
