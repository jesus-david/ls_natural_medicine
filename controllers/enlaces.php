<?php

class Enlaces{

	public static function enlacesController(){

		if(isset($_GET["action"])){
			
			if (strpos($_GET["action"], "_")) {
				
				$extracto = explode("_", $_GET["action"]);

				$_GET["action"] = $extracto[0];
				$_GET["id"] = $extracto[1];

			}

			$enlaces = $_GET["action"];

		}


		else{

			$enlaces = "index";

		}
			
		$respuesta = EnlacesModels::enlacesModel($enlaces);
		include $respuesta;


	}


}