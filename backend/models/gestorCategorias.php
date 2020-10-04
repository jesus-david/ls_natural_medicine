<?php 

class GestorCategoriasModel{

	public static function jsonCategories(){

		$consulta = new Consulta();

		$id = $_SESSION["id_usuario"];

		$categorias = $consulta->ver_registros("SELECT * from categorias order by nombre");


		return $categorias;

	}
	public static function categorias(){

		$consulta = new Consulta();
		$id_u = $_SESSION["id_usuario"];

		$categorias = $consulta->ver_registros("SELECT * from categorias");
		
		return $categorias;

	}

	//se llama sim porque no se me ocurrió un buen nombre -- CREAR / ACTUALIZAR
	public static function sim($datos, $option, $id = null){

		$consulta = new Consulta();
		$nombre = $datos["nombre"];
		$id_u = $_SESSION["id_usuario"];

		if ($option == "crear") {

			$consulta->nuevo_registro("INSERT into categorias (nombre,id_usuario) values('$nombre', '$id_u')");

		}else if($option == "actualizar"){

			$consulta->actualizar_registro("UPDATE categorias set nombre = '$nombre' where id = '$id'");
						
		}
		
		return array("status" => "ok");

	}

	public static function borrar_lista_categorias($lista){

		$consulta = new Consulta();
		
		for ($i=0; $i < count($lista); $i++) { 
			
			$id = $lista[$i];

			$consulta->borrar_registro("DELETE from categorias where id = '$id'");

			
		}

        return array("status" => "ok");

	}
	public static function borrar_catalogo(){

		$consulta = new Consulta();
		$id = $_POST["id"];
		
		$info = $consulta->ver_registros("SELECT * from catalogos where id = '$id'");

		$consulta->borrar_registro("DELETE from catalogos where id = '$id'");

		if (isset($info[0])) {
			if (file_exists("../../".$info[0]["ruta"])) {
				unlink("../../".$info[0]["ruta"]);
			}
		}

        return array("status" => "ok");

	}
	
	public static function ver_ultimo_archivo($id){

		$consulta = new Consulta();

		$order = $consulta -> ver_registros("select MAX(id) as orden from catalogos where id_empresa = '$id'");

		if (isset($order[0])) {
			$orden = $order[0]["orden"];
		}else {
			$orden = 0;
		}

		return $orden;
	}
	public static function guardar_files($files, $img_principal, $id){

		$consulta = new Consulta();

		$length = count($files);


		// $contador = $order
		for ($i=0; $i < $length; $i++) { 

	
			$path = $files[$i]["path"];
			$name = $files[$i]["type"];

			$consulta -> nuevo_registro("insert into catalogos (id_empresa,ruta) values ('$id','$path')");
		}

		return 'ok';

	}

	
}
