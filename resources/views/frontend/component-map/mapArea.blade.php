
@push('js-internal')
<style>
    #map {
        height: 80vh;
        width: 100%;
        /* z-index: 999; */
    }
    .leaflet-popup-content{
        width: max-content;
    }
     tr td{
        padding: 5px;
    }
    .info{
        padding: 10px;
        box-shadow: 2px;
    }
    /* td{
        font-size: 12px;
    } */
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

{{--  --}}

{{-- <script>
    $(function() {
        var map = L.map('map').setView([0.0005512, 123.3319888], 4.5);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        // url geojson
        var geoJsonUrl =
            "https://gist.githubusercontent.com/Sealorent/f9997b35f155423c15707844b6575031/raw/e10e3996b1599c3dc9b3adfbd2640b21df7b211b/boundary_kabupaten_indonesia.geojson";

        // control layer
        let controlLayers = L.control.layers('', null, {
            collapsed: false
        }).addTo(map);
    });

</script> --}}
