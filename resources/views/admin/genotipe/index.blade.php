<x-app-layout>
    <x-breadcrumbs name="genotipe" />
    <h1 class="font-semibold text-lg my-8">Daftar Genotipe</h1>

    <x-card-container>

        <div class="text-end">
            <x-link-button route="{{ route('admin.genotipe.create') }}" color="gray">
                Tambah Genotipe
            </x-link-button>
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="w-full" id="genotipeTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Genotipe & Subtipe</th>
                        <th>Virus Terkait</th>
                        <th>Menu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($genotipes as $genotipe)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            {{ $genotipe->genotipe_code }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $genotipe->virus->name }}
                            </td>
                            <td>
                                <div class="lg:flex gap-x-2">
                                    <a href="{{ route('admin.genotipe.show', $genotipe->id) }}"
                                        class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
                                        <i class="fas fa-eye fa-sm"></i>
                                    </a>
                                    <a href="{{ route('admin.genotipe.edit', $genotipe->id) }}"
                                        class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
                                        <i class="fas fa-edit fa-sm"></i>
                                    </a>
                                    <label for="modal"
                                        onclick="btnDelete('{{ $genotipe->id }}', '{{ $genotipe->genotipe_code }}')"
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
                let url = '{{ route('admin.genotipe.destroy', ':id') }}';
                let urlDelete = url.replace(':id', id);

                $('#data').html(name);
                $('form').attr('action', urlDelete);
            }

            $(function() {
                $('#genotipeTable').DataTable({
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
