

$("#crearZona").on("click",function(){

    var nombre = $("#nombreZona").val()
    $(this).html("...")
    ajax.peticion("normal", {crear: true, nombre: nombre}, "views/ajax/gestorZonas.php")
        .then((res)=>{
            console.log(res);
            if (res.status == "error" || res.status == false) {
                util.alertError("Error", res.mensaje)
                
            } else{
                util.alertSuccess("Realizado", "¡La zona se agregó correctamente!", "zones")

            }
            $(this).html("AGREGAR")
        },(error)=>{
            console.log(error);
        })
})

$("#actualizarZona").on("click",function(){

    var nombre = $("#nombreZonaEditar").val()
    var id = $("#idZone").val()
    $(this).html("...")
    ajax.peticion("normal", {actualizar: true, nombre: nombre, id: id}, "views/ajax/gestorZonas.php")
        .then((res)=>{
            console.log(res);
            if (res.status == "error" || res.status == false) {
                util.alertError("Error", res.mensaje)
                
            } else{
                util.alertSuccess("Realizado", "¡La zona se actualizó correctamente!", "zones")

            }
            $(this).html("ACTUALIZAR")
        },(error)=>{
            console.log(error);
        })
})