
var init_features = []
var type_money = $("#type_money").val()
var features_limit = {
    l1: 4,
    l2: 5
}
var random = (min, max) => Math.round(Math.random() * (max - min) + min);
 
var examples_features = [
    {
        name: "Color",
        val: "Negro"
    },
    {
        name: "Tamaño",
        val: "Mediano"
    },
    {
        name: "Marca",
        val: "xxxx"
    },
    {
        name: "Tamaño",
        val: "Grande"
    },
    
    {
        name: "Talla",
        val: "XL"
    }
]

if ($("#features_saved").length != 0) {
    init_features = JSON.parse($("#features_saved").html())

    console.log(init_features);
    drawFeatures()
}else{
    $("#features_saved")
}

$("#crearProducto").on("click",function(e){
    e.preventDefault()
    var datos = new FormData(document.getElementById("formNuevoProducto"))

    datos.append("crear", "true")
    datos.append("features", JSON.stringify(init_features))
    $(this).html("...")

    var categorias = $("#categorias").val()
    datos.append("categorias", categorias)
    
    ajax.peticion("FormData", datos,"views/ajax/gestorProductos.php")
        .then((res)=>{
            console.log(res)  
            if (res.status == "error") {
                util.alertError("Error", res.mensaje)
                
            } else{
                util.alertSuccess("Realizado", "¡El producto se creó correctamente!", "newProduct")

            }
            $(this).html("CREAR")
        },(error)=>{
            console.log(error)
            $(this).html("CREAR")
        })

})

$("#actualizarInfoProducto").on("click",function(e){
    e.preventDefault()
    var datos = new FormData(document.getElementById("actualizarInfoProducto-form"))

    datos.append("actualizar", "true")
    datos.append("features", JSON.stringify(init_features))
    var categorias = $("#categorias").val()
    datos.append("categorias", categorias)

    $(this).html("...")
    ajax.peticion("FormData", datos,"views/ajax/gestorProductos.php")
        .then((res)=>{
            console.log(res)  
            if (res.status == "error") {
                util.alertError("Error", res.mensaje)
                
            } else{
                util.alertSuccess("Realizado", "¡El producto se actualizó correctamente!", false, true)

            }
            $(this).html("ACTUALIZAR")
        },(error)=>{
            console.log(error)
            $(this).html("ACTUALIZAR")
        })

})


//mostrar modal 
$("#cambiarImagenPerfil").on("click",function(){
    $("#myModal").modal("show")
})
//guardar imagen
$("#cambiarImagen").on("click",function(){
    
    var data = new FormData(document.getElementById("formImagenPerfil"))
    data.append("cambiarImagenPerfil", "true")

    ajax.peticion("FormData", data, "views/ajax/gestorUsuarios.php")
        .then((res)=>{
            console.log(res)

            if (res.status != "ok") {
                $(".mensajeModal").html(res.mensaje)   
            }else{
                swal.fire({
                    title: "¡Actualizado!",
                    text:
                        "¡Imagen de perfil actualizada!",
                    type: "success",
                    buttonsStyling: !1,
                    confirmButtonText: "OK",
                    confirmButtonClass:
                        "btn btn-sm btn-bold btn-brand"
                }).then(()=>{
                    window.location.reload()
                })
            }
            
        },(error)=>{
            console.log(error)
        })
})

$("#formSearch").on("submit",function(e){
    e.preventDefault()
    filterProducts($("#generalSearch").val())
    
})

$(".removeFilterProducts").on("click",function(){

    filterProducts("")
    
})


$("#guardar_files_producto").on("click",function(){

	var formData1 = new FormData(document.getElementById("form_add_files"));

	var error = false;
	var id_p = $("#id_producto_hidden").val()
	var total_size = 0;
	
	formData1.forEach((item, i, ob)=>{
		if (i == "files_product[]") {
			total_size += item.size		
		}	
	});

	var mb = (total_size / 1024) / 1024

	console.log(mb)
	
	if (mb > 15) {
		error = "Los archivos superan el límite de subida ( 15MB )";
	}

	if (!error) {

		if (total_size > 0) {
			formData1.append('add_files_product',true)
			formData1.append('id_p',id_p)
            $(this).html("...")
			ajax.mostrarProgreso(function(prog){
	            console.log(prog)
	            $(".progress_bar_product .line_progress").css("width", prog + "%")
	        })
			ajax.peticion("formData",formData1,"views/ajax/gestorProductos.php")
			.then((data)=>{
                console.log(data)
                $(this).html("Guardar")
				if (data.status == "ok") {				
					$(".progress_bar_product .line_progress").css("width", "100%")
					util.alertSuccess("Realizado", "Imagenes agregadas a la galería", `galery_${id_p}` )
				}

			},(fail)=>{
				console.log("fallo");
                console.log(fail);
                $(this).html("Guardar")
			})
		}


			
		

	}else{
		
		util.alertError("Error", error.message)
	}

})

$(".content-img-galery").on("mouseover", function(e){

    var id_img  = $(this).attr("id")

    $(`button[accesskey="${id_img}"]`).removeClass("hidden")
})
$(".content-img-galery").on("mouseleave", function(e){

    var id_img  = $(this).attr("id")

    $(`button[accesskey="${id_img}"]`).addClass("hidden")
})

$(".borrar_img_producto").on("click",function(){

    var id = $(this).attr("accesskey")
    var id_p = $("#id_producto_hidden").val()
    var data = new FormData()
    data.append("borrar_file", true)
    data.append("id_file", id)

    util.alertConfirm("¿Estás seguro de borrar esta imagen de la galería?")
        .then(()=>{

            ajax.peticion("FormData", data, "views/ajax/gestorProductos.php")
                .then((res)=>{
                    console.log(res);
                    if (res.status == "ok") {
                        util.alertSuccess("Realizado", "Imagen borrada", `galery_${id_p}`)
                    }
                },(error)=>{
                    console.log(error);
                })

        },(error)=> console.log(error))
})

$(".addFeature").on("click",function(e){
    e.preventDefault()
    var length = init_features.length

    if (!length) {
        var temp_id = 1
    }else{
        var temp_id = init_features[length - 1].temp_id + 1
    }

    if (init_features.length < features_limit.l1) {
        init_features.push({
            nombre: "",
            childs: [
                {
                    nombre: "",
                    valor_agregado: "",
                    temp_id: 1
                }
            ],
            temp_id: temp_id  
        })

        drawFeatures()
    }else{
        util.alertError("¡Error!", "No puedes agregar más de 4")
    }
    console.log(init_features);
    
})

$(".sku_update").on("change",function(e){
    e.preventDefault()

    var sku = $(this).attr("data-sku")

    var datos = {
        sku_update: true,
        sku: sku,
        value: $(this).val()
    }

    console.log(datos);

    ajax.peticion("normal", datos,"views/ajax/gestorProductos.php")
        .then((res)=>{
            console.log(res)  
            
            util.alertSuccess("Actualizado","", false, true)
        },(error)=>{
            console.log(error)
        })

})
$("#aply_all").on("click",function(e){
    e.preventDefault()

    var id = $(this).attr("data-id")

    var datos = {
        sku_update_all: true,
        id: id,
        value: $("#global_stock").val()
    }

    console.log(datos);

    ajax.peticion("normal", datos,"views/ajax/gestorProductos.php")
        .then((res)=>{
            console.log(res)  
            
            util.alertSuccess("Actualizado", "",false, true)
        },(error)=>{
            console.log(error)
        })

})


function drawFeatures(){


    $(".content_feaures").html("")

    for(var i = 0; i < init_features.length; i++){
        var item = init_features[i]

        var drawChilds = ""
        var num = random(0, examples_features.length -1)
        var ejemp = examples_features[num]
        

        for(var j = 0; j < item.childs.length; j++){
            var cItem = item.childs[j]

            drawChilds += `
                <div id="feaure_child_${cItem.temp_id}" class="mx-5">
              
                    <div class="d-flex">

                        <input type="text" class="form-control input_c f14 mt-2 mr-2 nameChildFeature mx200" placeholder="${ejemp.val}" value="${cItem.nombre}" data-id="${cItem.temp_id}" data-id-f="${item.temp_id}">

                        <input type="text" class="form-control input_c f14 mt-2 mr-2 valueChildFeature mx200" placeholder="Sumar ($)" value="${cItem.valor_agregado}" data-id="${cItem.temp_id}" data-id-f="${item.temp_id}">

                        <div class="icons_features">
                            <span class="removeChildFeature" data-id="${cItem.temp_id}" data-id-f="${item.temp_id}">
                                <i class="fas fa-trash"></i>
                            </span>
                            
                            <i class="fas fa-question" data-toggle="kt-tooltip" title="*Suma*: Precio que se le suma al producto cuando esta característica es seleccionada." data-placement="top"></i>
                        </div>
                        
                    </div>
                  
                </div>
            
            `
        }

        $(".content_feaures").append(`
        
            <div class="mb-4" id="feaure_${item.temp_id}">
                                                                    
                <div class="d-flex">
                    <input type="text" class="form-control input_c mr-2 nameFeature" placeholder="${ejemp.name}" value="${item.nombre}" data-id="${item.temp_id}">
                    
                    <span class="addChildFeature" data-id="${item.temp_id}">
                        <i class="fas fa-plus mr-2 cursor"></i>
                    </span>
                    <span class="removeFeature" data-id="${item.temp_id}">
                        <i class="fas fa-trash cursor"></i>
                    </span>
                    
                </div>
        
                <div class="kt-list-timeline">
                    <div class="kt-list-timeline__items">
                        ${drawChilds}
                    </div>

                </div>
              
            </div>
        
        `)
    }

    $(".removeFeature").unbind().bind("click",function(){

        var id = Number($(this).attr("data-id"))

        init_features = init_features.filter((item) => item.temp_id != id)

        
        drawFeatures()

    })

    $(".removeChildFeature").unbind().bind("click",function(){

        var id = Number($(this).attr("data-id"))
        var id_f = Number($(this).attr("data-id-f"))
        var index_f = undefined
        for(var i = 0; i < init_features.length; i++){
            if (init_features[i].temp_id == id_f) {
                index_f = i
                break
            }
        }

        init_features[index_f].childs = init_features[index_f].childs.filter((item) => item.temp_id != id)

        drawFeatures()

        if (init_features[index_f].childs.length == 0) {
            init_features = init_features.filter((item) => item.temp_id != id_f)
            drawFeatures()
        }

    })

    $(".addChildFeature").unbind().bind("click",function(){

        var id = Number($(this).attr("data-id"))

        var index_f = undefined
  
        for(var i = 0; i < init_features.length; i++){
            if (init_features[i].temp_id == id) {
                index_f = i
                break
            }
        }


        if(init_features[index_f].childs.length < features_limit.l2){
            init_features[index_f].childs.push({
                nombre: "",
                valor_agregado: "",
                temp_id: init_features[index_f].childs[init_features[index_f].childs.length - 1 ].temp_id + 1,
              
            })
        
            drawFeatures()
        }else{
            util.alertError("¡Error!", "No puedes agregar más de 5")
        }

        

    })
    
    $(".nameFeature").unbind().bind("keyup",function(){

        var val = $(this).val()
        var id = Number($(this).attr("data-id"))

        var index = findIndexById(id)

        init_features[index].nombre = val
    
        // drawFeatures()

    })

    $(".nameChildFeature").unbind().bind("keyup",function(){

        var val = $(this).val()
        var id = Number($(this).attr("data-id"))
        var id_f = Number($(this).attr("data-id-f"))

        var index = findIndexById(id_f)
        var index_2 = findIndexChildById(index, id)

        init_features[index].childs[index_2].nombre = val

    })

    $(".valueChildFeature").unbind().bind("keyup",function(){

        var val = $(this).val()
        var id = Number($(this).attr("data-id"))
        var id_f = Number($(this).attr("data-id-f"))

        var index = findIndexById(id_f)
        var index_2 = findIndexChildById(index, id)

        init_features[index].childs[index_2].valor_agregado = val

    })
    
    
}

function findIndexById(id){
    var  index_f = undefined
    for(var i = 0; i < init_features.length; i++){
        if (init_features[i].temp_id == id) {
            index_f = i
            break
        }
    }

    return index_f
}
function findIndexChildById(parent, id){
    var  index_f = undefined
    for(var i = 0; i < init_features[parent].childs.length; i++){
        if (init_features[parent].childs[i].temp_id == id) {
            index_f = i
            break
        }
    }

    return index_f
}


function filterProducts(val){
    var data ={
        filtrar: true,
        search: val
    }

    ajax.peticion("normal", data, "views/ajax/gestorProductos.php")
        .then((res)=>{
            console.log(res)
            window.location.reload()            
        },(error)=>{
            console.log(error)
        })
}