<?php 

class GestorEstadisticasModel{

	public static function productosMasVendidos(){

		$consulta = new Consulta();

		$fecha1 = $_POST["fechaInicial"];
		$fecha2 = $_POST["fechaFinal"];
		$limite = $_POST["limite"];
		$zona = $_POST["zona"];
		$p = [];
		$pedidos = [];

		if ($zona == "#") {
			$clientes = $consulta->ver_registros("SELECT * FROM clientes");
		}else{
			$clientes = $consulta->ver_registros("SELECT * FROM clientes where id_zona = '$zona'");
		}

		// var_dump($clientes);
		
		for ($c=0; $c < count($clientes); $c++) { 
			$id_c = $clientes[$c]["id"];
			$pedidos_ = $consulta->ver_registros("SELECT * FROM pedidos where fecha between '$fecha1' and '$fecha2' AND id_cliente = '$id_c' AND procesado = '1'");

			$pedidos = array_merge($pedidos, $pedidos_);
		}

		
		// var_dump($pedidos);
		for ($i=0; $i < count($pedidos); $i++) { 
			$id_p = $pedidos[$i]["id"];
			$items = $consulta->ver_registros("SELECT id_pedido,id_producto, nombre, cantidad FROM items_pedidos where id_pedido = '$id_p' order by cantidad desc");

			for ($j=0; $j < count($items); $j++) { 

				$res = GestorEstadisticasModel::check_item_($p, $items[$j]);
				if (!$res["status"]) {
					array_push($p, $items[$j]);	
				}else{
					$p[$res["i"]]["cantidad"] = $p[$res["i"]]["cantidad"] + $items[$j]["cantidad"];					
				}
							
			}
		}

		return $p;

	}

	public static function check_item_($array, $item){
		$resp = ["status" => false];	
		for ($i=0; $i < count($array); $i++) { 
			if ($array[$i]["id_producto"] == $item["id_producto"]) {
				$resp["status"] = true;
				$resp["i"] = $i;
			}
		}

		return $resp;
	}

	public static function vendedoresMasVentas(){

		$consulta = new Consulta();

		$fecha1 = $_POST["fechaInicial"];
		$fecha2 = $_POST["fechaFinal"];
		$limite = $_POST["limite"];
		$zona = $_POST["zona"];

		if ($zona == "#") {
			$clientes = $consulta->ver_registros("SELECT * FROM clientes");
		}else{
			$clientes = $consulta->ver_registros("SELECT * FROM clientes where id_zona = '$zona'");
		}
		$vendedores = $consulta->ver_registros("SELECT * from usuarios");
		$p = [];
		for ($i=0; $i < count($vendedores); $i++) { 
			$vendedor = $vendedores[$i];
			$id = $vendedor["id"];
			$pedidos = $consulta->ver_registros("SELECT * FROM pedidos where fecha between '$fecha1' and '$fecha2' and id_usuario = '$id' AND procesado = '1'");

			$array = array("nombre" => $vendedor["usuario"], "cantidad" => 0);
			$cantidad = 0;
			$total_dinero = 0;


			for ($h=0; $h < count($pedidos); $h++) { 
				$id_p = $pedidos[$h]["id"];
				$id_p_cliente = $pedidos[$h]["id_cliente"];
				if (GestorEstadisticasModel::check_client($clientes, $id_p_cliente)) {
					$total_dinero = $total_dinero + $pedidos[$h]["total"];
					$items = $consulta->ver_registros("SELECT id_pedido, nombre, cantidad FROM items_pedidos where id_pedido = '$id_p' order by cantidad desc");
		
					for ($j=0; $j < count($items); $j++) { 
						$cantidad = $cantidad + $items[$j]["cantidad"];
					}
				}
				
			}

			$array["cantidad"] = $cantidad;
			$array["title"] = "productos";
			$array["total"] = $total_dinero;
			$array["nombre"] = $vendedor["usuario"] . " ( $$total_dinero )";
			if ($cantidad != 0) {
				
				array_push($p, $array);
				
			}
			
		}

		return $p;

	}

	public static function misVentas($id = null){
		$consulta = new Consulta();
		
		$id = ($id != null) ? $id : $_SESSION["id_usuario"];


		$me = $consulta->ver_registros("SELECT * from usuarios where id = '$id'");
		$p = [];
		$vendedor = $me[0];

		$pedidos = $consulta->ver_registros("SELECT * FROM pedidos where estado = '1'");

		$total_dinero = 0;


		for ($h=0; $h < count($pedidos); $h++) { 
			$id_p = $pedidos[$h]["id"];

			$total_dinero = $total_dinero + $pedidos[$h]["total"];

			
		}


		return $total_dinero;
	}

	public static function check_client($clientes, $id){

		$res = false;
		for ($i=0; $i < count($clientes); $i++) { 
			if ($clientes[$i]["id"] == $id) {
				$res = true;
				break;
			}
		}

		return $res;

	}

	public static function clientesMasPedidos(){

		$consulta = new Consulta();

		$fecha1 = $_POST["fechaInicial"];
		$fecha2 = $_POST["fechaFinal"];
		$zona = $_POST["zona"];

		if ($zona == "#") {
			$clientes = $consulta->ver_registros("SELECT * FROM clientes");
		}else{
			$clientes = $consulta->ver_registros("SELECT * FROM clientes where id_zona = '$zona'");
		}

		$p = [];
		for ($i=0; $i < count($clientes); $i++) { 
			$cliente = $clientes[$i];
			$id = $cliente["id"];
			$pedidos = $consulta->ver_registros("SELECT * FROM pedidos where fecha between '$fecha1' and '$fecha2' and id_cliente = '$id'");
			$array = array("nombre" => $cliente["nombre"], "cantidad" => count($pedidos));
			$total_dinero = 0;

			for ($h=0; $h < count($pedidos); $h++) { 
				$total_dinero = $total_dinero + $pedidos[$h]["total"];			
			}
			if (count($pedidos) != 0) {
				$array["total"] = $total_dinero;
				$array["nombre"] = $cliente["nombre"] . " ( $$total_dinero )";
				array_push($p, $array);
			}
			
		}

		return $p;

	}
	

	
}
