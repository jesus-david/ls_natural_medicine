<?php 
	// session_start();
	require_once '../../models/conexion.php';
	require_once '../../models/consulta.php';
	require_once '../../controllers/gestorCategorias.php';
	require_once '../../models/gestorCategorias.php';


class  JsonCategoriesAjax{

	public function jsonCategories(){
		$respuesta = GestorCategoriasController::jsonCategories();


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


$a = new JsonCategoriesAjax();

$a ->jsonCategories();
	

