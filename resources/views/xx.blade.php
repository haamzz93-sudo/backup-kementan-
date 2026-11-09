
@php
    $num_labels = $label->jumlah_label;
    $num_columns = 2; // Number of columns
    $labels_per_column = ceil($num_labels / $num_columns); // Calculate labels per column
@endphp
@if(strpos($komoditas->nama, $word) == true)
@for ($i = 0; $i < $num_columns; $i++)
<div class="row">
    @for ($j = $i * $labels_per_column; $j < min(($i + 1) * $labels_per_column, $num_labels); $j++)
        @php
            $x = $j + 1;
        @endphp
        <div class="column">
            <table cellpadding="0" cellspacing="0" align="left" style="width:50%;">
                <!-- Your table rows -->
                <tr>
                   <td colspan="5" style="text-align:center;font-weight:bold;text-transform:uppercase">SERTIFIKASI BENIH {{$komoditas->nama}}<br>HASIL {{$cara->cara_banyak}}</td>
                        <td class='rotate'><img src="data:image/png;base64, {{ base64_encode(QrCode::format('svg')->size(40)->generate($url.'/detail-benihsalur/'.$label->id.'/?kode=.'.$label->id.'.'.$x)) }} "></td>
                        <td class='rotate' rowspan="12" style="background-color:black;color:white;font-weight:bold;"><div>BENIH UNGGUL BERSERTIFIKAT</div></td>
                        <td class='rotate' rowspan="12" ><div >{{$lembaga->nama_lembaga}}</div></td> 
                        <td class='rotate' rowspan="12"><div>{{$kelas->kelas_benih}}</div></td>
                </tr>
                <tr>
        <td style="width: 30%;">No.</td>
        <td style="width: 1%;">:</td>
        <td style="width: 69%;">{{$sertibenih->kode}}.{{$label->id}}.{{$x}}</td>
    </tr>
                    <tr>
                        <td>Nama Produsen</td>
                        <td>:</td>
                        <td>{{$lembaga->nama_lembaga}}</td>
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
                <!-- Other rows and cells -->
            </table>
        </div>
    @endfor
</div>
@endfor
@else
@for ($i = 0; $i < $num_columns; $i++)
<div class="row">
    @for ($j = $i * $labels_per_column; $j < min(($i + 1) * $labels_per_column, $num_labels); $j++)
        @php
            $x = $j + 1;
        @endphp
        <div class="column">
            <table cellpadding="0" cellspacing="0" align="left" style="width:50%;">
            <tr>
        <td colspan="5" style="text-align:center;font-weight:bold;text-transform:uppercase">SERTIFIKASI BENIH {{$komoditas->nama}}<br>HASIL {{$cara->cara_banyak}}</td>
		<td class='rotate' rowspan="5"><img src="data:image/png;base64, {{ base64_encode(QrCode::format('svg')->size(40)->generate($url.'/detail-benihsalur/'.$label->id.'/?kode=.'.$label->id.'.'.$x)) }} "></td>
        <td class='rotate' rowspan="12" style="background-color:black;color:white;font-weight:bold;"><div>BENIH UNGGUL BERSERTIFIKAT</div></td>
        <td class='rotate' rowspan="12" ><div >{{$lembaga->nama_lembaga}} <br> {{$kelas->kelas_benih}} <br></div></td> 
        
    </tr>
            <tr>
        <td style="width: 30%;">No.</td>
        <td style="width: 1%;">:</td>
        <td style="width: 69%;">{{$sertibenih->kode}}.{{$label->id}}.{{$x}}</td>
    </tr>
    <tr>
        <td>Nama Produsen</td>
        <td>:</td>
        <td>{{$lembaga->nama_lembaga}}</td>
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
        <td>No. Kelompok Benih</td>
        <td>:</td>
        <td>{{$label->lot}}</td>
    </tr>
            </table>
        </div>
    @endfor
</div>
@endfor
@endif