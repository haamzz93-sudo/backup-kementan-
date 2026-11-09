@extends('layout/database')
@section('title')
Detail Produsen
@endsection
@section('meta')
<meta charset="utf-8" />
<meta name="keywords" content="Detail Produsen">
<meta property="og:url" content="" />
<meta property="og:type" content="article" />
<meta property="og:title" content="Detail Produsen" />
<meta property="og:description" content="" />
<meta property="og:image" content="" />
<meta name="csrf-token" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
@endsection

@section('content')

<style>
  .modal {
    visibility: hidden;
    opacity: 0;
    position: fixed;

    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(77, 77, 77, .0);
    transition: all .4s;
  }

  .modal:target {
    visibility: visible;
    opacity: 1;
    color: #fff;
  }

  .modal__content {
    border-radius: 4px;
    position: relative;
    width: 800px;
    max-width: 100%;
    max-height: 75%;
    color: #000;
    background: #009970;
    padding: 1em 1em 17em 2em;
    overflow-y: scroll;
  }

  .modal__footer {
    text-align: right;

    a {
      color: #585858;
    }

    i {
      color: #d02d2c;
    }
  }

  .modal__close {
    position: absolute;
    top: 10px;
    right: 10px;
    color: #ffffff;
    text-decoration: none;
  }

  .artist-info .table-container {
    background: #ffffff;
    padding: 2em;
    border-radius: 1em;
    box-shadow: 0 2px 10px rgba(0, 0, 0, .5);
    margin-top: 2em;
  }

  /*
 * Table styles
 */
  table {
    width: 100%;
  }

  .garis {
    border: 1px solid black;
    background-color: #FFF;
  }

  table.dataTable {
    width: 100%;
    margin: 0 auto;
    clear: both;
    border-collapse: separate;
    border-spacing: 0;
    /*
   * Header and footer styles
   */
    /*
   * Body styles
   */
  }

  table.dataTable thead th,
  table.dataTable tfoot th {
    font-weight: bold;
  }

  table.dataTable thead th,
  table.dataTable thead td {
    padding: 10px 18px;
    border-bottom: 1px none #111111;
  }

  table.dataTable thead th:active,
  table.dataTable thead td:active {
    outline: none;
  }

  table.dataTable tfoot th,
  table.dataTable tfoot td {
    padding: 10px 18px 6px 18px;
    border-top: 1px none #111111;
  }

  table.dataTable thead .sorting,
  table.dataTable thead .sorting_asc,
  table.dataTable thead .sorting_desc {
    cursor: pointer;
    *cursor: hand;
  }

  table.dataTable thead .sorting,
  table.dataTable thead .sorting_asc,
  table.dataTable thead .sorting_desc,
  table.dataTable thead .sorting_asc_disabled,
  table.dataTable thead .sorting_desc_disabled {
    background-repeat: no-repeat;
    background-position: center right;
  }

  table.dataTable thead .sorting {
    background-image: url("../images/sort_both.png");
  }

  table.dataTable thead .sorting_asc {
    background-image: url("../images/sort_asc.png");
  }

  table.dataTable thead .sorting_desc {
    background-image: url("../images/sort_desc.png");
  }

  table.dataTable thead .sorting_asc_disabled {
    background-image: url("../images/sort_asc_disabled.png");
  }

  table.dataTable thead .sorting_desc_disabled {
    background-image: url("../images/sort_desc_disabled.png");
  }

  table.dataTable tbody tr {
    background-color: white;
  }

  table.dataTable tbody tr.selected {
    background-color: #f6c2ff;
  }

  table.dataTable tbody th,
  table.dataTable tbody td {
    padding: 8px 10px;
  }

  table.dataTable.row-border tbody th,
  table.dataTable.row-border tbody td,
  table.dataTable.display tbody th,
  table.dataTable.display tbody td {
    border-top: 1px none #dddddd;
  }

  table.dataTable.row-border tbody tr:first-child th,
  table.dataTable.row-border tbody tr:first-child td,
  table.dataTable.display tbody tr:first-child th,
  table.dataTable.display tbody tr:first-child td {
    border-top: none;
  }

  table.dataTable.cell-border tbody th,
  table.dataTable.cell-border tbody td {
    border-top: 1px none #dddddd;
    border-right: 1px none #dddddd;
  }

  table.dataTable.cell-border tbody tr th:first-child,
  table.dataTable.cell-border tbody tr td:first-child {
    border-left: 1px none #dddddd;
  }

  table.dataTable.cell-border tbody tr:first-child th,
  table.dataTable.cell-border tbody tr:first-child td {
    border-top: none;
  }

  table.dataTable.stripe tbody tr.odd,
  table.dataTable.display tbody tr.odd {
    background-color: #f9f9f9;
  }

  table.dataTable.stripe tbody tr.odd.selected,
  table.dataTable.display tbody tr.odd.selected {
    background-color: #f0bdf9;
  }

  table.dataTable.hover tbody tr:hover,
  table.dataTable.display tbody tr:hover {
    background-color: whitesmoke;
  }

  table.dataTable.hover tbody tr:hover.selected,
  table.dataTable.display tbody tr:hover.selected {
    background-color: #edbbf5;
  }

  table.dataTable.order-column tbody tr>.sorting_1,
  table.dataTable.order-column tbody tr>.sorting_2,
  table.dataTable.order-column tbody tr>.sorting_3,
  table.dataTable.display tbody tr>.sorting_1,
  table.dataTable.display tbody tr>.sorting_2,
  table.dataTable.display tbody tr>.sorting_3 {
    background-color: #f9f9f9;
  }

  table.dataTable.order-column tbody tr.selected>.sorting_1,
  table.dataTable.order-column tbody tr.selected>.sorting_2,
  table.dataTable.order-column tbody tr.selected>.sorting_3,
  table.dataTable.display tbody tr.selected>.sorting_1,
  table.dataTable.display tbody tr.selected>.sorting_2,
  table.dataTable.display tbody tr.selected>.sorting_3 {
    background-color: #f1bef9;
  }

  table.dataTable.display tbody tr.odd>.sorting_1,
  table.dataTable.order-column.stripe tbody tr.odd>.sorting_1 {
    background-color: #f1f1f1;
  }

  table.dataTable.display tbody tr.odd>.sorting_2,
  table.dataTable.order-column.stripe tbody tr.odd>.sorting_2 {
    background-color: #f3f3f3;
  }

  table.dataTable.display tbody tr.odd>.sorting_3,
  table.dataTable.order-column.stripe tbody tr.odd>.sorting_3 {
    background-color: whitesmoke;
  }

  table.dataTable.display tbody tr.odd.selected>.sorting_1,
  table.dataTable.order-column.stripe tbody tr.odd.selected>.sorting_1 {
    background-color: #e8b7f1;
  }

  table.dataTable.display tbody tr.odd.selected>.sorting_2,
  table.dataTable.order-column.stripe tbody tr.odd.selected>.sorting_2 {
    background-color: #eab8f3;
  }

  table.dataTable.display tbody tr.odd.selected>.sorting_3,
  table.dataTable.order-column.stripe tbody tr.odd.selected>.sorting_3 {
    background-color: #ecbaf5;
  }

  table.dataTable.display tbody tr.even>.sorting_1,
  table.dataTable.order-column.stripe tbody tr.even>.sorting_1 {
    background-color: #f9f9f9;
  }

  table.dataTable.display tbody tr.even>.sorting_2,
  table.dataTable.order-column.stripe tbody tr.even>.sorting_2 {
    background-color: #fbfbfb;
  }

  table.dataTable.display tbody tr.even>.sorting_3,
  table.dataTable.order-column.stripe tbody tr.even>.sorting_3 {
    background-color: #fdfdfd;
  }

  table.dataTable.display tbody tr.even.selected>.sorting_1,
  table.dataTable.order-column.stripe tbody tr.even.selected>.sorting_1 {
    background-color: #f1bef9;
  }

  table.dataTable.display tbody tr.even.selected>.sorting_2,
  table.dataTable.order-column.stripe tbody tr.even.selected>.sorting_2 {
    background-color: #f3bffb;
  }

  table.dataTable.display tbody tr.even.selected>.sorting_3,
  table.dataTable.order-column.stripe tbody tr.even.selected>.sorting_3 {
    background-color: #f5c1fd;
  }

  table.dataTable.display tbody tr:hover>.sorting_1,
  table.dataTable.order-column.hover tbody tr:hover>.sorting_1 {
    background-color: #eaeaea;
  }

  table.dataTable.display tbody tr:hover>.sorting_2,
  table.dataTable.order-column.hover tbody tr:hover>.sorting_2 {
    background-color: #ebebeb;
  }

  table.dataTable.display tbody tr:hover>.sorting_3,
  table.dataTable.order-column.hover tbody tr:hover>.sorting_3 {
    background-color: #eeeeee;
  }

  table.dataTable.display tbody tr:hover.selected>.sorting_1,
  table.dataTable.order-column.hover tbody tr:hover.selected>.sorting_1 {
    background-color: #e1b2ea;
  }

  table.dataTable.display tbody tr:hover.selected>.sorting_2,
  table.dataTable.order-column.hover tbody tr:hover.selected>.sorting_2 {
    background-color: #e3b3eb;
  }

  table.dataTable.display tbody tr:hover.selected>.sorting_3,
  table.dataTable.order-column.hover tbody tr:hover.selected>.sorting_3 {
    background-color: #e6b5ee;
  }

  table.dataTable.no-footer {
    border-bottom: 1px none #111111;
  }

  table.dataTable.nowrap th,
  table.dataTable.nowrap td {
    white-space: nowrap;
  }

  table.dataTable.compact thead th,
  table.dataTable.compact thead td {
    padding: 4px 17px 4px 4px;
  }

  table.dataTable.compact tfoot th,
  table.dataTable.compact tfoot td {
    padding: 4px;
  }

  table.dataTable.compact tbody th,
  table.dataTable.compact tbody td {
    padding: 4px;
  }

  table.dataTable th.dt-left,
  table.dataTable td.dt-left {
    text-align: left;
  }

  table.dataTable th.dt-center,
  table.dataTable td.dt-center,
  table.dataTable td.dataTables_empty {
    text-align: center;
  }

  table.dataTable th.dt-right,
  table.dataTable td.dt-right {
    text-align: right;
  }

  table.dataTable th.dt-justify,
  table.dataTable td.dt-justify {
    text-align: justify;
  }

  table.dataTable th.dt-nowrap,
  table.dataTable td.dt-nowrap {
    white-space: nowrap;
  }

  table.dataTable thead th.dt-head-left,
  table.dataTable thead td.dt-head-left,
  table.dataTable tfoot th.dt-head-left,
  table.dataTable tfoot td.dt-head-left {
    text-align: left;
  }

  table.dataTable thead th.dt-head-center,
  table.dataTable thead td.dt-head-center,
  table.dataTable tfoot th.dt-head-center,
  table.dataTable tfoot td.dt-head-center {
    text-align: center;
  }

  table.dataTable thead th.dt-head-right,
  table.dataTable thead td.dt-head-right,
  table.dataTable tfoot th.dt-head-right,
  table.dataTable tfoot td.dt-head-right {
    text-align: right;
  }

  table.dataTable thead th.dt-head-justify,
  table.dataTable thead td.dt-head-justify,
  table.dataTable tfoot th.dt-head-justify,
  table.dataTable tfoot td.dt-head-justify {
    text-align: justify;
  }

  table.dataTable thead th.dt-head-nowrap,
  table.dataTable thead td.dt-head-nowrap,
  table.dataTable tfoot th.dt-head-nowrap,
  table.dataTable tfoot td.dt-head-nowrap {
    white-space: nowrap;
  }

  table.dataTable tbody th.dt-body-left,
  table.dataTable tbody td.dt-body-left {
    text-align: left;
  }

  table.dataTable tbody th.dt-body-center,
  table.dataTable tbody td.dt-body-center {
    text-align: center;
  }

  table.dataTable tbody th.dt-body-right,
  table.dataTable tbody td.dt-body-right {
    text-align: right;
  }

  table.dataTable tbody th.dt-body-justify,
  table.dataTable tbody td.dt-body-justify {
    text-align: justify;
  }

  table.dataTable tbody th.dt-body-nowrap,
  table.dataTable tbody td.dt-body-nowrap {
    white-space: nowrap;
  }

  table.dataTable,
  table.dataTable th,
  table.dataTable td {
    -webkit-box-sizing: content-box;
    box-sizing: content-box;
  }

  /*
 * Control feature layout
 */
  .dataTables_wrapper {
    position: relative;
    clear: both;
    *zoom: 1;
    zoom: 1;
  }

  .dataTables_wrapper .dataTables_length {
    float: left;
  }

  .dataTables_wrapper .dataTables_filter {
    float: right;
    text-align: right;
  }

  .dataTables_wrapper .dataTables_filter input {
    margin-left: 0.5em;
    border-radius: .5em;
    border: 1px solid #cccccc;
    background: #f1f1f1;
  }

  .dataTables_wrapper .dataTables_info {
    clear: both;
    float: left;
    padding-top: 0.755em;
  }

  .dataTables_wrapper .dataTables_paginate {
    float: right;
    text-align: right;
    padding-top: 0.25em;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button {
    box-sizing: border-box;
    display: inline-block;
    min-width: 1.5em;
    padding: 0.5em 1em;
    margin-left: 2px;
    text-align: center;
    text-decoration: none !important;
    cursor: pointer;
    *cursor: hand;
    color: #333333 !important;
    border: 1px solid transparent;
    border-radius: 2px;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button.current,
  .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: #333333 !important;
    border: 1px solid #878787;
    background-color: white;
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, white), color-stop(100%, #cccccc));
    /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top, white 0%, #cccccc 100%);
    /* Chrome10+,Safari5.1+ */
    background: -moz-linear-gradient(top, white 0%, #cccccc 100%);
    /* FF3.6+ */
    background: -ms-linear-gradient(top, white 0%, #cccccc 100%);
    /* IE10+ */
    background: -o-linear-gradient(top, white 0%, #cccccc 100%);
    /* Opera 11.10+ */
    background: linear-gradient(to bottom, white 0%, #cccccc 100%);
    /* W3C */
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
  .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
  .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
    cursor: default;
    color: #666 !important;
    border: 1px solid transparent;
    background: transparent;
    box-shadow: none;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: white !important;
    border: 1px solid #222222;
    background-color: dimgray;
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, dimgray), color-stop(100%, #222222));
    /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top, dimgray 0%, #222222 100%);
    /* Chrome10+,Safari5.1+ */
    background: -moz-linear-gradient(top, dimgray 0%, #222222 100%);
    /* FF3.6+ */
    background: -ms-linear-gradient(top, dimgray 0%, #222222 100%);
    /* IE10+ */
    background: -o-linear-gradient(top, dimgray 0%, #222222 100%);
    /* Opera 11.10+ */
    background: linear-gradient(to bottom, dimgray 0%, #222222 100%);
    /* W3C */
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button:active {
    outline: none;
    background-color: #3c3c3c;
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #3c3c3c), color-stop(100%, #1d1d1d));
    /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top, #3c3c3c 0%, #1d1d1d 100%);
    /* Chrome10+,Safari5.1+ */
    background: -moz-linear-gradient(top, #3c3c3c 0%, #1d1d1d 100%);
    /* FF3.6+ */
    background: -ms-linear-gradient(top, #3c3c3c 0%, #1d1d1d 100%);
    /* IE10+ */
    background: -o-linear-gradient(top, #3c3c3c 0%, #1d1d1d 100%);
    /* Opera 11.10+ */
    background: linear-gradient(to bottom, #3c3c3c 0%, #1d1d1d 100%);
    /* W3C */
    box-shadow: inset 0 0 3px #111;
  }

  .dataTables_wrapper .dataTables_paginate .ellipsis {
    padding: 0 1em;
  }

  .dataTables_wrapper .dataTables_processing {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 40px;
    margin-left: -50%;
    margin-top: -25px;
    padding-top: 20px;
    text-align: center;
    font-size: 1.2em;
    background-color: white;
    background: -webkit-gradient(linear, left top, right top, color-stop(0%, rgba(255, 255, 255, 0)), color-stop(25%, rgba(255, 255, 255, 0.9)), color-stop(75%, rgba(255, 255, 255, 0.9)), color-stop(100%, rgba(255, 255, 255, 0)));
    background: -webkit-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
    background: -moz-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
    background: -ms-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
    background: -o-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
    background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
  }

  .dataTables_wrapper .dataTables_length,
  .dataTables_wrapper .dataTables_filter,
  .dataTables_wrapper .dataTables_info,
  .dataTables_wrapper .dataTables_processing,
  .dataTables_wrapper .dataTables_paginate {
    color: #333333;
  }

  .dataTables_wrapper .dataTables_scroll {
    clear: both;
  }

  .dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody {
    *margin-top: -1px;
    -webkit-overflow-scrolling: touch;
  }

  .dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody th,
  .dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody td {
    vertical-align: middle;
  }

  .dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody th>div.dataTables_sizing,
  .dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody td>div.dataTables_sizing {
    height: 0;
    overflow: hidden;
    margin: 0 !important;
    padding: 0 !important;
  }

  .dataTables_wrapper.no-footer .dataTables_scrollBody {
    border-bottom: 1px none #111111;
  }

  .dataTables_wrapper.no-footer div.dataTables_scrollHead table,
  .dataTables_wrapper.no-footer div.dataTables_scrollBody table {
    border-bottom: none;
  }

  .dataTables_wrapper:after {
    visibility: hidden;
    display: block;
    content: "";
    clear: both;
    height: 0;
  }

  @media screen and (max-width: 767px) {

    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
      float: none;
      text-align: center;
    }

    .dataTables_wrapper .dataTables_paginate {
      margin-top: 0.5em;
    }
  }

  @media screen and (max-width: 640px) {

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
      float: none;
      text-align: center;
    }

    .dataTables_wrapper .dataTables_filter {
      margin-top: 0.5em;
    }
  }

  /* START Modals ------------------------------*/
  [data-ml-modal] {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    overflow-x: hidden;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
    z-index: 999;
    width: 0;
    height: 0;
    opacity: 0;
  }

  [data-ml-modal]:target {
    width: auto;
    height: auto;
    opacity: 1;
    -webkit-transition: opacity 1s ease;
    transition: opacity 1s ease;
  }

  [data-ml-modal]:target .modal-overlay {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    cursor: pointer;
    background-color: #000;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 1;
  }

  [data-ml-modal] .modal-dialog {
    border-radius: 6px;
    box-shadow: 0 11px 15px -7px rgba(0, 0, 0, 0.2), 0 24px 38px 3px rgba(0, 0, 0, 0.14), 0 9px 46px 8px rgba(0, 0, 0, 0.12);
    position: relative;
    overflow-x: hidden;
    overflow-y: auto;
    z-index: 2;
  }

  .modal-dialog-lg {
    width: 100% !important;
    height: 100% !important;
  }

  [data-ml-modal] .modal-dialog>h3 {
    background-color: #eee;
    border-bottom: 1px solid #b3b3b3;
    font-size: 24px;
    font-weight: 400;
    margin: 0;
    padding: 0.8em 56px .8em 27px;
  }

  [data-ml-modal] .modal-content {
    background: #fff;
    padding: 23px 27px;
  }

  [data-ml-modal] .modal-close {
    position: absolute;
    top: 13px;
    right: 13px;
    color: #0085a6;
    background-color: #fff;
    border-radius: 50%;
    height: 40px;
    width: 40px;
    font-size: 30px;
    line-height: 37px;
    text-align: center;
    -webkit-transition: all .3s ease-in-out;
    transition: all .3s ease-in-out;
  }

  [data-ml-modal] .modal-close:hover {
    background-color: #0085a6;
    color: #fff;
    cursor: pointer;
  }

  [data-ml-modal] p:first-child,
  [data-ml-modal] p:last-child {
    margin: 0;
  }

  @media (max-width:767px) {
    [data-ml-modal] .modal-dialog {
      margin: 20% auto;
    }
  }

  /* End Modals ------------------------------*/
</style>
<main id="main">
  <!-- modal salur -->
  @foreach($targetnya as $target)
  <div data-ml-modal id="modal-salur{{$target->id}}">
    <a href="#!" class="modal-overlay"></a>
    <div class="modal-dialog modal-dialog-lg">
      <a href="#!" class="modal-close">&times;</a>
      <h3>Target Penyaluran {{$target->komoditas->nama ?? "Belum Ada Komoditas"}} - {{$target->varietas->nama_varietas ?? "Belum Ada Varietas"}} {{$target->tahun}}</h3>
      <div class="modal-content newspaper">
        <div style="overflow-x:auto;">
          <table id="table2">
            <thead class="garis text-center">
              <tr>
                <td class="garis text-center">Rencana Tanggal Penyaluran</td>
                <td class="garis text-center">Keterangan</td>
                <td class="garis text-center">Jumlah</td>
              </tr>
            </thead>
            <tbody>
              @foreach($target->targetsalur as $sal)
              <tr>
                <td class="garis text-center">{{$sal->tanggal_salur}}</td>
                <td class="garis text-center">{{$sal->keterangan}}</td>
                <td class="garis text-center">{{$sal->jumlah}} {{$target->satuan->nama_satuan}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div data-ml-modal id="sebaran{{$lembaga->id}}">
    <a href="#!" class="modal-overlay"></a>
    <div class="modal-dialog modal-dialog-lg" style="margin-top: 0px;margin-bottom: 0px;">
      <a href="#!" class="modal-close">&times;</a>
      <h3>Laporan Proses Perbanyakan {{$lembaga->nama_lembaga}} {{$target->tahun}}</h3>
      <div class="modal-content newspaper">
        <div style="overflow-x:auto;">
          <iframe src="{{url('/peta-salur/')}}/{{$lembaga->id}}" style="width:100%;height:1080px"></iframe>
        </div>
      </div>
    </div>
  </div>
  <div data-ml-modal id="modal-banyakhasil{{$target->id}}">
    <a href="#!" class="modal-overlay"></a>
    <div class="modal-dialog modal-dialog-lg">
      <a href="#!" class="modal-close">&times;</a>
      <h3>Laporan Proses Perbanyakan {{$target->komoditas->nama ?? "Belum Ada Komoditas"}} - {{$target->varietas->nama_varietas ?? "Belum Ada Varietas"}} {{$target->tahun}}</h3>
      <div class="modal-content newspaper">
        <div style="overflow-x:auto;">
          <table id="table2">
            <thead class="garis text-center">
              <tr>
                <td class="garis text-center">Tanggal Lapor</td>
                <td class="garis text-center">Keterangan</td>
                <td class="garis text-center">Foto</td>
                <td class="garis text-center">Jumlah</td>
              </tr>
            </thead>
            <tbody>
              @foreach($target->produksi as $banyakhasil)
              <tr>
                <td class="garis text-center">{{$banyakhasil->tanggal_lapor}}</td>
                <td class="garis text-center">{{$banyakhasil->keterangan}}</td>
                <td class="garis text-center"><img src="{{ url('/storage/'.$banyakhasil->upload) }}" alt=""></td>
                <td class="garis text-center">{{$banyakhasil->pengadaan_benih}} {{$target->satuan->nama_satuan}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div data-ml-modal id="modal-banyakgagal{{$target->id}}">
    <a href="#!" class="modal-overlay"></a>
    <div class="modal-dialog modal-dialog-lg">
      <a href="#!" class="modal-close">&times;</a>
      <h3>Laporan Proses Perbanyakan Gagal {{$target->komoditas->nama ?? "Belum Ada Komoditas"}} - {{$target->varietas->nama_varietas ?? "Belum Ada Varietas"}} {{$target->tahun}}</h3>
      <div class="modal-content newspaper">
        <div style="overflow-x:auto;">
          <table id="table2">
            <thead class="garis text-center">
              <tr>
                <td class="garis text-center">Tanggal Lapor</td>
                <td class="garis text-center">Keterangan</td>
                <td class="garis text-center">Foto</td>
                <td class="garis text-center">Jumlah</td>
              </tr>
            </thead>
            <tbody>
              @foreach($target->produksimati as $banyakgagal)
              <tr>
                <td class="garis text-center">{{$banyakgagal->tanggal_lapor}}</td>
                <td class="garis text-center">{{$banyakgagal->keterangan}}</td>
                <td class="garis text-center"><img src="{{ url('/storage/'.$banyakgagal->upload) }}" alt=""></td>
                <td class="garis text-center">{{$banyakgagal->produksi_mati}} {{$target->satuan->nama_satuan}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div data-ml-modal id="modal-ptmhasil{{$target->id}}">
    <a href="#!" class="modal-overlay"></a>
    <div class="modal-dialog modal-dialog-lg">
      <a href="#!" class="modal-close">&times;</a>
      <h3>Laporan Benih Mencapai PTM {{$target->komoditas->nama ?? "Belum Ada Komoditas"}} - {{$target->varietas->nama_varietas ?? "Belum Ada Varietas"}} {{$target->tahun}}</h3>
      <div class="modal-content newspaper">
        <div style="overflow-x:auto;">
          <table id="table2">
            <thead class="garis text-center">
              <tr>
                <td class="garis text-center">Tanggal Lapor</td>
                <td class="garis text-center">Keterangan</td>
                <td class="garis text-center">Foto</td>
                <td class="garis text-center">Jumlah</td>
              </tr>
            </thead>
            <tbody>
              @foreach($target->ptm as $ptmhasil)
              <tr>
                <td class="garis text-center">{{$ptmhasil->tanggal_panen}}</td>
                <td class="garis text-center">{{$ptmhasil->keterangan}}</td>
                <td class="garis text-center"><img src="{{ url('/storage/'.$ptmhasil->upload) }}" alt=""></td>
                <td class="garis text-center">{{$ptmhasil->jum_panen}} {{$target->satuan->nama_satuan}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div data-ml-modal id="modal-ptmgagal{{$target->id}}">
    <a href="#!" class="modal-overlay"></a>
    <div class="modal-dialog modal-dialog-lg">
      <a href="#!" class="modal-close">&times;</a>
      <h3>Laporan Benih Gagal Setelah Mencapai PTM {{$target->komoditas->nama ?? "Belum Ada Komoditas"}} - {{$target->varietas->nama_varietas ?? "Belum Ada Varietas"}} {{$target->tahun}}</h3>
      <div class="modal-content newspaper">
        <div style="overflow-x:auto;">
          <table id="table2">
            <thead class="garis text-center">
              <tr>
                <td class="garis text-center">Tanggal Lapor</td>
                <td class="garis text-center">Keterangan</td>
                <td class="garis text-center">Foto</td>
                <td class="garis text-center">Jumlah</td>
              </tr>
            </thead>
            <tbody>
              @foreach($target->ptmmati as $ptmgagal)
              <tr>
                <td class="garis text-center">{{$ptmgagal->tanggal_lapor}}</td>
                <td class="garis text-center">{{$ptmgagal->keterangan}}</td>
                <td class="garis text-center"><img src="{{ url('/storage/'.$ptmgagal->upload) }}" alt=""></td>
                <td class="garis text-center">{{$ptmgagal->label_mati}} {{$target->satuan->nama_satuan}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @php
  $jumlah1 = DB::table('target_benih')
  ->join('lap_benih_panen','lap_benih_panen.target_benih_id','target_benih.id')
  ->join('lap_benih_label','lap_benih_label.lap_benih_panen_id','lap_benih_panen.id')
  ->where('target_benih.id',$target->id)
  ->select(DB::raw(
  'lap_benih_label.tanggal_lapor as tgllpr,
  lap_benih_label.jumlah_lanjut as jumlah_lanjut,
  lap_benih_label.jumlah_gagal as jumlah_gagal,
  lap_benih_label.jumlah_tunda as jumlah_tunda,
  lap_benih_label.keterangan as ket,
  lap_benih_label.upload as upload
  '
  ))
  ->get();
  @endphp
  <div data-ml-modal id="modal-labelhasil{{$target->id}}">
    <a href="#!" class="modal-overlay"></a>
    <div class="modal-dialog modal-dialog-lg">
      <a href="#!" class="modal-close">&times;</a>
      <h3>Laporan Label Benih {{$target->komoditas->nama ?? "Belum Ada Komoditas"}} - {{$target->varietas->nama_varietas ?? "Belum Ada Varietas"}} {{$target->tahun}}</h3>
      <div class="modal-content newspaper">
        <div style="overflow-x:auto;">
          <table id="table2">
            <thead class="garis text-center">
              <tr>
                <td class="garis text-center">Tanggal Lapor</td>
                <td class="garis text-center">Jumlah yang Berlabel</td>
                <td class="garis text-center">Jumlah Tidak dapat Dilabel</td>
                <td class="garis text-center">Jumlah yang dapat Diuji Ulang</td>
                <td class="garis text-center">Keterangan</td>
                <td class="garis text-center">Foto</td>
              </tr>
            </thead>
            <tbody>
              @foreach($jumlah1 as $label1)
              <tr>
                <td class="garis text-center">{{$label1->tgllpr}}</td>
                <td class="garis text-center">{{$label1->jumlah_lanjut}} {{$target->satuan->nama_satuan}}</td>
                <td class="garis text-center">{{$label1->jumlah_gagal}} {{$target->satuan->nama_satuan}}</td>
                <td class="garis text-center">{{$label1->jumlah_tunda}} {{$target->satuan->nama_satuan}}</td>
                <td class="garis text-center">{{$label1->ket}}</td>
                <td class="garis text-center"><img src="{{ url('/storage/'.$label1->upload) }}" alt=""></td>

              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div data-ml-modal id="modal-labelgagal{{$target->id}}">
    <a href="#!" class="modal-overlay"></a>
    <div class="modal-dialog modal-dialog-lg">
      <a href="#!" class="modal-close">&times;</a>
      <h3>Laporan Pengurangan Label Benih {{$target->komoditas->nama ?? "Belum Ada Komoditas"}} - {{$target->varietas->nama_varietas ?? "Belum Ada Varietas"}} {{$target->tahun}}</h3>
      <div class="modal-content newspaper">
        <div style="overflow-x:auto;">
          <table id="table2">
            <thead class="garis text-center">
              <tr>
                <td class="garis text-center">Tanggal Lapor</td>
                <td class="garis text-center">Jumlah</td>
                <td class="garis text-center">Solusi</td>
                <td class="garis text-center">Keterangan</td>
                <td class="garis text-center">Foto</td>
              </tr>
            </thead>
            <tbody>
              @foreach($target->penguranganstok as $kurang)
              <tr>
                <td class="garis text-center">{{$kurang->tanggal_lapor}}</td>
                <td class="garis text-center">{{$kurang->jumlah}} {{$target->satuan->nama_satuan}}</td>
                <td class="garis text-center">{{$kurang->solusi}}</td>
                <td class="garis text-center">{{$kurang->keterangan}}</td>
                <td class="garis text-center"><img src="{{ url('storage/'.$kurang->upload_foto) }}" alt=""></td>

              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div data-ml-modal id="modal-tersalur{{$target->id}}">
    <a href="#!" class="modal-overlay"></a>
    <div class="modal-dialog modal-dialog-lg">
      <a href="#!" class="modal-close">&times;</a>
      <h3>Laporan Penyaluran Benih {{$target->komoditas->nama ?? "Belum Ada Komoditas"}} - {{$target->varietas->nama_varietas  ?? "Belum Ada Varietas"}} {{$target->tahun}}</h3>
      <div class="modal-content newspaper">
        <div style="overflow-x:auto;">
          <table id="table2">
            <thead class="garis text-center">
              <tr>
                <td class="garis text-center">Tanggal Lapor</td>
                <td class="garis text-center">Penerima</td>
                <td class="garis text-center">Jumlah</td>
                <td class="garis text-center">Keperluan</td>
                <td class="garis text-center">Foto</td>
              </tr>
            </thead>
            <tbody>
              @foreach($target->penyaluranstok as $saluran)
              <tr>
                <td class="garis text-center">{{$saluran->tanggal_lapor}}</td>
                <td class="garis text-center">{{$saluran->nama_penerima}}, {{$saluran->alamat}}, {{$saluran->provinces->name}}, {{$saluran->regencies->name}}, {{$saluran->districts->name}}, {{$saluran->villages->name}}</td>
                <td class="garis text-center">{{$saluran->jumlah}} {{$target->satuan->nama_satuan}}</td>
                <td class="garis text-center">{{$saluran->keperluan}}</td>
                <td class="garis text-center"><img src="{{ url('/storage/'.$saluran->upload_foto) }}" alt=""></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @endforeach
  <!-- produksi non -->
  @foreach($produksinon as $pronon)
  <div data-ml-modal id="modal-swadaya{{$pronon->id}}">
    <a href="#!" class="modal-overlay"></a>
    <div class="modal-dialog modal-dialog-lg">
      <a href="#!" class="modal-close">&times;</a>
      <h3>Laporan Produksi Non APBN {{$pronon->komoditas->nama ?? "Belum Ada Komoditas"}} - {{$pronon->varietas->nama_varietas ?? "Belum Ada Varietas"}}</h3>
      <div class="modal-content newspaper">
        <div style="overflow-x:auto;">
          <table id="table2">
            <thead class="garis text-center">
              <tr>
                <td class="garis text-center">Tanggal Lapor</td>
                <td class="garis text-center">Jumlah Produksi</td>
                <td class="garis text-center">Jumlah Penyaluran</td>
                <td class="garis text-center">Ketersediaan Stok</td>
              </tr>
            </thead>
            <tbody>
              @foreach($pronon->childproduksiswadaya as $produksi)
              <tr>
                <td class="garis text-center">{{$produksi->tanggal_lapor}}</td>
                <td class="garis text-center">{{$produksi->produksi_benih}} {{$pronon->satuan->nama_satuan}}</td>
                <td class="garis text-center">{{$produksi->salur_benih}} {{$pronon->satuan->nama_satuan}}</td>
                <td class="garis text-center">{{$produksi->produksi_benih-$produksi->salur_benih}} {{$pronon->satuan->nama_satuan}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @endforeach
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
  <!--====== COUNTER PART START ======-->

  <div id="counter-part" class="bg_cover pt-65 pb-110" data-overlay="8" style="background-image: url('{{ asset('frontend/images/bg-2.jpg') }}')">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-sm-12">
          <div class="singel-counter text-center mt-40">
            <span>Detail Produsen/Pengedar</span>
          </div> <!-- singel counter -->
        </div>
      </div> <!-- row -->
    </div> <!-- container -->
  </div>

  <!--====== COUNTER PART ENDS ======-->
  <section class="artist-info">
    <div class="container">

      <!-- ======= About Section ======= -->
      <section id="about" class="about">
        <div class="container">
          <div class="section-title">
            <h2>{{$lembaga->nama_lembaga}}</h2>
          </div>
          <div class="row content">
            <div class="col-md-6">
              <img src="{{ url('/storage/'.$lembaga->upload) }}" style="width:100%;height:400px">
            </div>
            <div class="col-md-6">
              <p>Alamat : {{$lembaga->alamat}}, {{$lembaga->provinces->name}}, {{$lembaga->regencies->name}}, {{$lembaga->districts->name}}, {{$lembaga->villages->name}}</p>
              <p>Kepala : {{$lembaga->nama_kepala}}</p>
              <p>No. Telp : {{$lembaga->no_telp}}</p>
              <p><a href="http://www.google.com/maps/place/{{$lembaga->latitude}},{{$lembaga->longitude}}" target="_blank">Lihat Pada Googlemap</a></p>
            </div>
            <div class="col-md-12">
                <div class="table-container table-responsive table-striped display">
                    <h3 class="text-center">SERTIFIKAT KOMPETENSI PRODUSEN BENIH</h3>
                    <table id="table1">
                    <thead class="garis text-center">
                    <tr>
                      <th class="garis text-center">NOMOR SERTIFIKAT KOMPETENSI</th>
                      <th class="garis text-center">JENIS KOMPETENSI</th>
                      <th class="garis text-center">TANGGAL PENETAPAN SERTIFIKAT KOMPETENSI AWAL</th>
                      <th class="garis text-center">BERLAKU HINGGA</th>
                      <th class="garis text-center">PERPANJANGAN</th>
                      <th class="garis text-center">STATUS</th>
                    </tr>
                  </thead>
                  <tbody class="garis text-center">
                    @foreach($serkom as $ser)
                    @if(isset($ser->produsenbenih))
                 <tr>
                    <td class="garis text-center">{{$ser->no_serti}}</td>
                    @php
                    $col = collect($ser->jenis_kompetensi);
                    $array = $col->toArray();
                    $string = implode(', ', $array);
                    @endphp
                    <td class="garis text-center">{{$string ?? 'Kesalahan dalam Pengisian Data'}}</td>
                    <td class="garis text-center">{{$ser->tgl_awal}}</td>
                    <td class="garis text-center">@php
                    $tgl_akhir = $ser->tgl_akhir;
                    $panjang =  $ser->perpanjangansmm->where('child_smm_id',$ser->id)->sortByDesc('tgl_perpanjangan')->first();
                    if($panjang){
                    $tglakhirp = $panjang->tgl_berlaku;
                    
                        echo $tglakhirp;
                    }else{
                        echo $tgl_akhir;
                    }
                        @endphp
                    </td>
                    <td class="garis text-center">{{$ser->perpanjangansmm->count() }}</td>
                    <td class="garis text-center">
                    @php
                    $now = date("Y-m-d");
                    $tgl_akhir = $ser->tgl_akhir;
                    $panjang =  $ser->perpanjangansmm->where('child_smm_id',$ser->id)->sortByDesc('tgl_perpanjangan')->first();
                    if($panjang){
                    $tglakhirp = $panjang->tgl_berlaku;
                    if($now>$tglakhirp){
                        echo "Tidak Berlaku";
                    }else{
                        echo "Berlaku";
                    }
                    }else{
                        if($now>$tgl_akhir){
                            echo "Tidak Berlaku" ;
                        }else{
                            echo "Berlaku";
                        }
                    }
                    @endphp

                    </td>
                 </tr>
                 @endif
                 @endforeach
                  </tbody>
                    </table>
                    <div style="">
                    <!-- pagination -->
                    </div>
                </div>
            </div>
            @if($lembaga->jenis_produsen_id==4)
            <div class="col-md-12">
              <div class="table-container table-responsive table-striped display">
                <h3 class="text-center">Lokasi Produksi Benih</h3>
                <table id="table1">
                  <thead class="garis text-center">
                    <tr>
                      <td class="garis text-center">Alamat</td>
                      <td class="garis text-center">Luas Lokasi Produksi</td>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($lembaga->lokasiproduksidetail as $lok)
                    <tr>
                      <td class="garis text-center">{{$lok->alamat}}</td>
                      <td class="garis text-center">{{$lok->luas}} ha</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-container table-responsive table-striped display">
                <h3 class="text-center">Lokasi Penyimpanan Benih</h3>
                <table id="table2">
                  <thead class="garis text-center">
                    <tr>
                      <td class="garis text-center">Alamat</td>
                      <td class="garis text-center">Kapasitas Penyimpanan</td>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($lembaga->lokasigudangdetail as $gud)
                    <tr>
                      <td class="garis text-center">{{$gud->alamat}}</td>
                      <td class="garis text-center">{{$gud->kapasitas}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
                   
                  <div class="col-md-12">
                    
              <div class="table-container table-responsive table-striped display">
                <h3 class="text-center">Peta Penyaluran Benih</h3>
                <div class="col-md-12 text-center">
              <a href="#sebaran{{$lembaga->id}}"><button class="btn btn-success">Lihat Peta Penyaluran</button></a>
                  </div>
              </div>
                  </div> <!-- about cont -->
                  
            <div class="col-md-12">
              <div class="table-container table-responsive table-striped display">
                <h3 class="text-center">Produksi APBN</h3>
                <table id="table3">
                  <thead class="garis text-center">
                    <tr>
                      <th class="garis text-center" rowspan="2">TAHUN TARGET PRODUKSI</th>
                      <th class="garis text-center" rowspan="2">LOKASI PRODUKSI</th>
                      <th class="garis text-center" rowspan="2">TARGET PRODUKSI KOMODITAS (SATUAN)</th>
                      <th class="garis text-center" rowspan="2">TARGET SALUR KOMODITAS (SATUAN)</th>
                      <th class="garis text-center" colspan="4">PROSES PERBANYAKAN</th>
                      <th class="garis text-center" colspan="4">MENCAPAI PTM</th>
                      <th class="garis text-center" colspan="4">SIAP SALUR</th>
                      <th class="garis text-center" rowspan="2">TERSALUR</th>
                      <th class="garis text-center" rowspan="2">KINERJA PENYALURAN</th>
                      <th class="garis text-center" rowspan="2">SISA STOK</th>
                      <th class="garis text-center" rowspan="2">STATUS</th>
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
                    @php
                    $jumlah = DB::table('target_benih')
                    ->join('lap_benih_panen','lap_benih_panen.target_benih_id','target_benih.id')
                    ->join('lap_benih_label','lap_benih_label.lap_benih_panen_id','lap_benih_panen.id')
                    ->where('target_benih.id',$target->id)
                    ->sum('jumlah_lanjut');
                    @endphp
                    <!--Lokasi Produksi-->
                    <td class="garis text-center">{{$target->tahun}}</td>
                    <td class="garis text-center">{{$target->lokasiproduksidetail->alamat}}</td>
                    <td class="garis text-center">{{$target->komoditas->nama ?? "Belum Ada Komoditas"}} - {{$target->varietas->nama_varietas ?? "Belum Ada Varietas"}}<br>{{number_format($target->jum_target,0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <td class="garis text-center"><a href="#modal-salur{{$target->id}}">{{$target->komoditas->nama}} - {{$target->varietas->nama_varietas ?? "Belum Ada Varietas"}}<br>{{number_format($target->targetsalur->sum('jumlah'),0,",",".")}} {{$target->satuan->nama_satuan}}</a></td>
                    <!--Proses Perbanyakan Berhasil-->
                    <td class="garis text-center"><a href="#modal-banyakhasil{{$target->id}}">{{number_format(($target->produksi->sum('pengadaan_benih')-$target->produksimati->sum('produksi_mati')),0,",",".")}} {{$target->satuan->nama_satuan}}</a></td>

                    <!--Proses Perbanyakan Gagal-->
                    <td class="garis text-center"><a href="#modal-banyakgagal{{$target->id}}">{{number_format($target->produksimati->sum('produksi_mati'),0,",",".")}} {{$target->satuan->nama_satuan}}</a></td>
                    <!-- bELUM PROSES -->
                    <td class="garis text-center">{{number_format(($target->jum_target-$target->produksi->sum('pengadaan_benih')+$target->produksimati->sum('produksi_mati')),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    
                    <!--Kinerja Perbanyakan-->
                    <td class="garis text-center">{{number_format((($target->produksi->sum('pengadaan_benih')-$target->produksimati->sum('produksi_mati'))*100/$target->jum_target),0,",",".")."%"}}</td>
                    <!--PTM Berhasil-->
                    <td class="garis text-center"><a href="#modal-ptmhasil{{$target->id}}">{{number_format(($target->ptm->sum('jum_panen')-$target->ptmmati->sum('label_mati')),0,",",".")}} {{$target->satuan->nama_satuan}}</a></td>
                    <!--PTM Gagal-->
                    <td class="garis text-center"><a href="#modal-ptmgagal{{$target->id}}">{{number_format($target->ptmmati->sum('label_mati'),0,",",".")}} {{$target->satuan->nama_satuan}}</a></td>
                    <!-- BELUM PTM -->
                    <td class="garis text-center">{{number_format(($target->produksi->sum('pengadaan_benih')-$target->produksimati->sum('produksi_mati')-$target->ptm->sum('jum_panen')+$target->ptmmati->sum('label_mati')))}} {{$target->satuan->nama_satuan}}</td>
                    <!--Proses Kinerja PTM-->
                    <td class="garis text-center">{{number_format((($target->ptm->sum('jum_panen')-$target->ptmmati->sum('label_mati'))*100/$target->jum_target),0,",",".")."%"}}</td>
                    <!--Siap Salur Berlabel-->
                    <td class="garis text-center"><a href="#modal-labelhasil{{$target->id}}">{{number_format(($jumlah-$target->penguranganstok->sum('jumlah')),0,",",".")}} {{$target->satuan->nama_satuan}}</a></td>
                    <!--Siap Salur Mati Berlabel-->
                    <td class="garis text-center"><a href="#modal-labelgagal{{$target->id}}">{{number_format($target->penguranganstok->sum('jumlah'),0,",",".")}} {{$target->satuan->nama_satuan}}</a></td>
                    <!--Siap Salur belum Berlabel-->
                    <td class="garis text-center">{{number_format(($target->ptm->sum('jum_panen')-$target->ptmmati->sum('label_mati')-$jumlah),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <!--Proses Kinerja Berlabel-->
                    <td class="garis text-center">{{number_format((($jumlah-$target->penguranganstok->sum('jumlah'))*100/$target->jum_target),0,",",".")."%"}}</td>
                    <!--tersalur-->
                    <td class="garis text-center"><a href="#modal-tersalur{{$target->id}}">{{number_format($target->penyaluranstok->sum('jumlah'),0,",",".")}} {{$target->satuan->nama_satuan}}</a></td>
                    <!--Kinerja tersalur-->
                    <td class="garis text-center">{{number_format((($target->penyaluranstok->sum('jumlah'))*100/$target->jum_target),0,",",".")."%"}}</td>
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
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <div style="">
                  {!! $targetnya->withQueryString()->links() !!}
                </div>
              </div>
            </div>
            
            @if($produksinon->count())
            
            <div class="col-md-12">
              <div class="table-container table-responsive table-striped display">
                <h3 class="text-center">Produksi Non APBN</h3>
                <table id="table3">
                  <thead class="garis text-center">
                    <tr>
                      <th class="garis text-center">KOMODITAS</th>
                      <th class="garis text-center">VARIETAS</th>
                      <th class="garis text-center">SATUAN</th>
                      <th class="garis text-center">SUMBER DANA</th>
                      <th class="garis text-center">JUMLAH PRODUKSI</th>
                      <th class="garis text-center">JUMLAH TERSALUR</th>
                      <th class="garis text-center">STOK</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach($produksinon as $pronon)
                    @php
                    $idToValue = [
                    "apbd" => "APBD",
                    "mandiri" => "Mandiri"
                    ];
                    $jsonArray1 = collect($pronon->sumber_dana);
                    $jsonArray = json_decode($jsonArray1);
                    if ($jsonArray !== null) {
                    foreach ($jsonArray as &$id) {
                    if (array_key_exists($id, $idToValue)) {
                    $id = $idToValue[$id];
                    }
                    }
                    }
                    $jsonResult = implode(", ", $jsonArray);
                    @endphp
                    <tr>
                      <!--Lokasi Produksi-->
                      <td class="garis text-center">{{$pronon->komoditas->nama}}</td>
                      <td class="garis text-center">{{$pronon->varietas->nama_varietas ?? "Belum Ada Varietas"}}</td>
                      <td class="garis text-center">{{$pronon->satuan->nama_satuan}}</td>
                      <td class="garis text-center">{{$jsonResult}}</td>
                      <td class="garis text-center">{{$pronon->childproduksiswadaya->sum('produksi_benih')}} {{$pronon->satuan->nama_satuan}}</td>
                      <td class="garis text-center">{{$pronon->childproduksiswadaya->sum('salur_benih')}} {{$pronon->satuan->nama_satuan}}</td>
                      <td class="garis text-center">{{($pronon->childproduksiswadaya->sum('produksi_benih')-$pronon->childproduksiswadaya->sum('salur_benih'))}} {{$pronon->satuan->nama_satuan}}</td>
                      <td class="garis text-center"><a href="#modal-swadaya{{$pronon->id}}">Detail</a></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <div style="">
                  {!! $produksinon->withQueryString()->links() !!}
                </div>
              </div>
            </div>
            @endif
            @endif
          </div>
      </section>
    </div>
    </div>
  </section>
  <script>
    $(document).ready(function() {
      $('#table1').DataTable({
        "responsive": true,
        "bPaginate": true,
        "bInfo": false,
        "lengthMenu": [5, 10, 20, 50, 100, 200, 500],
      });
    });
    $(document).ready(function() {
      $('#table2').DataTable({
        "responsive": true,
        "bPaginate": true,
        "bInfo": false,
        "lengthMenu": [5, 10, 20, 50, 100, 200, 500],
      });
    });
    $(document).ready(function() {
      $('#table3').DataTable({
        "responsive": true,
        "bPaginate": true,
        "bInfo": false,
        "lengthMenu": [5, 10, 20, 50, 100, 200, 500],
      });
    });
  </script>
  <!-- End About Section -->


</main><!-- End #main -->
@endsection