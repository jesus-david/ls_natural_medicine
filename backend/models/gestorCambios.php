<?php 

class GestorCambiosModel{

	public static function verCambios(){

		$consulta = new Consulta();

		$cambios = $consulta->ver_registros("select * from historial_cambios inner join productos on historial_cambios.id_producto = productos.idproducto order by historial_cambios.fecha desc");

		for ($i=0; $i < count($cambios); $i++) { 
			
			$id_v = $cambios[$i]["id_variante"];

			$variante = $consulta->ver_registros("select * from combinacion where idcombinacion ='$id_v'");

			$cambios[$i]["variante"] = (isset($variante[0])) ? $variante[0] : [];
		}

		return $cambios;

	}
	public static function borrarHistorial(){

		$consulta = new Consulta();

		$consulta->borrar_registro("delete from historial_cambios");

		return 'ok';

	}

}
