<x-app-layout>
    <x-breadcrumbs name="citation" />
    <h1 class="font-semibold text-lg my-8">Sitasi</h1>

    <div class="text-end">
        <x-link-button route="{{ route('admin.citation.create') }}" color="gray">
            Tambah Sitasi
        </x-link-button>
    </div>

    <div class="overflow-x-auto mt-4">
        <table class="w-full" id="citationTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul Sitasi</th>
                    <th>Penulis</th>
                    {{-- <th>Tahun</th> --}}
                    <th>Menu</th>
                </tr>
            </thead>
        </table>
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
                const url = '{{ route('admin.citation.destroy', ':id') }}';
                const urlDelete = url.replace(':id', id);

                document.querySelector('#data').innerHTML = name;
                document.querySelector('.modal-action form').action = urlDelete;
            }

            $(function () {
                $('#citationTable').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: "{{ route('admin.citation.index') }}",
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'title', name: 'title' },
                        { data: 'author', name: 'author' },
                        // { data: 'year', name: 'year' },
                        { data: 'action', name: 'action' },
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
                    title: 'Berhasil',
                    text: '{{ Session::get('error') }}',
                });
            @endif
        </script>
    @endpush
</x-app-layout>
