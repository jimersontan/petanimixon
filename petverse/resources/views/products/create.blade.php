@extends('layouts.admin')

@section('content')
<h1>Create Product</h1>
<form action="{{ route('products.store') }}" method="POST">
    @csrf
    @include('products._form')
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('products.admin') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
