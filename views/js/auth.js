

var st__ = false

$(".eye_pass").on("click",function(){

    if (!st__) {
        $("#passwordRegistro").attr("type", "text")
        $(".eye_pass").html(`<i class="fas fa-eye-slash"></i>`)
        st__ = true
    }else{
        $("#passwordRegistro").attr("type", "password")
        $(".eye_pass").html(`<i class="fas fa-eye"></i>`)
        st__ = false
    }

})

// ..............................................................

$("#formRegistro").on("submit",function(e){
    e.preventDefault()

    var datos = new FormData(document.getElementById("formRegistro"))

    var acepted = $("#check_term")[0].checked

    if (acepted) {
        datos.append("nuevo_registro", true)
        $(".message").html(`
            <div class="alert alert-primary">
                Procesando registro...
            </div> 
        `)

        $.ajax({
            url: "views/ajax/auth.php",
            type: "POST",
            dataType: "JSON",
            processData: false,
            contentType: false,
            cache: false,
            data: datos
        })
        .done((res)=>{
            $(".message").html("")

            if (!res.status) {
                $(".message").html(`
                    <div class="alert alert-danger">
                        ${res.message}
                    </div> 
                `)
            }else{
                $(".message").html(`
                    <div class="alert alert-success">
                    Registrado con éxito
                    </div> 
                `)
                localStorage.setItem("nombreRegistro", "")
                localStorage.setItem("emailRegistro", "")

                setTimeout(()=>{
                    window.location.href = "login"
                },1500)
            }

            setTimeout(()=>{
                $(".message").html("")
            },3000)
            
            console.log(res)
        })
        .fail((error)=>{
            console.log(error)
        })
    }else{
        $(".message").html(`
            <div class="alert alert-danger">
                Debes aceptar los Términos y condiciones
            </div> 
        `)
    }

    


})

$("#actualizarInfo-form").on("submit",function(e){
    e.preventDefault()

    var datos = new FormData(document.getElementById("actualizarInfo-form"))

    datos.append("actualizar_info", true)
    $(".message").html(`
        <span class="text-primary">
            Procesando...
        </span> 
    `)
    $.ajax({
        url: "views/ajax/auth.php",
        type: "POST",
        dataType: "JSON",
        processData: false,
        contentType: false,
        cache: false,
        data: datos
    })
    .done((res)=>{
        $(".message").html("")

        if (!res.status) {
            $(".message").html(`
                <div class="alert alert-danger">
                    ${res.message}
                </div> 
            `)
        }else{
            $(".message").html(`
                <span class="alert alert-success">
                   Información actualizada
                </span> 
            `)        
        }

        setTimeout(()=>{
            $(".message").html("")
        },3000)
        
        console.log(res)
    })
    .fail((error)=>{
        console.log(error)
    })


})

$("#updateP").on("click",function(e){
    e.preventDefault()
    var val = $("#updatePass").val()

    if (val == "false") {
        $("#updatePass").val("true")
        $(".contentPassword").removeClass("hidden")
    }else{
        $("#updatePass").val("false")
        $("#password").val("")
        $(".contentPassword").addClass("hidden")
    }
})

$("#actualizarPassword").on("click",function(e){
    e.preventDefault()


    var datos = new FormData(document.getElementById("cambiarPassword-form"))

    datos.append("actualizar_password", true)
    $(".message").html(`
        <div class="alert alert-primary">
            Procesando...
        </div> 
    `)

    ajax.peticion("FormData",datos, "views/ajax/auth.php")
        .then((res)=>{

            $(".message").html("")

            if (!res.status) {
                $(".message").html(`
                    <div class="alert alert-danger">
                        ${res.message}
                    </div> 
                `)
            }else{
                $(".message").html(`
                    <div class="alert alert-success">
                       Contraseña actualizada
                    </div> 
                `)
            }

            setTimeout(()=>{
                $(".message").html("")
            },3000)
            
            console.log(res)
        },(fail)=>{
            console.log(fail)
        })

})


$("#login").on("click",function(e){
    e.preventDefault()


    var datos = {
        "inicio_sesion": true,
        "email": $("#email").val(),
        "password": $("#password").val(),
        "code_verif": $("#code_verif").val()
    }

    $(".message").html(`
        <div class="text-primary">
            Procesando login...
        </div> 
    `)

    $.ajax({
        url: "views/ajax/auth.php",
        type: "POST",
        dataType: "JSON",
        data: datos
    })
    .done((res)=>{
        $(".message").html("")

        if (!res.status) {
            $(".message").html(`
                <div class="alert alert-danger">
                    ${res.message}
                </div> 
            `)

            if(res.invalid_verification != undefined){
                $("#content-code").removeClass("hidden")
            }

        }else{
            console.log(res)
            window.location.href = "profile"
        }

        setTimeout(()=>{
            $(".message").html("")
        },3000)
        
        console.log(res)
    })
    .fail((fail)=>{
        console.log(fail)
    })


})

$("#resend").on("click",function(e){
    e.preventDefault()


    var datos = {
        "resend": true,
        "email": $("#email").val(),
    }

    $(".message").html(`
        <div class="text-primary">
            Reenviando código...
        </div> 
    `)

    $.ajax({
        url: "views/ajax/auth.php",
        type: "POST",
        dataType: "JSON",
        data: datos
    })
    .done((res)=>{
        $(".message").html("")

            if (!res.status) {
                $(".message").html(`
                    <div class="alert alert-danger">
                        ${res.message}
                    </div> 
                `)

            }else{
                $(".message").html(`
                    <div class="text-success">
                        ¡Código reenviado!
                    </div> 
                `)
            }

            setTimeout(()=>{
                $(".message").html("")
            },3000)
            
            console.log(res)
    })
    .fail((fail)=>{
        console.log(fail)
    })


})