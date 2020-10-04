<?php 
	// session_start();
	require_once '../../models/conexion.php';
	require_once '../../models/consulta.php';
	require_once '../../controllers/gestorPreguntas.php';
	require_once '../../models/gestorPreguntas.php';


class  JsonPreguntasAjax{

	public function jsonPreguntas(){
		$respuesta = GestorPreguntasController::jsonPreguntas();


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


$a = new JsonPreguntasAjax();

$a ->jsonPreguntas();
	

