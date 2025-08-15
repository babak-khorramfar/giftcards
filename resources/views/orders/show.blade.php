<x-app-layout>

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>

    <p>شماره سفارش: {{ $order->id }}</p>
    <p>مبلغ کل: {{ $order->total }} {{ $order->currency }}</p>
    <p>وضعیت: {{ $order->status }}</p>

    <a href="{{ route('home') }}">بازگشت به صفحه اصلی</a>
</div>
@endsection
</x-app-layout>