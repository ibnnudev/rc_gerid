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

            function btnRecovery(id, fileCode) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Kembalikan Sekuen',
                    text: 'Apakah anda yakin ingin mengembalikan data sekuen pada kode file ' + fileCode + '?',
                    showCancelButton: true,
                    confirmButtonText: 'Kembalikan',
                    confirmButtonColor: '#19743b',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.bank.recovery-by-file-code') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                file_code: fileCode
                            },
                            success: function(response) {
                                if (response.status == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message
                                    });
                                    $('#importTable').DataTable().ajax.reload();
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: response.message
                                    });
                                }
                            }
                        });
                    }
                });
            }

            function btnDelete(id, fileCode) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Hapus Sekuen',
                    text: 'Apakah anda yakin ingin menghapus data sekuen pada kode file ' + fileCode + '?',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    confirmButtonColor: '#d33',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.bank.delete-by-file-code') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                file_code: fileCode
                            },
                            success: function(response) {
                                if (response.status == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message
                                    });
                                    $('#importTable').DataTable().ajax.reload();
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: response.message
                                    });
                                }
                            }
                        });
                    }
                });
            }

            $(function() {
                $('#importTable').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: true,
                    ajax: "{{ route('admin.bank.imported') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'file',
                            name: 'file'
                        },
                        {
                            data: 'file_code',
                            name: 'file_code'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'approved',
                            name: 'approved'
                        },
                        {
                            data: 'rejected',
                            name: 'rejected'
                        },
                        {
                            data: 'imported',
                            name: 'imported'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            });
        </script>
    @endpush

</x-app-layout>
