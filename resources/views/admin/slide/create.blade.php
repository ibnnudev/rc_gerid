<x-app-layout>
    <x-breadcrumbs name="slide.create" />
    <h1 class="font-semibold text-lg my-8">Tambah Slide</h1>

    <x-card-container>
        <form action="{{ route('admin.slide.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-input id="image" name="image" label="Gambar" type="file" required />
            <x-input id="title" name="title" label="Judul" type="text" required />
            <x-textarea id="content" name="content" label="Konten" class="ckeditor" required />
            <x-button>Simpan</x-button>
        </form>
    </x-card-container>

    @push('js-internal')
    @endpush
</x-app-layout>
