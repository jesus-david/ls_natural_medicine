<?php 
	// session_start();
	require_once '../../controllers/gestorPedidos.php';
	require_once '../../controllers/gestorProductos.php';
	require_once '../../controllers/auth.php';
	require_once '../../controllers/mail.php';

	require_once '../../models/conexion.php';
	require_once '../../models/consulta.php';
	require_once '../../models/auth.php';
    require_once '../../models/gestorProductos.php';
    require_once '../../models/gestorPedidos.php';


class PedidosAjax{

	public function ver_items_pedidos(){
		$respuesta = GestorPedidosController::verItemsPedido();

		echo json_encode($respuesta);
	}

	public function crear_pedido(){
		$respuesta = GestorPedidosController::crear_pedido();

		echo json_encode($respuesta);
	}
	public function pedido_entregado(){
		$respuesta = GestorPedidosController::pedido_entregado();

		echo json_encode($respuesta);
	}
	public function cancelar_compra(){
		$respuesta = GestorPedidosController::cancelar_compra();

		echo json_encode($respuesta);
	}
	public function borrar_pedido(){
		$respuesta = GestorPedidosController::borrar_pedido();

		echo json_encode($respuesta);
	}
	public function borrar_pedido_soft(){
		$respuesta = GestorPedidosController::borrar_pedido_soft();

		echo json_encode($respuesta);
	}

	public function valorar(){
		$respuesta = GestorPedidosController::valorar();

		echo json_encode($respuesta);
	}
	

}


$a = new PedidosAjax();

	if (isset($_POST["ver_items_pedidos"])) {

		$a ->ver_items_pedidos();
	}

	if (isset($_POST["crear_pedido"])) {

		$a ->crear_pedido();
	}
	if (isset($_POST["pedido_entregado"])) {

		$a ->pedido_entregado();
	}
	if (isset($_POST["cancelar_compra"])) {

		$a ->cancelar_compra();
	}
	if (isset($_POST["borrar_pedido"])) {

		$a ->borrar_pedido();
	}
	if (isset($_POST["borrar_pedido_soft"])) {

		$a ->borrar_pedido_soft();
	}
	if (isset($_POST["valorar"])) {

		$a ->valorar();
	}
	