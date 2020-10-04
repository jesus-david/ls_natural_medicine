<?php 
session_start();
require_once '../../models/conexion.php';
require_once '../../models/consulta.php';
require_once '../../models/gestorConfig.php';

require_once '../../controllers/gestorConfig.php';

class GestorConfigAjax{


	public function update_field_config(){
		$respuesta = GestorConfigController::update_field_config();
		echo json_encode($respuesta);
	}

	public function addPageRes(){
		$respuesta = GestorConfigController::add_page_restrinction();
		echo json_encode($respuesta);
	}

	public function update_config_user(){
		$respuesta = GestorConfigController::update_field_config_user();
		echo json_encode($respuesta);
	}
	
	

}

$config = new GestorConfigAjax();


if (isset($_POST["update_field_config"])) {
	$config -> update_field_config();
}

if (isset($_POST["addPageRes"])) {
	$config -> addPageRes();
}
if (isset($_POST["update_config_user"])) {
	$config -> update_config_user();
}
