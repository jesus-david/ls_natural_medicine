<?php 
if(!isset($_SESSION)){ 
    session_start(); 
} 
class GestorProductosController{

	public static function jsonProducts(){

        $productos = GestorProductosModel::jsonProducts();
        
        for ($i=0; $i < count($productos); $i++) { 
            $productos[$i]["CompanyAgent"] = $productos[$i]["nombre"];
            $productos[$i]["imagen"] = ($productos[$i]["imagen"] != "") ? $productos[$i]["imagen"] : "views/images/default.jpg";
        }

		return $productos;

	}
	
	public static function jsonProductsMinim(){

        $productos = GestorProductosModel::jsonProductsMinim();
        
        for ($i=0; $i < count($productos); $i++) { 
            $productos[$i]["CompanyAgent"] = $productos[$i]["nombre"];
        }

		return $productos;

    }
    
    public static function crear(){

        $validado = GestorProductosController::validar($_POST);

        if ($validado["status"] == "error") {
            return $validado;
        }else{
            //imagen del producto
            

            $resp = GestorProductosModel::sim($_POST, "crear");

            $id = $resp["id"];
            $ruta = "views/images/productos/imagen_$id.jpg";
            if ($_FILES["imagen"]["tmp_name"] != "") {
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../../" . $ruta);
            }

            return $resp;
        }

        
    }
    public static function actualizar(){

        $validado = GestorProductosController::validar($_POST);

        if ($validado["status"] == "error") {
            return $validado;
        }else{
            //imagen del producto
            $resp = GestorProductosModel::sim($_POST, "actualizar", $_POST["id"]);

            $id = $resp["id"];
            $ruta = "views/images/productos/imagen_$id.jpg";
            if ($_FILES["imagen"]["tmp_name"] != "") {
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../../" . $ruta);
            }

            return $resp;
        }

        
	}
	
	public static function sku_update(){

		$sku = $_POST["sku"];
		$val = $_POST["value"];

		GestorProductosModel::sku_update($sku, $val);

		return array("status" => true);
	}
	public static function sku_update_all(){

		$id = $_POST["id"];
		$val = $_POST["value"];

		GestorProductosModel::sku_update_all($id, $val);

		return array("status" => true);
	}
    
    public static function ver_info_producto($id){
        return GestorProductosModel::ver_info_producto($id);
    }

	public static function ver_info_producto_por_slug($slug){
        return GestorProductosModel::ver_info_producto_por_slug($slug);
    }

    public static function validar($datos){
        $validado = array(
            "razon" => "",
            "mensaje" => "",
            "status" => "valido"
        );

        if ($datos["nombre"] == "" || $datos["precio"] == "" || $datos["inventario"] == "") {
            $validado = array(
                "razon" => "campos vacíos",
                "mensaje" => "Por favor llene los campos, requeridos",
                "status" => "error"
            );
        }else if ($_FILES["imagen"]["tmp_name"] != "") {
            if ($_FILES["imagen"]["type"] != "image/png" && $_FILES["imagen"]["type"] != "image/jpeg" && $_FILES["imagen"]["type"] != "image/jpg") {
                $validado = array(
                    "razon" => "extensión de imagen inválida",
                    "mensaje" => "La extensión de la imagen no está permitida (png,jpeg,jpg)",
                    "status" => "error"
                );
            }
        }

        return $validado;

    }

    public static function borrar_lista_productos(){
        $lista = $_POST["lista"];
        return GestorProductosModel::borrar_lista_productos($lista);
    
    }
    public static function actualizar_estados(){
        $lista = $_POST["lista"];
        $estado = $_POST["estado"];
        return GestorProductosModel::actualizar_estados($lista, $estado);
    
    }
    public static function actualizar_tipos(){
        $lista = $_POST["lista"];
        $tipo = $_POST["tipo"];
        return GestorUsuariosModel::actualizar_tipos($lista, $tipo);
    
    }

    public static function procesar_files($file_p,$id_producto){
		
		$files = [];
		$file_count = count($file_p["name"]);
		$file_keys = array_keys($file_p);
		$srcs = [];

		for ($i=0; $i < $file_count; $i++) { 
			foreach ($file_keys as $key) {
				$files[$i][$key] = $file_p[$key][$i];
			}
		}

		$orden = GestorProductosModel::ver_ultimo_archivo($id_producto);
		
		for ($i=0; $i < count($files); $i++) { 

			$orden++;

			$random = rand(0,10000);

			if(isset($files[$i]["tmp_name"]) && $files[$i]["tmp_name"] != ""){

				$file = $files[$i]["tmp_name"];

				if ($files[$i]["type"] == "image/jpeg" || $files[$i]["type"] == "image/png"){
					if (is_uploaded_file($file)) {

						
						$ruta_aux = "views/images/productos/producto_img_$random-$orden-$id_producto.jpg";
						
						$res_move = move_uploaded_file($file, "../../".$ruta_aux);
						

						$aux_file = [
						    'path' => $ruta_aux,
						  	'type' => "image"
						];

						array_push($srcs, $aux_file);
					}
				}


				if ($files[$i]["type"] == "video/mp4" || $files[$i]["type"] == "video/avi" || $files[$i]["type"] == "video/mkv" || $files[$i]["type"] == "video/wmv" || $files[$i]["type"] == "video/flv" || $files[$i]["type"] == "video/dvd" || $files[$i]["type"] == "video/webm"){

					if (is_uploaded_file($file)) {

						$ruta_aux = "views/images/productos/producto_video_$random-$orden-$id_producto.mp4";
						move_uploaded_file($file, "../../".$ruta_aux);

						$aux_file = [
						    'path' => $ruta_aux,
						  	'type' => "video"
						];
						array_push($srcs, $aux_file);
					}
				}


				if ($files[$i]["type"] == "application/pdf"){
					if (is_uploaded_file($file)) {

						$ruta_aux = "views/images/productos/producto_pdf_$random-$orden-$id_producto.pdf";
						
						$res_move = move_uploaded_file($file, "../../".$ruta_aux);
						

						$aux_file = [
						    'path' => $ruta_aux,
						  	'type' => "pdf"
						];

						array_push($srcs, $aux_file);
					}
				}


			}
			
		}

		return $srcs;

	}

    public static function add_files_product(){

		$id_producto = $_POST["id_p"];


		$srcs = GestorProductosController::procesar_files($_FILES["files_product"],$id_producto);

		$resp = GestorProductosModel::guardar_files_producto($srcs, false, $id_producto);

		
		$arr["status"] = "ok";

		return $arr;
		
		
    }
    
    public static function ver_images_producto($id){

		$images = GestorProductosModel::ver_images_producto($id);


		for ($i=0; $i < count($images); $i++) { 


			if ($images[$i]["path_media"] != "") {
				if ($images[$i]["name_key"] == "image") {
					$tag = '<img src="'.$images[$i]["path_media"].'" class="handleImg" style="width: 100%;height: 150px;">';
					$btnc = '
						<span class="icon-check span-left set_primary" 
							accesskey="'.$images[$i]["id_media"].'"
							data-p="'.$id.'"
							data-toggle="tooltip" title="establecer como imagen principal"></span>
					';
				}else if ($images[$i]["name_key"] == "video") {
					$btnc = "";
					$tag = '
						
						<video width="100%" height="150" controls>
						  <source src="'.$images[$i]["path_media"].'" type="video/mp4">
						</video>


					';
				}else if ($images[$i]["name_key"] == "pdf") {
					$btnc = '
						<span class="icon-pencil span-left name_pdf" 
						accesskey="'.$images[$i]["id_media"].'"
						data-id="'.$id.'"
						data-toggle="tooltip" title="nombre pdf"></span>

						
							<a class="icon-eye span-left-2" 
							href="'.$images[$i]["path_media"].'"
							target="_blank"
							></a>
						
					';
					$tag = '
						<p>'.$images[$i]["name"].'</p>	
						<embed src="'.$images[$i]["path_media"].'" type="application/pdf" width="100%" height="150px" />

					';
				}
				$btnBorrar = '
					
                    <button class="btn btn-label-danger btn-bold borrar_img_producto hidden" accesskey="'.$images[$i]["id_media"].'"
                    data-p="'.$id.'">
                        borrar
                    </button>
				';

				if ($images[$i]["name_key"] == "image") {
					echo '
						<div id="'.$images[$i]["id_media"].'" class="col-sm content-img-galery">
							'.$btnc.'
                            '.$btnBorrar.'
                            <img src="'.$images[$i]["path_media"].'" class="img-galery" data-id="'.$images[$i]["id_media"].'" />
						</div>
					';
				}else{
					echo '
                        <div id="'.$images[$i]["id_media"].'" class="col-sm">
							'.$btnc.'
							'.$btnBorrar.'
							'.$tag.'
                        </div>
					';
				}
				
				
			}
			

				
		}
		
    }

    public static function borrar_file(){
	

		$resultado = GestorProductosModel::borrar_file();

		if ($resultado == "ok") {
			$arr["status"] = "ok";
			return $arr;
		}else{
			$arr["status"] = "error";
			return $arr;
		}
				
			
    }
    
    public static function verImagenesSlide(){

		$respuesta = GestorProductosModel::verImagenesSlide();

		return $respuesta;
	}
    
    
    
}
