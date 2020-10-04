<?php 
    $action = $_GET["action"];


    $accepted = GestorProductosController::check_link($action);

    if(!$accepted){
		echo "<script> window.location.href = '404' </script>";
	  	exit();
    }else{
        if ($accepted["go"] == "producto") {
            include "producto.php";
        }
        if ($accepted["go"] == "store") {
            include "store.php";
        }
        
    }
    

?>