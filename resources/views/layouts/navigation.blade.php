<div class="flex justify-between items-center h-16 shrink-0 px-4 bg-karyasuci-primary dark:bg-gray-900">
    {{-- Logo --}}
    <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-white dark:text-karyasuci-primary">
        KARYA SUCI
    </a>
    {{-- Tombol 'X' untuk menutup sidebar (hanya terlihat di mobile) --}}
    <button @click="sidebarOpen = false" class="lg:hidden text-white hover:text-gray-200">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>

{{-- Menu Navigasi --}}
<nav class="flex flex-col justify-between flex-1 mt-4">
    {{-- Bagian Atas: Link Utama --}}
    <div class="px-4 space-y-2">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            {{ __('Dashboard') }}
        </x-nav-link>

        @if(in_array(Auth::user()->role, ['Admin', 'Manajer']))
            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                {{ __('Manajemen Pegawai') }}
            </x-nav-link>
        @endif

        @if(in_array(Auth::user()->role, ['Admin', 'Resepsionis', 'Manajer']))
<x-nav-link :href="route('patients.index')" :active="request()->routeIs('patients.index') or request()->routeIs('patients.create') or request()->routeIs('patients.edit') or request()->routeIs('patients.show')">               <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                {{ __('Absensi Pasien') }}
            </x-nav-link>
            <x-nav-link :href="route('patients.archive')" :active="request()->routeIs('patients.archive')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                {{ __('Arsip Pasien') }}
            </x-nav-link>
        @endif
        
        

        @if(in_array(Auth::user()->role, ['Admin', 'Fisioterapis', 'Manajer']))
            <x-nav-link :href="route('therapist.queue.index')" :active="request()->routeIs('therapist.queue.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                {{ __('Antrian Terapi') }}
            </x-nav-link>
        @endif

        @if(in_array(Auth::user()->role, ['Admin','Manajer', 'Kasir']))
            <x-nav-link :href="route('cashier.queue.index')" :active="request()->routeIs('cashier.queue.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H7a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                {{ __('Antrian Pembayaran') }}
            </x-nav-link>
            <x-nav-link :href="route('cashier.sales.create')" :active="request()->routeIs('cashier.sales.create')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                {{ __('Penjualan Produk') }}
            </x-nav-link>
        @endif

        @if(in_array(Auth::user()->role, ['Admin', 'Manajer', 'Kasir']))
            <x-nav-link :href="route('invoices.index')" :active="request()->routeIs('invoices.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                {{ __('Manajemen Invoices') }}
            </x-nav-link>
        @endif
        
        <div class="border-t border-gray-200 dark:border-gray-700 my-4"></div>

        <x-nav-link :href="route('inbox.index')" :active="request()->routeIs('inbox.*')">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            {{ __('Inbox') }}
        </x-nav-link>

        
        <x-nav-link :href="route('activity-logs.index')" :active="request()->routeIs('activity-logs.index')">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            {{ __('Log Aktivitas') }}
        </x-nav-link>
    </div>
    
    {{-- Bagian Bawah: Pengaturan Pengguna --}}
    <div class="mt-auto">
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
             <x-dropdown align="top" width="56">
                <x-slot name="trigger">
                    <button class="flex items-center w-full text-left p-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-900 hover:text-gray-700 dark:hover:text-gray-300">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</p>
                            <p class="text-xs">{{ Auth::user()->role }}</p>
                        </div>
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>