

$("#crearCategoria").on("click",function(){

    var nombre = $("#nombreCategoria").val()
    $(this).html("...")
    ajax.peticion("normal", {crear: true, nombre: nombre}, "views/ajax/gestorCategorias.php")
        .then((res)=>{
            console.log(res);
            if (res.status == "error" || res.status == false) {
                util.alertError("Error", res.mensaje)
                
            } else{
                util.alertSuccess("Realizado", "¡La categoría se agregó correctamente!", "categories")

            }
            $(this).html("AGREGAR")
        },(error)=>{
            console.log(error);
        })
})

$("#actualizarCategoria").on("click",function(){

    var nombre = $("#nombreCategoriaEditar").val()
    var id = $("#idCategoria").val()
    $(this).html("...")

    var data = new FormData(document.getElementById("editCategoria"))

    data.append("actualizar", true) 
    data.append("nombre", nombre) 
    data.append("id", id) 

    ajax.peticion("FormData", data, "views/ajax/gestorCategorias.php")
        .then((res)=>{
            console.log(res);
            if (res.status == "error" || res.status == false) {
                util.alertError("Error", res.mensaje)                
            } else{
                util.alertSuccess("Realizado", "¡La categoría se actualizó correctamente!", "categories")

            }
            $(this).html("ACTUALIZAR")
        },(error)=>{
            console.log(error);
        })
})