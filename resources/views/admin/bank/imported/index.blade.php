<x-app-layout>
    <x-breadcrumbs name="bank.imported" />
    <h1 class="font-semibold text-lg my-8">Daftar File Terimpor</h1>

    <x-card-container>
        <table class="w-full" id="importTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>File</th>
                    <th>Kode File</th>
                    <th>Waktu</th>
                    <th>Persetujuan</th>
                    <th>Penolakan</th>
                    <th>Status Import</th>
                    <th>Status</th>
                    <th>Menu</th>
                </tr>
            </thead>
        </table>
    </x-card-container>

    @push('js-internal')
        <script>
            $(function () {
                $('#importTable').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: true,
                    ajax: "{{ route('admin.bank.imported') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'file', name: 'file'},
                        {data: 'file_code', name: 'file_code'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'approved', name: 'approved'},
                        {data: 'rejected', name: 'rejected'},
                        {data: 'imported', name: 'imported'},
                        {data: 'status', name: 'status'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
            });
        </script>
    @endpush

</x-app-layout>
