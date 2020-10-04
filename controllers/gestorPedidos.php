<?php
if(!isset($_SESSION)){ 
    session_start(); 
}
class GestorPedidosController {

    public static function mis_pedidos($procesados = false){
        
        $pedidos = GestorPedidosModel::mis_pedidos($procesados);

        return $pedidos;
        
    }

    public static function mis_ventas(){
        
        $pedidos = GestorPedidosModel::mis_ventas();

        return $pedidos;
        
    }

    public static function mis_opiniones(){
        
        $opiniones = GestorPedidosModel::mis_opiniones();

        return $opiniones;
        
    }

    public static function verItemsPedido(){
        $id = $_POST["id"];
        
        $pedidos = GestorPedidosModel::verItemsPedido($id);

        return $pedidos;
        
    }

    public static function pedido_entregado(){
        $id_pedido = $_POST["id_pedido"];
        
        $resp = GestorPedidosModel::pedido_entregado($id_pedido);

        return $resp;
        
    }

    public static function cancelar_compra(){
        $id_pedido = $_POST["id_pedido"];
        
        $resp = GestorPedidosModel::cancelar_compra($id_pedido);

        return $resp;
        
    }
    public static function borrar_pedido(){
        $id_pedido = $_POST["id_pedido"];
        
        $resp = GestorPedidosModel::borrar_pedido($id_pedido);

        return $resp;
        
    }
    public static function borrar_pedido_soft(){
       
        $resp = GestorPedidosModel::borrar_pedido_soft();

        return $resp;
        
    }
    public static function valorar(){
       
        $resp = GestorPedidosModel::valorar();

        return $resp;
        
    }
    
    public static function crear_pedido(){
  
        $id_usuario = $_SESSION["id_usuario"];
        
        $resp = GestorPedidosModel::crear_pedido();

        if ($resp["status"] == true) {
            // echo $id_usuario;
            $comprador = AuthController::ver_info_usuario($id_usuario, false);

            // var_dump($comprador);

            $c_nombre = $comprador["nombre"];
            $c_email = $comprador["email"];

            $temp = GestorPedidosController::templateMail("Nuevo pedido.", "Te han realizado un pedido, ingresa a tu cuenta para más detalles. <br> Comprador: $c_nombre ( $c_email )","#", "Pedidos");

            Email::sendMail("martinez19florez@gmail.com", "Jesus David", "¡Nuevo Pedido!", $temp);


            // if (isset($comprador["email"])) {
            //     $c_nombre = $vendedor["nombre"];
            //     $c_email = $vendedor["email"];

            //     $temp = GestorPedidosController::templateMail("Información de contacto.", "Has realizado un pedido. <br> Vendedor: $c_nombre ( $c_email )","http://guaraba.com/compras", "Mis compras");

            //     Email::sendMail($comprador["email"], $comprador["nombre"], "Información", $temp);
            // }
            
        }
        
        

        return $resp;
        
    }

    public static function templateMail($title, $desc, $link, $text_link){

        return '
            <body style="margin: 0; padding: 0;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
                    <tr>
                        <td style="padding: 10px 0 30px 0;">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                                <tr>
                                    <td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/h1.gif" alt="Creating Email Magic" width="300" height="230" style="display: block;" />
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                                    <b>'.$title.'</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                    '.$desc.' <br><br>

                                                    <b><a href="'.$link.'">'.$text_link.'</a></b>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
            ';
    }

    
}
