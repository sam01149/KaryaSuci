<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2 sm:mb-0">
                {{ __('Detail Pasien: ') . $patient->name }}
            </h2>
            
            {{-- MENAMPILKAN NOMOR KUNJUNGAN & STATUS PROGRAM --}}
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                    Total Kunjungan: {{ $patient->treatmentSessions->count() }}
                </span>
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $patient->program_status == 'Paket' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                    Program: {{ $patient->program_status }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- INFORMASI DASAR PASIEN --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                     <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Data Diri Pasien</h3>
                        <a href="{{ route('patients.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                            &larr; Kembali ke Daftar Pasien
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t dark:border-gray-700 pt-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $patient->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Kontak</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $patient->contact_number ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Lahir</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->isoFormat('D MMMM Y') : '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Kelamin</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $patient->gender ?: '-' }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $patient->address ?: '-' }}</dd>
                        </div>
                         <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Registrasi</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $patient->created_at->isoFormat('D MMMM Y, HH:mm') }}</dd>
                        </div>
                    </div>

                    @if(in_array(Auth::user()->role, ['Admin', 'Manajer']))
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                         <a href="{{ route('patients.edit', $patient->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Edit Data Pasien
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- RIWAYAT KUNJUNGAN & FOTO BUKTI --}}
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Riwayat Kunjungan & Bukti Kehadiran</h3>
                    <div class="space-y-6">
                        @forelse($patient->treatmentSessions()->latest()->get() as $session)
                            <div class="border-b dark:border-gray-700 pb-4 flex flex-col sm:flex-row items-start sm:space-x-4">
                                @if($session->patient_photo_path)
                                    <a href="{{ asset('storage/' . $session->patient_photo_path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $session->patient_photo_path) }}" alt="Foto bukti check-in" class="w-full sm:w-32 h-auto rounded-md object-cover mb-2 sm:mb-0 hover:opacity-80 transition-opacity">
                                    </a>
                                @else
                                    <div class="w-full sm:w-32 h-32 rounded-md bg-gray-200 dark:bg-gray-700 flex items-center justify-center mb-2 sm:mb-0">
                                        <span class="text-xs text-gray-500">No Photo</span>
                                    </div>
                                @endif
                                <div class="flex-grow">
                                    <p class="font-bold text-lg">Kunjungan ke-{{ $session->visit_number }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Tanggal: {{ \Carbon\Carbon::parse($session->session_date)->isoFormat('dddd, D MMMM Y') }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Status: <span class="font-semibold">{{ $session->status }}</span></p>
                                    
                                    {{-- Menampilkan Detail Rekam Medis Jika Ada --}}
                                    @if($session->medicalRecord)
                                    <div class="mt-2 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-md">
                                        <p class="text-xs font-bold uppercase text-gray-500">Catatan Fisioterapis</p>
                                        <p class="text-sm mt-1"><strong>Diagnosis:</strong> {{ $session->medicalRecord->diagnosis }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p>Belum ada riwayat kunjungan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>