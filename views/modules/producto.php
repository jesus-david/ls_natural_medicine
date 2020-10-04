<?php 

	$slug = $_GET["action"];

	$info = GestorProductosController::ver_info_producto_por_slug($slug);
		
	if (!isset($info["nombre"]) or $info["estado"] == 0) {
		echo "<script> window.location.href = '404' </script>";
		exit();
	}
	$relacionados = GestorProductosController::productos_relacionados($info["categorias_"], $info["id"]);

	$preguntas = GestorProductosController::ver_preguntas($info["id"]);
	
	$json_variantes = json_encode($info["variantes"]);

	$porcentaje_oferta = 0;
	if ($info["oferta"] != 0.00) {
        $porcentaje_oferta = ceil(($info["oferta"] * 100) / $info["precio"]);
        $porcentaje_oferta = 100 - $porcentaje_oferta;
	}
	
	$sku_ = 0;

	$reputacion = $info["reputacion"];
    $porcentaje = $reputacion["porcentaje"];
    $porcentaje_base_5 = $reputacion["porcentaje_base_5"];    
    $items_r = $reputacion["items"];
	$vendidos = $info["vendidos"]["total"];
	$galeria = $info["galeria"];

?>
<span id="json_variantes" class="hidden"><?php echo $json_variantes; ?></span>
<div class="hero-wrap hero-bread" style="background-image: url('views/images/bg_gray.jpg');">
	<div class="container">
		<div class="row no-gutters slider-text align-items-center justify-content-center">
			<div class="col-md-9 ftco-animate text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="index" style="color: #113169;">Inicio</a></span> <span class="mr-2"><a href="shop" style="color: #113169;">Productos</a></span></p>
				<h1 class="mb-0 bread" style="color: #113169;"><?php echo $info["nombre"] ?></h1>
			</div>
		</div>
	</div>
</div>

<section class="ftco-section">
	<div class="container">
		
		<div class="row">
			<div class="col-lg-6 mb-5 ftco-animate">
				<a href="backend/<?php echo $info["imagen"] ?>" class="image-popup">
					<img src="backend/<?php echo $info["imagen"] ?>" class="img-fluid" id="img_principal">
				</a>

				<div class="d-flex">
					<div class="thumb_img">
						<img src="backend/<?php echo $info["imagen"] ?>" >
					</div>
					<?php foreach ($galeria as $img) { ?>
						<div class="thumb_img">
							<img src="backend/<?php echo $img["path_media"] ?>" >
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="col-lg-6 product-details pl-md-5 ftco-animate">
				<h3><?php echo $info["nombre"] ?></h3>
				<div class="rating d-flex" style="flex-wrap: wrap;">
					<p class="text-left mr-4" style="display: flex;align-items: center;">
						<a href="#" class="mr-2"><?php echo number_format($porcentaje_base_5, 2) ?></a>
						<span class="star-view"><span style="width:<?php echo $porcentaje ?>%"></span></span>
					</p>
					<p class="text-left mr-4">
						<a href="#" class="mr-2" style="color: #000;"><?php echo count($items_r) ?> <span style="color: #bbb;">valoraciones</span></a>
					</p>
					<p class="text-left">
						<a href="#" class="mr-2" style="color: #000;">
							<?php echo $vendidos ?> 						
							<span style="color: #bbb;">
								<?php echo ($vendidos == 1 ) ? "vendido" : "vendidos" ?>
							</span>
						</a>
					</p>
				</div>
				<p class="price">
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
						<input type="hidden" id="price_base" value="<?php echo $info["oferta"] ?>">
					<?php } ?>

					<?php if($info["oferta"] == 0.00){ ?>
						<span class="price">
							<?php echo $info["config"]->type_money ?>
							<?php echo number_format($info["precio"],2,",",".") ?>
						</span>
						<input type="hidden" id="price_base" value="<?php echo $info["precio"] ?>">
					<?php } ?>
					
				</p>
				<p>
					<?php echo $info["descripcion"] ?>
				</p>
				<div class="row mt-4">
					<div class="col-md-12">
						<!-- <div class="form-group d-flex">
							<div class="select-wrap">
								<div class="icon"><span class="ion-ios-arrow-down"></span></div>
								<select name="" id="" class="form-control">
									<option value="">Small</option>
									<option value="">Medium</option>
									<option value="">Large</option>
									<option value="">Extra Large</option>
								</select>
							</div>
						</div> -->

						<article class="">
							<?php foreach ($info["caracteristicas"] as $item) { ?>
								
								<?php 
									if (count($item["childs"])) {
										$sku_++;
									}    
								?>

								<p><?php echo $item["nombre"] ?>:</p>
								<ul class="sku-property-list">
									<?php foreach ($item["childs"] as $child) { ?>
										<li class="sku_item" data-name="<?php echo $item["nombre"] ?>" data-s-id="<?php echo $item["id"] ?>" data-child-id="<?php echo $child["id"] ?>" data-value="<?php echo $child["nombre"] ?>" data-sum="<?php echo $child["valor_agregado"] ?>" data-order="<?php echo $sku_ ?>">
											<?php echo $child["nombre"] ?>
										</li>
									<?php } ?>
								</ul>
								
								
							<?php } ?>

							<input type="hidden" id="sku_" value="<?php echo $sku_ ?>"> 
							<input type="hidden" id="p_id" value="<?php echo $info["id"] ?>">                       
						</article>  
					</div>
					<div class="w-100"></div>
					<div class="input-group col-md-6 d-flex mb-3">
						<span class="input-group-btn mr-2">
							<button type="button" class="quantity-left-minus btn"  data-type="minus" data-field=".quantity_p">
								<i class="ion-ios-remove"></i>
							</button>
						</span>

						<?php if (count($info["variantes"]) == 0) { ?>

							<input type="text" name="quantity" class="form-control input-number sku_stock quantity_p" value="1" min="0" max="<?php echo $info["inventario"] ?>" id="cantidad" readonly>
							
                            <?php if ($info["inventario"] == 0) { ?>
                                <div class="text-danger">¡Agotado!</div>
                            <?php } ?>
                        <?php } ?>
						
						<?php if (count($info["variantes"])) { ?>
                            <input type="text" name="quantity" class="form-control input-number sku_stock quantity_p" value="0" min="0" max="0" id="cantidad" readonly>
                            
                        <?php } ?>

						<span class="input-group-btn ml-2">
							<button type="button" class="quantity-right-plus btn" data-type="plus" data-field=".quantity_p">
								<i class="ion-ios-add"></i>
							</button>
						</span>
					</div>
					<div class="message_stock"></div>
					<div class="w-100"></div>
					<!-- <div class="col-md-12">
						<p style="color: #000;">600 kg available</p>
					</div> -->
				</div>
				<p><a href="#" id="add_cart" class="btn btn-black py-3 px-5">Agregar al carrito</a></p>
				<p class="message_cart"></p>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section">

	<div class="container">
		
		<!-- preguntas  -->
		<div class="row">
		
			<div class="col-md-12">
				<h5>Preguntas</h5>
				<div class="row">
					<div class="col-md-6 mt-2">
						<input type="text" class="form-control" id="ask" placeholder="Escribe tu pregunta...">
						<input type="hidden" id="id_pu" value="<?php echo $info['id'] ?>">
						<input type="hidden" id="id_client_" value="<?php echo $_SESSION['id_usuario'] ?>">
					</div>
					<div class="col-md-6 mt-2">
						<button class="btn btn-primary" id="preguntar">Preguntar</button>
					</div>
				</div>
			</div>



			<div class="col-md-12 mt-4">

				<?php if (count($preguntas)) { ?>
					<h5>Últimas preguntas</h5>
				<?php } ?>
				

				<?php foreach ($preguntas as $item) { ?>

					<div style="padding: 4px 10px; border-bottom: 1px solid #eee;">
						<div class="item__question question mb-2">
							<span class="mr-4">
								<i class="icon-comment"></i>
							</span>
							<div>
								<?php echo $item["contenido"] ?>

								<small class="ml-3"><?php echo $item["format_pregunta"] ?></small>
								
							</div>
						</div>
						
						<?php if ($item["respuesta"] != "") { ?>
							<div class="item__question answer text-muted ml-4">
								<span class="mr-4">
									<i class="icon-comments"></i>
								</span>
								<div>
									<?php echo $item["respuesta"] ?>

									<small class="ml-3"><?php echo $item["format_respuesta"] ?></small>
								</div>
								
							</div>
						<?php } ?>
					</div>
				

				<?php } ?>

			</div>
		</div>
		<br><br>
        <h4>Opiniones sobre el producto</h4>

        <?php 
        
            $sum5 = array(
                "suma" => 0,
                "total" => 0
            );
            $sum4 = array(
                "suma" => 0,
                "total" => 0
            );
            $sum3 = array(
                "suma" => 0,
                "total" => 0
            );
            $sum2 = array(
                "suma" => 0,
                "total" => 0
            );
            $sum1 = array(
                "suma" => 0,
                "total" => 0
            );

        
            for ($i=0; $i < count($items_r); $i++) { 
                $op = $items_r[$i];
                if ($op["valor"] > 4.5) {
                    $sum5["suma"] += $sum5["suma"] + $op["valor"];
                    $sum5["total"] += $sum5["total"] + 1;
                    continue;
                }
                if ($op["valor"] > 3.5) {
                    $sum4["suma"] += $sum4["suma"] + $op["valor"];
                    $sum4["total"] += $sum4["total"] + 1;
                    continue;
                }
                if ($op["valor"] > 2.5) {
                    $sum3["suma"] += $sum3["suma"] + $op["valor"];
                    $sum3["total"] += $sum3["total"] + 1;
                    continue;
                }
                if ($op["valor"] > 1.5) {
                    $sum2["suma"] += $sum2["suma"] + $op["valor"];
                    $sum2["total"] += $sum2["total"] + 1;
                    continue;
                }
                if ($op["valor"] < 1.5) {
                    $sum1["suma"] += $sum1["suma"] + $op["valor"];
                    $sum1["total"] += $sum1["total"] + 1;
                    continue;
                }
            }

            $total5 = ($sum5["total"] > 0) ? ($sum5["total"] * 100) / count($items_r) : 0;
            $total4 = ($sum4["total"] > 0) ? ($sum4["total"] * 100) / count($items_r) : 0;
            $total3 = ($sum3["total"] > 0) ? ($sum3["total"] * 100) / count($items_r) : 0;
            $total2 = ($sum2["total"] > 0) ? ($sum2["total"] * 100) / count($items_r) : 0;
            $total1 = ($sum1["total"] > 0) ? ($sum1["total"] * 100) / count($items_r) : 0;

        ?>


        <div id="transction-feedback" class="feedback-container" data-widget-cid="widget-1">
	        <div class="customer-reviews">Valoraciones (<?php echo count($items_r) ?>)</div>
            <div class="rate-detail util-clearfix">
                <ul class="rate-list">
                    <li>
                        <span class="r-title">5 estrellas</span>
                        <span class="r-graph">
                            <b class="r-graph-scroller" style="width:<?php echo $total5 ?>%;"></b>
                        </span>
                        <span class="r-num fb-star-list-href" data="5 Stars">
                            <?php echo number_format($total5, 2); ?>%
                        </span>
                    </li>
                    <li>
                        <span class="r-title">4 estrellas</span>
                        <span class="r-graph">
                            <b class="r-graph-scroller" style="width:<?php echo $total4 ?>%;"></b>
                        </span>
                        <span class="r-num fb-star-list-href" data="4 Stars">
                            <?php echo number_format($total4, 2) ?>%
                        </span>
                    </li>
                    <li>
                        <span class="r-title">3 estrellas</span>
                        <span class="r-graph">
                            <b class="r-graph-scroller" style="width:<?php echo $total3 ?>%;"></b>
                        </span>
                        <span class="r-num fb-star-list-href" data="3 Stars">
                            <?php echo number_format($total3, 2) ?>%
                        </span>
                    </li>
                    <li>
                        <span class="r-title">2 estrellas</span>
                        <span class="r-graph">
                            <b class="r-graph-scroller" style="width:<?php echo $total2 ?>%;"></b>
                        </span>
                        <span class="r-num fb-star-list-href" data="2 Stars">
                            <?php echo number_format($total2, 2) ?>%
                        </span>
                    </li>
                    <li>
                        <span class="r-title">1 estrella</span>
                        <span class="r-graph">
                            <b class="r-graph-scroller" style="width:<?php echo $total1 ?>%;"></b>
                        </span>
                        <span class="r-num fb-star-list-href" data="1 Stars">
                            <?php echo number_format($total1, 2) ?>%
                        </span>
                    </li>
                </ul>                
            </div>
            <div class="rate-score">
                <span class="rate-score-number"><b><?php echo number_format($porcentaje_base_5, 2) ?></b><span> / 5</span></span>
                <div class="star-view-big"><span style="width:<?php echo $porcentaje ?>%"></span></div>
            </div>

            <div class="feedback-action">
                
           
                    
            </div>
            <div class="feedback-list-wrap">
                
                <?php foreach ($items_r as $opinion) { ?>

                    <?php 
                       
						$porcentaje_ = ($opinion["valor"] > 0) ? ($opinion["valor"] * 100) / 5 : 0;
					
                    ?>

                    <div class="row mt-3">
                        <div class="col-md-2">
                            <span class="user-name">
								<div class="avatar_">
									<img src="views/images/user.png" style="width:80px">
								</div>
                                <a href="#"><?php echo $opinion["usuario"] ?></a>
                            </span>         
                        </div>
                        <div class="col-md-10">
                            <div class="f-rate-info">
                                <span class="star-view"><span style="width:<?php echo $porcentaje_ ?>%"></span></span>
                            </div>
                            <div class="user-order-info">
                                <?php foreach ($opinion["skus"] as $sku) { ?>					
                                    <span>
                                        <strong><?php echo $sku->name ?>:</strong>
                                        <?php echo $sku->value ?>
                                    </span>

                                <?php } ?>                       
                            </div>
                            <div class="f-content">
                                <dl class="buyer-review">
                                    <dt class="buyer-feedback">
										<span><?php echo $opinion["comentario"] ?></span>
										
                                        <div class="r-time-new text-right">
                                            <?php echo $opinion["format"] ?>
                                        </div>
                                    </dt>
                                </dl>													
                            </div>
                        </div>
                    </div>
					<hr>
                <?php } ?>

                
              
            </div>
        </div>
    </div>
</section>


<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center mb-3 pb-3">
			<div class="col-md-12 heading-section text-center ftco-animate">
				
				<h2 class="mb-4">Productos relacionados</h2>
				<p>Estos productos te pueden interesar.</p>
			</div>
		</div>   		
	</div>
	<div class="container">
		<div class="row">
			<?php foreach ($relacionados as $item) { ?>

				<?php 
					
					$precio = $item["precio"];
					$oferta = $item["oferta"];

					$aux_ = ceil(($oferta * 100) / $precio);
					$descuento = 100 - $aux_;
					
				?>

				<div class="col-md-6 col-lg-3 ftco-animate">
					<div class="product">
						<a href="<?php echo strtolower($item["slug"])  ?>" class="img-prod"><img class="img-fluid" src='backend/<?php echo $item["imagen"]; ?>' alt="" style="max-height: 250px;">

							<?php if ($oferta != "0.00") { ?>
								<span class="status"><?php echo $descuento; ?>%</span>
							<?php } ?>
							
							<div class="overlay"></div>
						</a>
						<div class="text py-3 pb-4 px-3 text-center">
							<h3><a href="<?php echo strtolower($item["slug"])  ?>"><?php echo $item["nombre"]; ?></a></h3>
							<div class="d-flex">
								<div class="pricing">

									<?php if ($item["oferta"] != "0.00") { ?>
										<p class="price">
											<span class="mr-2 price-dc">
												<?php echo $item["config"]->type_money ?>
												<?php echo number_format($item["precio"],2,",",".")  ?>
											</span>
											<span class="price-sale">
												<?php echo $item["config"]->type_money ?>
												<?php echo number_format($item["oferta"],2,",",".") ?>
											</span>
										</p>
									<?php } ?>
									<?php if ($item["oferta"] == "0.00") { ?>
										<p class="price">
											<span class="price-sale">
												<?php echo $item["config"]->type_money ?>
												<?php echo number_format($item["precio"],2,",",".")  ?>
											</span>
										</p>
									<?php } ?>
									
								</div>
							</div>
							<div class="bottom-area d-flex px-3">
								<div class="m-auto d-flex">
									<a href="<?php echo strtolower($item["slug"])  ?>" class="add-to-cart d-flex justify-content-center align-items-center text-center">
										<span><i class="ion-ios-menu"></i></span>
									</a>
									<a href="#" class="buy-now d-flex justify-content-center align-items-center mx-1">
										<span><i class="ion-ios-cart"></i></span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
		</div>
	</div>
</section>

