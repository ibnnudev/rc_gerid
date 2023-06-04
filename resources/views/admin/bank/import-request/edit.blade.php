<x-app-layout>
    <x-breadcrumbs name="import-request.edit" :data="$data" />
    <h1 class="font-semibold text-lg my-8">
        Ubah Permintaan
    </h1>

    <div class="xl:grid grid-cols-2">
        <x-card-container>
            <div id="alert-1" class="flex p-4 mb-4 text-xs rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-400"
                role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Hal yang terjadi jika melakukan edit pada file import:</span>
                    <ul class="mt-1.5 ml-4 list-decimal">
                        <li>File akan dikirim ke admin untuk di cek kembali</li>
                        <li>Tunggu email konfirmasi dari admin</li>
                    </ul>
                </div>
                <button type="button"
                    class="ml-auto -mx-1.5 -my-1.5 bg-gray-50 text-gray-500 rounded-lg focus:ring-2 focus:ring-gray-400 p-1.5 hover:bg-gray-200 inline-flex h-7 w-7 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-1" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.import-request.update', $data->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <x-select id="viruses_id" name="viruses_id" label="Jenis Virus" isFit="">
                    @foreach ($viruses as $virus)
                        <option value="{{ $virus->id }}" @if ($data->viruses_id == $virus->id) selected @endif>
                            {{ $virus->name }}
                        </option>
                    @endforeach
                </x-select>
                <x-input id="file" type="file" name="file" label="File Sekuen" class="mb-3" required />
                @isset($data->filename)
                    <span class="badge badge-primary badge-sm mb-6">
                        File sudah terupload
                    </span>
                @endisset
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
