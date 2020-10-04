<?php

class GestorCategoriasController {

		public static function verCategorias(){
			$categorias = GestorCategoriasModel::verCategorias();

			return $categorias;
					
		}

		public static function verCategoria($id){
			$categoria = GestorCategoriasModel::verCategoriaUnica($id);

			if (isset($categoria[0])) {
				return $categoria[0];
			}else{
				return null;
			}

			
			
		}

		public static function selectedC($item, $array){

			$selected = "";
	
			if (gettype($array) == "array") {
				for ($i=0; $i < count($array); $i++) { 
					if ($item['id'] == $array[$i]) {
						$selected = "selected";
					}
				}
			}
	
			
			return $selected;
		}
}

?>