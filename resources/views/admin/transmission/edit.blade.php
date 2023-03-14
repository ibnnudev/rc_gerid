<x-app-layout>
    <x-breadcrumbs name="transmission.edit" :data="$transmission" />
    <h1 class="font-semibold text-lg my-8">Edit Genotipe</h1>

    <div class="lg:w-1/2">
        <x-card-container>
            <form action="{{ route('admin.transmission.update', $transmission->id) }}" method="POST">
                @csrf
                @method('PUT')

                <x-input id="name" label="Nama Transmisi" name="name" type="text" required :value="$transmission->name" />

                <div class="text-end mt-4">
                    <x-button class="px-6">
                        <span>Simpan</span>
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
                    title: 'Gagal',
                    text: '{{ Session::get('error') }}',
                });
            @endif
        </script>
    @endpush
</x-app-layout>
