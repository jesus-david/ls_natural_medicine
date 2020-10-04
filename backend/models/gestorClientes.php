<?php 

class GestorClientesModel{

	public static function jsonClients(){

		$consulta = new Consulta();

		$sql = "";
		if (isset($_SESSION["filtrarClients"])) {
			$q = $_SESSION["filtrarClients"];

			$sql = "WHERE nombre like '%$q%' or apellido like '%$q%' or email like '%$q%' or direccion like '%$q%'"; 
			// echo $sql;
		}
	
		$clientes = $consulta->ver_registros("select * from clientes $sql");

	
		
		return $clientes;

	}
	public static function clientes(){

		$consulta = new Consulta();

		$clientes = $consulta->ver_registros("select * from clientes");
		
		return $clientes;

	}
	

	//se llama sim porque no se me ocurrió un buen nombre -- CREAR / ACTUALIZAR
	public static function sim($datos, $option, $id = null){

		$consulta = new Consulta();
		$nombre = $datos["nombre"];
		$telefono = $datos["telefono"];
		$email = $datos["email"];
		$direccion = $datos["direccion"];
		$estado = $datos["estado"];
		$latlng = $datos["latlng"];
		$zona = $datos["id_zona"];
		
		//no se usa el crear
		if ($option == "crear") {
			$consulta->nuevo_registro("INSERT into clientes (nombre, telefono, email,id_zona,direccion, lat_lng, estado) values('$nombre', '$telefono', '$email','$zona', '$direccion','$latlng', '1')");

			$r = $consulta->ver_registros("SELECT max(id) as id from clientes");
			$id = $r[0]["id"];
		}else if($option == "actualizar"){

			$consulta->actualizar_registro("UPDATE clientes set nombre = '$nombre', telefono = '$telefono', email = '$email', direccion = '$direccion', id_zona = '$zona', lat_lng = '$latlng', estado = '$estado' where id = '$id'");
						
		}
		
		return array("status" => "ok", "id" => $id);

	}
	public static function ver_info_cliente($id){

        $consulta = new Consulta();

        $info = $consulta->ver_registros("SELECT * from clientes where id = '$id'");

        $info = count($info) != 0 ? $info[0] : [];

        return $info;

	}

	public static function borrar_lista_clientes($lista){

		$consulta = new Consulta();

		// return $lista;
		
		for ($i=0; $i < count($lista); $i++) { 
			
			$id = $lista[$i];

			$consulta->borrar_registro("DELETE from clientes where id = '$id'");
			$pedidos = $consulta->ver_registros("SELECT * from pedidos where id_comprador = '$id'");

			for ($i=0; $i < count($pedidos); $i++) { 
				$id_pedido = $pedidos[$i]["id"];
				$consulta->borrar_registro("DELETE from items_pedidos where id_pedido = '$id_pedido'");
			}
			$consulta->borrar_registro("DELETE from pedidos where id_comprador = '$id'");

			
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
