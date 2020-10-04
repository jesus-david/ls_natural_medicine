<?php 
	
	require_once '../../models/conexion.php';
	require_once '../../models/consulta.php';
	require_once '../../models/gestorConfig.php';
	require_once '../../models/gestorClientes.php';
	require_once '../../controllers/gestorConfig.php';
	require_once '../../controllers/gestorClientes.php';


class GestorCliente{

	public function crear(){
		$respuesta = GestorClientesController::crear();

		echo json_encode($respuesta);
	}
	public function actualizar(){
		$respuesta = GestorClientesController::actualizar();

		echo json_encode($respuesta);
    }
    public function borrar_lista_clientes(){
		$respuesta = GestorClientesController::borrar_lista_clientes();

		echo json_encode($respuesta);
	}

	//sin uso
	public function actualizar_estados(){
		$respuesta = GestorClientesController::actualizar_estados();

		echo json_encode($respuesta);
	}
	public function actualizar_tipos(){
		$respuesta = GestorClientesController::actualizar_tipos();

		echo json_encode($respuesta);
	}


	
}


$a = new GestorCliente();


if (isset($_POST["crear"])) {
	$a->crear();
}
if (isset($_POST["actualizar"])) {
	$a->actualizar();
}

if (isset($_POST["borrar_lista_clientes"])) {
	$access = GestorConfigModel::verficar_usuario();
	if (isset($access->deleteClient) || $_SESSION["tipo"] == 0) {
		$a->borrar_lista_clientes();
	}else{
		echo json_encode(array("status"=> false, "message" => "no tienes privilegios de borrar clientes"));
	}
    
}

//sin uso
if (isset($_POST["actualizar_estados"])) {
	$access = GestorConfigModel::verficar_usuario();
	if (isset($access->editProduct) || $_SESSION["tipo"] == 0) {
		$a->actualizar_estados();
	}else{
		echo json_encode(array("status"=> false, "message" => "no tienes privilegios de actualizar clientes"));
	}
    
}

if (isset($_POST["actualizar_tipos"])) {
    $a->actualizar_tipos();
}
//------------------

if (isset($_POST["filtrar"])) {
	$_SESSION["filtrarClients"] = $_POST["search"];
	echo json_encode(array("q" => $_SESSION["filtrarClients"]));
}


	

