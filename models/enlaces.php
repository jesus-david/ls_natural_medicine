<?php

class EnlacesModels{

	public static function enlacesModel($enlaces){

		if( $enlaces == "index" ||
			$enlaces == "shop" ||
			$enlaces == "producto" ||
			$enlaces == "404" ||
			$enlaces == "login" ||
			$enlaces == "registro" ||
			$enlaces == "cerrarSesion" ||
			$enlaces == "orders" ||
			$enlaces == "settings" ||
			$enlaces == "about" ||
			$enlaces == "contact" ||			
			$enlaces == "cart" ||
			$enlaces == "profile"){

			$module = "views/modules/".$enlaces.".php";

		}
		else if($enlaces == "index"){
			$module = "views/modules/index.php";
		}else{
			$module = "views/modules/redirect.php";
		}

		return $module;

	}


}