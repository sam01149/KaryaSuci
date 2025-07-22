{{-- File: resources/views/patients/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftarkan Pasien Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong>Whoops!</strong> Ada masalah dengan input Anda.
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('patients.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                                <input type="text" name="name" id="name" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" value="{{ old('name') }}" required>
                            </div>

                            <div>
                                <label for="contact_number" class="block font-medium text-sm text-gray-700 dark:text-gray-300">No. Kontak</label>
                                <input type="text" name="contact_number" id="contact_number" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" value="{{ old('contact_number') }}">
                            </div>

                            <div>
                                <label for="date_of_birth" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tanggal Lahir</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" value="{{ old('date_of_birth') }}">
                            </div>

                            <div>
                                <label for="gender" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Jenis Kelamin</label>
                                <select name="gender" id="gender" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="Laki-laki" @if(old('gender') == 'Laki-laki') selected @endif>Laki-laki</option>
                                    <option value="Perempuan" @if(old('gender') == 'Perempuan') selected @endif>Perempuan</option>
                                </select>
                            </div>

                             <div>
                                <label for="address" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Alamat</label>
                                <textarea name="address" id="address" rows="4" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('address') }}</textarea>
                            </div>
                            <div class="mt-4">
                                <x-input-label for="branch_id" :value="__('Cabang Pendaftaran')" />
                                <select id="branch_id" name="branch_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                    <option value="">-- Pilih Cabang --</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('branch_id')" class="mt-2" />
                            </div>
                                                        <div class="flex items-center justify-end mt-4">
                                <a href="{{ route('patients.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                    Batal
                                </a>
                                <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>