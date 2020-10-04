<?php 
    if (isset($_SESSION["id_usuario"]) && isset($_GET["action"]) && $_GET["action"] != "cerrarSesion") {
        $info = GestorUsuariosModel::ver_info_usuario($_SESSION["id_usuario"]);

        if (count($info) != 0 && $info["estado"] == "0") {
            echo "<script> window.location.href = 'cerrarSesion' </script>";
            exit();
        }

        $access = GestorConfigModel::ver_verif($_SESSION["tipo"]);       
        $notificaciones_sin_ver = GestorNotificacionesController::notificaciones_sin_ver();
        $notificaciones = GestorNotificacionesController::notificaciones_vistas();
    }else{
        $notificaciones_sin_ver = [];
        $notificaciones = [];
    }

    $type = GestorConfigModel::divice_type();

    
?>

<?php if (isset($_SESSION["id_usuario"])) { ?>

    <input type="hidden" id="user_id_global" value="<?php echo $_SESSION['id_usuario'] ?>">
    <input type="hidden" id="tag_on_signal" value="<?php echo $_SESSION['tag_on_signal'] ?>">


    <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">

        <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn">
            <i class="la la-close"></i>
        </button>
        <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">
            </div>
        </div>


        <!-- begin:: Header Topbar -->
        <div class="kt-header__topbar">

            <!--begin: Notifications -->

            <?php if ($type != "desktop") { ?>
                <div class="kt-header__topbar-wrapper flex-align" data-offset="30px,0px" >
                    <span class="kt-header__topbar-icon kt-pulse kt-pulse--brand cursor mobile-noty">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24" />
                                <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" id="Combined-Shape" fill="#000000" opacity="0.3" />
                                <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" id="Combined-Shape" fill="#000000" />
                            </g>
                        </svg> 


                        <span class="b-notific-container">
                            <?php if (count($notificaciones_sin_ver) != 0) { ?>
                                <span class="badge badge-primary b-notific"><?php echo count($notificaciones_sin_ver) ?></span>
                            <?php } ?>
                        </span>
                    </span>

                </div>

            <?php } ?>
            <?php if ($type == "desktop") { ?>

                <div class="kt-header__topbar-item dropdown">
                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="30px,0px" aria-expanded="true">
                        <span class="kt-header__topbar-icon kt-pulse kt-pulse--brand">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect id="bound" x="0" y="0" width="24" height="24" />
                                    <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" id="Combined-Shape" fill="#000000" opacity="0.3" />
                                    <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" id="Combined-Shape" fill="#000000" />
                                </g>
                            </svg> <span class="kt-pulse__ring"></span>


                            <span class="b-notific-container">
                                <?php if (count($notificaciones_sin_ver) != 0) { ?>
                                    <span class="badge badge-primary b-notific"><?php echo count($notificaciones_sin_ver) ?></span>
                                <?php } ?>
                            </span>
                        </span>
                    

                    </div>
                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-lg">
                        <form>

                            <!--begin: Head -->
                            <div class="kt-head kt-head--skin-dark kt-head--fit-x kt-head--fit-b" style="background-image: url(views/assets/media/misc/bg-1.jpg)">
                                <h3 class="kt-head__title">
                                    
                                    <?php if ($_SESSION["tag_on_signal"] == "") { ?>
                                        <span class="btn btn-danger btn-sm btn-bold btn-font-md re-nt" data-toggle="kt-tooltip" title="Notificaciones en tiempo real desactivadas" data-placement="top">
                                            <i class="fa fa-bell-slash"></i>
                                        </span>
                                    <?php } ?>
                                    
                                    Notificaciones
                                    &nbsp;

                                    <span class="n_badge_container">
                                        <?php if (count($notificaciones_sin_ver) != 0) { ?>
                                            <span class="btn btn-success btn-sm btn-bold btn-font-md n_badge">
                                                <?php echo count($notificaciones_sin_ver) ?> Nuevas
                                            </span>
                                        <?php } ?>
                                    </span>
                                    
                                    
                                </h3>
                                <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-success kt-notification-item-padding-x" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" data-toggle="tab" href="#topbar_notifications_events" role="tab" aria-selected="true">Sin revisar</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#topbar_notifications_notifications" role="tab" aria-selected="false">Revisadas</a>
                                    </li>
                                    <li class="nav-item cursor">
                                        <a class="nav-link borrarRevisadas">Borrar Revisadas</a>
                                    </li>
                                </ul>
                            </div>

                            <!--end: Head -->
                            <div class="tab-content">
                                <div class="tab-pane" id="topbar_notifications_notifications" role="tabpanel">
                                    <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll nt-revisadas" data-scroll="true" data-height="300" data-mobile-height="200">

                                        <?php foreach ($notificaciones as $item) { ?>
                                            
                                            <a href="#" class="kt-notification__item notificacion" 
                                                data-link="<?php echo $item['link'] ?>"
                                                data-id="<?php echo $item['id'] ?>">
                                                <div class="kt-notification__item-details">
                                                    <div class="kt-notification__item-title">
                                                        <?php echo $item['titulo'] ?>
                                                    </div>
                                                    <div class="kt-notification__item-time">
                                                        <?php echo GestorNotificacionesController::ago($item['fecha']) ?>
                                                        <span class="spinn_n_<?php echo $item['id'] ?>"></span>
                                                    </div>
                                                </div>
                                            </a>
                                        
                                        <?php } ?>

                                        <?php if (count($notificaciones) == 0) { ?>
                                            <div class="kt-grid kt-grid--ver" style="min-height: 200px;">
                                                <div class="kt-grid kt-grid--hor kt-grid__item kt-grid__item--fluid kt-grid__item--middle">
                                                    <div class="kt-grid__item kt-grid__item--middle kt-align-center">
                                                        
                                                        <br>No hay notificaciones.
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    
                                        
                                    </div>
                                </div>
                                <div class="tab-pane active show sinRevisar" id="topbar_notifications_events" role="tabpanel">
                                    <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                        <?php foreach ($notificaciones_sin_ver as $item) { ?>
                                            
                                            <a href="#" class="kt-notification__item notificacion" 
                                                data-link="<?php echo $item['link'] ?>"
                                                data-id="<?php echo $item['id'] ?>">
                                                <div class="kt-notification__item-details">
                                                    <div class="kt-notification__item-title">
                                                        <?php echo $item['titulo'] ?>
                                                    </div>
                                                    <div class="kt-notification__item-time">
                                                        <?php echo GestorNotificacionesController::ago($item['fecha']) ?>

                                                        <span class="spinn_n_<?php echo $item['id'] ?>"></span>
                                                    </div>
                                                </div>
                                            </a>

                                        <?php } ?>

                                        <?php if (count($notificaciones_sin_ver) == 0) { ?>
                                            <div class="kt-grid kt-grid--ver" style="min-height: 200px;">
                                                <div class="kt-grid kt-grid--hor kt-grid__item kt-grid__item--fluid kt-grid__item--middle">
                                                    <div class="kt-grid__item kt-grid__item--middle kt-align-center">
                                                        
                                                        <br>No hay notificaciones sin revisar.
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>

           

            <!--end: Notifications -->


          
            <!--begin: Quick Actions -->

            <?php if ($_SESSION["tipo"] == '0' || $_SESSION["tipo"] == '1') { ?>
                <div class="kt-header__topbar-item dropdown">
                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="30px,0px" aria-expanded="true">
                        <span class="kt-header__topbar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect id="bound" x="0" y="0" width="24" height="24" />
                                    <rect id="Rectangle-62-Copy" fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
                                    <rect id="Rectangle-62-Copy-2" fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
                                    <rect id="Rectangle-62-Copy-4" fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
                                    <rect id="Rectangle-62-Copy-3" fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
                                </g>
                            </svg> </span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">
                        <form>

                            <!--begin: Head -->
                            <div class="kt-head kt-head--skin-dark" style="background-image: url(views/assets/media/misc/bg-1.jpg)">
                                <h3 class="kt-head__title">
                                    Acción rápida
                                    <span class="kt-space-15"></span>
                                    <!-- <span class="btn btn-success btn-sm btn-bold btn-font-md">23 tasks pending</span> -->
                                </h3>
                            </div>

                            <!--end: Head -->

                            <!--begin: Grid Nav -->
                            <div class="kt-grid-nav kt-grid-nav--skin-light">
                                <div class="kt-grid-nav__row">
                                    <a href="orders" class="kt-grid-nav__item">
                                        <span class="kt-grid-nav__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--success kt-svg-icon--lg">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect id="bound" x="0" y="0" width="24" height="24" />
                                                    <rect id="Rectangle" fill="#000000" opacity="0.3" x="11.5" y="2" width="2" height="4" rx="1" />
                                                    <rect id="Rectangle-Copy-3" fill="#000000" opacity="0.3" x="11.5" y="16" width="2" height="5" rx="1" />
                                                    <path d="M15.493,8.044 C15.2143319,7.68933156 14.8501689,7.40750104 14.4005,7.1985 C13.9508311,6.98949895 13.5170021,6.885 13.099,6.885 C12.8836656,6.885 12.6651678,6.90399981 12.4435,6.942 C12.2218322,6.98000019 12.0223342,7.05283279 11.845,7.1605 C11.6676658,7.2681672 11.5188339,7.40749914 11.3985,7.5785 C11.2781661,7.74950085 11.218,7.96799867 11.218,8.234 C11.218,8.46200114 11.2654995,8.65199924 11.3605,8.804 C11.4555005,8.95600076 11.5948324,9.08899943 11.7785,9.203 C11.9621676,9.31700057 12.1806654,9.42149952 12.434,9.5165 C12.6873346,9.61150047 12.9723317,9.70966616 13.289,9.811 C13.7450023,9.96300076 14.2199975,10.1308324 14.714,10.3145 C15.2080025,10.4981676 15.6576646,10.7419985 16.063,11.046 C16.4683354,11.3500015 16.8039987,11.7268311 17.07,12.1765 C17.3360013,12.6261689 17.469,13.1866633 17.469,13.858 C17.469,14.6306705 17.3265014,15.2988305 17.0415,15.8625 C16.7564986,16.4261695 16.3733357,16.8916648 15.892,17.259 C15.4106643,17.6263352 14.8596698,17.8986658 14.239,18.076 C13.6183302,18.2533342 12.97867,18.342 12.32,18.342 C11.3573285,18.342 10.4263378,18.1741683 9.527,17.8385 C8.62766217,17.5028317 7.88033631,17.0246698 7.285,16.404 L9.413,14.238 C9.74233498,14.6433354 10.176164,14.9821653 10.7145,15.2545 C11.252836,15.5268347 11.7879973,15.663 12.32,15.663 C12.5606679,15.663 12.7949989,15.6376669 13.023,15.587 C13.2510011,15.5363331 13.4504991,15.4540006 13.6215,15.34 C13.7925009,15.2259994 13.9286662,15.0740009 14.03,14.884 C14.1313338,14.693999 14.182,14.4660013 14.182,14.2 C14.182,13.9466654 14.1186673,13.7313342 13.992,13.554 C13.8653327,13.3766658 13.6848345,13.2151674 13.4505,13.0695 C13.2161655,12.9238326 12.9248351,12.7908339 12.5765,12.6705 C12.2281649,12.5501661 11.8323355,12.420334 11.389,12.281 C10.9583312,12.141666 10.5371687,11.9770009 10.1255,11.787 C9.71383127,11.596999 9.34650161,11.3531682 9.0235,11.0555 C8.70049838,10.7578318 8.44083431,10.3968355 8.2445,9.9725 C8.04816568,9.54816454 7.95,9.03200304 7.95,8.424 C7.95,7.67666293 8.10199848,7.03700266 8.406,6.505 C8.71000152,5.97299734 9.10899753,5.53600171 9.603,5.194 C10.0970025,4.85199829 10.6543302,4.60183412 11.275,4.4435 C11.8956698,4.28516587 12.5226635,4.206 13.156,4.206 C13.9160038,4.206 14.6918294,4.34533194 15.4835,4.624 C16.2751706,4.90266806 16.9686637,5.31433061 17.564,5.859 L15.493,8.044 Z" id="Combined-Shape" fill="#000000" />
                                                </g>
                                            </svg>
                                        </span>
                                        <span class="kt-grid-nav__title">Pedidos</span>
                                        <!-- <span class="kt-grid-nav__desc">eCommerce</span> -->
                                    </a>
                                    <a href="newProduct" class="kt-grid-nav__item">
                                        <span class="kt-grid-nav__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--success kt-svg-icon--lg">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect id="bound" x="0" y="0" width="24" height="24" />
                                                    <path d="M20.4061385,6.73606154 C20.7672665,6.89656288 21,7.25468437 21,7.64987309 L21,16.4115967 C21,16.7747638 20.8031081,17.1093844 20.4856429,17.2857539 L12.4856429,21.7301984 C12.1836204,21.8979887 11.8163796,21.8979887 11.5143571,21.7301984 L3.51435707,17.2857539 C3.19689188,17.1093844 3,16.7747638 3,16.4115967 L3,7.64987309 C3,7.25468437 3.23273352,6.89656288 3.59386153,6.73606154 L11.5938615,3.18050598 C11.8524269,3.06558805 12.1475731,3.06558805 12.4061385,3.18050598 L20.4061385,6.73606154 Z" id="Combined-Shape" fill="#000000" opacity="0.3" />
                                                    <polygon id="Combined-Shape-Copy" fill="#000000" points="14.9671522 4.22441676 7.5999999 8.31727912 7.5999999 12.9056825 9.5999999 13.9056825 9.5999999 9.49408582 17.25507 5.24126912" />
                                                </g>
                                            </svg>
                                        <span class="kt-grid-nav__title">Nuevo Producto</span>
                                    </a>
                                </div>
                                <div class="kt-grid-nav__row">
                                    <a href="security" class="kt-grid-nav__item">
                                        <span class="kt-grid-nav__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--success kt-svg-icon--lg">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect id="bound" x="0" y="0" width="24" height="24" />
                                                    <path d="M4,9.67471899 L10.880262,13.6470401 C10.9543486,13.689814 11.0320333,13.7207107 11.1111111,13.740321 L11.1111111,21.4444444 L4.49070127,17.526473 C4.18655139,17.3464765 4,17.0193034 4,16.6658832 L4,9.67471899 Z M20,9.56911707 L20,16.6658832 C20,17.0193034 19.8134486,17.3464765 19.5092987,17.526473 L12.8888889,21.4444444 L12.8888889,13.6728275 C12.9050191,13.6647696 12.9210067,13.6561758 12.9368301,13.6470401 L20,9.56911707 Z" id="Combined-Shape" fill="#000000" />
                                                    <path d="M4.21611835,7.74669402 C4.30015839,7.64056877 4.40623188,7.55087574 4.5299008,7.48500698 L11.5299008,3.75665466 C11.8237589,3.60013944 12.1762411,3.60013944 12.4700992,3.75665466 L19.4700992,7.48500698 C19.5654307,7.53578262 19.6503066,7.60071528 19.7226939,7.67641889 L12.0479413,12.1074394 C11.9974761,12.1365754 11.9509488,12.1699127 11.9085461,12.2067543 C11.8661433,12.1699127 11.819616,12.1365754 11.7691509,12.1074394 L4.21611835,7.74669402 Z" id="Path" fill="#000000" opacity="0.3" />
                                                </g>
                                            </svg> </span>
                                        <span class="kt-grid-nav__title">Seguridad</span>
                                    </a>
                                    <a href="addUser" class="kt-grid-nav__item">
                                        <span class="kt-grid-nav__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--success kt-svg-icon--lg">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon id="Shape" points="0 0 24 0 24 24 0 24" />
                                                    <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" id="Combined-Shape" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                    <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" id="Combined-Shape" fill="#000000" fill-rule="nonzero" />
                                                </g>
                                            </svg> </span>
                                        <span class="kt-grid-nav__title">Nuevo usuario</span>
                                        <!-- <span class="kt-grid-nav__desc">Latest cases</span> -->
                                    </a>
                                </div>
                            </div>

                            <!--end: Grid Nav -->
                        </form>
                    </div>
                </div>

            <?php } ?>

            <!--end: Quick Actions -->



            <!--begin: User Bar -->
            <div class="kt-header__topbar-item kt-header__topbar-item--user">
                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
                    <div class="kt-header__topbar-user">
                        <span class="kt-header__topbar-welcome kt-hidden-mobile">Hola,</span>
                        <span class="kt-header__topbar-username kt-hidden-mobile"><?php echo $_SESSION["usuario"]; ?></span>
                        <img class="kt-hidden" alt="Pic" src="views/assets/media/users/300_25.jpg" />

                        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                        <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold"><?php echo substr($_SESSION["usuario"],0,1) ?></span>
                    </div>
                </div>
                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">

                    <!--begin: Head -->
                    <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url(views/assets/media/misc/bg-1.jpg)">
                        <div class="kt-user-card__avatar">
                            <img class="kt-hidden" alt="Pic" src="views/assets/media/users/300_25.jpg" />

                            <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                            <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">
                                <?php echo substr($_SESSION["usuario"],0,1) ?>
                            </span>
                        </div>
                        <div class="kt-user-card__name">
                            <?php echo $_SESSION["usuario"] ?>
                        </div>
                        <div class="kt-user-card__badge">
                            <span class="text-success"><?php echo $_SESSION["correo"] ?></span>
                        </div>
                    </div>

                    <!--end: Head -->

                    <!--begin: Navigation -->
                    <div class="kt-notification">
                        <a href="profile" class="kt-notification__item">
                            <div class="kt-notification__item-icon">
                                <i class="flaticon2-calendar-3 kt-font-success"></i>
                            </div>
                            <div class="kt-notification__item-details">
                                <div class="kt-notification__item-title kt-font-bold">
                                    Mi perfil
                                </div>
                                <div class="kt-notification__item-time">
                                    Configuración de la cuenta y más
                                </div>
                            </div>
                        </a>

                        
                        <?php if ($_SESSION["tipo"] == 2) { ?>
                            <a href="myRoutes_<?php echo $_SESSION["id_usuario"] ?>" class="kt-notification__item">
                                <div class="kt-notification__item-icon">
                                    <i class="flaticon2-map kt-font-danger"></i>
                                </div>
                                <div class="kt-notification__item-details">
                                    <div class="kt-notification__item-title kt-font-bold">
                                        Mis rutas
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                        
                        <!-- <a href="#" class="kt-notification__item">
                            <div class="kt-notification__item-icon">
                                <i class="flaticon2-hourglass kt-font-brand"></i>
                            </div>
                            <div class="kt-notification__item-details">
                                <div class="kt-notification__item-title kt-font-bold">
                                    My Tasks
                                </div>
                                <div class="kt-notification__item-time">
                                    latest tasks and projects
                                </div>
                            </div>
                        </a> -->
                        <div class="kt-notification__custom">
                            <a href="cerrarSesion" class="btn btn-label-brand btn-sm btn-bold">Cerrar Sesión</a>
                        </div>
                    </div>

                    <!--end: Navigation -->
                </div>
            </div>

            <!--end: User Bar -->
        </div>

    </div>



<?php } ?>


  <!-- Notificaciones Phone -->
<!-- TODO: vista de notificaciones en teléfono -->
<div class="Npty hidden">
    <form>
        <!--begin: Head -->
        <div class="kt-head kt-head--skin-dark kt-head--fit-x kt-head--fit-b" style="background-image: url(views/assets/media/misc/bg-1.jpg)">
            <h3 class="kt-head__title">

                <span class="close-noty"><i class="fa fa-times"></i></span>
                
                <?php if ($_SESSION["tag_on_signal"] == "") { ?>
                    <span class="btn btn-danger btn-sm btn-bold btn-font-md re-nt" data-toggle="kt-tooltip" title="Notificaciones en tiempo real desactivadas" data-placement="top">
                        <i class="fa fa-bell-slash"></i>
                    </span>
                <?php } ?>
                
                Notificaciones
                &nbsp;

                <span class="n_badge_container">
                    <?php if (count($notificaciones_sin_ver) != 0) { ?>
                        <span class="btn btn-success btn-sm btn-bold btn-font-md n_badge">
                            <?php echo count($notificaciones_sin_ver) ?> Nuevas
                        </span>
                    <?php } ?>
                </span>
                
                
            </h3>
            <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-success kt-notification-item-padding-x" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active show" data-toggle="tab" href="#topbar_notifications_events_2" role="tab" aria-selected="true">Sin revisar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#topbar_notifications_notifications_2" role="tab" aria-selected="false">Revisadas</a>
                </li>
                <li class="nav-item cursor">
                    <a class="nav-link borrarRevisadas">Borrar Revisadas</a>
                </li>
                
            </ul>
        </div>

        <!--end: Head -->
        <div class="tab-content">
            <div class="tab-pane" id="topbar_notifications_notifications_2" role="tabpanel">
                <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll nt-revisadas" data-scroll="true" data-height="400" data-mobile-height="400">

                    <?php foreach ($notificaciones as $item) { ?>
                        
                        <a href="#" class="kt-notification__item notificacion" 
                            data-link="<?php echo $item['link'] ?>"
                            data-id="<?php echo $item['id'] ?>">
                            <div class="kt-notification__item-details">
                                <div class="kt-notification__item-title">
                                    <?php echo $item['titulo'] ?>
                                </div>
                                <div class="kt-notification__item-time">
                                    <?php echo GestorNotificacionesController::ago($item['fecha']) ?>
                                    <span class="spinn_n_<?php echo $item['id'] ?>"></span>
                                </div>
                            </div>
                        </a>
                    
                    <?php } ?>

                    <?php if (count($notificaciones) == 0) { ?>
                        <div class="kt-grid kt-grid--ver" style="min-height: 200px;">
                            <div class="kt-grid kt-grid--hor kt-grid__item kt-grid__item--fluid kt-grid__item--middle">
                                <div class="kt-grid__item kt-grid__item--middle kt-align-center">
                                    
                                    <br>No hay notificaciones.
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                
                    
                </div>
            </div>
            <div class="tab-pane active show sinRevisar" id="topbar_notifications_events_2" role="tabpanel">
                <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true" data-height="400" data-mobile-height="400">
                    <?php foreach ($notificaciones_sin_ver as $item) { ?>
                        
                        <a href="#" class="kt-notification__item notificacion" 
                            data-link="<?php echo $item['link'] ?>"
                            data-id="<?php echo $item['id'] ?>">
                            <div class="kt-notification__item-details">
                                <div class="kt-notification__item-title">
                                    <?php echo $item['titulo'] ?>
                                </div>
                                <div class="kt-notification__item-time">
                                    <?php echo GestorNotificacionesController::ago($item['fecha']) ?>

                                    <span class="spinn_n_<?php echo $item['id'] ?>"></span>
                                </div>
                            </div>
                        </a>

                    <?php } ?>

                    <?php if (count($notificaciones_sin_ver) == 0) { ?>
                        <div class="kt-grid kt-grid--ver" style="min-height: 200px;">
                            <div class="kt-grid kt-grid--hor kt-grid__item kt-grid__item--fluid kt-grid__item--middle">
                                <div class="kt-grid__item kt-grid__item--middle kt-align-center">
                                    
                                    <br>No hay notificaciones sin revisar.
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </form>
</div>
