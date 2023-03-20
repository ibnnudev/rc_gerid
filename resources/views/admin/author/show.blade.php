<x-app-layout>
    <x-breadcrumbs name="author.show" :data="$author" />
    <h1 class="font-semibold text-lg my-8">Detail Penulis</h1>

    <x-card-container>
        <div class="md:grid md:grid-cols-2 gap-x-4">
            <x-input id="name" disabled label="Nama Pengarang" name="name" type="text" :value="$author->name" />
            <x-input id="phone" disabled label="Nomor Telepon" name="phone" type="text" />
            <x-input id="member" disabled label="Anggota" name="member" type="text" :value="$author->member" />
            <x-input id="address" disabled label="Alamat" name="address" type="text" :value="$author->address" />
            <x-select id="institutions_id" disabled label="Institusi" name="institutions_id" isFit="">
                @if ($author->institutions_id != null)
                    <option value="{{ $author->institutions_id }}" selected>
                        {{ $author->institution->name }}
                    </option>
                @else
                    <option value="" selected disabled>Pilih Institusi</option>
                @endif
            </x-select>
        </div>

        {{-- back --}}
        <div class="mt-4 text-end">
            <x-link-button route="{{ route('admin.author.index') }}" color="gray">
                Kembali
            </x-link-button>
        </div>
    </x-card-container>

    @push('js-internal')
        <script>
            $(function () {
                $('#institutions_id').select2();
            });
        </script>
    @endpush

</x-app-layout>
