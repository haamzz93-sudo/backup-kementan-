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
                      <th class="garis text-center" rowspan="2">TAHUN TARGET PRODUKSI</th>
                      <th class="garis text-center" rowspan="2">KODE PRODUSEN</th>
                      <th class="garis text-center" rowspan="2">JENIS PRODUSEN</th>
                      <th class="garis text-center" rowspan="2">NAMA PRODUSEN</th>
                      <th class="garis text-center" rowspan="2">NAMA PROVINSI</th>
                      <th class="garis text-center" rowspan="2">NAMA KABUPATEN</th>
                      <th class="garis text-center" rowspan="2">NAMA KECAMATAN</th>
                      <th class="garis text-center" rowspan="2">NAMA DESA</th>
                      <th class="garis text-center" rowspan="2">ALAMAT</th>
                      <th class="garis text-center" rowspan="2">LOKASI PRODUKSI</th>
                      <th class="garis text-center" rowspan="2">KOMODITAS - VARIETAS</th>
                      <th class="garis text-center" rowspan="2">TARGET PRODUKSI</th>
                      <th class="garis text-center" rowspan="2">TARGET SALUR</th>
                      <th class="garis text-center" colspan="4">PROSES PERBANYAKAN</th>
                      <th class="garis text-center" colspan="4">MENCAPAI PTM</th>
                      <th class="garis text-center" colspan="4">SIAP SALUR</th>
                      <th class="garis text-center" rowspan="2">TERSALUR</th>
                      <th class="garis text-center" rowspan="2">KINERJA PENYALURAN</th>
                      <th class="garis text-center" rowspan="2">SISA STOK</th>
                      <th class="garis text-center" rowspan="2">STATUS</th>
                      <th class="garis text-center" rowspan="2">LIHAT DETAIL PRODUSEN</th>
                    </tr>
                    <tr class="garis text-center">
                      <th class="garis text-center">BERHASIL</th>
                      <th class="garis text-center">GAGAL</th>
                      <th class="garis text-center">BELUM DIPROSES</th>
                      <th class="garis text-center">KINERJA PERBANYAKAN</th>
                      <th class="garis text-center">BERHASIL</th>
                      <th class="garis text-center">GAGAL</th>
                      <th class="garis text-center">BELUM PTM</th>
                      <th class="garis text-center">KINERJA PTM</th>
                      <th class="garis text-center">BERLABEL</th>
                      <th class="garis text-center">PENGURANGAN BERLABEL</th>
                      <th class="garis text-center">BELUM BERLABEL</th>
                      <th class="garis text-center">KINERJA BERLABEL</th>
                    </tr>
                  </thead>
				  <tbody>
                  @foreach($targetnya as $target)
                    @if(optional($target->lembaga)->jenis_produsen_id == 4 && isset($target->lembaga->nama_lembaga) && $target->status!="tolak")
                    @php
                    $jumlah = DB::table('target_benih')
                    ->join('lap_benih_panen','lap_benih_panen.target_benih_id','target_benih.id')
                    ->join('lap_benih_label','lap_benih_label.lap_benih_panen_id','lap_benih_panen.id')
                    ->where('target_benih.id',$target->id)
                    ->sum('jumlah_lanjut');
                    @endphp
                    <!--Lokasi Produksi-->
                    <tr>
                    <td class="garis text-center">{{$target->tahun}}</td>
                    <td class="garis text-center">{{$target->lembaga->kode_produsen ?? 'Belum Ada Kode'}}</td>
                    <td class="garis text-center">{{$target->lembaga->jenisprodusen->nama_jenis ?? 'Belum Ada Jenis'}}</td>
                    <td class="garis text-center">{{$target->lembaga->nama_lembaga}}</td>
                    <td class="garis text-center">{{$target->lembaga->provinces->name ?? 'Provinsi Belum Diisi'}}</td>
                    <td class="garis text-center">{{$target->lembaga->regencies->name ?? 'Kabupaten Belum Diisi'}}</td>
                    <td class="garis text-center">{{$target->lembaga->districts->name ?? 'Kecamatan Belum Diisi'}}</td>
                    <td class="garis text-center">{{$target->lembaga->villages->name ?? 'Desa Belum Diisi'}}</td>
                    <td class="garis text-center">{{$target->lembaga->alamat ?? 'Alamat Belum Diisi'}}</td>
                    <td class="garis text-center">{{$target->lokasiproduksidetail->alamat ?? 'Alamat Tidak Diisi'}}</td>
                    
                    <td class="garis text-center">{{$target->komoditas->nama}} - {{$target->varietas->nama_varietas ?? 'Varietas Tidak Dipilih'}}</td>
                    <td class="garis text-center">{{number_format($target->jum_target,0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <td class="garis text-center">{{number_format($target->targetsalur->sum('jumlah'),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    
                    <!--Proses Perbanyakan Berhasil-->
                    <td class="garis text-center">{{number_format(($target->produksi->sum('pengadaan_benih')-$target->produksimati->sum('produksi_mati')),0,",",".")}} {{$target->satuan->nama_satuan}}</td>

                    <!--Proses Perbanyakan Gagal-->
                    <td class="garis text-center">{{number_format($target->produksimati->sum('produksi_mati'),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <!-- bELUM PROSES -->
                    <td class="garis text-center">{{number_format(($target->jum_target-$target->produksi->sum('pengadaan_benih')+$target->produksimati->sum('produksi_mati')),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    
                    <!--Kinerja Perbanyakan-->
                    <td class="garis text-center">
                        @if(($target->produksi->sum('pengadaan_benih')-$target->produksimati->sum('produksi_mati'))>0 )
                        {{number_format((($target->produksi->sum('pengadaan_benih')-$target->produksimati->sum('produksi_mati'))*100/$target->jum_target),0,",",".")."%"}}
                        
                        @else
                        Belum Ada Pelaporan
                        @endif
                        </td>
                    <!--PTM Berhasil-->
                    <td class="garis text-center">{{number_format(($target->ptm->sum('jum_panen')-$target->ptmmati->sum('label_mati')),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <!--PTM Gagal-->
                    <td class="garis text-center">{{number_format($target->ptmmati->sum('label_mati'),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <!-- BELUM PTM -->
                    <td class="garis text-center">{{number_format(($target->produksi->sum('pengadaan_benih')-$target->produksimati->sum('produksi_mati')-$target->ptm->sum('jum_panen')+$target->ptmmati->sum('label_mati')))}} {{$target->satuan->nama_satuan}}</td>
                    <!--Proses Kinerja PTM-->
                    <td class="garis text-center">
                        @if(($target->ptm->sum('jum_panen')-$target->ptmmati->sum('label_mati'))>0)
                        {{number_format((($target->ptm->sum('jum_panen')-$target->ptmmati->sum('label_mati'))*100/$target->jum_target),0,",",".")."%"}}
                        @else
                        Belum Ada Pelaporan
                        @endif
                        </td>
                    <!--Siap Salur Berlabel-->
                    <td class="garis text-center">{{number_format(($jumlah-$target->penguranganstok->sum('jumlah')),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <!--Siap Salur Mati Berlabel-->
                    <td class="garis text-center">{{number_format($target->penguranganstok->sum('jumlah'),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <!--Siap Salur belum Berlabel-->
                    <td class="garis text-center">{{number_format(($target->ptm->sum('jum_panen')-$target->ptmmati->sum('label_mati')-$jumlah),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <!--Proses Kinerja Berlabel-->
                    <td class="garis text-center">
                        @if(($jumlah-$target->penguranganstok->sum('jumlah'))>0)
                        {{number_format((($jumlah-$target->penguranganstok->sum('jumlah'))*100/$target->jum_target),0,",",".")."%"}}
                        @else
                        Belum Ada Pelaporan
                        @endif</td>
                    <!--tersalur-->
                    <td class="garis text-center">{{number_format($target->penyaluranstok->sum('jumlah'),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <!--Kinerja tersalur-->
                    <td class="garis text-center">
                        @if(($target->penyaluranstok->sum('jumlah'))>0)
                        {{number_format((($target->penyaluranstok->sum('jumlah'))*100/$target->jum_target),0,",",".")."%"}}
                        @else
                        Belum Ada Pelaporan
                        @endif
                        </td>
                    <!--stok-->
                    <td class="garis text-center">{{number_format(($jumlah-$target->penguranganstok->sum('jumlah')-$target->penyaluranstok->sum('jumlah')),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <td class="garis text-center">
                      @if($target->status=="active")
                      Terverifikasi
                      @elseif($target->status=="pending")
                      Diajukan Ulang
                      @elseif($target->status=="tolak")
                      Ditolak dengan keterangan {{$target->keterangan}}
                      @elseif($target->status=="selesai")
                      Target Selesai
                      @else
                      Diajukan
                      @endif</td>
                      <td class="garis text-center"><a href="{{url('/')}}/detail-produsen/{{$target->lembaga->id}}">Lihat Detail</a></td>
                    </tr>
                    @endif
                    @endforeach
                  </tbody>
	</table>


<script>
    function fnExcelReport() {
        var table = document.getElementById('theTable'); // id of table
        var tableHTML = table.outerHTML;
        var fileName = 'varprod_nas_{{now()}}.xls';

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