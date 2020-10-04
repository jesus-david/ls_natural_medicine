<?php 
if(!isset($_SESSION)){ 
    session_start(); 
} 
class GestorEstadisticasController{

	public static function productosMasVendidos(){

        $data = GestorEstadisticasModel::productosMasVendidos();
     
		return $data;

    }
    
    public static function vendedoresMasVentas(){

        $data = GestorEstadisticasModel::vendedoresMasVentas();
     
		return $data;

    }

    public static function clientesMasPedidos(){

        $data = GestorEstadisticasModel::clientesMasPedidos();
     
		return $data;

    }
    
  

    
    
}
