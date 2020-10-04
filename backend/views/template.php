<?php 
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
?>
<!DOCTYPE html>
<html lang="es">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>LS NATURAL MECIDINE ADMIN</title>
		<meta name="description" content="Administrador">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--begin::Fonts -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
                google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
                active: function() {
                    sessionStorage.fonts = true;
                }
            });
        </script>

		<!--end::Fonts -->


		<!--end::Page Vendors Styles -->

		<!--begin:: Global Mandatory Vendors -->
		<link href="views/assets/vendors/general/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" type="text/css" />

		<!--end:: Global Mandatory Vendors -->

		<!--begin:: Global Optional Vendors -->

		<link href="views/assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
		<link href="views/assets/vendors/general/bootstrap-timepicker/css/bootstrap-timepicker.css" rel="stylesheet" type="text/css" />
		<link href="views/assets/vendors/general/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
		<link href="views/assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" />
		<link href="views/assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
		<link href="views/assets/vendors/general/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css" rel="stylesheet" type="text/css" />
		<link href="views/assets/vendors/general/select2/dist/css/select2.css" rel="stylesheet" type="text/css" />
	
	
		
		<link href="views/assets/vendors/general/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css" />
		<link href="views/assets/vendors/general/animate.css/animate.css" rel="stylesheet" type="text/css" />
		
		<link href="views/assets/vendors/general/sweetalert2/dist/sweetalert2.css" rel="stylesheet" type="text/css" />
		<link href="views/assets/vendors/general/socicon/css/socicon.css" rel="stylesheet" type="text/css" />
		<link href="views/assets/vendors/custom/vendors/line-awesome/css/line-awesome.css" rel="stylesheet" type="text/css" />
		<link href="views/assets/vendors/custom/vendors/flaticon/flaticon.css" rel="stylesheet" type="text/css" />
		<link href="views/assets/vendors/custom/vendors/flaticon2/flaticon.css" rel="stylesheet" type="text/css" />
		<link href="views/assets/vendors/custom/vendors/fontawesome5/css/all.min.css" rel="stylesheet" type="text/css" />

		<!--end:: Global Optional Vendors -->

		<!--begin::Global Theme Styles(used by all pages) -->
		<link href="views/assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />

		<!--end::Global Theme Styles -->
		<link href="views/assets/app/custom/login/login-v4.default.css" rel="stylesheet" type="text/css" />

		<!--begin::Layout Skins(used by all pages) -->
		<link href="views/assets/demo/default/skins/header/base/light.css" rel="stylesheet" type="text/css" />
		<link href="views/assets/demo/default/skins/header/menu/light.css" rel="stylesheet" type="text/css" />
		<link href="views/assets/demo/default/skins/brand/dark.css" rel="stylesheet" type="text/css" />
		<link href="views/assets/demo/default/skins/aside/dark.css" rel="stylesheet" type="text/css" />

		<link rel="stylesheet" href="views/css/reset.css">
		<link rel="stylesheet" href="views/css/reveal.css">
		<link rel="stylesheet" href="views/css/theme/white.css">
		<link rel="stylesheet" href="views/lib/css/monokai.css">

		<!--end::Layout Skins -->
		<link rel="stylesheet" href="views/css/dataTables.bootstrap4.css">
		<link rel="stylesheet" href="views/assets/app/custom/pricing/pricing-v1.default.css">
		<link rel="shortcut icon" href="views/assets/media/logos/favicon.ico" />
		<link rel="stylesheet" href="views/css/leaflet.css">
		<link rel="stylesheet" href="views/css/leaflet-routing-machine.css" />
		<link rel="stylesheet" href="views/css/leaflet.extra-markers.min.css">
		<link rel="stylesheet" type="text/css" href="views/css/estilos.css">
		<link rel="stylesheet" type="text/css" href="views/css/custom.css">
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading _body_">

			<!-- begin:: Page -->
		
		<?php if (isset($_GET["action"]) && $_GET["action"] == "login"): ?>

			<?php
				$module = new Enlaces();
				$module -> enlacesController();
			?>
			
		<?php else: ?>
			<!-- begin:: Header Mobile -->
			<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
				<div class="kt-header-mobile__logo">
					<a href="index">
						<h4 class="text-white">DELIVERY</h4>
					</a>
				</div>
				<div class="kt-header-mobile__toolbar">
					<button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
					<!-- <button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button> -->
					<button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
				</div>
			</div>

			<!-- end:: Header Mobile -->

			<!-- INCLUDE MODULE -->
		
			<div class="kt-grid kt-grid--hor kt-grid--root">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

					<!-- SIDE BAR -->
					
						<?php include("views/modules/sidebar.php") ?>
						
					<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

						<!-- HEADER -->
							<?php include("views/modules/header.php") ?>
						

						<!-- CONTENIDO -->
						<?php
							$module = new Enlaces();
							$module -> enlacesController();
						?>

						<!-- FOOTER -->
							<?php include("views/modules/footer.php") ?>

					</div>
				</div>
			</div>
		
			<!-- begin::Scrolltop -->
			<div id="kt_scrolltop" class="kt-scrolltop">
				<i class="fa fa-arrow-up"></i>
			</div>
			<div class="cubierta"></div>

			<!-- ver imagenes -->

			<div class="slider-overlay slider-1" style="display: none;">
				<div class="slider-close-btn">
					<button class="btn-icon-only btn-transparent" >
						<span class="btn-icon-wrap">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50" version="1.1" class='slider-close' data-id-slider='1'>
								<g id="surface1">
								<path style=" " d="M 7.71875 6.28125 L 6.28125 7.71875 L 23.5625 25 L 6.28125 42.28125 L 7.71875 43.71875 L 25 26.4375 L 42.28125 43.71875 L 43.71875 42.28125 L 26.4375 25 L 43.71875 7.71875 L 42.28125 6.28125 L 25 23.5625 Z "/>
								</g>
								</svg>
						</span>
					</button>
				</div>
				<div class="slider-body">
					<!-- <button class="btn-icon-only btn-transparent changeImgSlider" data-id-slider='1' data-c='-1'>
						<span class="btn-icon-wrap">                    
							<i class="fas fa-angle-left slider-close"></i>
						</span>
					</button> -->
					<article>
						<div class="img-container-slider img-slide-content-1">
							
						</div>
					</article>
					<!-- <button class="btn-icon-only btn-transparent changeImgSlider" data-id-slider='1' data-c='+1'>
						<span class="btn-icon-wrap">
							<i class="fas fa-angle-right slider-close"></i>
						</span>
					</button> -->
				</div>
				<div class="shadow-footer"></div>
				<div class="slider-footer">
					<strong class="info-bar"></strong>
					<div class="miScroll contenedorMiniaturas">
						<div class="img-bar img-bar-1">
							
						</div>
					</div>                    
				</div>
			</div>

			<!--  -->

		<?php endif; ?>

		<!-- end::Scrolltop -->

        <!-- librerías -->

        

        <!-- SCRIPTS TEMPLATE -->

        <script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#5d78ff",
						"dark": "#282a3c",
						"light": "#ffffff",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
						"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
					}
				}
			};
		</script>

		<!-- end::Global Config -->

		<!--begin:: Global Mandatory Vendors -->
		<script src="views/assets/vendors/general/jquery/dist/jquery.js" type="text/javascript"></script>
		<script src="views/assets/vendors/general/popper.js/dist/umd/popper.js" type="text/javascript"></script>
		<script src="views/assets/vendors/general/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="views/assets/vendors/general/js-cookie/src/js.cookie.js" type="text/javascript"></script>

		<script src="views/assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js" type="text/javascript"></script>
		<script src="views/assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js" type="text/javascript"></script>
		<script src="views/assets/vendors/general/sticky-js/dist/sticky.min.js" type="text/javascript"></script>


		<!--end:: Global Mandatory Vendors -->

		<!--begin:: Global Optional Vendors -->
		
		<script src="views/assets/vendors/general/block-ui/jquery.blockUI.js" type="text/javascript"></script>
		<script src="views/assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
		<script src="views/assets/vendors/custom/components/vendors/bootstrap-datepicker/init.js" type="text/javascript"></script>
	
		<script src="views/assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
		<script src="views/assets/vendors/custom/components/vendors/bootstrap-timepicker/init.js" type="text/javascript"></script>

		<script src="views/assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js" type="text/javascript"></script>
		<script src="views/assets/vendors/general/bootstrap-switch/dist/js/bootstrap-switch.js" type="text/javascript"></script>
		
	
		<script src="views/assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js" type="text/javascript"></script>		
		<script src="views/assets/vendors/general/select2/dist/js/select2.full.js" type="text/javascript"></script>
	
		
		<script src="views/assets/vendors/general/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
		<script src="views/assets/vendors/general/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
		<script src="views/assets/vendors/custom/components/vendors/bootstrap-markdown/init.js" type="text/javascript"></script>
			
		<script src="views/assets/vendors/general/chart.js/dist/Chart.bundle.js" type="text/javascript"></script>
		<script src="views/assets/vendors/general/sweetalert2/dist/sweetalert2.min.js" type="text/javascript"></script>
		<script src="views/assets/vendors/custom/components/vendors/sweetalert2/init.js" type="text/javascript"></script>
		<script src="views/assets/vendors/general/jquery.repeater/src/lib.js" type="text/javascript"></script>
		<script src="views/assets/vendors/general/jquery.repeater/src/jquery.input.js" type="text/javascript"></script>
		<script src="views/assets/app/custom/general/components/extended/bootstrap-notify.js" type="text/javascript"></script>

		<!--end:: Global Optional Vendors -->

		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="views/assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>


		<!--begin::Page Scripts(used by this page) -->
		<script src="views/assets/app/custom/general/dashboard.js" type="text/javascript"></script>

		<!--end::Page Scripts -->

		<!--begin::Global App Bundle(used by all pages) -->
		<script src="views/assets/app/bundle/app.bundle.js" type="text/javascript"></script>

			
		<?php if (isset($_GET["action"]) && $_GET["action"] == "listUsers") { ?>
			<script src="views/assets/js/plugin.bundle.js" type="text/javascript"></script>
			<script src="views/assets/js/scripts.bundle.js" type="text/javascript"></script>
			<script src="views/assets/js/list-datatable.js" type="text/javascript"></script>
		<?php } ?>
		<?php if (isset($_GET["action"]) && $_GET["action"] == "products") { ?>
			<script src="views/assets/js/plugin.bundle.js" type="text/javascript"></script>
			<script src="views/assets/js/scripts.bundle.js" type="text/javascript"></script>
			<script src="views/js/list-products.js" type="text/javascript"></script>
		<?php } ?>
		<?php if (isset($_GET["action"]) && $_GET["action"] == "clients") { ?>
			<script src="views/assets/js/plugin.bundle.js" type="text/javascript"></script>
			<script src="views/assets/js/scripts.bundle.js" type="text/javascript"></script>
			<script src="views/js/list-clients.js" type="text/javascript"></script>
		<?php } ?>
		<?php if (isset($_GET["action"]) && $_GET["action"] == "categories") { ?>
			<script src="views/assets/js/plugin.bundle.js" type="text/javascript"></script>
			<script src="views/assets/js/scripts.bundle.js" type="text/javascript"></script>
			<script src="views/js/list-categories.js" type="text/javascript"></script>
		<?php } ?>
		<?php if (isset($_GET["action"]) && $_GET["action"] == "orders") { ?>
			<script src="views/assets/js/plugin.bundle.js" type="text/javascript"></script>
			<script src="views/assets/js/scripts.bundle.js" type="text/javascript"></script>
			<script src="views/js/list-orders.js" type="text/javascript"></script>
		<?php } ?>
		<?php if (isset($_GET["action"]) && $_GET["action"] == "preguntas") { ?>
			<script src="views/assets/js/plugin.bundle.js" type="text/javascript"></script>
			<script src="views/assets/js/scripts.bundle.js" type="text/javascript"></script>
			<script src="views/js/list-preguntas.js" type="text/javascript"></script>
		<?php } ?>
	

			
		<script src="views/assets/app/custom/general/crud/forms/widgets/select2.js" type="text/javascript"></script>
		<!-- CUSTOM!! -->


        <script src="views/js/alertify.js"></script>
        <script src="views/js/jquery.dataTables.js"></script>
        <script src="views/js/ajax.js"></script>
        <script src="views/js/utilidades.js"></script>

				
		
		<script src="views/js/auth.js"></script>
		<script src="views/js/usuarios.js"></script>
		<script src="views/js/productos.js"></script>
		<script src="views/js/clientes.js"></script>
		<script src="views/js/zonas.js"></script>
		<script src="views/js/orders.js"></script>
		<script src="views/js/gestorConfig.js"></script>	
		<script src="views/js/categorias.js"></script>		
		<script>
			// $("#m-table").KTDatatable()
			$("#table__r").DataTable({
				responsive: true
			})

		</script>

		<?php if (isset($_GET["action"]) && $_GET["action"] == "detailsProduct") { ?>
			<script src="views/js/reveal.js"></script>
			<script src="views/js/slider.js"></script>
			<script>

				// More info https://github.com/hakimel/reveal.js#configuration
				Reveal.initialize({
					controls: true,
					progress: false,
					center: true,
					hash: true,
					controlsTutorial: true,
					slideNumber: true,

					// transitionSpeed: 'slow',
					transition: 'slide', // none/fade/slide/convex/concave/zoom
					backgroundTransition: 'slide',

					// More info https://github.com/hakimel/reveal.js#dependencies
					dependencies: [
						{ src: 'plugin/markdown/marked.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
						{ src: 'plugin/markdown/markdown.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
						{ src: 'plugin/highlight/highlight.js' },
						{ src: 'plugin/search/search.js', async: true },
						{ src: 'plugin/zoom-js/zoom.js', async: true },
						{ src: 'plugin/notes/notes.js', async: true }
					]
				});

			</script>
		<?php } ?>
	



    </body>
</html>
