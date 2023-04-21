<x-app-layout>
    <x-breadcrumbs name="import-request.create" />
    <h1 class="font-semibold text-lg my-8">
        Tambah Permintaan
    </h1>

    <div class="xl:grid grid-cols-2">
        <x-card-container>
            <form action="{{ route('admin.import-request.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-input id="file" type="file" name="file" label="File Sekuen" class="mb-3" required />
                <x-textarea id="description" name="description" label="Deskripsi"></x-textarea>

                <div class="text-end">
                    {{-- <x-link-button :route="route('admin.import-request.index')" color="gray" class="mr-full">Batal</x-link-button> --}}
                    <x-button>Simpan</x-button>
                </div>
            </form>
        </x-card-container>
    </div>

    @push('js-internal')
        <script>
            $(function() {});

            @if (Session::has('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ Session::get('error') }}',
                })
            @endif
        </script>
    @endpush

</x-app-layout>
