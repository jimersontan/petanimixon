<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Requests - Pet Animixon Admin</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}"> <!-- reuse table styles -->
</head>
<body class="dashboard-body">
    @include('partials.admin_header')
    <div class="dashboard-layout">
        @include('partials.admin_sidebar')
        <main class="main-content">
            <div class="content-header">
                <h1 class="page-title">Admin Account Requests</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Requested At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $req)
                        <tr>
                            <td>{{ $req->name }}</td>
                            <td>{{ $req->email }}</td>
                            <td>{{ ucfirst($req->status) }}</td>
                            <td>{{ $req->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                @if($req->status === 'pending')
                                    <form method="POST" action="{{ route('admin.requests.approve', $req->id) }}" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.requests.decline', $req->id) }}" style="display:inline; margin-left:8px;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Decline</button>
                                    </form>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>