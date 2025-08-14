@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $product->name }}</h1>
    <p>کد: {{ $product->code }}</p>
    <p>قیمت: {{ $product->price }} {{ $product->currency }}</p>

    @if($product->description)
        <p>{{ $product->description }}</p>
    @endif

    <a href="{{ route('products.index') }}">بازگشت به لیست محصولات</a>
</div>
@endsection
