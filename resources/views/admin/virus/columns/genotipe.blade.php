<ul>
    @foreach ($virus->genotipes as $genotipe)
        <li>{{ $genotipe->genotipe_code }}</li>
    @endforeach
</ul>
