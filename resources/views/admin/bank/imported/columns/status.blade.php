@if ($data->is_active == 1)
    <span class="badge badge-sm">Aktif</span>
@elseif ($data->is_active == 0)
    <span class="badge badge-sm badge-error">Tidak Aktif</span>
@endif
