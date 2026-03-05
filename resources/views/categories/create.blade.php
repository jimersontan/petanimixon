@extends('layouts.admin')

@section('title','Create Category')

@section('content')
<h1>Create Category</h1>
<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    @include('categories._form')
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('categories.admin') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection