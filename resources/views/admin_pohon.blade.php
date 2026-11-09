<style>
    /* -- DEFAULTS -- */

div, ul, li{
  margin: 0;
  padding: 0;
  list-style-type: none;
}

/* -- FLUID GRID STYLES -- */

#Grid{
  margin-bottom: 20px;
  text-align: center;
  font-size: 0.1px;
}

#Grid li{
  display: inline-block;
  width: 50%;
  margin-bottom: 1%;
}

#Grid:after{
  content: '';
  display: inline-block;
  width: 100%;
}

#Grid .placeholder{
  padding: 0;
}

/* -- MEDIA QUERIES DEFINING RESPONSIVE LAYOUTS -- */

/* 3 COL */

@media (max-width: 800px){
  #Grid li{
    width: 33%;
    padding-top: 10%;
    margin-bottom: 3%;
  }
}

/* 2 COL */

@media (max-width: 600px){
  #Grid li{
    width: 48%;
    padding-top: 48%;
    margin-bottom: 4%;
  }
}

/* SINGLE COL */

@media (max-width: 400px){
  #Grid li{
    width: 100%;
    padding-top: 100%;
    margin-bottom: 5%;
  }
}
p{
  font: 200 10px "Helvetica Neue";
  max-width: 400px;
  margin-bottom: 10px;
  color: #333;
  text-align: center;
}
</style>
<ul id="Grid">
    
@foreach($reg as $row)
    <li>
    <img src="data:image/png;base64, {{ base64_encode(QrCode::format('svg')->size(160)->margin(0)->generate($url.'/detail-pohon/'.$row->idnyo)) }} ">
    <p>
    {{$induk->nama}}-{{$induk->nama_varietas}}<br>{{$induk->kelas_benih}}<br><b>{{$row->no_registrasi}}</b>
    </p>
    </li>
  @endforeach
    <br>
  </ul>