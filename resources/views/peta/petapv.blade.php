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
            if (layer.feature.properties.ID == '{{ $prov->id}}') {
              @if($prov->varietassebar->count()>0)
              layer.bindPopup(
                '<b>PROVINSI {{$prov->name}}</b><br>10 Varietas Sebaran Terluas:</br><table>'
                +'<tr>\
                <th>Nama Komoditas</th>\
                <th>Nama Varietas</th>\
                <th>Tanggal Lapor Terakhir</th>\
                <th>Luasan (Hektar)</th>\
                </tr>'
                
                @foreach($prov->varietassebar
                  ->groupBy('varietas_id')
                  ->map(function ($groupedItems) {
                      $maxTanggalLapor = $groupedItems->max('tanggal_lapor_sebar');
                      $sumLuasSebar = $groupedItems->where('tanggal_lapor_sebar', $maxTanggalLapor)->sum('luas_sebar');
                      return [
                          'maxTanggalLapor' => $maxTanggalLapor,
                          'sumLuasSebar' => $sumLuasSebar,
                  ];
                })
                ->sortByDesc('sumLuasSebar')
                ->take(10) as $varietasId => $data)
                @php
                $var = $varietas->where('id',$varietasId)->first();
                $kom = $komoditas->where('id',$var->komoditas_id)->first();
                @endphp
                +'<tr>'
                +'<td>{{$kom->nama}}</td>\
                <td>{{$var->nama_varietas}}</td>\
                <td>{{ $data["maxTanggalLapor"] }}</td>\
                <td>{{ $data["sumLuasSebar"] }} ha</td>'
                +'</tr>'
                @endforeach
                
                +'</table>'
                +'<a href="{{url("/")}}/detailpvsebar/{{$prov->id}}" target="_blank"><button>Lihat Data Provinsi</button></a>'
              );
              @endif
              layer.setStyle({
                @if($prov->varietassebar->count()>0)
                fillColor: '#28a745',
                @else
                fillColor: '#ffffff',
                @endif
                weight: 0.5,
                opacity: 0.5,
                color: 'white', //Outline color
                fillOpacity: 3
              });
            }
            @endforeach
          }
        })
        .addTo(map);
    });
</script>