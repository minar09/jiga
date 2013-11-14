https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false

 var location = new google.maps.LatLng(     23.744522,     90.372828 );
 var options = {    zoom: 12,
					center: location, 
					mapTypeId: google.maps.MapTypeId.ROADMAP };
 var map = new google.maps.Map(     
								document.getElementById(‘map_canvas’),     
								options ); 