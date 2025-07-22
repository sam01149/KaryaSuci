<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            if (localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
        {{-- Style untuk mencegah "kedipan" overlay saat halaman dimuat --}}
        <style>
            [x-cloak] { display: none !important; }
        </style>
        <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <meta name="theme-color" content="#94DD53"/>
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ sidebarOpen: false }" class="relative min-h-screen bg-gray-100 dark:bg-gray-900">

            <div 
                x-show="sidebarOpen" 
                @click="sidebarOpen = false" 
                class="fixed inset-0 z-20 bg-black bg-opacity-75 transition-opacity lg:hidden"
                x-cloak
            ></div>

            <aside 
                class="bg-white dark:bg-gray-800 w-64 fixed inset-y-0 left-0 z-30 transform transition duration-300 ease-in-out lg:translate-x-0"
                :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
            >
                @include('layouts.navigation')
            </aside>

            <div class="lg:ml-64">
                <header class="bg-white dark:bg-gray-800 shadow sticky top-0 z-10">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center">
                            <button @click.stop="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 dark:text-gray-400 focus:outline-none mr-4">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                            </button>
                            
                            <div class="flex-1 min-w-0">
                                @isset($header)
                                    {{ $header }}
                                @endisset
                            </div>
                        </div>
                    </div>
                </header>
                <main>{{ $slot }}</main>
            </div>
        </div>
        
    </body>
</html>