<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<div id="Map" style="height:500px">
	
	</div>
</div>
<style>
	.cluster {background-color: rgba(0,0,0,0.3); padding:0.5em;}
</style>
<script>
$(document).ready(function($) {
	if($("#Map").length != 0) {
		var MapHolder = $('#Map');
		
		Bounds = new Object();
		var Listing =  [15];
		var MLSListing =  [521];
		//var Markers = getMarkers()
		
		
		$('#Map').gmap3({
		  map:{
			options:{
		        center: [43.461392,-79.680405],
		        zoom:12,
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
						if (
							!Bounds.hasOwnProperty("north") || 
							Bounds.north < map_bounds.getNorthEast().lat() ||
							Bounds.south > map_bounds.getSouthWest().lat() ||
							Bounds.east < map_bounds.getNorthEast().lng() || 
							Bounds.west > map_bounds.getSouthWest().lng()
						
						)  {
							Bounds.north = map_bounds.getNorthEast().lat(); //bigger
							Bounds.south = map_bounds.getSouthWest().lat();
							Bounds.east =  map_bounds.getNorthEast().lng(); //bigger
							Bounds.west = map_bounds.getSouthWest().lng();
							query = "RMSController/AjaxMapSearch/?type=bounds&north="+Bounds.north+"&south="+Bounds.south+"&east="+Bounds.east+"&west="+Bounds.west;
							if(query) {
								$.getJSON(query, function(data){
									PopulateMap(data);
								}).fail(function(){alert("No Listings in This View")});
							}
							
						}					
					}
				}
		  }
		});
	}
	
	function PopulateMap(markerdata) {
		var markers = new Array;
		var latLngs = [];
		//alert(markerdata);
		/*
var icons = mapIcons()
		if(options == 'all') {
			markers = MakeMarkers($("#AllListings"));
		} else {
			markers = MakeMarkers($("#FilteredListings"));
		}
*/

		
		//var allMarkers = mapIcons();
		
		markers = MakeMarkers(markerdata);
		
		
		$('#Map').gmap3({
			
			action: 'addMarkers',
			marker: {
				values: markers,
				events: {
	                click: function(marker, event, context) {
	                    listingQuery = "RMSController/AjaxListing/?class="+context.data+"&id="+context.id+"&return=json";
						$.getJSON(listingQuery, function(data){
							$('#Map').gmap3({
		                    	infowindow:{
			                    	anchor:marker, 
									options:{content: data.Title+' <a href="'+data.URLSegment+'">Read More</a>'}
		                    	}
	                    	});
						});
	                    
	                    /*
$( marker.data ).dialog({ width: 500, title: marker.title, open: function(event, ui){
		                    var imagSRC = $(this).find("[data-image]").attr("data-image");
		                    $(this).find("img").attr("src",imagSRC);
	                    } });
*/
	                }
	            },
	            cluster: {
		            radius: 40,
					0: {
						content: "<div class='cluster cluster-1'>CLUSTER_COUNT</div>",
						width: 36,
						height: 36
					},
					20: {
						content: "<div class='cluster cluster-2'>CLUSTER_COUNT</div>",
						width: 36,
						height: 36
					},
					50: {
						content: "<div class='cluster cluster-3'>CLUSTER_COUNT</div>",
						width: 36,
						height: 36
					},
					events: {
						click: function(cluster, event, data) {
							var map = $('#Map').gmap3("get");
							var newcenter = [cluster.main.getPosition().lat(), cluster.main.getPosition().lng()];
							
							map.setZoom(map.getZoom()+2);
							map.setCenter(cluster.main.getPosition());
						}
					}
	            }   
			}
			
		});
		
					
	}
	
	function MakeMarkers(list){
		var markers = new Array;
		var latLngs = [];
		for (var i in list) {
			var checkList = new Array();
			
			if(list[i].ClassName == "Listing") {
				checkList = Listing;
				if(CheckMarker(list[i], checkList)) {
					var gPos = new google.maps.LatLng(list[i].Lat, list[i].Lon);
					latLngs.push(gPos);
					markers.push({latLng:gPos, id:list[i].ID, data:list[i].ClassName});
				}
				
			} else if (list[i].ClassName == "MLSListing") {
				checkList = MLSListing;
				if(CheckMarker(list[i], checkList)) {
					var gPos = new google.maps.LatLng(list[i].Lat, list[i].Lon);
					latLngs.push(gPos);
					markers.push({latLng:gPos, id:list[i].ID, data:list[i].ClassName});
				}
			}
			
		}
		
		/*
var icons = searchIcons();
		$(list).find("[data-position]").each(function(){
			
			var position = $(this).attr("data-position");
			var pArray = position.split(",");
			var gPos = new google.maps.LatLng(pArray[0], pArray[1]);
			var thisIcon;
			if($(this).attr("data-type") == "Condo") {
				thisIcon = icons.Condo;
			} else {
				thisIcon = icons.House;
			}
			latLngs.push(gPos);
			if($(this).hasClass('listingItem')) {
				markers.push({latLng:position.split(","), options:{icon: thisIcon, title: $(this).attr("data-location"), data: $(this).attr("data-content")}});
			} else {
				
				var mls = $(this).attr('data-mls');
				var propType = $(this).attr('data-style');
				var price = $(this).find("[data-price]").attr("data-price");
				var beds = $(this).find("[data-bed]").attr("data-bed");
				var baths = $(this).find("[data-bath]").attr("data-bath");
				var pageLink = $(this).find("a.pagelink").attr("href");
				var content = $(this).find("[data-content]").attr("data-content");
				var src = $(this).find("[data-src]").attr("data-src");
				var popContent = $("<div></div>").addClass('twelve columns').append("<div class='six columns' data-image='"+src+"'><img src=''/></div><div class='six columns'><p>"+mls+"<br>"+propType+"<br>"+price+"<br>"+beds+" Bed(s) "+baths+" Bath(s)<br><a href='"+pageLink+"' class='button tiny secondary radius'>View More Details</a></p></div><div class='twelve columns'>"+content+"</div>");
				markers.push({latLng:position.split(","), options:{icon: thisIcon, title: $(this).attr("data-location"), data: popContent}});
			}
			
		}); */
		return markers;
	}
	
	function CheckMarker(item, list) {
		//alert(list);
		if($.inArray(item.ID, list) > -1  ) {
			return false;
			
		} else {
			if(item.ClassName == "Listing") {
				Listing.push(item.ID);
			} else if (item.ClassName == "MLSListing") {
				MLSListing.push(item.ID);
			}
			
			return true;
			
		}
	}
	
});
</script>