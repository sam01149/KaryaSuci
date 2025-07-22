<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Antrian Tagihan & Konfirmasi') }}
            </h2>
            <a href="{{ route('invoices.index') }}" class="text-sm font-medium text-karyasuci-primary hover:underline">
                Lihat Manajemen Invoices &rarr;
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="space-y-6">
                        @forelse($sessions as $session)
                            {{-- Cek apakah ini adalah pasien paket yang sedang dalam sesi lanjutan --}}
                            @php
                                $isPackageContinuation = ($session->patient->program_status == 'Paket' && $session->patient->is_package_active);
                            @endphp

                            <div class="p-4 border rounded-lg dark:border-gray-700" x-data="{ open: false }">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-lg">{{ $session->patient->name }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            @if($isPackageContinuation)
                                                Sisa Sesi: <strong>{{ $session->patient->package_sessions_remaining }}</strong> dari <strong>{{ $session->patient->package_total_sessions }}</strong>
                                            @else
                                                Kunjungan Ke-{{ $session->visit_number }}
                                            @endif
                                            | Terapis: {{ $session->therapist->name ?? 'N/A' }}
                                        </p>
                                        <span class="px-2 py-1 mt-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $session->patient->program_status == 'Paket' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                            Program: {{ $session->patient->program_status }}
                                        </span>
                                    </div>
                                    <button @click="open = !open" class="text-sm font-semibold text-karyasuci-primary hover:underline">
                                        <span x-show="!open">{{ $isPackageContinuation ? 'Lihat Detail' : 'Proses Tagihan' }}</span>
                                        <span x-show="open">Sembunyikan</span>
                                    </button>
                                </div>
                                
                                <div x-show="open" x-transition class="mt-4 pt-4 border-t dark:border-gray-600">
                                    @if($session->medicalRecord)
                                        <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-md">
                                            <h4 class="font-semibold text-base">Ringkasan Penanganan:</h4>
                                            <p class="text-sm"><strong>Asesmen:</strong> {{ $session->medicalRecord->assessment }}</p>
                                            <p class="text-sm"><strong>Diagnosis:</strong> {{ $session->medicalRecord->diagnosis }}</p>
                                            <p class="text-sm"><strong>Rencana Terapi:</strong> {{ $session->medicalRecord->treatment_plan }}</p>
                                        </div>
                                    @endif

                                    {{-- Tampilkan form pembuatan tagihan HANYA jika bukan pasien paket lanjutan --}}
                                    @if(!$isPackageContinuation)
                                        <form action="{{ route('cashier.session.pay', $session->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4" x-data="{ paymentType: 'Umum' }">
                                            @csrf
                                            {{-- ... (blok error) ... --}}
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label for="amount_{{$session->id}}" class="block text-sm font-medium">Harga Terapi / Paket</label>
                                                    <input type="number" id="amount_{{$session->id}}" name="amount" placeholder="Rp" class="mt-1 block w-full dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-md shadow-sm" required>
                                                </div>
                                                <div>
                                                    <label for="payment_type_{{$session->id}}" class="block text-sm font-medium">Tipe Sesi</label>
                                                    <select id="payment_type_{{$session->id}}" name="payment_type" x-model="paymentType" class="mt-1 block w-full dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-md shadow-sm">
                                                        <option value="Umum">Umum</option>
                                                        <option value="Paket">Paket</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div x-show="paymentType === 'Paket'" x-transition class="pt-4 border-t dark:border-gray-600">
                                                <p class="text-sm font-semibold mb-2">Detail Pendaftaran Program Paket</p>
                                                <div>
                                                    <label for="package_total_sessions_{{$session->id}}" class="block text-sm font-medium">Jumlah Sesi Paket</label>
                                                    <input type="number" id="package_total_sessions_{{$session->id}}" name="package_total_sessions" placeholder="Contoh: 10" class="mt-1 block w-full dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-md shadow-sm">
                                                </div>
                                                <div class="mt-4">
                                                    <label for="program_proof_photo_{{$session->id}}" class="block text-sm font-medium">Upload Bukti Persetujuan</label>
                                                    <input type="file" id="program_proof_photo_{{$session->id}}" name="program_proof_photo" class="mt-1 block w-full text-sm">
                                                </div>
                                            </div>

                                            <div class="flex justify-end pt-4">
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-karyasuci-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-80">                                                   Buat Tagihan
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        {{-- Tampilan untuk konfirmasi pasien paket lanjutan --}}
                                        <div class="text-center">
                                            <p class="mb-4">Pasien ini sedang dalam program paket. Tidak ada tagihan baru yang perlu dibuat untuk sesi ini.</p>
                                            <form action="{{ route('cashier.session.confirm', $session->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-karyasuci-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-80">
                                                    Konfirmasi Kunjungan
                                                </button>
                                                
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">Tidak ada antrian saat ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>