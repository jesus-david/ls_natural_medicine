<?php 
	// session_start();
	require_once '../../models/conexion.php';
	require_once '../../models/consulta.php';
	require_once '../../models/auth.php';
	require_once '../../controllers/auth.php';
    require_once '../../controllers/mail.php';


class AuthAjax{

	public function nuevo_registro(){
		$respuesta = AuthController::nuevo_registro();

		echo json_encode($respuesta);
	}

	public function inicio_sesion(){
		$respuesta = AuthController::inicio_sesion();

		echo json_encode($respuesta);
	}

	public function resend(){
		$respuesta = AuthController::resend();

		echo json_encode($respuesta);
	}
	
	public function actualizar_info(){
		$respuesta = AuthController::actualizar_info();

		echo json_encode($respuesta);
	}
	public function actualizar_password(){
		$respuesta = AuthController::actualizar_password();

		echo json_encode($respuesta);
	}
	
	

}


$a = new AuthAjax();

	if (isset($_POST["nuevo_registro"])) {
		$a ->nuevo_registro();
	}

	if (isset($_POST["inicio_sesion"])) {
		$a ->inicio_sesion();
	}

	if (isset($_POST["resend"])) {
		$a ->resend();
	}

	if (isset($_POST["actualizar_info"])) {
		$a ->actualizar_info();
	}

	if (isset($_POST["actualizar_password"])) {
		$a ->actualizar_password();
	}
	
	
