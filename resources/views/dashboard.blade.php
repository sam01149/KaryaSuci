<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">Semoga harimu menyenangkan di Klinik Karya Suci.</p>
                            {{-- Anda bisa menambahkan statistik ringkas di sini --}}
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-center text-gray-800 dark:text-gray-200">{{ $monthName }}</h4>
                            <div class="grid grid-cols-7 gap-2 mt-4 text-center text-sm">
                                @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                                    <div class="font-semibold text-gray-500">{{ $day }}</div>
                                @endforeach

                                @for ($i = 0; $i < $startOfMonth; $i++)
                                    <div></div>
                                @endfor

                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    <div class="{{ $day == now()->day ? 'bg-karyasuci-primary text-white rounded-full' : 'text-gray-700 dark:text-gray-300' }}">
                                        {{ $day }}
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>