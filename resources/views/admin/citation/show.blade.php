<x-app-layout>
    <x-breadcrumbs name="citation.show" :data="$citation" />
    <h1 class="font-semibold text-lg my-8">Detail Sitasi</h1>

    <div class="w-1/2">
        <x-card-container>
            <form action="{{ route('admin.citation.update', $citation->id) }}" method="POST">
                @csrf
                @method('PUT')
                <x-input id="title" name="title" label="Judul Sitasi" type="text" :value="$citation->title" class="mb-2"
                    disabled />
                <x-select disabled id="author" name="author" label="Penulis" isFit="" required>
                    <option>
                        {{ $citation->author != null || $citation->author != '' ? $citation->author->name : 'Tidak ada penulis' }}
                    </option>
                </x-select>

                <div class="flex justify-end mt-4">
                    <x-link-button route="{{ route('admin.citation.index') }}" color="gray">
                        Kembali
                    </x-link-button>
                </div>
            </form>
        </x-card-container>
    </div>

    @push('js-internal')
        <script>
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
                    title: 'Berhasil',
                    text: '{{ Session::get('error') }}',
                });
            @endif
        </script>
    @endpush
</x-app-layout>
