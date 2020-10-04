<!DOCTYPE html>
<html lang="en">
<head>
	<title>LS NATURAL MEDICINE</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">
	
	<link rel="stylesheet" href="views/css/open-iconic-bootstrap.min.css">
	<link rel="stylesheet" href="views/css/animate.css">
	
	<link rel="stylesheet" href="views/css/owl.carousel.min.css">
	<link rel="stylesheet" href="views/css/owl.theme.default.min.css">
	<link rel="stylesheet" href="views/css/magnific-popup.css">
	
	<link rel="stylesheet" href="views/css/aos.css">
	
	<link rel="stylesheet" href="views/css/ionicons.min.css">
	
	<link rel="stylesheet" href="views/css/bootstrap-datepicker.css">
	<link rel="stylesheet" href="views/css/jquery.timepicker.css">
	<link rel="stylesheet" href="views/css/selectize.css">
    <link rel="stylesheet" href="views/css/selectize.default.css">
	<link rel="stylesheet" href="views/css/bootstrap.css">
	<link rel="stylesheet" href="views/css/flaticon.css">
	<link rel="stylesheet" href="views/css/icomoon.css">
	<link rel="stylesheet" href="views/css/style.css">
	
	<link rel="stylesheet" type="text/css" href="views/DataTables/DataTables-1.10.21/css/dataTables.bootstrap4.min.css"/>
	<link rel="stylesheet" type="text/css" href="views/DataTables/datatables.min.css"/>

	<link rel="stylesheet" href="views/css/custom.css">
</head>
<body class="goto-here">

    <?php include "modules/header.php" ?>


    <?php
        $modulos = new Enlaces();
        $modulos->enlacesController();
    ?>
    
    <?php include "modules/footer.php" ?>
	
	
	<!-- loader -->
	<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
	
	
	<script src="views/js/jquery.min.js"></script>
	<!-- <script src="views/js/jquery-migrate-3.0.1.min.js"></script> -->
	<script src="views/js/popper.min.js"></script>
	<script src="views/js/bootstrap.min.js"></script>
	<script src="views/js/selectize.min.js"></script>
	<script src="views/js/jquery.easing.1.3.js"></script>
	<script src="views/js/jquery.waypoints.min.js"></script>
	<!-- <script src="views/js/jquery.stellar.min.js"></script> -->
	<script src="views/js/owl.carousel.min.js"></script>
	<script src="views/js/jquery.magnific-popup.min.js"></script>
	<script src="views/js/aos.js"></script>
	<!-- <script src="views/js/jquery.animateNumber.min.js"></script> -->
	<script src="views/js/bootstrap-datepicker.js"></script>
	<script src="views/js/scrollax.min.js"></script>

	<script type="text/javascript" src="views/DataTables/datatables.min.js"></script>
	<script type="text/javascript" src="views/DataTables/datatable.bootstrap.js"></script>

	<script src="views/js/main.js"></script>
	<script src="views/js/productos.js"></script>
	<script src="views/js/auth.js"></script>
	<script src="views/js/carrito.js"></script>
	<script src="views/js/pedidos.js"></script>
	
	
	<script>

		$('.selectize').selectize({});

		$(document).ready(function() {
			$('#example').DataTable({
				language: {
                "decimal":        "",
                "emptyTable":     "Vacio",
                "info":           "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "infoEmpty":      "Mostrando 0 a 0 de 0 entradas",
                "infoFiltered":   "(Filtrado de _MAX_ entradas)",
                "infoPostFix":    "",
                "thousands":      ".",
                "lengthMenu":     "Mostrar _MENU_ entradas",
                "loadingRecords": "Cargando...",
                "processing":     "Procesando...",
                "search":         "Buscar:",
                "zeroRecords":    "No se encontraron resultados",
                "paginate": {
                    "first":      "Primero",
                    "last":       "Último",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                },
                "aria": {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            },
            "pagingType": "simple_numbers",
			});
		} );
		$(document).ready(function(){
			
			var quantitiy=0;
			$('.quantity-right-plus').click(function(e){
				
				// Stop acting like a button
				e.preventDefault();
				// Get the field name
				var field = $(this).attr("data-field")
				var quantity = parseInt($(field).val());
				
				// If is not undefined
				if (Number($(field).attr("max")) >= quantity + 1) {
					$(field).val(quantity + 1).trigger("change");					
				}
				// Increment
				
			});
			
			$('.quantity-left-minus').click(function(e){
				// Stop acting like a button
				e.preventDefault();
				// Get the field name
				var field = $(this).attr("data-field")
				var quantity = parseInt($(field).val());

				if ((quantity - 1) >= Number($(field).attr("min"))){
					$(field).val(quantity - 1).trigger("change");
				}
			});
			
		});
	</script>
</body>
</html>