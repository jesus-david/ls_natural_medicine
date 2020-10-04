<?php 
// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);
class templateControllers{
	public function template()
	{
		if (isset($_GET["action"])) {
			if ($_GET["action"] == "exportOrder") {
				// $id = $_GET["id"];
				// echo "EXPORTAR";
				include 'views/modules/exportOrder.php';
			}else if ($_GET["action"] == "exportProduct") {
				// $id = $_GET["id"];
				// echo "EXPORTAR";
				include 'views/modules/exportProduct.php';
			}else{
				include 'views/template.php';
			}
		}else{
			include 'views/template.php';
		}
	}
}
