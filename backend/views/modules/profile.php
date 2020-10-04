<?php 
    if(!isset($_SESSION["usuario_validado"])){
        echo "<script> window.location.href = 'login' </script>";
        exit();
    }

    $full = explode(" ",$_SESSION["usuario"]);

    $iniciales = (count($full) >= 2) ? substr($full[0], 0,1) . substr($full[1], 0,1) : substr($full[0], 0,1);
    $tipo = "";
    if ($_SESSION["tipo"] == 0) {
        $tipo = "Master";
    }else if ($_SESSION["tipo"] == 1) {
        $tipo = "Administrador";
    }

    $ventas = GestorEstadisticasModel::misVentas();
    $config = GestorConfigController::ver_mis_config();

    $rate = $config->rate;
    $payAtHome = $config->payAtHome;
    $receiveNotyByDay= $config->receiveNotyByDay;
    $typeMoney = $config->type_money;

?>

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    Perfil
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
    <div
        class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid"
    >
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__body kt-portlet__body--fit p-2">
               
                <div class="kt-widget kt-widget--user-profile-3 p-3">
                    <div class="kt-widget__top row">
                        <?php if ($_SESSION["imagen"] != ""): ?>
                            <div class="kt-widget__media kt-hidden- col-md-3 text-center">
                                <img src="<?php echo $_SESSION["imagen"]; ?>" alt="image" class="img-profile">
                            </div>
                        <?php else: ?>
                            <div class="col-md-3 text-center mb-4">
                                <div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-boldest kt-font-light kt-hidden- inline-flex">
                                    <?php echo $iniciales; ?>
                                </div>
                            </div>
                            
                        <?php endif; ?>
                        
                        
                        
                        <div class="kt-widget__content col-md-9">
                            <div class="kt-widget__head">
                                <a href="#" class="kt-widget__username">
                                    <?php echo $_SESSION["usuario"] ?>
                                    <i class="flaticon2-correct kt-font-success"></i>                       
                                </a>

                                <div class="kt-widget__action">
                                    
                                    <button type="button" class="btn btn-brand btn-sm btn-upper" id="cambiarImagenPerfil">Imagen perfil</button>
                                </div>
                            </div>

                            <div class="kt-widget__subhead">
                                <a href="#">
                                    <i class="flaticon2-new-email"></i>
                                    <?php echo $_SESSION["correo"] ?>
                                </a>
                            </div>

                            <div class="kt-widget__subhead">
                                <div class="">
                                    
                                    <a href="#">
                                        <i class="flaticon2-calendar-3"></i>
                                        <?php echo $tipo ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-widget__bottom">

                                        
                        <div class="kt-widget__item">
                            <div class="kt-widget__icon">
                                <i class="flaticon-pie-chart"></i>
                            </div>
                            <div class="kt-widget__details">
                                <span class="kt-widget__title">Mis datos</span>
                                <a href="editUser_<?php echo $_SESSION["id_usuario"]?>" 
                                    class="kt-widget__value kt-font-brand">
                                    Editar
                                </a>
                            </div>
                        </div>
                        <div class="kt-widget__item">
                            <div class="kt-widget__icon">
                                <i class="flaticon-diagram"></i>
                            </div>
                            <div class="kt-widget__details">
                                <span class="kt-widget__title">Ventas</span>
                                <span class="kt-widget__value">
                                    <span>$</span>
                                    <?php echo $ventas ?>
                                </span>
                            </div>
                        </div>

                        <?php if ($_SESSION["tipo"] == 0): ?>
                            <div class="kt-widget__item">
                                <div class="kt-widget__icon">
                                    <i class="flaticon-confetti"></i>
                                </div>
                                <div class="kt-widget__details">
                                    <span class="kt-widget__title">Seguridad</span>
                                    <a href="security" 
                                    class="kt-widget__value kt-font-brand">
                                        Gestionar
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                        


                        <!-- <div class="kt-widget__item">
                            <div class="kt-widget__icon">
                                <i class="flaticon-chat-1"></i>
                            </div>
                            <div class="kt-widget__details">
                                <span class="kt-widget__title">648 Comments</span>
                                <a href="#" class="kt-widget__value kt-font-brand">View</a>
                            </div>
                        </div> -->

                    </div>


                </div>
                                  
            </div>
        </div>
        <!--end::Portlet-->


        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__body kt-portlet__body--fit p-2">
                <div class="p-3">
                    <h3>Configuración</h3>

                    <form class="kt-form kt-form--label-right">
                        <div class="kt-portlet__body">
                            
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Tipo de moneda</label>
                                <div class="col-lg-4 col-md-8 col-sm-12">
                                    <select class="form-control update_config_user" id="kt_notify_icon" data-key="type_money">
                                        <option value="$" <?php echo ($typeMoney == "$") ? "selected" : "" ?>>
                                            Peso colombiano ($) 
                                        </option>
                                        <option value="US$" <?php echo ($typeMoney == "US$") ? "selected" : "" ?>>
                                            Dólar (US$)
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="col-md-1">
                                    <i class="kt-nav__link-icon flaticon-questions-circular-button" data-toggle="kt-tooltip" title="Tipo de moneda que se usará en los productos, si es dólar al realizar los pedidos se convierte el total a pesos colombianos de acuerdo a la tasa de dólar que esté en ese momento." data-placement="top"></i>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Tasa dólar</label>
                                <div class="col-lg-4 col-md-8 col-sm-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="text" class="form-control" value="1" readonly>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">=</span>
                                        </div>
                                        <input type="text" class="form-control update_config_user" placeholder="???" value="<?php echo $rate ?>" data-key="rate">
                                        <div class="input-group-append">
                                            <span class="input-group-text">COP.</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-1">
                                    <i class="kt-nav__link-icon flaticon-questions-circular-button" data-toggle="kt-tooltip" title="Valor dólar/peso que usará." data-placement="top"></i>
                                </div>
                            </div>
                        
                        </div>
                        <div class="kt-portlet__foot"></div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- end:: Content -->
</div>


<!--begin::Modal-->
<div
    class="modal fade"
    id="myModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Selecciona una imagen
                </h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <div
                    class="kt-scroll"
                    data-scroll="true"
                    data-height="200">
                    <form id="formImagenPerfil">
                        <input type="file" name="imageUser">
                    </form>
                    

                    <div class="mensajeModal"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-primary"
                    id="cambiarImagen">
                    guardar
                </button>
                <button
                    type="button"
                    class="btn btn-brand"
                    data-dismiss="modal"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->