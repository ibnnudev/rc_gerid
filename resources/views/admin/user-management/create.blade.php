<x-app-layout>
    <x-breadcrumbs name="user-management.create" />
    <h1 class="font-semibold text-lg my-8">
        Tambah Pengguna
    </h1>

    <div class="xl:grid grid-cols-3">
        <x-card-container>
            <form action="{{ route('admin.user-management.store') }}" method="POST">
                @csrf
                <x-input id="name" name="name" type="text" label="Nama" required />
                <x-input id="email" name="email" type="email" label="Email" required />
                <x-select id="role" name="role" label="Role" required>
                    <option value="admin">Admin</option>
                    <option value="user" selected>User</option>
                    <option value="validator">Validator</option>
                </x-select>
                <div class="virus hidden">
                    <x-select id="virus_id" name="virus_id" label="Tipe Virus" required>
                        @foreach ($viruses as $virus)
                            <option value="{{ $virus->id }}">{{ $virus->name }}</option>
                        @endforeach
                    </x-select>
                </div>
                <div class="p-4 mt-4 text-xs text-gray-800 rounded-lg bg-gray-50" role="alert">
                    <span class="font-semibold">Info!</span>
                    Kata sandi akan dikirimkan ke email pengguna
                </div>
                <div class="text-end">
                    <x-button class="mt-4">
                        Tambah
                    </x-button>
                </div>
            </form>
        </x-card-container>
    </div>
    @push('js-internal')
        <script>
            $(function() {

                $('#role').on('change', function() {
                    if ($(this).val() == 'validator') {
                        $('.virus').removeClass('hidden');
                    } else {
                        $('.virus').addClass('hidden');
                    }
                })

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
</x-app-layout>
