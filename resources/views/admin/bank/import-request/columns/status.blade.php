@if ($data->status == 0)
    <span class="badge badge-warning badge-sm">
        Menunggu
    </span>
@elseif ($data->status == 1)
    <span class="badge badge-primary badge-sm">
        Disetujui
    </span>
@elseif ($data->status == 2)
    <span class="badge badge-error badge-sm">
        Ditolak
    </span>
@endif
