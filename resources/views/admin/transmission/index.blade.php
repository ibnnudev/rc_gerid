<x-app-layout>
    <x-breadcrumbs name="transmission" />
    <h1 class="font-semibold text-lg my-8">Daftar Transmisi</h1>

    <x-card-container>

        <div class="text-end">
            <x-link-button route="{{ route('admin.transmission.create') }}" color="gray">
                Tambah Transmisi
            </x-link-button>
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="w-full" id="transmissionTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Transmisi</th>
                        <th>Menu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transmissions as $transmission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $transmission->name }}
                            </td>
                            <td>
                                <div class="lg:flex gap-x-2">
                                    <a href="{{ route('admin.transmission.edit', $transmission->id) }}"
                                        class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
                                        <i class="fas fa-edit fa-sm"></i>
                                    </a>
                                    <label for="modal"
                                        onclick="btnDelete('{{ $transmission->id }}', '{{ $transmission->name }}')"
                                        class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
                                        <i class="fas fa-trash fa-sm"></i>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
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
            function btnDelete(dataId, dataName) {
                let id = dataId;
                let name = dataName;
                // console.log(id, name);
                let url = '{{ route('admin.transmission.destroy', ':id') }}';
                let urlDelete = url.replace(':id', id);

                $('#data').html(name);
                $('form').attr('action', urlDelete);
            }

            $(function() {
                $('#transmissionTable').DataTable({
                    "responsive": true,
                    "autoWidth": false,
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
