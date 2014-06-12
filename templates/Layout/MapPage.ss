<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<div id="Map" style="height:500px">
	
	</div>
	$Items
</div>
<script>
$(document).ready(function($) {
	if($("#Map").length != 0) {
		var MapHolder = $('#Map');
		
		Bounds = new Object();
		
		//var Markers = getMarkers()
		
		
		$('#Map').gmap3({
		  marker:{
			values:[
				{latLng:[parseFloat(MapHolder.attr('data-home-lat')), parseFloat(MapHolder.attr('data-home-lon'))], data:"Paris !"}
			]
		  },
		  map:{
			options:{
		        center: [43.461392,-79.680405],
		        zoom:10,
		        mapTypeId: google.maps.MapTypeId.ROADMAP,
		        mapTypeControlOptions: {
		           mapTypeIds: ["style1"]
		        },
		        navigationControl: true,
		        scrollwheel: false,
		        streetViewControl: true,
		      },
		      events: {
					idle: function(){
					
						var map = $(this).gmap3('get');
						var query;
						
						// first get the map bounds
						var map_bounds = map.getBounds();
						//check if first load
						if (!Bounds.hasOwnProperty("north")) {
							Bounds.north = map_bounds.getNorthEast().lat(); //bigger
							Bounds.south = map_bounds.getSouthWest().lat();
							Bounds.east =  map_bounds.getNorthEast().lng(); //bigger
							Bounds.west = map_bounds.getSouthWest().lng();
							query = "property/AjaxMapSearch/?north="+Bounds.north+"&south="+Bounds.south+"&east="+Bounds.east+"&west="+Bounds.west;
							

						} else {
							//check if the map bounds have exceeded existing values
							if (Bounds.north < map_bounds.getNorthEast().lat() ||  Bounds.south > map_bounds.getSouthWest().lat() || Bounds.east < map_bounds.getNorthEast().lng() || Bounds.west > map_bounds.getSouthWest().lng()) {
								
								query = "property/AjaxMapSearch/?north="+Bounds.north+"&south="+Bounds.south+"&east="+Bounds.east+"&west="+Bounds.west;
							} else {
								
							}
						}
						
						//alert(Bounds.north+','+Bounds.south+','+Bounds.east+','+Bounds.west);
						
						//if Query is set update map 
						/*
if(query) {
							//alert("Change");
							$('#AllListings').load(query, function(){
								PopulateMap('all');
								alert("loaded");
							});
							
						}
*/
						
					}
				}
		  }
		});
	}
});
</script>