<x-guest-layout>
    <div class="bg-white border border-gray-200 rounded-xl shadow h-full">
        <div href="#" class="rounded-t-xl bg-blue-700 text-white py-3 px-6 font-semibold">
            Detail Informasi ({{ $virus->name }})
        </div>
        <div class="px-6 py-8">
            <!-- Cari Sitasi -->
            <div class="grid lg:grid-cols-5 gap-4 items-center">
                <div>
                    <label for="year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Tahun
                    </label>
                    <select id="year"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.50">
                        <option selected disabled>Pilih tahun</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="province" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Provinsi
                    </label>
                    <select id="province"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.50">
                        <option selected disabled>Pilih provinsi</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="author" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Penulis
                    </label>
                    <select id="author"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.50">
                        <option selected disabled>Pilih penulis</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="genotipe" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Genotipe
                    </label>
                    <select id="genotipe"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.50">
                        <option selected disabled>Pilih genotipe</option>
                        @foreach ($genotipes as $genotipe)
                            <option value="{{ $genotipe->id }}">{{ $genotipe->genotipe_code }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="button"
                        class="text-white mt-5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-normal rounded-lg text-xs px-9 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">Cari</button>
                </div>
            </div>
            <!-- Konten -->
            <div class="grid lg:grid-cols-12 gap-6 mt-8">
                <div class="col-span-8">
                    <h1 class="font-semibold">{{ $virus->name }}</h1>
                    <div class="mt-5 overflow-y-auto h-80 text-sm leading-6" style="scrollbar-width: thin;">
                        <p>
                            {!! htmlspecialchars_decode($virus->description) !!}
                        </p>
                    </div>
                </div>
                <div class="col-span-4 justify-center lg:justify-start">
                    <img src="{{ asset('storage/virus/' . $virus->image) }}" alt="{{ $virus->name }}"
                        class="w-full h-64 object-contain rounded-lg">
                </div>
            </div>
            <!-- Chart -->
            <div class="mt-8">
                <h1 class="font-semibold">Visualisasi</h1>
                <div class="grid lg:grid-cols-2 gap-6 mt-8">
                    <div></div>
                    <div>
                        <div class="flex justify-between items-center">
                            <h3 class="font-semibold text-sm">Persebaran Virus {{ $virus->name }} berdasarkan Gen</h3>
                            <div>
                                <div>
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
                        </div>
                        <div style="height: 300px" class="relative flex items-center justify-center"
                            id="groupChartContainer">
                            <p class="text-center text-sm" id="groupChartByYearNull" hidden>Data Masih Belum Tersedia
                            </p>
                            <canvas id="canvasGenChartByYear" class="absolute z-10" visi></canvas>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <h3 class="font-semibold">Persebaran Virus {{ $virus->name }} berdasarkan Gen</h3>
                    <div class="flex items-center gap-4">
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
                                <option value="{{ $year }}" {{ $year == $lastYearSample ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                        <div>
                            <button type="button" id="renderGroupChart"
                                class="inline-flex items-center ml-2 px-4 py-2 text-white bg-blue-700  hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <span class="sr-only">Search</span>
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
    @push('js-internal')
        <!-- chart -->
        <script>
            let virus = @json($virus);
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
    @endpush
</x-guest-layout>
