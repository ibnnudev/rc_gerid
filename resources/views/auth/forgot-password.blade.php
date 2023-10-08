<x-guest-layout>
    <div class="mb-4 text-xs 2xl:text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input id="email" label="Email" name="email" type="email" :value="old('email')" required autofocus />
            {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button class="ml-3">
                {{ __('Email Password Reset Link') }}
            </x-button>
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
