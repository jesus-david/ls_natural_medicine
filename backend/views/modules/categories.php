<?php 

    if(!isset($_SESSION["usuario_validado"])){
        echo "<script> window.location.href = 'login' </script>";
    
        exit();
    }

?>

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    Categorías
                </h3>

                <span class="kt-subheader__separator kt-subheader__separator--v"
                ></span>

                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total">
                        0 Total
                    </span>

                </div>

                <div
                    class="kt-subheader__group kt-hidden"
                    id="kt_subheader_group_actions">
                    <div class="kt-subheader__desc">
                        
                        Seleccionado/s:
                        <span id="kt_subheader_group_selected_rows"></span>
                    </div>

                    <div class="btn-toolbar kt-margin-l-20">
                       
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
               
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->


    <!-- begin:: Content -->
    <div
        class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__body kt-portlet__body--fit">
                <!--begin: Datatable -->
                <div class="row">
                    <div class="col-md-7">
                        <div class="kt-datatable" id="kt_apps_companys_list_datatable">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="p-3">
                            <h4 class="text-center">Agregar Categoria</h4>
                            <div class="form-group">
                                <input type="text" id="nombreCategoria" class="form-control" placeholder="nombre">
                            
                                <span class="form-text text-muted">Por favor agrega el nombre de la categoria</span>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-wide" id="crearCategoria" style="width:100%;">AGREGAR</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <!--end: Datatable -->
            </div>
        </div>
        <!--end::Portlet-->

    </div>
    <!-- end:: Content -->
</div>


 <!-- Modal -->
 <div class="modal fade" id="modalEditCategoria" tabindex="-1" role="dialog" aria-labelledby="modalEditCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditCategoriaLabel">Editar Categoría</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body body-editar-zona">
                <form id="editCategoria">
                    <div class="form-group">
                        <input type="text" id="nombreCategoriaEditar" class="form-control" placeholder="nombre">
                        <input type="hidden" id="idCategoria">
                        <span class="form-text text-muted">Por favor agrega el nombre de la empresa</span>
                    </div>
                  
                </form>
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="actualizarCategoria">ACTUALIZAR</button>
            </div>
        </div>
    </div>
</div>