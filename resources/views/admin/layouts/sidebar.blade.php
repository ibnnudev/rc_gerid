<button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
    class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:focus:ring-gray-600">
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
    <div class="h-full px-4 py-8 overflow-y-auto bg-white">
        {{-- Logo --}}
        <a href="#" class="flex items-center mb-4">
            <img src="{{ asset('assets/application/logo new.png') }}" class="mr-3 object-contain" alt="logo"
                class="mix-blend-multiply" />
        </a>
        <ul class="space-y-3">
            <x-sidebar-menu name="Dashboard" icon="fas fa-home" route="{{ route('admin.dashboard') }}"
                active="{{ request()->routeIs('admin.dashboard') }}" />
            @if (auth()->user()->role == 'admin')
                <x-sidebar-menu name="Bank Data" icon="fas fa-bank" route="{{ route('admin.bank.index') }}"
                    active="{{ request()->routeIs('admin.bank.*') }}" />
                <x-sidebar-menu name="Virus" icon="fas fa-virus" route="{{ route('admin.virus.index') }}"
                    active="{{ request()->routeIs('admin.virus.*') }}" />
                <x-sidebar-menu name="Genotipe" icon="fas fa-dna" route="{{ route('admin.genotipe.index') }}"
                    active="{{ request()->routeIs('admin.genotipe.*') }}" />
                <x-sidebar-menu name="Penulis" icon="fas fa-user" route="{{ route('admin.author.index') }}"
                    active="{{ request()->routeIs('admin.author.*') }}" />
                <x-sidebar-menu name="Sitasi" icon="fas fa-lines-leaning" route="{{ route('admin.citation.index') }}"
                    active="{{ request()->routeIs('admin.citation.*') }}" />
                {{-- <x-sidebar-menu name="Transmisi" icon="fas fa-route" route="{{ route('admin.transmission.index') }}"
                    active="{{ request()->routeIs('admin.transmission.*') }}" /> --}}
                {{-- <li>
                    <button type="button"
                        class="flex w-full items-center p-3 font-normal text-gray-900 rounded-md dark:text-white hover:bg-gray-100
                            @if (request()->routeIs('admin.cases.*')) bg-primary text-white shadow-sm hover:bg-secondary @endif
                            "
                        aria-controls="data-kasus" data-collapse-toggle="data-kasus">
                        <i
                            class="fas fa-hospital-user w-4 h-4 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white
                                @if (request()->routeIs('admin.cases.*')) text-white @endif
                                "></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Kasus</span>
                        <i
                            class="fas w-3 h-3 text-gray-500 transition duration-75 transform group-hover:text-gray-900 dark:group-hover:text-white
                                @if (request()->routeIs('admin.cases.*')) fa-angle-up text-white @else fa-angle-down @endif
                                "></i>
                    </button>
                    <ul id="data-kasus"
                        class="{{ request()->routeIs('admin.cases.hiv') ? '' : 'hidden' }} py-2 space-y-2">
                        <li>
                            <a href="{{ route('admin.cases.hiv') }}"
                                class="{{ request()->routeIs('admin.cases.hiv') ? 'bg-gray-100' : '' }} flex items-center p-3 font-normal text-gray-900 rounded-md dark:text-white hover:bg-gray-100 pl-11">
                                HIV</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center p-3 font-normal text-gray-900 rounded-md dark:text-white hover:bg-gray-100 pl-11">Hepatitis
                                B</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center p-3 font-normal text-gray-900 rounded-md dark:text-white hover:bg-gray-100 pl-11">Hepatitis
                                C</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center p-3 font-normal text-gray-900 rounded-md dark:text-white hover:bg-gray-100 pl-11">Rotavirus</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center p-3 font-normal text-gray-900 rounded-md dark:text-white hover:bg-gray-100 pl-11">Norovirus</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center p-3 font-normal text-gray-900 rounded-md dark:text-white hover:bg-gray-100 pl-11">Dengue</a>
                        </li>
                    </ul>
                </li> --}}

                {{-- divider --}}
                <li class="border-t border-gray-200"></li>
            @endif

            @if (auth()->user()->role == 'admin')
                {{-- manajemen pengguna --}}
                <x-sidebar-menu name="Manajemen Pengguna" icon="fas fa-user-group"
                    route="{{ route('admin.user-management.index') }}"
                    active="{{ request()->routeIs('admin.user-management.*') }}" />
            @endif

            @if (auth()->user()->role == 'admin' || auth()->user()->role == 'validator')
                <x-sidebar-menu name="Daftar Permintaan" icon="fas fa-code-pull-request"
                    route="{{ route('admin.import-request.admin') }}"
                    active="{{ request()->routeIs('admin.import-request.*') }}" />
            @else
                <x-sidebar-menu name="Daftar Permintaan" icon="fas fa-code-pull-request"
                    route="{{ route('admin.import-request.index') }}"
                    active="{{ request()->routeIs('admin.import-request.*') }}" />
                <x-sidebar-menu name="Daftar Sekuen" icon="fas fa-bank" route="{{ route('admin.bank.imported') }}"
                    active="{{ request()->routeIs('admin.bank.imported') }}" />
            @endif

            <x-sidebar-menu name="Pengaturan" icon="fas fa-cog" route="{{ route('admin.profile.index') }}"
                active="{{ request()->routeIs('admin.profile.*') }}" />

            @if (auth()->user()->role == 'admin')
                <x-sidebar-menu name="Slide" icon="fas fa-images" route="{{ route('admin.slide.index') }}"
                    active="{{ request()->routeIs('admin.slide.*') }}" />
            @endif

            {{-- logout --}}
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center p-3 font-normal text-gray-900 rounded-md dark:text-white hover:bg-gray-100">
                        <i
                            class="fas fa-sign-out-alt w-4 h-4 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="ml-3">Keluar</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>
