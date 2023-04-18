@extends('frontend.layout')
@section('content')
<div class="xl:flex xl:px-10 xl:m-0  xl:py-5">
    <div class="xl:flex-1 xl:w-72">
        <h4 class="text-2xl">{{ $citation->title }}</h4>
        @foreach ($citation->sample as $item)
        <div class="pb-5">
            <p class="text-lg">Kode Sampel: {{ $item->sample_code }}</p>
            <hr>
            <p> >{{ $item->gene_name }}</p>
            <div class="xl:w-20">
                <p>{{ $item->sequence_data }}</p>
            </div>
        </div>
        @endforeach
    </div>
    <div class="hidden xl:block xl:flex-none align-top">
        <table>
            <tbody>
                <tr>Analyze this Sequence</tr>
                
            </tbody>
        </table>
    </div>
</div>
@endsection