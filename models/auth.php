<?php 

class AuthModel{


    public static function nuevo_registro(){
        $consulta = new Consulta();

        $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES);
        $apellido = htmlspecialchars($_POST['apellido'], ENT_QUOTES);
        $email = $_POST["email"];
        $telefono = htmlspecialchars($_POST['telefono'], ENT_QUOTES);
        $city = $_POST["city"];
        $direccion = htmlspecialchars($_POST['direccion'], ENT_QUOTES);
        $password = htmlspecialchars($_POST["password"], ENT_QUOTES);
        $fecha = date("Y-m-d H:i:s");
        $crypted = password_hash($password, PASSWORD_DEFAULT);

        $valid = $consulta->ver_registros("SELECT * from clientes where email = '$email'");
        $code = Email::getCode();

        if (!count($valid)) {
            $consulta->nuevo_registro("INSERT into clientes (nombre, apellido,telefono,email, ciudad, direccion, estado,password, token_email, fecha) values ('$nombre', '$apellido', '$telefono', '$email', '$city','$direccion', '0', '$crypted', '$code', '$fecha')");

            $info = $consulta->ver_registros("SELECT max(id) as id from clientes");

            $id = $info[0]["id"];
            
            $consulta->nuevo_registro("INSERT into carrito (id_usuario, items) value('$id', '[]')");

            return array("status" => true, "code" => $code, "datos" => $_POST);

        }else{
            return array("status" => false, "message" => "Este Email ya está registrado");
        }

    }

    public static function actualizar_info(){

        $consulta = new Consulta();

        $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES);
        $apellido = htmlspecialchars($_POST['apellido'], ENT_QUOTES);
        $telefono = htmlspecialchars($_POST['telefono'], ENT_QUOTES);
        $city = $_POST["city"];
        $direccion = htmlspecialchars($_POST['direccion'], ENT_QUOTES);

        $id = $_SESSION["id_usuario"];

        $consulta->actualizar_registro("UPDATE clientes set nombre = '$nombre', telefono='$telefono', apellido ='$apellido', ciudad ='$city', direccion = '$direccion' where id = '$id'");

        $info = $consulta->ver_registros("SELECT * from clientes where id = '$id'");


        $info = count($info) != 0 ? $info[0] : [];

        return array("status" => true, "info" => $info);

    }
    public static function actualizar_password($password, $id){

        $consulta = new Consulta();

        $encriptacion = password_hash($password, PASSWORD_DEFAULT);
       
        $consulta->actualizar_registro("UPDATE clientes set password = '$encriptacion' where id = '$id'");

        return array(
            'status' => true
        );

    

    }
    
    public static function ver_info_usuario($email, $id = false, $carrito = true){

        $consulta = new Consulta();

        if ($id) {
            $info = $consulta->ver_registros("SELECT * from clientes where id = '$id'");
        }else{
            $info = $consulta->ver_registros("SELECT * from clientes where email = '$email'");
        }


        if (isset($info[0])) {
            $id = $info[0]["id"];
            if ($carrito) {
                $carrito = $consulta->ver_registros("SELECT * from carrito where id_usuario = '$id'");
                $info[0]["carrito"] = $carrito[0];
            }
            
        }
        

        $info = count($info) != 0 ? $info[0] : [];

        return $info;

    }

    public static function verificado($email){

        $consulta = new Consulta();

        $consulta->actualizar_registro("UPDATE clientes set estado = '1' where email = '$email'");

    }
    
}