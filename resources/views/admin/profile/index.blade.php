<x-app-layout>
    <x-breadcrumbs name="profile" />
    <h1 class="font-semibold text-lg my-8">
        Pengaturan
    </h1>

    <div class="xl:flex gap-x-3">
        <div class="md:w-1/5">
            <x-card-container>
                <div class="avatar">
                    <div class="rounded-lg h-full">
                        <img src="{{ $user->avatar ? asset('storage/avatar/' . $user->avatar) : asset('images/noimage.jpg') }}"
                            class="object-cover" id="avatar_preview" />
                    </div>
                </div>
                <div class="mt-3">
                    <x-link-button onclick="changeAvatar()" color="gray" class="w-full justify-center">
                        Ubah Foto
                    </x-link-button>
                </div>
            </x-card-container>
        </div>
        <div>
            <x-card-container>
                <h3 class="font-semibold text-base mb-2">
                    Informasi Akun
                </h3>
                <form action="{{ route('admin.profile.update', $user->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input id="avatar" type="file" name="avatar" hidden />
                    <x-input id="name" type="text" name="name" label="Nama" value="{{ $user->name }}" />
                    <x-input id="email" type="email" name="email" label="Email" value="{{ $user->email }}" />
                    <x-input id="role" label="Role" type="text" value="{{ $user->role }}" disabled />
                    <div class="mt-4 text-end">
                        <x-button color="green">
                            Simpan
                        </x-button>
                    </div>
                </form>
            </x-card-container>
        </div>
        <div>
            <x-card-container>
                <h3 class="font-semibold text-base mb-2">
                    Ubah Password
                </h3>
                <form action="{{ route('admin.profile.change-password') }}" method="POST">
                    @csrf
                    <x-input id="old_password" type="password" name="old_password" label="Password Lama" />
                    <x-input id="new_password" type="password" name="new_password" label="Password Baru" />
                    <x-input id="new_password_confirmation" type="password" name="new_password_confirmation"
                        label="Konfirmasi Password" />
                    <div class="mt-4 text-end">
                        <x-button color="green">
                            Simpan
                        </x-button>
                    </div>
                </form>
            </x-card-container>
        </div>
    </div>

    @push('js-internal')
        <script>
            function changeAvatar() {
                $('#avatar').click();

                $('#avatar').on('change', function() {
                    var file = $(this)[0].files[0];
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#avatar_preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                });
            }

            @if (Session::has('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ Session::get('success') }}'
                })
            @endif

            @if (Session::has('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ Session::get('error') }}'
                })
            @endif
        </script>
    @endpush
</x-app-layout>
