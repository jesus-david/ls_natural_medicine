<?php 
	// session_start();
	require_once '../../models/conexion.php';
	require_once '../../models/consulta.php';
	require_once '../../models/gestorConfig.php';
	require_once '../../controllers/gestorConfig.php';
	require_once '../../controllers/gestorPedidos.php';
	require_once '../../models/gestorPedidos.php';


class  JsonOrdersAjax{

	public function jsonOrders(){
		$respuesta = GestorPedidosController::jsonOrders();


		$resp = array(
			"meta" => [
				"page" => 1,
				"pages"=> 1,
				"perpage"=>-1,
				"total"=> count($respuesta),
				"sort"=>"asc",
				"field"=>"id"
			],
			"data" => $respuesta
		);
		echo json_encode($resp);
	}



}


$a = new JsonOrdersAjax();

$a ->jsonOrders();
	

