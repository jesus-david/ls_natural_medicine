<?php 

    if(!isset($_SESSION["logged"])){
        echo "<script> window.location.href = 'login' </script>";
        exit();
    }

    $pedidos = GestorPedidosController::mis_pedidos(true);
    $pedidos_total = count(GestorPedidosController::mis_pedidos());
    $pedidos_procesados = count($pedidos);
    $config = GestorProductosController::ver_config();
    include 'nav_user.php';
?>

<div class="container">
    
    <div>
        <div class="me-info-head">
            <div class="avatar_">
                <img src="views/images/user.png" alt="">
            </div>
            <div>
                <h3 class="m-0"><?php echo $_SESSION["usuario"] ?></h3>
                <span class="text-muted"><?php echo $_SESSION["email"] ?></span>
            </div>
        </div>
        <hr class="m-0">
        <div class="me-info-details">

            <div class="detail-info-item">
                <span class="v zero"><?php echo $pedidos_total ?></span>
                <span class="d">Todos los pedidos</span>
            </div>
            <div class="detail-info-item">
                <span class="v zero"><?php echo $pedidos_procesados ?></span>
                <span class="d">Pendientes procesados</span>
            </div>
            <div class="detail-info-item">
                <span class="v"><?php echo count($_SESSION["carrito"]) ?></span>
                <span class="d">Carrito</span>
            </div>
            <!-- <div class="detail-info-item">
                <span class="v zero">0</span>
                <span class="d">Pendientes</span>
            </div> -->
        </div>
    </div>

    <br><br>

    <h3>Mis compras</h3>
    <p class="alert alert-primary">
        Recuerda que puedes calificar los pedidos ya procesados, da tu opinión.
    </p>

    <div class="">
    <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($pedidos as $item) { ?>

                <?php 
                    
                    if ($item["estado"] == "0") {
                        $estado = "<div class='badge badge-warning'>En espera</div>";
                    }else if($item["estado"] == "-1"){
                        $estado = "<div class='badge badge-danger'>Cancelado</div>";
                    }else if($item["estado"] == "1"){
                        $estado = "<div class='badge badge-primary'>Procesado</div>";
                    }else if($item["estado"] == "2"){
                        $estado = "<div class='badge badge-danger'>Rechazado</div>";
                    }
                    $total = 0;
                   
                 
                    for ($i=0; $i < count($item["items"]); $i++) { 
                        $p = $item["items"][$i];

                        $total += $p["precio_compra"];
                    }

                    if (isset($item["items"][0])) {
                        $f_p = GestorProductosController::ver_info_producto($item["items"][0]["id_producto"]);

                        // var_dump($f_p);
                        $n = (strlen($f_p["nombre"]) > 15) ? substr($f_p["nombre"], 0, 15) . "..." : $f_p["nombre"];

                    }
                ?>

                <tr>
                    <td>
                        #<?php echo $item["id"] ?>
                    </td>
                    <td><?php echo $item["fecha"] ?></td>
                    <td><?php echo $config->type_money ?><?php echo number_format($total,2,",",".") ?></td>
                    <td>
                        <?php echo $estado ?>
                        <?php if ($item["valorado"] == "0") { ?>
                            <img src="views/img/star.png" style="width: 25px;">
                        <?php } ?>
                    </td>						
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle bind_s" type="button" id="dropdownMenu<?php echo $item['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu<?php echo $item['id'] ?>">

                                <a class="dropdown-item ver_productos_pedido" data-id="<?php echo $item['id'] ?>" href="#">
                                    Ver productos
                                </a>
                                
                                <?php if ($item["estado"] == "0") { ?>
                                    <a class="dropdown-item cancelar_pedido" href="#" data-id="<?php echo $item['id'] ?>">
                                        Cancelar compra
                                    </a>
                                <?php } ?>
                                
                                <?php if ($item["estado"] == "-1" || $item["estado"] == "2") { ?>
                                    <a class="dropdown-item borrar_pedido" href="#" data-id="<?php echo $item['id'] ?>">Borrar</a>
                                <?php } ?>
                                
                                <?php if ($item["estado"] == "1") { ?>
                                    
                                    <?php if ($item["valorado"] == "0") { ?>
                                        <a class="dropdown-item sta valorar_" href="#" data-id="<?php echo $item['id'] ?>">
                                            Valorar <i class="icon-star"></i>
                                        </a>
                                    <?php } ?>
                                                                                
                                    <?php if ($item["valorado"] == "1") { ?>
                                        <a class="dropdown-item borrar_pedido_soft" href="#" data-id="<?php echo $item['id'] ?>" data-who="buyer">Borrar</a>
                                    <?php } ?>
                                                                                
                                <?php } ?>
                                
                            </div>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modal_productos">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Productos del pedido</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body ">

				<div class="shopping-cart-list">
					<div class="store-list single">
						<div class="card-container store-collection">
							<div class="shopping-cart-store">
								<div class="shopping-cart-product content_p"></div>
							</div>
						</div>
					</div>
				</div>
					
				
				
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modal_valoracion">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Valorar</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body ">
				
				<div class="text-muted">
					Ayuda a filtrar los productos, ¡Da tu opinión!
				</div>
				
                <label></label>
                
                <div class="content_set_reviews"></div>
				
			</div>
			<div class="modal-footer">
                <span class="message_v"></span>
				<button class="btn btn-primary" id="valorar">Valorar</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>