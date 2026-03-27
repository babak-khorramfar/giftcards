<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            پروفایل کاربر
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        @if(session('status') === 'profile-updated')
            <div style="color: green; margin-bottom: 12px;">پروفایل با موفقیت به‌روزرسانی شد.</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div style="margin-bottom:10px;">
                <label>نام:</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}">
                @error('name') <div style="color:red">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom:10px;">
                <label>ایمیل:</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}">
                @error('email') <div style="color:red">{{ $message }}</div> @enderror
            </div>

            <button type="submit">ذخیره تغییرات</button>
        </form>
    </div>
</x-app-layout>
