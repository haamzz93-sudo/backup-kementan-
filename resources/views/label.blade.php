
<style>
td {
    border: 1px black solid;
    padding: 5px;
    font-size:12px;
}
.rotate {
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  width: 1.5em;
}
.rotate div {
     -moz-transform: rotate(-90.0deg);  /* FF3.5+ */
       -o-transform: rotate(-90.0deg);  /* Opera 10.5 */
  -webkit-transform: rotate(-90.0deg);  /* Saf3.1+, Chrome */
             filter:  progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083);  /* IE6,IE7 */
         -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)"; /* IE8 */
         margin-left: -10em;
         margin-right: -10em;
}
table, tr, td, th, tbody, thead, tfoot {
    page-break-inside: avoid !important;
}
</style>


@foreach($label as $row)
@if ($row->komoditas_id !== 11)
<table cellpadding="0" cellspacing="0" align="center" style="width:900px">
    
    <!--<tr>
        <td class='rotate' rowspan="9"><div>No. {{$row->no_label}}</div></td>
        <td colspan="3" style="text-align:center;font-weight:bold;text-transform:uppercase">SERTIFIKASI BENIH {{$row->nama_komoditas}}<br>HASIL {{$row->cara_banyak}} BEBAS GEJALA PENYAKIT</td>
        <td class='rotate' rowspan="9" style="background-color:black;color:white;font-weight:bold"><div>BENIH UNGGUL BERSETIFIKAT</div></td>
        <td class='rotate' rowspan="9"><div>{{$row->nama_lembaga}}</div></td>
        <td class='rotate' rowspan="9"><div>{{$asu->kelas_benih}}</div></td>
        <td class='rotate' rowspan="9"><img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate($row->no_label)) }} "></td>
    </tr>
    <tr>
        <td style="width: 30%;">Nama Produsen</td>
        <td style="width: 1%;">:</td>
        <td style="width: 69%;">{{$row->nama_lembaga}}</td>
    </tr>
    <tr>
        <td style="height:36px">Alamat</td>
        <td>:</td>
        <td>{{$row->alamat}}</td>
    </tr>
    <tr>
        <td>No. Induk Sertifikat</td>
        <td>:</td>
        <td>{{$row->no_label1}}</td>
    </tr>
    <tr>
        <td>Jenis Tanaman</td>
        <td>:</td>
        <td>{{$row->nama_komoditas}}</td>
    </tr>
    <tr>
        <td>Varietas</td>
        <td>:</td>
        <td>{{$row->nama_varietas}}</td>
    </tr>
    <tr>
        <td>Tanggal Tanam</td>
        <td>:</td>
        <td>{{$row->tgl_okulasi}}</td>
    </tr>
        <tr>
        <td>Tanggal Pemeriksaan Akhir</td>
        <td>:</td>
        <td>{{$row->tgl_periksa_akhir}}</td>
    </tr>
    <tr>
        <td colspan="3"></td>
    </tr>-->
     <tr>
        <td class='rotate' rowspan="9"><div>No. Lkg.A02.12.2036.02.22.10012983</div></td>
        <td colspan="3" style="text-align:center;font-weight:bold;text-transform:uppercase">SERTIFIKASI BENIH LENGKENG<br>HASIL OKULASI BEBAS GEJALA PENYAKIT</td>
        <td class='rotate' rowspan="9" style="background-color:black;color:white;font-weight:bold"><div>BENIH UNGGUL BERSETIFIKAT</div></td>
        <td class='rotate' rowspan="9"><div>BBH Gedung Johor</div></td>
        <td class='rotate' rowspan="9"><div>Benih Salur</div></td>
		<td class='rotate' rowspan="9"><img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate('https://proceed.klinikberdikari.id/public/detail-benihsalur')) }} "></td>
    </tr>
    <tr>
        <td style="width: 30%;">Nama Produsen</td>
        <td style="width: 1%;">:</td>
        <td style="width: 69%;">BBH Gedung Johor</td>
    </tr>
    <tr>
        <td style="height:36px">Alamat</td>
        <td>:</td>
        <td>Jl. Karya Jaya No. 22 Pangkalan Masyhur Medan</td>
    </tr>
    <tr>
        <td>No. Induk Sertifikat</td>
        <td>:</td>
        <td>Sert.0902/02.2022/829</td>
    </tr>
    <tr>
        <td>Jenis Tanaman</td>
        <td>:</td>
        <td>Lengkeng</td>
    </tr>
    <tr>
        <td>Varietas</td>
        <td>:</td>
        <td>Diamond River</td>
    </tr>
    <tr>
        <td>Tanggal Tanam</td>
        <td>:</td>
        <td>2022-02-18</td>
    </tr>
        <tr>
        <td>Tanggal Pemeriksaan Akhir</td>
        <td>:</td>
        <td>2023-02-24</td>
    </tr>
    <tr>
        <td colspan="3"></td>
    </tr>
</table>
<br>
@else 
<table cellpadding="0" cellspacing="0" align="center" style="width:900px">
    
    <tr>
        <td class='rotate' rowspan="11"><div>No. {{$row->no_label}}</div></td>
        <td colspan="3" style="text-align:center;font-weight:bold;text-transform:uppercase">SERTIFIKASI BENIH {{$row->nama_komoditas}}<br>HASIL {{$row->cara_banyak}} BEBAS GEJALA PENYAKIT</td>
        <td class='rotate' rowspan="11" style="background-color:black;color:white;font-weight:bold"><div>BENIH UNGGUL BERSETIFIKAT</div></td>
        <td class='rotate' rowspan="11"><div>{{$row->nama_lembaga}}</div></td>
        <td class='rotate' rowspan="11"><div>{{$asu->kelas_benih}}</div></td>
        <!--<td class='rotate' rowspan="11"><img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate($row->no_label)) }} "></td>-->
		<td class='rotate' rowspan="11"><img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate('https://proceed.klinikberdikari.id/public/detail-benihsalur')) }} "></td>
    </tr>
    <tr>
        <td style="width: 30%;">Nama Produsen</td>
        <td style="width: 1%;">:</td>
        <td style="width: 69%;">{{$asu->nama_lembaga}}</td>
    </tr>
    <tr>
        <td style="height:36px">Alamat</td>
        <td>:</td>
        <td>{{$asu->alamat}}</td>
    </tr>
    <tr>
        <td>No. Induk</td>
        <td>:</td>
        <td>ini nempel dmn</td>
    </tr>
    <tr>
        <td>Jenis Tanaman</td>
        <td>:</td>
        <td>{{$row->nama_komoditas}}</td>
    </tr>
    <tr>
        <td>Varietas Batang Bawah</td>
        <td>:</td>
        <td>label->var-id</td>
    </tr>
    <tr>
        <td>Varietas Batang Atas</td>
        <td>:</td>
        <td>{{$asu->nama_varietas}}</td>
    </tr>
    <tr>
        <td>Tanggal Perbanyakan</td>
        <td>:</td>
        <td>{{$row->tgl_okulasi}}</td>
    </tr>
        <tr>
        <td>Tanggal Pemeriksaan Akhir</td>
        <td>:</td>
        <td>{{$row->tgl_periksa_akhir}}</td>
    </tr>
        <tr>
        <td>Masa Berlaku Label s/d</td>
        <td>:</td>
        <td>{{$row->tgl_berlaku}}</td>
    </tr>
    <tr>
        <td colspan="3">Nomor apa ya</td>
    </tr>
    
</table>
<br>
    
    @endif
@endforeach

