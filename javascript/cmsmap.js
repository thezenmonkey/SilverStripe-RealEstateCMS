// Standard jQuery header
(function($) {  
	$(document).ready(function() {
		//Map System in Back End
		
		$("#ShowMap").live('click', function() {
		
			var position;
			var house = new google.maps.LatLng($("#StreetView").attr("data-lat"),$("#StreetView").attr("data-lon"));
			var panoramaOptions;
			if($("#Form_ItemEditForm_SVHeading").val() != '') {
				panoramaOptions = {
					position: house,
					pov: {
						heading: Math.round($("#Form_ItemEditForm_SVHeading").val()),
						pitch: Math.round($("#Form_ItemEditForm_SVPitch").val()),
						zoom: 1
					},
					visible: true
				};
			} else {
				panoramaOptions = {
					position: house,
					pov: {
					heading: 421,
					pitch: 0,
					zoom: 1
				},
				visible: true
			};
		}
			
			$("#StreetViewSet").show();
			
			position = $('#GoogleMap').attr("data-position");
			$('#GoogleMap').gmap({draggable: false, scrollwheel: false}).bind('init', function(ev, map) {
				$(this).gmap('addMarker', {'position': position, 'bounds':true });
				$(this).gmap('option', 'zoom', 17 );
			});
			
		    var panorama = new google.maps.StreetViewPanorama(document.getElementById("StreetView"), panoramaOptions);
			
			
			$("#StreetViewSet").click(function(event){
				event.preventDefault();
				var heading = panorama.getPov().heading;
				var pitch = panorama.getPov().pitch;
				var position = panorama.getPosition();
				
				$("#Form_ItemEditForm_Lat").val(position.lat());
				$("#Form_ItemEditForm_Lon").val(position.lng());
				$("#Form_ItemEditForm_SVHeading").val(heading);
				$("#Form_ItemEditForm_SVPitch").val(pitch);
				$("#Form_ItemEditForm_SVZoom").val(1);
			});
		});
	});

})(jQuery);


