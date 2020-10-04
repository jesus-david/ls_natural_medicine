<?php 

class GestorCarritoModel{

    public static function actualizar_carrito(){

        $consulta = new Consulta();
        $items = $_SESSION["carrito"];
        $id = $_SESSION["id_usuario"];
        $str = json_encode($items);

        $consulta->actualizar_registro("UPDATE carrito set items = '$str' where id_usuario = '$id'");

        return array(
            'status' => true,
            "carritoString" => json_encode($items)
        );


    }
    public static function vaciar_carrito(){

        $consulta = new Consulta();
        $id = $_SESSION["id_usuario"];
        $str = json_encode(array());

        $consulta->actualizar_registro("UPDATE carrito set items = '$str' where id_usuario = '$id'");

        return array(
            'status' => true,
            "carritoString" => $str
        );


    }

    public static function validadPedido($arrayPedido){

        $consulta = new Consulta();
        $result = [];
        $error = false;
        
        foreach ($arrayPedido as $item) {


            $id = $item["idProducto"];
            $cantidad = $item["cantidad"];

            $producto = $consulta->ver_registros("SELECT * from productos where id = '$id'");
            
            if (!isset($producto[0])) {
                $error = true;
                break;
            }else if($cantidad > $producto[0]["inventario"]){
                $error = true;
                break;
            }
            $item["info"] = $producto[0];

            array_push($result,$item);
            
        }
        
        if ($error) {
            return array(
                'status' => false,
                "messaje" => "Ha ocurrido un error al procesar el pedido"
            );
        }

        return array(
            'status' => true,
            "pedido" => $result
        );

    

    }
    

    

}