<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
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
<table id="theTable" class="table table-striped table-dark my-3">
    <thead class="garis text-center">
                    <tr>
                      <th>KODE PRODUSEN</th>
                      <th>JENIS PRODUSEN</th>
                      <th>NAMA PRODUSEN</th>
                      <th>NAMA PROVINSI</th>
                      <th>NAMA KABUPATEN</th>
                      <th>NAMA KECAMATAN</th>
                      <th>NAMA DESA</th>
                      <th>ALAMAT</th>
                      <th>KOMODITAS - VARIETAS</th>
                      <th>SATUAN</th>
                      <th>JUMLAH PRODUKSI</th>
                      <th>JUMLAH PENYALURAN</th>
                      <th>STOK SAAT INI</th>
                      <th>DETAIL PRODUSEN</th>
                    </tr>
                  </thead>
				   <tbody>
                    @foreach($nonapbn as $non)
                    <tr>
                    <td>{{$non->produksiumum->kode_produsen ?? 'Belum Ada Kode'}}</td>
                    <td>{{$non->produksiumum->jenis_produsen->nama_jenis ?? 'Belum Ada Jenis'}}</td>
                    <td>{{$non->produksiumum->nama_lembaga ?? 'Belum Ada Data'}}</td>
                    <td>{{$non->produksiumum->provinces->name ?? 'Provinsi Belum Diisi'}}</td>
                    <td>{{$non->produksiumum->regencies->name ?? 'Kabupaten Belum Diisi'}}</td>
                    <td>{{$non->produksiumum->districts->name ?? 'Kecamatan Belum Diisi'}}</td>
                    <td>{{$non->produksiumum->villages->name ?? 'Desa Belum Diisi'}}</td>
                    <td>{{$non->produksiumum->alamat ?? 'Alamat Belum Diisi'}}</td>
                    <td>{{$non->komoditas->nama}} - {{$non->varietas->nama_varietas ?? 'Varietas Tidak Dipilih'}}</td>
                    <td>{{$non->satuan->nama_satuan}}</td>
                    <td>{{number_format(($non->childproduksiswadaya->sum('produksi_benih')),0,",",".")}} {{$non->satuan->nama_satuan}}</td>
                    <td>{{number_format(($non->childproduksiswadaya->sum('salur_benih')),0,",",".")}} {{$non->satuan->nama_satuan}}</td>
                    <td>{{number_format(($non->childproduksiswadaya->sum('produksi_benih')-$non->childproduksiswadaya->sum('salur_benih')),0,",",".")}} {{$non->satuan->nama_satuan}}</td>     
                    <td><a href="{{url('/')}}/detail-produsen/{{$non->lembaga_id}}">Lihat Detail</a></td>
                </tr>
                    @endforeach
                  </tbody>
</table>


<script>
    function fnExcelReport() {
        var table = document.getElementById('theTable'); // id of table
        var tableHTML = table.outerHTML;
        var fileName = 'varprod_non_nas_{{now()}}.xls';

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
            window.location.href = "{{url('/')}}/prokel"; // Replace with your desired URL
        }, 1000); // Delay in milliseconds
    };
</script>
<script src="{{ asset('frontend/js/main.js')}}"></script>