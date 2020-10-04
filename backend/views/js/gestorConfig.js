


$(".actualizar_config").on("blur",function(){



    var id = $(this).attr("data-id")
    var key = $(this).attr("data-key")
    var value = $(this).val()

    OptionsAjax.data = {
        update_field_config: true,
        key: key,
        value: $(this).val(),
        id_p: id
    }
    OptionsAjax.url = "views/ajax/gestorConfig.php"
    ajax.setData(OptionsAjax)
    ajax.ejecutar()
    .then((data)=>{

            if (data.status == "ok") {
                util.alertSuccess("actualizado")
            }else{
                
                util.alertError(data.error)
            }

        },(fail)=>{
            console.log("fallo");
            console.log(fail);
        })




})

$(".actualizar_config_seguridad").on("click",function(){



    var id = $(this).attr("data-id")
    var key = $(this).attr("data-key")
    var to = $(this).attr("data-to")
    var value = $(this)[0].checked

    console.log($(this))

    var data = {
        update_field_config: true,
        key: key,
        value: value,
        id_p: id,
        to: to
    } 

    console.log(data)

    ajax.peticion("normal",data, "views/ajax/gestorConfig.php")
        .then((data)=>{

            if (data.status == "ok") {
                util.alertSuccess("actualizado")
            }else{
                
                util.alertError(data.error)
            }

        },(fail)=>{
            console.log("fallo");
            console.log(fail);
        })
        




})


$(".agregarPaginaRestriccion").on("click",function(){


    var nombre = $("#p-name").val()


    if (nombre != "") {
        OptionsAjax.data = {
            addPageRes: true,
            nombre: nombre
        }
        OptionsAjax.url = "views/ajax/gestorConfig.php"
        ajax.setData(OptionsAjax)
        ajax.ejecutar()
        .then((data)=>{
    
                if (data.status == "ok") {
                    util.alertSuccess("agregado")
                    $("#p-name").val("")
                }else{
                    
                    util.alertError(data.error)
                }
    
            },(fail)=>{
                console.log("fallo");
                console.log(fail);
            })
    
    }
    



})

