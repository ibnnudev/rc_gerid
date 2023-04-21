<x-app-layout>
    <x-breadcrumbs name="import-request.edit" :data="$data" />
    <h1 class="font-semibold text-lg my-8">
        Ubah Permintaan
    </h1>

    <div class="xl:grid grid-cols-2">
        <x-card-container>
            <form action="{{ route('admin.import-request.update', $data->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <x-input id="file" type="file" name="file" label="File Sekuen" class="mb-3" required />
                <x-textarea id="description" name="description" label="Deskripsi">{{ $data->description }}</x-textarea>

                <div class="text-end">
                    <x-button>Simpan</x-button>
                </div>
            </form>
        </x-card-container>
    </div>

    @push('js-internal')
        <script>
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
