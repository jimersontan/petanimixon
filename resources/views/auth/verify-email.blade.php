@extends('frontend.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                    <h3 class="fw-bold mb-0">Verify Your Email Address</h3>
                </div>

                <div class="card-body p-4 text-center">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <i class="fas fa-envelope-open-text text-primary" style="font-size: 3rem;"></i>
                    </div>

                    <p class="fs-5 text-muted mb-4">
                        Before proceeding, please check your email for a verification link.
                        If you did not receive the email, we can send you another one.
                    </p>

                    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold">
                            Click here to request another
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


