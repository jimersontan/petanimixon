@extends('layouts.admin')

@section('content')
<div class="content-header">
    <h1 class="page-title">Create Product</h1>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('products._form')
        
        <div class="form-actions" style="margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('products.admin') }}" class="btn btn-secondary" style="margin-left: 8px;">Cancel</a>
        </div>
    </form>
</div>
@endsection
