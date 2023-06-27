<x-app-layout>
    <x-breadcrumbs name="user-management.edit" :data="$user" />
    <h1 class="font-semibold text-lg my-8">
        Ubah Role Pengguna
    </h1>

    <div class="xl:grid grid-cols-3">
        <x-card-container>
            <form action="{{ route('admin.user-management.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <x-input id="name" name="name" type="text" label="Nama" :value="$user->name" required />
                <x-select id="role" name="role" label="Role" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : ''}}>Admin</option>
                    <option value="user" {{ $user->role == 'user' ? 'selected' : ''}}>User</option>
                    <option value="validator" {{ $user->role == 'validator' ? 'selected' : ''}}>Validator</option>
                </x-select>
                <div class="virus {{
                    $user->role == 'validator' ? '' : 'hidden'
                }}">
                    <x-select id="virus_id" name="virus_id" label="Tipe Virus" required>
                        @foreach ($viruses as $virus)
                            <option value="{{ $virus->id }}" {{ $user->virus_id == $virus->id ? 'selected' : '' }}>
                                {{ $virus->name }}</option>
                        @endforeach
                    </x-select>
                </div>
                <div class="text-end">
                    <x-button class="mt-4">
                        Simpan Perubahan
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
