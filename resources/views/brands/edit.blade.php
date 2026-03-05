@extends('layouts.admin')

@section('title','Edit Brand')

@section('content')
<div class="content-header">
    <h1 class="page-title">Edit Brand</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('brands.update', $brand) }}">
            @csrf
            @include('brands._form')
            <button type="submit" class="btn-primary">Save Changes</button>
            <a href="{{ route('brands.admin') }}" class="btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
