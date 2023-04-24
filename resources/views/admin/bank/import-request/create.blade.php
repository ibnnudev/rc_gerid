<x-app-layout>
    <x-breadcrumbs name="import-request.create" />
    <h1 class="font-semibold text-lg my-8">
        Tambah Permintaan
    </h1>
    
    <div class="xl:grid grid-cols-2 gap-x-3">
        <div id="alert-2"
            class="error hidden flex p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
            role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">
                    Periksa kembali file yang diupload, terdapat beberapa data yang tidak sesuai dengan format yang
                </span>
                <ul class="mt-1.5 ml-4 list-disc list-inside">

                </ul>
            </div>
            <button type="button"
                class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                data-dismiss-target="#alert-2" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <x-card-container>
            <form action="{{ route('admin.import-request.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-input id="file" type="file" name="file" label="File Sekuen" class="mb-3" required />
                <x-textarea id="description" name="description" label="Deskripsi"></x-textarea>

                <div class="text-end">
                    {{-- <x-link-button :route="route('admin.import-request.index')" color="gray" class="mr-full">Batal</x-link-button> --}}
                    <x-button class="hidden">Simpan</x-button>
                </div>
            </form>
        </x-card-container>
    </div>

    @push('js-internal')
        <script>
            $(function() {
                $('#file').change(function() {
                    let formData = new FormData();
                    formData.append('file', $(this)[0].files[0]);
                    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                    $.ajax({
                        url: "{{ route('admin.import-request.validation-file') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response == true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'File yang diupload sesuai dengan format yang ditentukan',
                                });

                                $('#alert-2').addClass('hidden');
                                // show the submit button
                                $('button[type="submit"]').removeClass('hidden');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'File yang diupload tidak sesuai, periksa kembali file yang diupload'
                                });

                                $('#alert-2').removeClass('hidden');
                                $('#alert-2 ul').html('');
                                response.forEach(function(item) {
                                    $('#alert-2 ul').append(
                                        // show the row number of error
                                        '<li>Baris ke-' + item.row + ' : ' + item
                                        .errors + '</li>'
                                    );
                                });

                                $('#file').val('');
                                $('button[type="submit"]').addClass('hidden');
                            }
                        },
                    });
                });
            });

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
