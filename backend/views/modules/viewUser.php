<?php 
    if(!isset($_SESSION["usuario_validado"])){
    
        echo "<script> window.location.href = 'login' </script>";
    
        exit();
    }
    if($_SESSION["tipo"] != 0 && $_SESSION["tipo"] != 1){
        echo "<script> window.location.href = 'profile' </script>";
    
        exit();
    }

    $id = $_GET["id"];

    $info = GestorUsuariosController::ver_info_usuario($id);
    
    if (!isset($info["usuario"])) {
        echo "<script> window.location.href = 'listUsers' </script>";
    }

    // var_dump($info);

    $full = explode(" ",$info["usuario"]);

    $iniciales = (count($full) >= 2) ? substr($full[0], 0,1) . substr($full[1], 0,1) : substr($full[0], 0,1);
    $tipo = "";

    if ($info["tipo"] == 0) {
        $tipo = "Master";
    }else if ($info["tipo"] == 1) {
        $tipo = "Administrador";
    }else if ($info["tipo"] == 2) {
        $tipo = "Vendedor";
    }

    $ventas = GestorEstadisticasModel::misVentas($id);
    $pedidos = GestorUsuariosController::pedidos_($id);
    $pedidos_procesados = GestorUsuariosController::pedidos_($id, 1);
    $pedidos_rechazados = GestorUsuariosController::pedidos_($id, 2);
?>

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    Usuario #<?php echo $info["id"] ?>
                </h3>

                <span class="kt-subheader__separator kt-subheader__separator--v"
                ></span>
    
            </div>
            <div class="kt-subheader__toolbar">

                

            </div>
        </div>
    </div>
    <!-- end:: Content Head -->

    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
       
        <div class="kt-portlet kt-portlet--height-fluid-">
            <div class="kt-portlet__head  kt-portlet__head--noborder">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                   
                </div>
            </div>
            <div class="kt-portlet__body kt-portlet__body--fit-y">
                <!--begin::Widget -->
                <div class="kt-widget kt-widget--user-profile-1">
                    <div class="kt-widget__head">
                        <div class="kt-widget__media">
                            <?php if ($info["imagen"] != ""): ?>
                               
                                <img src="<?php echo $info["imagen"]; ?>" alt="image" class="img-profile">
                                
                            <?php else: ?>
                                <div class="col-md-3 text-center mb-4">
                                    <div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-boldest kt-font-light kt-hidden- inline-flex">
                                        <?php echo $iniciales; ?>
                                    </div>
                                </div>
                                
                            <?php endif; ?>
                        </div>
                        <div class="kt-widget__content">
                            <div class="kt-widget__section">
                                <a href="#" class="kt-widget__username">
                                    <?php echo $info["usuario"] ?>
                                    <i class="flaticon2-correct kt-font-success"></i>
                                </a>
                                <span class="kt-widget__subtitle">
                                    <?php echo $tipo ?>
                                </span>
                            </div>

                            <div class="kt-widget__action">
                                <button type="button" class="btn btn-info btn-sm"  data-toggle="modal" data-target="#exampleModal">Imagen en grande</button>
                            </div>
                        </div>
                    </div>
                    <div class="kt-widget__body">
                        <div class="kt-widget__content">
                            <div class="kt-widget__info">
                                <span class="kt-widget__label">Email:</span>
                                <a href="#" class="kt-widget__data"><?php echo $info["correo"] ?></a>
                            </div>
                            <div class="divider"></div>
                            <div class="kt-widget__info">
                                <span class="kt-widget__label">Cartera:</span>
                                <a href="wallets" class="kt-widget__data"><?php echo $info["cartera"]["nombre"] ?></a>
                            </div>
                            <div class="divider"></div>
                            <div class="kt-widget__info">
                                <span class="kt-widget__label">Ventas:</span>
                                <span class="kt-widget__data">$ <?php echo $ventas ?></span>
                            </div>
                            <div class="divider"></div>
                            <div class="kt-widget__info">
                                <span class="kt-widget__label">Pedidos:</span>
                                <span class="kt-widget__data"><?php echo count($pedidos) ?></span>
                            </div>
                            <div class="divider"></div>
                            <div class="kt-widget__info">
                                <span class="kt-widget__label">Pedidos Procesados:</span>
                                <span class="kt-widget__data"><?php echo count($pedidos_procesados)  ?></span>
                            </div>
                            <div class="divider"></div>
                            <div class="kt-widget__info">
                                <span class="kt-widget__label">Pedidos Rechazados:</span>
                                <span class="kt-widget__data"><?php echo count($pedidos_rechazados)  ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Widget -->
            </div>
        </div>
    </div>
    <!-- end:: Content -->
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Imagen</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-center">
            <?php if ($info["imagen"] != ""){ ?>
                               
                <img src="<?php echo $info["imagen"]; ?>" alt="image" style="width: 100%;" >
                
            <?php } ?>
        </div>
        </div>
    </div>
</div>