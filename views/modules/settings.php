<?php 

    if(!isset($_SESSION["logged"])){
        echo "<script> window.location.href = 'login' </script>";
        exit();
    }

    include 'nav_user.php';
?>

<section class="">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xl-7 ftco-animate">
				<form id="actualizarInfo-form" class="billing-form">
					<h3 class="mb-4 billing-heading mt-4">Información</h3>
					<div class="row align-items-end">
						<div class="col-md-6">
							<div class="form-group">
								<label for="firstname">Nombre</label>
								<input type="text" class="form-control" placeholder="" name="nombre" value="<?php echo $_SESSION['nombre'] ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="lastname">Apellido</label>
								<input type="text" class="form-control" placeholder="" name="apellido" value="<?php echo $_SESSION['apellido'] ?>">
							</div>
						</div>
						<div class="w-100"></div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="country">Ciudad</label>
								<div class="select-wrap">
									<div class="icon"><span class="ion-ios-arrow-down"></span></div>
									<select name="city"  class="form-control">
										<option value="Bogotá">Bogotá</option>
									</select>
								</div>
							</div>
                        </div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="telefono">Teléfono</label>
								<input type="text" class="form-control" placeholder="" name="telefono" value="<?php echo $_SESSION['telefono'] ?>">
							</div>
						</div>
						<div class="w-100"></div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="streetaddress">Dirección</label>
								<input type="text" class="form-control" placeholder="Dirección para los envíos" name="direccion" value="<?php echo $_SESSION['direccion'] ?>">
							</div>
						</div>
						<div class="w-100"></div>
							
						<div class="w-100"></div>
					</div>
					<p><button class="btn btn-primary py-3 px-4">Actualizar</button></p>
				</form>
				<div class="message"></div>
				
			</div>
			<div class="col-xl-5">
				
			</div> 
		</div>
	</div>
</section> 
