<?php 
	
	require_once '../../models/conexion.php';
	require_once '../../models/consulta.php';
	require_once '../../models/gestorConfig.php';
	require_once '../../models/gestorProductos.php';
	require_once '../../controllers/gestorConfig.php';
	require_once '../../controllers/gestorProductos.php';


class GestorProducto{

	public function crear(){
		$respuesta = GestorProductosController::crear();

		echo json_encode($respuesta);
	}
	public function actualizar(){
		$respuesta = GestorProductosController::actualizar();

		echo json_encode($respuesta);
	}
	public function verDetalles(){
		$respuesta = GestorProductosController::ver_info_producto($_POST["id"]);

		echo json_encode($respuesta);
    }
    public function borrar_lista_productos(){
		$respuesta = GestorProductosController::borrar_lista_productos();

		echo json_encode($respuesta);
	}

	public function actualizar_estados(){
		$respuesta = GestorProductosController::actualizar_estados();

		echo json_encode($respuesta);
	}
	public function actualizar_tipos(){
		$respuesta = GestorProductosController::actualizar_tipos();

		echo json_encode($respuesta);
	}

	public function cambiarImagenPerfil(){
		$respuesta = GestorProductosController::cambiarImagenPerfil();

		echo json_encode($respuesta);
	}

	public static function add_files_product(){
		$respuesta = GestorProductosController::add_files_product();
		echo json_encode($respuesta);
	}
	public static function borrar_file(){
		$respuesta = GestorProductosController::borrar_file();
		echo json_encode($respuesta);
	}

	public function verImagenesSlide(){
		$respuesta = GestorProductosController::verImagenesSlide();
	
		echo json_encode($respuesta);
	}

	public function sku_update(){
		$respuesta = GestorProductosController::sku_update();

		echo json_encode($respuesta);
	}
	public function sku_update_all(){
		$respuesta = GestorProductosController::sku_update_all();

		echo json_encode($respuesta);
	}
	

	
}


$a = new GestorProducto();



if (isset($_POST["crear"])) {
	$a->crear();
}
if (isset($_POST["actualizar"])) {
	$a->actualizar();
}
if (isset($_POST["verDetalles"])) {
	$a->verDetalles();
}
if (isset($_POST["sku_update"])) {
	$a->sku_update();
}
if (isset($_POST["sku_update_all"])) {
	$a->sku_update_all();
}

if (isset($_POST["borrar_lista_productos"])) {
	$access = GestorConfigModel::verficar_usuario();
	if (isset($access->deleteProduct) || $_SESSION["tipo"] == 0) {
		$a->borrar_lista_productos();
	}else{
		echo json_encode(array("status"=> false, "message" => "no tienes privilegios de borrar productos"));
	}
    
}

if (isset($_POST["actualizar_estados"])) {
	$access = GestorConfigModel::verficar_usuario();
	if (isset($access->editProduct) || $_SESSION["tipo"] == 0) {
		$a->actualizar_estados();
	}else{
		echo json_encode(array("status"=> false, "message" => "no tienes privilegios de actualizar productos"));
	}
    
}

if (isset($_POST["actualizar_tipos"])) {
    $a->actualizar_tipos();
}

if (isset($_POST["cambiarImagenPerfil"])) {
    $a->cambiarImagenPerfil();
}

if (isset($_POST["add_files_product"])) {
	$a ->add_files_product();
}
if (isset($_POST["borrar_file"])) {
	$a ->borrar_file();
}

if (isset($_POST["verImagenesSlide"])) {
	$a ->verImagenesSlide();
}



if (isset($_POST["filtrar"])) {
	$_SESSION["filtroProducts"] = $_POST["search"];
	echo json_encode(array("q" => $_SESSION["filtroProducts"]));
}



	

