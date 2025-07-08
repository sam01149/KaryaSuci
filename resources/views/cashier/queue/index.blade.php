{{-- File: resources/views/cashier/queue/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Antrian Pembayaran') }}
            </h2>
            {{-- TAMBAHKAN INI --}}
            <a href="{{ route('cashier.history.index') }}" class="text-sm font-medium text-blue-600 hover:underline">
                Lihat Riwayat Hari Ini &rarr;
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($message = Session::get('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="space-y-6">
                        @forelse($sessions as $session)
                            <div class="p-4 border rounded-lg dark:border-gray-700" x-data="{ open: false }">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-lg">{{ $session->patient->name }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Selesai: {{ $session->updated_at->format('H:i') }} | Terapis: {{ $session->therapist->name ?? 'N/A' }}</p>
                                        <span class="px-2 py-1 mt-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $session->patient->program_status == 'Paket' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                            Program: {{ $session->patient->program_status }}
                                        </span>
                                    </div>
                                    <button @click="open = !open" class="text-sm text-blue-600 hover:underline">
                                        <span x-show="!open">Tampilkan Detail</span>
                                        <span x-show="open">Sembunyikan Detail</span>
                                    </button>
                                </div>
                                
                                {{-- Detail yang bisa di-toggle --}}
                                <div x-show="open" x-transition class="mt-4 pt-4 border-t dark:border-gray-600">
                                    {{-- Detail Rekam Medis --}}
                                    @if($session->medicalRecord)
                                        <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-md">
                                            <h4 class="font-semibold">Ringkasan Penanganan:</h4>
                                            <p class="text-sm"><strong>Asesmen:</strong> {{ $session->medicalRecord->assessment }}</p>
                                            <p class="text-sm"><strong>Diagnosis:</strong> {{ $session->medicalRecord->diagnosis }}</p>
                                            <p class="text-sm"><strong>Penanganan:</strong> {{ $session->medicalRecord->treatment_plan }}</p>
                                        </div>
                                    @endif

                                    {{-- Form Pembayaran --}}
                                    <form action="{{ route('cashier.session.pay', $session->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                        @csrf
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label for="amount_{{$session->id}}" class="block text-sm font-medium">Jumlah Bayar</label>
                                                <input type="number" id="amount_{{$session->id}}" name="amount" placeholder="Rp" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm" required>
                                            </div>
                                            <div>
                                                <label for="payment_type_{{$session->id}}" class="block text-sm font-medium">Tipe Sesi</label>
                                                <select id="payment_type_{{$session->id}}" name="payment_type" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm">
                                                    <option value="Umum">Umum</option>
                                                    <option value="Paket">Paket</option>
                                                </select>
                                            </div>
                                             <div>
                                                <label for="receipt_photo_{{$session->id}}" class="block text-sm font-medium">Upload Bukti Bayar</label>
                                                <input type="file" id="receipt_photo_{{$session->id}}" name="receipt_photo" class="mt-1 block w-full text-sm" required>
                                            </div>
                                        </div>
                                        
                                        {{-- Opsi Daftar Program Paket --}}
                                        <div class="mt-4 p-4 border-t dark:border-gray-600" x-data="{ registerProgram: false }">
                                            <label class="flex items-center">
                                                <input type="checkbox" name="register_program" x-model="registerProgram" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm">
                                                <span class="ms-2 text-sm">Daftarkan/Perbarui Program Paket untuk pasien ini?</span>
                                            </label>
                                            <div x-show="registerProgram" class="mt-4 space-y-4">
                                                <input type="hidden" name="program_status" value="Paket">
                                                <div>
                                                    <label for="program_proof_photo_{{$session->id}}" class="block text-sm font-medium">Upload Bukti Program Paket</label>
                                                    <input type="file" id="program_proof_photo_{{$session->id}}" name="program_proof_photo" class="mt-1 block w-full text-sm">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex justify-end">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500">
                                                Proses & Selesaikan Pembayaran
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">Belum ada pasien yang menunggu pembayaran.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>