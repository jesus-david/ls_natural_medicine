<?php 
session_start();
require_once '../../models/conexion.php';
require_once '../../models/consulta.php';
require_once '../../models/gestorNotificaciones.php';

require_once '../../controllers/gestorNotificaciones.php';

class GestorNotificacionesAjax{


	public function notificacion_vista(){
		$respuesta = GestorNotificacionesController::notificacion_vista();
		echo json_encode($respuesta);
	}

	public function addPageRes(){
		$respuesta = GestorNotificacionesController::add_page_restrinction();
		echo json_encode($respuesta);
	}
	public function guardar_tag(){
		$respuesta = GestorNotificacionesController::guardar_tag();
		echo json_encode($respuesta);
	}

	public function borrar_revisadas(){
		$respuesta = GestorNotificacionesController::borrar_revisadas();
		echo json_encode($respuesta);
	}
	
	

}

$a = new GestorNotificacionesAjax();


if (isset($_POST["notificacion_vista"])) {
	$a -> notificacion_vista();
}

if (isset($_POST["addPageRes"])) {
	$a -> addPageRes();
}

if (isset($_POST["guardar_tag"])) {
	$a -> guardar_tag();
}

if (isset($_POST["borrar_revisadas"])) {
	$a -> borrar_revisadas();
}
