<?php 
	if(!isset($_SESSION)){ 
		session_start(); 
	}
	require_once '../../models/conexion.php';
	require_once '../../models/consulta.php';
	require_once '../../models/gestorProductos.php';
	require_once '../../controllers/gestorProductos.php';
	require_once '../../controllers/mail.php';


class GestorProductosAjax{


	public function ask(){
		$respuesta = GestorProductosController::ask();
	
		echo json_encode($respuesta);
	}
}


$a = new GestorProductosAjax();

if (isset($_POST["ask"])) {
	$a->ask();
}
if (isset($_POST["setFilter"])) {

	$key = $_POST["key"];
	$value = $_POST["value"];
	$_SESSION[$key] = $value;

	echo json_encode(array("status" => true, "s" => $_SESSION[$key], "key" =>$key));
}
if (isset($_POST["setFilters"])) {

	$items = $_POST["items"];


	for($i = 0; $i < count($items); $i++){
		$key = $items[$i]["key"];
		$value = $items[$i]["value"];
		$_SESSION[$key] = $value;
	}

	

	echo json_encode(array("status" => true, "x" => $items));
}


	

