<button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
    class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
        </path>
    </svg>
</button>

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen border border-r transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-4 py-8 overflow-y-hidden">
        {{-- Logo --}}
        {{-- <a href="#" class="flex items-center pl-2.5 mb-8">
            <img src="{{ asset('assets/application/logo.png') }}" class="h-12 mr-3 sm:h-20" alt="logo" />
        </a> --}}
        <ul class="space-y-3">
            <x-sidebar-menu name="Dashboard" icon="fas fa-home" route="{{ route('admin.dashboard') }}"
                active="{{ request()->routeIs('admin.dashboard') }}" />
            <x-sidebar-menu name="Bank Data" icon="fas fa-bank" route="{{ route('admin.bank.index') }}"
                active="{{ request()->routeIs('admin.bank.*') }}" />
            <x-sidebar-menu name="Data Penulis" icon="fas fa-user" route="{{ route('admin.author.index') }}"
                active="{{ request()->routeIs('admin.author.*') }}" />
            <x-sidebar-menu name="Data Virus" icon="fas fa-virus" route="{{ route('admin.virus.index') }}" active="{{ request()->routeIs('admin.virus.*') }}" />


            {{-- logout --}}
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center p-3 font-normal text-gray-900 rounded-md dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i
                            class="fas fa-sign-out-alt w-4 h-4 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="ml-3">Keluar</span>
                    </button>
                </form>
            </li>
        </ul>

        <!--
            <div id="dropdown-cta" class="p-4 mt-12 rounded-2xl border-b border-gray-200 sm:rounded-2xl shadow-xl"
            role="alert">
            <div class="flex items-center text-center justify-center flex-col">
                <div class="avatar">
                    <div class="w-12 rounded-full">
                        <img
                            src="{{ auth()->user()->avatar != null ? asset(auth()->user()->avatar) : asset('images/noimage.jpg') }}" />
                    </div>
                </div>
                <p class="font-bold mt-2">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-gray-400">
                    {{ auth()->user()->getRole() }}
                </p>

                {{-- open profile button light --}}
                <a href=""
                    class="w-full px-4 py-2 mt-6 text-xs font-medium bg-gray-100 border border-transparent rounded-md shadow-sm">
                    <span>Buka Profil</span>
                </a>
            </div>
        </div>
            !-->
    </div>
</aside>
