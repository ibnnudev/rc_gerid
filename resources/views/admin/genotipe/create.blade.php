<x-app-layout>
    <x-breadcrumbs name="genotipe.create" />
    <h1 class="font-semibold text-xl my-8">Tambah Genotipe</h1>

    <x-card-container>
        <form action="{{ route('admin.genotipe.store') }}" method="POST">
            @csrf

            <div class="md:grid md:grid-cols-2 gap-x-4">
                <x-input id="genotipe" label="Genotipe & Subtipe" name="genotipe_code" type="text" required />
                <x-select id="id_virus" label="Nama Virus" name="viruses_id" isFit="" required>
                    @foreach ($viruses as $virus)
                        <option value="{{ $virus->id }}">{{ $virus->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="text-end mt-4">
                <x-button class="px-6">
                    <span>Tambah</span>
                </x-button>
            </div>
        </form>
    </x-card-container> 

    @push('js-internal')
        <script>
            $('document').ready(function(){
                $('#id_virus').select2();
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
