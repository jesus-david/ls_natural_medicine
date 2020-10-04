
let mapa = L.map("map-routes-sallers")
let myPosision = false
let position 
let control 
let toggle = true
let profile = (localStorage.getItem("profile-route") != null) ? localStorage.getItem("profile-route") : 'mapbox/driving/'
let myMarker
var iconMarker = L.ExtraMarkers.icon({
	icon: 'fa-user',
	markerColor: 'green',
	shape: 'circle',
	prefix: 'fa'
});

$(document).ready(()=>{
	$(`a[ruta-profile="${profile}"]`).parent().addClass("active")


	L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
	attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(mapa);


	window.lrmConfig = {
		serviceUrl: 'https://api.mapbox.com/directions/v5',
		profile: profile
	};

	setTimeout(()=>{
		$("#myMapa").addClass("hidden")
	},500)


	getLocation()

	$(".listMyRoutes").on("click", function(e){
		e.preventDefault()
		$("#misRutas").removeClass("hidden")
		$("#myMapa").addClass("hidden")
		$(".listMyRoutes").addClass("hidden")
	})

	$(".verRuta").on("click",function(){
		$("#misRutas").addClass("hidden")
		$("#myMapa").removeClass("hidden")
		$("#zoom").removeClass("hidden")
		$(".listMyRoutes").removeClass("hidden")
		
		var idruta = $(this).attr("data-id")
		var nombre = $(this).attr("ruta-n")
		var json = JSON.parse($(".puntos-"+ idruta).html())
		console.log(idruta);
		console.log(json);

		control.setWaypoints(json)

		$("#zoom").unbind()
		$("#zoom").bind("click",function(){
			if (json.length != 0) {
				var lt = L.latLng(json[0].lat, json[0].lng)	
				console.log("SET VIEW FORCE!!");
			
				mapa.setView(lt,15)
			}
		})
		
	})

	$(".setProfile").on("click",function(e){
		e.preventDefault()

		var p = $(this).attr("ruta-profile")
		console.log(p);

		// control.options.profile = p
		control.getRouter().options.profile = p
		control.route();
		localStorage.setItem("profile-route", p)
		$(".kt-nav__item").removeClass("active")
		$(this).parent().addClass("active")
		
	})

	function getLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);
			
			navigator.geolocation.watchPosition(miPosision, errorP)
		} else {
			console.log("Geolocation is not supported by this browser.");
		}
	}

	function miPosision(p){
		
		// console.log(p);

		if (myMarker != undefined) {
			mapa.removeLayer(myMarker)

			myMarker = L.marker([p.coords.latitude, p.coords.longitude],{icon: iconMarker})
			
			mapa.addLayer(myMarker)
		}
	}
	function errorP(error){
		console.log(error);
	}

	function showPosition(position) {
		console.log("Latitude: " + position.coords.latitude +
		"<br>Longitude: " + position.coords.longitude);
		position = position
		myPosision = [
			L.latLng(position.coords.latitude, position.coords.longitude),
			L.latLng(position.coords.latitude, position.coords.longitude)
		]

		control = L.Routing.control(L.extend(window.lrmConfig, {
			waypoints: [myPosision],
			// geocoder: L.Control.Geocoder.nominatim(),
			routeWhileDragging: true,
			collapsible: true,
			addWaypoints:false,
			draggableWaypoints:false,
			reverseWaypoints: false,
			showAlternatives: true,
			altLineOptions: {
				styles: [
					{color: 'black', opacity: 0.15, weight: 9},
					{color: 'white', opacity: 0.8, weight: 6},
					{color: 'blue', opacity: 0.5, weight: 2}
				]
			}
		})).addTo(mapa);
		
		L.Routing.errorControl(control).addTo(mapa);
		
		myMarker = L.marker([position.coords.latitude, position.coords.longitude],{icon: iconMarker}).addTo(mapa).bindPopup("Mi ubicación.");
		

	}
})

