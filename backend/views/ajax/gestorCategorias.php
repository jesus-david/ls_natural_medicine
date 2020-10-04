<?php 
	
	require_once '../../models/conexion.php';
	require_once '../../models/consulta.php';
	require_once '../../models/gestorConfig.php';
	require_once '../../models/gestorCategorias.php';
	require_once '../../controllers/gestorConfig.php';
	require_once '../../controllers/gestorCategorias.php';


class GestorCategorias{

	public function crear(){
		$respuesta = GestorCategoriasController::crear();

		echo json_encode($respuesta);
	}
	public function actualizar(){
		$respuesta = GestorCategoriasController::actualizar();

		echo json_encode($respuesta);
    }
    public function borrar_lista_categorias(){
		$respuesta = GestorCategoriasController::borrar_lista_categorias();

		echo json_encode($respuesta);
	}
	public function borrar_catalogo(){
		$respuesta = GestorCategoriasController::borrar_catalogo();

		echo json_encode($respuesta);
	}

	
	
}


$a = new GestorCategorias();


if (isset($_POST["crear"])) {
	$a->crear();	
}
if (isset($_POST["actualizar"])) {
	$a->actualizar();	
}
if (isset($_POST["borrar_catalogo"])) {
	$access = GestorConfigModel::verficar_usuario();
	if (isset($access->editCompany) || $_SESSION["tipo"] == 0) {
		$a->borrar_catalogo();
	}else{
		echo json_encode(array("status"=> false, "mensaje" => "no tienes privilegios de actualizar empresas"));
	}
	
}

if (isset($_POST["borrar_lista_categorias"])) {
	$a->borrar_lista_categorias();    
}


if (isset($_POST["filtrar"])) {
	$_SESSION["filtrarClients"] = $_POST["search"];
	echo json_encode(array("q" => $_SESSION["filtrarClients"]));
}


	

