@extends('layouts.admin')

@section('title','Create Category')

@section('content')
<div class="content-header">
    <div>
        <h1 class="page-title">Create Category</h1>
        <p class="page-subtitle">Organize your products into clear sections.</p>
    </div>
</div>

<div class="card form-card">
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        @include('categories._form')
        <div class="form-actions">
            <button type="submit" class="btn-primary">Save category</button>
            <a href="{{ route('categories.admin') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection