@if ($data->status == 3 && $data->removed_by == null)
    <div class="lg:flex gap-x-2">
        <x-link-button onclick="btnDelete('{{ $data->id }}', '{{ $data->file_code }}')" color="red">
            Hapus
        </x-link-button>
    </div>
@elseif ($data->status == 3 && $data->removed_by != null)
    <div class="lg:flex gap-x-2">
        <x-link-button onclick="btnRecovery('{{ $data->id }}', '{{ $data->file_code }}')" class="bg-primary">
            Kembalikan
        </x-link-butt>
    </div>
@endif
