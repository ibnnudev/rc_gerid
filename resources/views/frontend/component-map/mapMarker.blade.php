
@push('js-internal')
<style>
    #map {
        height: 80vh;
        width: 100%;
    }
</style>

{{-- Marker cluster --}}
<link rel="stylesheet" href="{{ asset('assets/cluster/MarkerCluster.css') }}">
<link rel="stylesheet" href="{{ asset('assets/cluster/MarkerCluster.Default.css') }}">

{{-- Slider --}}
<link rel="stylesheet" href="{{ asset('assets/slider/nouislider.css') }}">
<!-- Leaflet -->
<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js" integrity="sha512-A7vV8IFfih/D732iSSKi20u/ooOfj/AGehOKq0f4vLT1Zr2Y+RX7C+w8A1gaSasGtRUZpF/NZgzSAu4/Gc41Lg==" crossorigin=""></script>

{{-- Marker cluster --}}
<script src="{{ asset('assets/cluster/leaflet.markercluster.js') }}"></script>

{{-- Slider --}}
<script src="{{ asset('assets/slider/nouislider.js') }}"></script>

<!-- Nouis Slider -->
<script>
    let slStartYear, slEndYear, years;
    years = @json($years);
    // console.log(parseInt(years[0]['year']));
    slStartYear = parseInt(years[0]['year']);
    slEndYear = parseInt(years[years.length - 1]['year']);
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
</script>

<script>
    // handle selectOption
    function handleSelect(elm){
        window.location = elm.value;
    }
    $(function() {
        // MARKER INITIALIZATION
        let circleMarkerMale = {
            radius: 8,
            fillColor: "#00bfff",
            color: "#000",
            weight: 1,
            opacity: 1,
            fillOpacity: 0.8
        }

        let circleMarkerFemale = {
            radius: 8,
            fillColor: "#ff8c69",
            color: "#000",
            weight: 1,
            opacity: 1,
            fillOpacity: 0.8
        };

        let individualCases = @json($individualCases);
        // console.log(individualCases[0]);

        // get current location
        let map = L.map('map').setView([individualCases[0]['latitude'], individualCases[0]['longitude']], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        }).addTo(map);

        // marker cluster
        let markers = L.markerClusterGroup();

        // add marker
        individualCases.forEach(location => {
            const popUpContent = `
                    <h4 class="font-semibold text-md mb-2">Detail Informasi</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Properti</th>
                                <th></th>
                                <th>Data</th>
                            </tr>
                            <tr>
                                <td>No</td>
                                <td>:</td>
                                <td><b>${location.no}</b></td>
                            </tr>
                            <tr>
                                <td>IDKD</td>
                                <td>:</td>
                                <td><b>${location.idkd}</b></td>
                            </tr>
                            <tr>
                                <td>Alamat IDKD</td>
                                <td>:</td>
                                <td><b>${location.idkd_address}</b></td>
                            </tr>
                            <tr>
                                <td>Kota</td>
                                <td>:</td>
                                <td><b>${location.regency.name}</b></td>
                            </tr>
                            
                            <tr>
                                <td>Daerah</td>
                                <td>:</td>
                                <td><b>${location.region}</b></td>
                            </tr>
                            <tr>
                                <td>Jumlah Kasus</td>
                                <td>:</td>
                                <td><b>${location.count_of_cases}</b></td>
                            </tr>
                            <tr>
                                <td>Umur</td>
                                <td>:</td>
                                <td><b>${location.age}</b></td>
                            </tr>
                            <tr>
                                <td>Rentang Umur</td>
                                <td>:</td>
                                <td><b>${location.age_group}</b></td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td><b>${location.sex == 1 ? "Pria": "wanita"}</b></td>
                            </tr>
                            <tr>
                                <td>Penyebaran</td>
                                <td>:</td>
                                <td><b>${location.transmission.name}</b></td>
                            </tr>
                            <tr>
                                <td>Tahun</td>
                                <td>:</td>
                                <td><b>${location.year}</b></td>
                            </tr>
                        </thead>
                    </table>
                `;
            let marker = L.circleMarker([location['latitude'], location['longitude']], location.sex == 1 ? circleMarkerMale : circleMarkerFemale)
                .bindPopup(popUpContent);
            markers.addLayer(marker);
        });

        map.addLayer(markers);

        // reset all filter
        function resetFilter() {
            $('.path.leaflet-interactive').remove();
            $('g').empty();
            $('.leaflet-pane.leaflet-marker-pane').empty();
            $('.leaflet-marker-icon').remove();

            individualCases = @json($individualCases);

            // remove all marker
            map.removeLayer(markers);
        }

        // filter data from gender select box
        $('#gender').on('change', function() {
            // remove all marker
            resetFilter();
            // reset year select box
            $('#startYear').val('{{ $years->first()->year }}').trigger('change');
            $('#endYear').val('{{ $years->last()->year }}').trigger('change');

            let value = $(this).val();
            // console.log(value);
            individualCases = individualCases.filter(function(item) {
                return item.sex == value;
            });

            // console.log(individualCases);

            // remove all marker
            map.removeLayer(markers);

            // add transition animation
            map.flyTo([individualCases[0]['latitude'], individualCases[0]['longitude']], 12);

            // add new marker
            markers = L.markerClusterGroup();
            individualCases.forEach(location => {
                const popUpContent = `
                    <h4 class="font-semibold text-md mb-2">Detail Informasi</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Properti</th>
                                <th></th>
                                <th>Data</th>
                            </tr>
                            <tr>
                                <td>No</td>
                                <td>:</td>
                                <td><b>${location.no}</b></td>
                            </tr>
                            <tr>
                                <td>IDKD</td>
                                <td>:</td>
                                <td><b>${location.idkd}</b></td>
                            </tr>
                            <tr>
                                <td>Alamat IDKD</td>
                                <td>:</td>
                                <td><b>${location.idkd_address}</b></td>
                            </tr>
                            <tr>
                                <td>Kota</td>
                                <td>:</td>
                                <td><b>${location.city}</b></td>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <td>:</td>
                                <td><b>${location.subdistrict}</b></td>
                            </tr>
                            <tr>
                                <td>Daerah</td>
                                <td>:</td>
                                <td><b>${location.region}</b></td>
                            </tr>
                            <tr>
                                <td>Jumlah Kasus</td>
                                <td>:</td>
                                <td><b>${location.count_of_cases}</b></td>
                            </tr>
                            <tr>
                                <td>Umur</td>
                                <td>:</td>
                                <td><b>${location.age}</b></td>
                            </tr>
                            <tr>
                                <td>Rentang Umur</td>
                                <td>:</td>
                                <td><b>${location.age_group}</b></td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td><b>${location.sex}</b></td>
                            </tr>
                            <tr>
                                <td>Penyebaran</td>
                                <td>:</td>
                                <td><b>${location.transmission.name}</b></td>
                            </tr>
                            <tr>
                                <td>Tahun</td>
                                <td>:</td>
                                <td><b>${location.year}</b></td>
                            </tr>
                        </thead>
                    </table>
                `;
                let marker = L.circleMarker([location['latitude'], location['longitude']], location.sex == 1 ? circleMarkerMale : circleMarkerFemale)
                    .bindPopup(popUpContent);
                markers.addLayer(marker);
            });

            map.addLayer(markers);

            individualCases = @json($individualCases);
        });

        // filter data from start date and end date
        let startYear, endYear;

        startYear = $('#startYear').val();
        endYear = $('#endYear').val();

        $('#startYear').on('change', function() {
            startYear = $(this).val();
        });

        $('#endYear').on('change', function() {
            endYear = $(this).val();
        });
        $('#btnFilter').on('click', function(e) {
            e.preventDefault();
            if (startYear == undefined || endYear == undefined) {
                alert('Silahkan pilih tanggal terlebih dahulu');
                return;
            }

            if (startYear > endYear) {
                alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir');
                return;
            }

            individualCases = individualCases.filter(function(item) {
                return parseInt(item.year) >= parseInt(startYear) && parseInt(item.year) <=
                    parseInt(endYear);
            });
            // console.log(individualCases);

            // remove all marker
            map.removeLayer(markers);

            // add transition animation
            map.flyTo([individualCases[0]['latitude'], individualCases[0]['longitude']], 12);

            // add new marker
            markers = L.markerClusterGroup();
            individualCases.forEach(location => {
                const popUpContent = `
                    <h4 class="font-semibold text-md mb-2">Detail Informasi</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Properti</th>
                                <th></th>
                                <th>Data</th>
                            </tr>
                            <tr>
                                <td>No</td>
                                <td>:</td>
                                <td><b>${location.no}</b></td>
                            </tr>
                            <tr>
                                <td>IDKD</td>
                                <td>:</td>
                                <td><b>${location.idkd}</b></td>
                            </tr>
                            <tr>
                                <td>Alamat IDKD</td>
                                <td>:</td>
                                <td><b>${location.idkd_address}</b></td>
                            </tr>
                            <tr>
                                <td>Kota</td>
                                <td>:</td>
                                <td><b>${location.city}</b></td>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <td>:</td>
                                <td><b>${location.subdistrict}</b></td>
                            </tr>
                            <tr>
                                <td>Daerah</td>
                                <td>:</td>
                                <td><b>${location.region}</b></td>
                            </tr>
                            <tr>
                                <td>Jumlah Kasus</td>
                                <td>:</td>
                                <td><b>${location.count_of_cases}</b></td>
                            </tr>
                            <tr>
                                <td>Umur</td>
                                <td>:</td>
                                <td><b>${location.age}</b></td>
                            </tr>
                            <tr>
                                <td>Rentang Umur</td>
                                <td>:</td>
                                <td><b>${location.age_group}</b></td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td><b>${location.sex}</b></td>
                            </tr>
                            <tr>
                                <td>Penyebaran</td>
                                <td>:</td>
                                <td><b>${location.transmission.name}</b></td>
                            </tr>
                            <tr>
                                <td>Tahun</td>
                                <td>:</td>
                                <td><b>${location.year}</b></td>
                            </tr>
                        </thead>
                    </table>
                `;
                let marker = L.circleMarker([location['latitude'], location['longitude']], location.sex == 1 ? circleMarkerMale : circleMarkerFemale)
                    .bindPopup(popUpContent);
                markers.addLayer(marker);
            });

            map.addLayer(markers);

            individualCases = @json($individualCases);
        })

    

        $('#btnTimelapse').on('click', function(e) {
            resetFilter();
            $('#startYear').val(slStartYear);
            $('#endYear').val(slEndYear);

            e.preventDefault();

            let gap = slEndYear - slStartYear;
            // loop through all year every 1 second
            let i = 0;
            let interval = setInterval(function() {
                // console.log(i);
                if (i > gap) {
                    clearInterval(interval);
                    return;
                }

                individualCases = individualCases.filter(function(item) {
                    return parseInt(item.year) == parseInt(slStartYear + i);
                });

                // add new marker
                markers = L.markerClusterGroup();

                individualCases.forEach((location) => {
                    // fly to each location
                    map.flyTo([location['latitude'], location['longitude']], 12);
                    const popUpContent = `
                            <h4 class="font-semibold text-md mb-2">Detail Informasi</h4>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Properti</th>
                                        <th></th>
                                        <th>Data</th>
                                    </tr>
                                    <tr>
                                        <td>No</td>
                                        <td>:</td>
                                        <td><b>${location.no}</b></td>
                                    </tr>
                                    <tr>
                                        <td>IDKD</td>
                                        <td>:</td>
                                        <td><b>${location.idkd}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat IDKD</td>
                                        <td>:</td>
                                        <td><b>${location.idkd_address}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Kota</td>
                                        <td>:</td>
                                        <td><b>${location.city}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Kecamatan</td>
                                        <td>:</td>
                                        <td><b>${location.subdistrict}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Daerah</td>
                                        <td>:</td>
                                        <td><b>${location.region}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Kasus</td>
                                        <td>:</td>
                                        <td><b>${location.count_of_cases}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Umur</td>
                                        <td>:</td>
                                        <td><b>${location.age}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Rentang Umur</td>
                                        <td>:</td>
                                        <td><b>${location.age_group}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kelamin</td>
                                        <td>:</td>
                                        <td><b>${location.sex}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Penyebaran</td>
                                        <td>:</td>
                                        <td><b>${location.transmission.name}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Tahun</td>
                                        <td>:</td>
                                        <td><b>${location.year}</b></td>
                                    </tr>
                                </thead>
                            </table>
                        `;
                    marker = L.circleMarker(
                        [location["latitude"], location["longitude"]],
                        location.sex == 1 ?
                        circleMarkerMale :
                        circleMarkerFemale
                    ).bindPopup(popUpContent);

                    map.addLayer(marker);
                    marker.on("click", function(e) {
                        map.flyTo([location["latitude"], location["longitude"]], 17);
                    });

                    // if last location, zoom out
                    if (i == gap) {
                        map.flyTo([location['latitude'], location['longitude']], 11);
                    }
                });

                individualCases = @json($individualCases);

                i++;
            }, 1000);
        });

        // Button Reset
        $('#btnReset').on('click', function(e) {
            e.preventDefault();
            location.reload();
        });
    });
</script>
@endpush