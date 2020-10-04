<?php 
	
	require_once '../../models/conexion.php';
	require_once '../../models/consulta.php';
	require_once '../../models/gestorConfig.php';
	require_once '../../models/gestorPedidos.php';
	require_once '../../models/gestorProductos.php';
	require_once '../../models/gestorNotificaciones.php';
	require_once '../../controllers/gestorConfig.php';
	require_once '../../controllers/gestorPedidos.php';
	require_once '../../controllers/gestorProductos.php';
	require_once '../../controllers/gestorNotificaciones.php';
	require_once '../../controllers/mail.php';


class GestorPedidos{

	public function crear(){
		$respuesta = GestorPedidosController::crear();

		echo json_encode($respuesta);
	}


	public function searchCode(){
		$respuesta = GestorPedidosController::searchCode();

		echo json_encode($respuesta);
	}

	public function borrar_lista_pedidos(){
		$respuesta = GestorPedidosController::borrar_lista_pedidos();

		echo json_encode($respuesta);
	}

	
	public function actualizar_estados(){
		$respuesta = GestorPedidosController::actualizar_estados();

		echo json_encode($respuesta);
	}


	
}


$a = new GestorPedidos();


if (isset($_POST["crear"])) {
	$a->crear();
}


if (isset($_POST["searchCode"])) {
	$a->searchCode();
}


if (isset($_POST["borrar_lista_pedidos"])) {
	$a->borrar_lista_pedidos();
}


if (isset($_POST["actualizar_estados"])) {
	$access = GestorConfigModel::verficar_usuario();
	if (isset($access->updateStateOrder) || $_SESSION["tipo"] == 0) {
		$a->actualizar_estados();
	}else{
		echo json_encode(array("status"=> false, "message" => "no tienes privilegios de actualizar estados de los pedidos"));
	}
    
}

if (isset($_POST["filtrar"])) {
	$_SESSION["filtrarOrders"] = $_POST["search"];
	echo json_encode(array("q" => $_SESSION["filtrarOrders"]));
}


	

