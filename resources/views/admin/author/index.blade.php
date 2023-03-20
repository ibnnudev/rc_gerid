<x-app-layout>
    <x-breadcrumbs name="author" />
    <h1 class="font-semibold text-lg my-8">Penulis</h1>

    <div class="text-end">
        <x-link-button route="{{ route('admin.author.create') }}" color="gray">
            Tambah Penulis
        </x-link-button>
    </div>

    <div class="overflow-x-auto mt-4">
        <table id="authorsTable" class="w-full">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pengarang</th>
                    <th>Anggota</th>
                    <th>Institusi</th>
                    <th>Menu</th>
                </tr>
            </thead>
        </table>
    </div>
    </div>

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
                        class="text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 px-2 rounded-md text-sm p-2 text-center inline-flex items-center">
                        Hapus
                    </button>
                </form>
                <label for="modal"
                    class="text-white bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 px-2 rounded-md text-sm p-2 text-center inline-flex items-center">
                    Batal
                </label>
            </div>
        </div>
    </div>

    @push('js-internal')
        <script>
            function btnDelete(e) {
                const id = e.dataset.id;
                const name = e.dataset.name;
                const url = '{{ route('admin.author.destroy', ':id') }}';
                const urlDelete = url.replace(':id', id);

                document.querySelector('#data').innerHTML = name;
                document.querySelector('.modal-action form').action = urlDelete;
            }

            $(function() {
                $('#authorsTable').DataTable({
                    responsive: true,
                    autoWidth: false,
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('admin.author.index') }}',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'member',
                            name: 'member'
                        },
                        {
                            data: 'institution',
                            name: 'institution'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ]
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
            });
        </script>
    @endpush
</x-app-layout>
