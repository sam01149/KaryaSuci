<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Absensi Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if ($message = Session::get('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                         <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
                        <form action="{{ route('patients.index') }}" method="GET" class="w-full sm:w-1/2">
                            <div class="flex">
                                <input type="text" name="search" placeholder="Cari nama pasien..." class="w-full dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-l-md shadow-sm" value="{{ request('search') }}">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-700 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest">Cari</button>
                            </div>
                        </form>
                        <a href="{{ route('patients.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                            Daftarkan Pasien Baru
                        </a>
                    </div>

                   <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                {{-- TAMBAHKAN HEADER CABANG --}}
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cabang</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status Hari Ini</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse ($patients as $patient)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $loop->index + $patients->firstItem() }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $patient->name }}</td>
                
                {{-- TAMBAHKAN KOLOM DATA CABANG --}}
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    {{ $patient->branch ? $patient->branch->name : 'N/A' }}
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @if(in_array($patient->id, $checkedInPatientIds ?? []))
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Sudah Absen
                        </span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                            Belum Absen
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center space-x-4">
                        @if(!in_array($patient->id, $checkedInPatientIds ?? []))
                            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'checkin-modal-{{ $patient->id }}')"
                                class="text-green-600 hover:text-green-900 font-semibold">
                                Absen
                            </button>
                        @endif
                        <a href="{{ route('patients.print.pdf', $patient->id) }}"  class="text-gray-600 dark:text-gray-400 hover:underline">Print</a>
                        <a href="{{ route('patients.detail', $patient->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold">Detail</a>


                        {{-- Saya hapus 'delete_patients' Gate, ganti dengan 'delete-patient' sesuai yang kita buat --}}
                        @can('delete-patient')
                            <a href="{{ route('patients.edit', $patient->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Edit</a>
                            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Menghapus pasien ini akan menghapus semua data terkait. Anda yakin?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                            </form>
                        @endcan
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada data pasien yang cocok.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
                    <div class="mt-4">
                        {{ $patients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL UNTUK SETIAP PASIEN (PENDEKATAN BARU) --}}
    @foreach($patients as $patient)
<x-modal name="checkin-modal-{{ $patient->id }}" :show="$errors->checkin->isNotEmpty() && old('patient_id_for_modal') == $patient->id" focusable>
    <form action="{{ route('patients.checkin', $patient->id) }}" method="post" enctype="multipart/form-data" class="p-6">
        @csrf
        {{-- Input tersembunyi untuk melacak modal mana yang dibuka --}}
        <input type="hidden" name="patient_id_for_modal" value="{{ $patient->id }}">

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Absensi Pasien: <span class="font-bold">{{ $patient->name }}</span>
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Silakan ambil dan upload foto pasien sebagai bukti kehadiran hari ini.
        </p>

        {{-- ========================================================== --}}
        {{-- == BLOK UNTUK MENAMPILKAN ERROR VALIDASI DI MODAL == --}}
        {{-- ========================================================== --}}
        @if ($errors->checkin->any())
            <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <strong class="font-bold">Terjadi Kesalahan!</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->checkin->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- ========================================================== --}}

        <div class="mt-6">
            {{-- Perhatikan: nama input diubah menjadi 'check_in_photo' agar sesuai controller --}}
            <x-input-label for="check_in_photo_{{ $patient->id }}" value="Foto Pasien (Wajib)" />
            <input id="check_in_photo_{{ $patient->id }}" name="check_in_photo" type="file" class="block w-full mt-1 text-sm ..." accept="image/*" required>
        </div>
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                Batal
            </x-secondary-button>
            <x-primary-button class="ms-3">
                Konfirmasi Absensi
            </x-primary-button>
        </div>
    </form>
</x-modal>
@endforeach
</x-app-layout>