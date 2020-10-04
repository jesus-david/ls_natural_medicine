<?php
if(!isset($_SESSION)){ 
    session_start(); 
} 
class GestorCarritoController {


    public static function toogleItem(){
        $item = (object)  $_POST["item"];
        $items = $_SESSION["carrito"];

        $info = GestorProductosController::ver_info_producto($item->id);
        
        if (isset($info["nombre"])) {

            if (count($info["caracteristicas"])) {
                
                $sku_id = [];                
                foreach ($item->skus as $sku) {
                    if (gettype($sku) == "array") {
                        array_push($sku_id,$sku["child_id"]);
                    }else{
                        array_push($sku_id,$sku->child_id);
                    }
                }
                $sku_id = implode("#", $sku_id);
                $selected_sku = [];
                for ($i=0; $i < count($info["variantes"]); $i++) { 
                    if ($info["variantes"][$i]["sku"] == $sku_id) {
                        $selected_sku = $info["variantes"][$i];
                    }
                }

                if ($item->cantidad > $selected_sku["inventario"]) {
                    return array("status" => false);
                }


            }else if ($item->cantidad > $info["inventario"]) {
                return array("status" => false);
            }

            $item->id = $info["id"];
            // $item->id_usuario = $info["id_usuario"];
            $item->nombre = $info["nombre"];
            $item->caracteristicas = $info["caracteristicas"];
        }
        
       
        if (!GestorCarritoController::checkProductoInCart($item->sku)) {
           
            //agregar item            
            array_push($items,$item);
            $_SESSION["carrito"] = $items; 

            $resp = GestorCarritoModel::actualizar_carrito();

            return $resp;
        }else{

            // //eliminar item
            // $resp = GestorCarritoController::deleteProductFromCart($item->sku);

            // GestorCarritoModel::actualizar_carrito();

            // if (isset($_POST["reemplazar"])) {
            //     $items = $resp["reeplace"];

            //     array_push($items,$item);

            //     $_SESSION["carrito"] = $items; 
    
            //     $resp = GestorCarritoModel::actualizar_carrito();
    
            // }
            
            // return $resp;

            return array("status" => "already");
        }

        
    }

    public static function change_stock($sku, $cantidad){
        $items = $_SESSION["carrito"];

        $bool = false;

        for ($i=0; $i < count($items); $i++) { 
            if ($items[$i]->sku == $sku) {

                $info = GestorProductosController::ver_info_producto($items[$i]->id);

                if (count($info["caracteristicas"])) {
                
                    $sku_id = [];                
                    foreach ($items[$i]->skus as $sku) {
                        if (gettype($sku) == "array") {
                            array_push($sku_id,$sku["child_id"]);
                        }else{
                            array_push($sku_id,$sku->child_id);
                        }
                    }
                    $sku_id = implode("#", $sku_id);
                    $selected_sku = [];
                    for ($j=0; $j < count($info["variantes"]); $j++) { 
                        if ($info["variantes"][$j]["sku"] == $sku_id) {
                            $selected_sku = $info["variantes"][$j];
                        }
                    }
    
                    if ($cantidad > $selected_sku["inventario"]) {
                        return array("status" => false);
                    }
    
    
                }else if ($cantidad > $info["inventario"]) {
                    return array("status" => false);
                }


                $items[$i]->cantidad = $cantidad;

                break;
            }
        }

        $_SESSION["carrito"] = $items;

        $suma = GestorCarritoController::recount();

        

        GestorCarritoModel::actualizar_carrito();

        return array("status" => true, "total" =>  number_format($suma,2,",","."));
        
    }

    public static function recount(){
        $items = $_SESSION["carrito"];
        $suma = 0;

        for ($i=0; $i < count($items); $i++) { 
     
            $info = GestorProductosController::ver_info_producto($items[$i]->id);
            
            if (isset($info["nombre"])) {
                if ($info["oferta"] != 0.00) {
                    $suma += $info["oferta"] * $items[$i]->cantidad;
                }else{
                    $suma += $info["precio"] * $items[$i]->cantidad;
                }
                
            }
         
        }

        return $suma;
    }

    public static function vaciar_carrito(){

        $result = GestorCarritoModel::vaciar_carrito();

        $_SESSION["carrito"] = json_decode($result["carritoString"]);

        return array("status" => true);
    }

    public static function checkProductoInCart($sku){

        $items = $_SESSION["carrito"];

        $bool = false;

        for ($i=0; $i < count($items); $i++) { 
            if ($items[$i]->sku == $sku) {
                $bool = true;
                break;
            }
        }
        
        return $bool;
    }

    public static function deleteProductFromCart($sku){

        $items = $_SESSION["carrito"];
        $reeplace = [];
        
        for ($i=0; $i < count($items); $i++) { 
            if ($items[$i]->sku != $sku) {
                $obj = (object) $items[$i];
                array_push($reeplace,$obj);
            }
        }
        
        $_SESSION["carrito"] = $reeplace;

        GestorCarritoModel::actualizar_carrito();

        $suma = GestorCarritoController::recount();


        return array("status"=>"ok", "reeplace" => $reeplace, "carritoString" => json_encode($reeplace), "suma" => $suma);
    }




}
