<x-app-layout>
    <x-breadcrumbs name="genotipe.show" :data="$genotipe" />
    <h1 class="font-semibold text-xl my-8">Detail Genotipe</h1>

    <x-card-container>
        <div class="md:grid md:grid-cols-2 gap-x-4">
            <x-input id="genotipe" label="Genotipe & Subtipe" name="genotipe_code" type="text" required disabled
            :value="$genotipe->genotipe_code" />
            <x-select id="id_virus" label="Nama Virus" name="viruses_id" isFit="" required disabled>
                @foreach ($viruses as $virus)
                    <option value="{{ $virus->id }}" {{ $genotipe->viruses_id == $virus->id ? 'selected' : ' ' }}>{{ $virus->name }}</option>
                @endforeach
            </x-select>
        </div>

        
        {{-- back --}}
        <div class="mt-4 text-end">
            <x-link-button route="{{ route('admin.genotipe.index') }}" color="gray">
                Kembali
            </x-link-button>
        </div>
    </x-card-container>

    @push('js-internal')
        <script>
            $(function() {});

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
