<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{-- Perubahan 1: Judul Halaman --}}
            {{ __('Edit Pegawai: ') }} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Perubahan 2: Form Action dan Method --}}
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            {{-- Perubahan 3: Isi value dengan data lama --}}
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="phone_number" :value="__('Nomor Telepon')" />
                            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number', $user->phone_number)" required />
                            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="role" :value="__('Role / Jabatan')" />
                            <select id="role" name="role" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                {{-- Pilih role yang sesuai dengan data user --}}
                                <option value="Manajer" @selected(old('role', $user->role) == 'Manajer')>Manajer</option>
                                <option value="Resepsionis" @selected(old('role', $user->role) == 'Resepsionis')>Resepsionis</option>
                                <option value="Fisioterapis" @selected(old('role', $user->role) == 'Fisioterapis')>Fisioterapis</option>
                                <option value="Kasir" @selected(old('role', $user->role) == 'Kasir')>Kasir</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="branch_id" :value="__('Cabang Penempatan')" />
                            <select id="branch_id" name="branch_id" class="block mt-1 w-full ...">
                                <option value="">-- Pilih Cabang --</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" @selected(old('branch_id', $user->branch_id) == $branch->id)>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('branch_id')" class="mt-2" />
                        </div>
                        {{-- Perubahan 4: Password menjadi opsional --}}
                        <hr class="my-6 border-gray-200 dark:border-gray-700">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Isi bagian password hanya jika Anda ingin mengubahnya.</p>

                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password Baru')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <x-primary-button class="ml-4">
                                {{ __('Update Pegawai') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>