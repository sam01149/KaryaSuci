{{-- File: resources/views/therapist/queue/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Antrian Pasien Hari Ini
        </h2>
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
                    <div class="space-y-4">
                        @forelse($sessions as $session)
                            <div class="flex items-center justify-between p-4 border rounded-lg dark:border-gray-700">
                                <div>
                                    <p class="font-bold text-lg">{{ $session->patient->name }} <span class="text-sm font-normal text-gray-500 dark:text-gray-400">(Kunjungan ke-{{$session->visit_number}})</span></p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Waktu Kedatangan: {{ $session->created_at->format('H:i') }}</p>
                                </div>
                                <a href="{{ route('therapist.session.treat', $session->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700">
                                    Layani Pasien
                                </a>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">Belum ada pasien dalam antrian.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>