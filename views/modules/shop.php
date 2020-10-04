<?php 

	
	$categorias = GestorCategoriasController::verCategorias();
	$pagina = isset($_GET["id"]) ? $_GET["id"] : 1;
	$text_categorias = 

    $arr = GestorProductosController::productos($pagina);

    $productos = $arr["productos"];
    $paginas = $arr["paginas"];

    $nums = count($productos);
	$num_info = count($productos);

	$search = isset($_SESSION["search_filter"]) ? $_SESSION["search_filter"] : false;
	$orden = isset($_SESSION["filter_orden"]) ? $_SESSION["filter_orden"] : "";
    $filter_categorias = isset($_SESSION["filter_categorias"]) ? $_SESSION["filter_categorias"] : "";
?>


<div class="hero-wrap hero-bread" style="background-image: url('views/images/bg_4.jpg');">
	<div class="container">
		<div class="row no-gutters slider-text align-items-center justify-content-center">
			<div class="col-md-9 ftco-animate text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="index">Inicio</a></span> 
				<h1 class="mb-0 bread">Productos</h1>
			</div>
		</div>
	</div>
</div>

<section class="ftco-section">
	<div class="container">
		<div class="row ">
			<div class="col-md-2 text-center mb-2 d-flex justify-content-center align-items-center">
				<ul class="product-category pl-0 mb-0">
					<li><a href="#" class="active" id="setFilters">Filtrar</a></li>
				</ul>
			</div>
			
			<div class="col-md-4 text-center mb-2">
				<input type="text" placeholder="Buscar" class="form-control" id="search_filter" value="<?php echo $search ?>">
			</div>
			<div class="col-md-4 text-center mb-2">
				<select placeholder="Todas las categorías" class="selectize setFilter" multiple data-key="filter_categorias" id="c_filter">
					<?php foreach ($categorias as $item) { ?>
						<option value="<?php echo $item["id"] ?>" <?php echo GestorCategoriasController::selectedC($item,$filter_categorias) ?>><?php echo $item["nombre"] ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-2 text-center mb-2">
				<select class="selectize setFilter" data-key="filter_orden" id="order_filter">
					<option value="nombre asc">Orden por defecto</option>
					<option value="nombre desc" <?php echo ($orden == "nombre desc") ? "selected": "" ?>>Nombre Z-A</option>
					<option value="precio desc" <?php echo ($orden == "precio desc") ? "selected": "" ?>>
						Meyor Precio
					</option>
					<option value="precio asc" <?php echo ($orden == "precio asc") ? "selected": "" ?>>
						Menor Precio
					</option>
				</select>
			</div>
		</div>
		<hr><br>
		<div class="row">
			<?php foreach ($productos as $item) { ?>

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
									<!-- <a href="#" class="buy-now d-flex justify-content-center align-items-center mx-1">
										<span><i class="ion-ios-cart"></i></span>
									</a> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php if (!count($productos)) { ?>
				<div class="col-md-12">
					<h3 class="text-muted text-center">No hay productos disponiblres :(</h3>
				</div>
				
			<?php } ?>
		</div>

		<div class="row mt-5">
			<div class="col text-center">
				<div class="block-27">
					<ul>
						<?php if ($paginas > 1 && count($productos)) { ?>


							<li><a href="shop_1">&lt;</a></li>
							<?php 


								$aumentar = 1;
								$disminuir = 0;
								$rango = 3;
								for ($i=1; $i <= $rango; $i++) { 
									$atras = ($pagina - $rango) + $disminuir;
									if ($atras >= 1 && $atras != $pagina ) {
										echo "
											<li><a href='shop_$atras'>$atras</a></li>";
									}
								
									$disminuir++;
								}
								echo "<li class='active'><span>$pagina</span></li>";
								for ($i=1; $i <= $rango; $i++) { 
									$adelante = $pagina + $aumentar;
								
									if ($adelante <= $paginas && $adelante != $pagina) {
										echo "
											<li><a href='shop_$adelante'>$adelante</a></li>";
									}

									$aumentar++;
								}

							?>
						
							<li><a href="shop_<?php echo $paginas?>">&gt;</a></li>
							
			

						<?php } ?>
																	
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

