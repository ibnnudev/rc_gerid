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
            <tbody>
                @forelse ($authors as $author)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $author->name }}</td>
                        <td>
                            {{ $author->member }}
                        </td>
                        <td>{{ $author->institution->name }}</td>
                        <td>
                            <div class="lg:flex gap-x-2">
                                <a href="{{ route('admin.author.show', $author->id) }}"
                                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
                                    <i class="fas fa-eye fa-sm"></i>
                                </a>
                                <a href="{{ route('admin.author.edit', $author->id) }}"
                                    class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
                                    <i class="fas fa-edit fa-sm"></i>
                                </a>
                                <label for="modal" data-name="{{ $author->name }}" data-id="{{ $author->id }}"
                                    onclick="btnDelete(this)"
                                    class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
                                    <i class="fas fa-trash fa-sm"></i>
                                </label>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
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
                    columnDefs: [{
                        targets: '_all',
                        className: 'text-left'
                    }, ],
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
