{{-- File: resources/views/manager/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dasbor Manajer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Pendapatan Hari Ini</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">Rp {{ number_format($revenueToday, 2, ',', '.') }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Pendapatan Bulan Ini</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">Rp {{ number_format($revenueThisMonth, 2, ',', '.') }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Total Pasien Hari Ini</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $patientsToday }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Pasien Baru Bulan Ini</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $newPatientsThisMonth }}</p>
                </div>

                 <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Tipe Pasien Hari Ini</h3>
                    <div class="flex space-x-4 mt-2">
                         <p class="text-xl font-semibold text-gray-900 dark:text-white">Umum: {{ $patientTypeToday['Umum'] ?? 0 }}</p>
                         <p class="text-xl font-semibold text-gray-900 dark:text-white">Paket: {{ $patientTypeToday['Paket'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mb-4">Riwayat Penjualan Obat & Alat</h3>
                    {{-- AWAL FORM FILTER BARU --}}
        <form method="GET" action="{{ route('manager.dashboard') }}" class="mb-4">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="branch_id" class="text-sm">Filter Cabang</label>
                    <select name="branch_id" id="branch_id" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm text-sm">
                        <option value="">Semua Cabang</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" @selected(request('branch_id') == $branch->id)>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="product_type" class="text-sm">Filter Tipe Produk</label>
                    <select name="product_type" id="product_type" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm text-sm">
                        <option value="">Semua Tipe</option>
                        <option value="Obat" @selected(request('product_type') == 'Obat')>Obat</option>
                        <option value="Alat" @selected(request('product_type') == 'Alat')>Alat</option>
                    </select>
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="w-full inline-flex justify-center py-2 px-4 bg-karyasuci-primary text-white rounded-md text-sm font-semibold">Filter</button>
                    <a href="{{ route('manager.dashboard') }}" class="w-full inline-flex justify-center py-2 px-4 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded-md text-sm">Reset</a>
                </div>
            </div>
        </form>
        {{-- AKHIR FORM FILTER BARU --}}

                    <div class="overflow-x-auto">
                                                <table class="min-w-full">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kasir</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                {{-- Kita akan menggunakan nested loop (perulangan di dalam perulangan) --}}
                                @forelse ($productSales as $sale)
                                    @foreach($sale->items as $item)
                                        {{-- Setiap item akan mendapatkan barisnya sendiri --}}
                                        <tr class="{{ !$loop->first ? 'border-t-0' : '' }}">
                                            {{-- Tampilkan Tanggal, Pasien, dan Kasir hanya untuk item pertama --}}
                                            @if ($loop->first)
                                                <td class="px-4 py-2 whitespace-nowrap text-sm" rowspan="{{ $sale->items->count() }}">{{ $sale->created_at->format('d M, H:i') }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm font-medium" rowspan="{{ $sale->items->count() }}">{{ $sale->patient->name ?? 'N/A' }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm" rowspan="{{ $sale->items->count() }}">{{ $sale->cashier->name ?? 'N/A' }}</td>
                                            @endif
                                            
                                            {{-- Detail per item --}}
                                            <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $item->product_name }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->product_type == 'Obat' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ $item->product_type }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-center">{{ $item->quantity }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    {{-- Baris untuk Total per Transaksi --}}
                                    <tr class="bg-gray-50 dark:bg-gray-700/50">
                                        <td colspan="6" class="px-4 py-2 whitespace-nowrap text-sm font-semibold text-right">Total Transaksi</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-semibold">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center py-4 text-sm text-gray-500">Belum ada penjualan produk.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- SCRIPT UNTUK MENGGAMBAR GRAFIK --}}
   
</x-app-layout>