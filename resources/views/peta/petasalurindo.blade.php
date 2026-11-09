<style>
    body {
  margin: 0;
}
html, body, #leaflet {
  height: 100%;
}
 .arrow-icon {
        width: 14px;
        height: 14px;
    }
    .arrow-icon > div {
        margin-left: -1px;
        margin-top: -3px;
        transform-origin: center center;
        font: 12px/1.5 "Helvetica Neue", Arial, Helvetica, sans-serif;
    }
   
 table {
  width: 100%;
}

 .garis{
  border: 1px solid black;
  background-color:#FFF;
  
 }
 .pdl{
  padding-left: 50px;
 }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />

<div id="leaflet"></div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<link rel="stylesheet" href="//unpkg.com/leaflet-gesture-handling/dist/leaflet-gesture-handling.min.css" type="text/css">
<script src="//unpkg.com/leaflet-gesture-handling"></script>
<script>
 var map = L.map('leaflet', {
  'center': [{{$lembaga->latitude}}, {{$lembaga->longitude}}],
  'zoom': 6,
        'zoomControl': true,
        'gestureHandling': true,
        'zoomControl': false,
  'layers': [
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      'attribution': 'Map data &copy; OpenStreetMap contributors'
    })
  ]
});

@foreach ($regencies as $regency)
    @php
        $salur = DB::table('lap_penyaluran_stok')
            ->where('regencies_id',$regency->id)
            ->whereIn('target_benih_id', $targetIds)
            ->get();
    @endphp

    var mylatlngs{{$regency->id}} = [
        [{{$lembaga->latitude}}, {{$lembaga->longitude}}],
        [{{$regency->latitude}}, {{$regency->longitude}}]
    ];

    var polyline{{$regency->id}} = L.polyline(mylatlngs{{$regency->id}}, { color: 'red' }).addTo(map);

    var marker{{$regency->id}} = L.marker([{{$regency->latitude}}, {{$regency->longitude}}]).addTo(map);

    marker{{$regency->id}}.bindPopup(`TUJUAN PENYALURAN : {{$regency->name}}<br>
    <table>
        <thead>
        <tr>
            <th class="garis text-center">Tanggal Lapor</th>
            <th class="garis text-center">Penerima</th>
            <th class="garis text-center">Alamat</th>
            <th class="garis text-center">Keperluan</th>
            <th class="garis text-center">Komoditas</th>
            <th class="garis text-center">Jumlah</th>
        </tr>
        </thead>
        @foreach($salur as $ass)
        @php
        $target = DB::table('target_benih')
            ->where('id',$ass->target_benih_id)
            ->first();
            $komoditas = DB::table('komoditas')->select('nama')->find($target->komoditas_id);
            $varietas = DB::table('varietas')->select('nama_varietas')->find($target->varietas_id);
            $satuan = DB::table('satuan')->select('nama_satuan')->find($target->satuan_id);
        @endphp
      <tbody>
        <tr>
          <td class="garis">{{$ass->tanggal_lapor}}</td>
          <td class="garis">{{$ass->nama_penerima}}</td>
          <td class="garis">{{$ass->alamat}}</td>
          <td class="garis">{{$ass->keperluan}}</td>
          <td class="garis">{{$komoditas->nama}} {{$varietas->nama_varietas}}</td>
          <td class="garis">{{$ass->jumlah}} {{$satuan->nama_satuan}}</td>
        </tr>
      </tbody>
        @endforeach
        </table>`,
        {
          maxWidth : 560,
          maxHeight: 225
        }
    ).openPopup();
@endforeach

// Add markers with popup text
var redIcon = L.icon({
  iconUrl: '{{ URL::asset("pin/location-pin.png") }}',
  iconSize: [35, 45],
  iconAnchor: [18, 40],
  popupAnchor: [0, -20]
});

var markera1 = L.marker([{{$lembaga->latitude}}, {{$lembaga->longitude}}], {icon: redIcon}).addTo(map);
markera1.bindPopup(`SUMBER PENYALURAN : {{$lembaga->nama_lembaga}}<br>
<b>Penyaluran dalam Lingkup Kab/Kota Produsen</b>
@if($salur->where('regencies_id',$lembaga->regencies_id)->count()>0)
    <table>
        <tr>
        <th>Tanggal Lapor</th>
        <th>Penerima</th>
        <th>Alamat</th>
        <th>Keperluan</th>
        <th>Komoditas</th>
        <th>Jumlah</th>
        </tr>
        @foreach($salur->where('regencies_id',$lembaga->regencies_id) as $ass)
        @php
        $target = DB::table('target_benih')
            ->where('id',$ass->target_benih_id)
            ->first();
            $komoditas = DB::table('komoditas')->select('nama')->find($target->komoditas_id);
            $varietas = DB::table('varietas')->select('nama_varietas')->find($target->varietas_id);
            $satuan = DB::table('satuan')->select('nama_satuan')->find($target->satuan_id);
        @endphp
       <tr>
       <td>{{$ass->tanggal_lapor}}</td>
       <td>{{$ass->nama_penerima}}</td>
       <td>{{$ass->alamat}}</td>
       <td>{{$ass->keperluan}}</td>
       <td>{{$komoditas->nama}} {{$varietas->nama_varietas ?? "Belum Ada Varietas"}}</td>
       <td>{{$ass->jumlah}} {{$satuan->nama_satuan}}</td>
       </tr>
        @endforeach
        
        </table>
        @else
        <p>Tidak ada data</p>
        @endif`,
        {
          maxWidth : 560,
          maxHeight: 225
        }
    ).openPopup();
  
</script>



