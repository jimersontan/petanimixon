@extends('layouts.admin')

@section('title','Create Brand')

@section('content')
<div class="content-header">
    <div>
        <h1 class="page-title">Add New Brand</h1>
        <p class="page-subtitle">Highlight the brands you work with.</p>
    </div>
</div>

<div class="card form-card">
    <div class="card-body">
        <form method="POST" action="{{ route('brands.store') }}" enctype="multipart/form-data">
            @csrf
            @include('brands._form')
            <div class="form-actions">
                <button type="submit" class="btn-primary">Create brand</button>
                <a href="{{ route('brands.admin') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
