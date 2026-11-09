
<style>
td {
    border: 0px black solid;
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


@foreach($induk as $row)
<table cellpadding="0" cellspacing="0" style="width:100px">
    <tr>
        <td class='rotate'><img src="data:image/png;base64, {{ base64_encode(QrCode::format('svg')->size(500)->margin(0)->generate($url.'/detail-produsen/'.$row->idnya)) }} "></td>
        
    </tr>
    <tr><td style="text-align: center;"><h1>{{$row->namanya}}</h1><br><h2>{{$row->kodenya}}</h2></td></tr>
</table>
<br>
@endforeach

<script></script>