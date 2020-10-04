<?php 

    if(!isset($_SESSION["usuario_validado"])){
        
        // var_dump($_SESSION);
        echo "<script> window.location.href = 'login' </script>";
    
        exit();
    }

    if ($_SESSION["tipo"] != 0) {
        GestorConfigController::verficar_usuario("listUsers");
    } 

    $q = isset($_SESSION["filtroUsers"]) ? $_SESSION["filtroUsers"] : "";

?>

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    Usuarios
                </h3>

                <span class="kt-subheader__separator kt-subheader__separator--v"
                ></span>

                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total">
                        450 Total
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
                                <span class="cursor" id="filtrarUsers" data-toggle="kt-tooltip" title="Buscar" data-placement="top">
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
                                <span class="kt-input-icon__icon kt-input-icon__icon--right mright removeFilter cursor" data-toggle="kt-tooltip" title="Quitar filtro" data-placement="top">
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
                        <div
                            class="dropdown"
                            id="kt_subheader_group_actions_status_change">
                            <button
                                type="button"
                                class="btn btn-label-brand btn-bold btn-sm dropdown-toggle"
                                data-toggle="dropdown"
                            >
                                Actualizar estado / tipo
                            </button>
                            <div class="dropdown-menu">
                                <ul class="kt-nav">
                                    <li
                                        class="kt-nav__section kt-nav__section--first"
                                    >
                                        <span class="kt-nav__section-text"
                                            >Cambiar estado a:</span>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a
                                            href="#"
                                            class="kt-nav__link"
                                            data-toggle="status-change"
                                            data-status="1">
                                            <span class="kt-nav__link-text" data-change="1" data-text="Activo">
                                                <span
                                                    class="kt-badge kt-badge--unified-success kt-badge--inline kt-badge--bold"
                                                    >Activo
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
                                            <span class="kt-nav__link-text" data-change="0" data-text="Bloqueado">
                                                <span class="kt-badge kt-badge--unified-danger kt-badge--inline kt-badge--bold">
                                                    Bloqueado
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <div class="divider"></div>
                                    <li class="kt-nav__section kt-nav__section--first">
                                        <span class="kt-nav__section-text"
                                            >Cambiar tipo a:</span>
                                    </li>
                                    
                                    <li class="kt-nav__item">
                                        <a
                                            href="#"
                                            class="kt-nav__link"
                                            data-toggle="status-change"
                                            data-status="3">
                                            <span class="kt-nav__link-text" data-change="0" data-inputT="tipo" data-text="Master">
                                                <span
                                                    class="kt-badge kt-badge--unified-primary kt-badge--inline kt-badge--bold">
                                                    Master
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a
                                            href="#"
                                            class="kt-nav__link"
                                            data-toggle="status-change"
                                            data-status="4">
                                            <span class="kt-nav__link-text" data-change="1" data-inputT="tipo" data-text="Administrador">
                                                <span class="kt-badge kt-badge--unified-success kt-badge--inline kt-badge--bold">
                                                    Usuario
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- <button
                            class="btn btn-label-success btn-bold btn-sm btn-icon-h"
                            id="kt_subheader_group_actions_fetch"
                            data-toggle="modal"
                            data-target="#kt_datatable_records_fetch_modal"
                        >
                            Fetch Selected
                        </button> -->
                        <button
                            class="btn btn-label-danger btn-bold btn-sm btn-icon-h"
                            id="kt_subheader_group_actions_delete_all"
                        >
                            Borrar todo
                        </button>
                    </div>
                </div>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="/metronic/preview/demo1/.html" class=""> </a>

                <a href="addUser" class="btn btn-label-brand btn-bold">
                    Nuevo usuario
                </a>

                <div class="kt-subheader__wrapper">
                    <div
                        class="dropdown dropdown-inline"
                        data-toggle="kt-tooltip-"
                        title="Quick actions"
                        data-placement="left">
                        <a
                            href="#"
                            class="btn btn-icon"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px"
                                height="24px"
                                viewBox="0 0 24 24"
                                version="1.1"
                                class="kt-svg-icon kt-svg-icon--success kt-svg-icon--md">
                                <g
                                    stroke="none"
                                    stroke-width="1"
                                    fill="none"
                                    fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24" />
                                    <path
                                        d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z"
                                        fill="#000000"
                                        fill-rule="nonzero"
                                        opacity="0.3"
                                    />
                                    <path
                                        d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z"
                                        fill="#000000"
                                    />
                                </g>
                            </svg>
                            <!--<i class="flaticon2-plus"></i>-->
                        </a>
                        <div
                            class="dropdown-menu dropdown-menu-fit dropdown-menu-md dropdown-menu-right">
                        </div>
                    </div>
                </div>
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
            <div class="kt-portlet__body kt-portlet__body--fit">
                <!--begin: Datatable -->
                <div class="kt-datatable" id="kt_apps_user_list_datatable">
                </div>
                <!--end: Datatable -->
            </div>
        </div>
        <!--end::Portlet-->

        <!--begin::Modal-->
        <div
            class="modal fade"
            id="kt_datatable_records_fetch_modal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Selected Records
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
                            data-height="200"
                        >
                            <ul id="kt_apps_user_fetch_records_selected"></ul>
                        </div>
                    </div>
                    <div class="modal-footer">
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
    </div>
    <!-- end:: Content -->
</div>
