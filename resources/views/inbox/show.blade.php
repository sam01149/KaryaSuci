<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pesan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    
                    <div class="pb-4 border-b dark:border-gray-700">
                        <h3 class="text-2xl font-bold">{{ $message->subject }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Dari: <span class="font-semibold">{{ $message->sender->name }}</span> | Diterima: {{ $message->created_at->locale('id')->translatedFormat('l, d F Y H:i') }}
                        </p>
                    </div>

                    <div class="mt-6">
                        <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400">Isi Pesan:</h4>
                        {{-- Penggunaan nl2br() akan mengubah baris baru (\n) menjadi tag <br> agar format teks terjaga --}}
                        <p class="mt-2 text-base whitespace-pre-wrap">{!! nl2br(e($message->body)) !!}</p>
                    </div>

                    <div class="mt-8 pt-6 border-t dark:border-gray-700">
                         <a href="{{ route('inbox.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400">
                            &larr; Kembali ke Inbox
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>