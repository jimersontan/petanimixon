@extends('layouts.admin')

@section('title','Edit Product')

@section('content')
<h1>Edit Product</h1>
<form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('products._form')
    <button type="submit" class="btn btn-primary">Save Changes</button>
    <a href="{{ route('products.admin') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
