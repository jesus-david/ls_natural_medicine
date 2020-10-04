<?php

class GestorCategoriasModel{

	public static function verCategorias(){
		$consulta = new Consulta();

		$categorias = $consulta -> ver_registros("SELECT * FROM categorias");

		for($i = 0; $i < count($categorias); $i++){
			$item = $categorias[$i];
			$id = $item["id"];

			$productos = $consulta -> ver_registros("SELECT * FROM productos where categorias like '%$id%'");

			$categorias[$i]["productos"] = $productos;
			$categorias[$i]["total"] = count($productos);
		}
		foreach ($categorias as $key => $row) {
			$aux[$key] = $row['total'];
		}
		array_multisort($aux, SORT_DESC, $categorias);

		return $categorias;
	}

	public static function verCategoriaUnica($id){
		$consulta = new Consulta();

		$categoria = $consulta -> ver_registros("SELECT * FROM categorias where id = '$id'");
		if (isset($categoria[0])) {
			$nombre = $categoria[0]["nombre"];
			$padre = [];
			$hijas = $consulta -> ver_registros("SELECT * FROM categorias where padre = '$nombre'");

			if ($categoria[0]["padre"] != "no") {
				$nombrePadre = $categoria[0]["padre"];
				$padre = $consulta -> ver_registros("SELECT * FROM categorias where nombre = '$nombrePadre'");
			}
			

			$categoria[0]["hijas"] = $hijas;
			$categoria[0]["info_padre"] = (isset($padre[0])) ? $padre[0] : [];

			return $categoria;
		}else{
			return null;
		}
		
	}

}


?>