<x-guest-layout>
    <div class="bg-white border border-gray-200 rounded-xl shadow h-full">
        <div href="#" class="rounded-t-xl bg-blue-700 text-white py-3 px-6 font-semibold">
            Detail Informasi ({{ $virus->name }})
        </div>
        <div class="px-6 py-8">
            <form action="{{ route('listCitation') }}" method="POST" class="py-8">
                @csrf
                <input type="hidden" name="virus_id" value="{{ $virus->id }}" />
                <div class="grid lg:grid-cols-5 gap-4 items-center">
                    <div>
                        <label for="year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Tahun
                        </label>
                        <select id="year" name="year"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.50">
                            <option selected value="">Pilih tahun</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="province" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Provinsi
                        </label>
                        <select id="province" name="province"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.50">
                            <option selected value="">Pilih provinsi</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="author" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Penulis
                        </label>
                        <select id="author" name="author"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.50">
                            <option selected value="">Pilih penulis</option>
                            @foreach ($authors as $key => $val)
                                <option value="{{ $val['author']['id'] }}">{{ $val['author']['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="genotipe" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Genotipe
                        </label>
                        <select id="genotipe" name="genotipe"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.50">
                            <option selected value="">Pilih genotipe</option>
                            @foreach ($virus->genotipes as $genotipe)
                                <option value="{{ $genotipe->id }}">{{ $genotipe->genotipe_code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit"
                            class="text-white mt-7 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-normal rounded-lg text-sm px-9 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">Cari
                            Sitasi</button>
                    </div>
                </div>
            </form>
            <!-- Konten -->
            <div class="flex flex-wrap lg:grid grid-cols-1 lg:grid-cols-12 gap-6 mt-8">
                <div class="lg:col-span-8 w-fit">
                    <h1 class="font-semibold">{{ $virus->name }}</h1>
                    <div class="mt-5 overflow-y-auto max-h-80 text-sm leading-6 w-full sm:w-fit"
                        style="scrollbar-width: thin;">
                        <div class="hidden md:block">
                            {!! html_entity_decode($virus->description) !!}
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-4 justify-center lg:justify-start">
                    <img src="{{ asset('storage/virus/' . $virus->image) }}" alt="{{ $virus->name }}"
                        class="w-full h-40 lg:h-64 object-contain rounded-lg">
                </div>
            </div>
            <!-- Map & Chart -->
            <div class="mt-8">
                <h1 class="font-semibold">Visualisasi</h1>
                <div class="grid lg:grid-cols-2 gap-6 mt-8">
                    <div class="map-form h-80">
                        <div class="flex items-center gap-4 mb-4 hidden">
                            <select id="map-province" name="map-province"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.50">
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}"
                                        {{ $province->id == $lastCitySampleId ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                            <select id="map-year" name="map-year"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.50">
                                @foreach ($years as $year)
                                    <option value="{{ $year }}"
                                        {{ $year == $lastYearSample ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            <div>
                                <button type="button" id="map-filter-button"
                                    class="inline-flex items-center ml-2 px-4 py-2 text-white bg-blue-700  hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Filter
                                </button>
                            </div>
                        </div>
                        <div id="map"></div>
                    </div>
                    <div>
                        <div class="space-y-4 flex flex-col md:flex-row md:justify-between items-center">
                            <h3 class="font-semibold text-sm">Persebaran Virus {{ $virus->name }}
                                berdasarkan Gen</h3>
                            <div class="w-full md:w-fit">
                                <select id="groupChartYear" name="groupChartYear"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.50">
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}"
                                            {{ $year == $lastYearSample ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div style="height: 300px" class="relative flex items-center justify-center h-full"
                            id="groupChartContainer">
                            <p class="text-center text-sm" id="groupChartByYearNull" hidden>Data Masih Belum Tersedia
                            </p>
                            <canvas id="canvasGenChartByYear" class="absolute z-10" visi></canvas>
                        </div>
                    </div>
                </div>
                <div class="mt-24">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <h3 class="font-semibold">Persebaran Virus {{ $virus->name }} berdasarkan Gen</h3>
                        <div class="space-y-4 md:flex items-end gap-4 w-full">
                            <select id="provincy" name="provincy"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.50">
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}"
                                        {{ $province->id == $lastCitySampleId ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                            <select id="year-for-city" name="year-for-city"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.50">
                                @foreach ($years as $year)
                                    <option value="{{ $year }}"
                                        {{ $year == $lastYearSample ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            <div>
                                <button type="button" id="renderGroupChart"
                                    class="inline-flex items-center md:ml-2 px-4 py-2 text-white bg-blue-700  hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full justify-center md:w-fit dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Filter
                                </button>
                            </div>
                        </div>
                    </div>
                    <div style="height: 300px" class="relative flex items-center justify-center"
                        id="groupChartByCityContainer">
                        <p class="text-center text-sm" id="groupChartByCityNull" hidden>Data Masih Belum Tersedia</p>
                        <canvas id="canvasGroupChartByCity" class="absolute z-10"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @push('css-internal')
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
            <!-- Make sure you put this AFTER Leaflet's CSS -->
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
            <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
            <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css'
                rel='stylesheet' />
            <style>
                #map {
                    height: 100%;
                }
            </style>
        @endpush
        @push('js-internal')
            <script>
                let virus = @json($virus);
            </script>
            <!-- chart -->
            <script>
                $(document).ready(function() {
                    ajaxGetGroupChart($("#groupChartYear").val());
                    ajaxGetGroupChartByCity($("#year-for-city").val(), $("#provincy").val());
                });

                // on change group chart by year
                $('#groupChartYear').on('change', function() {
                    yearGroupChart = $(this).val();
                    ajaxGetGroupChart(yearGroupChart);
                })
                // reload change group chart by year
                var GroupChartByYear = null;

                function ajaxGetGroupChart(params) {
                    $.ajaxSetup({
                        cache: false
                    });
                    $.ajax({
                        method: 'GET',
                        url: '/chartGroupYear',
                        data: {
                            year: params,
                            id: virus.id
                        },
                        async: true,
                        success: function(result) {
                            if (GroupChartByYear !== null) {
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
                            if (result.length == 0 || result == 'undefined') {
                                $('#canvasGenChartByYear').attr('hidden', true);
                                $('#groupChartByYearNull').attr('hidden', false);
                                // else data not null
                            } else {
                                $('#canvasGenChartByYear').attr('hidden', false);
                                $('#groupChartByYearNull').attr('hidden', true);
                                GroupChartByYear = new Chart(document.getElementById("canvasGenChartByYear").getContext(
                                    '2d'), {
                                    type: 'bar',
                                    data: {
                                        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                            'September', 'Oktober', 'November', 'Desember'
                                        ],
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
                                                // stacked: true,
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
                                                // stacked: true,
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
                    ajaxGetGroupChartByCity($("#year-for-city").val(), $("#provincy").val());
                })
                // reload the group chart by city
                var GroupChartByCity = null;

                function ajaxGetGroupChartByCity(years, provincies) {
                    $.ajaxSetup({
                        cache: false
                    });
                    $.ajax({
                        method: 'GET',
                        url: '/chartGroupCity',
                        data: {
                            provincy: provincies,
                            year: years,
                            id: virus.id
                        },
                        async: true,
                        success: function(result) {
                            // console.log(result);
                            if (GroupChartByCity !== null) {
                                GroupChartByCity.destroy();
                            }
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
                            if (result.length == 0 || result == 'undefined') {
                                $('#canvasGroupChartByCity').attr('hidden', true);
                                $('#groupChartByCityNull').attr('hidden', false);
                                // else data not null
                            } else {
                                $('#canvasGroupChartByCity').attr('hidden', false);
                                $('#groupChartByCityNull').attr('hidden', true);
                                GroupChartByCity = new Chart(document.getElementById("canvasGroupChartByCity")
                                    .getContext('2d'), {
                                        type: 'bar',
                                        data: {
                                            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                                'September', 'Oktober', 'November', 'Desember'
                                            ],
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
                                                    // stacked: true,
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
                                                    // stacked: true,
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

            <!-- map -->
            <script>
                var map = L.map('map').setView([0.0005512, 123.3319888], 4.5);
                // fullscreen
                map.addControl(new L.Control.Fullscreen());
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
                var geoJsonUrl = "https://raw.githubusercontent.com/superpikar/indonesia-geojson/master/indonesia-province.json";
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
                var html;

                function getPotensi(result) {
                    if (potensi != null) {
                        reset();
                    }

                    $.ajax({
                        dataType: "json",
                        url: geoJsonUrl,
                    }).done(function(data) {
                        potensi = L.geoJson(data).addTo(map);
                        var layerGrou = L.geoJSON(data, {
                            onEachFeature: function(feature, layer, i) {
                                result.forEach(res => {
                                    if (res.province_name === feature.properties.Propinsi) {
                                        html = "";
                                        layer.bindPopup(display(res)).addTo(potensi);
                                        layer.setStyle(getColorPotensi(res.potensi));
                                    }
                                });
                            },
                            weight: 1,
                        });
                    });
                }

                var genotipe;

                function display(param) {
                    genotipe = "";
                    totalGenotipe = param.genotipes.reduce((acc, curr) => acc + curr.jumlah, 0);
                    param.genotipes.forEach(e => {
                        if (e.jumlah !== 0) {
                            genotipe += `<tr  class="bg-gray-100 border">
                                                <td>${e.genotipe}</td>
                                                <td>:</td>
                                                <td class="text-center"><b>${e.jumlah}</b></td>
                                            </tr>`;
                        }
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
                                        </tr>
                                        <tr class="bg-gray-100 border">
                                            <td>Total</td>
                                            <td>:</td>
                                            <td class="text-center"><b>${totalGenotipe}</b></td>
                                        </tr>
                                        ` +
                        genotipe +
                        `</body>
                                <table>`;
                    return html;
                }

                $(document).ready(function() {
                    $.ajax({
                        type: "get",
                        url: "{{ route('getGrouping') }}",
                        data: {
                            id: virus.id,
                        }
                    }).done(function(result) {
                        getPotensi(result);
                    });
                });

                function reset() {
                    map.removeLayer(potensi);
                    $(".leaflet-control-layers-overlays label").remove();
                    $(".info svg").remove();
                    controlLayers.removeLayer(potensi);
                }
            </script>
        @endpush
</x-guest-layout>
