<?php

class GestorProductosModel{

	public static function productos($search = false){
		$consulta = new Consulta();
	
		$orden = isset($_SESSION["filter_orden"]) ? $_SESSION["filter_orden"] : "nombre";
		$filter_categorias = isset($_SESSION["filter_categorias"]) ? $_SESSION["filter_categorias"] : "";

		if ($search) {			
			$productos = $consulta->ver_registros("SELECT * from productos where (nombre like '%$search%' or descripcion like '%$search%') AND estado = '1' order by $orden");

		}else{
			$productos = $consulta->ver_registros("SELECT * from productos where estado = '1' order by $orden");
		}

		$array_productos = [];

		for ($i=0; $i < count($productos); $i++) { 
			$id_p = $productos[$i]["id"];
			$item = $productos[$i];

			$info = GestorProductosModel::ver_info_producto($id_p);
		
			if($filter_categorias != ""){
				$go = false;
				for ($j=0; $j < count($filter_categorias); $j++) { 
					$str_c = $filter_categorias[$j];
					$categorias_p = explode(",",$info["categorias"]);
					for ($x=0; $x < count($categorias_p); $x++) { 
						if ($categorias_p[$x] == $str_c) {
							$go = true;
							break;
						}
					}
					
				}

				if ($go) {
					$array_productos[$i] = $info;
				}
				
			}else{			
				$array_productos[$i] = $info;
			}

		
		}

		return $array_productos;

	}

	public static function productos_relacionados($categorias, $id_producto){

		$consulta = new Consulta();

		$relacionados = [];

		for ($i=0; $i < count($categorias); $i++) { 
			$id = $categorias[$i]["id"];

			$p = $consulta->ver_registros("SELECT * from productos where categorias like '%$id%' AND id != '$id_producto'");
			
			$relacionados = array_merge($relacionados, $p);
		}


		for ($i=0; $i < count($relacionados); $i++) { 
			$id_p = $relacionados[$i]["id"];

			$info = GestorProductosModel::ver_info_producto($id_p);
		
			$relacionados[$i] = $info;
		
		}

		return $relacionados;
		

	}

	public static function ver_productos(){
		$consulta = new Consulta();

		$productos = $consulta -> ver_registros("SELECT * FROM productos where estado = '1' limit 0,8");

		$array_productos = [];

		for ($i=0; $i < count($productos); $i++) { 
			$id_p = $productos[$i]["id"];
			$item = $productos[$i];

			$info = GestorProductosModel::ver_info_producto($id_p);
		
			$array_productos[$i] = $info;
		
		}

		return $array_productos;
	}

	public static function productos_limite($search = false, $inicio, $limite){
		$consulta = new Consulta();

		$orden = isset($_SESSION["filter_orden"]) ? $_SESSION["filter_orden"] : "nombre";
		$filter_categorias = isset($_SESSION["filter_categorias"]) ? $_SESSION["filter_categorias"] : "";

	
		if ($search) {
			$productos = $consulta->ver_registros("SELECT * from productos where (nombre like '%$search%' or descripcion like '%$search%') AND estado = '1' order by $orden limit $inicio,$limite");
		}else{
			$productos = $consulta->ver_registros("SELECT * from productos where estado = '1' order by $orden limit $inicio,$limite");
		}
		
		$array_productos = [];

		for ($i=0; $i < count($productos); $i++) { 
			$id_p = $productos[$i]["id"];
			$item = $productos[$i];

			$info = GestorProductosModel::ver_info_producto($id_p);
	
			if($filter_categorias != ""){
				$go = false;
				for ($j=0; $j < count($filter_categorias); $j++) { 
					$str_c = $filter_categorias[$j];
					$categorias_p = explode(",",$info["categorias"]);
					for ($x=0; $x < count($categorias_p); $x++) { 
						if ($categorias_p[$x] == $str_c) {
							$go = true;
							break;
						}
					}
					
				}

				if ($go) {
					$array_productos[$i] = $info;
				}
				
			}else{			
				$array_productos[$i] = $info;
			}
		}

		return $array_productos;

	}

	public static function ver_info_producto($id){

		$consulta = new Consulta();
		
		GestorProductosModel::check_ofeta($id);

		$info = $consulta->ver_registros("SELECT * from productos where id = '$id' and estado = '1'");
		
		if (isset($info[0])) {
			$galeria = $consulta->ver_registros("SELECT * from multimedia_product where id_product = '$id'");
		
			$resp = $consulta->ver_registros("SELECT * from config where config_name = 'config_user'");
			$config_array = json_decode($resp[0]["config_value"]);

			if (isset($info[0]["categorias"])) {
				$categorias = [];
				$ids = explode(",", $info[0]["categorias"]);

				for ($i=0; $i < count($ids); $i++) { 
					$id_categoria = $ids[$i];
					$categoria = $consulta->ver_registros("SELECT * from categorias where id = '$id_categoria'");

					if (isset($categoria[0])) {
						array_push($categorias, $categoria[0]);
					}
				}

				$info[0]["categorias_"] = $categorias;
				
			}
			
			$caracteristicas = GestorProductosModel::ver_caracteristicas_producto($id);

			$variantes = GestorProductosModel::ver_variantes_producto($id);

			$opiniones = $consulta -> ver_registros("SELECT * from opiniones where id_producto = '$id' order by fecha desc");
			
			$vendidos = $consulta -> ver_registros("SELECT count(items_pedidos.id) as total from pedidos inner join items_pedidos on pedidos.id = items_pedidos.id_pedido where items_pedidos.id_producto = '$id' AND pedidos.estado = '1'");


			$total = count($opiniones) * 5;
			$sum_t = 0;
		
			for($i = 0; $i < count($opiniones); $i++) {
				$item = $opiniones[$i];
				$id_usu = $item["id_comprador"];
				$f = $item["fecha"];

				$usuario = $consulta->ver_registros("SELECT * from usuarios where id = '$id_usu'");

				$opiniones[$i]["format"] = date("M",strtotime($f)) . " " .date("d",strtotime($f)) . ", ". date("Y",strtotime($f));
				$opiniones[$i]["skus"] = ($opiniones[$i]["skus"] != "") ? json_decode($opiniones[$i]["skus"]) : [];
				$opiniones[$i]["usuario"] = isset($usuario[0]) ? $usuario[0]["nombre"] : "";


				$sum_t += $item["valor"];            
			}

			$porcentaje = ($sum_t > 0) ? ($sum_t * 100) / $total : 0;

			$rep = array(
				"porcentaje" => $porcentaje,
				"porcentaje_base_5" => ($porcentaje > 0) ? ($porcentaje / 100) * 5 : 0,
				"items" => $opiniones,            
			);


			$info = count($info) != 0 ? $info[0] : [];
			$info["galeria"] = $galeria;

			$info["caracteristicas"] = $caracteristicas;
			$info["variantes"] = $variantes;
			$info["reputacion"] = $rep;
			$info["vendidos"] = $vendidos[0];
			$info["config"] = $config_array;
		}


        return $info;

	}


	public static function ver_info_producto_por_slug($slug){

		$consulta = new Consulta();
		

		$info = $consulta->ver_registros("SELECT * from productos where slug = '$slug' and estado = '1'");
	
		$resp = $consulta->ver_registros("SELECT * from config where config_name = 'config_user'");
		$config_array = json_decode($resp[0]["config_value"]);
		
		if (isset($info[0])) {

			$id = $info[0]["id"];

			GestorProductosModel::check_ofeta($id);

			$galeria = $consulta->ver_registros("SELECT * from multimedia_product where id_product = '$id'");

			$categorias = [];
			$ids = explode(",", $info[0]["categorias"]);

			for ($i=0; $i < count($ids); $i++) { 
				$id_categoria = $ids[$i];
				$categoria = $consulta->ver_registros("SELECT * from categorias where id = '$id_categoria'");

				if (isset($categoria[0])) {
					array_push($categorias, $categoria[0]);
				}
			}

			$info[0]["categorias_"] = $categorias;


			$caracteristicas = GestorProductosModel::ver_caracteristicas_producto($id);

			$variantes = GestorProductosModel::ver_variantes_producto($id);

			$opiniones = $consulta -> ver_registros("SELECT * from opiniones where id_producto = '$id' order by fecha desc");
			
			$vendidos = $consulta -> ver_registros("SELECT count(items_pedidos.id) as total from pedidos inner join items_pedidos on pedidos.id = items_pedidos.id_pedido where items_pedidos.id_producto = '$id' AND pedidos.estado = '1'");


			$total = count($opiniones) * 5;
			$sum_t = 0;
		
			for($i = 0; $i < count($opiniones); $i++) {
				$item = $opiniones[$i];
				$id_usu = $item["id_comprador"];
				$f = $item["fecha"];

				$usuario = $consulta->ver_registros("SELECT * from clientes where id = '$id_usu'");

				$opiniones[$i]["format"] = date("M",strtotime($f)) . " " .date("d",strtotime($f)) . ", ". date("Y",strtotime($f));
				$opiniones[$i]["skus"] = ($opiniones[$i]["skus"] != "") ? json_decode($opiniones[$i]["skus"]) : [];
				$opiniones[$i]["usuario"] = isset($usuario[0]) ? $usuario[0]["nombre"] : "";


				$sum_t += $item["valor"];            
			}

			$porcentaje = ($sum_t > 0) ? ($sum_t * 100) / $total : 0;

			$rep = array(
				"porcentaje" => $porcentaje,
				"porcentaje_base_5" => ($porcentaje > 0) ? ($porcentaje / 100) * 5 : 0,
				"items" => $opiniones,            
			);


			$info = count($info) != 0 ? $info[0] : [];
			$info["galeria"] = $galeria;

			$info["caracteristicas"] = $caracteristicas;
			$info["variantes"] = $variantes;
			$info["reputacion"] = $rep;
			$info["vendidos"] = $vendidos[0];
			$info["config"] = $config_array;
				
		}

        return $info;

	}

	public static function ver_caracteristicas_producto($id){
		$consulta = new Consulta();

		$caracteristicas = $consulta->ver_registros("SELECT * from caracteristicas where id_producto = '$id'");

		for ($i=0; $i < count($caracteristicas); $i++) { 
			
			$item = $caracteristicas[$i];
			$id_c = $item["id"];

			$childs = $consulta->ver_registros("SELECT * from items_caracteristica where id_caracteristica = '$id_c'");

			for ($j=0; $j < count($childs); $j++) { 
				$childs[$j]["temp_id"] = $j + 1;
			}

			$caracteristicas[$i]["childs"] = $childs;
			$caracteristicas[$i]["temp_id"] = $i;

		}

		return $caracteristicas;


	}
	public static function ver_variantes_producto($id){
		$consulta = new Consulta();

		$variantes = $consulta->ver_registros("SELECT * from variantes where id_producto = '$id'");

		for ($i=0; $i < count($variantes); $i++) { 
			
			$item = $variantes[$i];
			$variantes[$i]["values"] = [];
			$id_c = $item["id"];
			$skus = explode("#",$item["sku"]);

			for ($j=0; $j < count($skus); $j++) { 
				$id_c = $skus[$j];
				$info_sku = $consulta->ver_registros("SELECT * from items_caracteristica where id = '$id_c'");
				array_push($variantes[$i]["values"], $info_sku[0]);
			}

		}

		return $variantes;


	}

	public static function check_ofeta($id){
		$consulta = new Consulta();

		$producto = $consulta->ver_registros("SELECT oferta, fechaLimiteOferta from productos where id = '$id'");

		if (isset($producto[0])) {

			if ($producto[0]["oferta"] != "0.00") {
				$hoy = date("Y-m-d H:i:s");
				if($hoy > $producto[0]["fechaLimiteOferta"]){
					//se acabó la oferta
					$consulta->actualizar_registro("UPDATE productos set oferta = '0.00', fechaLimiteOferta = '0000-00-00 00:00:00' where id = '$id'");
				}


			}
		}
	}
	
	public static function check_product($slug){

		$consulta = new Consulta();
		$product = $consulta->ver_registros("SELECT * from productos where slug = '$slug'");

		if (count($product)) {
			return true;
		}else{
			return false;
		}
	
	}

	public static function ver_config(){
		$consulta = new Consulta();

		$resp = $consulta->ver_registros("SELECT * from config where config_name = 'config_user'");


		if (!count($resp)) {
			$config_array = array(
				"type_money" => "$",
				"rate" => "",
				"payAtHome" => "false",
				"receiveNotyByDay" => "true"
	
			);
			$init_config = json_encode($config_array);

			$consulta->nuevo_registro("INSERT into config (config_name, config_value, config_code) values ('config_user', '$init_config', 'config_user')");
			
		}else{
			$config_array = json_decode($resp[0]["config_value"]);
		}

		return $config_array;
	}
	
	public static function ver_preguntas($id_producto){
		
		$consulta = new Consulta();

		$preguntas = $consulta->ver_registros("SELECT * from preguntas where id_producto = '$id_producto' order by fecha_pregunta desc");

		for ($i=0; $i < count($preguntas); $i++) { 
			
			$f_pregunta = $preguntas[$i]["fecha_pregunta"];
			$f_respuesta = $preguntas[$i]["fecha_respuesta"];


			$preguntas[$i]["format_pregunta"] = date("M",strtotime($f_pregunta)) . " " .date("d",strtotime($f_pregunta)) . ", ". date("Y",strtotime($f_pregunta));

			if ($preguntas[$i]["respuesta"] != "") {
				$preguntas[$i]["format_respuesta"] = date("M",strtotime($f_respuesta)) . " " .date("d",strtotime($f_respuesta)) . ", ". date("Y",strtotime($f_respuesta));
			}
		}

		return $preguntas;
	}
	public static function ver_preguntas_sin_responder(){
		
		$consulta = new Consulta();
		$id = $_SESSION["id_usuario"];

		$preguntas = $consulta->ver_registros("SELECT * from preguntas where respuesta = '' order by fecha_pregunta desc ");

		return $preguntas;
	}
	public static function ask(){

		$consulta = new Consulta();

		$id_producto = $_POST["id_producto"];
		$id_cliente = $_POST["id_cliente"];
		$pregunta = htmlspecialchars($_POST["pregunta"], ENT_QUOTES);
		$hoy = date("Y-m-d H:i:s");

		$consulta->nuevo_registro("INSERT into preguntas (id_producto,id_cliente,contenido,	respuesta,fecha_pregunta,fecha_respuesta) values ('$id_producto', '$id_cliente', '$pregunta', '','$hoy', '0000-00-00 00:00:00')");

		$cliente = $consulta->ver_registros("SELECT * from clientes where id = '$id_cliente'");

		return array("cliente" => $cliente[0]);

	}

}


?>