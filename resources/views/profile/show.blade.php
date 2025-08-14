@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div>
            <label>نام:</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}">
            @error('name') <div style="color: red;">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>ایمیل:</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}">
            @error('email') <div style="color: red;">{{ $message }}</div> @enderror
        </div>

        <button type="submit">ذخیره تغییرات</button>
    </form>
</div>
@endsection
