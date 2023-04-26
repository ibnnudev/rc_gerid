<x-app-layout>
    <x-breadcrumbs name="import-request.show" :data="$importRequest" />
    <h1 class="font-semibold text-lg my-8">Detail Permintaan</h1>

    <x-card-container>
        <table id="singleRequests" class="w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kd. Sampel</th>
                    <th>Kd. File</th>
                    <th>Virus</th>
                    <th>Genotipe & Subtipe</th>
                    <th>Tanggal</th>
                    <th>Tempat</th>
                    <th>Provinsi</th>
                    <th>Gen</th>
                    <th>Sitasi</th>
                    <th>File Sequence</th>
                    <th></th>
                    <th>Menu</th>
                </tr>
            </thead>
        </table>
    </x-card-container>
    @push('js-internal')
        <script>
            $(function() {
                $('#singleRequests').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: '{{ route('admin.import-request.show', $importRequest->id) }}',
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
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ],
                    // hide citation
                    columnDefs: [{
                        targets: [9],
                        visible: false,
                        searchable: false
                    }, ],
                });
            });
        </script>
    @endpush
</x-app-layout>
