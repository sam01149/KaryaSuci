{{-- File: resources/views/cashier/products/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Pesan & Catat Penjualan Obat / Alat
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if ($message = Session::get('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('cashier.products.store') }}" method="POST" class="space-y-6"  enctype="multipart/form-data">
                        @csrf
                        <div>
                            <x-input-label for="patient_id" value="Pilih Pasien" />
                            <select id="patient_id" name="patient_id" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Pasien --</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="product_type" value="Tipe Produk" />
                                <select id="product_type" name="product_type" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm" required>
                                    <option value="Obat">Obat</option>
                                    <option value="Alat">Alat</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="product_name" value="Nama Obat / Alat" />
                                <x-text-input id="product_name" name="product_name" type="text" class="mt-1 block w-full" placeholder="Nama item..." required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="quantity" value="Jumlah" />
                                <x-text-input id="quantity" name="quantity" type="number" class="mt-1 block w-full" value="1" required />
                            </div>
                            <div>
                                <x-input-label for="total_price" value="Total Harga" />
                                <x-text-input id="total_price" name="total_price" type="number" class="mt-1 block w-full" placeholder="Rp" required />
                            </div>
                        </div>
                            {{-- TAMBAHKAN BLOK INPUT FILE INI --}}
                        <div class="mt-4">
                            <x-input-label for="receipt_photo" :value="__('Bukti Pembayaran')" />
                            <input id="receipt_photo" name="receipt_photo" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-karyasuci-primary file:text-white hover:file:bg-opacity-80" required>
                            <x-input-error class="mt-2" :messages="$errors->get('receipt_photo')" />
                        </div>
                        {{-- AKHIR BLOK INPUT FILE --}}
                        <div class="flex items-center justify-end">
                            <x-primary-button>
                                Simpan Penjualan
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>