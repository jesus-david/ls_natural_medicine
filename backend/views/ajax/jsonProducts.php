<?php 
	// session_start();
	require_once '../../models/conexion.php';
	require_once '../../models/consulta.php';
	require_once '../../controllers/gestorProductos.php';
	require_once '../../models/gestorProductos.php';


class  JsonProductsAjax{

	public function jsonProducts(){
		$respuesta = GestorProductosController::jsonProducts();


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


$a = new JsonProductsAjax();

$a ->jsonProducts();
	

