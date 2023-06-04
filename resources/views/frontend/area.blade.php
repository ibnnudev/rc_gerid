@extends('frontend.layout')
@include('frontend.component-map.mapArea')
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
.information{
    position: absolute;
    bottom: 50%;
    align-items: center;
    margin-right: auto;
    margin-left: auto;
    left: 0;
    right: 0;
    z-index: 10000000;
    background-color: #ededed
}
.loader {
    position: absolute;
    bottom: 50%;
    align-items: center;
    margin-right: auto;
    margin-left: auto;
    left: 0;
    right: 0;
    z-index: 10000000;
    opacity: 1;
    border: 12px solid #f3f3f3; /* Light grey */
    border-top: 12px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

@media  (max-width: 767px) {
    #virus-img{
        width: 40px;
        height: 80px;
    }

    #slider{
        margin-top: 6%;
    }
}


/* Medium devices (landscape tablets, 768px and up) */
@media  (min-width: 768px) {
    #virus-img{
        width: 50px;
        height: 80px;
    }
    #slider{
        margin-top: 22%;
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
            <h3 class="text-lg font-semibold">Filter</h3>
            {{-- Slider --}}
            <div id="slider" class="mt-20 mb-4 mx-2" style="z-index: 1;"></div>
            <div class="grid-cols- justify-items-center">
                <button type="button" id="btnFilter" class="btn btn-primary w-full mb-2">
                    Jalankan Filter
                </button>
            </div>
        </div>
        <div class="p-6 lg:flex-1 lg:w-60" id="map">
                <div class="loader" id="spinner"></div>
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
                            <option value="{{ $year}}" {{ $year == $lastYearSample ? 'selected' : '' }}>
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
                        <option value="{{ $year }}"  >
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
<!-- nouis slide -->
<script>
    let slStartYear, slEndYear, years;

    years = @json($years);
    let virus = @json($virus);


    slStartYear = parseInt(years[years.length - 1]);
    slEndYear = parseInt(years[0]);
    var slider = document.getElementById('slider');

    noUiSlider.create(slider, {
        start: [slStartYear, slEndYear],
        connect: true,
        range: {
            'min': slStartYear,
            'max': slEndYear
        },
        step: 1,
        tooltips: [true, true],
        format: {
            to: function(value) {
                return parseInt(value);
            },
            from: function(value) {
                return parseInt(value);
            }
        }
    }).on('slide', function(values, handle) {
        slStartYear = values[0];
        slEndYear = values[1];
    });

    // leaflet Map
    
    var map = L.map('map').setView([0.0005512, 123.3319888], 4.5);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    // url geojson Provinsi
    var geoJsonUrl = "https://raw.githubusercontent.com/superpikar/indonesia-geojson/master/indonesia-province.json";
    // kabupaten wdmkk
    // var geoJsonUrl =
    //     "https://gist.githubusercontent.com/Sealorent/f9997b35f155423c15707844b6575031/raw/e10e3996b1599c3dc9b3adfbd2640b21df7b211b/boundary_kabupaten_indonesia.geojson";

    // control layer
    let controlLayers = L.control.layers('', null, {
        collapsed: false
    }).addTo(map);


    function getColourPotensi(d) {
        if (d === 'Tinggi')
            return '#a40404';
        else if (d === 'Rendah')
            return '#80b918';
        else
            return 'white';
    }

    function getColorPotensi(param) {
        return {
            weight: 1,
            opacity: 1,
            color: 'white',
            dashArray: '3',
            fillOpacity: 0.7,
            fillColor: param == 'tinggi' ? '#a40404' : '#80b918',
        };
    }

        
        //legend
        var potensi = null;

        function getPotensi(result) {
            console.log(result);
            if (potensi != null) {
                reset();
            }
            legend = L.control({
                position: 'bottomright'
            });
            legend.onAdd = function(map) {
                var div = L.DomUtil.create('div', 'info legend bg-white mr-10'),
                    grades = ['Tinggi', 'Rendah'],
                    labels = [];
                // loop through our density intervals and generate a label with a colored square for each interval
                for (var i = 0; i < grades.length; i++) {
                    div.innerHTML +=
                        '<i class="fa-solid fa-square" style="color:' + getColourPotensi(grades[i]) + '"></i> ' +
                        grades[i] + '<br>';
                }
                return div;
            };
            legend.addTo(map);

            $.ajax({
                dataType: "json",
                url: geoJsonUrl,
            }).done(function(data) {
                // console.log(data);
                potensi = L.geoJson(data).addTo(map);
                controlLayers.addOverlay(potensi, 'Potensi');

                var layerGrou = L.geoJSON(data, {
                    onEachFeature: function(feature, layer,i) {
                        result.forEach(res => {
                            if (res.province_name == feature.properties.Propinsi) {
                                // console.log('b');
                                var html = "";
                                layer.bindPopup(display(res)).addTo(potensi);
                                layer.setStyle(getColorPotensi(res.potensi));
                            }else{
                                layer.bindPopup(`<p style=font-weight:bold;> ` + feature.properties.Propinsi + `</p><small class="text-red-400">Data Masih Belum Tersedia</small>`).addTo(potensi);
                            }
                        });
                    },
                    weight: 1,
                });
                if (layerGrou != null) {
                    $("#spinner").attr("hidden", true);
                }
            });

        }

        function display(param) {
            var genotipe = "";
            param.genotipes.forEach(e => {
                genotipe += `<tr  class="bg-gray-100 border">
                                <td>${e.genotipe}</td>
                                <td>:</td>
                                <td class="text-center"><b>${e.jumlah}</b></td>
                            </tr>`;
            });
            html = `<h4 class="font-semibold text-md mb-2">Detail Informasi</h4>
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 p-2">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="text-center">Properti</th>
                                <th></th>
                                <th class="text-center">Data</th>
                            </tr>
                        </thead>
                        <tbody class="my-2">
                            <tr class="bg-gray-100 border ">
                                <td>Provinsi</td>
                                <td>:</td>
                                <td class="text-center"><b>${param.province_name}</b></td>
                            </tr>`
                            + genotipe +
                        `</body>
                    <table>`;
            return html;
        }


        
    function setHidden(){
        $("#spinner").attr("hidden", true);
    }

    $(document).ready(function() {
        $.ajax({
            type: "get",
            url: "{{ route('getGrouping') }}",
            data: {
                id : 2,
                startYear:slStartYear,
                endYear:slEndYear,
            }
        }).done(function(result) {
            if(result.length < 1){
                
                $("#spinner").attr("hidden", true);
            }else{
                getPotensi(result);
            }
        });
    });

    function reset(){
        map.removeLayer(potensi);
        legend.remove(potensi);
        controlLayers.removeLayer(potensi);
    }

     $('#btnFilter').on('click', function(e) {
        $("#spinner").attr("hidden", false);

        $.ajax({
            type: "get",
            url: "{{ route('getGrouping') }}",
            data: {
                startYear:slStartYear,
                endYear:slEndYear,
                id: virus.id,
            },
        }).done(function(result) {
            if(result.length < 1){

                Swal.fire({
                    icon: 'info',
                    title: 'Mohon Maaf',
                    text: 'Data Yang Dicari Masih Belum tersedia',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#spinner").attr("hidden", true);
                        reset();
                    }
                });;
                
            }else{
                getPotensi(result);
            }

            e.preventDefault();
        });
     });
    
    


</script>
<!-- chart -->
<script>
    // let virus = @json($virus);
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
                                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'September', 'Oktober', 'November', 'Desember'], 
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
                    // console.log(result);
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
                                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'September', 'Oktober', 'November', 'Desember'], 
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