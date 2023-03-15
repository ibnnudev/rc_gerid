@foreach ($virus->genotipes as $genotipe)
    {{ $genotipe->genotipe_code }} @if ($loop->last)
    @else
        —
    @endif
@endforeach
