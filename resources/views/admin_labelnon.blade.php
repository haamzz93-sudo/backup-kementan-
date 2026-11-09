<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Label Non</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100mm; /* 10 cm */
            height: 46mm; /* 4.2 cm */
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .table-wrapper {
            width: 100%;
            position: relative;
            background-repeat: no-repeat;
            background-size: 20%;
            background-position: center;
            opacity: 0.3; /* Adjust opacity as needed */
        }

        table {
            border: 1px solid #ddd;
            width: 100%;
            page-break-inside: avoid !important;
        }

        .tg {
            border-collapse: collapse;
            border-color: black;
            border-style: solid;
        }

        .tg td {
            font-size: 6px;
            padding: 1px 1px;
            page-break-inside: avoid !important;
        }

        .tg th {
            font-size: 9px;
            padding: 10px;
            page-break-inside: avoid !important;
        }

        .tg .tg-0pky {
            text-align: left;
            vertical-align: top;
        }

        .rotate {
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            width: 1.5em;
        }

        .rotate div {
            transform: rotate(-90.0deg);
            -moz-transform: rotate(-90.0deg); /* FF3.5+ */
            -o-transform: rotate(-90.0deg); /* Opera 10.5 */
            -webkit-transform: rotate(-90.0deg); /* Saf3.1+, Chrome */
            filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083); /* IE6,IE7 */
            -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)"; /* IE8 */
            margin-left: -10em;
            margin-right: -10em;
            font-weight: bold;
        }
    </style>
</head>
<body>
    
    <div class="container">
        @php
            ini_set('max_execution_time','0');
            $type1 = pathinfo($path1, PATHINFO_EXTENSION);
            $data1 = file_get_contents($path1);
            $logo1 = 'data:image/' . $type1 . ';base64,' . base64_encode($data1);

            $type2 = pathinfo($path2, PATHINFO_EXTENSION);
            $data2 = file_get_contents($path2);
            $logo2 = 'data:image/' . $type2 . ';base64,' . base64_encode($data2);
            
        @endphp
        @php
            $nomor_awal = (int)$label->no_awal;
            $nomor_akhir = (int)$label->no_akhir;
            $max_length = strlen((string)$nomor_akhir);
            $fixed_rows = 10;
            $kolom = 0;
            foreach($result as $k) {
                if($k['value'] !== null) {
                    $kolom++;
                }
            }
        @endphp

        @for($i = $nomor_awal; $i <= $nomor_akhir; $i++)
            @php
                $formatted_number = str_pad($i, $max_length, '0', STR_PAD_LEFT);
            @endphp
            <div class="table-wrapper" style="background-image: url('{{ $logo2 }}');">
                <table class="tg">
                    <thead>
                        <tr>
                            <td class="tg-0pky" colspan="8" style="text-transform:uppercase;font-weight:bold;font-size:10px">
                                SERTIFIKASI BENIH {{$sert->komoditas->nama}} Hasil {{$sert->cara->cara_banyak}}
                            </td>
                            <td class="rotate" colspan ="1" rowspan="{{ $kolom + $fixed_rows }}" style="background-color:black;color:white;"><div>BENIH UNGGUL BERSERTIFIKAT</div></td>
                            @if($lembaga_non->jenis_lembaga_id !==2 && $lembaga_non->jenis_lembaga_id !==6 && $lembaga_non->jenis_lembaga_id !==8)
                            <td class="rotate" colspan ="1" rowspan="{{ $kolom + $fixed_rows }}" style="font-size:8px;padding-left:10px;padding-right:10px; text-transform:uppercase; font-size: 5px;"><div class="">{{$sert->kelasbenih->kelas_benih}}<br>{{$lembaga_non->nama_lembaga}}</div></td>
                            @else
                            <td class="rotate" colspan ="1" rowspan="{{ $kolom + $fixed_rows }}" style="font-size:8px;padding-left:10px;padding-right:10px; text-transform:uppercase; font-size: 5px;"><div class="">{{$sert->kelasbenih->kelas_benih}}<br>BALAI PENGAWASAN DAN <br>SERTIFIKASI BENIH<br> {{$lembaga_non->provinces->name}}</div></td>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="tg-0pky" colspan="2">No. Seri Label</td>
                            <td class="tg-0pky">:</td>
                            <td class="tg-0pky" colspan="4">{{$label->kode_urut_awal}} - {{$formatted_number}}</td>
                            <td class="tg-0pky" rowspan="5">
                                <img src="{{$logo1}}" width="30" height="30">
                            </td>
                        </tr>
                        <tr>
                            <td class="tg-0pky" colspan="2">Nama Produsen</td>
                            <td class="tg-0pky">:</td>
                            <td class="tg-0pky" colspan="4">{{$lembaga_non->nama_lembaga}}</td>
                        </tr>
                        <tr>
                            <td class="tg-0pky" colspan="2">Alamat Lembaga</td>
                            <td class="tg-0pky">:</td>
                            <td class="tg-0pky" colspan="4">{{$lembaga_non->alamat}}</td>
                        </tr>
                        <tr>
                            <td class="tg-0pky" colspan="2">No. Induk</td>
                            <td class="tg-0pky">:</td>
                            <td class="tg-0pky" colspan="4">{{$label->no_induk_sertifikasi}}</td>
                        </tr>
                        <tr>
                            <td class="tg-0pky" colspan="2">Komoditas</td>
                            <td class="tg-0pky">:</td>
                            <td class="tg-0pky" colspan="4">{{$sert->komoditas->nama}}</td>
                        </tr>
                        <tr>
                            <td class="tg-0pky" colspan="2">Varietas</td>
                            <td class="tg-0pky">:</td>
                            <td class="tg-0pky" colspan="4">{{$sert->varietas->nama_varietas}}</td>
                            
                            <td class="tg-0pky" rowspan="4">
                              <div style="margin-left:auto; margin-right:auto; display:block; position: relative; width: 30px; height: 30px;">
                                <img src="data:image/png;base64, {{ base64_encode(QrCode::format('svg')->size(50)->generate($url.'/detail-produsen-non/'.$id)) }} " style="width:30px;height:30px;position: relative; top: 0; left: 0;">
                                </div>
                            </td>
                        </tr>
                        
                        @foreach ($result as $item)
                            @if($item['value'] !== null)
                                <tr>
                                    <td class="tg-0pky" colspan="2">{{ $item['key'] }}</td>
                                    <td class="tg-0pky" colspan="1">:</td>
                                    <td class="tg-0pky" colspan="4">{{ $item['value'] }}</td>
                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <td class="tg-0pky" colspan="2">No. Lot/No. Kelompok Benih</td>
                            <td class="tg-0pky" colspan="1">:</td>
                            <td class="tg-0pky" colspan="4">{{$label->no_batch}}</td>
                        </tr>
                        @if(strpos($komoditas->nama, $word) == true)
                        <tr>
                            <td class="tg-0pky" colspan="2">Status Cetak Label</td>
                            <td class="tg-0pky" colspan="1">:</td>
                            @if($label->jumlah_download >"1")
                                <td class="tg-0pky"colspan="5"><b>DIPERBAHARUI</b></td>
                            @else
                                <td class="tg-0pky"colspan="5"><b>LABEL BARU CETAK</b></td>
                            @endif
                        </tr>
                        @endif
                        <tr>
                            <td class="tg-0pky" colspan="10">{{$label->jumlah_label_download}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endfor
    </div>
</body>
</html>