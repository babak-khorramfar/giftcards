<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-xl font-bold mb-4">{{ $title ?? 'صفحه اصلی سایت' }}</h1>
        <p>اینجا محتوای صفحه اصلی نمایش داده می‌شود.</p>
        <form method="POST" action="{{ route('orders.store') }}" class="space-y-2">
        @csrf
        <input type="number" step="0.01" name="total" value="20.00" />
        <input type="text" name="currency" value="USD" />
        <button type="submit">ثبت سفارش تست</button>
        </form>

    </div>
</x-app-layout>
