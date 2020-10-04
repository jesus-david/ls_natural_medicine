<?php 

class GestorZonasModel{

	public static function jsonZones(){

		$consulta = new Consulta();

		$sql = "";
		if (isset($_SESSION["filtrarZones"])) {
			$q = $_SESSION["filtrarZones"];

			$sql = "WHERE nombre like '%$q%' or codigo like '%$q%'"; 
			// echo $sql;
		}
	
		$zonas = $consulta->ver_registros("select * from zonas $sql order by nombre");
		
		return $zonas;

	}
	public static function zonas(){

		$consulta = new Consulta();

		$zonas = $consulta->ver_registros("select * from zonas");
		
		return $zonas;

	}

	//se llama sim porque no se me ocurrió un buen nombre -- CREAR / ACTUALIZAR
	public static function sim($datos, $option, $id = null){

		$consulta = new Consulta();
		$nombre = $datos["nombre"];

		if ($option == "crear") {

			$consulta->nuevo_registro("INSERT into zonas (nombre) values('$nombre')");

			$r = $consulta->ver_registros("SELECT max(id) as id from zonas");
			$id = $r[0]["id"];
		}else if($option == "actualizar"){

			$consulta->actualizar_registro("UPDATE zonas set nombre = '$nombre' where id = '$id'");
						
		}
		
		return array("status" => "ok", "id" => $id);

	}
	public static function ver_info_cliente($id){

        $consulta = new Consulta();

        $info = $consulta->ver_registros("SELECT * from clientes where id = '$id'");

        $info = count($info) != 0 ? $info[0] : [];

        return $info;

	}

	public static function borrar_lista_zonas($lista){

		$consulta = new Consulta();
		
		for ($i=0; $i < count($lista); $i++) { 
			
			$id = $lista[$i];

			$consulta->borrar_registro("DELETE from zonas where id = '$id'");
			
			$consulta->actualizar_registro("UPDATE clientes set id_zona = '0' where id_zona = '$id'");
			
		}

        return array("status" => "ok");

	}
	

	//sin uso
	public static function actualizar_estados($lista, $estado){

		$consulta = new Consulta();
		
		for ($i=0; $i < count($lista); $i++) { 
			
			$id = $lista[$i];
			$consulta->actualizar_registro("UPDATE productos set estado = '$estado' where id = '$id'");

		}

        return array("status" => "ok");

	}
	public static function actualizar_tipos($lista, $tipo){

		$consulta = new Consulta();

		$access = GestorConfigModel::verficar_usuario();

		
		
		for ($i=0; $i < count($lista); $i++) { 
			
			$id = $lista[$i];

			if($_SESSION["tipo"] == 0){
				$consulta->actualizar_registro("UPDATE usuarios set tipo = '$tipo' where id = '$id'");
			}else if (isset($access->listUsers) && $id != $_SESSION["id_usuario"] && $tipo != 0) {
				$consulta->actualizar_registro("UPDATE usuarios set tipo = '$tipo' where id = '$id'");
			}

			

		}

        return array("status" => "ok");

	}
	
	

	
}
