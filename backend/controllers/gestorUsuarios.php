<?php 
if(!isset($_SESSION)){ 
    session_start(); 
}
class GestorUsuariosController{

	public static function jsonUsers(){

        $users = GestorUsuariosModel::jsonUsers();
        
        for ($i=0; $i < count($users); $i++) { 
            $users[$i]["CompanyAgent"] = $users[$i]["usuario"];
        }

		return $users;

    }

    public static function usuarios(){

        $usuarios = GestorUsuariosModel::usuarios();
     
		return $usuarios;

    }
    public static function rutas(){

        $rutas = GestorUsuariosModel::rutas();
     
		return $rutas;

    }
    public static function mis_clientes(){

        $mis_clientes = GestorUsuariosModel::mis_clientes();
     
		return $mis_clientes;

    }
    public static function pedidos_($id_user, $state = false){

        $pedidos = GestorUsuariosModel::pedidos_($id_user, $state);
     
		return $pedidos;

    }
    public static function crear_peticion(){

        if ($_POST["num_stock"] != "") {
            $resp = GestorUsuariosModel::crear_peticion();
     
            return $resp;
        }else{
            return array("status" => false, "message" => "Ingrese la cantidad de inventario que desea pedir.");
        }
    }

    public static function peticiones(){

        $peticiones = GestorUsuariosModel::peticiones();
     
		return $peticiones;

    }

    public static function verificar_mi_cartera($id){

        $resp = GestorUsuariosModel::verificar_mi_cartera($id);
     
		return $resp;

    }
    
    public static function crear(){

        $validado = GestorUsuariosController::validar($_POST);

        if ($validado["status"] == "error") {
            return $validado;
        }else{
            return GestorUsuariosModel::crear($_POST);
        }

        
    }

    // LA ACTUALIZACION DE LOS USUARIOS LO HACE EL MODULO AUTH

    public static function validar($datos){
        $validado = array(
            "razon" => "",
            "mensaje" => "",
            "status" => "valido"
        );

        if ($datos["nombre"] == "" || $datos["correo"] == "" || $datos["tipo"] == "" || $datos["password"] == "") {
            $validado = array(
                "razon" => "campos vacíos",
                "mensaje" => "Por favor llene todos los campos.",
                "status" => "error"
            );
        }else if (!filter_var($datos["correo"], FILTER_VALIDATE_EMAIL)) {
            $validado = array(
                "status" => "error",
                "razon" => "Email no válido",
                "mensaje" => "Formato de email incorrecto."
            );
        }else if (GestorUsuariosModel::check_email($datos["correo"])) {
            $validado = array(
                "status" => "error",
                "razon" => "Email duplicado",
                "mensaje" => "Este Email ya está asignado a una cuenta."
            );
        }

        return $validado;

    }

    public static function ver_info_usuario($id){
        return GestorUsuariosModel::ver_info_usuario($id);
    }

    public static function borrar_lista_usuarios(){
        $lista = $_POST["lista"];
        return GestorUsuariosModel::borrar_lista_usuarios($lista);
    
    }
    public static function actualizar_estados(){
        $lista = $_POST["lista"];
        $estado = $_POST["estado"];
        return GestorUsuariosModel::actualizar_estados($lista, $estado);
    
    }
    public static function actualizar_tipos(){
        $lista = $_POST["lista"];
        $tipo = $_POST["tipo"];
        return GestorUsuariosModel::actualizar_tipos($lista, $tipo);
    
    }
    public static function cambiarImagenPerfil(){
       

        if (isset($_FILES["imageUser"])) {
            if ($_FILES["imageUser"]["name"] != "") {
                $imagen = $_FILES["imageUser"];
                $oldImage = $_SESSION["imagen"];
                $id_usuario = $_SESSION["id_usuario"];
                //borrar imagen anterior
                if ($oldImage != "") {
                    unlink("../../$oldImage");
                }

                $ruta = "views/images/usuarios/imagen_$id_usuario.jpg";

                move_uploaded_file($imagen["tmp_name"], "../../".$ruta);

                return GestorUsuariosModel::cambiarImagenPerfil($ruta, $id_usuario);

            }else{
                return array("status" => "error", "mensaje" => "selecciona una imagen");
            }
            
        }


    
    }

    
    public static function nueva_ruta(){
        $puntos = $_POST["puntos"];
        $nombre = $_POST["nombre"];
        $id_usuario = $_POST["id_usuario"];
        $id_ruta = $_POST["id_ruta"];
        $saveP = [];
        for ($i=0; $i < count($puntos); $i++) { 
            # code...
            $punto = $puntos[$i];

            array_push($saveP, array(
                "lat" => $punto["lat"],
                "lng" => $punto["lng"]
            ));
        }



        return GestorUsuariosModel::nueva_ruta($saveP, $nombre, $id_usuario, $id_ruta);
    
    }
    public static function borrar_ruta(){
      
        return GestorUsuariosModel::borrar_ruta();
    
    }
    
    public static function ver_rutas($id){
    
        return GestorUsuariosModel::ver_rutas($id);
    
    }
    
    
}
