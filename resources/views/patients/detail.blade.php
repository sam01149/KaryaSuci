<x-app-layout>
    {{-- Kita definisikan Alpine.js di sini untuk mengontrol modal foto --}}
    <div x-data="{ photoModalOpen: false, photoModalSrc: '' }">
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Detail Arsip Pasien: {{ $patient->name }}
                </h2>
                <a href="{{ route('patients.print.pdf', $patient->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
                    Cetak Arsip
                </a>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 h-fit">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Pasien</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">No. Induk</p>
                            <p class="font-semibold">{{ $patient->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Lengkap</p>
                            <p class="font-semibold">{{ $patient->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tanggal Registrasi</p>
                            <p class="font-semibold">{{ $patient->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tanggal Lahir</p>
                            <p class="font-semibold">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d M Y') }}</p>
                        </div>
                         <div>
                            <p class="text-sm font-medium text-gray-500">Jenis Kelamin</p>
                            <p class="font-semibold">{{ $patient->gender }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nomor Kontak</p>
                            <p class="font-semibold">{{ $patient->contact_number ?? '-' }}</p>
                        </div>
                        <div class="col-span-full">
                            <p class="text-sm font-medium text-gray-500">Alamat</p>
                            <p class="font-semibold whitespace-pre-wrap">{{ $patient->address ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Program</p>
                            <p class="font-semibold">{{ $patient->program_status }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Cabang</p>
                            <p class="font-semibold">{{ $patient->branch->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Riwayat Kunjungan & Dokumentasi</h3>
                    <div class="space-y-4">
                        @forelse ($patient->treatmentSessions as $session)
                            <div class="border dark:border-gray-700 rounded-lg p-4 flex items-start space-x-4">
                                {{-- FOTO SEKARANG BISA DIKLIK --}}
                                @if($session->patient_photo_path)
                                <img 
                                    @click="photoModalOpen = true; photoModalSrc = '{{ asset('storage/' . $session->patient_photo_path) }}'"
                                    src="{{ asset('storage/' . $session->patient_photo_path) }}" 
                                    alt="Foto Kunjungan" 
                                    class="w-24 h-24 object-cover rounded-md cursor-pointer hover:opacity-80 transition">
                                @endif
                                <div>
                                    <p class="font-bold">Kunjungan Ke-{{ $session->visit_number }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Tanggal: {{ $session->session_date->format('d M Y') }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Status Sesi: {{ $session->status }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">Belum ada riwayat kunjungan.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

        <div x-show="photoModalOpen" @keydown.escape.window="photoModalOpen = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75" x-cloak>
            <div @click.away="photoModalOpen = false" class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl p-4 w-full max-w-2xl">
                <img :src="photoModalSrc" alt="Foto Kunjungan" class="w-full h-auto object-contain max-h-[80vh]">
                <button @click="photoModalOpen = false" class="absolute top-0 right-0 mt-2 mr-2 text-white bg-black bg-opacity-50 rounded-full p-1 hover:bg-opacity-75">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>
</x-app-layout>