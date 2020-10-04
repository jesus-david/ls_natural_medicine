<?php 

class GestorPedidosModel{

	public static function jsonOrders(){

		$consulta = new Consulta();

		$sql = "";
		if (isset($_SESSION["filtrarOrders"])) {
			$q = $_SESSION["filtrarOrders"];

			$clientes = $consulta->ver_registros("SELECT * from clientes where nombre like '%$q%'");
		
			$sql = "where fecha like '%$q%'"; 

			for ($i=0; $i < count($clientes); $i++) { 
				$id_s = $clientes[$i]["id"];

				if ($sql != "") {
					$sql .= " or id_comprador = '$id_s'"; 
				}else{
					$sql = " where id_comprador = '$id_s'"; 
				}
				
			}
		

		}

		
		
		$pedidos = $consulta->ver_registros("SELECT * from pedidos $sql order by id desc");
		
		// var_dump($pedidos);
	
		for ($i=0; $i < count($pedidos); $i++) { 
			$id = $pedidos[$i]["id"];
			$id_c = $pedidos[$i]["id_comprador"];

			$items = $consulta->ver_registros("SELECT * from items_pedidos inner join productos on productos.id = items_pedidos.id_producto where items_pedidos.id_pedido  = '$id' ");
			$total = 0;
			for ($j=0; $j < count($items); $j++) { 
				$items[$j]["skus"] = json_decode($items[$j]["skus"]);	
				$total += $items[$j]["precio_compra"];
			}
			
			$c = $consulta->ver_registros("SELECT * from clientes where id  = '$id_c' ");

			$pedidos[$i]["productos"] = $items;
			$pedidos[$i]["total"] = $total;
			// 					
			$pedidos[$i]["cliente"] = isset($c[0]) ? $c[0] : [];
			
		}
		
		
		return $pedidos;

	}
	public static function pedidos(){

		$consulta = new Consulta();

		$sql = "";
		
		$pedidos = $consulta->ver_registros("SELECT * from pedidos");
	
	
		return $pedidos;

	}
	public static function searchCode(){

		$consulta = new Consulta();

		$search = $_POST["search"];
		
		$productos = $consulta->ver_registros("SELECT * from productos where codigo like '%$search%' or nombre like '%$search%' and inventario > '1' and estado = '1'");
	
	
		return $productos;

	}

	public static function ver_items_pedido($id){

        $consulta = new Consulta();

        $info = $consulta->ver_registros("SELECT * from pedidos where id = '$id'");
		$items = $consulta->ver_registros("SELECT * from items_pedidos where id_pedido = '$id'");

		for ($i=0; $i < count($items); $i++) { 
			$id_p = $items[$i]["id_producto"];
			$infop = $consulta->ver_registros("SELECT * from productos where id = '$id_p'");
			$items[$i]["limite"] = $infop[0]["inventario"];
			$items[$i]["precio"] = $items[$i]["precio_actual"];
		}

		
		$info = count($info) != 0 ? $info[0] : [];

		$id_usuario = $info["id_usuario"];

		$info["items"] = $items;
		$info["clientes"] = GestorPedidosModel::clientes_usuario($id_usuario);
		

        return $info;

	}

	public static function ver_cliente_por_id_pedido($id){
        $consulta = new Consulta();
        $idCliente = $consulta -> ver_registros("SELECT id_comprador from pedidos where id = '$id'");
        $cliente = [];
        if (isset($idCliente[0]["id_comprador"])) {
            $idc = $idCliente[0]["id_comprador"];

            $cliente = $consulta->ver_registros("SELECT * from clientes where id = '$idc'");
        }

        return isset($cliente[0]) ? $cliente[0] : [];
	}

	public static function actualizar_estados($lista, $estado){

		$consulta = new Consulta();
		
		for ($i=0; $i < count($lista); $i++) { 
			
			$id = $lista[$i];
			$info = $consulta->ver_registros("SELECT estado from pedidos where id = '$id'");
			$cliente = self::ver_cliente_por_id_pedido($id);


			if ($info[0]["estado"] != "1") {
				if ($estado == "1") {
		
					$consulta->actualizar_registro("UPDATE pedidos set estado = '$estado' where id = '$id'");
				
					$temp = self::templateMail("Pedido procesado", "Tu pedido ha sido procesado, ingresa a tu cuenta y califica los productos. ","#", "ir a mis pedidos");

           			Email::sendMail($cliente["email"], $cliente["nombre"], "¡Pedido procesado!", $temp);
				
				}else{
					$consulta->actualizar_registro("UPDATE pedidos set estado = '$estado' where id = '$id'");
			
					if ($estado == "2") {
						$temp = self::templateMail("Pedido rechazado", "Te han realizado un pedido, ingresa a tu cuenta para más detalles. ","#", "ir a mis pedidos");

           				Email::sendMail($cliente["email"], $cliente["nombre"], "¡Pedido rechazado!", $temp);
					}
				
				}
			}else{
				return array("status" => false, "message" => "Este pedido ya ha sido procesado, no puedes cambiar su estado.");
			}

			
		}

        return array("status" => "ok");

	}

	public static function borrar_lista_pedidos($lista){

		$consulta = new Consulta();
		
		for ($i=0; $i < count($lista); $i++) { 
			
			$id = $lista[$i];
			$back = false;
			$pedido = $consulta->ver_registros("SELECT * from pedidos where id = '$id'");
			$items = $consulta->ver_registros("SELECT * from items_pedidos where id_pedido = '$id'");
			$verif = GestorConfigController::verficar_usuario("deleteGeneralOrders", false);

			if ($pedido[0]["id_usuario"] == $_SESSION["id_usuario"]) {
				if ($pedido[0]["procesado"] != '1' || $_SESSION["tipo"] == '0') {
					$consulta->borrar_registro("DELETE from pedidos where id = '$id'");
					$consulta->borrar_registro("DELETE from items_pedidos where id_pedido = '$id'");
					
					if ($pedido[0]["procesado"] != '1') {
						//regresar inventario
						$back = true;
					}
				}else{
					return array("status"=> false, "message" => "No puedes borrar pedidos procesados");
				}
			}else if ($verif || $_SESSION["tipo"] == '0') {
				$consulta->borrar_registro("DELETE from pedidos where id = '$id'");
				$consulta->borrar_registro("DELETE from items_pedidos where id_pedido = '$id'");

				if ($pedido[0]["procesado"] != '1') {
					//regresar inventario
					$back = true;
				}
			}else{
				return array("status"=> false, "message" => "No tienes privilegios para borrar pedidos de otros usuarios");
			}

			if ($back) {
				for ($j=0; $j < count($items); $j++) { 
					$item = $items[$j];
					$id_producto = $item["id_producto"];
					$cantidad = $item["cantidad"];
					$producto = $consulta->ver_registros("SELECT inventario from productos where id = '$id_producto'");

					$n_inventario = $producto[0]["inventario"] + $cantidad;

					$consulta->actualizar_registro("UPDATE productos set inventario = '$n_inventario' where id = '$id_producto'");
				}
			}

		
		}

        return array("status" => "ok");

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
