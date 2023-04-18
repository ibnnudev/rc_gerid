@extends('frontend.layout')
@section('content')
<style>
    table td,
    th {
        word-wrap: break-word;
        overflow: hidden;
        white-space: inherit !important;

    }
</style>
<div class="xl:flex xl:px-10 xl:m-0  xl:py-5">
    <div class="xl:flex-1 xl:w-72">
        <h4 class="xl:text-lg">{{ $citation->title }}</h4>
        <p>{{ $citation->author->institutions_id != null ? getInstitution($citation->author->institutions_id) : null }} 
        <p class="pb-2 text-blue-700" ><a href="{{ route('detailFasta', $citation->id) }}">FASTA</a></p>
        <hr>
        <table class="border table table-striped ">
            <tr>
                <td>REFERENCE</td>
                <td style="padding-left: 1em"></td>
            </tr>
            <tr>
                <td class="text-end">AUTHOR</td>
                <td style="padding-left: 1em">
                    <p class="text-blue-700"> 
                        <a href="http://www.google.com/search?q={{ $citation->author->name.",". $citation->author->member}}"
                            target="_blank" rel="noopener noreferrer">{{ $citation->author->name.",". $citation->author->member }}
                        </a>
                    </p>
                </td>
            </tr>
            <tr>
                <td class="text-end"> TITLE</td>
                <td style="padding-left: 1em">
                    <p class="text-blue-700">
                        <a href="https://www.google.com/search?q={{ $citation->title }}" target="_blank">
                        {{$citation->title }}
                        </a>
                    </p>
                </td>
            </tr>
            <tr>
                <td>FEATURE </td>
                <td style="padding-left: 1em"></td>
            </tr>
            <tr>
                <td class="text-end">virus</td>
                <td style="padding-left: 1em">
                    <p class="m-0">{{ $virus->name }}</p>
                </td>
            </tr>
            <tr>
                <td class="text-end">sampel</td>
                <td style="padding-left: 1em">
                    <p class="m-0">{{ $citation->sample[0]->sample_code }}</p>
                </td>
            </tr>
            <tr>
                <td class="text-end">gene</td>
                <td style="padding-left: 1em">
                    <p class="m-0">{{ $citation->sample[0]->gene_name }}</p>
                </td>
            </tr>
            <tr>
                <td style="width:2%">DATA SEKUEN </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="xl:ml-10 max-w-3xl h-full">
                        <p class="break-words">
                            {{ $citation->sample[0]->sequence_data }}
                        </p>
                    </div>
                </td>
            </tr>
        </table>
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
@php
    function getInstitution($id){
        return App\Models\Institution::where('id', $id)->first()->name;
    }

    
@endphp
