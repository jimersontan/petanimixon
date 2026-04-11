@extends('frontend.layouts.app')

@section('title', $product->product_name . ' - PetMarkt-PH')

@section('content')
<div class="pd-page">
    {{-- Breadcrumb --}}
    <div class="pd-breadcrumb">
        <a href="{{ route('shop') }}">Home</a> /
        <a href="{{ route('shop.all') }}">Shop</a> /
        @if($product->category)
        <a href="{{ route('categories.show', $product->category->id) }}">{{ $product->category->category_name }}</a> /
        @endif
        {{ $product->product_name }}
    </div>

    @include('frontend.partials.product_modal_content')

</div>

{{-- Image Lightbox --}}
<div class="rv-lightbox" id="lightbox" onclick="window.closeLightbox()">
    <button class="rv-lightbox-close">&times;</button>
    <img id="lightboxImg" src="" alt="Review photo">
</div>

@endsection


