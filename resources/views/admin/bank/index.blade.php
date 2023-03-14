<x-app-layout>
    <x-breadcrumbs name="bank" />
    <h1 class="font-semibold text-lg my-8">Bank Data</h1>

    <x-card-container>
        <div class="text-end mb-4">
            <x-link-button route="{{ route('admin.bank.create') }}" color="gray">
                Tambah Bank Data
            </x-link-button>
        </div>

        <table id="samplesTable" class="w-full">
            <thead>
                <tr>
                    <th>Kd. Sampel</th>
                    <th>Virus</th>
                    <th>Genotipe & Subtipe</th>
                    <th>Tanggal</th>
                    <th>Tempat</th>
                    <th>Gen</th>
                    <th>Judul</th>
                    <th>Author</th>
                    <th>Menu</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($samples as $sample)
                    <tr>
                        <td>{{ $sample->sample_code }}</td>
                        <td>{{ $sample->virus->name }}</td>
                        <td>{{ $sample->genotipe->genotipe_code }}</td>
                        <td>{{ date('M, Y', strtotime($sample->pickup_date)) }}</td>
                        <td>{{ $sample->place }}</td>
                        <td>{{ $sample->gene_name }}</td>
                        <td>
                            {{ $sample->citations->title }}
                        </td>
                        <td>{{ $sample->author->name }}</td>
                        <td>
                            <div class="lg:flex gap-x-2">
                                <a href="{{ route('admin.bank.show', $sample->id) }}"
                                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
                                    <i class="fas fa-eye fa-sm"></i>
                                </a>
                                <a href="{{ route('admin.bank.edit', $sample->id) }}"
                                    class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
                                    <i class="fas fa-edit fa-sm"></i>
                                </a>
                                <label for="modal"
                                    onclick="btnDelete('{{ $sample->id }}', '{{ $sample->sample_code }}')"
                                    class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
                                    <i class="fas fa-trash fa-sm"></i>
                                </label>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
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

            $(function() {
                $('#samplesTable').DataTable({
                    responsive: true,
                    autoWidth: false,
                    processing: true,
                    // fit content all column
                    columnDefs: [{
                        targets: 'no-sort',
                        orderable: false,
                    }],
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
