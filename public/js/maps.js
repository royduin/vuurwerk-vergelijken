(function()
{
	google.maps.visualRefresh = true;
	var infowindow = null;

	function initialize()
	{
		var mapOptions = {
			center: new google.maps.LatLng(52.23, 4.55),
			zoom: 7,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
	 
		var map = new google.maps.Map(document.getElementById("map-canvas"),mapOptions);
		infowindow = new google.maps.InfoWindow({ content: 'Loading...' });
	 
		setMarkers(map,locations);
	}

	function setMarkers(map,locations)
	{
		var image = 'https://vuurwerk-vergelijken.nl/img/vuurwerk-icon.png';
	 
		for (var i = 0; i < locations.length; i++)
		{
			var loc = locations[i];
			var myLatLng = new google.maps.LatLng(loc[1], loc[2]);
			var marker = new google.maps.Marker({
				position: myLatLng,
				map: map,
				icon: image,
				animation: google.maps.Animation.DROP,
				title: loc[0],
				html: loc[3]
			});
			
			google.maps.event.addListener(marker, 'click', function(){
				infowindow.setContent(this.html);
				infowindow.open(map,this);
			});
		}
	}

	google.maps.event.addDomListener(window, 'load', initialize);
})();
