<x-app-layout>
    <x-breadcrumbs name="slide" />
    <h1 class="font-semibold text-lg my-8">Daftar Slide</h1>
    <x-card-container>
        <div class="text-end mb-4">
            <x-link-button route="{{ route('admin.slide.create') }}" class="mr-2" color="gray">
                <i class="fas fa-plus mr-2"></i>
                Tambah Slide
            </x-link-button>
        </div>
        <div class="mt-4 overflow-x-auto">
            <table class="w-full" id="slideTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </x-card-container>

    @push('js-internal')
        <script>
            function btnDelete(id) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('admin.slide.destroy', ':id') }}'.replace(':id', id),
                            type: 'DELETE',
                            data: {
                                '_token': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    $('#slideTable').DataTable().ajax.reload();
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Terjadi kesalahan saat menghapus data!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        });
                    }
                });
            }

            $(function() {

            });

            @if (Session::has('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ Session::get('success') }}',
                    showConfirmButton: false,
                    timer: 1500
                });
            @endif

            @if (Session::has('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ Session::get('error') }}',
                    showConfirmButton: false,
                    timer: 1500
                });
            @endif
        </script>
    @endpush
</x-app-layout>
