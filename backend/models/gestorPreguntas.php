<?php 

class GestorPreguntasModel{

	public static function jsonPreguntas(){

		$consulta = new Consulta();

		$sql = "";
		if (isset($_SESSION["filtrarPreguntas"])) {
			$q = $_SESSION["filtrarPreguntas"];

			$sql = "WHERE contenido like '%$q%'"; 
			// echo $sql;
		}
	
		$preguntas = $consulta->ver_registros("select * from preguntas $sql");

		for ($i=0; $i < count($preguntas); $i++) { 

			$id_cliente = $preguntas[$i]["id_cliente"];
			$id_producto = $preguntas[$i]["id_producto"];

			$producto = $consulta->ver_registros("SELECT * from productos where id = '$id_producto'");
			$cliente = $consulta->ver_registros("SELECT * from clientes where id = '$id_cliente'");

			$preguntas[$i]["producto"] = $producto[0];
			$preguntas[$i]["cliente"] = $cliente[0];
		}

		
		return $preguntas;

	}
	public static function clientes(){

		$consulta = new Consulta();

		$clientes = $consulta->ver_registros("select * from clientes");
		
		return $clientes;

	}
	
	public static function borrar_lista($lista){

		$consulta = new Consulta();

		// return $lista;
		
		for ($i=0; $i < count($lista); $i++) { 
			
			$id = $lista[$i];

			$consulta->borrar_registro("DELETE from preguntas where id = '$id'");
			
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

	public static function answer(){

		$consulta = new Consulta();

		$id_pregunta = $_POST["id_pregunta"];
		$repuesta = htmlspecialchars($_POST["repuesta"], ENT_QUOTES);
		$hoy = date("Y-m-d H:i:s");

		$consulta->nuevo_registro("UPDATE preguntas set respuesta = '$repuesta', fecha_respuesta = '$hoy' where id = $id_pregunta");

		$info = $consulta->ver_registros("SELECT * from preguntas where id = '$id_pregunta'");

		$id_cliente = $info[0]["id_cliente"];

		$cliente = $consulta->ver_registros("SELECT * from clientes where id = '$id_cliente'");

		return array("cliente" => $cliente[0], "id_producto" => $info[0]["id_producto"]);

	}

}
