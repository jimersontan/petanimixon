@extends('layouts.admin')

@section('title','Create Brand')

@section('content')
<div class="content-header">
    <h1 class="page-title">Add New Brand</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('brands.store') }}">
            @csrf
            @include('brands._form')
            <button type="submit" class="btn-primary">Create Brand</button>
            <a href="{{ route('brands.admin') }}" class="btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
