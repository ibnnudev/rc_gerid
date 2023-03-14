<x-app-layout>
    <x-breadcrumbs name="transmission.create" />
    <h1 class="font-semibold text-lg my-8">Tambah Transmisi</h1>

    <div class="lg:w-1/2">
        <x-card-container>
            <form action="{{ route('admin.transmission.store') }}" method="POST">
                @csrf
                <x-input id="name" label="Nama Transmisi" name="name" type="text" class="w-full"
                    required />

                <div class="text-end mt-4">
                    <x-button class="px-6">
                        <span>Tambah</span>
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
