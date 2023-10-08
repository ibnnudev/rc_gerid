<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <x-input id="email" label="Email" name="email" type="email" required autofocus />
        <p id="result" class="text-xs lg:text-sm px-2"></p>
        <!-- Password -->
        <x-input id="password" label="Password" name="password" type="password" required />

        <div class="flex items-center justify-between mt-4">
            <div>
                {{-- forgot passwoed --}}
                <a class="underline text-xs lg:text-xs text-gray-600" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            </div>
            <div>
                @if (Route::has('password.request'))
                    <a class="underline text-xs lg:text-xs text-gray-600" href="{{ route('register') }}">
                        {{ __('Tidak punya akun?') }}
                    </a>
                @endif
                <x-button class="ml-3">Masuk</x-button>
            </div>
        </div>
    </form>

    @push('js-internal')
        <script>
            $(function() {
                @if (Session::has('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: '{{ Session::get('success') }}',
                    });
                @endif

                @if (Session::has('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: '{{ Session::get('error') }}',
                    });
                @endif
            });
        </script>
    @endpush
</x-guest-layout>
