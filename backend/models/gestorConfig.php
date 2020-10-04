<?php 

class GestorConfigModel{


	public static function ver_paginas_permitidas(){

		$consulta = new Consulta();

		$pages = $consulta->ver_registros("select * from config where config_code = 'SSU'");

		return $pages;
		
	}

	public static function ver_mis_config(){
		$consulta = new Consulta();

		$id = $_SESSION["id_usuario"];

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

	public static function ver_verif($to){

		$consulta = new Consulta();
		
		
		if ($to == 1) {
			$to = "admin";
		}else if ($to == 2) {
			$to = "saller";
		}


		$config = GestorConfigModel::watch__res($to);

		if ($to == "0") {

			$pages = GestorConfigModel::ver_paginas_permitidas();

			for ($i=0; $i < count($pages); $i++) { 
				$n = $pages[$i]["config_value"];
				$config->$n = true;
			}
		}

		return $config;	
		
	}
	public static function verficar_usuario(){

		$consulta = new Consulta();

		$t = ($_SESSION["tipo"] == 1) ? "admin" : "saller";

		$config = GestorConfigModel::watch__res($t);
		
		return $config;		
	}
	public static function update_field_config_user(){

		$consulta = new Consulta();

		$val = $_POST["value"];
		$key = $_POST["key"];
		$id = $_SESSION["id_usuario"];

		$array = $consulta->ver_registros("SELECT * from config where config_name = 'config_user'");

		$config = json_decode($array[0]["config_value"]);

	
		$config->$key = $val;

		$string = json_encode($config);
	
		$consulta -> actualizar_registro("UPDATE config set config_value = '$string' where config_name = 'config_user'");

		return array("status" => "ok");

	}


	public static function update_field_config(){

		$consulta = new Consulta();

		$val = $_POST["value"];
		$key = $_POST["key"];
		$id = $_POST["id_p"];
		$to = $_POST["to"];

		$config = GestorConfigModel::watch__res($to);
	
		if ($val == "true") {
			$config->$key = "true";
		}else{
			unset($config->$key);
		}
		$string = json_encode($config);
		$a = $to . "_r";

		$consulta -> actualizar_registro("update config set config_value = '$string' where config_name = '$a'");

		return "ok";

	}

	public static function watch__res($to){

		$consulta = new Consulta();
		$a = $to . "_r";
		
		$config = $consulta->ver_registros("select * from config where config_name = '$a'");

		if (isset($config[0])) {
			$array = json_decode($config[0]["config_value"]);

			return $array;
		}else{
			return json_decode("{}");
		}
		
		
	}

	public static function add_page_restrinction(){

		$consulta = new Consulta();

		$nombre = $_POST["nombre"];

		$consulta ->nuevo_registro("insert into config (config_name,config_value,config_code) values ('$nombre', 'true', 'SSU')");

		
		return array("status" => 'ok');


	}

	public static function divice_type(){
		  
		$tablet_browser = 0;
		$mobile_browser = 0;
		$body_class = 'desktop';
		
		if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			$tablet_browser++;
			$body_class = "tablet";
		}
		
		if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			$mobile_browser++;
			$body_class = "mobile";
		}
		
		if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
			$mobile_browser++;
			$body_class = "mobile";
		}
		
		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
		$mobile_agents = array(
			'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
			'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
			'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
			'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
			'newt','noki','palm','pana','pant','phil','play','port','prox',
			'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
			'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
			'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
			'wapr','webc','winw','winw','xda ','xda-');
		
		if (in_array($mobile_ua,$mobile_agents)) {
			$mobile_browser++;
		}
		
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
			$mobile_browser++;
			//Check for tablets on opera mini alternative headers
			$stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
			if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
			$tablet_browser++;
			}
		}

		return $body_class;
	}


}