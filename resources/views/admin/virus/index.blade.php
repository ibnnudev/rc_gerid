<x-app-layout>
    <x-breadcrumbs name="virus" />
    <h1 class="font-semibold text-lg my-8">Daftar Virus</h1>

    {{-- Statistic --}}
    <div class="xl:grid xl:grid-cols-6 gap-x-3 mb-4 sm:block">
        {{-- Total HIV --}}
        <div class="stats shadow mb-4 w-full overflow-hidden">
            <div class="stat w-full">
                <div class="stat-title">Hepatitis B</div>
                <div class="stat-value text-sm mt-2">
                    {{-- TODO: tampilin datanya --}}
                    0
                </div>
            </div>
        </div>
        {{-- Total HIV --}}
        <div class="stats shadow mb-4 w-full overflow-hidden">
            <div class="stat w-full">
                <div class="stat-title">Kasus Hepatitis C</div>
                <div class="stat-value text-sm mt-2">
                    {{-- TODO: tampilin datanya --}}
                    0
                </div>
            </div>
        </div>
        {{-- Total HIV --}}
        <div class="stats shadow mb-4 w-full overflow-hidden">
            <div class="stat w-full">
                <div class="stat-title">Kasus Dengue</div>
                <div class="stat-value text-sm mt-2">
                    {{-- TODO: tampilin datanya --}}
                    0
                </div>
            </div>
        </div>
        {{-- Total HIV --}}
        <div class="stats shadow mb-4 w-full overflow-hidden">
            <div class="stat w-full">
                <div class="stat-title">Kasus Norovirus</div>
                <div class="stat-value text-sm mt-2">
                    {{-- TODO: tampilin datanya --}}
                    0
                </div>
            </div>
        </div>
        {{-- Total HIV --}}
        <div class="stats shadow mb-4 w-full overflow-hidden">
            <div class="stat w-full">
                <div class="stat-title">Kasus Rotavirus</div>
                <div class="stat-value text-sm mt-2">
                    {{-- TODO: tampilin datanya --}}
                    0
                </div>
            </div>
        </div>
        {{-- Total HIV --}}
        <div class="stats shadow mb-4 w-full overflow-hidden">
            <div class="stat w-full">
                <div class="stat-title">Kasus HIV</div>
                <div class="stat-value text-sm mt-2">
                    {{ number_format($totalHIVCases, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <x-card-container>

        <div class="text-end">
            {{-- <x-link-button route="{{ route('admin.virus.create') }}" color="gray">
                Tambah Virus
            </x-link-button> --}}
        </div>

        <div class="mt-4 overflow-x-auto">
            <table class="w-full" id="virusTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Virus</th>
                        <th>Genotipe & Subtipe</th>
                        <th>Nama Latin</th>
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
                console.log(id, name);
                let url = '{{ route('admin.virus.destroy', ':id') }}';
                let urlDelete = url.replace(':id', id);

                $('#data').html(name);
                $('form').attr('action', urlDelete);
            }

            $(function() {
                $('#virusTable').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: '{{ route('admin.virus.index') }}',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'genotipe',
                            name: 'genotipe'
                        },
                        {
                            data: 'latin_name',
                            name: 'latin_name'
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
