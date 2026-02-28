@extends('layouts.admin')

@section('title','Edit Category')

@section('content')
<h1>Edit Category</h1>
<form action="{{ route('categories.update', $category) }}" method="POST">
    @csrf
    @method('PUT')
    @include('categories._form')
    <button type="submit" class="btn btn-primary">Save Changes</button>
    <a href="{{ route('categories.admin') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection