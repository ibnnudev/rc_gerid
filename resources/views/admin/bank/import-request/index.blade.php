<x-app-layout>
    <x-breadcrumbs name="import-request" />
    <h1 class="font-semibold text-lg my-8">
        Daftar Permintaan
    </h1>
    <x-card-container>
        @isset($failures)
            <div id="alert-2" class="flex p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
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
                        @foreach ($failures as $failure)
                            <li>
                                <span class="text-red-600 dark:text-red-400">Baris {{ $failure->row() }}</span> -
                                {{ $failure->errors()[0] }}
                            </li>
                        @endforeach
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
        @endisset

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
                <span class="font-medium">Tata cara melakukan permintaan import data sequence:</span>
                <ul class="mt-1.5 ml-4 list-decimal">
                    <li>Pilih File</li>
                    <li>Klik tombol Import</li>
                    <li>Tunggu hingga proses selesai</li>
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

        <div class="text-end mb-3">
            <x-link-button id="btnImport" color="gray" route="{{ route('admin.import-request.create') }}">
                Import Sampel
            </x-link-button>
        </div>

        <table class="w-full" id="importTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>File</th>
                    <th>Kode File</th>
                    <th>Waktu</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Menu</th>
                </tr>
            </thead>
        </table>
    </x-card-container>

    @push('js-internal')
        <script>
            function btnDelete(id, name) {
                let url = '{{ route('admin.import-request.destroy', ':id') }}';
                url = url.replace(':id', id);
                Swal.fire({
                    title: 'Hapus Data',
                    text: `Apakah anda yakin ingin menghapus data ${name}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#19743b',
                    cancelButtonColor: '#dc3545',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                Swal.fire({
                                    title: 'Berhasil',
                                    text: `Data ${name} berhasil dihapus`,
                                    icon: 'success',
                                    confirmButtonColor: '#19743b',
                                }).then(() => {
                                    $('#importTable').DataTable().ajax.reload();
                                });
                            },
                        });
                    }
                });
            }

            function btnImport(id, name) {
                Swal.fire({
                    title: 'Import Data',
                    text: `Apakah anda yakin ingin mengimport data ${name}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Import',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#19743b',
                    cancelButtonColor: '#dc3545',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('admin.import-request.import') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Berhasil',
                                    text: `Data ${name} berhasil diimport`,
                                    icon: 'success'
                                }).then(() => {
                                    $('#importTable').DataTable().ajax.reload();
                                });
                            },
                            error: function(response) {
                                Swal.fire({
                                    title: 'Gagal',
                                    text: `Data ${name} gagal diimport`,
                                    icon: 'error'
                                }).then(() => {
                                    $('#importTable').DataTable().ajax.reload();
                                });
                            }
                        });
                    }
                });
            }

            $(function() {
                $('#importTable').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: '{{ route('admin.import-request.index') }}',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'file',
                            name: 'file'
                        },
                        {
                            data: 'file_code',
                            name: 'file_code'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            searchable: false,
                            orderable: false
                        },
                    ],
                });
            });

            @if (Session::has('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ Session::get('success') }}',
                })
            @endif

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
