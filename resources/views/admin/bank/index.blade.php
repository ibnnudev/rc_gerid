<x-app-layout>
    <x-breadcrumbs name="bank" />
    <h1 class="font-semibold text-lg my-8">Bank Data</h1>

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

    {{-- Statistic --}}
    <div class="xl:grid xl:grid-cols-6 gap-x-3 mb-2 sm:block">
        {{-- Total HIV --}}
        <div class="stats shadow mb-4 w-full overflow-hidden">
            <div class="stat w-full">
                <div class="stat-title">Sampel Hepatitis B</div>
                <div class="stat-value text-sm mt-2">
                    {{ number_format($totalSample->where('virus.name', 'Hepatitis B')->count(), 0, ',', '.') ?? 0 }}
                </div>
            </div>
        </div>
        {{-- Total HIV --}}
        <div class="stats shadow mb-4 w-full overflow-hidden">
            <div class="stat w-full">
                <div class="stat-title">Sampel Hepatitis C</div>
                <div class="stat-value text-sm mt-2">
                    {{ number_format($totalSample->where('virus.name', 'Hepatitis C')->count(), 0, ',', '.') ?? 0 }}
                </div>
            </div>
        </div>
        {{-- Total HIV --}}
        <div class="stats shadow mb-4 w-full overflow-hidden">
            <div class="stat w-full">
                <div class="stat-title">Sampel Dengue</div>
                <div class="stat-value text-sm mt-2">
                    {{ number_format($totalSample->where('virus.name', 'Dengue')->count(), 0, ',', '.') ?? 0 }}
                </div>
            </div>
        </div>
        {{-- Total HIV --}}
        <div class="stats shadow mb-4 w-full overflow-hidden">
            <div class="stat w-full">
                <div class="stat-title">Sampel Norovirus</div>
                <div class="stat-value text-sm mt-2">
                    {{ number_format($totalSample->where('virus.name', 'Norovirus')->count(), 0, ',', '.') ?? 0 }}
                </div>
            </div>
        </div>
        {{-- Total HIV --}}
        <div class="stats shadow mb-4 w-full overflow-hidden">
            <div class="stat w-full">
                <div class="stat-title">Sampel Rotavirus</div>
                <div class="stat-value text-sm mt-2">
                    {{ number_format($totalSample->where('virus.name', 'Rotavirus')->count(), 0, ',', '.') ?? 0 }}
                </div>
            </div>
        </div>
        {{-- Total HIV --}}
        <div class="stats shadow mb-4 w-full overflow-hidden">
            <div class="stat w-full">
                <div class="stat-title">Sampel HIV</div>
                <div class="stat-value text-sm mt-2">
                    {{ number_format($totalSample->where('virus.name', 'HIV')->count(), 0, ',', '.') ?? 0 }}
                </div>
            </div>
        </div>
    </div>

    <x-card-container>
        <div class="sm:flex justify-between items-center mb-4 space-y-2">
            <div>
                <x-link-button route="{{ route('admin.bank.advanced-search') }}" color="gray">
                    Pencarian Advanced
                </x-link-button>
            </div>
            <div class="sm:flex
                sm:space-y-0 space-y-2
            ">
                <x-link-button route="{{ route('admin.bank.imported') }}" class="mr-2" color="gray">
                    <i class="fas fa-file-import mr-2"></i>
                    Daftar Permintaan
                </x-link-button>
                <x-link-button id="btnDownload" class="mr-2"
                    route="{{ asset('assets/file/format data sekuen.xlsx') }}" color="gray" target="_blank">
                    <i class="fas fa-download mr-2"></i>
                    Unduh Template
                </x-link-button>
                <x-link-button route="{{ route('admin.bank.create') }}" class="mr-2" color="gray">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Sampel
                </x-link-button>
                <x-link-button id="btnImport" class="bg-primary">
                    <i class="fas fa-file-import mr-2"></i>
                    Import Sampel
                </x-link-button>
                <form id="formImport" action="{{ route('admin.bank.import') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="import_file" hidden>
                    <input type="submit" hidden>
                </form>
            </div>
        </div>

        <div class="overflow-auto">
            <table id="samplesTable" class="w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kd. Sampel</th>
                        <th>Virus</th>
                        <th>Genotipe & Subtipe</th>
                        <th>Tanggal</th>
                        <th>Tempat</th>
                        <th>Provinsi</th>
                        <th>Gen</th>
                        <th>Sitasi</th>
                        <th>File Sequence</th>
                        <th>Menu</th>
                    </tr>
                </thead>
            </table>
        </div>
    </x-card-container>

    <!-- Put this part before </body> tag -->
    <input type="checkbox" id="modal" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">
                Konfirmasi Penghapusan
            </h3>
            <p class="py-4">
                Apakah kamu yakin ingin menghapus data <span id="data" class="font-semibold"></span> ini?
            </p>
            <div class="modal-action">
                <form action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 px-2 rounded-md text-xs p-2 text-center inline-flex items-center">
                        Hapus
                    </button>
                </form>
                <label for="modal"
                    class="text-white bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 px-2 rounded-md text-xs p-2 text-center inline-flex items-center">
                    Batal
                </label>
            </div>
        </div>
    </div>

    @push('js-internal')
        <script>
            function btnDelete(_id, _name) {
                const id = _id;
                const name = _name;
                const url = '{{ route('admin.bank.destroy', ':id') }}';
                const urlDelete = url.replace(':id', id);

                document.querySelector('#data').innerHTML = name;
                document.querySelector('.modal-action form').action = urlDelete;
            }

            $('#btnImport').click(function() {
                $('input[name="import_file"]').click();

                $('input[name="import_file"]').change(function() {
                    // check file extension is .xlsx
                    const file = $('input[name="import_file"]').val();
                    const extension = file.substr((file.lastIndexOf('.') + 1));
                    if (extension != 'xlsx') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Format file harus .xlsx',
                        });
                        return;
                    }
                    // confirm
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah anda yakin ingin mengimpor data ini?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Tidak',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#formImport').submit();
                        }
                    });
                });
            });

            $(function() {

                $('#formImport').on('submit', function() {
                    Swal.fire({
                        title: 'Mohon tunggu',
                        text: 'Sedang memproses data',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    });
                });


                $('#samplesTable').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: '{{ route('admin.bank.index') }}',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'sample_code',
                            name: 'sample_code'
                        },
                        {
                            data: 'virus',
                            name: 'virus'
                        },
                        {
                            data: 'genotipe',
                            name: 'genotipe'
                        },
                        {
                            data: 'pickup_date',
                            name: 'pickup_date'
                        },
                        {
                            data: 'place',
                            name: 'place'
                        },
                        {
                            data: 'province',
                            name: 'province'
                        },
                        {
                            data: 'gene_name',
                            name: 'gene_name'
                        },
                        // {
                        //     data: 'title',
                        //     name: 'title'
                        // },
                        {
                            data: 'citation',
                            name: 'citation'
                        },
                        {
                            data: 'file_sequence',
                            name: 'file_sequence'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ],
                    // hide citation
                    columnDefs: [{
                        targets: [8],
                        visible: false,
                        searchable: false
                    }],
                    /*
                        dom: 'Bfrtip',
                    buttons: [{
                        extend: 'csv',
                        filename: 'Data Sample',
                        bom: true
                    }, {
                        extend: 'excel',
                        filename: 'Data Sample',
                        bom: true,
                        exportOptions: {
                            modifier: {
                                page: 'all'
                            }
                        }
                    }, {
                        extend: 'print',
                        filename: 'Data Sample',
                        bom: true
                    }],
                    */
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
