<?php 
if(!isset($_SESSION)){ 
    session_start(); 
} 
class GestorPedidosController{

	public static function jsonOrders(){

        $pedidos = GestorPedidosModel::jsonOrders();

        for ($i=0; $i < count($pedidos); $i++) { 
            $f = GestorConfigController::ago($pedidos[$i]["fecha"]);
            $pedidos[$i]["fecha"] = $f . " <br>" . $pedidos[$i]["fecha"];
        }
     
		return $pedidos;

    }
    public static function searchCode(){

        $productos = GestorPedidosModel::searchCode();
     
		return $productos;

    }
    
    
    public static function actualizar_estados(){
        $lista = $_POST["lista"];
        $estado = $_POST["estado"];
        return GestorPedidosModel::actualizar_estados($lista, $estado);
    
    }
    
    public static function ver_items_pedido($id){
        return GestorPedidosModel::ver_items_pedido($id);
    }

    public static function borrar_lista_pedidos(){
        $lista = $_POST["lista"];
        return GestorPedidosModel::borrar_lista_pedidos($lista);
    
    }


    
    
}
