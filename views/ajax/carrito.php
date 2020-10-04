<?php 
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	ini_set('log_errors', 1);
	// session_start();
	require_once '../../controllers/gestorCarrito.php';
	require_once '../../controllers/gestorProductos.php';

	require_once '../../models/conexion.php';
    require_once '../../models/consulta.php';    
	require_once '../../models/gestorCarrito.php';
	require_once '../../models/gestorProductos.php';


class CarritoAjax{

	public function toogleItem(){
		$respuesta = GestorCarritoController::toogleItem();

		echo json_encode($respuesta);
	}

	public function procesarPedido(){
		$respuesta = GestorCarritoController::procesarPedido();

		echo json_encode($respuesta);
	}

	public function change_stock(){

		$respuesta = GestorCarritoController::change_stock($_POST["sku"], $_POST["value"]);

		echo json_encode($respuesta);
	}
	public function deleteFromCart(){
		$respuesta = GestorCarritoController::deleteProductFromCart($_POST["sku"]);

		echo json_encode($respuesta);
	}
	
	public function vaciar(){
		$respuesta = GestorCarritoController::vaciar_carrito();

		echo json_encode($respuesta);
	}

	

}


$a = new CarritoAjax();

	if (isset($_POST["toogleItem"])) {

		$a ->toogleItem();
	}
	if (isset($_POST["change_stock"])) {

		$a ->change_stock();
	}	
	
	if (isset($_POST["procesarPedido"])) {

		$a ->procesarPedido();
	}
	if (isset($_POST["deleteFromCart"])) {

		$a ->deleteFromCart();
	}
	
	if (isset($_POST["vaciar"])) {

		$a ->vaciar();
	}
	
