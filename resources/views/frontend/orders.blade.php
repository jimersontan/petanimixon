@extends('frontend.layouts.app')

@section('title', 'My Orders - Petverse')

@section('content')
    <section class="ud-section">
        <div class="ud-section-header">
            <h2 class="ud-section-title">My Orders</h2>
        </div>

        @if($orders->isEmpty())
            <div class="ud-card" style="padding: 2rem; text-align: center;">
                <p>You haven't placed any orders yet.</p>
                <a href="{{ route('shop') }}" class="ud-btn ud-btn-primary">Start Shopping</a>
            </div>
        @else
            <div class="ud-table-wrap">
                <table class="ud-table" style="width:100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Items</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->display_id }}</td>
                                <td>{{ $order->created_at->format('M j, Y') }}</td>
                                <td>{{ ucfirst($order->order_status) }}</td>
                                <td>{{ $order->formatted_total }}</td>
                                <td>{{ $order->orderItems->count() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 1.5rem;">
                {{ $orders->links() }}
            </div>
        @endif
    </section>
@endsection
