<?php 
if(!isset($_SESSION)){ 
    session_start(); 
} 
class GestorCategoriasController{

	public static function jsonCategories(){

        $categorias = GestorCategoriasModel::jsonCategories();
     
		return $categorias;

    }
    
    public static function categorias(){

        $categorias = GestorCategoriasModel::categorias();
     
		return $categorias;

    }
    
    public static function crear(){

        $validado = GestorCategoriasController::validar($_POST);

        if ($validado["status"] == "error") {
            return $validado;
        }else{

            $resp = GestorCategoriasModel::sim($_POST, "crear");
            return $resp;
        }

        
    }
    public static function actualizar(){

        $validado = GestorCategoriasController::validar($_POST);

        if ($validado["status"] == "error") {
            return $validado;
        }else{

            $resp = GestorCategoriasModel::sim($_POST, "actualizar", $_POST["id"]);
            
            return $resp;
        }

        
    }
    
    public static function validar($datos){
        $validado = array(
            "razon" => "",
            "mensaje" => "",
            "status" => "valido"
        );

        if ($datos["nombre"] == "") {
            $validado = array(
                "razon" => "campos vacíos",
                "mensaje" => "Por favor llene los campos, requeridos",
                "status" => "error"
            );
        }

        return $validado;

    }

    public static function selectedC($item, $array){

        $selected = "";

        for ($i=0; $i < count($array); $i++) { 
            if ($item['id'] == $array[$i]) {
                $selected = "selected";
            }
        }
        return $selected;
    }


    public static function procesar_files($file_p,$id_empresa){
		
		$files = [];
		$file_count = count($file_p["name"]);
		$file_keys = array_keys($file_p);
		$srcs = [];

		for ($i=0; $i < $file_count; $i++) { 
			foreach ($file_keys as $key) {
				$files[$i][$key] = $file_p[$key][$i];
			}
		}

		$orden = GestorCategoriasModel::ver_ultimo_archivo($id_empresa);
		
		for ($i=0; $i < count($files); $i++) { 

			$orden++;

			$random = rand(0,10000);

			if(isset($files[$i]["tmp_name"]) && $files[$i]["tmp_name"] != ""){

				$file = $files[$i]["tmp_name"];

				if ($files[$i]["type"] == "application/pdf"){
					if (is_uploaded_file($file)) {

						$ruta_aux = "views/images/catalogos/c_pdf_$random-$orden-$id_empresa.pdf";
						
						$res_move = move_uploaded_file($file, "../../".$ruta_aux);
						

						$aux_file = [
						    'path' => $ruta_aux,
						  	'type' => "pdf"
						];

						array_push($srcs, $aux_file);
					}
				}else if ($files[$i]["type"] == "image/jpeg" || $files[$i]["type"] == "image/png" || $files[$i]["type"] == "image/jpg"){
					if (is_uploaded_file($file)) {

						$ruta_aux = "views/images/catalogos/c_img_$random-$orden-$id_empresa.jpg";
						
						$res_move = move_uploaded_file($file, "../../".$ruta_aux);
						

						$aux_file = [
						    'path' => $ruta_aux,
						  	'type' => "image"
						];

						array_push($srcs, $aux_file);
					}
				}


			}
			
		}

		return $srcs;

	}

    public static function add_files_(){

		$id_empresa = $_POST["id"];


		$srcs = GestorEmpresasController::procesar_files($_FILES["files_catalogos"],$id_empresa);

		$resp = GestorEmpresasModel::guardar_files($srcs, false, $id_empresa);

		
		$arr["status"] = "ok";

		return $arr;
		
		
    }


    public static function borrar_lista_categorias(){
        $lista = $_POST["lista"];
        return GestorCategoriasModel::borrar_lista_categorias($lista);
    
    }
    public static function borrar_catalogo(){
        
        return GestorCategoriasModel::borrar_catalogo();
    
    }
    
    //sin uso
    public static function actualizar_estados(){
        $lista = $_POST["lista"];
        $estado = $_POST["estado"];
        return GestorCategoriasModel::actualizar_estados($lista, $estado);
    
    }
    public static function actualizar_tipos(){
        $lista = $_POST["lista"];
        $tipo = $_POST["tipo"];
        return GestorCategoriasModel::actualizar_tipos($lista, $tipo);
    
    }
    
    
}
