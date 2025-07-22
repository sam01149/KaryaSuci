<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Cabang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    {{-- Tombol Tambah akan kita fungsikan nanti --}}
                    <a href="#" class="inline-block mb-4 px-4 py-2 bg-karyasuci-primary text-white rounded-md text-sm font-semibold">Tambah Cabang Baru</a>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                       <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Cabang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alamat</th>
                                <th class="relative px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                            @foreach ($branches as $branch)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $branch->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $branch->address ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>