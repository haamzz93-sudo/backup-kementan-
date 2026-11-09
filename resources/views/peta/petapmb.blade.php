<style>
    #map {
        height: 500px;
        z-index:0;
    }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />

<div id="map"></div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<link rel="stylesheet" href="//unpkg.com/leaflet-gesture-handling/dist/leaflet-gesture-handling.min.css" type="text/css">
<script src="//unpkg.com/leaflet-gesture-handling"></script>
<script>
  var map = L.map('map', {
    'center': [-2.948926, 118.0148634],
    'zoom': 5,
        'zoomControl': true,
        'gestureHandling': true,
        'zoomControl': false,
    });
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    $.getJSON('{{ asset("json/provinsi.json")}} ',
        function(geojson) {
            L.geoJson(geojson, {
                    onEachFeature: function(feature, layer) {
                        @foreach($provinsis as $prov)
                        @php
                            $lol = App\Models\SertifikatKompetensi::whereHas('produsenbenih', function($q) use ($prov){
                                $q->where('provinces_id',$prov->id);
                            })->count()
                            @endphp
                        if (layer.feature.properties.ID == '{{ $prov->id}}') {
                            layer.bindPopup('<b>PROVINSI {{$prov->name}}</b><br>JUMLAH SERTIFIKAT : {{$lol}}');
                            layer.setStyle({
                                 @if($lol)
                                fillColor: '#000080',
                                @else
                                fillColor: '#FFFFFF',
                                @endif
                                weight: 0.5,
                                opacity: 0.5,
                                color: 'grey', //Outline color
                                fillOpacity: 3
                            });
                        }
                        @endforeach
                    }
                })
                .addTo(map);
        });
</script>