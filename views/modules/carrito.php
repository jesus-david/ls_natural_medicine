<?php 

	if(!isset($_SESSION["usuario_validado"])){
		echo "<script> window.location.href = 'login' </script>";
		exit();
	}

	include "sidebar-perfil.php"; 

	$items = $_SESSION["carrito"];

	$stores = [];

	foreach ($items as $item) {
		$_id = $item->id_usuario;

		if (!isset($stores[$_id])) {
			$stores[$_id] = [];
		}
	
		array_push($stores[$_id], $item);
	}

?>

<div class="col-md-9  mt-3 p-2 col-md-9 animaciones">
    <div class="elementos-perfil p-3 bg-white mb-3" style="border-radius: 3px;">
        <div class="titulo-compras">
            <h4>
                <i class="fas fa-shopping-cart"></i> Carrito (<?php echo count($items) ?>)
            </h4>
        </div>

        <div class="contenidos-compras">
			<?php if (count($items) == 0) { ?>
				<div class="compra-elemento mt-4">
					<p class="btn-block p-3"
						align="center"
						style="background-color: #e4f2f9;
							border-radius: 5px;
							font-size: 13px;">
						Tu carrito está vación, ve a <a href="publicaciones_1">explorar</a>
					</p>
				</div>
			<?php } ?>
            
        </div>
    </div>

    <div class="shopping-cart-list">
        
		<?php foreach ($stores as $item) { ?>

			<?php 
								
				$user = AuthController::ver_info_usuario($item[0]->id_usuario, false);
				$store = GestorConfigController::store_id_user($item[0]->id_usuario);

	

				$title_store = $user["nombre"];
				$link_store = "#";
				$total = 0;
												
				if (isset($store["nombre"])) {
					$link_store = preg_replace('([^A-Za-z0-9])', '', $store['nombre']) . $store["id"];
					$title_store = $store["nombre"];
				}
			?>

			<div class="store-list single" id="store__<?php echo $user['id'] ?>">
            	<div class="card-container store-collection">
			
					<div class="shopping-cart-store">
						<div class="store-name">                      
							<div class="store-name-head">
								<a class="store-name-link" href="<?php echo $link_store ?>">
									<?php echo $title_store ?> 
								</a>            
								<span class="float-right">
									<span class="star-view"><span style="width:75%"></span></span>
								</span>               
							</div>
						</div>				

						<?php foreach ($item as $public) { ?>

							<?php 
								$info = GestorPublicacionesController::ver_info_producto($public->id);
								
								$img = "";

								if (!isset($info["nombre"])) {
									
									$is_id = $user['id'] ;

									echo "<div class='alert alert-info'>Este producto fue borrardo.</div>";

									echo "
										<button class='btn btn-danger opt-btn deleteFromCart' data-sku='$public->sku' data-id-u='$is_id' data-p-id='$public->id'>
											<i class='fas fa-trash'></i>
										</button>
									";

									continue;
								}

								if (isset($info["galeria"])) {
									$img = $info["galeria"][0]["path_media"];
								}
		
								$porcentaje_oferta = 0;

								if ($info["oferta"] != 0.00) {
									$porcentaje_oferta = ($info["oferta"] * 100) / $info["precio"];
									$porcentaje_oferta = ceil(100 - $porcentaje_oferta);
									$total += $info["oferta"] * $public->cantidad;
								}else{
									$total += $info["precio"] * $public->cantidad;
								}


								$sku_id = [];             
								if (count($info["variantes"])) {

									foreach ($public->skus as $sku) {
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
								}   
								
								
							?>

							<?php if (isset($info["nombre"])) { ?>
								<div class="shopping-cart-product" id="product_store_<?php echo $info["id"] ?>">
									<div class="product-container row">                          
										<div class="product-field product-image col-md-2">
											<a href="#">
												<img src="<?php echo $img ?>"/>
											</a>
										</div>
										<div class="product-field product-main col-md-6">
											<div class="product-title">
												<a href="<?php echo $info['slug'] ?>" class="product-name-link">
													<?php echo $info["nombre"] ?>
												</a>
											</div>
											<div class="product-attr">
												<div class="product-sku">
													<?php if (isset($public->skus)) { ?>
														<dl>
															<?php foreach ($public->skus as $sku) { ?>
																
																<?php if (gettype($sku) == "array") { ?>
																	<dt>
																		<?php echo $sku["name"] ?>:
																	</dt>
																	<dd>
																		<span><?php echo $sku["value"] ?></span>
																	</dd>

																<?php } ?>
																<?php if (gettype($sku) == "object") { ?>
																	<dt>
																		<?php echo $sku->name ?>:
																	</dt>
																	<dd>
																		<span><?php echo $sku->value ?></span>
																	</dd>

																<?php } ?>
																
															<?php } ?>									
														</dl>
													<?php } ?>
													
												</div>
											</div>
											<div class="product-price">

												<?php if ($info["oferta"] != 0.00) { ?>
													<div class="cost-main normal">
														<span class="main-cost-price">
															$ <span class="price"><?php echo number_format($info["oferta"],2,",",".") ?></span>
														</span>
													</div>
													<div class="cost-extend">
														<span class="old_price del">
															$ <?php echo number_format($info["precio"],2,",",".") ?>
														</span>
														<span class="percent_offert">
															-<?php echo $porcentaje_oferta ?>%
														</span>
													</div>
													
												<?php } ?>

												<?php if($info["oferta"] == 0.00){ ?>
													<div class="cost-main normal">
														<span class="main-cost-price">
															$ <span class="price"><?php echo number_format($info["precio"],2,",",".") ?></span>
														</span>
													</div>
													
												
												<?php } ?>

											</div>
										
										</div>
										<div class="product-field product-opt col-md-4">
											<div class="opt-group">
												<button class="btn btn-danger opt-btn deleteFromCart" data-sku="<?php echo $public->sku ?>" data-id-u="<?php echo $user['id'] ?>" data-p-id="<?php echo $info["id"] ?>">
													<i class="fas fa-trash"></i>
												</button>
											</div>
											<div class="product-num i-spinner">

											<?php if (count($info["variantes"]) == 0) { ?>
												<?php if ($info["inventario"] != 0) { ?>
													<input type="number" min="0" max="<?php echo $info["inventario"] ?>" step="1" id="cantidad" class="change_stock" data-sku="<?php echo $public->sku ?>" data-id-u="<?php echo $user['id'] ?>" value="<?php echo $public->cantidad ?>" />
												<?php } ?>												
												<?php if ($info["inventario"] == 0) { ?>
													<div class="alert alert-danger mt-2">¡Agotado!</div>
												<?php } ?>
											<?php } ?>

											<?php if (count($info["variantes"])) { ?>
												<input type="number" min="0" max="<?php echo $selected_sku["inventario"] ?>" step="1" id="cantidad" class="change_stock" data-sku="<?php echo $public->sku ?>" data-id-u="<?php echo $user['id'] ?>" value="<?php echo $public->cantidad ?>" />
												<div class="message_stock"></div>
											<?php } ?>

											</div>
										</div>
									</div>
								</div>
							<?php } ?>

							

												
						<?php } ?>
						<hr>
						<div>
							<h2 class="my-2">
								Total: $ 
								<span id="total_<?php echo $user['id'] ?>">
									<?php echo number_format($total,2,",",".") ?>
								</span>
							</h2>
						</div>	
						<div class="buy-from-seller">
							<button class="btn btn-primary buy_seller" data-id="<?php echo $user['id'] ?>">
								Comprar lo de este vendedor
							</button>
						</div>
					</div>

				</div>
			</div>

		<?php } ?>
        
           
    </div>
</div>
