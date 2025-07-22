<x-app-layout>
    {{-- Kita definisikan Alpine.js di sini untuk mengontrol modal foto --}}
    <div x-data="{ photoModalOpen: false, photoModalSrc: '' }">
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Manajemen Invoices') }}
                </h2>
                <a href="{{ route('invoices.print.pdf') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
                    Cetak PDF
                </a>
            </div>
        </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="GET" action="{{ route('invoices.index') }}" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
                                <input type="date" name="start_date" id="start_date" value="{{ request('start_date', today()->toDateString()) }}" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date', today()->toDateString()) }}" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm">
                            </div>
                            <div class="hidden lg:block lg:col-span-2"></div>

                                    {{-- Tombol Aksi --}}
                                    <div class="flex space-x-2">
                                        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 bg-karyasuci-primary text-white rounded-md text-sm font-semibold">Filter</button>
                                        <a href="{{ route('invoices.index') }}" class="w-full inline-flex justify-center py-2 px-4 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded-md text-sm">Reset</a>
                                    </div>
                        </div>
                    </form>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pasien</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Waktu</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Keterangan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status Bayar</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah Tagihan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bukti Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($invoices as $invoice)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer" >
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            <a href="{{ route('invoices.show', $invoice->id) }}" class="hover:underline">
                                                {{ $invoice->patient->name ?? 'N/A' }}
                                            </a>
                                        </td> 
                                        {{-- 1. Kolom Waktu --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $invoice->created_at->format('d M Y, H:i') }} {{-- Format diubah --}}

                                        </td>

                                        {{-- 2. Kolom Pasien --}}
                                       
                                        
                                        {{-- 3. Kolom Keterangan (Dibuat Lebih Detail) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if ($invoice->treatment_session_id)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    Sesi Perawatan
                                                </span>
                                            @elseif ($invoice->sale)
                                                <div class="flex flex-col">
                                                    @foreach($invoice->sale->items as $item)
                                                        <div class="text-xs text-gray-600 dark:text-gray-400">
                                                            - {{ $item->product_name }} (x{{$item->quantity}})
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span>Lainnya</span>
                                            @endif
                                        </td>

                                        {{-- 4. Kolom Status Bayar --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($invoice->payment_status == 'Lunas') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @elseif($invoice->payment_status == 'Cicilan') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                                {{ $invoice->payment_status }}
                                            </span>
                                        </td>

                                        {{-- 5. Kolom Jumlah Tagihan --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">
                                            Rp {{ number_format($invoice->total_due, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @php
                                                    // Ambil path foto dari cicilan terbaru, atau dari invoice itu sendiri
                                                    $photoPath = $invoice->installmentPayments->first()->receipt_photo_path ?? $invoice->receipt_photo_path;
                                                @endphp

                                                @if($photoPath)
                                                    <img 
                                                        @click="photoModalOpen = true; photoModalSrc = '{{ asset('storage/' . $photoPath) }}'"
                                                        src="{{ asset('storage/' . $photoPath) }}" 
                                                        alt="Bukti Bayar" 
                                                        class="w-10 h-10 object-cover rounded-md cursor-pointer hover:scale-110 transition">
                                                @else
                                                    -
                                                @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">Belum ada transaksi hari ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div x-show="photoModalOpen" @keydown.escape.window="photoModalOpen = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75" x-cloak>
            <div @click.away="photoModalOpen = false" class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl p-4 w-full max-w-2xl">
                <img :src="photoModalSrc" alt="Bukti Pembayaran" class="w-full h-auto object-contain max-h-[80vh]">
                <button @click="photoModalOpen = false" class="absolute top-0 right-0 mt-2 mr-2 text-white bg-black bg-opacity-50 rounded-full p-1 hover:bg-opacity-75">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>
</x-app-layout>