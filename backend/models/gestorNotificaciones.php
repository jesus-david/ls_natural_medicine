<?php 

class GestorNotificacionesModel{

	public static function crear_notificacion($usuario, $tipo, $titulo, $link){

		$consulta = new Consulta();

		$fecha = date("Y-m-d H:i:s");

		$consulta->nuevo_registro("INSERT into notificaciones (id_usuario, tipo, titulo, link,fecha,visto) values('$usuario','$tipo','$titulo','$link','$fecha', '0')");

		$lastId = $consulta->ver_registros("SELECT max(id) as id from notificaciones where id_usuario = '$usuario'");

		$tag_user = $consulta->ver_registros("SELECT tag_on_signal from usuarios where id = '$usuario'");
		
		
		return array("status" => true, "tag" => $tag_user, "id" => $lastId[0]["id"]);

	}
	public static function notificaciones_sin_ver(){

		$consulta = new Consulta();

		$id_usuario = $_SESSION["id_usuario"];
		
		$notificaciones = $consulta->ver_registros("SELECT * from notificaciones where id_usuario = '$id_usuario' AND visto = '0' order by fecha desc");
	
	
		return $notificaciones;

	}
	public static function notificaciones_vistas(){

		$consulta = new Consulta();

		$id_usuario = $_SESSION["id_usuario"];
		
		$notificaciones = $consulta->ver_registros("SELECT * from notificaciones where id_usuario = '$id_usuario' AND visto = '1' order by fecha desc");
	
	
		return $notificaciones;

	}
	
	public static function notificaciones(){

		$consulta = new Consulta();

		$id_usuario = $_SESSION["id_usuario"];
		
		$notificaciones = $consulta->ver_registros("SELECT * from notificaciones where id_usuario = '$id_usuario' order by fecha desc");
	
	
		return $notificaciones;

	}
	public static function 	guardar_tag(){

		$consulta = new Consulta();

		$id_usuario = $_SESSION["id_usuario"];
		$tag = "user_". $id_usuario;

		$consulta->actualizar_registro("UPDATE usuarios set tag_on_signal = '$tag' where id = '$id_usuario'");
	
		$_SESSION['tag_on_signal'] = $tag;
		return array("status" => "ok");

	}

	public static function 	borrar_revisadas(){

		$consulta = new Consulta();

		$id_usuario = $_SESSION["id_usuario"];

		$consulta->borrar_registro("DELETE from notificaciones where id_usuario = '$id_usuario' AND visto = '1'");
	 
		return array("status" => "ok");

	}
	public static function notificacion_vista(){

		$consulta = new Consulta();

		$id = $_POST["id"];
		
		$consulta->actualizar_registro("UPDATE notificaciones set visto = '1' where id = '$id'");
	
	
		return array("status" => "ok");

	}
	
	

	
}
