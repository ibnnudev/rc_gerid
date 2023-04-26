@if ($data->status == 3)
    <p>
        Diimport oleh {{ $data->importedBy->name }}
    </p>
@else
    <p class="text-center">-</p>
@endif
