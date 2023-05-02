@extends('frontend.layout')
<style>
footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  
}
</style>
@section('content')
<div class="xl:flex xl:px-10 xl:m-0  xl:py-5">
    <div class="xl:flex-1 xl:w-72">
        <h4 class="text-2xl">{{ $citation['title'] }}</h4>
        {{-- @foreach ($citation->sample as $item) --}}
        <div class="pb-5">
            <p class="text-lg">Kode Sampel: {{ $citation['accession_ncbi'] }}</p>
            <hr>
            <p> >{{ $citation['gene_name'] }}</p>
            <div class="w-10 xl:w-40">
                <p>{{ $citation['sequence_data'] }}</p>
            </div>
        </div>
        {{-- @endforeach --}}
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