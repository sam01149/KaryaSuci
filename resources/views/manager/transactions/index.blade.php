{{-- File: resources/views/manager/transactions/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Laporan Semua Transaksi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kasir</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bukti Bayar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bukti Program</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($invoices as $invoice)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $invoice->created_at->isoFormat('D MMM Y, HH:mm') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $invoice->patient->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $invoice->cashier->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $invoice->payment_type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($invoice->receipt_photo_path)
                                            <a href="{{ asset('storage/' . $invoice->receipt_photo_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Foto</a>
                                        @else - @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($invoice->patient->program_proof_photo_path)
                                             <a href="{{ asset('storage/' . $invoice->patient->program_proof_photo_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Foto</a>
                                        @else - @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="text-center py-4">Belum ada transaksi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $invoices->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>