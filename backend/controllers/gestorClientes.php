<?php 
if(!isset($_SESSION)){ 
    session_start(); 
} 
class GestorClientesController{

	public static function jsonClients(){

        $clientes = GestorClientesModel::jsonClients();
     
		return $clientes;

    }
    
    public static function clientes(){

        $clientes = GestorClientesModel::clientes();
     
		return $clientes;

    }
    public static function clientes_routes(){

        $clientes = GestorClientesModel::clientes_routes();
     
		return $clientes;

    }
    
    public static function crear(){

        $validado = GestorClientesController::validar($_POST);

        if ($validado["status"] == "error") {
            return $validado;
        }else{

            $resp = GestorClientesModel::sim($_POST, "crear");
            return $resp;
        }

        
    }
    public static function actualizar(){

        $validado = GestorClientesController::validar($_POST);

        if ($validado["status"] == "error") {
            return $validado;
        }else{

            $resp = GestorClientesModel::sim($_POST, "actualizar", $_POST["id"]);

            return $resp;
        }

        
    }
    
    public static function ver_info_cliente($id){
        return GestorClientesModel::ver_info_cliente($id);
    }

    public static function validar($datos){
        $validado = array(
            "razon" => "",
            "mensaje" => "",
            "status" => "valido"
        );

        if ($datos["nombre"] == "") {
            $validado = array(
                "razon" => "campos vacíos",
                "mensaje" => "Por favor llene los campos, requeridos",
                "status" => "error"
            );
        }else if (!filter_var($datos["email"], FILTER_VALIDATE_EMAIL) && $datos["email"] != "") {
            $validado = array(
                "status" => "error",
                "razon" => "Email no válido",
                "mensaje" => "Formato de email incorrecto."
            );
        }

        return $validado;

    }

    public static function borrar_lista_clientes(){
        $lista = $_POST["lista"];
        return GestorClientesModel::borrar_lista_clientes($lista);
    
    }

    //sin uso
    public static function actualizar_estados(){
        $lista = $_POST["lista"];
        $estado = $_POST["estado"];
        return GestorProductosModel::actualizar_estados($lista, $estado);
    
    }
    public static function actualizar_tipos(){
        $lista = $_POST["lista"];
        $tipo = $_POST["tipo"];
        return GestorUsuariosModel::actualizar_tipos($lista, $tipo);
    
    }
    
    
}
