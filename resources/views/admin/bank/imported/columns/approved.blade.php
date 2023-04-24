@if ($data->status == 1 || $data->status == 3)
    {{-- <span class="text-green-500">Disetujui</span> --}}
    {{-- <span>
        <i class="fas fa-check fa-sm text-primary"></i>
        {{ $data->acceptedBy->name }}
    </span> --}}
    <p>{{ $data->accepted_reason }}</p>
@else
    <p class="text-center">-</p>
@endif
