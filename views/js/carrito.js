var sku_ = $("#sku_").val()
var variantes = []
if ($("#json_variantes").length != 0) {
    variantes = JSON.parse($("#json_variantes").html())

    console.log(variantes);
}
var sku = []
var price_base = Number($("#price_base").val())

$(".sku_item").on("click",function(e){
    var name = $(this).attr("data-name")
    var _id = $(this).attr("data-s-id")
    var value = $(this).attr("data-value")
    var child_id = $(this).attr("data-child-id")
    var suma = $(this).attr("data-sum")
    var orden = $(this).attr("data-order")
    
    var s = {
        name : name,
        _id :_id,
        value : value,
        child_id : child_id,
        suma : suma,
        orden: orden
    }

    var x = sku.filter((item)=> item._id == s._id)[0]

    if (x != undefined) {
        sku.map((item)=>{
            if (item._id == s._id) {
                item.child_id = s.child_id
                item.suma = s.suma
                item.value = s.value
            }
        })
    }else{
        sku.push(s)
    }


    var n_price = price_base
    sku.map((item)=>{
        n_price += Number(item.suma)
    })

    $(".price").html(format(n_price))

    $(`li.sku_item[data-s-id='${_id}']`).removeClass("sku_active")
    $(this).addClass("sku_active")
    
    if (sku.length == sku_){
        var sku_id_v = ""

        sku = ordenar(sku)

        for(var i = 0; i < sku.length; i++){

            if (i == sku.length - 1) {
                sku_id_v += sku[i].child_id
            }else{
                sku_id_v += sku[i].child_id + "#"
            }
        }

        var v = variantes.filter((item) => item.sku == sku_id_v)[0]
        
        if (v.inventario > 0) {
            $(".sku_stock").attr("max", v.inventario).removeAttr("readonly").val(1)
            $(".message_stock").html("")
        }else{
            $(".sku_stock").attr("max", "0").attr("readonly", "true").val(0)
            $(".message_stock").html(`
                <div class="text-danger">¡Agotado!</div>
            `)
        }

        
    }

    console.log(sku);


})

$("#add_cart").on("click", function (e) {
    e.preventDefault()

    console.log("hey");
    var cantidad = $("#cantidad").val()

    if (sku.length != sku_) {
        
        $(".message_cart").html(`
            <div class="text-info">Selecciona las características del producto.</div>
        `)

        setTimeout(()=>{
            $(".message_cart").html("")
        },2000)

        return false
    }

    if (cantidad == 0) {
        $(".message_cart").html(`
            <div class="text-info">Selecciona la cantidad del producto.</div>
        `)
        setTimeout(()=>{
            $(".message_cart").html("")
        },2000)

        return false
    }
    var id_sku = $("#p_id").val()
    
    sku.map((item)=>{
        id_sku += "#" + item._id + "#" + item.child_id
    })


    var item = {
        id: $("#p_id").val(),
        cantidad: cantidad,
        sku: id_sku,
        skus: sku
    }

    var data = {
        toogleItem: true,
        item: item
    }
    console.log(item)

    $.ajax({
        url: "views/ajax/carrito.php",
        type: "POST",
        dataType: "JSON",
        data: data
    })
    .done((res)=>{
        console.log(res)

        if (res.status == "already") {
            $(".message_cart").html(`
                <div class="text-info">Ya está en el carrito.</div>
            `)
        } else if (res.status == true) {
            $(".message_cart").html(`
                <div class="text-info">Agregado.</div>
            `)
            var x = Number($(".num_items_cart").html())
            $(".num_items_cart").html(x + 1)
        }else{
            $(".message_cart").html(`
                <div class="text-info">Ha ocurrido un error.</div>
            `)
        }

        setTimeout(()=>{
            $(".message_cart").html("")
        },2000)
    })
    .fail((fail)=>{
        console.log(fail)
    })

})


$(".change_stock").on("change",function(){

    var sku = $(this).attr("data-sku")
    var id_u = $(this).attr("data-id-u")
    var value = $(this).val()
    
    var data ={
        change_stock:true, 
        sku: sku, 
        value: value,
        id_usuario: id_u
    }


    $.ajax({
        url: "views/ajax/carrito.php",
        type: "POST",
        dataType: "JSON",
        data: data
    })
    .done((res)=>{
        console.log(res);         
        if (res.status == false) {
            util.alertError("Ha ocurrido un error", "Su petición sobrepasa el inventario del producto")
        }else{
            var type = $("#_type").val()
            var rate =  Number($("#_rate").val())
            var total = Number(res.total.replace(".","").replace(",","."))

           
            if (type == "US$") {
                total = format(total *rate)
            }else{
                total = format(total)
            }

            $(".total_pesos").html("$ " + total)
            $(".total_").html(res.total)
        }
        
        // window.location.reload()  
    })
    .fail((fail)=>{
        console.log(fail)
    })

})

$(".buy_").on("click",function(e){

    e.preventDefault()
    
    var data ={
        crear_pedido:true
    }

    console.log(data);

    $(this).html("Procesando...")
    $.ajax({
        url: "views/ajax/pedidos.php",
        type: "POST",
        dataType: "JSON",
        data: data
    })
    .done((res)=>{
        console.log(res);         
        if (res.status == false) {
            $(".buy_error").html(res.message)
        }else{
            $(".buy_error").html(`<span class='text-primary'>¡Pedido realizado!</span>`)

            setTimeout(()=>{
                window.location.reload()
            },1500)
        }
        
    })
    .fail((fail)=>{
        console.log(fail)
    })


})

$(".deleteFromCart").on("click",function(e){

    e.preventDefault()

    var sku = $(this).attr("data-sku")
    var id_u = $(this).attr("data-id-u")
    var id_p = $(this).attr("data-p-id")
    
    var data ={
        deleteFromCart:true, 
        sku: sku, 
        id_usuario: id_u
    }

    $.ajax({
        url: "views/ajax/carrito.php",
        type: "POST",
        dataType: "JSON",
        data: data
    })
    .done((res)=>{
        console.log(res);         
        
        window.location.reload()
    })
    .fail((fail)=>{
        console.log(fail);
    })


})


$(".vaciarCarrito").on("click",function(){

    ajax.peticion("normal",{vaciar:true}, "views/ajax/carrito.php")
        .then((res)=>{

            console.log(res);            
            window.location.reload()            
        },(fail)=>{
            console.log(fail)
        })
})


$("#buy_").on("click",function(e){
    e.preventDefault()

    var id = $("#p_id").val()
    var id_vendedor = $(this).attr("data-id-seller")
    var cantidad = $("#cantidad").val()

    step_1(id,cantidad,id_vendedor)
    
})

function step_1(id, cantidad, id_vendedor){
    

    if (sku.length != sku_) {
        
        $(".message_cart").html(`
            <div class="alert alert-info">Selecciona las características del producto.</div>
        `)

        setTimeout(()=>{
            $(".message_cart").html("")
        },2000)

        return false
    }

    if (cantidad == 0) {
        $(".message_cart").html(`
            <div class="alert alert-info">Selecciona la cantidad del producto.</div>
        `)
        setTimeout(()=>{
            $(".message_cart").html("")
        },2000)

        return false
    }
    var id_sku = id
    
    sku.map((item)=>{
        id_sku += "#" + item._id + "#" + item.child_id
    })

    var item = {
        id: id,
        cantidad: cantidad,
        sku: id_sku,
        skus: sku
    }

    var data = {
        toogleItem: true,
        item: item
    }
    console.log(item)

    $(".message_cart").html(`
        <div class="alert alert-info">Cargando...</div>
    `)
 
    ajax.peticion("normal", data , "views/ajax/carrito.php")
        .then((res) => {

            console.log(res)

            if (res.status == "already" || res.status == true) {
                $(".message_cart").html(`
                    <div class="alert alert-info">Procesando...</div>
                `)
                step_2(id_vendedor)
            }else{
                util.alertError("Ha ocurrido un error")
            }

        }, (fail) => {
            console.log(fail)
        })
}

function step_2(id_vendedor){

    var data ={
        crear_pedido:true,
        id_vendedor: id_vendedor
    }

    console.log(data);

    ajax.peticion("normal",data, "views/ajax/pedidos.php")
        .then((res)=>{

            console.log(res);         
            if (res.status == false) {
                $(".message_cart").html(``)
                util.alertError("Ha ocurrido un error", res.message)
            }else{
                $(".message_cart").html(``)
                util.alertSuccess("¡Realizado!", "El pedido se ha realizado con éxito.", false, true)
            }
            
            // window.location.reload()            
        },(fail)=>{
            console.log(fail)
        })
}


function format(n) {
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

function enElCarrito(sku) {
    var carrito = JSON.parse($(".cartJson").html())

    var item = carrito.filter((item) => item.sku == sku)[0]

    if (item != undefined) {
        return true
    } else {
        return false
    }
}

function ordenar(items){
	items = items.sort(function (a, b) {
		if (a.orden > b.orden) {
		  return 1;
		}
		if (a.orden < b.orden) {
		  return -1;
		}
		return 0;
	});

	return items
}