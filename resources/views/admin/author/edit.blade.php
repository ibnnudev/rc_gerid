<x-app-layout>
    <x-breadcrumbs name="author.edit" :data="$author" />
    <h1 class="font-semibold text-lg my-8">Edit Penulis</h1>

    <x-card-container>
        <form action="{{ route('admin.author.update', $author->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="md:grid md:grid-cols-2 gap-x-4">
                <x-input id="name" required label="Nama Pengarang" name="name" type="text" :value="$author->name" />
                <x-input id="phone" label="Nomor Telepon" name="phone" type="text" :value="$author->phone" />
                <x-input id="member" required label="Anggota" name="member" type="text" :value="$author->member" />
                <x-input id="address" required label="Alamat" name="address" type="text" :value="$author->address" />
                <x-select id="institutions_id" label="Institusi" name="institutions_id" isFit="" required>
                    @foreach ($institutions as $institution)
                        <option value="{{ $institution->id }}"
                            {{ $institution->id == $author->institution->id ? 'selected' : '' }}>
                            {{ $institution->name }}
                        </option>
                    @endforeach
                </x-select>
                <div></div>
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
