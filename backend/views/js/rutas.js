
let idEditar = false
let mapa = L.map("map")
let myPosision = false
let position 
let control 
let toggle = true
let profile = (localStorage.getItem("profile-route") != null) ? localStorage.getItem("profile-route") : 'mapbox/driving/'


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
		$("#contenedorNuevaRuta").addClass("hidden")
	},500)

	$("#s_nuevaRuta").on("click",function(){

		$("#contenedorListaRutas").addClass("hidden")
		$("#contenedorNuevaRuta").removeClass("hidden")
		$("#s_listaRutas").removeClass("activeButton")
		$("#zoom").addClass("hidden")
		$(this).addClass("activeButton")
		$("#nombreRutaNueva").val("")
		idEditar = false
		if (myPosision != false) {
			control.setWaypoints(myPosision)
		}
		
	})
	$("#s_listaRutas").on("click",function(){
		$("#contenedorListaRutas").removeClass("hidden")
		$("#contenedorNuevaRuta").addClass("hidden")
		$("#s_nuevaRuta").removeClass("activeButton")
		$("#zoom").addClass("hidden")
		$(this).addClass("activeButton")
		$("#nombreRutaNueva").val("")
	})


	$("#guardarNuevaRuta").on("click",function(e){
		e.preventDefault()
			
		var nombre = $("#nombreRutaNueva").val()
		var frecuencia = $("#frecuencia").val()
		var puntos = control.getWaypoints()
		var id = $("#s_id").val()
		var array = []
		if (nombre != "") {

			$(this).html("...")
			for(var i = 0; i < puntos.length; i++){
				console.log(puntos[i]);
				var p = puntos[i].latLng
				array.push({lat: p.lat, lng: p.lng})
			}

			console.log(puntos);
			var data = {
				nueva_ruta: true,
				puntos: array,
				nombre: nombre,
				frecuencia: frecuencia,
				id_usuario: id,
				id_ruta: idEditar
			}

			console.log(data);


			ajax.peticion("normal",data, "views/ajax/gestorUsuarios.php")
				.then((res)=>{
					console.log(res);
					if (res.status == "ok") {
						util.alertSuccess("Realizado", res.message, `routes_${id}`)
					}
					$(this).html("Guardar ruta")
				},(error)=>{
					console.log(error);
					$(this).html("Guardar ruta")
				})

		}else{
			util.alertError("Error", "Por favor agrege el nombre de la ruta.")
		}
	})

	$(".borrarRuta").on("click",function(e){
		e.preventDefault()

		util.alertConfirm("¿Estás seguro de borrar esta ruta?")
			.then((res)=>{
				console.log("seguir");
				var data = {
					borrar_ruta: true,
					id_usuario: $(this).attr("data-id")
				}
				ajax.peticion("normal",data, "views/ajax/gestorUsuarios.php")
					.then((res)=>{
						console.log(res);
						if (res.status == "ok") {
							$(`.id_tr_${data.id_usuario}`).remove()
							util.alertSuccess("Realizado", "La ruta ha sido borrada")
						}
					},(error)=>{
						console.log(error);
					})
			}, (no) => console.log(no))

		

	})

	$(".editarRuta").on("click",function(e){
		e.preventDefault()
		$("#contenedorListaRutas").addClass("hidden")
		$("#contenedorNuevaRuta").removeClass("hidden")
		$("#zoom").removeClass("hidden")
		$("#s_listaRutas").removeClass("activeButton")
		
		var idruta = $(this).attr("data-id")
		var nombre = $(this).attr("ruta-n")
		var frecuencia = $(this).attr("ruta-f")
		var json = JSON.parse($(".puntos-"+ idruta).html())
		console.log(idruta);
		console.log(json);

		$("#nombreRutaNueva").val(nombre)
		$("#frecuencia").val(frecuencia)
		control.setWaypoints(json)

		idEditar = idruta

		// if (json.length != 0) {
		// 	var lt = L.latLng(json[0].lat, json[0].lng)	
		// 	console.log("SET VIEW");
		// 	mapa.setView(lt,15)
		// }

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


	$("#addRouteClient").on("click",function(){
		var coords = $("#routesClient").val()	
		var coords = coords.split(",")
	
		var points = control.getWaypoints()
		var latlng = L.latLng(coords[0], coords[1]);
	
		points.push(latlng)
		control.setWaypoints(points)

		control.route();
	})

	getLocation()

	function getLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);
		} else {
			console.log("Geolocation is not supported by this browser.");
		}
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
			geocoder: L.Control.Geocoder.nominatim(),
			routeWhileDragging: true,
			reverseWaypoints: false,
			collapsible: true,
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
		console.log(control);
		
	}


})

