@if ($data->status == 2)
    {{-- <span class="text-red-500">Ditolak</span> --}}
    {{-- <p>
        Ditolak oleh {{ $data->rejectedBy->name ?? null }}
    </p> --}}
    <p>{{ $data->rejected_reason ?? null }}</p>
@else
    <p class="text-center">-</p>
@endif
