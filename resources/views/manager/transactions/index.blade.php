<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Laporan Seluruh Transaksi') }}
            </h2>
            {{-- TOMBOL BARU --}}
            <a href="{{ route('manager.transactions.print') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
                Cetak PDF
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal & Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kasir</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Keterangan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($invoices as $invoice)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer" onclick="window.location.href='{{ route('invoices.show', $invoice->id) }}';">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $invoice->created_at->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $invoice->patient->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $invoice->cashier->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if ($invoice->treatment_session_id)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    Sesi Perawatan
                                                </span>
                                            @elseif ($invoice->sale)
                                                <div class="flex flex-col space-y-1">
                                                    @foreach($invoice->sale->items as $item)
                                                        <div class="flex items-center">
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                                {{ $item->product_type == 'Obat' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                                                {{ $item->product_type }}
                                                            </span>
                                                            <span class="ml-2 text-xs text-gray-600 dark:text-gray-400">
                                                                {{ $item->product_name }} (x{{$item->quantity}})
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span>Lainnya</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                            Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">Tidak ada data transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>