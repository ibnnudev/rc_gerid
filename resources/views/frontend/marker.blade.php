@extends('frontend.layout')
@include('frontend.component-map.mapMarker')
@section('content')
<style>
.description {
    font-size: 1.125rem; /* 18px */
    line-height: 1.75rem; 
}
.description li {
    margin-left: 50px;
}

.description ul {
    list-style: disc;
    display: inline;
 }

@media only screen and (max-width: 767px) {
    #virus-img{
        width: 40px;
        height: 80px;
    }
}


/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
    #virus-img{
        width: 50px;
        height: 80px;
    }
}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
    #virus-img{
        width: 80px;
        height: 160px;
    }
}

/* Extra large devices (large laptops and desktops, 1200px and up) */
@media only screen and (min-width: 1200px) {
        #virus-img{
        width: 120px;
        height:180px;
    }

}
</style>

<section class="bg-white mt-2 mb-2   ">
    <div class="grid grid-cols-1 gap-4 place-items-center max-w-screen px-4 shadow lg:pb-8 lg:px-25  ">
        <div class="py-2">
            <img id="virus-img" class="h-64 w-48 mx-auto mb-4 pt-4 lg:w-10 lg:h-10"  src="{{ $virus->image ? asset('images/' . $virus->image)  : asset('images/noimage.jpg') }}"  alt="">
            <p class="text-center text-lg lg:text-lg font-bold pb-2">{{ $virus->name }}</p>
            <div class="text-xs lg:text-lg description text-justify mx-20">
                {{-- text  Desciption --}}
                {{-- {{ $virus->description }} --}}
                {{-- {{ !$virus->description }} --}}
                {!! htmlspecialchars_decode($virus->description ) !!}
            </div>
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
                                <option value="{{ $year }}" selected>{{ $year }}</option>
                            @else
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endif
                        @endforeach
                    </x-select>
                </div>
                <div class="pb-2">
                    <x-select id="endYear" label="Tahun Selesai" name="endYear" isFit="false" required class="mt-0">
                        @foreach ($years as $year)
                            @if ($loop->first)
                                <option value="{{ $year }}" selected>{{ $year }}</option>
                            @else
                                <option value="{{ $year }}">{{ $year }}</option>
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
        {{-- pie chart --}}
        <x-card-container>
            <div class="flex justify-between items-center">
                <h3 class="font-semibold">Persebaran Virus {{ $virus->name }}</h3>
                <div>
                    {{-- input year with select2 --}}
                    <x-select name="pieChartYear" id="pieChartYear" class="max-w-sm">
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ $year == $lastYearSample ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
            </div>
            <div style="height: 300px" class="relative flex items-center justify-center" id="pieChartContainer">
                <canvas id="canvasPieChart" class="absolute z-10"></canvas>
                <p class="text-center my-auto align-middle" id="pieChartNull" hidden>Data Masih Belum Tersedia</p>
            </div>
        </x-card-container>
        {{-- genchart --}}
        <x-card-container>
            <div class="flex justify-between items-center">
                <h3 class="font-semibold">Persebaran Virus {{ $virus->name }} berdasarkan Gen</h3>
                <div>
                    {{-- input year with select2 --}}
                    <x-select name="groupChartYear" id="groupChartYear" class="max-w-sm">
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ $year == $lastYearSample ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
            </div>
            <div style="height: 300px" class="relative flex items-center justify-center" id="groupChartContainer">
                <p class="text-center" id="groupChartByYearNull" hidden>Data Masih Belum Tersedia</p>
                <canvas id="canvasGenChartByYear" class="absolute z-10" visi></canvas>
            </div>
        </x-card-container>
    </div>
    <x-card-container>
        <div class="flex justify-between items-center">
            <h3 class="font-semibold">Persebaran Virus {{ $virus->name }} berdasarkan Gen</h3>
            <div class="flex items-center" >
                <x-select name="provincy" id="provincy" class="max-w-xs">
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}" {{ $province->id == $lastCitySampleId ? 'selected' : '' }}>{{ $province->name }}
                        </option>
                    @endforeach
                </x-select>
                <x-select name="year" id="year" class="max-w-sm ">
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ $year == $lastYearSample ? 'selected' : '' }} >
                            {{ $year }}
                        </option>
                    @endforeach
                </x-select>
                <button type="button" id="renderGroupChart" class="inline-flex items-center ml-2 px-4 py-4 text-white bg-blue-700  hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span class="sr-only">Search</span>
                       Search
                </button>
            </div>
        </div>
        <div style="height: 300px" class="relative flex items-center justify-center" id="groupChartByCityContainer">
            <p class="text-center" id="groupChartByCityNull" hidden>Data Masih Belum Tersedia</p>
            <canvas id="canvasGroupChartByCity" class="absolute z-10"></canvas>
        </div>
    </x-card-container>
</section>
@endsection
@push('js-internal')
    <script>
        let virus = @json($virus);
        // set state chart
         $(document).ready(function(){
            ajaxGetPieChart($("#pieChartYear").val());
            ajaxGetGroupChart($("#groupChartYear").val());
            ajaxGetGroupChartByCity($("#year").val(),$("#provincy").val());
        });
        // on change pie chart
        $('#pieChartYear').on('change', function() {
            yearPieChart = $(this).val();
            ajaxGetPieChart(yearPieChart);
        })
        // reload pie chart
        var GenChart = null;
        function ajaxGetPieChart(params) {
            $.ajaxSetup ({
                cache:   false
            });
            $.ajax({
                    method: 'GET',
                    url: '/chartPieYear',
                    data: {
                        year: params,
                        id : virus.id
                        },
                    async: true,
                    success: function(result) {
                        if(GenChart !== null) {
                            GenChart.destroy();
                        }
                        // when data nol
                        if(result.length == 0){
                            $('#canvasPieChart').attr('hidden', true);
                            $('#pieChartNull').attr('hidden', false);
                        // else data not null
                        }else{
                            $('#canvasPieChart').attr('hidden', false);
                            $('#pieChartNull').attr('hidden', true);
                            GenChart = new Chart(document.getElementById("canvasPieChart").getContext('2d'), {
                                type: "pie",
                                data: {
                                    labels: result['label'],
                                    datasets: [{
                                    backgroundColor: ['#316395', '#22AA99', '#994499'],
                                    data: result['data']
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
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(thrownError);
                    }
            });
        }
        // on change group chart by year
        $('#groupChartYear').on('change', function() {
            yearGroupChart = $(this).val();
            ajaxGetGroupChart(yearGroupChart);
        })
        // reload change group chart by year
        var GroupChartByYear = null;
        function ajaxGetGroupChart(params) {
            $.ajaxSetup ({
                cache:   false
            });
            $.ajax({
                    method: 'GET',
                    url: '/chartGroupYear',
                    data: {
                        year: params,
                        id : virus.id
                        },
                    async: true,
                    success: function(result) {
                        // console.log(result);
                        if(GroupChartByYear !== null) {
                            GroupChartByYear.destroy();
                        }

                        let samples = [];

                        for (let i = 0; i < Object.keys(result).length; i++) {
                            samples.push({
                                label: Object.keys(result)[i],
                                data: Object.values(result)[i],
                                // backgroundColor: backgroundColor[i],
                                // borderColor: borderColor[i],
                                borderWidth: 1,
                            });
                        }
                        // when data nol
                        if(result.length == 0 || result == 'undefined'){
                            $('#canvasGenChartByYear').attr('hidden', true);
                            $('#groupChartByYearNull').attr('hidden', false);
                        // else data not null
                        }else{
                            $('#canvasGenChartByYear').attr('hidden', false);
                            $('#groupChartByYearNull').attr('hidden', true);
                            GroupChartByYear = new Chart(document.getElementById("canvasGenChartByYear").getContext('2d'), {
                                type: 'bar',
                                data: {
                                    labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni','Juli','Agustus', 'September', 'Oktober', 'November', 'Desember'], 
                                    datasets: samples 
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
                        }

                        

                    
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(thrownError);
                    }
            });
        }
        // on change group chart by city
        $('#renderGroupChart').on('click', function() {
            ajaxGetGroupChartByCity($("#year").val(),$("#provincy").val());
        })
        // reload the group chart by city
        var GroupChartByCity = null;
        function ajaxGetGroupChartByCity(years,provincies) {
            $.ajaxSetup ({
                cache:   false
            });
            $.ajax({
                    method: 'GET',
                    url: '/chartGroupCity',
                    data: {
                        provincy : provincies,
                        year: years,
                        id : virus.id
                        },
                    async: true,
                    success: function(result) {
                        console.log(result);
                        if(GroupChartByCity !== null) {
                            GroupChartByCity.destroy();
                        }
                        // let backgroundColor = [
                        //         // generate 6 random color
                        //         "rgba(25, 116, 59, 0.1)",
                        //         "rgba(255, 0, 0, 0.1)",
                        //         "rgba(0, 0, 255, 0.1)",
                        //         "rgb(250, 128, 114, 0.1)",
                        //         "rgba(255, 0, 255, 0.1)",
                        //         "rgba(0, 255, 255, 0.1)",
                        //     ];

                        // let borderColor = [
                        //     // generate 6 random color
                        //     "#19743b",
                        //     "#ff0000",
                        //     "#0000ff",
                        //     "#FA8072",
                        //     "#ff00ff",
                        //     "#00ffff",
                        // ];

                        let samplesGroup = [];

                        for (let i = 0; i < Object.keys(result).length; i++) {
                            samplesGroup.push({
                                label: Object.keys(result)[i],
                                data: Object.values(result)[i],
                                // backgroundColor: backgroundColor[i],
                                // borderColor: borderColor[i],
                                borderWidth: 1,
                            });
                        }
                        // when data nol
                        if(result.length == 0 || result == 'undefined'){
                            $('#canvasGroupChartByCity').attr('hidden', true);
                            $('#groupChartByCityNull').attr('hidden', false);
                        // else data not null
                        }else{
                            $('#canvasGroupChartByCity').attr('hidden', false);
                            $('#groupChartByCityNull').attr('hidden', true);
                            GroupChartByCity = new Chart(document.getElementById("canvasGroupChartByCity").getContext('2d'), {
                                type: 'bar',
                                data: {
                                    labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni','Juli','Agustus', 'September', 'Oktober', 'November', 'Desember'], 
                                    datasets: samplesGroup
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
                        }

                        

                    
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(thrownError);
                    }
            });
        }
       
        
    </script>
@endpush