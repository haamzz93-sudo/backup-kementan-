<style>
.row {
  display: flex;
  margin-left:-5px;
  margin-right:-5px;
}

.column {
  flex: 50%;
  padding: 5px;
}

td {
    border: 1px black solid;
    padding: 2px;
    font-size:7px;

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
table {
  border: 1px solid #ddd;
  page-break-inside: avoid !important;
}

th, td {
  text-align: left;
  page-break-inside: avoid !important;
}
</style>
@if(strpos($komoditas->nama, $word) == true)
@for ($x = 1; $x <= $label->jumlah_label; $x++)
<table cellpadding="0" cellspacing="0" align="left" style="width:50%;">
     <tr>
        <td class='rotate' rowspan="12"><div>No. {{$sertibenih->kode}}.{{$label->id}}.<?php echo $x?></div></td>
        <td colspan="5" style="text-align:center;font-weight:bold;text-transform:uppercase">SERTIFIKASI BENIH {{$komoditas->nama}}<br>HASIL {{$cara->cara_banyak}}</td>
        <td class='rotate' rowspan="12" style="background-color:black;color:white;font-weight:bold;"><div>BENIH UNGGUL BERSERTIFIKAT</div></td>
        <td class='rotate' rowspan="12" ><div >{{$lembaga->nama_lembaga}}</div></td> 
        <td class='rotate' rowspan="12"><div>{{$kelas->kelas_benih}}</div></td>
		<td class='rotate' rowspan="12"><img src="data:image/png;base64, {{ base64_encode(QrCode::format('svg')->size(40)->generate($url.'/detail-benihsalur/'.$label->id.'/?kode=.'.$label->id.'.'.$x)) }} "></td>
    </tr>
    <tr>
        <td style="width: 30%;">Nama Produsen</td>
        <td style="width: 1%;">:</td>
        <td style="width: 69%;">{{$lembaga->nama_lembaga}}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{$lembaga->alamat}}, {{$lembaga->provinces->name}}</td>
    </tr>
    <tr>
        <td style="height:36px;">Lembaga Sertifikasi</td>
        <td>:</td>
        <td style="word-wrap:break-word">{{$lembagaser->nama_lembaga}}</td>
    </tr>
    <tr>
        <td>No. Induk Sertifikasi</td>
        <td>:</td>
        <td>{{$sertibenih->no_serti}}</td>
    </tr>
    <tr>
        <td>No. Sertifikasi</td>
        <td>:</td>
        <td>{{$sertibenih->no_label1}}</td>
    </tr>
    <tr>
        <td>Jenis Tanaman</td>
        <td>:</td>
        <td>{{$komoditas->nama}}</td>
    </tr>
    <tr>
        <td>Varietas Batang Bawah</td>
        <td>:</td>
        <td>{{$varietasbwh->nama_varietas}}</td>
    </tr>
    <tr>
        <td>Varietas Batang Atas</td>
        <td>:</td>
        <td>{{$varietasatas->nama_varietas}}</td>
    </tr>
    <tr>
        <td>Tanggal Mulai Perbanyakan</td>
        <td>:</td>
        <td>{{$target->tanggal_r_tanam}}</td>
    </tr>
        <tr>
        <td>Tanggal Pemeriksaan Akhir</td>
        <td>:</td>
        <td>{{$periksa->tanggal_lapor}}</td>
    </tr>
    <tr>
        <td colspan="5">No. Kelompok Benih : {{$label->lot}}</td>
    </tr>
</table>
<br>
@endfor
@else
@for ($x = 1; $x <= $label->jumlah_label; $x++)
<table cellpadding="0" cellspacing="0" align="left" style="width:50%;">
     <tr>
        <td class='rotate' rowspan="11"><div>No. {{$sertibenih->kode}}.{{$label->id}}.<?php echo $x?></div></td>
        <td colspan="4" style="text-align:center;font-weight:bold;text-transform:uppercase">SERTIFIKASI BENIH {{$komoditas->nama}}<br>HASIL {{$cara->cara_banyak}}</td>
        <td class='rotate' rowspan="11" style="background-color:black;color:white;font-weight:bold;"><div>BENIH UNGGUL BERSERTIFIKAT</div></td>
        <td class='rotate' rowspan="11" ><div >{{$lembaga->nama_lembaga}}</div></td> 
        <td class='rotate' rowspan="11"><div>{{$kelas->kelas_benih}}</div></td>
		<td class='rotate' rowspan="11"><img src="data:image/png;base64, {{ base64_encode(QrCode::format('svg')->size(40)->generate($url.'/detail-benihsalur/'.$label->id.'/?kode=.'.$label->id.'.'.$x)) }} "></td>
    </tr>
    <tr>
        <td style="width: 30%;">Nama Produsen</td>
        <td style="width: 1%;">:</td>
        <td style="width: 69%;">{{$lembaga->nama_lembaga}}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{$lembaga->alamat}}, {{$lembaga->provinces->name}}</td>
    </tr>
    <tr>
        <td style="height:36px;">Lembaga Sertifikasi</td>
        <td>:</td>
        <td style="word-wrap:break-word">{{$lembagaser->nama_lembaga}}</td>
    </tr>
    <tr>
        <td>No. Induk Sertifikasi</td>
        <td>:</td>
        <td>{{$sertibenih->no_serti}}</td>
    </tr>
    <tr>
        <td>No. Sertifikasi</td>
        <td>:</td>
        <td>{{$sertibenih->no_label1}}</td>
    </tr>
    <tr>
        <td>Jenis Tanaman</td>
        <td>:</td>
        <td>{{$komoditas->nama}}</td>
    </tr>
    <tr>
        <td>Varietas</td>
        <td>:</td>
        <td>{{$varietasatas->nama_varietas}}<</td>
    </tr>
    <tr>
        <td>Tanggal Mulai Perbanyakan</td>
        <td>:</td>
        <td>{{$target->tanggal_r_tanam}}</td>
    </tr>
        <tr>
        <td>Tanggal Pemeriksaan Akhir</td>
        <td>:</td>
        <td>{{$periksa->tanggal_lapor}}</td>
    </tr>
    <tr>
        <td colspan="4">No. Kelompok Benih : {{$label->lot}}</td>
    </tr>
</table>
<br>
@endfor
@endif