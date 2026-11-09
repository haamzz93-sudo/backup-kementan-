<style>
		.leaflet-container {
			max-width: 100%;
			max-height: 100%;
            margin-top: 25px;
		}
		#map { 
		    height: 600px;
			width: 100%;
			margin-top:25px;
		}
	</style>
	
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
     
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
     
    <div id="map"></div>
    
    <script>
        
        var map = L.map('map',{
            'center': [-0.789275, 113.921327 ],
            'zoom': 5,
			
      'layers': [
	  
          L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            		attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
        		})
              ]
              });
              this.setInterval(function () {
            map.invalidateSize();
        }, 100);
        addTo(map);
              $.getJSON('{{ asset("json/indonesia.json")}}',
              function (geojson) {
                  L.geoJson(geojson, {
                      onEachFeature: function (feature, layer) {
                          if(layer.feature.properties.ID )
                          {
                            layer.setStyle({
                                 weight: 0.5,
                                  opacity: 0.5,
                                  color: 'grey',  //Outline color
                                  fillOpacity: 3
                                  }) ;
                                  }
                                                              }})
                                                              .addTo(map);
                                                              });
        
    </script>