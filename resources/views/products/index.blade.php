<x-app-layout>

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>

    @if($products->isEmpty())
        <p>هیچ محصولی موجود نیست.</p>
    @else
        <ul>
            @foreach($products as $product)
                <li>
                    {{ $product->name }} - {{ $product->price }} {{ $product->currency }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
</x-app-layout>