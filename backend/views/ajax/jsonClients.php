<?php 
	// session_start();
	require_once '../../models/conexion.php';
	require_once '../../models/consulta.php';
	require_once '../../controllers/gestorClientes.php';
	require_once '../../models/gestorClientes.php';


class  JsonClientsAjax{

	public function jsonClients(){
		$respuesta = GestorClientesController::jsonClients();


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


$a = new JsonClientsAjax();

$a ->jsonClients();
	

