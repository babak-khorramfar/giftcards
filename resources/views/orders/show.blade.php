<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">سفارش #{{ $order->id }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div>مبلغ: {{ $order->total }} {{ $order->currency }}</div>
            <div>وضعیت: {{ $order->status }}</div>

            @if($order->meta)
                <div>
                    <strong>Meta:</strong>
                    <pre>{{ json_encode($order->meta, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
            @endif

            @if($order->error_message)
                <div style="color:red;">خطا: {{ $order->error_message }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
