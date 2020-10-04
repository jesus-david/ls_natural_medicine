<?php 
session_start();
require_once '../../models/conexion.php';
require_once '../../models/consulta.php';
require_once '../../models/gestorPreguntas.php';
require_once '../../models/gestorProductos.php';

require_once '../../controllers/gestorPreguntas.php';
require_once '../../controllers/gestorProductos.php';
require_once '../../controllers/mail.php';

class GestorPreguntasAjax{


	public function answer(){
		$respuesta = GestorPreguntasController::answer();
	
		echo json_encode($respuesta);
	}
	public function borrar_lista(){
		$respuesta = GestorPreguntasController::borrar_lista();
	
		echo json_encode($respuesta);
	}
	
}

$config = new GestorPreguntasAjax();


if (isset($_POST["answer"])) {
	$config -> answer();
}

if (isset($_POST["borrar_lista"])) {
	$config -> borrar_lista();
}
