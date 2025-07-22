<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Lupa password Anda? Tidak masalah. Masukkan email dan nomor telepon Anda yang terdaftar, dan kami akan mengirimkan permintaan ke Admin untuk membantu Anda.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
            <strong class="font-bold">Oops! Terjadi kesalahan.</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('password.customSendRequest') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email Terdaftar Anda')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
        </div>

        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Nomor Telepon Anda')" />
            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Kirim Permintaan ke Admin') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>