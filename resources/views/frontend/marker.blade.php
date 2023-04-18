@extends('frontend.layout')
@include('frontend.component-map.mapMarker')
@section('content')

<section class="bg-white mt-2 mb-2 m">
    <div class="grid grid-cols-1 gap-4 place-items-center max-w-screen px-4 shadow  lg:pb-8 lg:px-25  ">
        <div class="py-2">
            {{-- text  Desciption--}}
                {!! htmlspecialchars_decode(nl2br($virus->description )) !!}
            {{-- grid gambar --}}
        </div>
    </div>
</section>

{{-- Map --}}
<section>
    <div class="lg:flex bg-gray-200">
        {{-- filter --}}
        <div class="p-6 lg:flex-none">
            <h3 class="text-lg font-semibold mb-4">Filter</h3>
            <div class="mb-2">
                <x-select id="gender" label="Gender" name="gender" isFit="false" required>
                    <option selected disabled>Choose...</option>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                </x-select>
            </div>
            {{-- multi min max range year slider --}}
            <div class="d-inline">
                <div class="pb-2">
                    <x-select id="startYear" label="Tahun Mulai" name="startYear" isFit="false" required class="mt-0">
                        @foreach ($years as $year)
                            @if ($loop->first)
                                <option value="{{ $year->year }}" selected>{{ $year->year }}</option>
                            @else
                                <option value="{{ $year->year }}">{{ $year->year }}</option>
                            @endif
                        @endforeach
                    </x-select>
                </div>
                <div class="pb-2">
                    <x-select id="endYear" label="Tahun Selesai" name="endYear" isFit="false" required class="mt-0">
                        @foreach ($years as $year)
                            @if ($loop->first)
                                <option value="{{ $year->year }}" selected>{{ $year->year }}</option>
                            @else
                                <option value="{{ $year->year }}">{{ $year->year }}</option>
                            @endif
                        @endforeach
                    </x-select>
                </div>
            </div>
            <div class="d-grid">
                <button type="button" id="btnFilter" class="btn btn-primary w-full">
                    Jalankan Filter
                </button>
            </div>
            {{-- Slider --}}
            <div id="slider" class="mt-4 mb-4 mx-2" style="z-index: 999;"></div>
            <div class="grid justify-items-center">
                <button type="button" id="btnTimelapse" class="btn btn-primary w-full mb-2">
                    Jalankan Timelapse
                </button>
                {{-- button reset all filter --}}
                <button type="button" id="btnReset" class="btn btn-danger  w-full">
                    Reset Filter
                </button>
            </div>
        </div>
        <div class="p-6 lg:flex-1 lg:w-60" id="map">
        </div>
    </div>
    <div class="md:grid md:grid-cols-2 gap-x-4 pt-10">
        <x-card-container>
            <div class="flex justify-between items-center">
                <h3 class="font-semibold">Persebaran Virus {{ $virus->name }}</h3>
                <div>
                    {{-- input year with select2 --}}
                    <x-select name="year" id="year" class="max-w-sm">
                        <option value="">sa</option>
                        {{-- @foreach ($years as $year)
                            <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach --}}
                    </x-select>
                </div>
            </div>
            <div style="height: 300px" class="relative">
                <canvas id="persebaranVirus" class="absolute z-10"></canvas>
            </div>
        </x-card-container>

        <x-card-container>
            <div class="flex justify-between items-center">
                <h3 class="font-semibold">Persebaran Virus {{ $virus->name }} berdasarkan Gen</h3>
                <div>
                    {{-- input year with select2 --}}
                    <x-select name="sampleYear" id="sampleYear" class="max-w-sm">
                        <option value="">2020</option>
                        {{-- @foreach ($years as $year)
                            <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach --}}
                    </x-select>
                </div>
            </div>
            <div style="height: 300px" class="relative" id="sampleVirusContainer">
                <canvas id="persebaranVirusByGen" class="absolute z-10"></canvas>
            </div>
        </x-card-container>
    </div>
</section>
@endsection
@push('js-internal')
    <script>
        var chart = new Chart(document.getElementById("persebaranVirusByGen").getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'September', 'Oktober', 'November', 'Desember'], 
                // responsible for how many bars are gonna show on the chart
                // create 12 datasets, since we have 12 items
                // data[0] = labels[0] (data for first bar - 'Standing costs') | data[1] = labels[1] (data for second bar - 'Running costs')
                // put 0, if there is no data for the particular bar
                datasets: [{
                    label: 'CRF01_AE',
                    data: [2, 8, 10, 10, 200, 300],
                    backgroundColor: '#22aa99'
                }, {
                    label: 'CRF01_AG',
                    data: [100, 8, 10, 10, 200, 300],
                    backgroundColor: '#994499'
                }, {
                    label: 'B[0]',
                    data: [50, 8, 10, 10, 200, 300],
                    backgroundColor: '#316395'
                }]
            },
             options: {
                maintainAspectRatio: false,
                reponsive: true,
                plugins: {
                    legend: {
                        labels: {
                            usePointStyle: true,
                            boxWidth: 5,
                            boxHeight: 5,
                        },
                    },
                },
                scales: {
                    y: {
                        // stack the bar
                        stacked: true,
                        grid: {
                            display: false,
                        },
                        ticks: {
                            beginAtZero: true,
                            precision: 0,
                            stepSize: 1,
                        },
                    },
                    x: {
                        // stack the bar
                        stacked: true,
                        grid: {
                            display: false,
                        },
                        ticks: {
                            beginAtZero: true,
                            precision: 0,
                            stepSize: 1,
                        },
                    },
                },
            },
            });
    </script>
@endpush