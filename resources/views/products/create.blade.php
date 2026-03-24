@extends('layouts.admin')

@section('title','Create Product')

@section('content')
<div class="content-header">
    <div>
        <h1 class="page-title">Create Product</h1>
        <p class="page-subtitle">Add a new item to your catalog.</p>
    </div>
</div>

<div class="card form-card">
    <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('products._form')
        <div class="form-actions">
            <button type="submit" class="btn-primary">Save product</button>
            <a href="{{ route('inventory.admin') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
