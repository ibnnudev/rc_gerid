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
                    <th>Status</th>
                    <th>
                        @if (auth()->user()->role == 'admin')
                            Status Aktifasi
                        @else
                            Menu
                        @endif
                    </th>
                    <th>File Sequence</th>
                    <th>Sitasi</th>
                </tr>
            </thead>
        </table>
    </x-card-container>
    @push('js-internal')
        <script>
            function changeStatus(id, value) {
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Anda akan mengubah status permintaan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#19743b',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Ubah!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = '{{route('admin.import-request.change-status-single', ':id')}}';
                        url = url.replace(':id', id);
                        $.ajax({
                            url: url,
                            type: "PUT",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id,
                                status: value
                            },
                            success: function(response) {
                                if (response.status == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message
                                    });
                                    $('#singleRequests').DataTable().ajax.reload();
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: response.message
                                    });
                                }
                            }
                        })
                    }
                })
            }

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
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                        {
                            data: 'file_sequence',
                            name: 'file_sequence'
                        },
                        {
                            data: 'citation',
                            name: 'citation'
                        }
                    ],
                });
            });
        </script>
    @endpush
</x-app-layout>
