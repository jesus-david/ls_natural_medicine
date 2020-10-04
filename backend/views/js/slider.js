

$(".slider-close").on("click",function(){
	var id = $(this).attr("data-id-slider")
	$(`.slider-${id}`).hide()
})

$(".changeImgSlider").on("click",function(){
	var id = $(this).attr("data-id-slider")
	var ind = $(this).attr("data-c")
	var limit = $(`.slider-${id}`).attr("data-limit")

	var img =  $(`.img-bar-${id} .img-item-selected img`)
	var index = img.attr("data-index")

	if (ind == '-1') {
		var nuevoIndex = (Number(index) - 1);
		if (nuevoIndex < 1) {
			nuevoIndex = limit
		}
	}else if (ind == '+1') {
		var nuevoIndex = (Number(index) + 1);
		if (nuevoIndex > limit) {
			nuevoIndex = 1
		}
	}
	$(".slider-options").removeClass("img-item-selected")

	var src = $(`img[data-index='${nuevoIndex}']`).attr("src")
	
	$(`img[data-index='${nuevoIndex}']`).parent().addClass("img-item-selected")
	$(".img-actual-info").html(nuevoIndex)
	$(".img-slide-content-"+id).html(`
		<img src="${src}">
	`)

})

$(".verSlide").on("click",function(){
	var id = $(this).attr("data-id")
	var my_self = $(this).attr("data-self")

	var datos = {
        verImagenesSlide: true,
        id: id
    }

    console.log(datos);

    $(".img-bar").html("")
    ajax.peticion("normal", datos, "views/ajax/gestorProductos.php")
        .then((data)=>{           
        	console.log(data)
        	var contador = 1;
        	var auxContador = 0;
        	var ln = data.length
        	$(".slider-overlay").attr('data-limit', ln);

        	for(var i = 0; i < data.length; i++){

        		var idnt = data[i].id
        		var link = data[i].link
        		var selected = (idnt == my_self) ? "img-item-selected" : ""

        		if (selected != "") {
        			$(".img-container-slider").html(`
						<img src="${link}">
        			`)
        			auxContador = contador
        		}
        		
        		$(".img-bar").append(`					
					<div>
                        <div class="img-container slider-img-container slider-options ${selected}">
                            <img src="${link}" data-id-slider='1' data-index='${contador}'>
                        </div>
                    </div>
        		`)

        		contador++
        	}

        	$(".slider-overlay").show()
        	$(".info-bar").html(`
				<span class='img-actual-info'>${auxContador}</span> / <span class='total-imagenes'>${ln}</span> . 
				<a href="#" class='simple-a verLista' data-estado='0'>ver lista de imágenes <i class='fas fa-angle-down'></i> </a>
        	`)

        	$(".slider-options img").on("click",function(){
				var id = $(this).attr("data-id-slider")
				var index = $(this).attr("data-index")
				var path = $(this).attr("src")

				$(".slider-options").removeClass("img-item-selected")

				$(this).parent().addClass("img-item-selected")
				$(".img-actual-info").html(index)

				$(".img-slide-content-"+id).html(`
					<img src="${path}">
				`)
            })
            

			$(".verLista").on("click",function(e){
				e.preventDefault()
				var estado = $(this).attr("data-estado")

				if (estado == 0) {
					$(".slider-footer").css('bottom', '5px');
					$(this).attr("data-estado",'1')
				}else{
					$(".slider-footer").css('bottom', '-82px');
					$(this).attr("data-estado",'0')
				}
            });
            
            $(".verLista").trigger("click")

            setTimeout(()=>{
                var imags = $(".slider-options img:first")
                console.log(imags);
                if (imags.length != 0) {
                    imags.trigger("click")
                }
            },500)
			
        }, (fail)=>{
            c("fallo")
            c(fail)
        })

	
})