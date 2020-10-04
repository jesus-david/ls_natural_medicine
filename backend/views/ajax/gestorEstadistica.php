<?php 
	
	require_once '../../models/conexion.php';
	require_once '../../models/consulta.php';
	require_once '../../models/gestorConfig.php';
	require_once '../../models/gestorEstadisticas.php';
	require_once '../../controllers/gestorConfig.php';
	require_once '../../controllers/gestorEstadisticas.php';


class GestorEstadistica{

	public function productosMasVendidos(){
		$respuesta = GestorEstadisticasController::productosMasVendidos();

		echo json_encode($respuesta);
	}
	public function vendedoresMasVentas(){
		$respuesta = GestorEstadisticasController::vendedoresMasVentas();

		echo json_encode($respuesta);
    }
    public function clientesMasPedidos(){
		$respuesta = GestorEstadisticasController::clientesMasPedidos();

		echo json_encode($respuesta);
	}
	
}


$a = new GestorEstadistica();


if (isset($_POST["productosMasVendidos"])) {
	$a->productosMasVendidos();
}
if (isset($_POST["vendedoresMasVentas"])) {
	$a->vendedoresMasVentas();
}
if (isset($_POST["clientesMasPedidos"])) {
	$a->clientesMasPedidos();
}

	

