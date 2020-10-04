<?php 

class GestorUsuariosModel{

	public static function jsonUsers(){

		$consulta = new Consulta();
		$myId = $_SESSION["id_usuario"];
		$sql = "";
		if (isset($_SESSION["filtroUsers"])) {
			$q = $_SESSION["filtroUsers"];

			$sql = " AND (usuario like '%$q%' or correo like '%$q%')"; 
			// echo $sql;
		}
		

		if($_SESSION["tipo"] == 0){
			$users = $consulta->ver_registros("select * from usuarios where id != '$myId' $sql");
		}else{
			$users = $consulta->ver_registros("select * from usuarios where id != '$myId' AND tipo != '0' $sql");
		}

		
		// "SELECT * from usuarios"
		return $users;

	}

	public static function usuarios(){

		$consulta = new Consulta();

		$usuarios = $consulta->ver_registros("select * from usuarios");
		
		return $usuarios;

	}
	public static function rutas(){

		$consulta = new Consulta();

		$rutas = $consulta->ver_registros("select * from rutas");
		
		return $rutas;

	}

	public static function pedidos_($id_user, $state){

		$consulta = new Consulta();
		if ($state) {
			$pedidos = $consulta->ver_registros("SELECT * from pedidos where id_usuario = '$id_user' AND procesado = '$state'");
		}else{
			$pedidos = $consulta->ver_registros("SELECT * from pedidos where id_usuario = '$id_user'");
		}
		
		
		return $pedidos;
		
	}
	
	//actualizar está en Auth
	public static function crear($datos){

		$consulta = new Consulta();
		$nombre = htmlspecialchars($datos["nombre"], ENT_QUOTES);
		$correo = $datos["correo"];
		$tipo = $datos["tipo"];
		$password = $datos["password"];
		

		$encrypt = password_hash($password, PASSWORD_DEFAULT);
				
		$consulta->nuevo_registro("INSERT into usuarios (usuario, correo,imagen, tipo, estado, password, tag_on_signal) values('$nombre', '$correo','', '$tipo','1', '$encrypt', '')");

		$idLast = $consulta->ver_registros("SELECT max(id) as id from usuarios");
		$_id = $idLast[0]["id"];

		$init_config = json_encode(array(
			"type_money" => "Bs",
			"rate" => "",
			"payAtHome" => "false",
			"receiveNotyByDay" => "true"

		));

		$consulta->nuevo_registro("INSERT into config (config_name, config_value, config_code) values ('config_user_$_id', '$init_config', 'USERS_CONFIG')");

		return array("status" => "ok");

	}

	public static function check_email($email){
		$consulta = new Consulta();
		$user = $consulta->ver_registros("SELECT correo from usuarios where correo = '$email'");

		if(count($user) != 0){
			return true;
		}else{
			return false;
		}
	}

	public static function ver_info_usuario($id){

        $consulta = new Consulta();

		$info = $consulta->ver_registros("SELECT * from usuarios where id = '$id'");
		


		$info = count($info) != 0 ? $info[0] : [];
		$info["cartera"] = ["nombre" => ""];

        return $info;

	}
	
	public static function borrar_lista_usuarios($lista){

		$consulta = new Consulta();
		
		for ($i=0; $i < count($lista); $i++) { 
			
			$id = $lista[$i];

			$productos = $consulta->ver_registros("SELECT id from productos where id_usuario = '$id'");

			$consulta->borrar_registro("DELETE from usuarios where id = '$id'");

	
			$consulta->borrar_registro("DELETE from notificaciones where id_usuario = '$id'");
			$consulta->borrar_registro("DELETE from config where config_name = 'config_user_$_id'");
			GestorProductosModel::borrar_lista_productos($productos);


			
		}

        return array("status" => "ok");

	}
	
	public static function actualizar_estados($lista, $estado){

		$consulta = new Consulta();
		
		for ($i=0; $i < count($lista); $i++) { 
			
			$id = $lista[$i];
			$consulta->actualizar_registro("UPDATE usuarios set estado = '$estado' where id = '$id'");

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


			if ($tipo == '0') {
				GestorNotificacionesController::crear_notificacion($id, "estado_usuario", "¡Tu rango de usuario ha sido actualizado a Master!", "profile");
			}else if ($tipo == '1') {
				GestorNotificacionesController::crear_notificacion($id, "estado_usuario", "¡Tu rango de usuario ha sido actualizado a Administrador!", "profile");
			}else{
				GestorNotificacionesController::crear_notificacion($id, "estado_usuario", "¡Tu rango de usuario ha sido actualizado a Vendedor!", "profile");
			}
			

		}

        return array("status" => "ok");

	}
	
	public static function cambiarImagenPerfil($ruta, $id){

		$consulta = new Consulta();
		
		$consulta->borrar_registro("UPDATE usuarios set imagen = '$ruta' where id = '$id'");

		$_SESSION["imagen"] = $ruta;

        return array("status" => "ok");

	}
	
	public static function nueva_ruta($saveP, $nombre, $id_usuario, $id_ruta){

		$consulta = new Consulta();

		$str = json_encode($saveP);
		$hoy = date("Y-m-d");
		$frecuencia = $_POST["frecuencia"];
		

		if ($id_ruta != "false") {
			$consulta->actualizar_registro("UPDATE rutas set nombre='$nombre', puntos ='$str', frecuencia = '$frecuencia' where id = '$id_ruta'");

			GestorNotificacionesController::crear_notificacion($id_usuario, "ruta", "¡Tu ruta $nombre ha sido actualizada!", "myRoutes");

			return array("status" => "ok", "message" => "¡La ruta ha sido actualizada con éxito!");
		}else{
			$consulta->nuevo_registro("INSERT into rutas (id_usuario, nombre, puntos, frecuencia, fecha_creada) values('$id_usuario', '$nombre', '$str', '$frecuencia', '$hoy')");

			GestorNotificacionesController::crear_notificacion($id_usuario, "ruta", "¡Se te ha asignado una nueva ruta!", "myRoutes");

			return array("status" => "ok", "message" => "¡La ruta ha sido agregada con éxito!");
		}

		

		

	}
	public static function borrar_ruta(){

		$consulta = new Consulta();

		$id = $_POST["id_usuario"];

		$consulta->borrar_registro("DELETE from rutas where id = '$id'");
		

		return array("status" => "ok");

	}
	
	public static function ver_rutas($id){

        $consulta = new Consulta();

		$user = $consulta->ver_registros("SELECT * from usuarios where id = '$id'");
		$rutas = $consulta->ver_registros("SELECT * from rutas where id_usuario = '$id'");
		
		if(isset($user[0])){
			for ($i=0; $i < count($rutas); $i++) { 
				$rutas[$i]["array"] = (array) json_decode($rutas[$i]["puntos"]);
			}

			return $rutas;
		}

        

	}

}
