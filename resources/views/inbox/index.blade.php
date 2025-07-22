<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inbox (Pesan Masuk)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="space-y-4">
                        @forelse ($messages as $message)
    {{-- Setiap item sekarang adalah sebuah link --}}
                                <a href="{{ route('inbox.show', $message) }}" class="block">
                                    <div class="border-l-4 {{ is_null($message->read_at) ? 'border-karyasuci-primary' : 'border-gray-300 dark:border-gray-600' }} pl-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 ease-in-out">
                                        <div class="flex justify-between items-center">
                                            <p class="font-bold {{ is_null($message->read_at) ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}">
                                                Dari: {{ $message->sender->name }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $message->created_at->diffForHumans() }}</p>
                                        </div>
                                        <p class="font-semibold {{ is_null($message->read_at) ? 'text-gray-800 dark:text-gray-200' : 'text-gray-500 dark:text-gray-400' }}">{{ $message->subject }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate">{{ $message->body }}</p>
                                    </div>
                                </a>
                            @empty
                                <p class="text-center text-gray-500">Tidak ada pesan.</p>
                            @endforelse
                                                </div>
                    <div class="mt-4">
                        {{ $messages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>