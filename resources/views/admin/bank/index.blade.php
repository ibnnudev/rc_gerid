<x-app-layout>
    <x-breadcrumbs name="bank" />
    <h1 class="font-semibold text-lg my-8">Bank Data</h1>

    <x-card-container>
        <div class="sm:flex justify-end items-end mb-4">
            <x-link-button route="{{ route('admin.bank.create') }}" class="mr-2" color="gray">
                Tambah Bank Data
            </x-link-button>
            <x-link-button id="btnImport" class="bg-primary">
                Import Sampel
            </x-link-button>
            <form id="formImport" action="{{ route('admin.bank.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="import_file" hidden>
                <input type="submit" hidden>
            </form>
        </div>

        <table id="samplesTable" class="w-full">
            <thead>
                <tr>
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
                    $('#formImport').submit();
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
                    ]
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
