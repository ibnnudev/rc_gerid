<x-app-layout>
    <x-breadcrumbs name="user-management" />
    <h1 class="font-semibold text-lg my-8">
        Manajemen Pengguna
    </h1>

    <x-card-container>
        <table id="usersTable" class="w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tgl. Bergabung</th>
                    <th>Status Aktivasi</th>
                    <th>Menu</th>
                </tr>
            </thead>
        </table>
    </x-card-container>

    @push('js-internal')
        <script>
            function changeRole(value, id) {
                Swal.fire({
                    title: 'Ubah Role Pengguna',
                    text: 'Apakah anda yakin ingin mengubah role pengguna ini?',
                    icon: 'warning',
                    confirmButtonText: 'Ya, ubah!',
                    confirmButtonColor: '#19743b',
                    cancelButtonText: 'Tidak, batalkan!',
                    cancelButtonColor: '#d33',
                    showCancelButton: true,
                    reverseButtons: true,
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('admin.user-management.role') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                role: value,
                                id: id
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response == true) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: 'Role pengguna berhasil diubah.',
                                        icon: 'success',
                                    })
                                } else {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: 'Role pengguna gagal diubah.',
                                        icon: 'error',
                                    })
                                }
                            },
                        });
                    }
                })
            }

            $(function() {
                $('#usersTable').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: "{{ route('admin.user-management.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'is_active',
                            name: 'is_active'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                });

                // get role select
                $('#role').on('change', function() {
                    console.log($('option:selected', this).val());
                });
            });

            @if (Session::has('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ Session::get('success') }}",
                    icon: 'success',
                })
            @endif
        </script>
    @endpush
</x-app-layout>
