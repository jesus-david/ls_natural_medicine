<?php
if(!isset($_SESSION)){ 
    session_start(); 
}
class GestorProductosController {

	public static function productos($p, $store = false){

		$paginas = 20;
		$pagina = GestorProductosController::validatePage($p);
		$search = isset($_SESSION["search_filter"]) ? $_SESSION["search_filter"] : false;

		if ($pagina != false) {
			
			$total = count(GestorProductosModel::productos($search));

			$total_paginas = ceil($total / $paginas);

			$inicio = ($pagina - 1) * $paginas;


			$productos = GestorProductosModel::productos_limite($search, $inicio, $paginas);

			return array("productos" => $productos, "paginas" => $total_paginas);

		}else{
			return [];
		}

		// $publicaciones = GestorProductosModel::publicaciones();

	}

	public static function ver_productos(){
		$productos = GestorProductosModel::ver_productos();

		return $productos;
				
	}
	public static function productos_relacionados($categorias, $id_producto){
		$productos = GestorProductosModel::productos_relacionados($categorias, $id_producto);

		return $productos;
				
	}
	public static function ver_info_producto($id){
        return GestorProductosModel::ver_info_producto($id);
    }

	public static function ver_info_producto_por_slug($slug){
        return GestorProductosModel::ver_info_producto_por_slug($slug);
    }

	public static function validatePage($p){

		$p = (int) $p;
		if ($p == "") {
			$p = false;
        }else if(is_string($p)){
            $p = false;
        }else{
			if (is_nan($p)) {
				$p = false;
			}else if($p <= 0){
				$p = false;
			}
		}
				
		return $p;

	}

	public static function check_link($link){

		$id = preg_replace('/[^0-9]+/i', '',$link);

		$res_1 = GestorProductosModel::check_product($link);
		if ($res_1) {
			return array("go" => "producto");
		}else{
			return false;
		}
		
		
	}

	public static function ago($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'año',
            'm' => 'mes',
            'w' => 'semana',
            'd' => 'día',
            'h' => 'hora',
            'i' => 'minuto',
            's' => 'segundo',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ?  'Hace ' . implode(', ', $string) : 'justo ahora';
	}
	
	public static function ver_config(){

		$resp = GestorProductosModel::ver_config();

		return $resp;
		
	}
	public static function ver_preguntas($id_publicacion){
		$preguntas = GestorProductosModel::ver_preguntas($id_publicacion);

		return $preguntas;
	}
	public static function ver_preguntas_sin_responder(){
		$preguntas = GestorProductosModel::ver_preguntas_sin_responder();

		return $preguntas;
	}

	public static function ask(){

		$info = GestorProductosModel::ask();
		$id_p = $_POST["id_producto"];
		$info_x = self::ver_info_producto($id_p);
		$host = $_SERVER['HTTP_HOST'];

		$temp1 = '
			<div style="width:100%; background:rgb(1, 174, 146); position:relative; font-family:sans-serif; padding-bottom:40px">

				<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">
				
					<center>
					
						<h3 style="font-weight:100; color:#999">Preguntas!</h3>
				
						<hr style="border:1px solid #ccc; width:80%">
				
						<h4 style="font-weight:100; color:#999; padding:0 20px">Un usuario te ha hecho una pregunta en un producto</h4>

						<div>
							<a href="'.$host.'\/backend\/answer_'.$info_x["id"].'" target="_blank">Ver pregunta</a>
						</div>
						
						<br>
				
						<hr style="border:1px solid #ccc; width:80%">
			
					</center>
			
				</div>
			
			</div>
		';

		Email::sendMail("martinez19florez@gmail.com", "Jesus David", "Pregunta sobre un producto", $temp1);

		return array("status" => true);
	}

}

?>