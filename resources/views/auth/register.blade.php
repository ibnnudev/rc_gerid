<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <x-input id="name" label="Nama Lengkap" name="name" type="text" required />
        <x-input id="email" label="Email" name="email" type="email" required />
        <x-input id="password" label="Password" name="password" type="password" required />
        <x-input id="password_confirmation" label="Konfirmasi Password" name="password_confirmation" type="password"
            required />

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <x-button type="submit" class="ml-3">
                {{ __('Daftar') }}
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
                        text: '{{ Session::get('success') }}'
                    });
                @endif

                @if (Session::has('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: '{{ Session::get('error') }}'
                    });
                @endif
            });
        </script>
    @endpush


</x-guest-layout>
