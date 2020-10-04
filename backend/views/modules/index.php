<?php 
    if(!isset($_SESSION["usuario_validado"])){
        echo "<script> window.location.href = 'login' </script>";
        exit();
	}

	$clientes = GestorClientesController::clientes();
	$usuarios = GestorUsuariosController::usuarios();
	$rutas = GestorUsuariosController::rutas();
	$zonas = GestorZonasController::zonas();
?>

<!-- contenido -->
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Dashboard</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<span class="kt-subheader__desc">#XRS-45670</span>
	</div>
	<div class="kt-subheader__toolbar">
		<div class="kt-subheader__wrapper"></div>
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">


	

	<!--begin:: Widgets/Activity-->
	<div class="kt-portlet kt-portlet--fit kt-portlet--head-lg kt-portlet--head-overlay kt-portlet--skin-solid kt-portlet--height-fluid">
		<div class="kt-portlet__head kt-portlet__head--noborder kt-portlet__space-x">
			<div class="kt-portlet__head-label">
				<h3 class="kt-portlet__head-title">
					<!-- Activity -->
				</h3>
			</div>
			<div class="kt-portlet__head-toolbar">
				<!-- <a href="#" class="btn btn-label-light btn-sm btn-bold dropdown-toggle" data-toggle="dropdown">
					Export
				</a>
				<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right">
					<ul class="kt-nav">
						<li class="kt-nav__section kt-nav__section--first">
							<span class="kt-nav__section-text">Finance</span>
						</li>
						<li class="kt-nav__item">
							<a href="#" class="kt-nav__link">
								<i class="kt-nav__link-icon flaticon2-graph-1"></i>
								<span class="kt-nav__link-text">Statistics</span>
							</a>
						</li>
						<li class="kt-nav__item">
							<a href="#" class="kt-nav__link">
								<i class="kt-nav__link-icon flaticon2-calendar-4"></i>
								<span class="kt-nav__link-text">Events</span>
							</a>
						</li>
						<li class="kt-nav__item">
							<a href="#" class="kt-nav__link">
								<i class="kt-nav__link-icon flaticon2-layers-1"></i>
								<span class="kt-nav__link-text">Reports</span>
							</a>
						</li>
						<li class="kt-nav__section kt-nav__section--first">
							<span class="kt-nav__section-text">HR</span>
						</li>
						<li class="kt-nav__item">
							<a href="#" class="kt-nav__link">
								<i class="kt-nav__link-icon flaticon2-calendar-4"></i>
								<span class="kt-nav__link-text">Notifications</span>
							</a>
						</li>
						<li class="kt-nav__item">
							<a href="#" class="kt-nav__link">
								<i class="kt-nav__link-icon flaticon2-file-1"></i>
								<span class="kt-nav__link-text">Files</span>
							</a>
						</li>
					</ul>
				</div> -->
			</div>
		</div>
		<div class="kt-portlet__body kt-portlet__body--fit">
			<div class="kt-widget17">
				<div class="kt-widget17__visual  kt-portlet-fit--top kt-portlet-fit--sides" style="background-image: url(views/assets/media/bg/bg-2.jpg);background-size: contain;">
					<div class="kt-widget17__chart" style="height:320px;"></div>
				</div>
				<div class="kt-widget17__stats">
					<div class="kt-widget17__items">
						<div class="kt-widget17__item">
							<a href="listUsers">
								<span class="kt-widget17__icon">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect id="bound" x="0" y="0" width="24" height="24" />
											<path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" id="Combined-Shape" fill="#000000" />
											<rect id="Rectangle-Copy-2" fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) " x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
										</g>
									</svg> </span>
								<span class="kt-widget17__subtitle">
									Usuarios 
								</span>
								<span class="kt-widget17__desc">
									<h3><?php echo count($usuarios) ?></h3> 
								</span>
							</a>
							
						</div>
						<div class="kt-widget17__item">
							<a href="listUsers">
								<span class="kt-widget17__icon">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--success">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<polygon id="Bound" points="0 0 24 0 24 24 0 24" />
											<path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" id="Shape" fill="#000000" fill-rule="nonzero" />
											<path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" id="Path" fill="#000000" opacity="0.3" />
										</g>
									</svg> </span>
								<span class="kt-widget17__subtitle">
									Rutas 
								</span>
								<span class="kt-widget17__desc">
									<h3><?php echo count($rutas) ?></h3> 
								</span>
							</a>
							
						</div>
					</div>
					<div class="kt-widget17__items">
						<div class="kt-widget17__item">
							<a href="clients">
								<span class="kt-widget17__icon">

									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<polygon id="Shape" points="0 0 24 0 24 24 0 24" />
											<path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" id="Combined-Shape" fill="#000000" fill-rule="nonzero" opacity="0.3" />
											<path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" id="Combined-Shape" fill="#000000" fill-rule="nonzero" />
										</g>
									</svg>
								</span>
								<span class="kt-widget17__subtitle">
									Clientes
								</span>
								<span class="kt-widget17__desc">
									<h3><?php echo count($clientes) ?></h3> 
								</span>
							</a>
							
						</div>
						<div class="kt-widget17__item">
							<a href="zones">
								<span class="kt-widget17__icon">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--danger">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<polygon id="Bound" points="0 0 24 0 24 24 0 24" />
											<path d="M6,18 L9,18 C9.66666667,18.1143819 10,18.4477153 10,19 C10,19.5522847 9.66666667,19.8856181 9,20 L4,20 L4,15 C4,14.3333333 4.33333333,14 5,14 C5.66666667,14 6,14.3333333 6,15 L6,18 Z M18,18 L18,15 C18.1143819,14.3333333 18.4477153,14 19,14 C19.5522847,14 19.8856181,14.3333333 20,15 L20,20 L15,20 C14.3333333,20 14,19.6666667 14,19 C14,18.3333333 14.3333333,18 15,18 L18,18 Z M18,6 L15,6 C14.3333333,5.88561808 14,5.55228475 14,5 C14,4.44771525 14.3333333,4.11438192 15,4 L20,4 L20,9 C20,9.66666667 19.6666667,10 19,10 C18.3333333,10 18,9.66666667 18,9 L18,6 Z M6,6 L6,9 C5.88561808,9.66666667 5.55228475,10 5,10 C4.44771525,10 4.11438192,9.66666667 4,9 L4,4 L9,4 C9.66666667,4 10,4.33333333 10,5 C10,5.66666667 9.66666667,6 9,6 L6,6 Z" id="Combined-Shape" fill="#000000" fill-rule="nonzero" />
										</g>
									</svg> 
								
								</span>
								<span class="kt-widget17__subtitle">
									Zonas
								</span>
								<span class="kt-widget17__desc">
									<h3><?php echo count($zonas) ?></h3> 
								</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



	<!--End::Section-->

</div>

<!-- end:: Content -->
</div>


	
