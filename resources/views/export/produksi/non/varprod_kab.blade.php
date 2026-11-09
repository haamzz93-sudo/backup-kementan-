<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<link rel="stylesheet" href="{{ asset('frontend/css/style.css')}}">
<div class="preloader">
        <div class="loader rubix-cube">
            <div class="layer layer-1"></div>
            <div class="layer layer-2"></div>
            <div class="layer layer-3 color-1"></div>
            <div class="layer layer-4"></div>
            <div class="layer layer-5"></div>
            <div class="layer layer-6"></div>
            <div class="layer layer-7"></div>
            <div class="layer layer-8"></div>
        </div>
    </div>
<table id="theTable" class="table table-striped table-dark my-3" style="display:none">
             <thead>
                 <tr>
                     <th>Nama Komoditas</th>
                     <th>Nama Varietas</th>
                     <th>Tanggal Lapor Terakhir</th>
                     <th>Luasan (Hektar)</th>
                     <th>Satuan</th>
                 </tr>
                 @foreach($regencies as $reg)
    @foreach($lapsebaran
    ->where('regencies_id',$reg->id)
    ->groupBy('varietas_id')
    ->map(function ($groupedItems) {
    $maxTanggalLapor = $groupedItems->max('tanggal_lapor_sebar');
    $sumLuasSebar = $groupedItems->where('tanggal_lapor_sebar', $maxTanggalLapor)->sum('luas_sebar');
    return [
    'maxTanggalLapor' => $maxTanggalLapor,
    'sumLuasSebar' => $sumLuasSebar,
    ];
    })
    ->sortByDesc('sumLuasSebar') as $varietasId => $data)
    @php
    $var = $varietas->where('id',$varietasId)->first();
    $kom = $komoditas->where('id',$var->komoditas_id)->first();
    @endphp
    <tr>
        <td>{{$prov->name}}</td>
        <td>{{$kom->nama}}</td>
        <td>{{$var->nama_varietas}}</td>
        <td>{{ $data["maxTanggalLapor"] }}</td>
        <td>{{ $data["sumLuasSebar"] }}</td>
        <td>Hektar</td>
    </tr>
    @endforeach
    @endforeach
         </table>


     <script>
         function fnExcelReport() {
             var table = document.getElementById('theTable'); // id of table
             var tableHTML = table.outerHTML;
             var fileName = 'varsebar_kab.xls';

             var msie = window.navigator.userAgent.indexOf("MSIE ");

             // If Internet Explorer
             if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
                 dummyFrame.document.open('txt/html', 'replace');
                 dummyFrame.document.write(tableHTML);
                 dummyFrame.document.close();
                 dummyFrame.focus();
                 return dummyFrame.document.execCommand('SaveAs', true, fileName);
             }
             //other browsers
             else {
                 var a = document.createElement('a');
                 tableHTML = tableHTML.replace(/  /g, '').replace(/ /g, '%20'); // replaces spaces
                 a.href = 'data:application/vnd.ms-excel,' + tableHTML;
                 a.setAttribute('download', fileName);
                 document.body.appendChild(a);
                 a.click();
                 document.body.removeChild(a);
             }
         }
         window.onload = function () {
        fnExcelReport();

        // Set a timeout to redirect back after the download process is completed
        setTimeout(function () {
            window.location.href = "{{url('/')}}/pv"; // Replace with your desired URL
        }, 1000); // Delay in milliseconds
    };
     </script>
     <script src="{{ asset('frontend/js/main.js')}}"></script>