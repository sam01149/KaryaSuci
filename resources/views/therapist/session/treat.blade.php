{{-- File: resources/views/therapist/session/treat.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Sesi Perawatan: {{ $session->patient->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Kolom Kiri: Form Rekam Medis --}}
            <div class="md:col-span-2">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Catatan Sesi Hari Ini</h3>
                        <form action="{{ route('therapist.session.finish', $session->id) }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="assessment" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Asesmen</label>
                                    <textarea id="assessment" name="assessment" rows="5" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required>{{ old('assessment') }}</textarea>
                                </div>
                                <div>
                                    <label for="diagnosis" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Diagnosis</label>
                                    <textarea id="diagnosis" name="diagnosis" rows="3" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required>{{ old('diagnosis') }}</textarea>
                                </div>
                                <div>
                                    <label for="treatment_plan" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Rencana Terapi</label>
                                    <textarea id="treatment_plan" name="treatment_plan" rows="5" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required>{{ old('treatment_plan') }}</textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500">
                                        Simpan & Selesaikan Sesi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Riwayat Rekam Medis --}}
            <div class="md:col-span-1">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                     <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Riwayat Kunjungan</h3>
                        <div class="space-y-4">
                        @forelse($pastRecords as $record)
                            <div class="border-b pb-2">
                                <p class="font-semibold">{{ $record->created_at->format('d F Y') }}</p>
                                <p class="text-sm"><strong>Diagnosis:</strong> {{ $record->diagnosis }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada riwayat kunjungan.</p>
                        @endforelse
                        </div>
                     </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>