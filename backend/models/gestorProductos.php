<?php 

class GestorProductosModel{

	public static function jsonProducts(){

		$consulta = new Consulta();

		$sql = "";
		$id = $_SESSION["id_usuario"];

		// var_dump($id_empresa);
		if (isset($_SESSION["filtroProducts"])) {
			$q = $_SESSION["filtroProducts"];

			$sql = "WHERE (nombre like '%$q%' or precio like '%$q%'or oferta like '%$q%' or codigo like '%$q%' or inventario like '%$q%')"; 
			// echo $sql;

			
		}
				
		$productos = $consulta->ver_registros("select * from productos $sql");
		
		for ($i=0; $i < count($productos); $i++) { 
			GestorProductosModel::check_ofeta($productos[$i]["id"]);
			$id_usuario_p = $productos[$i]["id_usuario"];
			//TODO:
			$config = $consulta->ver_registros("SELECT * from config where config_name='' ");
		}
		
		
		return $productos;

	}
	public static function jsonProductsMinim(){

		$consulta = new Consulta();

		$productos = $consulta->ver_registros("select * from productos where inventario < inventario_minimo");
	
		
		return $productos;

	}
	
	//se llama sim porque no se me ocurrió un buen nombre -- CREAR / ACTUALIZAR
	public static function sim($datos, $option, $id = null){

		$consulta = new Consulta();
		$nombre = htmlspecialchars($datos['nombre'], ENT_QUOTES);
		$precio = $datos["precio"];
		$oferta = ($datos["oferta"] != "") ? $datos["oferta"] : 0.00;
		$fechaLimiteOferta = ($datos["fechaLimiteOferta"] != "") ? $datos["fechaLimiteOferta"]: '0000-00-00 00:00:00';
		$descripcion = htmlspecialchars($datos['descripcion'], ENT_QUOTES);
		$inventario = $datos["inventario"];
		$estado = $datos["estado"];
		$codigo = htmlspecialchars($datos['codigo'], ENT_QUOTES);
		$id_usuario = $_SESSION["id_usuario"];
		$features = json_decode($datos["features"]);
		$strCategorias = $_POST["categorias"];

		$slug = GestorProductosModel::eliminar_simbolos($datos['nombre']);
		

		if ($option == "crear") {

			$consulta->nuevo_registro("INSERT into productos (nombre, imagen,precio, oferta, fechaLimiteOferta, descripcion,categorias,inventario,inventario_minimo,estado,codigo, id_usuario) values('$nombre', '','$precio', '$oferta','$fechaLimiteOferta', '$descripcion', '$strCategorias', '$inventario', '0', '$estado', '$codigo', '$id_usuario')");

			$r = $consulta->ver_registros("SELECT max(id) as id from productos");

			$id = $r[0]["id"];
			if($_FILES["imagen"]["tmp_name"] != ""){
				$ruta = "views/images/productos/imagen_$id.jpg";
				$consulta->actualizar_registro("UPDATE productos set imagen = '$ruta' where id = '$id'");
			}

			$slug .= "-" . $id;

			$consulta->actualizar_registro("UPDATE productos set slug= '$slug' where id = '$id'");
				
			for ($i=0; $i < count($features); $i++) { 
				$item = (array) $features[$i];

				if ($item["nombre"] != "" && count($item["childs"])) {
					$n1 = $item["nombre"];

					$consulta->nuevo_registro("INSERT into caracteristicas (nombre, id_producto) values ('$n1', '$id')");

					$max_c = $consulta->ver_registros("SELECT max(id) as id from caracteristicas");

					$id_caracteristica = $max_c[0]["id"];

					for ($j=0; $j < count($item["childs"]); $j++) { 
						$cItem = (array) $item["childs"][$j];

						if ($cItem["nombre"] != "") {
							$n2 = $cItem["nombre"];
							$v1 = ($cItem["valor_agregado"] != "") ? $cItem["valor_agregado"] : 0;
							$consulta->nuevo_registro("INSERT into items_caracteristica (nombre, valor_agregado, id_caracteristica) values ('$n2', '$v1', '$id_caracteristica')");
						}

					}

				}
			}
			
			GestorProductosModel::actualizar_variantes($id);
			
		}else if($option == "actualizar"){

			$slug .= "-" . $id;

			if($_FILES["imagen"]["tmp_name"] != ""){
				$ruta = "views/images/productos/imagen_$id.jpg";

				$consulta->actualizar_registro("UPDATE productos set nombre = '$nombre', slug= '$slug', imagen = '$ruta', precio = '$precio', oferta = '$oferta', fechaLimiteOferta = '$fechaLimiteOferta', descripcion = '$descripcion', categorias = '$strCategorias', inventario = '$inventario', estado = '$estado', codigo = '$codigo' where id = '$id'");
			}else{
				$consulta->actualizar_registro("UPDATE productos set nombre = '$nombre', slug= '$slug', precio = '$precio', oferta = '$oferta', fechaLimiteOferta = '$fechaLimiteOferta', descripcion = '$descripcion', categorias = '$strCategorias', inventario = '$inventario', estado = '$estado', codigo = '$codigo' where id = '$id'");
			}

			// $consulta->actualizar_registro("UPDATE items_pedidos set nombre = '$nombre' where id_producto = '$id'");


			$caracteristicas = GestorProductosModel::ver_caracteristicas_producto($id);

			for ($i=0; $i < count($features); $i++) { 
				$item = (array) $features[$i];

							
				if ($item["nombre"] != "" && count($item["childs"])) {
					$n1 = $item["nombre"];
			

					if (isset($item["id"])) { //actualizar

						$idc = $item["id"];
						 
						$consulta->nuevo_registro("UPDATE caracteristicas set nombre = '$n1' where id = '$idc'");

						$guardados_c = $consulta->ver_registros("SELECT * from items_caracteristica where id_caracteristica = '$idc'");
						$recibidos_c = (array) $item["childs"];

						$faltantes = GestorProductosModel::faltantes_en_caracteristica($guardados_c, $recibidos_c );

						// $faltantes_invertido = GestorProductosModel::faltantes_en_caracteristica($recibidos_c, $guardados_c );

						for ($j=0; $j < count($item["childs"]); $j++) { 
							$cItem = (array) $item["childs"][$j];

							if ($cItem["nombre"] != "" && isset($cItem["id"])) {

								$n2 = $cItem["nombre"];
								$v1 = ($cItem["valor_agregado"] != "") ? $cItem["valor_agregado"] : 0;
								$id_c_c = $cItem["id"];

					
								$consulta->nuevo_registro("UPDATE items_caracteristica set nombre = '$n2', valor_agregado = '$v1' where id = '$id_c_c'");

							}

						}

						for ($f=0; $f < count($faltantes); $f++) { 
							$id_f = $faltantes[$f];

							$consulta->borrar_registro("DELETE from items_caracteristica where id = '$id_f'");
							$consulta->borrar_registro("DELETE from variantes where sku like '%$id_f%'");

						}

						for ($f=0; $f < count($recibidos_c); $f++) { 					
							$i_fn = (array) $recibidos_c[$f];
							if (!isset($i_fn["id"])) {
								$n__ = $i_fn["nombre"];
								$v__ = ($i_fn["valor_agregado"] != "") ? $i_fn["valor_agregado"] : 0;

								$consulta->nuevo_registro("INSERT into items_caracteristica (nombre, valor_agregado, id_caracteristica) values ('$n__', '$v__', '$idc')");
							}
							
						}

						$caracteristicas_s = GestorProductosModel::ver_caracteristicas_producto($id);
						$arr_certesian = [];
						
						for ($c_s=0; $c_s < count($caracteristicas_s); $c_s++) { 
							$aux_arr = [];
							for ($j=0; $j < count($caracteristicas_s[$c_s]["childs"]); $j++) { 
								array_push($aux_arr, $caracteristicas_s[$c_s]["childs"][$j]["id"]);
							}

							array_push($arr_certesian, $aux_arr);

						}

						$cross = GestorProductosModel::build($arr_certesian);

						for ($j=0; $j < count($cross); $j++) { 
							$sku_s = implode("#", $cross[$j]);

							$check_sku = $consulta->ver_registros("SELECT * from variantes where sku = '$sku_s'");

							if (!count($check_sku)) {
								$consulta->nuevo_registro("INSERT INTO variantes (id_producto, sku, inventario) values ('$id', '$sku_s', '0')");
							}							
						}
					
					}else{// crear

						$consulta->nuevo_registro("INSERT into caracteristicas (nombre, id_producto) values ('$n1', '$id')");

						$max_c = $consulta->ver_registros("SELECT max(id) as id from caracteristicas");

						$id_caracteristica = $max_c[0]["id"];

						for ($j=0; $j < count($item["childs"]); $j++) { 
							$cItem = (array) $item["childs"][$j];

							if ($cItem["nombre"] != "") {
								$n2 = $cItem["nombre"];
								$v1 = ($cItem["valor_agregado"] != "") ? $cItem["valor_agregado"] : 0;
								$consulta->nuevo_registro("INSERT into items_caracteristica (nombre, valor_agregado, id_caracteristica) values ('$n2', '$v1', '$id_caracteristica')");
							}

						}

						//borrar variantes y crear las nuevas
						GestorProductosModel::actualizar_variantes($id);
					}
					

				}
			}

			$arr_f = (array) $features;
			$faltantes_ = GestorProductosModel::faltantes_en_caracteristica($caracteristicas, $arr_f );


			for ($f= 0 ; $f < count($faltantes_); $f++) { 
				$id_f = $faltantes_[$f];
				$consulta->borrar_registro("DELETE from caracteristicas where id = '$id_f'");
				$consulta->borrar_registro("DELETE from items_caracteristica where id_caracteristica = '$id_f'");

						
			}

			if (count($faltantes_)) {
				//borrar variantes y crear las nuevas		
				GestorProductosModel::actualizar_variantes($id);
			}

			
		}
		
		return array("status" => "ok", "id" => $id);

	}

	public static function ver_info_producto($id){

		$consulta = new Consulta();
		
		GestorProductosModel::check_ofeta($id);

		$info = $consulta->ver_registros("SELECT * from productos where id = '$id'");
		$galeria = $consulta->ver_registros("SELECT * from multimedia_product where id_product = '$id'");
	
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


        return $info;

	}

	public static function ver_info_producto_por_slug($slug){

		$consulta = new Consulta();
		

		$info = $consulta->ver_registros("SELECT * from productos where slug = '$slug'");
	
		
		if (isset($info[0])) {

			$id = $info[0]["id"];

			GestorProductosModel::check_ofeta($id);

			$galeria = $consulta->ver_registros("SELECT * from multimedia_product where id_producto = '$id'");

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
				
		}

        return $info;

	}

	public static function actualizar_variantes($id){
		$consulta = new Consulta();
		$caracteristicas = GestorProductosModel::ver_caracteristicas_producto($id);
		$arr_certesian = [];
		
		for ($i=0; $i < count($caracteristicas); $i++) { 
			$aux_arr = [];
			for ($j=0; $j < count($caracteristicas[$i]["childs"]); $j++) { 
				array_push($aux_arr, $caracteristicas[$i]["childs"][$j]["id"]);
			}

			array_push($arr_certesian, $aux_arr);

		}

		//borrar variantes y crear las nuevas

		if (count($caracteristicas)) {
			$cross = GestorProductosModel::build($arr_certesian);

			$consulta->borrar_registro("DELETE from variantes where id_producto = '$id'");

			for ($i=0; $i < count($cross); $i++) { 
				$sku_s = implode("#", $cross[$i]);

				$consulta->nuevo_registro("INSERT INTO variantes (id_producto, sku, inventario) values ('$id', '$sku_s', '0')");
			}

		}
		
		return $arr_certesian;

	}

	public static function build($set)
    {
        if (!$set) {
            return array(array());
        }

        $subset = array_shift($set);
        $cartesianSubset = self::build($set);

        $result = array();
        foreach ($subset as $value) {
            foreach ($cartesianSubset as $p) {
                array_unshift($p, $value);
                $result[] = $p;
            }
        }

        return $result;        
    }
	public static function sku_update($sku, $val){

		$consulta = new Consulta();

		$consulta->actualizar_registro("UPDATE variantes set inventario = '$val' where sku = '$sku'");

	}
	public static function sku_update_all($id, $val){

		$consulta = new Consulta();

		$consulta->actualizar_registro("UPDATE variantes set inventario = '$val' where id_producto = '$id'");

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
	public static function faltantes_en_caracteristica($guardados, $recibidos){

		$faltantes = [];

		for ($i=0; $i < count($guardados); $i++) { 
			
			$g = (array) $guardados[$i];

			if (isset($g["id"])) {

				$id = $g["id"];
				$bool = false;
				for ($j=0; $j < count($recibidos); $j++) { 
					$r = (array) $recibidos[$j];
					if (isset($r["id"]) && $r["id"] == $id) {
						$bool = true;
					}
				}

				if (!$bool) {
					array_push($faltantes, $id);
				}
			}
			

		}

		return $faltantes;

	}

	public static function borrar_lista_productos($lista){

		$consulta = new Consulta();
		
		for ($i=0; $i < count($lista); $i++) { 
			
			if (isset($lista[$i]["id"])) {
				$id = $lista[$i]["id"];
			}else{
				$id = $lista[$i];
			}
			

			$producto = $consulta->ver_registros("select * from productos where id = '$id'");
			$consulta->borrar_registro("DELETE from productos where id = '$id'");

			if (isset($producto[0])) {
				if ($producto[0]["imagen"] != "" && file_exists("../../" . $producto[0]["imagen"])) {
					unlink("../../".$producto[0]["imagen"]);
				}
			}

			$itemPedido = $consulta->ver_registros("SELECT * from items_pedidos where id_producto = '$id'");


			for ($p=0; $p < count($itemPedido); $p++) { 
				$id_p_ = $itemPedido[$p]["id_pedido"];

				//TODO: actualizar el precio total del pedido
				$pedido =  $consulta->ver_registros("SELECT * from pedidos where id = '$id_p_'");

				$oldTotal = $pedido[0]["total"];
				$nTotal = $oldTotal - $itemPedido[$p]["precio_total"];

				// echo $nTotal;

				$consulta->actualizar_registro("UPDATE pedidos set total = '$nTotal', mensaje = 'Algunos productos fueron borrados del pedido' where id = '$id_p_'");
				
			}

			$consulta->borrar_registro("DELETE from items_pedidos where id_producto = '$id'");

			GestorProductosModel::borrar_files_producto($id);
			
		}

        return array("status" => "ok");

	}
	
	public static function actualizar_estados($lista, $estado){

		$consulta = new Consulta();
		
		for ($i=0; $i < count($lista); $i++) { 
			
			$id = $lista[$i];
			$consulta->actualizar_registro("UPDATE productos set estado = '$estado' where id = '$id'");

		}

        return array("status" => "ok");

	}

	public static function actualizar_tipos($lista, $tipo){

		$consulta = new Consulta();

		$access = GestorConfigModel::verficar_usuario();

		
		
		for ($i=0; $i < count($lista); $i++) { 
			
			$id = $lista[$i];

			if($_SESSION["tipo"] == 0){
				$consulta->actualizar_registro("UPDATE usuarios set tipo = '$tipo' where id = '$id'");
			}else if (isset($access->listUsers) && $id != $_SESSION["id_usuario"] && $tipo != 0) {
				$consulta->actualizar_registro("UPDATE usuarios set tipo = '$tipo' where id = '$id'");
			}

			

		}

        return array("status" => "ok");

	}

	public static function ver_ultimo_archivo($id){

		$consulta = new Consulta();

		$order = $consulta -> ver_registros("select MAX(orden) as orden from multimedia_product where id_product = '$id'");

		if (isset($order[0])) {
			$orden = $order[0]["orden"];
		}else {
			$orden = 0;
		}

		return $orden;
	}

	public static function guardar_files_producto($files, $img_principal, $id){

		$consulta = new Consulta();

		$length = count($files);


		if ($img_principal != false) {			
			// $consulta->actualizar_registro("update productos set foto = '$img_principal' where id = '$id'");
		}

		$order = $consulta -> ver_registros("select MAX(orden) as orden from multimedia_product where id_product = '$id'");

		if (isset($order[0])) {
			$orden = $order[0]["orden"];
		}else {
			$orden = 0;
		}

		// $contador = $order
		for ($i=0; $i < $length; $i++) { 

			$orden++;

			$path = $files[$i]["path"];
			$name = $files[$i]["type"];

			$consulta -> nuevo_registro("insert into multimedia_product (name_key,name,path_media,id_product,orden) values ('$name','','$path','$id','$orden')");
		}

		return 'ok';

	}

	public static function borrar_files_producto($id){
		$consulta = new Consulta();

		$files = $consulta->ver_registros("SELECT * from multimedia_product where id_product = '$id'");


		for ($i=0; $i < count($files); $i++) { 
			$file = $files[$i];
			try {										
				if (isset($file["path_media"])) {
					unlink("../../".$file[0]["path_media"]);
				}								
			}catch (Exception $e) {}
		}
	}

	public static function ver_images_producto($id){
		
		$consulta = new Consulta();
				
		$imgs = $consulta -> ver_registros("select * from multimedia_product where id_product = '$id' order by orden");
	
		return $imgs;
	}

	public static function verImagenesSlide(){

		$consulta = new Consulta();

		$id = $_POST["id"];

		$imagenesSlide = [];

		$producto = $consulta->ver_registros("select * from productos where id='$id'");

		$img1["id"] = $producto[0]["id"];
		$img1["link"] = $producto[0]["imagen"];
		array_push($imagenesSlide,$img1);

		

		$imagenes = $consulta->ver_registros("select * from multimedia_product where id_product='$id' && name_key = 'image'");

		for ($g=0; $g < count($imagenes); $g++) { 
			$link = $imagenes[$g]["path_media"];
			$idimg = $imagenes[$g]["id_media"];
	
			$aux["id"] = $idimg;
			$aux["link"] = $link;
			array_push($imagenesSlide,$aux);
			
		}

		return $imagenesSlide;

	}

	public static function borrar_file(){
		
		$consulta = new Consulta();

		$id = $_POST["id_file"];
		
		$file = $consulta -> ver_registros("select * from multimedia_product where id_media = '$id' ");

		try {
			if (isset($file[0])) {		
				
				if (isset($file[0]["path_media"])) {
					unlink("../../".$file[0]["path_media"]);
				}				
			}
		} catch (Exception $e) {
			
		}
		$consulta->borrar_registro("delete from multimedia_product where id_media = '$id'");
	
		return 'ok';
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
	
	public static function eliminar_simbolos($string){
 
		$string = trim($string);
	 
		$string = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$string
		);
	 
		$string = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$string
		);
	 
		$string = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$string
		);
	 
		$string = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$string
		);
	 
		$string = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$string
		);
	 
		$string = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç'),
			array('n', 'N', 'c', 'C',),
			$string
		);
	 
		$string = str_replace(
			array("\\", "¨", "º", "-", "~",
				 "#", "@", "|", "!", "\"",
				 "·", "$", "%", "&", "/",
				 "(", ")", "?", "'", "¡",
				 "¿", "[", "^", "<code>", "]",
				 "+", "}", "{", "¨", "´",
				 ">", "< ", ";", ",", ":",
				 ".", " "),
			' ',
			$string
		);

		$string = preg_replace('/\s+/', ' ',$string);

		$find = array(' ', '&', '\r\n', '\n','+','’');
		$string = str_replace($find, '-', $string);

		return $string;
	} 
}
