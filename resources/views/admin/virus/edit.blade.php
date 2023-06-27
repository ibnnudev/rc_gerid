<x-app-layout>
    <x-breadcrumbs name="virus.edit" :data="$virus" />
    <h1 class="font-semibold text-lg my-8">Edit Virus</h1>

    <div class="lg:flex gap-x-4">
        <div class="lg:w-1/5">
            <x-card-container>
                <div class="avatar">
                    <div class="w-full rounded rounded-xl">
                        <img src="{{ $virus->image ? asset('storage/virus/' . $virus->image) : asset('images/noimage.jpg') }}"
                            id="imageThumbnail" />
                    </div>
                </div>
                <a class="flex w-full justify-center items-center py-2 bg-gray-700 mt-3 text-white border border-transparent rounded-md shadow-sm"
                    id="btnChangeImage">
                    <i class="fas fa-camera mr-2"></i>
                    <span>Unggah Gambar</span>
                </a>
            </x-card-container>
        </div>
        <div class="lg:w-4/5">
            <form action="{{ route('admin.virus.update', $virus->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-card-container>

                    <input type="file" id="image" name="image" class="hidden" />

                    <div class="grid grid-cols-2 gap-x-3">
                        <x-input id="name" label="Nama" name="name" type="text" required :value="$virus->name" />
                        <x-input id="latin_name" label="Nama Latin" name="latin_name" type="text" required :value="$virus->latin_name" />
                    </div>

                    <x-textarea id="description" label="Deskripsi" name="description" class="ckeditor" required>{{$virus->description}}</x-textarea>

                    <div class="text-end mt-4">
                        <x-button class="px-6">
                            <span>Simpan</span>
                        </x-button>
                    </div>
                </x-card-container>
            </form>
        </div>
    </div>

    @push('js-internal')
        <script>
            $(function() {

                $('#btnChangeImage').click(function() {
                    $('#image').click();
                });

                $('#image').change(function() {
                    if (this.files && this.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('#imageThumbnail').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(this.files[0]);
                    }
                });
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
