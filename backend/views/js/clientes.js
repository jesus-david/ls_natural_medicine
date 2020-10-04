
if ($("#mapa_client_direccion").length != 0) {
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        console.log("Geolocation is not supported by this browser.");
    }
	

	function showPosition(position) {
        let markerDireccion

        var __tkoen = "pk.eyJ1IjoiamVzdXNtYXAxOSIsImEiOiJjazZ0cHZqeHQwMG5uM2xteXRnOXJjcm01In0.81SWLAQS_tTVT4YzbsWRRQ"

        var coors = $("#latlng").val()
        var latitude
        var longitude
        if (coors != "") {
            coors = coors.split(",")
            console.log(coors);
            latitude = coors[0]
            longitude = coors[1]
        }else{
            latitude = position.coords.latitude
            longitude = position.coords.longitude
        }

        let mapa = L.map("mapa_client_direccion").setView([latitude, longitude], 13);

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mapa);

        
        if (coors != "") {
            if (markerDireccion != undefined) {
                mapa.removeLayer(markerDireccion)
            }
    
            markerDireccion = L.marker(coors);
    
            mapa.addLayer(markerDireccion) 
            $("#latlng").val(latitude + "," + longitude)
        }
        
        
        mapa.on("click",function(e){
            console.log("click sobre el mapa");
            console.log(e);

            $.ajax({
                url: `https://api.mapbox.com/geocoding/v5/mapbox.places/${e.latlng.lng},${e.latlng.lat}.json?access_token=${__tkoen}`,
                type: "GET",
                dataType: "JSON"
            })
            .done((res)=>{
                console.log(res);
                var d = ""
               
                if(res.features. length != 0){
                    $("#direccion").val(res.features[0].place_name)
                }
                if (markerDireccion != undefined) {
                    mapa.removeLayer(markerDireccion)
                }

                markerDireccion = L.marker(e.latlng);

                mapa.addLayer(markerDireccion) 
                $("#latlng").val(e.latlng.lat + "," + e.latlng.lng)
                
            })
            .fail((error) =>{
                console.log(error);
            })
        })
	
		console.log(mapa);
        
        $(".findInMap").on("click",function(){

            var d = $("#direccion").val()
            console.log(d);
            $.ajax({
                url: `https://api.mapbox.com/geocoding/v5/mapbox.places/${d}.json?access_token=${__tkoen}`,
                type: "GET",
                dataType: "JSON"
            })
            .done((res)=>{
                console.log(res);
            
                if (markerDireccion != undefined) {
                    mapa.removeLayer(markerDireccion)
                }

                if (res.features) {
                    var coors = [
                        res.features[0].geometry.coordinates[1],
                        res.features[0].geometry.coordinates[0] 
                    ]
                    markerDireccion = L.marker(coors);
                    mapa.addLayer(markerDireccion) 

                    mapa.setView(coors,15)

                    $("#latlng").val(res.features[0].geometry.coordinates[1] + "," + res.features[0].geometry.coordinates[0] )
                }
                

                
                
            })
            .fail((error) =>{
                console.log(error);
            })
        })
    }
    

}



$("#crearCliente").on("click",function(e){
    e.preventDefault()
    var datos = new FormData(document.getElementById("formNuevoCliente"))

    datos.append("crear", "true")
    datos.append("id_zona", $("#zona").val())
    $(this).html("...")
    ajax.peticion("FormData", datos,"views/ajax/gestorClientes.php")
        .then((res)=>{
            console.log(res)  
            if (res.status == "error") {
                util.alertError("Error", res.mensaje)
                
            } else{
                util.alertSuccess("Realizado", "¡El Cliente se agregó correctamente!", false, true)

            }
            $(this).html("CREAR")
        },(error)=>{
            console.log(error)
            $(this).html("CREAR")
        })

})


$("#actualizarInfoCliente").on("click",function(e){
    e.preventDefault()
    var datos = new FormData(document.getElementById("actualizarInfoCliente-form"))

    datos.append("actualizar", "true")
    datos.append("id_zona", $("#zona").val())
    $(this).html("...")
    ajax.peticion("FormData", datos,"views/ajax/gestorClientes.php")
        .then((res)=>{
            console.log(res)  
            if (res.status == "error") {
                util.alertError("Error", res.mensaje)
                
            } else{
                util.alertSuccess("Realizado", "¡El cliente se actualizó correctamente!")

            }
            $(this).html("ACTUALIZAR")
        },(error)=>{
            console.log(error)
            $(this).html("ACTUALIZAR")
        })

})

$("#filtrarClients").on("click",function(){

    filtrarClients($("#generalSearch").val())
    
})
$(".removeFilterClients").on("click",function(){

    filtrarClients("")
    
})

function filtrarClients(val){
    var data ={
        filtrar: true,
        search: val
    }

    ajax.peticion("normal", data, "views/ajax/gestorClientes.php")
        .then((res)=>{
            console.log(res)
            window.location.reload()            
        },(error)=>{
            console.log(error)
        })
}