<?php 

	if(!isset($_SESSION["logged"])){
		echo "<script> window.location.href = 'login' </script>";
		exit();
	}

	$items = $_SESSION["carrito"];


	$total = 0;

	$type_money = "";
	$rate = 0;
?>

<!-- <div class="hero-wrap hero-bread" style="background-image: url('views/images/bg_1.jpg');">
	<div class="container">
		<div class="row no-gutters slider-text align-items-center justify-content-center">
			<div class="col-md-9 ftco-animate text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Cart</span></p>
				<h1 class="mb-0 bread">My Cart</h1>
			</div>
		</div>
	</div>
</div> -->

<section class="ftco-section ftco-cart">
	<div class="container">
		<div class="row">
			<div class="col-md-12 ftco-animate">
				<div class="cart-list">
					<table class="table">
						<thead class="thead-primary">
							<tr class="text-center">
								<th>&nbsp;</th>
								<th>&nbsp;</th>
								<th>Producto</th>
								<th>Precio</th>
								<th>Cantiddad</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>

							<?php foreach ($items as $item) { ?>

								<?php 

									$info = GestorProductosController::ver_info_producto($item->id);

									if (!isset($info["nombre"])) {
									
	
										echo "
											<tr>
												<td class='product-remove'>
													<a href='#' class='deleteFromCart' data-p-id='$item->id' data-sku='$item->sku' data-id-u=''>
														<span class='ion-ios-close'></span> 
													</a>
												</td>
												<td colspan='5'>
													<div class='alert alert-info'>Este producto fue borrardo, o no está disponible.</div>
												</td>
											</tr>
										";
	
										continue;
									}
									$porcentaje_oferta = 0;

									$total_this = 0;

									if ($info["oferta"] != 0.00) {
										$porcentaje_oferta = ceil(($info["oferta"] * 100) / $info["precio"]);
										$porcentaje_oferta = 100 - $porcentaje_oferta;
										$total_this = $info["oferta"] * $item->cantidad;
									}else{
										$total_this = $info["precio"] * $item->cantidad;
									}

									$total += $total_this;

									$type_money = $info["config"]->type_money;
									$rate = $info["config"]->rate;

									$sku_id = [];             
									if (count($info["variantes"])) {

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
									}  
									
								?>

								<tr class="text-center">
									<td class='product-remove'>
										<a href='#' class="deleteFromCart" data-sku="<?php echo $item->sku ?>" data-id-u="" data-p-id="<?php echo $info["id"] ?>"><span class='ion-ios-close'></span></a>
									</td>
									
									<td class="image-prod">
										<div class="img" style="background-image:url(backend/<?php echo $info["imagen"] ?>);"></div>
									</td>
									
									<td class="product-name">
										<h3><?php echo $info["nombre"] ?></h3>
										<div class="product-attr">
											<div class="product-sku">
												<?php if (isset($item->skus)) { ?>
													<dl>
														<?php foreach ($item->skus as $sku) { ?>
															
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
									</td>
									
									<td class="price">
										<?php if ($info["oferta"] != 0.00) { ?>
											<span>
												<?php echo $info["config"]->type_money ?>
												<?php echo number_format($info["oferta"],2,",",".") ?>
											</span>
											<span class="old_price">
												<?php echo $info["config"]->type_money ?> <?php echo number_format($info["precio"],2,",",".") ?>
											</span>
											<span class="percent_offert">
												<?php echo $porcentaje_oferta ?>%
											</span>
										<?php } ?>
										<?php if($info["oferta"] == 0.00){ ?>
											<?php echo $info["config"]->type_money ?>
											<?php echo number_format($info["precio"],2,",",".") ?>
										<?php } ?>
									</td>
									
									<td class="quantity">
										<span class="input-group-btn mr-2">
											<button type="button" class="quantity-left-minus btn"  data-type="minus" data-field=".quantity_cart_<?php echo $info['id'] ?>">
												<i class="ion-ios-remove"></i>
											</button>
										</span>

										<?php if (count($info["variantes"]) == 0) { ?>
											<?php if ($info["inventario"] != 0) { ?>
												<input type="number" class="form-control change_stock quantity_cart_<?php echo $info['id'] ?>" min="0" max="<?php echo $info["inventario"] ?>" readonly data-sku="<?php echo $item->sku ?>" data-id-u="" value="<?php echo $item->cantidad ?>" >
											<?php } ?>	
											
											
											<?php if ($info["inventario"] == 0) { ?>
												<div class="text-danger">¡Agotado!</div>
											<?php } ?>
										<?php } ?>
										
										<?php if (count($info["variantes"])) { ?>
											<input type="number" class="form-control change_stock quantity_cart_<?php echo $info['id'] ?>" min="0" max="<?php echo $selected_sku["inventario"] ?>" readonly data-sku="<?php echo $item->sku ?>" data-id-u="" value="<?php echo $item->cantidad ?>">
											
										<?php } ?>

										<span class="input-group-btn ml-2">
											<button type="button" class="quantity-right-plus btn" data-type="plus" data-field=".quantity_cart_<?php echo $info['id'] ?>">
												<i class="ion-ios-add"></i>
											</button>
										</span>

										<div class="message_stock"></div>
									</td>
									
									<td class="total">
										<?php echo $info["config"]->type_money ?> 
										<?php echo number_format($total_this,2,",",".") ?>
									</td>
								</tr>
							<?php } ?>
							
							<?php if (!count($items)) { ?>
								<tr>
									<td colspan="6">
										<h3>Tu carrito está vacío</h3>
									</td>
								</tr>
							<?php } ?>
							

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row justify-content-end">

			<div class="col-lg-4 mt-5 cart-wrap ftco-animate fadeInUp ftco-animated">
    				<div class="cart-total mb-3">
    					<h3 class="billing-heading">Métodos de pago</h3>
    					<div class="radio">
							<label>
								<input type="radio" name="optradio" class="mr-2" checked> 
								Transferencia bancaria directa
							</label>
						</div>
    				</div>
    		</div>
		
			<div class="col-lg-4 mt-5 cart-wrap">
				<div class="cart-total mb-3">
					<h3>Totales del carrito</h3>
					<p class="d-flex">
						<span><?php echo $type_money ?></span>
						<span class="total_"><?php echo number_format($total,2,",",".") ?></span>
					</p>
					<input type="hidden" id="_type" value="<?php echo $type_money ?>">
					<input type="hidden" id="_rate" value="<?php echo $rate ?>">
					<?php if ($type_money == "US$") { ?>
						<p class="d-flex">
							<span>Valor Dólar/Peso</span>
							<span><?php echo number_format($rate,2,",",".") ?></span>
						</p>
					<?php } ?>
					<hr>
					<p class="d-flex total-price">
						<span>Total</span>
						<span>
							
							<span class="total_pesos">
								$ 
								<?php 
									echo ($type_money == "US$") ? number_format($total * $rate,2,",",".") : number_format($total,2,",",".")  ;
								?>
							</span>
							
						</span>
					</p>
				</div>
				<p><a href="#" class="btn btn-primary py-3 px-4 buy_">Procesar pedido</a></p>
				<p class="buy_error"></p>
			</div>
		</div>
	</div>
</section>

