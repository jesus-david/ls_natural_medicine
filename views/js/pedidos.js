var set_reviews = []

$("table#example tbody").on("click", "tr td .dropdown .dropdown-menu a.ver_productos_pedido", function(e){
    e.preventDefault();

    var id = $(this).attr("data-id")

    $.ajax({
        url: "views/ajax/pedidos.php",
        type: "POST",
        dataType: "JSON",
        data: {ver_items_pedidos: true, id: id}
    })
    .done((res)=>{
        console.log(res);
        $(".content_p").html("")
        for(var i = 0; i < res.length; i++){

            var item = res[i]
            var producto = item.info
            var galeria = producto.galeria
            var img = producto.imagen
            var skus = ""

            if (item.skus != "") {

                for(var j = 0;  j < item.skus.length; j++){

                    skus += `
                        <dt>
                            ${item.skus[j].name}:
                        </dt>
                        <dd>
                            <span>${item.skus[j].value}</span>
                        </dd>
    
                    `

                }
                
            }


            $(".content_p").append(`
                <div class="product-container row">                          
                    <div class="product-field product-image col-md-4">
                        <a href="${producto.slug}">
                            <img src="backend/${img}" style="max-width: 110px;"/>
                        </a>
                    </div>
                    <div class="product-field product-main col-md-8">
                        <div class="product-title">
                            <a href="${producto.slug}" class="product-name-link">
                                ${producto.nombre}
                            </a>
                        </div>
                        <div class="product-attr">
                            <div class="product-sku">
                                <dl>
                                    ${skus}                          
                                </dl>
                            </div>
                        </div>
                        <div class="product-price">

                            <div class="cost-main normal">
                                <span class="main-cost-price">
                                    $ <span class="price">${format_(item.precio_compra)}</span>
                                </span>
                            </div>
                        
                        </div>
                    
                    </div>
                </div>
                    
            
            `)

        }

        $("#modal_productos").modal("show")
    })
    .fail((fail)=>{
        console.log(fail);
    })
    
})

$("table#example tbody").on("click", "tr td .dropdown .dropdown-menu a.pedido_entregado", function(e){
    e.preventDefault();

    var id = $(this).attr("data-id")

    util.alertConfirm("¿Quieres marcar este pedido como entregado?")
        .then(()=>{

            ajax.peticion("normal", {pedido_entregado: true, id_pedido: id}, "views/ajax/pedidos.php")
                .then((res)=>{
                    console.log(res);
                    
                    util.alertSuccess("OK", "Realizado con éxito", false, true)
    
                },(fail)=>{
                    console.log(fail);
                })


        }, ()=> console.log(""))
    
})

$("table#example tbody").on("click", "tr td .dropdown .dropdown-menu a.cancelar_pedido", function(e){
    e.preventDefault();

    var id = $(this).attr("data-id")

    util.alertConfirm("¿Seguro de que quieres cancelar este pedido?")
        .then(()=>{

            ajax.peticion("normal", {cancelar_compra: true, id_pedido: id}, "views/ajax/pedidos.php")
                .then((res)=>{
                    console.log(res);
                    
                    util.alertSuccess("Realizado", "Compra cancelada", false, true)
    
                },(fail)=>{
                    console.log(fail);
                })


        }, ()=> console.log(""))
    
})

$("table#example tbody").on("click", "tr td .dropdown .dropdown-menu a.borrar_pedido", function(e){
    e.preventDefault();

    var id = $(this).attr("data-id")

    util.alertConfirm("¿Seguro de que quieres borrar este pedido?")
        .then(()=>{

            ajax.peticion("normal", {borrar_pedido: true, id_pedido: id}, "views/ajax/pedidos.php")
                .then((res)=>{
                    console.log(res);
                    
                    util.alertSuccess("Realizado", "Pedido borrado", false, true)
    
                },(fail)=>{
                    console.log(fail);
                })


        }, ()=> console.log(""))
    
})
  
$("table#example tbody").on("click", "tr td .dropdown .dropdown-menu a.borrar_pedido_soft", function(e){
    e.preventDefault();

    var id = $(this).attr("data-id")
    var who = $(this).attr("data-who")

    util.alertConfirm("¿Seguro de que quieres borrar este pedido?")
        .then(()=>{

            ajax.peticion("normal", {borrar_pedido_soft: true, id_pedido: id, who : who}, "views/ajax/pedidos.php")
                .then((res)=>{
                    console.log(res);
                    
                    util.alertSuccess("Realizado", "Pedido borrado", false, true)
    
                },(fail)=>{
                    console.log(fail);
                })


        }, ()=> console.log(""))
    
})

var id_p_valorar = 0

$("table#example tbody").on("click", "tr td .dropdown .dropdown-menu a.valorar_", function(e){
    e.preventDefault();

    id_p_valorar = $(this).attr("data-id")

    var id = $(this).attr("data-id")

    $.ajax({
        url: "views/ajax/pedidos.php",
        type: "POST",
        dataType: "JSON",
        data: {ver_items_pedidos: true, id: id}
    })
    .done((res)=>{
        console.log(res);
        set_reviews = res
        $(".content_set_reviews").html("")

        for(var i = 0; i < res.length; i++){

            var item = res[i]
            var producto = item.info

            $(".content_set_reviews").append(`

                <h5>${producto.nombre}</h5>
                <div class="row mt-4">
                        <div class="col-md-6 mt-2">
                            <div class="rate-score">
                                <div class="star-view-big">
                                    <span class="star-width" data-id="${producto.id}" style="width:100%"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <select class="form-control valoracion_control" data-id="${producto.id}">
                                    <option>1</option>
                                    <option>1.5</option>
                                    <option>2</option>
                                    <option>2.5</option>
                                    <option>3</option>
                                    <option>3.5</option>
                                    <option>4</option>
                                    <option>4.5</option>
                                    <option selected>5</option>
                                
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea data-id="${producto.id}" class="form-control comment_control" placeholder="Comenta..."></textarea>
                    </div>
            
            `)

        }

        $(".valoracion_control").unbind().bind("change", function(){

            var id = $(this).attr("data-id")
            var total = 5
            var val = $(this).val()
            var porcentaje = (val * 100) / total
        
            $(`.star-width[data-id="${id}"]`).css("width", `${porcentaje}%`)
        
        })

        $("#modal_valoracion").modal("show")
    })
    .fail((fail)=>{
        console.log(fail);
    })

    
})



$("#valorar").on("click",function(e){


    $(this).html("Procesando...")

    var reviews = []

    for(var i = 0; i < set_reviews.length; i++){

        var item = set_reviews[i]
        var producto = item.info
        
        var x = {
            id: producto.id, 
            val: $(`.valoracion_control[data-id="${producto.id}"]`).val(),
            comment: $(`.comment_control[data-id="${producto.id}"]`).val()
        }

        reviews.push(x)

    }

    var data = {
        valorar: true, 
        id: id_p_valorar,
        reviews: reviews
    }

    console.log(data);

    $.ajax({
        url: "views/ajax/pedidos.php",
        type: "POST",
        dataType: "JSON",
        data: data
    })
    .done((res)=>{
        console.log(res);
        $(".message_v").html("<span class='alert alert-info'>Realizado</span>")

        setTimeout(()=>{
            window.location.reload()
        },1500)
    })
    .fail((fail)=>{
        console.log(fail);
        $(this).html("Valorar")
    })



})

function format_(n) {
    var x = n.toLocaleString()
    var arr = x.split(",")

    if (arr[1] == undefined) {
        n = arr[0] + ",00"
    }else if(arr[1].length == 1){
        n = arr[0] + "," + arr[1] + "0"
    }else{
        n = arr[0] + "," + arr[1]
    }

    return n
}