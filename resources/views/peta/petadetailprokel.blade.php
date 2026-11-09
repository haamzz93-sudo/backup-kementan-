<style>
  #map {
    height: 500px;
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
    'center': [{{$provinsis->latitude}}, {{$provinsis->longitude}}],
    'zoom': 8,
    'zoomControl': true,
    'gestureHandling': true,
    'zoomControl': false,
  });
  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map);
  var customIcon = L.divIcon({
    className: 'custom-icon',
    html: `<svg xmlns="http://www.w3.org/2000/svg" width="30" height="40" viewBox="0 0 30 40">
            <path d="M15 0C6.716 0 0 6.716 0 15c0 11.2 15 25 15 25s15-13.8 15-25c0-8.284-6.716-15-15-15zm0 21c-3.866 0-7-3.134-7-7s3.134-7 7-7 7 3.134 7 7-3.134 7-7 7z" fill="green" />
        </svg>`
});
@foreach($lembaga as $lem)
@if($lem->latitude && $lem->longitude)
  marker = new L.marker([{{$lem->latitude}}, {{$lem->longitude}}],{icon: customIcon})
    .bindPopup('\
    <table>\
    <tr>\
      <th>Kode Produsen</th>\
      <th>:</th>\
      <th>{{$lem->kode}}</th>\
    </tr>\
    <tr>\
      <th>Nama Produsen</th>\
      <th>:</th>\
      <th>{{$lem->nama_lembaga}}</th>\
    </tr>\
    <tr>\
      <th>Alamat Produsen</th>\
      <th>:</th>\
      <th>{{$lem->alamat}}</th>\
    </tr>\
    <tr>\
      <th>Detail/th>\
      <th>:</th>\
      <th><a href="{{url("/")}}/detail-produsen/{{$lem->id}}">Lihat Detail</a></th>\
    </tr>\
    ', {
    maxWidth : 600
})
    .addTo(map);
    @endif
  @endforeach
</script>