<x-app-layout>
    <x-breadcrumbs name="bank.imported.user" />
    <h1 class="font-semibold text-lg my-8">Daftar Sekuen</h1>

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
        <div class="overflow-auto">
            <table id="samplesTable" class="w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kd. Sampel</th>
                        <th>Kode File</th>
                        <th>Virus</th>
                        <th>Genotipe & Subtipe</th>
                        <th>Tanggal</th>
                        <th>Tempat</th>
                        <th>Provinsi</th>
                        <th>Gen</th>
                        <th>Sitasi</th>
                        <th>File Sequence</th>
                        {{-- <th>Menu</th> --}}
                    </tr>
                </thead>
            </table>
        </div>
    </x-card-container>

    @push('js-internal')
        <script>
            $(function() {
                $('#samplesTable').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: '{{ route('admin.bank.imported') }}',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'sample_code',
                            name: 'sample_code'
                        },
                        {
                            data: 'file_code',
                            name: 'file_code'
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
                        {
                            data: 'citation',
                            name: 'citation'
                        },
                        {
                            data: 'file_sequence',
                            name: 'file_sequence'
                        },
                        // {
                        //     data: 'action',
                        //     name: 'action'
                        // },
                    ],
                    columnDefs: [{
                        targets: [9],
                        visible: false,
                        searchable: false
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
