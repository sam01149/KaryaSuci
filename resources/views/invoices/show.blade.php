<x-app-layout>
     <div x-data="{ photoModalOpen: false, photoModalSrc: '' }">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Tagihan #') }}{{ $invoice->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 transition ease-in-out duration-150">
    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    Kembali
</a>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Tagihan</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format($invoice->total_due, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Sudah Dibayar</p>
                        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($invoice->amount_paid, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Sisa Tagihan</p>
                        <p class="text-2xl font-bold text-red-600">Rp {{ number_format($invoice->total_due - $invoice->amount_paid, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            @if($invoice->payment_status != 'Lunas')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <form action="{{ route('invoices.store_installment', $invoice->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    <h3 class="text-lg font-semibold mb-4">Tambah Pembayaran</h3>
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="amount" value="Jumlah Pembayaran (Rp)" />
                            <x-text-input id="amount" name="amount" type="number" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="receipt_photo" value="Bukti Bayar" />
                            <input id="receipt_photo" name="receipt_photo" type="file" class="mt-1 block w-full text-sm" required>
                        </div>
                    </div>
                    <div class="mt-4">
                        <x-input-label for="notes" value="Catatan (Opsional)" />
                        <textarea id="notes" name="notes" rows="2" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm"></textarea>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <x-primary-button>Simpan Pembayaran</x-primary-button>
                    </div>
                </form>
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Riwayat Pembayaran</h3>
                    <div class="space-y-4">
                        @forelse($invoice->installmentPayments as $payment)
                         
                            <div class="border-b dark:border-gray-700 pb-3">
                                <div class="flex justify-between items-start">
                                    {{-- Bagian Kiri: Gambar & Detail --}}
                                    <div class="flex items-start space-x-4">
                                        <img @click="photoModalOpen = true; photoModalSrc = '{{ asset('storage/' . $payment->receipt_photo_path) }}'"
                                            src="{{ asset('storage/' . $payment->receipt_photo_path) }}" 
                                            alt="Bukti Bayar" 
                                            class="w-16 h-16 object-cover rounded-md cursor-pointer hover:scale-105 transition">
                                        
                                        <div>
                                            <p class="font-semibold text-lg text-gray-800 dark:text-gray-200">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                            <p class="text-xs text-gray-500">Dicatat oleh {{ $payment->cashier->name }}</p>
                                        </div>
                                    </div>
                                    
                                    {{-- Bagian Kanan: Waktu --}}
                                    <p class="text-sm text-gray-500">{{ $payment->created_at->format('d M Y, H:i') }}</p>
                                </div>

                                {{-- PERBAIKAN DI SINI: Blok catatan sekarang ditempatkan di bawah --}}
                                @if($payment->notes)
                                    <div class="mt-2 pl-20"> {{-- pl-20 untuk membuatnya sejajar dengan teks di atas --}}
                                        <p class="text-xs text-gray-500 italic">
                                            <span class="font-semibold">Catatan:</span> "{{ $payment->notes }}"
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada riwayat pembayaran (cicilan).</p>
                        @endforelse
                    </div>
                </div>
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