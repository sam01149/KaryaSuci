<nav x-data="{ open: false }" class="bg-karyasuci-primary dark:bg-gray-800 border-b border-green-600 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-extrabold text-white dark:text-karyasuci-primary">
                        KARYA SUCI
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" />

                    @if(in_array(Auth::user()->role, ['Admin', 'Resepsionis', 'Manajer']))
                        <x-nav-link :href="route('patients.index')" :active="request()->routeIs('patients.*')">
                            {{ __('Manajemen Pasien') }}
                        </x-nav-link>
                    @endif

                    @if(in_array(Auth::user()->role, ['Admin', 'Fisioterapis', 'Manajer']))
                        <x-nav-link :href="route('therapist.queue.index')" :active="request()->routeIs('therapist.queue.*')">
                            {{ __('Antrian Terapi') }}
                        </x-nav-link>
                    @endif

                    @if(in_array(Auth::user()->role, ['Admin', 'Kasir']))
                        <x-nav-link :href="route('cashier.queue.index')" :active="request()->routeIs('cashier.queue.*')">
                            {{ __('Antrian Pembayaran') }}
                        </x-nav-link>
                        <x-nav-link :href="route('cashier.products.create')" :active="request()->routeIs('cashier.products.create')">
                            {{ __('Pesan Obat/Alat') }}
                        </x-nav-link>
                    @endif

                    @if(in_array(Auth::user()->role, ['Admin', 'Manajer']))
                        <x-nav-link :href="route('manager.dashboard')" :active="request()->routeIs('manager.dashboard')">
                            {{ __('Dasbor Laporan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('manager.transactions.index')" :active="request()->routeIs('manager.transactions.index')">
                            {{ __('Laporan Transaksi') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <button type="button" x-data="{
                    darkMode: localStorage.getItem('darkMode') === 'true',
                    toggle() {
                        this.darkMode = !this.darkMode;
                        localStorage.setItem('darkMode', this.darkMode);
                        document.documentElement.classList.toggle('dark', this.darkMode);
                    }
                }" @click="toggle()" class="mr-4 p-2 rounded-md text-gray-200 dark:text-gray-400 hover:text-white dark:hover:text-gray-300 hover:bg-white/10 dark:hover:bg-gray-700 focus:outline-none">
                    <svg x-show="!darkMode" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                    <svg x-show="darkMode" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-200 dark:text-gray-300 hover:text-white dark:hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
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
    </div>
</nav>