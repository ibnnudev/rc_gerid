<x-app-layout>
    <x-breadcrumbs name="author.create" />
    <h1 class="font-semibold text-xl my-8">Tambah Penulis</h1>

    <x-card-container>
        <form action="{{ route('admin.author.store') }}" method="POST">
            @csrf
            <div class="md:grid md:grid-cols-2 gap-x-4">
                <x-input id="name" label="Nama Pengarang" name="name" type="text" required />
                <x-input id="phone" label="Nomor Telepon" name="phone" type="text" />
                <x-input id="member" label="Anggota" name="member" type="text" required />
                <x-input id="address" label="Alamat" name="address" type="text" required />
                <x-select id="institutions_id" label="Institusi" name="institutions_id" isFit="" required>
                    @foreach ($institutions as $institution)
                        <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="text-end">
                <x-button>Simpan</x-button>
            </div>
        </form>
    </x-card-container>

    @push('js-internal')
        <script>
            $(function() {
                $('#institutions_id').select2();
            });
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
        </script>
    @endpush
</x-app-layout>
