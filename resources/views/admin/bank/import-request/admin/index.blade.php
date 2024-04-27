<x-app-layout>
    <x-breadcrumbs name="import-request.admin" />
    <h1 class="font-semibold text-lg my-8">
        Daftar Permintaan {{ auth()->user()->role == 'validator' ? 'Validasi' : 'Import' }}
    </h1>
    <x-card-container>

        <table class="w-full" id="importTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Jenis Virus</th>
                    <th>File</th>
                    <th>Kode File</th>
                    <th>Waktu</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Menu</th>
                </tr>
            </thead>
        </table>
    </x-card-container>

    {{-- Modal Form --}}
    <input type="checkbox" id="my-modal-4" class="modal-toggle" />
    <label for="my-modal-4" class="modal cursor-pointer">
        <label class="modal-box relative" for="">
            <h3 class="text-lg font-bold">Formulir ubah status permintaan</h3>
            <p class="py-4">
                <x-input id="status" name="status" label="Status Permintaan" type="text" disabled />
                <x-textarea id="reason" name="reason" label="Alasan"></x-textarea>

            <div class="text-end">
                <x-link-button onclick="$('#my-modal-4').prop('checked', false);" color="gray">
                    Batal
                </x-link-button>
                <x-button>Simpan</x-button>
            </div>
            </p>
        </label>
    </label>

    @push('js-internal')
        <script>
            function changeStatus(id, value) {
                // unbind any existing click events
                $('button[type="submit"]').unbind('click');

                $('#reason').val('');

                if (value == 'accepted' || value == 'rejected') {
                    $('#my-modal-4').prop('checked', true);
                    $('input[name="status"]').val(value == 'accepted' ? 'Disetujui' : 'Ditolak');
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Ubah Status',
                        text: 'Apakah anda yakin ingin mengubah status permintaan ini?',
                        showCancelButton: true,
                        confirmButtonText: 'Ubah',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#19743b',
                        cancelButtonColor: '#dc3545',
                    }).then((result) => {
                        $.ajax({
                            url: '{{ route('admin.import-request.change-status') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id,
                                status: value,
                                reason: $('#reason').val()
                            },
                            datatype: 'json',
                            success: function(response) {
                                if (response == true) {
                                    Swal.fire({
                                        title: 'Berhasil',
                                        text: response.message,
                                        icon: 'success'
                                    }).then(() => {
                                        $('#importTable').DataTable().ajax.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal',
                                        text: response.message,
                                        icon: 'error'
                                    }).then(() => {
                                        $('#importTable').DataTable().ajax.reload();
                                    });
                                }
                            },
                        });
                    });
                }

                $('button[type="submit"]').click(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: '{{ route('admin.import-request.change-status') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,
                            status: value,
                            reason: $('#reason').val()
                        },
                        datatype: 'json',
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Mohon Tunggu',
                                text: 'Sedang mengubah status permintaan',
                                icon: 'info',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                showConfirmButton: false,
                                willOpen: () => {
                                    Swal.showLoading();
                                },
                            });
                        },
                        success: function(response) {
                            if (response == true) {
                                Swal.fire({
                                    title: 'Berhasil',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    $('#importTable').DataTable().ajax.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal',
                                    text: response.message,
                                    icon: 'error'
                                }).then(() => {
                                    $('#importTable').DataTable().ajax.reload();
                                });
                            }

                            $('#my-modal-4').prop('checked', false);
                        },
                    });
                });
            }

            function btnDelete(id, name) {
                let url = '{{ route('admin.import-request.destroy', ':id') }}';
                url = url.replace(':id', id);
                Swal.fire({
                    title: 'Hapus Data',
                    text: `Apakah anda yakin ingin menghapus data ${name}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#19743b',
                    cancelButtonColor: '#dc3545',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                Swal.fire({
                                    title: 'Berhasil',
                                    text: `Data ${name} berhasil dihapus`,
                                    icon: 'success',
                                    confirmButtonColor: '#19743b',
                                }).then(() => {
                                    $('#importTable').DataTable().ajax.reload();
                                });
                            },
                        });
                    }
                });
            }

            $(function() {
                $('#importTable').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: '{{ route('admin.import-request.admin') }}',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'virus_type',
                            name: 'virus_type'
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
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            searchable: false,
                            orderable: false
                        },
                    ]
                });
            });

            @if (Session::has('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ Session::get('success') }}',
                })
            @endif

            @if (Session::has('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ Session::get('error') }}',
                })
            @endif
        </script>
    @endpush

</x-app-layout>
