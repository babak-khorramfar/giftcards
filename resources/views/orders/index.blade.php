<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            سفارش‌های من
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if($orders->isEmpty())
            <p>هنوز سفارشی ثبت نکرده‌اید.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full border">
                    <thead>
                        <tr>
                            <th class="border px-3 py-2">شماره سفارش</th>
                            <th class="border px-3 py-2">مبلغ کل</th>
                            <th class="border px-3 py-2">واحد پول</th>
                            <th class="border px-3 py-2">وضعیت</th>
                            <th class="border px-3 py-2">تاریخ ثبت</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="border px-3 py-2">
                                    <a href="{{ route('orders.show', $order->id) }}">{{ $order->id }}</a>
                                </td>
                                <td class="border px-3 py-2">{{ $order->total }}</td>
                                <td class="border px-3 py-2">{{ $order->currency }}</td>
                                <td class="border px-3 py-2">{{ $order->status }}</td>
                                <td class="border px-3 py-2">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
