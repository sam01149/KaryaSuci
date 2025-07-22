<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manajemen Pegawai') }}
            </h2>
            {{-- Tombol ini akan kita fungsikan nanti --}}
            <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-karyasuci-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-80">
                Tambah Pegawai Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No. Telepon</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                                    {{-- TAMBAHKAN HEADER CABANG --}}
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cabang</th>
                                    <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->phone_number ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->role }}</td>
                                        {{-- TAMBAHKAN DATA CABANG --}}
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->branch->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('users.edit', $user->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">Edit</a>
                                            <form class="inline-block ml-4" action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pegawai ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-500 dark:hover:text-red-700 font-medium">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>   
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">Tidak ada data pegawai.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>