<x-app-layout>
    <x-breadcrumbs name="citation.create" />
    <h1 class="font-semibold text-lg my-8">Tambah Sitasi</h1>

    <div class="w-1/2">
        {{-- alert --}}
        <div class="alert shadow-sm mb-4">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="stroke-current flex-shrink-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>
                    <strong>Info!</strong> Jika penulis tidak ada di daftar, silahkan tambahkan terlebih dahulu.
                    {{-- klik link dibawah ini --}}
                    <a href="{{ route('admin.author.create') }}" class="text-primary underline">Tambah Penulis</a>
                </span>
            </div>
        </div>
        <x-card-container>
            <form action="{{ route('admin.citation.store') }}" method="POST">
                @csrf
                <x-input id="title" name="title" label="Judul Sitasi" type="text" class="mb-2" required />
                <x-select id="author" name="author" label="Penulis" isFit="" required>
                    <option value="">Pilih Penulis</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                    @endforeach
                </x-select>

                <div class="flex justify-end mt-4">
                    <x-link-button route="{{ route('admin.citation.index') }}" color="gray">
                        Batal
                    </x-link-button>
                    <x-button class="ml-2">
                        Simpan
                    </x-button>
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
