<?php 
if(!isset($_SESSION)){ 
    session_start(); 
} 
class GestorZonasController{

	public static function jsonZones(){

        $zonas = GestorZonasModel::jsonZones();
     
		return $zonas;

    }
    
    public static function zonas(){

        $zonas = GestorZonasModel::zonas();
     
		return $zonas;

    }
    
    public static function crear(){

        $validado = GestorZonasController::validar($_POST);

        if ($validado["status"] == "error") {
            return $validado;
        }else{

            $resp = GestorZonasModel::sim($_POST, "crear");
            return $resp;
        }

        
    }
    public static function actualizar(){

        $validado = GestorZonasController::validar($_POST);

        if ($validado["status"] == "error") {
            return $validado;
        }else{

            $resp = GestorZonasModel::sim($_POST, "actualizar", $_POST["id"]);

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
        }

        return $validado;

    }

    public static function borrar_lista_zonas(){
        $lista = $_POST["lista"];
        return GestorZonasModel::borrar_lista_zonas($lista);
    
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
