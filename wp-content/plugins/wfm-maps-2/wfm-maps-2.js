var map; 

function initialize() {
	var mapOptions = {
		center: new google.maps.LatLng(wfmObj.cords1, wfmObj.cords2),
		zoom: +wfmObj.zoom,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("map-canvas"),
	mapOptions);
}

google.maps.event.addDomListener(window, 'load', initialize);