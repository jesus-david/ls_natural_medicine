<?php 

    if(!isset($_SESSION["usuario_validado"])){
        echo "<script> window.location.href = 'login' </script>";
        exit();
    }

    $q = isset($_SESSION["filtrarOrders"]) ? $_SESSION["filtrarOrders"] : "";
?>

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    Pedidos 
                </h3>

                <span class="kt-subheader__separator kt-subheader__separator--v"
                ></span>

                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total">
                        0 Total
                    </span>

                    <form class="kt-margin-l-20" id="kt_subheader_search_form">
                        <div
                            class="kt-input-icon kt-input-icon--right kt-subheader__search">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Search..."
                                id="generalSearch"
                                value="<?php echo $q?>"
                            />
                            <span
                                class="kt-input-icon__icon kt-input-icon__icon--right">
                                <span class="cursor" id="filtrarOrders" data-toggle="kt-tooltip" title="Buscar" data-placement="top">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px"
                                        height="24px"
                                        viewBox="0 0 24 24"
                                        version="1.1"
                                        class="kt-svg-icon">
                                        <g
                                            stroke="none"
                                            stroke-width="1"
                                            fill="none"
                                            fill-rule="evenodd">
                                            <rect
                                                x="0"
                                                y="0"
                                                width="24"
                                                height="24"
                                            />
                                            <path
                                                d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                                fill="#000000"
                                                fill-rule="nonzero"
                                                opacity="0.3"
                                            />
                                            <path
                                                d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                                fill="#000000"
                                                fill-rule="nonzero"
                                            />
                                        </g>
                                    </svg>
                                    <!--<i class="flaticon2-search-1"></i>-->
                                </span>
                            </span>
                            <?php if ($q != "") { ?>
                                <span class="kt-input-icon__icon kt-input-icon__icon--right mright removeFilterOrders cursor" data-toggle="kt-tooltip" title="Quitar filtro" data-placement="top">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect id="bound" x="0" y="0" width="24" height="24" />
                                            <circle id="Oval-5" fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                                            <path d="M12.0355339,10.6213203 L14.863961,7.79289322 C15.2544853,7.40236893 15.8876503,7.40236893 16.2781746,7.79289322 C16.6686989,8.18341751 16.6686989,8.81658249 16.2781746,9.20710678 L13.4497475,12.0355339 L16.2781746,14.863961 C16.6686989,15.2544853 16.6686989,15.8876503 16.2781746,16.2781746 C15.8876503,16.6686989 15.2544853,16.6686989 14.863961,16.2781746 L12.0355339,13.4497475 L9.20710678,16.2781746 C8.81658249,16.6686989 8.18341751,16.6686989 7.79289322,16.2781746 C7.40236893,15.8876503 7.40236893,15.2544853 7.79289322,14.863961 L10.6213203,12.0355339 L7.79289322,9.20710678 C7.40236893,8.81658249 7.40236893,8.18341751 7.79289322,7.79289322 C8.18341751,7.40236893 8.81658249,7.40236893 9.20710678,7.79289322 L12.0355339,10.6213203 Z" id="Combined-Shape" fill="#000000" />
                                        </g>
                                    </svg>
                                </span>
                            <?php } ?>
                        </div>
                    </form>
                </div>

                <div
                    class="kt-subheader__group kt-hidden"
                    id="kt_subheader_group_actions">
                    <div class="kt-subheader__desc">
                        
                        Seleccionado/s:
                        <span id="kt_subheader_group_selected_rows"></span>
                    </div>

                    <div class="btn-toolbar kt-margin-l-20">

                        <?php if (GestorConfigController::verficar_usuario("updateStateOrder", false) || $_SESSION["tipo"] == "0") { ?>
                            <div
                                class="dropdown"
                                id="kt_subheader_group_actions_status_change">
                                <button
                                    type="button"
                                    class="btn btn-label-brand btn-bold btn-sm dropdown-toggle"
                                    data-toggle="dropdown">
                                    Actualizar estado
                                </button>
                                <div class="dropdown-menu">
                                    <ul class="kt-nav">
                                        <li
                                            class="kt-nav__section kt-nav__section--first">
                                            <span class="kt-nav__section-text"
                                                >Cambiar estado a:</span>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a
                                                href="#"
                                                class="kt-nav__link"
                                                data-toggle="status-change"
                                                data-status="1">
                                                <span class="kt-nav__link-text" data-change="1" data-text="Procesado">
                                                    <span
                                                        class="kt-badge kt-badge--unified-success kt-badge--inline kt-badge--bold">
                                                        Procesado
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a
                                                href="#"
                                                class="kt-nav__link"
                                                data-toggle="status-change"
                                                data-status="2">
                                                <span class="kt-nav__link-text" data-change="2" data-text="Rechazado">
                                                    <span class="kt-badge kt-badge--unified-danger kt-badge--inline kt-badge--bold">
                                                        Rechazado
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a
                                                href="#"
                                                class="kt-nav__link"
                                                data-toggle="status-change"
                                                data-status="2">
                                                <span class="kt-nav__link-text" data-change="0" data-text="En espera">
                                                    <span class="kt-badge kt-badge--unified-warning kt-badge--inline kt-badge--bold">
                                                        En espera
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                       
                        <button
                            class="btn btn-label-danger btn-bold btn-sm btn-icon-h"
                            id="kt_subheader_group_actions_delete_all">
                            Borrar todo
                        </button>
                
                    </div>
                </div>
            </div>
            <div class="kt-subheader__toolbar">            
          
                
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->


    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__body kt-portlet__body--fit">

                <div class="alert alert-primary m-2 d-inline">
                    No se pueden editar pedidos procesados
                </div>            
                            
                <!--begin: Datatable -->
                <div class="kt-datatable" id="kt_apps_orders_list_datatable">
                </div>
                <!--end: Datatable -->
            </div>
        </div>
        <!--end::Portlet-->

         <!-- Modal -->
        <div class="modal fade" id="modalStateOrder" tabindex="-1" role="dialog" aria-labelledby="modalStateOrderLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalStateOrderLabel">Procesar pedido</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body body-editar-zona">
                        <div class="form-group">
                            <input type="text" id="factura" class="form-control" placeholder="Número de factura">
                            <input type="hidden" id="idOrder">
                            <span class="form-text text-muted">Por favor agrega el número de la factura</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="procesarPedido">Procesar</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- end:: Content -->

    <a href="exportOrder" styl="display:none" class="aHidden"></a>

</div>




