<head>

    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <link href="https://nightly.datatables.net/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
    <script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <style>
        body {
            font: 90%/1.45em "Helvetica Neue", HelveticaNeue, Verdana, Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <table id="example" class="display nowrap" width="100%">
            <thead>
                <tr>
                    <th>Kode Varietas</th>
                    <th>No. SK</th>
                    <th>Kelompok Komoditas</th>
                    <th>Komoditas</th>
                    <th>Nama Varietas</th>
                    <th>Nama Pemohon</th>
                    <th>Tahun Daftar</th>
                    <th>Produk</th>
                    <th>Penciri</th>
                    <th>Deskripsi</th>
                    <th>Wilayah Adaptasi</th>
                    <th>Iklim</th>
                    <th>Asal</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>Kode Varietas</th>
                    <th>No. SK</th>
                    <th>Kelompok Komoditas</th>
                    <th>Komoditas</th>
                    <th>Nama Varietas</th>
                    <th>Nama Pemohon</th>
                    <th>Tahun Daftar</th>
                    <th>Produk</th>
                    <th>Penciri</th>
                    <th>Deskripsi</th>
                    <th>Wilayah Adaptasi</th>
                    <th>Iklim</th>
                    <th>Asal</th>
                </tr>
            </tfoot>

            <tbody>
                @foreach($v as $var)
                <tr>
                    <td>{{$var->kode}}</td>
                    <td>{{$var->no_sk}}</td>
                    <td>{{$var->kelkomoditas->nama_kelompok}}</td>
                    <td>{{$var->komoditas->nama}}</td>
                    <td>{{$var->nama_varietas}}</td>
                    <td>{{$var->pemohon->nama_produsen ?? "Belum ada Produsen"}}</td>
                    <td>{{$var->tahun_daftar}}</td>
                    <td><a href="{{url('/storage') . " /" . $var->upload_produk}}" target="_blank">Klik Disini</a></td>
                    <td><a href="{{url('/storage') . " /" . $var->upload_penciri}}" target="_blank">Klik Disini</a></td>
                    <td><a href="{{url('/storage') . " /" . $var->upload_deskripsi}}" target="_blank">Klik Disini</a>
                    </td>
                    <td>
                        @php
                        $wilAdaptasiArray = $var->wil_adaptasi;
                        @endphp
                        @if (!empty($wilAdaptasiArray))
                        @foreach($wilAdaptasiArray as $item)
                        @if($item==1)
                        <p>Dataran Rendah</p>
                        @elseif($item==2)
                        <p>Dataran Menengah</p>
                        @elseif($item==3)
                        <p>Dataran Tinggi</p>
                        @endif
                        @endforeach
                        @else
                        <p>Tidak Ada Data</p>
                        @endif
                    </td>
                    <td>
						@php
                        $iklimas = $var->iklim;
                        @endphp
                        @if (!empty($iklimas))
                        @foreach($iklimas as $item1)
                        @if($item1==1)
                        <p>Musim Hujan</p>
                        @elseif($item==2)
                        <p>Musim Kemarau</p>
                        @endif
                        @endforeach
                        @else
                        <p>Tidak Ada Data</p>
                        @endif
                    </td>
                    <td>
                        @php
                        $tes = $var->asal;
                        if ($tes==1) {
                        echo "Introduksi";
                        } elseif($tes==2) {
                        echo "Dalam Negeri";
                        } else{
                        echo "Belum Diisi";
                        }
                        @endphp
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <script>
       $(document).ready(function () {
    var table = $('#example').DataTable({
        initComplete: function () {
            count = 0;
            this.api().columns().every(function () {
                var title = this.header();
                title = $(title).html().replace(/[\W]/g, '-');
                var column = this;

                // Disable filtering for specific columns
                if (["Kode-Varietas", "Nama-Varietas", "Produk", "Penciri", "Deskripsi"].indexOf(title) === -1) {
                    var select = $('<select id="' + title + '" class="select2"></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var data = $.map($(this).select2('data'), function (value, key) {
                                return value.text ? '^' + $.fn.dataTable.util.escapeRegex(value.text) + '$' : null;
                            });

                            if (data.length === 0) {
                                data = [""];
                            }

                            var val = data.join('|');

                            column
                                .search(val ? val : '', true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>');
                    });

                    $('#' + title).select2({
                        multiple: true,
                        closeOnSelect: false,
                        placeholder: "Select a " + title
                    });

                    $('.select2').val(null).trigger('change');
                }
            });
        }
    });
});

    </script>
</body>

</html>