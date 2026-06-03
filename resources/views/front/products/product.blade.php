@extends('layouts.front.app')


@section('og')
    <meta property="og:type" content="product"/>
    <meta property="og:title" content="{{ $product->name }}"/>
    <meta property="og:description" content="{{ strip_tags($product->description) }}"/>
    @if(!is_null($product->cover))
        <meta property="og:image" content="{{ asset("storage/$product->cover") }}"/>
    @endif
@endsection

@section('content')
<!-- <nav aria-label="breadcrumb">
  
    <div class="breadcrumb">
      <div class="container">

    <ol class=" breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">  Home</a></li>
       
        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
      </ol> 
  </div>
  </div>
</nav> -->
@include('layouts.front.product')
@endsection