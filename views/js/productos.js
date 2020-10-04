


$("#setFilters").on("click",function(e){
    e.preventDefault()

    var items = [
        {
            key: "search_filter",
            value: $("#search_filter").val()
        },
        {
            key: "filter_categorias",
            value: ($("#c_filter").val().length) ? $("#c_filter").val() : ""
        },
        {
            key: "filter_orden",
            value: $("#order_filter").val()
        }
    ]

    var datos = {
        setFilters: true,
        items: items
    }

    $.ajax({
        url: "views/ajax/gestorProductos.php",
        type: "POST",
        dataType: "JSON",
        data: datos
    })
    .done((res)=>{
        console.log(res)  
        window.location.reload()
    })
    .fail((error)=>{
        console.log(error)
    })
})

$(".setFilterCategory").on("click",function(e){
    e.preventDefault()

    var items = [
        {
            key: "filter_categorias",
            value: [$(this).attr("data-id")]
        }
    ]

    var datos = {
        setFilters: true,
        items: items
    }

    $.ajax({
        url: "views/ajax/gestorProductos.php",
        type: "POST",
        dataType: "JSON",
        data: datos
    })
    .done((res)=>{
        console.log(res)  
        window.location.href = "shop"
    })
    .fail((error)=>{
        console.log(error)
    })
})

$(".thumb_img").on("click",function(){

    var url = $(this).find("img").attr("src")
    console.log(url);

    $("#img_principal").attr("src", url)
    $("#img_principal").parent("a").attr("href", url)
})
$(".content_seccion_nav").on("scroll",function(){
    var left = $(this).scrollLeft()
    if (left > 10) {
        $(".nav_head_").addClass("categorie__scrolled")
    }else{
        $(".nav_head_").removeClass("categorie__scrolled")
    }
})

$("#preguntar").on("click",function(e){
    e.preventDefault()

    var pregunta = $("#ask").val()

    if (pregunta != "") {
        var data = {
            ask: true,
            id_producto: $("#id_pu").val(),
            id_cliente: $("#id_client_").val(),
            pregunta: pregunta
        
        }

        $(this).html("Enviando pregunta....")
    
        $.ajax({
            url: "views/ajax/gestorProductos.php",
            type: "POST",
            dataType: "JSON",
            data: data
        })
        .done((res)=>{
            console.log(res);
            $(this).html("Pregunta enviada.")
            
            setTimeout(()=>{
                $(this).html("Preguntar")
            },2000)
    
        })
        .fail((error)=>{
            console.log(error);
        })
    }

    
})