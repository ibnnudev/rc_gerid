<x-app-layout>
    <x-breadcrumbs name="virus.show" :data="$virus" />
    <h1 class="font-semibold text-lg my-8">Detail Virus</h1>

    <div class="lg:flex gap-x-4">
        <div class="lg:w-1/5">
            <x-card-container>
                <div class="avatar">
                    <div class="w-full rounded rounded-xl">
                        <img src="{{ $virus->image ? asset('images/' . $virus->image) : asset('images/noimage.jpg') }}"
                            id="imageThumbnail" />
                    </div>
                </div>
            </x-card-container>
        </div>
        <div class="lg:w-4/5">
            <x-card-container>

                <input type="file" id="image" name="image" class="hidden" />

                <div class="grid grid-cols-2 gap-x-3">
                    <x-input id="name" label="Nama" name="name" type="text" required disabled
                        :value="$virus->name" />
                    <x-input id="latin_name" label="Nama Latin" name="latin_name" type="text" required disabled
                        :value="$virus->latin_name" />
                </div>

                <x-textarea id="description" label="Deskripsi" name="description" class="ckeditor" required disabled>
                    {{ $virus->description }}</x-textarea>

                {{-- back --}}
                <div class="mt-4 text-end">
                    <x-link-button route="{{ route('admin.virus.index') }}" color="gray">
                        Kembali
                    </x-link-button>
                </div>
            </x-card-container>
        </div>
    </div>

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
