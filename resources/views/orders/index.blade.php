@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>

    @if($orders->isEmpty())
        <p>هنوز سفارشی ثبت نکرده‌اید.</p>
    @else
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>شماره سفارش</th>
                    <th>مبلغ کل</th>
                    <th>واحد پول</th>
                    <th>وضعیت</th>
                    <th>تاریخ ثبت</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td><a href="{{ route('orders.show', $order->id) }}">{{ $order->id }}</a></td>
                        <td>{{ $order->total }}</td>
                        <td>{{ $order->currency }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $orders->links() }}
    @endif
</div>
@endsection
