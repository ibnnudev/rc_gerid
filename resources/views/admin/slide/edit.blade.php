<x-app-layout>
    <x-breadcrumbs name="slide.edit" :data="$data" />
    <h1 class="font-semibold text-lg my-8">Edit Slide</h1>

    <x-card-container>
        <form action="{{ route('admin.slide.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-input id="image" name="image" label="Gambar" type="file" required />
            @if ($data->image)
                <img src="{{ asset('storage/slides/' . $data->image) }}" alt="{{ $data->title }}" class="my-4"
                    width="200" height="200" />
            @endif
            <x-input id="title" name="title" label="Judul" type="text" required :value="$data->title" />
            <x-textarea id="content" name="content" label="Konten" class="ckeditor"
                required>{{ $data->content }}</x-textarea>
            <x-input id="video" name="video" label="Link Video" type="text" :value="$data->video ?? null" />
            @if ($data->video != null)
                <div class="mt-4">
                    {!! $data->video !!}
                </div>
            @endif
            <div class="mt-4">
                <x-button>Simpan Perubahan</x-button>
            </div>
        </form>
    </x-card-container>

    @push('js-internal')
    @endpush
</x-app-layout>
