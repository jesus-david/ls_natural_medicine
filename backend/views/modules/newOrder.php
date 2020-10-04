<?php 
    if(!isset($_SESSION["usuario_validado"])){
    
        echo "<script> window.location.href = 'login' </script>";
    
        exit();
    }
  
    $mis_clientes = GestorUsuariosController::mis_clientes();
    

    $cestaString = json_encode($_SESSION["cesta"]);


    echo "<input type='hidden' id='cestaString' value='$cestaString' />"

?>

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    <a href="orders" class="mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24" />
                                <path d="M21.4451171,17.7910156 C21.4451171,16.9707031 21.6208984,13.7333984 19.0671874,11.1650391 C17.3484374,9.43652344 14.7761718,9.13671875 11.6999999,9 L11.6999999,4.69307548 C11.6999999,4.27886191 11.3642135,3.94307548 10.9499999,3.94307548 C10.7636897,3.94307548 10.584049,4.01242035 10.4460626,4.13760526 L3.30599678,10.6152626 C2.99921905,10.8935795 2.976147,11.3678924 3.2544639,11.6746702 C3.26907199,11.6907721 3.28437331,11.7062312 3.30032452,11.7210037 L10.4403903,18.333467 C10.7442966,18.6149166 11.2188212,18.596712 11.5002708,18.2928057 C11.628669,18.1541628 11.6999999,17.9721616 11.6999999,17.7831961 L11.6999999,13.5 C13.6531249,13.5537109 15.0443703,13.6779456 16.3083984,14.0800781 C18.1284272,14.6590944 19.5349747,16.3018455 20.5280411,19.0083314 L20.5280247,19.0083374 C20.6363903,19.3036749 20.9175496,19.5 21.2321404,19.5 L21.4499999,19.5 C21.4499999,19.0068359 21.4451171,18.2255859 21.4451171,17.7910156 Z" id="Shape" fill="#000000" fill-rule="nonzero" />
                            </g>
                        </svg>
                    </a>
                    Nuevo Pedido
                </h3>

                <span class="kt-subheader__separator kt-subheader__separator--v"
                ></span>
    
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
                <!--begin::Form-->
                <form class="kt-form" id="formNuevaCartera">
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input list="codes" class="custom-select searchCode" placeholder="Buscar producto por código o nombre">
                                    <datalist id="codes"></datalist>
                                    <span class="form-text text-muted">Por favor agrega los productos del pedido</span>
                                </div>

                                <div class="form-group col-md-6">
                                    <select name="tCliente" id="tCliente" class="form-control">
                                        <option value="0">cliente</option>
                                        <?php foreach ($mis_clientes as $item) { ?>
                                            <option value="<?php echo $item["id"] ?>"><?php echo $item["nombre"] ?></option>
                                        <?php } ?>
                                        
                                    </select>
                                    <span class="form-text text-muted">Por favor selecciona el cliente</span>
                                </div>
                            </div>
                            
                            <div class="form-group">

                                <table class="p-2 table table-borderless table-striped table-light--success">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="border-bottom-0">Nombre</th>
                                            <th scope="col" class="border-bottom-0">Precio</th>
                                            <th scope="col" class="border-bottom-0">Cantidad</th>
                                            <th scope="col" class="border-bottom-0">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyTablaPedidos">

                                    </tbody>
                                    <tfoot>
                                        <th scope="col" ></th>
                                        <th scope="col" ></th>
                                        <th scope="col" ></th>
                                        <th scope="col" id="totalPedido"></th>
                                    </tfoot>
                                </table>
                            
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <button class="btn btn-primary" id="crearPedido">CREAR</button>
                            <button class="btn btn-danger" id="vaciarPedido">VACIAR PEDIDO</button>
                            <span class="px-2 mensajeRespuesta"></span>
                        </div>
                    </div>
                </form>

                <!--end::Form-->
            </div>
        </div>
        <!--end::Portlet-->

        
    </div>
    <!-- end:: Content -->
</div>


 <!-- Modal -->
 <div class="modal fade" id="modalSetStock" tabindex="-1" role="dialog" aria-labelledby="modalSetStockLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSetStockLabel">Cantidad del producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body body-details">
                <div class="row">
                    <div class="col-md-6 mt-1">
                        <input type="text" id="pStock" class="form-control" placeholder="Nueva petición de stock">
                    </div>
                    <div class="col-md-6 mt-1">
                        <button  class="btn btn-label-brand btn-bold" id="realizarPeticionStock">
                            Realizar
                        </button>
                    </div>
                </div>
                
                <div class="divider"></div>

                <div class="body__">

                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>