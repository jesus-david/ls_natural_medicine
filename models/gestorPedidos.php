<?php

class GestorPedidosModel
{
    public static function mis_pedidos($procesado){
        $consulta = new Consulta();
        
        $id_usuario = $_SESSION["id_usuario"];
        $sql = "";
        if ($procesado) {
            $sql = " AND estado = '1'";
        }

        $pedidos = $consulta -> ver_registros("SELECT * from pedidos where id_comprador = '$id_usuario' AND soft_delete_buyer = '0' $sql order by fecha desc");

        
        for($i = 0; $i < count($pedidos); $i++) {
            $item = $pedidos[$i];
            $id_pedido = $item["id"];
            $items = GestorPedidosModel::verItemsPedido($id_pedido);

            $pedidos[$i]["items"] = $items;
        }

        return $pedidos;

    }

    public static function mis_ventas(){
        $consulta = new Consulta();
        
        $id_usuario = $_SESSION["id_usuario"];

        $pedidos = $consulta -> ver_registros("SELECT * from pedidos where id_vendedor = '$id_usuario' AND soft_delete_seller = '0' order by fecha desc");

        
        for($i = 0; $i < count($pedidos); $i++) {
            $item = $pedidos[$i];
            $id_pedido = $item["id"];
            $items = GestorPedidosModel::verItemsPedido($id_pedido);

            $pedidos[$i]["items"] = $items;
        }

        return $pedidos;

    }

    public static function mis_opiniones(){
        $consulta = new Consulta();
        
        $id_usuario = $_SESSION["id_usuario"];

        $opiniones = $consulta -> ver_registros("SELECT * from opiniones where id_vendedor = '$id_usuario' order by fecha desc");

        $total = count($opiniones) * 5;
        $sum_t = 0;
    
        for($i = 0; $i < count($opiniones); $i++) {
            $item = $opiniones[$i];
            $id_public = $item["id_producto"];
            $f = $item["fecha"];

            $publicacion = $consulta->ver_registros("SELECT * from publicaciones where id = '$id_public'");

            $opiniones[$i]["format"] = date("M",strtotime($f)) . " " .date("d",strtotime($f)) . ", ". date("Y",strtotime($f));
            $opiniones[$i]["skus"] = ($opiniones[$i]["skus"] != "") ? json_decode($opiniones[$i]["skus"]) : [];
            $opiniones[$i]["usuario"] = isset($publicacion[0]) ? $publicacion[0]["nombre"] : "";


            $sum_t += $item["valor"];            
        }

        $porcentaje = ($sum_t > 0) ? ($sum_t * 100) / $total : 0;

        $arr = array(
            "porcentaje" => $porcentaje,
            "porcentaje_base_5" => ($porcentaje > 0) ? ($porcentaje / 100) * 5 : 0,
            "items" => $opiniones,            
        );

        return $arr;

    }

    public static function verItemsPedido($id){
        $consulta = new Consulta();

        $items = $consulta -> ver_registros("SELECT * from items_pedidos where id_pedido = '$id'");
        
        for ($i=0; $i < count($items); $i++) { 

            $info = GestorProductosController::ver_info_producto($items[$i]["id_producto"]);

            if ($items[$i]["skus"] != "") {
                $items[$i]["skus"] = json_decode($items[$i]["skus"]);
            }

            if (isset($info["nombre"])) {
                $items[$i]["info"] = $info;
            }else{
                $items[$i]["info"] = [];
            }
            
        }

        return $items;
    }

    public static function pedido_entregado($id_pedido){
        $consulta = new Consulta();
        
        $id_usuario = $_SESSION["id_usuario"];

        $pedido = $consulta -> ver_registros("SELECT * from pedidos where id = '$id_pedido'");
        $consulta->actualizar_registro("UPDATE pedidos set estado = '1' where id = '$id_pedido'");

        //todo:
    

        return array("status" => true);

    }

    public static function cancelar_compra($id_pedido){
        $consulta = new Consulta();
        
        $id_usuario = $_SESSION["id_usuario"];

        $pedido = $consulta -> ver_registros("SELECT * from pedidos where id = '$id_pedido'");
        $consulta->actualizar_registro("UPDATE pedidos set estado = '-1' where id = '$id_pedido'");


        if (isset($pedido[0])) {
            
            $items = GestorPedidosModel::verItemsPedido($id_pedido);

            for ($i=0; $i < count($items); $i++) { 
                
                $item = $items[$i];
                $info = GestorProductosController::ver_info_producto($item["id_producto"]);

                if (isset($info["nombre"])) {
                    $id_p = $info["id"];
                    if ($item["sku"] != "") {
                        
                        for ($j=0; $j < count($info["variantes"]); $j++) { 
                            if ($info["variantes"][$j]["sku"] == $item["sku"]) {
                                $n_stock = $info["variantes"][$j]["inventario"] + $item["cantidad"];  
                                $s_k = $item["sku"];
                                $consulta->actualizar_registro("UPDATE variantes set inventario = '$n_stock' where sku = '$s_k'");
                                break;
                            }
                        }

                    }else{
    
                        $n_stock = $info["inventario"] + $item["cantidad"];
    
                        $consulta->actualizar_registro("UPDATE productos set inventario = '$n_stock' where id = '$id_p'");
    
                    }
                }

               
            }



        }
    

        return array("status" => true);

    }

    public static function borrar_pedido($id_pedido){
        $consulta = new Consulta();
        
        $id_usuario = $_SESSION["id_usuario"];

        
        $consulta->borrar_registro("DELETE from pedidos where id = '$id_pedido'");
        $consulta->borrar_registro("DELETE from items_pedidos where id_pedido = '$id_pedido'");


        return array("status" => true);

    }

    public static function borrar_pedido_soft(){
        $consulta = new Consulta();
        
        $id_usuario = $_SESSION["id_usuario"];
        $id_pedido = $_POST["id_pedido"];
        $who = $_POST["who"];

        if ($who == "seller") {
            $consulta->actualizar_registro("UPDATE pedidos set soft_delete_seller = '1' where id = '$id_pedido'");
        }else{
            $consulta->actualizar_registro("UPDATE pedidos set soft_delete_buyer = '1' where id = '$id_pedido'");
        }
        
        

        return array("status" => true);

    }

    public static function valorar(){
        $consulta = new Consulta();
        
        $id_usuario = $_SESSION["id_usuario"];
        $reviews = $_POST["reviews"];

        // return $reviews;


        $id = $_POST["id"];
        
        $hoy = date("Y-m-d H:i:s");

        $info = $consulta->ver_registros("SELECT * from pedidos where id = '$id'");

        if (isset($info[0])) {
            
            $info = $info[0];            
            $items = $consulta->ver_registros("SELECT * from items_pedidos where id_pedido = '$id'");
            $comprador = $info["id_comprador"];

            for ($i=0; $i < count($items); $i++) { 
                
                $skus = $items[$i]["skus"];
                $id_producto = $items[$i]["id_producto"];
                $valor = 0;
                $comment = "";

                for ($j=0; $j < count($reviews); $j++) { 
                    if ($reviews[$j]["id"] == $id_producto) {
                        $valor = $reviews[$j]["val"];
                        $comment = htmlspecialchars($reviews[$j]["comment"], ENT_QUOTES);
                        break;
                    }
                }

                $consulta->nuevo_registro("INSERT into opiniones (id_producto, id_comprador, valor, comentario, skus, fecha) values ('$id_producto', '$comprador', '$valor', '$comment', '$skus', '$hoy')");

                $consulta->actualizar_registro("UPDATE pedidos set valorado = '1' where id = '$id'");
            }


        }
 

        

        return array("status" => true);

    }

    public static function crear_pedido(){
        $consulta = new Consulta();
        
        $id_usuario = $_SESSION["id_usuario"];
        $items = $_SESSION["carrito"];

        $arr_p = [];

        for ($i=0; $i < count($items); $i++) { 

            $item = $items[$i];
            $info = GestorProductosController::ver_info_producto($item->id);

            //validación de producto
            if (isset($info["nombre"])) {
                //validación de inventario
                if (count($info["variantes"])) {
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
                    for ($j=0; $j < count($info["variantes"]); $j++) { 
                        if ($info["variantes"][$j]["sku"] == $sku_id) {
                            $selected_sku = $info["variantes"][$j];
                        }
                    }

                    if ($item->cantidad > $selected_sku["inventario"]) {
                        $item->cantidad = $selected_sku["inventario"];
                    }

                    $info["selected_sku"] = $selected_sku;
                    $info["skus"] = $item->skus;
                    $info["sku"] = $sku_id;

                }else{
                    if ($item->cantidad > $info["inventario"]) {
                        $item->cantidad = $info["inventario"];
                    }
                }

                $info["cantidad_compra"] = $item->cantidad;
                

                array_push($arr_p, $info);
            }
            
        }


        if (count($arr_p)) {
            
            $hoy = date("Y-m-d H:i:s");

            $consulta->nuevo_registro("INSERT into pedidos (id_comprador, estado, valorado, fecha, soft_delete_seller, soft_delete_buyer) values('$id_usuario', '0', '0','$hoy', '0', '0')");

            $r = $consulta->ver_registros("SELECT max(id) as id from pedidos");

            $id_pedido = $r[0]["id"];
            
            for ($i=0; $i < count($arr_p); $i++) { 
                $producto = $arr_p[$i];
                $id_producto = $producto["id"];
                $precio_compra = ($producto["oferta"] != 0.00) ? $producto["oferta"] : $producto["precio"];
                $c = $producto["cantidad_compra"];

            
                if (count($producto["variantes"])) {
                    $json_sku = json_encode($producto["skus"]);
                    $sku = $producto["sku"];

                    $consulta->nuevo_registro("INSERT into items_pedidos (id_pedido, id_producto, precio_compra, cantidad, skus,sku) values('$id_pedido', '$id_producto', '$precio_compra', '$c', '$json_sku', '$sku')");
                    
                    $n_stock = $producto["selected_sku"]["inventario"] - $c;
                   
                    $consulta->actualizar_registro("UPDATE variantes set inventario = '$n_stock' where sku = '$sku'");

                }else{
                    $consulta->nuevo_registro("INSERT into items_pedidos (id_pedido, id_producto, precio_compra, cantidad, skus,sku) values('$id_pedido', '$id_producto', '$precio_compra', '$c', '', '')");

                    $n_stock = $producto["inventario"] - $c;

                    $consulta->actualizar_registro("UPDATE productos set inventario = '$n_stock' where id = '$id_producto'");
                }
                

            }

            $_SESSION["carrito"] = [];

            return array("status"=> true, "array" => $arr_p);
        }

        return array("status"=> false, "message" => "Sin productos disponibles en el pedido.");

    }

  

}

?>