<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Log Aktivitas Klinik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Area Filter --}}
                    <form method="GET" action="{{ route('activity-logs.index') }}" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            @if(in_array(Auth::user()->role, ['Admin', 'Manajer']))
                                <div>
                                    <label for="branch_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cabang</label>
                                    <select name="branch_id" id="branch_id" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm">
                                        <option value="">Semua Cabang</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" @selected(request('branch_id') == $branch->id)>{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
                                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm">
                            </div>
                            <div class="flex space-x-2">
                                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 bg-karyasuci-primary text-white rounded-md text-sm font-semibold">Filter</button>
                                <a href="{{ route('activity-logs.index') }}" class="w-full inline-flex justify-center py-2 px-4 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded-md text-sm">Reset</a>
                            </div>
                        </div>
                    </form>
                    {{-- Daftar Log Aktivitas --}}
                    <div class="space-y-8">
                        @forelse($groupedLogs as $date => $logsOnDate)
                            <div class="p-4 border rounded-lg dark:border-gray-700">
                                <h3 class="font-bold text-lg mb-2 border-b pb-2 dark:border-gray-600">{{ $date }}</h3>
                                <div class="space-y-2">
                                    @foreach($logsOnDate as $log)
                                        <div class="flex items-start">
                                            <span class="text-sm text-gray-500 dark:text-gray-400 w-20 shrink-0">[{{ $log->created_at->format('H:i') }}]</span>
                                            <p class="text-sm">{{ $log->description }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">Tidak ada aktivitas yang tercatat.</p>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>