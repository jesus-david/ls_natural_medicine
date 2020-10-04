
<?php 

	$categorias = GestorCategoriasController::verCategorias();
	$counter = 0;
	$productos = GestorProductosController::ver_productos();

	include "slide.php" 
	
?>

<section class="ftco-section">
	<div class="container">
		<div class="row no-gutters ftco-services" style="display: flex; justify-content: center;">
			<div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
				<div class="media block-6 services mb-md-0 mb-4">
					<div class="icon bg-color-1 active d-flex justify-content-center align-items-center mb-2">
						<span class="flaticon-shipped"></span>
					</div>
					<div class="media-body">
						<h3 class="heading">Envío gratis</h3>
						<!-- <span>On order over $100</span> -->
					</div>
				</div>      
			</div>
	
			<div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
				<div class="media block-6 services mb-md-0 mb-4">
					<div class="icon bg-color-3 d-flex justify-content-center align-items-center mb-2">
						<span class="flaticon-award"></span>
					</div>
					<div class="media-body">
						<h3 class="heading">Productos de calidad</h3>
						<!-- <span>Quality Products</span> -->
					</div>
				</div>      
			</div>
			<div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
				<div class="media block-6 services mb-md-0 mb-4">
					<div class="icon bg-color-4 d-flex justify-content-center align-items-center mb-2">
						<span class="flaticon-customer-service"></span>
					</div>
					<div class="media-body">
						<h3 class="heading">Soporte</h3>
						<!-- <span>24/7 Support</span> -->
					</div>
				</div>      
			</div>
		</div>
	</div>
</section>

<section class="ftco-section ftco-category ftco-no-pt">
	<div class="container">
		<div class="row justify-content-center mb-3 pb-3">
			<div class="col-md-12 heading-section text-center ftco-animate">
				<!-- <span class="subheading">Productos destacados</span> -->
				<h2 class="mb-4">Categorías populares</h2>
			</div>
		</div>   		
	</div>
	<div class="container">
		<div class="row">

			<?php foreach ($categorias as $item) { ?>

				<?php if ($counter < 6) { ?>
					<div class="col-md-4 my-2 order-md-last align-items-stretch d-flex">
						<div class="category-wrap-2 ftco-animate img align-self-stretch d-flex setFilterCategory" style="border: 1px solid #f0f0f0; align-items: center !important;height:250px; background-image: url(views/images/bg_gray.jpg);" data-id="<?php echo $item['id'] ?>">
							<div class="text text-center">
								<h2><?php echo $item["nombre"] ?></h2>
								<p class="mb-0"><?php echo count($item["productos"]) ?></p>
							</div>
						</div>
					</div>

					<?php $counter++; ?>
				<?php } ?>

				
			<?php } ?>

			
		</div>
	</div>
</section>

<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center mb-3 pb-3">
			<div class="col-md-12 heading-section text-center ftco-animate">
				<!-- <span class="subheading">Productos destacados</span> -->
				<h2 class="mb-4">Productos</h2>
				<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
			</div>
		</div>   		
	</div>
	<div class="container">
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
						<a href="<?php echo $item["slug"]  ?>" class="img-prod"><img class="img-fluid" src='backend/<?php echo $item["imagen"]; ?>' alt="" style="max-height: 250px;">

							<?php if ($oferta != "0.00") { ?>
								<span class="status"><?php echo $descuento; ?>%</span>
							<?php } ?>
							
							<div class="overlay"></div>
						</a>
						<div class="text py-3 pb-4 px-3 text-center">
							<h3><a href="<?php echo $item["slug"]  ?>"><?php echo $item["nombre"]; ?></a></h3>
							<div class="d-flex">
								<div class="pricing">

									<?php if ($item["oferta"] != "0.00") { ?>
										<p class="price">
											<span class="mr-2 price-dc">
												<?php echo $item["config"]->type_money ?>
												<?php echo number_format($item["precio"],2,",",".") ?>
											</span>
											<span class="price-sale">
												<?php echo $item["config"]->type_money ?>
												<?php echo number_format($item["oferta"],2,",",".")  ?>
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
									<a href="<?php echo $item["slug"]  ?>" class="add-to-cart d-flex justify-content-center align-items-center text-center">
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
					
			
		</div>
	</div>
</section>

<section class="ftco-section img" style="background-image: url(views/images/bg_gray.jpg);">
	<div class="container">
		<div class="row ">
			<div class="col-md-6 heading-section ftco-animate deal-of-the-day">
				<!-- <span class="subheading">Sobre nosotros</span> -->
				<h2 class="mb-4">Sobre nosotros</h2>
				<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
				<h3><a href="about">Más...</a></h3>
			</div>
		</div>   		
	</div>
</section>

<!-- <section class="ftco-section testimony-section">
	<div class="container">
		<div class="row justify-content-center mb-5 pb-3">
			<div class="col-md-7 heading-section ftco-animate text-center">
				<span class="subheading">Testimony</span>
				<h2 class="mb-4">Our satisfied customer says</h2>
				<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in</p>
			</div>
		</div>
		<div class="row ftco-animate">
			<div class="col-md-12">
				<div class="carousel-testimony owl-carousel">
					<div class="item">
						<div class="testimony-wrap p-4 pb-5">
							<div class="user-img mb-5" style="background-image: url(views/images/person_1.jpg)">
								<span class="quote d-flex align-items-center justify-content-center">
									<i class="icon-quote-left"></i>
								</span>
							</div>
							<div class="text text-center">
								<p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
								<p class="name">Garreth Smith</p>
								<span class="position">Marketing Manager</span>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="testimony-wrap p-4 pb-5">
							<div class="user-img mb-5" style="background-image: url(views/images/person_2.jpg)">
								<span class="quote d-flex align-items-center justify-content-center">
									<i class="icon-quote-left"></i>
								</span>
							</div>
							<div class="text text-center">
								<p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
								<p class="name">Garreth Smith</p>
								<span class="position">Interface Designer</span>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="testimony-wrap p-4 pb-5">
							<div class="user-img mb-5" style="background-image: url(views/images/person_3.jpg)">
								<span class="quote d-flex align-items-center justify-content-center">
									<i class="icon-quote-left"></i>
								</span>
							</div>
							<div class="text text-center">
								<p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
								<p class="name">Garreth Smith</p>
								<span class="position">UI Designer</span>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="testimony-wrap p-4 pb-5">
							<div class="user-img mb-5" style="background-image: url(views/images/person_1.jpg)">
								<span class="quote d-flex align-items-center justify-content-center">
									<i class="icon-quote-left"></i>
								</span>
							</div>
							<div class="text text-center">
								<p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
								<p class="name">Garreth Smith</p>
								<span class="position">Web Developer</span>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="testimony-wrap p-4 pb-5">
							<div class="user-img mb-5" style="background-image: url(views/images/person_1.jpg)">
								<span class="quote d-flex align-items-center justify-content-center">
									<i class="icon-quote-left"></i>
								</span>
							</div>
							<div class="text text-center">
								<p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
								<p class="name">Garreth Smith</p>
								<span class="position">System Analyst</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section> -->

<hr>
