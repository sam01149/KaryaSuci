<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transaksi Penjualan Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Form Pencarian Pasien --}}
                    <div class="px-5 mb-2 max-w-xl">
                        <form method="GET" action="{{ route('cashier.sales.create') }}">
                            <label for="search" class="block font-semibold text-m text-black dark:text-black">Cari Nama atau ID Pasien</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" name="search" id="search" class="flex-1 block w-full rounded-none rounded-l-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" placeholder="Ketik nama lalu tekan Cari..." value="{{ request('search') }}" required>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-700 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest">
                                    Cari
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Form Utama Penjualan --}}
                    <form method="POST" action="{{ route('cashier.sales.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if ($errors->any())
                            {{-- ... blok error validasi ... --}}
                        @endif

                        {{-- Hasil Pencarian Pasien (Tempat Memilih Pasien) --}}
                        @if(request('search'))
                            @if($patients->count() > 0)
                                <div class="px-6 space-y-3 mb-6">
                                    <h3 class="font-semibold">Pilih Pasien dari Hasil Pencarian:</h3>
                                    @foreach ($patients as $patient)
                                        <label for="patient_{{ $patient->id }}" class="flex items-center p-3 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                            <input type="radio" id="patient_{{ $patient->id }}" name="patient_id" value="{{ $patient->id }}" class="h-4 w-4 text-karyasuci-primary focus:ring-karyasuci-primary border-gray-300">
                                            <div class="ml-4">
                                                <span class="font-medium">{{ $patient->name }}</span>
                                                <span class="text-sm text-gray-500 dark:text-gray-400 block">Cabang: {{ $patient->branch->name ?? 'N/A' }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                    <x-input-error :messages="$errors->get('patient_id')" class="mt-2" />
                                </div>
                            @else
                                <p class="text-center text-gray-500 mb-6">Pasien tidak ditemukan.</p>
                            @endif
                        @endif
                <div x-data="{
                    items: [{ product_name: '', product_type: 'Obat', quantity: 1, price: 0 }],
                    addItem() {
                        this.items.push({ product_name: '', product_type: 'Obat', quantity: 1, price: 0 });
                    },
                    removeItem(i) {
                        if (this.items.length > 1) {
                            this.items.splice(i, 1);
                        }
                    },
                    get totalAmount() {
                        return this.items.reduce((total, item) => {
                            const quantity = parseInt(item.quantity) || 0;
                            const price = parseFloat(item.price) || 0;
                            return total + (quantity * price);
                        }, 0);
                    }
                }" class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('cashier.sales.store') }}" enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                                <strong class="font-bold">Oops! Terjadi kesalahan validasi.</strong>
                                <ul class="mt-2 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <hr class="my-4 border-gray-200 dark:border-gray-700">

                        <h3 class="font-semibold mb-4">Detail Item Penjualan</h3>

                        @verbatim
                        <div class="space-y-4">
                            <template x-for="(item, i) in items" :key="i">
                                <div class="flex items-start space-x-3 p-3 border rounded-md dark:border-gray-700">
                                    <div class="flex-grow grid grid-cols-1 sm:grid-cols-4 gap-3">
                                        <div class="sm:col-span-2">
                                            <label :for="'product_name_' + i" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Obat/Alat</label>
                                            <input :id="'product_name_' + i" :name="'items[' + i + '][product_name]'" x-model="item.product_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100" required>
                                        </div>

                                        <div>
                                            <label :for="'product_type_' + i" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe</label>
                                            <select :id="'product_type_' + i" :name="'items[' + i + '][product_type]'" x-model="item.product_type" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                                <option value="Obat">Obat</option>
                                                <option value="Alat">Alat</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label :for="'quantity_' + i" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah</label>
                                            <input :id="'quantity_' + i" :name="'items[' + i + '][quantity]'" x-model.number="item.quantity" type="number" min="1" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100" required>
                                        </div>

                                        <div class="sm:col-span-4">
                                            <label :for="'price_' + i" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Satuan (Rp)</label>
                                            <input :id="'price_' + i" :name="'items[' + i + '][price]'" x-model.number="item.price" type="number" min="0" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100" required>
                                        </div>
                                    </div>
                                    <div class="pt-6">
                                        <button @click.prevent="removeItem(i)" type="button" class="text-red-500 hover:text-red-700" x-show="items.length > 1">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-4">
                            <button @click.prevent="addItem()" type="button" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline font-semibold">+ Tambah Item Lainnya</button>
                        </div>
                        
                        @endverbatim

                        <hr class="my-6 border-gray-200 dark:border-gray-700">
                            {{-- TAMBAHKAN BLOK INI --}}
                            <div class="mb-6">
                                <label for="notes" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Catatan (Opsional)</label>
                                <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                            </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="receipt_photo" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Upload Bukti Pembayaran</label>
                                <input id="receipt_photo" name="receipt_photo" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-karyasuci-primary file:text-white hover:file:bg-opacity-80" required>
                                @error('receipt_photo')
                                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="text-right">
                                <p class="text-gray-500 dark:text-gray-400">Total Transaksi</p>
                                <p class="text-3xl font-bold" x-text="new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(totalAmount)"></p>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md shadow-sm">
                                Simpan Transaksi
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
