<?php
if(!isset($_SESSION)){ 
    session_start(); 
}
class AuthController {

    public static function nuevo_registro(){
        $validado = AuthController::validarRegistro($_POST);
        if($validado["status"]){
            $resp = AuthModel::nuevo_registro();

            if ($resp["status"]) {
                $template = AuthController::templateCode($resp["code"]);

                $sended = Email::sendMail($_POST["email"], $_POST["nombre"], "Verificar cuenta", $template);

                return $sended;
            }else{
                return $resp;
            }
            

            
        }else{
            return $validado;
        }
    }

    public static function templateCode($code){

        return '

        <body style="margin: 0; padding: 0;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
                <tr>
                    <td style="padding: 10px 0 30px 0;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                            <tr>
                                <td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/h1.gif" alt="Creating Email Magic" width="300" height="230" style="display: block;" />
                                </td>
                            </tr>
                            <tr>
                                <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                                <b>¡Bienvenido a Natural Medicine!</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                Copia y pega el siguiente código en el formulario de Login para validar tu cuenta. <br><br>

                                                Código: <b>'.$code.'</b>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        ';
    }

	public static function validarRegistro($datos, $pass = true, $mail = true){
        
        
        if ($datos["nombre"] != "" && $datos["telefono"] != ""  && $datos["city"] != "#" && $datos["apellido"] != "") {
            
            if ($pass) {
                if ($datos["password"] == "") {
                    return array(
                        "status" => false,
                        "message" => "Ingrese todos los campos requeridos.",
                        "datos" => $datos,
                    );
                }
            }
            if ($mail) {
                if ($datos["email"] == "") {
                    return array(
                        "status" => false,
                        "message" => "Ingrese todos los campos requeridos.",
                        "datos" => $datos,
                    );
                }
                if (!filter_var($datos["email"], FILTER_VALIDATE_EMAIL)) {
                    return array(
                        "status" => false,
                        "message" => "Formato de email incorrecto.",
                        "datos" => $datos
                    );
                }
            }
        
            return array(
                "status" => true,
                "message" => "Go.",
                "datos" => $datos
            );

        }else{
          
            return array(
                "status" => false,
                "message" => "Ingrese todos los campos requeridos.",
                "datos" => $datos
            );
        }
        
    }

    //inicio session

    public static function resend(){
        $email = $_POST["email"];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return array(
                "status" => false,
                "message" => "Formato de email incorrecto.",
                "datos" => $datos
            );
        }

        $info = AuthModel::ver_info_usuario($email);

        if ($info != []) {
            $template = AuthController::templateCode($info["token_email"]);

            $sended = Email::sendMail($info["email"], $info["nombre"], "Verificar cuenta", $template);

            return $sended;
            
        }else{
            return array(
                "status" => false,
                "message" => "Este email no corresponde a ninguna cuenta."
            );
        }
    }

    public static function inicio_sesion(){
        $validado = AuthController::validarLogin($_POST);
        if($validado["status"]){
            $session= AuthController::sessions($validado["datos"]);

            return array(
                "status" => true,
                "session" => $session
            );
        }else{
            return $validado;
        }
    }


    public static function validarLogin($datos){
        

        if ($datos["email"] != "" && $datos["password"] != "") {
            
           if (!filter_var($datos["email"], FILTER_VALIDATE_EMAIL)) {
                return array(
                    "status" => false,
                    "message" => "Formato de email incorrecto.",
                    "datos" => $datos
                );
            }else{

                $info = AuthModel::ver_info_usuario($datos["email"]);

                if ($info != []) {
                    if($info["estado"] == "0"){

                        if ($datos["code_verif"] == $info["token_email"]) {
                            AuthModel::verificado($datos["email"]);    
                        }else{
                            $mensaje = ($datos["code_verif"] == "") ? "Ingresa el código de verificación." : "Código incorrecto.";
                           
                            return array(
                                "status" => false,
                                "message" => $mensaje,
                                "invalid_verification" => true,
                                "datos" => $datos
                            );
                        }
                       
                    }
                    
                    if($info["estado"] == "-1"){
                        return array(
                            "status" => false,
                            "message" => "Tu cuenta ha sido bloqueada.",
                            "datos" => $datos
                        );
                    }
                        
                    if (!password_verify($datos["password"], $info["password"])) {
                        return array(
                            "status" => false,
                            "message" => "Contraseña incorrecta.",
                            "datos" => $datos
                        );
                    }
                    return array(
                        "status" => true,
                        "message" => "Go.",
                        "datos" => $info
                    );
                    
                }else{
                    return array(
                        "status" => false,
                        "message" => "Este email no corresponde a ninguna cuenta.",
                        "datos" => $datos
                    );
                }
                
            }

        }else{
            return array(
                "status" => false,
                "message" => "Ingrese todos los campos requeridos.",
                "datos" => $datos
            );
        }
    }

    //actualizar informacion

    public static function actualizar_info(){
        $validado = AuthController::validarRegistro($_POST, false, false);

        if($validado["status"]){
            $res = AuthModel::actualizar_info($validado["datos"]);

            AuthController::sessions($res["info"], false);
            
            return $res;
        }else{
            return $validado;
        }
    }

    public static function actualizar_password(){
        if($_POST["passwordActual"] != "" && $_POST["passwordNueva"] != ""){

            if (password_verify($_POST["passwordActual"],$_SESSION["password"])) {
                $res = AuthModel::actualizar_password($_POST["passwordNueva"]);

                $info = AuthModel::ver_info_cliente($_SESSION["email"]);

                AuthController::sessions($info);

                return $res;
                # code...
            }else{
                return array(
                    "status" => false,
                    "message" => "Contraseña actual incorrecta."
                );
            }

           
        }else{
            return array(
                "status" => false,
                "message" => "Ingrese todos los campos requeridos."
            );
        }
    }

    public static function ver_info_usuario($id, $carrito = true){
        return AuthModel::ver_info_usuario(false, $id, $carrito);
    }

    public static function sessions($datos, $carrito = true){


        $_SESSION["logged"] = true;
        $_SESSION["id_usuario"] = $datos["id"];
        $_SESSION["usuario"] = ucwords($datos["nombre"]) . " " . ucwords($datos["apellido"]);
        $_SESSION["nombre"] = $datos["nombre"];
        $_SESSION["apellido"] = $datos["apellido"];
        $_SESSION["email"] = $datos["email"];
        $_SESSION["telefono"] = $datos["telefono"];
        $_SESSION["city"] = $datos["ciudad"];
        $_SESSION["direccion"] = $datos["direccion"];
        $_SESSION["estado"] = $datos["estado"];

        if ($carrito) {
            $_SESSION["carrito"] = json_decode($datos["carrito"]["items"]);
        }
        
        return $_SESSION;
    }
}