<?php

class EnlacesModels{

	public static function enlacesModel($enlaces){

		// var_dump($enlaces);

		if( $enlaces == "emptyPage" ||
			$enlaces == "jsonUsers" ||
			$enlaces == "usuarios" ||
			$enlaces == "listUsers" ||
			$enlaces == "security" ||
			$enlaces == "orders" ||
			$enlaces == "profile" ||
			$enlaces == "dashboard" ||
			$enlaces == "routes" ||
			$enlaces == "addUser" ||
			$enlaces == "login" ||
			$enlaces == "editUser" ||
			$enlaces == "cerrarSesion" ||
			$enlaces == "newProduct" ||
			$enlaces == "editProduct" ||
			$enlaces == "products" ||
			$enlaces == "clients" ||
			$enlaces == "editClient" ||
			$enlaces == "detailsProduct" ||
			$enlaces == "galery" ||
			$enlaces == "tempSent" ||
			$enlaces == "viewUser" ||
			$enlaces == "categories" ||
			$enlaces == "preguntas"
		){
				
			$module = "views/modules/".$enlaces.".php";

		}
		else if($enlaces == "index" || $enlaces == ""){
			$module = "views/modules/index.php";
		}else{
			$module = "views/modules/404.php";
		}

		return $module;

	}


}